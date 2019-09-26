<?php namespace App\Repository\PDF;

use Dompdf\Dompdf;
use Dompdf\Options;
use App\Helpers\View;
use App\Models\CoursesModel;


class Course extends Base
{

    public static function printPDF( int $id, $slug = 'archivo' )
    {
        header("HTTP/1/1.1 200 OK");

        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $options->set('isHtml5ParserEnabled', true);

        $dompdf = new Dompdf($options);

        //$dompdf->set_option( 'dpi' , '92' );
        $dompdf->set_paper('A4','portrait');

        $data = self::createData($id);

        $html = View::make( 'pdf/course', $data );
        
        $dompdf->loadHtml($html);

        // Render the HTML as PDF
        $dompdf->render();

        //$nameFile = sanitize_title($data['{{title}}']) . '.pdf';
        $nameFile = "$slug.pdf";

        $dompdf->stream( $nameFile, ["Attachment" => 0] );

        exit(0);
    }

    private static function createData( int $id )
    {
        $content = CoursesModel::getContentPdf($id);
        $title   = get_the_title( $id );
        $excerpt = get_the_excerpt( $id);
        $image   = get_the_post_thumbnail_url( $id );

        return [
            '{{domain}}'         =>  LEVEL_PLACEMENT_URI,
            '{{css_url}}'        =>  LEVEL_PLACEMENT_URI . 'assets/css/stylePdf.css',
            '{{content}}'        =>  $content,
            '{{title}}'          =>  $title,
            '{{excerpt}}'        =>  $excerpt,
            '{{image}}'          =>  $image,
        ];
    }


}
