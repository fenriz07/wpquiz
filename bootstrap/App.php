<?php namespace Bootstrap;

class App
{
    use Loader;

    private static $_instance     = null;
    private $versionAssets = 1;


    private function __construct()
    {
        $this->setConst();
        $this->loadDir('app/Helpers');
        $this->loadDir('app/PostTypes');
        $this->loadDir('app/Taxonomies');
        $this->loadDir('app/MetaBox');
        $this->loadFile('lib/meta-box/meta-box');
        $this->loadFile('lib/mb-term-meta/mb-term-meta');
        $this->loadFile('lib/meta-box-group/meta-box-group');
        $this->loadDir('routes');
        $this->loadDir('app/Shortcodes');

        add_action( 'wp_enqueue_scripts', [$this,'initCss'] );
        add_action( 'wp_enqueue_scripts', [$this,'initJs'] );
    }

    public static function fire()
    {
        
        if (self::$_instance === null) {
            self::$_instance = new self;
        }

        return self::$_instance;
    }

    public function __clone()
    {
        trigger_error('La clonación de este objeto no está permitida', E_USER_ERROR);
    }

    private function setConst()
    {
        define('LEVEL_PLACEMENT_DOMAIN_TEXT', 'level-placement');
        define('LEVEL_PLACEMENT_PREFIX_META_BOX', 'test-post-');
    }

    public function initCss()
    {
      wp_register_style( 'level-placement-admin-css', LEVEL_PLACEMENT_URI . 'assets/css/admin.css','',     $this->versionAssets );
      wp_register_style( 'level-placement-css', LEVEL_PLACEMENT_URI . 'assets/css/level-placement.css','',     $this->versionAssets );


    }

    public function initJs()
    {
      wp_register_script('level-placement-js',  LEVEL_PLACEMENT_URI .  'assets/js/level-placement.js','',$this->versionAssets);
      wp_register_script('model-test',  LEVEL_PLACEMENT_URI .  'assets/js/backbone/model.js','',$this->versionAssets);
      wp_register_script('view-test',  LEVEL_PLACEMENT_URI .  'assets/js/backbone/view.js',''  ,$this->versionAssets);
    }
  

}

