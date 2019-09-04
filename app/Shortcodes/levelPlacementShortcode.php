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
    wp_enqueue_style('level-placement-css');

    $instructions = '';
    $html_instruction = file_get_contents(LEVEL_PLACEMENT_DIR .'partials/instruction.html');
    $html_results_ins = '';
    $icon_check       =  LEVEL_PLACEMENT_URI . '/assets/img/icon-check.svg';
    $atts = shortcode_atts([
      'idcat' => 1,
    ],$atts);

    $idcat = $atts['idcat'];

    $term = get_term( $idcat, 'category-test' );

    if($term->parent != 0){

      $html_results = file_get_contents(LEVEL_PLACEMENT_DIR .'partials/warning.html');

      return $html_results;
    }

    $site = [
      'endpoint' => get_site_url() . '/wp-json/levelplacement/v1/',
      'idcat'    => $idcat,
      'nametest' => $term->name,
      'contact'  => 'Contact',
      'action'   => 'process_question'
    ];

    wp_localize_script( 'model-test', 'site', $site );
    wp_enqueue_script('model-test');

    wp_localize_script( 'view-test', 'site', $site );
    wp_enqueue_script('view-test');

    wp_enqueue_script('level-placement-js');


    $site_url = get_site_url();

    $wizard  =  file_get_contents(LEVEL_PLACEMENT_DIR .'partials/wizard.html');

    $html_results = str_replace(['{siteurl}','{instructions}'],[$site_url,$html_results_ins],$wizard);

    return $html_results;
  }
}

new levelPlacementShortcode();
