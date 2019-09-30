<?php

use App\Repository\PDF\Base;
use App\Repository\ResultRepository;


/**
 * Class to manage the spn routes
 */
class SpnRoutes
{
    protected $queue;
    
    public function setRoutes()
    {
        global $wp;
        $wp->add_query_var('slugcourse');
        $wp->add_query_var('idresult');

        add_rewrite_rule('descargar/programa/([^/]*)/?$', 'index.php?pagename=downloadcourse&slugcourse=$matches[1]', 'top'); 
        add_rewrite_rule('descargar/resultado/([^/d]*)/?$','index.php?pagename=downloadresult&idresult=$matches[1]', 'top');

        //$this->queue = new QueueMailCourseInfo();

    }


    public function setTitle()
    {
        global $title;
        return $title . " | " . get_bloginfo( 'name' );
    }


    public function setTemplate($template)
    {
        
        $pagename = get_query_var('pagename');        

        switch ($pagename) {
            case 'downloadcourse':
                Base::print();
                exit(0);
                break;
            case 'downloadresult':
                ResultRepository::show();
                break;
            default:
                # code...
                break;
        }

        return $template;
        
    }

    public static function init()
    {
        $self = new self();
        add_action('init', [ $self,'setRoutes' ], 2);
        add_filter('template_include', [$self,'setTemplate'] );
    }
}

SpnRoutes::init();
