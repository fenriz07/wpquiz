<?php namespace App\Repository\PDF;

use Dompdf\Dompdf;
use Dompdf\Options;
use App\Helpers\View;


class Course extends Base
{

    public static function printPDF( int $id )
    {
        header("HTTP/1/1.1 200 OK");

        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $options->set('isHtml5ParserEnabled', true);

        $dompdf = new Dompdf($options);

        //$dompdf->set_option( 'dpi' , '92' );
        $dompdf->set_paper('A4','portrait');

       // $data = self::createData($id);

        $html = View::make( 'pdf/course', [] );
        
        $dompdf->loadHtml($html);

        // Render the HTML as PDF
        $dompdf->render();

        //$nameFile = sanitize_title($data['{{title}}']) . '.pdf';
        $nameFile = 'test.pdf';

        $dompdf->stream( $nameFile, ["Attachment" => 0] );

        exit(0);
    }

}
