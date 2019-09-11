<?php namespace App\Models;

use \WP_Query;

 /**
  *
  */
 class TestModel
 {
   private static $_instance = null;
   private static $post_type = 'test';
   private static $args;
   public static $result;

   function __construct()
   {
     # code...
   }

   public static function select()
   {
       if (self::$_instance === null) {
           self::$_instance = new self;
       }

       return self::$_instance;
   }

   public function setCategory($id_category)
   {
       self::$args['tax_query']  = [[
           'taxonomy' => 'category-test',
           'field'    => 'term_taxonomy_id',
           'terms'     => $id_category,
         ]];

       return $this;
   }

   public function base()
   {
       self::$args['post_type'] = self::$post_type;
       self::$args['post_status' ] = 'publish';
       self::$args['posts_per_page'] = -1;
       self::$args['orderby'] = 'rand';

       $posts = [];
       $query = new WP_Query(self::$args);

       // The Loop
       if ($query->have_posts()) {
           while ($query->have_posts()) : $query->the_post();
           array_push($posts, [
                 'id'      => get_the_ID(),
                 'title'   => html_entity_decode(get_the_title()),
               ]);
           endwhile;
       } else {
           self::$result = [];
           return $this;
       }

       // Reset Post Data
       wp_reset_postdata();

       self::$result = $posts;
       return $this;
   }

   public function addMeta($rand = 0)
   {

       $response = 'answers';
       $posts = self::$result;

       foreach ($posts as $key_post => $post) {
           $answers = rwmb_meta(LEVEL_PLACEMENT_PREFIX_META_BOX . $response, '', $post['id']);

           foreach ($answers as $key => $answer) {
             $answers[$key] = ['text' => $answer , 'slug' => sanitize_title($answer)];
           }

           //Set rand answers
           if($rand == 1){
              shuffle($answers);
           }
           $posts[$key_post]['meta'] = compact('answers'); ;
       }

       self::$result = $posts;

       return $this;
   }

   public function addAnswer()
   {
     $response = 'answers';
     $posts = self::$result;

     foreach ($posts as $key => $post) {
         $answers = rwmb_meta(LEVEL_PLACEMENT_PREFIX_META_BOX . $response, '', $post['id']);
         $posts[$key]['answer'] = ['text' => $answers[0]  , 'slug' => sanitize_title($answers[0])] ;
     }

     self::$result = $posts;

     return $this;
   }

   public function get()
   {
       return self::$result;
   }

   public static function typeQuestion( $id )
   {
     return rwmb_meta( LEVEL_PLACEMENT_PREFIX_META_BOX . 'type_question', '', $id);
   }

   public static function getQuestionType($type,$id)
   {
     return self::{$type}($id);
   }

   private static function imagenes($id)
   {
     $questions = rwmb_meta('questions','',$id);

     foreach ($questions as $key => $q) {
       $questions[$key]['test-post-image'] = wp_get_attachment_url( $q['test-post-image'][0] );
       shuffle( $questions[$key]['test-post-answers']);
     }

     $payload = [
      'id'        => $id,
      'type'      => 'imagenes',
      'questions' => $questions,
     ];

     return $payload;
   }

   private static function lista($id)
   {

    $questions = rwmb_meta( 'questions_lista', '', $id);

    foreach ($questions as $key => $q)
    {
       shuffle( $questions[$key]['test-post-answers'] );
    }

     $payload = [
       'id'        => $id,
       'type'      => 'lista',
       'questions' => $questions,
     ];

     return $payload;

   }

   private static function parrafos($id)
   {
     $questions = rwmb_meta( 'questions_parrafo', '', $id);

     foreach ($questions as $key => $q)
     {
        shuffle( $questions[$key]['test-post-answers'] );
     }

     $payload = [
       'id'        => $id,
       'type'      => 'parrafos',
       'questions' => [
                        'image' => self::getUrlImage( rwmb_meta( LEVEL_PLACEMENT_PREFIX_META_BOX . 'image', '', $id) ),
                        'group' => $questions,
                      ]
      ];

    return $payload;
   }

   private static function getUrlImage( $image )
   {
     $image = reset($image);
    
     return $image['full_url'];
   }
 }
