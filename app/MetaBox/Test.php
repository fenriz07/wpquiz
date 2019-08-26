<?php


function testPostMetaBox($meta_boxes)
{
    
    $meta_boxes[] = array(
        'id' => 'metabox-test-post',
        'title' => esc_html__('Answers', LEVEL_PLACEMENT_DOMAIN_TEXT),
        'post_types' => array( 'test' ),
        'context' => 'after_title',
        'priority' => 'high',
        'autosave' => false,
        'fields' => array(
            array(
                'id' => LEVEL_PLACEMENT_PREFIX_META_BOX . 'answers',
                'type' => 'text',
                'name' => esc_html__('First response (valid)', LEVEL_PLACEMENT_DOMAIN_TEXT),
                'clone' => true,
                'max_clone' => 3,
                'placeholder' => 'Answer',
                'size' =>  60
            ),


        ),
    );

    return $meta_boxes;
}
add_filter('rwmb_meta_boxes', 'testPostMetaBox');