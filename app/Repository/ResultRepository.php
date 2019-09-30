<?php namespace App\Repository;

class ResultRepository
{
    public function store( $result )    
    {
   
        $nameTest = $result['nameTest'];
        $email    = $result['email'];

        $title = "$nameTest | $email";

        $arr = [
            'post_title'   => $title,
            'post_type'    => 'resultwpquiz',
            'post_status'  => 'publish',
        ];

        $post_id = wp_insert_post($arr);

        $result = json_encode( $result );

        add_post_meta($post_id, 'result', $result); 
    }

    /**
     *  Mostrar fecha y hora.
     *  Combinar     varios reportes en uno mediante las pestañas.
     *  Filtrar por test
     */

    public static function show( $id = null )
    {
        status_header(200);

        if( $id === null )
        {
            $id = (int) get_query_var('idresult');
        }


        $f = fopen('php://memory', 'w'); 

        $result = get_post_meta($id, 'result');
        $result = json_decode($result[0]);

        self::coreCSV($result,$f);

        // reset the file pointer to the start of the file
        fseek($f, 0);

        // tell the browser it's going to be a csv file
        header('Content-Type: application/csv');

        // tell the browser we want to save it instead of displaying it
        header('Content-Disposition: attachment; filename="sample.csv";');

        fpassthru($f);

        // make php send the generated csv lines to the browser

        
        die();
    
    }

    public static function coreCSV($result, &$f)
    {
        //dd($result);
        fputcsv( $f, [ 'Nombre del Test','Puntaje','Correo' ], ';'); 
        fputcsv( $f, [ 'Nombre del Test','Puntaje','Correo' ], ';'); 
    }


}
