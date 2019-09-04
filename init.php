<?php

  /*
    Plugin Name: WP Level Placement Plugin
  */

  $dir = trailingslashit( plugin_dir_path( __FILE__ ) );
  $uri = trailingslashit( plugin_dir_url(__FILE__) );


  require_once $dir  . 'vendor/autoload.php';
  
  define('LEVEL_PLACEMENT_DIR', $dir  );
  define('LEVEL_PLACEMENT_URI', $uri  );

  Bootstrap\App::fire();


  function mailtrap($phpmailer) {
    $phpmailer->isSMTP();
    $phpmailer->Host = 'smtp.mailtrap.io';
    $phpmailer->SMTPAuth = true;
    $phpmailer->Port = 2525;
    $phpmailer->Username = 'b8af9d80d7eaae';
    $phpmailer->Password = 'c10705164d06d7';
  }
  
  add_action('phpmailer_init', 'mailtrap');

  error_reporting(-1);
  ini_set('display_errors', 'On');

 ?>
