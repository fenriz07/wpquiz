<?php


/**
 *
 */
class ProcessQuestion
{

  function __construct()
  {

    add_action('wp_ajax_get_team', [$this, 'processingPost']);
    add_action('wp_ajax_nopriv_get_team', [$this, 'processingPost']);
  }

  public function processingPost()
  {
    //Get personal data...
    $id_category        = $_GET['id_category'];
    $questions_answers  = $_GET['questions_answers'];
    //$list = List {id:"respuesta"}

    //Seteamos las variables para las estadisticas
    $n_questions = count($questions_answers);
    $n_approved_answers = 0;
    $wrong_answers = 0;


    //Consultamos el modelo para traer las preguntas, respuesta y comparar el resultado
    $tests = TestModel::select()
                          ->setCategory($id_category)
                          ->base()
                          ->addMeta()
                          ->get();
  }
}

new ProcessQuestion();
