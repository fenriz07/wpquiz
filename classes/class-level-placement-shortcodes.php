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
    //
    // $tests = TestModel::select()
    //                     ->setCategory(23)
    //                     ->base()
    //                     ->addMeta()
    //                     ->get();
    // echo '<pre>';
    //   var_dump($tests);
    // echo '</pre>';

  ?>

    <form method="POST" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
      <input type="text" name="id_category" value="23">
      <button type="submit">Send Data</button>
      <input type="hidden" name="action" value="process_question">
    </form>

  <?php
  }
}

new levelPlacementShortcode();
