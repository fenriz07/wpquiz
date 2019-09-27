<?php namespace App\Repository\Api;

use App\Traits\Queue;
use App\Models\CoursesModel;
use App\Repository\Api\LevelRepository;

/**
 *  Repositorio de codigo, se encarga de procesar las respuestas del test.
 *  Procesa el test, calcula y guarda los resultados.
 * 
 *  Para entender el flujo del algoritmo,revisar el motodo store.
 * 
 *  @var int   $points puntaje del visitante.
 *  @var array $testBd Contiene un arreglo con todo el test que esta guardado en el sitio web.
 *  @var array $answers
 *  @author Servio Zambrano
 *  @version 1.0
 */

class TestRepository
{

    /**
     * Trait Queue para procesar asincronamente. 
     */
    use Queue; 

    private $points;    
    private $testBd;
    private $answers;

    public function __construct()
    {
      $this->initWorkers();
    }

    /**
     * @todo : Registrar el examen como un customposttype nuevo que no esta registrado.
     */
  
    public function store($data)
    {
      $idCategory    =  $data['id_category'];
      $this->answers =  $data['test'];

      $this->getEvaluationRules($idCategory);

      //Consultamos el repositorio Level para traer el test que el usuario ha realizado.
      $this->testBd = LevelRepository::show($idCategory,false)['levels'];

      /*En la propiedad answers tenemos las respuestas enviadas por el usuario, con el siguente metodo normalizamos 
      toda la información para ser procesada por el metodo de calculo*/
      $this->normalizeTest();

      //Calculamos el test para setear el puntaje:
      $this->caclTest();


      $info = [
        'test'     =>  $this->testBd,
        'point'    =>  $this->points,
        'nameTest' =>  $data['name-test'],
        'email'    =>  $data['personal']['email'],
      ];

      $this->queueResult->push_to_queue( $info);
      $this->queueResult->save()->dispatch();

      //Procesamos el puntaje con los rangos de resultado
      $response = $this->evaluateRangeRules( $idCategory );

      return $response;
  
    }

    /**
     * @return int points = Indica el puntaje obtenido por el visitante
     */
  
    private function caclTest()
    {

      $points = 0;
      $questionList  = null;
      $statusAnswers = null;

      foreach ($this->answers as $idPost => $answers)
      {
        foreach ($this->testBd as $key => $question)
        {
          if($question['id'] == $idPost)
          {

            //Definimos la lista de preguntas y respuesta de la BD en $questionList
            if( $question['lvl']['type'] == 'parrafos' )
            {
              $questionList = $question['lvl']['questions']['group'];
            }else{
              $questionList = $question['lvl']['questions'];
            }

            foreach ($answers as $x => $answer)
            {
              $answerEvaluate   = sanitize_title( $answer );
              $answerEvaluateBd = sanitize_title( $questionList[$x]['test-post-answers'][0] );

              //Si la primera respuesta de la pregunta es igual a lo que respondio el usuario entonces le sumamos un punto
              if( strcmp($answerEvaluate,$answerEvaluateBd) == 0 )
              {
                $this->points++;
                $statusAnswers = true;
              }else{
                $statusAnswers =  false;
              }

              //Independientemente si respondio bien o no, marcamos su respuesta y si fue bien o mal respondida.
              if( $question['lvl']['type'] == 'parrafos' )
              {
                $this->testBd[$key]['lvl']['questions']['group'][$x]['user']['status'] = $statusAnswers;
                $this->testBd[$key]['lvl']['questions']['group'][$x]['user']['answer'] = $answerEvaluate;
              }else{
                $this->testBd[$key]['lvl']['questions'][$x]['user']['status'] = $statusAnswers;
                $this->testBd[$key]['lvl']['questions'][$x]['user']['answer'] = $answer;
              }            
            }

          }
        }
      }
  
    }
  
    private function notifyTest($data)
    {
      $templates = (object) [
        'search_email'  => ['{fullname}','{email}','{name-test}','{phone}', '{name-level}','{result}','{n-approved-answers}','{approved}'],
        'email'         => file_get_contents(LEVEL_PLACEMENT_DIR .'partials/email.html'),
        'search_result' => ['{id}','{question}','{answer}','{approved}'],
        'single_result' => file_get_contents(LEVEL_PLACEMENT_DIR .'partials/single-result.html'),
      ];
  
      $html_results = '';
      $email_html   = '';
  
      foreach ($data['statistics']['results'] as $key => $result) {
        $tmp = [$key,$result['title'],$result['value'],$result['approved']];
        $html_results .= str_replace($templates->search_result,$tmp,$templates->single_result);
      }
  
      $data_email = $data['personal'];
      $data_email['result']             = $html_results;
      $data_email['n-approved-answers'] = $data['statistics']['n-approved-answers'];
      $data_email['approved']           = $data['statistics']['approved'];
  
      $email_html = str_replace($templates->search_email,$data_email,$templates->email);
  
  
      $headers   = [ 'Content-Type: text/html; charset=UTF-8' ];
      $subject   = 'Test Information';
      $to_owner  = get_option('admin_email');
      wp_mail($to_owner, $subject, $email_html, $headers);
    }

    /**
     * El metodo se encarga de normalizar las respuestas del usuario a un formato de arreglo que se pueda procesar 
     * de forma mas amigable.
     */
    private function normalizeTest()
    {

      $answers = [];

      foreach ($this->answers as $key => $answer) 
      {        
        $answerExplode = explode('-',$answer['name']);

        $idPost = $answerExplode[0];
        $key    = $answerExplode[1];

        $answers[ $idPost ][ $key ] = $answer['value'];
      }
      
      $this->answers = $answers;
    }

    private function getEvaluationRules($id)
    {
      $ranges = rwmb_meta( PREFIX_META_BOX_CATEGORYTEST . 'range-evaluations-test', ['object_type' => 'term' ], $id);

      foreach ($ranges as $key => $range)
      {
        
        $ranges[$key]['range']['finish'] = (int) $range['categorytest-taxonomy-point'];
        if($key == 0)
        {
          $ranges[$key]['range']['start'] = 0;
        }else{
          $ranges[$key]['range']['start'] = ( (int) $ranges[$key - 1]['categorytest-taxonomy-point'] ) + 1;
        }
      }

      return $ranges;      

    }

    private function evaluateRangeRules($id)
    {
      $ranges = $this->getEvaluationRules($id);
      $range  =  null;

      foreach ($ranges as $key => $r) 
      {

        if( in_array( $this->points, range( $r['range']['start'], $r['range']['finish'] ) ) )
        {
            $range = $r;
        }

      }

      return $this->preparedResponse( $range );

    }

    private function preparedResponse( $range )
    {

      $payload = [
        'message' => $range['categorytest-taxonomy-description'],
        'courses' => [],
      ];

      $coursesId = $range['categorytest-taxonomy-courses-relations'];

      if( !empty($coursesId) )
      {
        $courses = (new CoursesModel() )->where()->postIn($coursesId)->query()->get();
        $payload['courses'] = $courses;
      }

      return $payload;

    }
}