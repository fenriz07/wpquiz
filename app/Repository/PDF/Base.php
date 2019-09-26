<?php namespace App\Repository\PDF;


class Base
{
    public static function print()
    {
        $slugCourse  = get_query_var('slugcourse');

        if ( $post = get_page_by_path( $slugCourse, OBJECT, 'lp_course' ) )
        {
            $id = $post->ID;
        }
        else{
            wp_redirect('/');
        };

       $type = get_post_type( $id );

       switch ($type) {
           case 'lp_course':
               Course::printPDF( $id,$slugCourse );
               break;
           case false: 
                wp_redirect('/');
           default:
                wp_redirect('/');
               break;
       }
    }

}
