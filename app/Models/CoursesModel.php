<?php namespace App\Models;

use App\Traits\Thumbnail;
 /**
  *
  */
 class CoursesModel extends BasePostType
 {

    use Thumbnail;

    protected $posttype = 'lp_course';

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
                  'image'   => $this->getThumbnail($id),
                  'price'   => $this->getPrice($id)

            ]);

            endwhile;
        }
        $this->posts = $posts;
        wp_reset_postdata();
    }

    private function getPrice($id)
    {
        return rwmb_meta('_lp_price', '', $id);
    }
 

 }