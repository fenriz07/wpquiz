<?php

/**
 *
 */
class levelPlacementShortcode
{

  function __construct()
  {
    $this->test = 'test-category';
    add_shortcode($this->test,[$this,'getTestCategory']);
  }

  //[test-category idcat="1"]
  public static function getTestCategory($atts)
  {
    wp_enqueue_script('level-placement-js');
    wp_enqueue_style('level-placement-css');

    $atts = shortcode_atts( array(
  		'idcat' => 1,
  	), $atts, $this->test );

    $idcat = $atts['idcat'];

    echo file_get_contents(LEVEL_PLACEMENT_DIR .'partials/wizard.html');
  }
}

new levelPlacementShortcode();
