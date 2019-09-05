<?php namespace App\Repository\Api;

use App\Models\TestModel;

class TestRepository
{
    private $limit_approved_answers = 45;

    public function __construct()
    {
    }
  
    public function store($data)
    {
      $id_category =  $data['id_category'];
  
      //Consultamos el modelo para traer las preguntas, respuesta y comparar el resultado
      $tests = TestModel::select()
                            ->setCategory($id_category )
                            ->base()
                            ->addAnswer()
                            ->get();
  
      //Calculamos:
      $result = $this->caclTest($tests,$data['test']);
  
      $data_email = ['personal' => [
                                      'fullname'   => $data['personal']['lastname'],
                                      'email'      => $data['personal']['email'],
                                      'name-test'  => $data['name-test'],
                                      'phone'      => $data['personal']['phone'],
                                      'name-level' => $data['name-level'],
                                   ],
                      'statistics'     => $result,
                    ];
      //Enviamos correo:
      $this->notifyTest($data_email);
  
      //Redireccionamos o Retornamos un codigo de Ok a la restapi.
  
      //Retornar el porcentaje de la clasificacion de respuestas correctas
      // echo json_encode(['result' => 'Ok']);
      // wp_die();
  
    }
  
    private function caclTest($tests,$questions_answers = null)
    {
  
      $n_approved_answers = 0;
  
      foreach ($questions_answers as $key => $answer) {
        $id   = (int) $answer['name'];
        $slug = $answer['value'];
  
  
        $key_test = array_search($id, array_column($tests, 'id'));
  
        $slug_test = $tests[$key_test]['answer']['slug'];
  
        if (strcmp ($slug , $slug_test ) == 0) {
          $n_approved_answers += 1;
          $questions_answers[$key]['approved'] = 'Yes';
        }else {
          $questions_answers[$key]['approved'] = 'Not';
        }
  
        $questions_answers[$key]['title'] =  $tests[$key_test]['title'];
  
      }
  
  
      $approved = ($n_approved_answers >= $this->limit_approved_answers) ? 'Yes' : 'Not';
  
      return ['results' => $questions_answers, 'n-approved-answers' => $n_approved_answers,'approved' => $approved ];
  
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
}