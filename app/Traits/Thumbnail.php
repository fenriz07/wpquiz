<?php namespace App\Traits;

trait Thumbnail
{
   public function getThumbnail($product_id)
   {
        $thumbID    = get_post_thumbnail_id( $product_id );
        return wp_get_attachment_url( $thumbID );
   } 
}
