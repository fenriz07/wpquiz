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
    $n_approved_answers = 0;
    $wrong_answers = 0;


    //Consultamos el modelo para traer las preguntas, respuesta y comparar el resultado
    $tests = TestModel::select()
                          ->setCategory($id_category)
                          ->base()
                          ->addAnswer()
                          ->get();

    //Calculamos:
    $result = $this->caclTest($tests);

    //Enviamos correo:
    $this->notifyTest($result);

    //Retornar el porcentaje de la clasificacion de respuestas correctas
    // echo json_encode(['result' => 'Ok']);
    // wp_die();

  }

  private function caclTest($tests,$questions_answers = null){

    foreach ($tests as $key => $value) {
      $tests[$key]['approved'] = 'Yes';
    }

    return $tests;

  }

  private function notifyTest($data)
  {

    $email_html = file_get_contents(LEVEL_PLACEMENT_DIR .'partials/email.html');
    $headers   = [ 'Content-Type: text/html; charset=UTF-8' ];
    $subject   = 'Test Information';
    $to_owner  = get_option('admin_email');
    wp_mail($to_owner, $subject, $email_html, $headers);
  }

  private function setHtmlResult($result){
    $html_template = file_get_contents(LEVEL_PLACEMENT_DIR .'partials/single-result.html');
  }


}

new ProcessQuestion();
