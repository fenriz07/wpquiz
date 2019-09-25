<?php namespace App\Helpers;

class View
{
    private static $partial = null;
    private static $vars = null;
    private static $HTML;
    
    public static function make($name, $data)
    {
        $path = LEVEL_PLACEMENT_DIR ."resources/views/{$name}.htm";

        if (file_exists($path)) {
            self::$partial = $path;
        } else {
            wp_die(__("Partial ".$path." not found"));
        }

        self::$vars['data'] = $data;

        //extract(self::$vars, EXTR_SKIP);
       
        return self::getHTML();
    }

    private static function getHTML()
    {
      $html = file_get_contents(self::$partial);

      if( empty(self::$vars['data']) )
      {
          return $html;
      }
      
      $keys   = array_keys(   self::$vars['data'] );
      $values = array_values( self::$vars['data'] );

      return str_replace($keys,$values,$html);
      
    }


}