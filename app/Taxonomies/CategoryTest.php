<?php

function categoryTest()
{

    $labels = array(
        'name'                       => _x('Tests & Levels', 'taxonomy general name', LEVEL_PLACEMENT_DOMAIN_TEXT),
        'singular_name'              => _x('Tests & Levels', 'taxonomy singular name', LEVEL_PLACEMENT_DOMAIN_TEXT),
        'search_items'               => __('Search Test or Level', LEVEL_PLACEMENT_DOMAIN_TEXT),
        'popular_items'              => __('Popular Categorys', LEVEL_PLACEMENT_DOMAIN_TEXT),
        'all_items'                  => __('All Categorys', LEVEL_PLACEMENT_DOMAIN_TEXT),
        'parent_item'                => null,
        'parent_item_colon'          => null,
        'edit_item'                  => __('Edit Item', LEVEL_PLACEMENT_DOMAIN_TEXT),
        'update_item'                => __('Update Item', LEVEL_PLACEMENT_DOMAIN_TEXT),
        'add_new_item'               => __('Add New Item', LEVEL_PLACEMENT_DOMAIN_TEXT),
        'new_item_name'              => __('New Category Name', LEVEL_PLACEMENT_DOMAIN_TEXT),
        'separate_items_with_commas' => __('Separate Categorys with commas', LEVEL_PLACEMENT_DOMAIN_TEXT),
        'add_or_remove_items'        => __('Add or remove Categorys', LEVEL_PLACEMENT_DOMAIN_TEXT),
        'choose_from_most_used'      => __('Choose from the most used Categorys', LEVEL_PLACEMENT_DOMAIN_TEXT),
        'not_found'                  => __('No Category found.', LEVEL_PLACEMENT_DOMAIN_TEXT),
        'menu_name'                  => __('Tests & Levels', LEVEL_PLACEMENT_DOMAIN_TEXT),
    );

    $args = array(
        'hierarchical'          => true,
        'labels'                => $labels,
        'show_ui'               => true,
        'show_admin_column'     => true,
        'update_count_callback' => '_update_post_term_count',
        'query_var'             => true,
        'rewrite'               => array( 'slug' => 'category' ),
    );

  register_taxonomy('category-test', ['test'], $args);
}


add_action('init', 'categoryTest', 0);
