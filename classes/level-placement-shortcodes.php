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
    $atts = shortcode_atts( array(
  		'idcat' => 1,
  	), $atts, $this->test );

    $idcat = $atts['idcat'];
    echo $idcat;
  }
}

new levelPlacementShortcode();
