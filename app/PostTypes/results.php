<?php

/**
 *
 */
function ResultCustomPost()
{
    $labels = array(
        'name'                => _x('Result WP Quiz', 'Post Type General Name', LEVEL_PLACEMENT_DOMAIN_TEXT),
        'singular_name'       => _x('Result WP Quiz', 'Post Type Singular Name', LEVEL_PLACEMENT_DOMAIN_TEXT),
        'menu_name'           => __('Result WP Quiz', LEVEL_PLACEMENT_DOMAIN_TEXT),
        'parent_item_colon'   => __('Parent Result WP Quiz:', LEVEL_PLACEMENT_DOMAIN_TEXT),
        'all_items'           => __('All Results', LEVEL_PLACEMENT_DOMAIN_TEXT),
        'view_item'           => __('View Results', LEVEL_PLACEMENT_DOMAIN_TEXT),
        'add_new_item'        => __('Add Question', LEVEL_PLACEMENT_DOMAIN_TEXT),
        'add_new'             => __('Add New', LEVEL_PLACEMENT_DOMAIN_TEXT),
        'edit_item'           => __('Edit Question', LEVEL_PLACEMENT_DOMAIN_TEXT),
        'update_item'         => __('Update Question', LEVEL_PLACEMENT_DOMAIN_TEXT),
        'search_items'        => __('Search Question', LEVEL_PLACEMENT_DOMAIN_TEXT),
        'not_found'           => __('Not found', LEVEL_PLACEMENT_DOMAIN_TEXT),
        'not_found_in_trash'  => __('Not found in Trash', LEVEL_PLACEMENT_DOMAIN_TEXT),
    );

    $args = array(
        'label'               => __('Results WP Quiz', LEVEL_PLACEMENT_DOMAIN_TEXT),
        'description'         => __('Results WP Quiz', LEVEL_PLACEMENT_DOMAIN_TEXT),
        'labels'              => $labels,
        'supports'            => array( 'title'),
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => false,
        'show_in_admin_bar'   => false,
        'menu_position'       => 9,
        'menu_icon'           => 'dashicons-hammer',
        'can_export'          => true,
        'has_archive'         => true,
        'rewrite' => array(
            'slug' => 'results-wp-quiz'
        ),
        'exclude_from_search' => true,
        'publicly_queryable'  => true,
    );

    register_post_type('resultwpquiz', $args);

}

add_action('init', 'ResultCustomPost', 0);
