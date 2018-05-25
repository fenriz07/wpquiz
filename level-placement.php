<?php

  /*
  Plugin Name: WP Level Placement Plugin
  Plugin URI: http://speaktosucceed.es/
  Description: Create simple tests for your students in multiple languages, with multiple answers answers to the test
  Version: 0.1
  Author: Cmantikweb
  Author URI: https://cmantikweb.com/
  */

  /**
   * Copyright (c) `date "+%Y"` . All rights reserved.
   *
   * Released under the GPL license
   * http://www.opensource.org/licenses/gpl-license.php
   *
   * This is an add-on for WordPress
   * http://wordpress.org/
   *
   * **********************************************************************
   * This program is free software; you can redistribute it and/or modify
   * it under the terms of the GNU General Public License as published by
   * the Free Software Foundation; either version 2 of the License, or
   * (at your option) any later version.
   *
   * This program is distributed in the hope that it will be useful,
   * but WITHOUT ANY WARRANTY; without even the implied warranty of
   * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
   * GNU General Public License for more details.
   * **********************************************************************
   */


   define('LEVEL_PLACEMENT_DIR', trailingslashit(plugin_dir_path(__FILE__)));
   define('LEVEL_PLACEMENT_URI', trailingslashit(plugin_dir_url(__FILE__)));
   define('LEVEL_PLACEMENT_DOMAIN_TEXT', 'level-placement');

   require_once LEVEL_PLACEMENT_DIR . 'inc/level-placement-core-class.php';



 ?>
