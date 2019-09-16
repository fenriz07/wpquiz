<?php 
namespace App\Models;


use \WP_Query as WPQuery;

class BasePostType{


    protected $posttype;
    protected $args;
    protected $query;
    protected $posts;

    public function rawArgs($args)
    {
        $this->args = $args;

        return $this;
    }

    public function search($s)
    {
        $this->args['post_type'] = $this->posttype;
        $this->args['s'] = $s;

        return $this;
    }

    public function whereNMK($condition = null)
    {

        $this->args['post_type'] = $this->posttype;

        return $this;
    }



    public function where($condition = null)
    {

        $this->args['post_type'] = $this->posttype;


        return $this;
    }

    public function postIn($list_id)
    {
        $this->args['post__in'] = $list_id;

        return $this;
    }


    public function numberPost($number = 1)
    {
        $this->args['posts_per_page'] = $number;
        return $this;
    }

    public function paged($p)
    {
        $this->args['paged'] = $p;
        return $this;
    }

    public function post__not_in($post__not_in)
    {
        $this->args['post__not_in'] = $post__not_in;
        return $this;
    }

    public function orderby($orderby = 'post_date')
    {
        $this->args['orderby'] = $orderby;
        return $this;
    }

    public function order($order)
    {
        $this->args['order'] = $order;
        return $this;
    }

    public static function show($post)
    {
        return get_post($post);
    }


    public function query()
    {
        $this->query = new WPQuery($this->args);

        $this->listPost();
        return $this;
    }

    public function queryE()
    {
        $this->query = new WPQuery($this->args);

        $this->listPost();
        return $this;
    }

    protected function listPost()
    {
        $posts = [];

        if ($this->query->have_posts()) {
            while ($this->query->have_posts()) : $this->query->the_post();

            $id = get_the_ID();

            array_push($posts, [
                  'id'      => $id,
                  'uri'     => get_permalink(get_the_ID()),
                  'title'   => get_the_title(),
                  'content' => get_the_content(),
            ]);

            endwhile;
        }
        $this->posts = $posts;
        wp_reset_postdata();
    }

    public function get()
    {
        return $this->posts;
    }

}