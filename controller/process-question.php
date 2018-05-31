<?php


/**
 *
 */
class ProcessQuestion
{

  function __construct()
  {

    add_action('admin_post_process_question', [$this, 'processingPost']);
    // add_action('wp_ajax_get_team', [$this, 'processingPost']);
    // add_action('wp_ajax_nopriv_get_team', [$this, 'processingPost']);
  }

  public function processingPost()
  {
    //Get personal data...
    $id_category        = $_POST['id_category'];

    //$questions_answers  = $_GET['questions_answers'];
    //$list = List {id:"respuesta"}

    //Seteamos las variables para las estadisticas
    $n_questions = count($questions_answers);



    //Consultamos el modelo para traer las preguntas, respuesta y comparar el resultado
    $tests = TestModel::select()
                          ->setCategory($id_category)
                          ->base()
                          ->addAnswer()
                          ->get();

    //Calculamos:
    $result = $this->caclTest($tests);
    $data_email = ['personal' => [
                                    'fullname'  => 'Servio Zambrano',
                                    'email'     => 'servio.za@gmail.com',
                                    'name-test' => 'Nivel A1'
                                 ],
                    'statistics'     => $result,
                  ];
    //Enviamos correo:
    $this->notifyTest($data_email);

    //Retornar el porcentaje de la clasificacion de respuestas correctas
    // echo json_encode(['result' => 'Ok']);
    // wp_die();

  }

  private function caclTest($tests,$questions_answers = null){

    $n_approved_answers = 0;
    // TODO: Falta hacer el algoritmo de comprobacion de respuesta incorrecta o correcta
    foreach ($tests as $key => $value) {
      $n_approved_answers += 1;
      $tests[$key]['approved'] = 'Yes';
    }

    $approved = ($n_approved_answers >= 45) ? 'Yes' : 'Not';

    return ['results' => $tests, 'n-approved-answers' => $n_approved_answers,'approved' => $approved ];

  }

  private function notifyTest($data)
  {
    $templates = (object) [
      'search_email'  => ['{fullname}','{email}','{name-test}','{result}','{n-approved-answers}','{approved}'],
      'email'         => file_get_contents(LEVEL_PLACEMENT_DIR .'partials/email.html'),
      'search_result' => ['{id}','{question}','{answer}','{approved}'],
      'single_result' => file_get_contents(LEVEL_PLACEMENT_DIR .'partials/single-result.html'),
    ];

    $html_results = '';
    $email_html   = '';

    foreach ($data['statistics']['results'] as $key => $result) {
      $tmp = [$key,$result['title'],$result['answer']['text'],$result['approved']];
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

new ProcessQuestion();
