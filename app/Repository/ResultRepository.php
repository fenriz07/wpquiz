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
}
