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
      require_once LEVEL_PLACEMENT_DIR  . "classes/class-rest-api.php";

  }

  private function initCss()
  {
    // wp_register_style( 'lightbox-jerseypedia', JERSEY_URI . 'assets/vendor/lightbox2/css/lightbox.min.css' );
  }
  private function initJs()
  {
    // wp_register_script('tiny_mce_jersey', JERSEY_URI .  'assets/vendor/tinymce/tinymce.min.js');
  }

  private function initPostType()
  {
      require_once LEVEL_PLACEMENT_DIR . "inc/post-type/test.php";
  }

  private function initLibs()
  {
      require LEVEL_PLACEMENT_DIR . "inc/libs/meta-box/meta-box.php";
  }

  private function model()
  {
      require_once LEVEL_PLACEMENT_DIR . "inc/model/test.php";
  }

  private function initController()
  {
      require_once LEVEL_PLACEMENT_DIR . "controller/process-question.php";
  }


}
