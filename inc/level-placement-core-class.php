<?php

/**
 *
 */
class LevelPlacementCore
{

  function __construct()
  {

    $this->initClass();
    $this->model();
    $this->initLibs();
    $this->initPostType();
    $this->initCss();
    $this->initJs();
    $this->initController();


  }

  private function initClass()
  {
      require_once LEVEL_PLACEMENT_DIR  . "classes/class-level-placement-shortcodes.php";
      //require_once LEVEL_PLACEMENT_DIR  . "classes/class-rest-api.php";

  }


  private function initController()
  {
      require_once LEVEL_PLACEMENT_DIR . "controller/process-question.php";
      require_once LEVEL_PLACEMENT_DIR . "controller/process-contact.php";
  }


}
