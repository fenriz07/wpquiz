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


    $atts = shortcode_atts([
      'idcat' => 1,
    ],$atts);

    $idcat = $atts['idcat'];

    $html_results_ins =  rwmb_meta( PREFIX_META_BOX_CATEGORYTEST . 'instruction', ['object_type' => 'term' ], $idcat);
    $duration         =  rwmb_meta( PREFIX_META_BOX_CATEGORYTEST . 'duration',    ['object_type' => 'term' ], $idcat);

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

    wp_localize_script('level-placement-js', 'quiz', ['duration' => $duration]);
    wp_enqueue_script('level-placement-js');

    $site_url = get_site_url();

    $wizard  =  file_get_contents(LEVEL_PLACEMENT_DIR .'partials/wizard.html');

    $html_results = str_replace(['{siteurl}','{instructions}'],[$site_url,$html_results_ins],$wizard);

    return $html_results;
  }
}

new levelPlacementShortcode();
