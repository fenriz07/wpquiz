<?php

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
                 'title'   => get_the_title(),
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

   public function addMeta()
   {

       $response = 'answers';
       $posts = self::$result;

       foreach ($posts as $key => $post) {
           $answers = rwmb_meta(LEVEL_PLACEMENT_PREFIX_META_BOX . $response, '', $post['id']);
           //Set rand answers
           shuffle($answers);
           $meta = compact('answers');
           $posts[$key]['meta'] = $meta;
       }

       self::$result = $posts;

       return $this;
   }

   public function get()
   {
       return self::$result;
   }
 }
