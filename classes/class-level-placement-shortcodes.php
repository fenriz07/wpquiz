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
    wp_enqueue_script( 'wp-api' );
    wp_enqueue_script('level-placement-js');
    wp_enqueue_style('level-placement-css');


    $atts = shortcode_atts([
      'idcat' => 1,
    ],$atts);

    $idcat = $atts['idcat'];

    /*ABDIANGEL: Puedes comentar esto, es solo para probar si el atributo esta siendo traido con exito.
    Para que entiendas la variable idcat es el id de la categoria, esta te la voy a renderizar en el front-end
    para que tu la agarres con Js y consules el rest-api
    */

    $site_url = get_site_url();

    $wizard  =  file_get_contents(LEVEL_PLACEMENT_DIR .'partials/wizard.html');

    $html_results = str_replace('{siteurl}',$site_url,$wizard);

    echo $html_results;
  }
}

new levelPlacementShortcode();
