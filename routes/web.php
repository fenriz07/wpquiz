<?php

use App\Mails\Mail;
use App\Repository\PDF\Base;
use App\Queue\QueueMailCourseInfo;

/**
 * Class to manage the spn routes
 */
class SpnRoutes
{
    protected $queue;
    
    public function setRoutes()
    {
        global $wp;
        $wp->add_query_var('pdfid');

        add_rewrite_rule('descargar/programa/([^d/]*)/?$', 'index.php?pagename=downloadcourse&pdfid=$matches[1]', 'top'); 

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
                
        if( $pagename == 'downloadcourse' )
        {   
            Base::print();
            exit(0);

            //$this->queue->push_to_queue(0);
            //$this->queue->save()->dispatch();
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
