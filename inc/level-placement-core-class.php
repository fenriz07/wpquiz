<?php

/**
 *
 */
class LevelPlacementCore
{

  function __construct()
  {

    $this->initClass();
    $this->initLibs();
    $this->initPostType();
    $this->initCss();
    $this->initJs();

  }

  private function initClass()
  {
      require_once LEVEL_PLACEMENT_DIR  . "classes/level-placement-shortcodes.php";

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


}
