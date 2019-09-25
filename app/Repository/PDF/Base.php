<?php namespace App\Repository\PDF;


class Base
{
    public static function print()
    {
        $id   = (int) get_query_var('pdfid');
        $type = get_post_type( $id );

       switch ($type) {
           case 'lp_course':
               Course::printPDF( $id );
               break;
           case false: 
                wp_redirect('/');
           default:
                wp_redirect('/');
               break;
       }
    }

}
