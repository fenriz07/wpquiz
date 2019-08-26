<?php

  /*
    Plugin Name: WP Level Placement Plugin
  */
  require_once trailingslashit( plugin_dir_path( __FILE__ ) )  . 'vendor/autoload.php';
  
  use Bootstrap\App;

  define('LEVEL_PLACEMENT_DIR', trailingslashit( plugin_dir_path( __FILE__ ) ) );
  define('LEVEL_PLACEMENT_URI', trailingslashit( plugin_dir_url(  __FILE__ )  )  );

  App::fire();

 ?>
