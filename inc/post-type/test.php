<?php

/**
 *
 */
function TestCustomPost()
{
    $labels = array(
        'name'                => _x('Test', 'Post Type General Name', LEVEL_PLACEMENT_DOMAIN_TEXT),
        'singular_name'       => _x('Test', 'Post Type Singular Name', LEVEL_PLACEMENT_DOMAIN_TEXT),
        'menu_name'           => __('WP Level Placement', LEVEL_PLACEMENT_DOMAIN_TEXT),
        'parent_item_colon'   => __('Parent Test:', LEVEL_PLACEMENT_DOMAIN_TEXT),
        'all_items'           => __('All Question', LEVEL_PLACEMENT_DOMAIN_TEXT),
        'view_item'           => __('View Question', LEVEL_PLACEMENT_DOMAIN_TEXT),
        'add_new_item'        => __('Add Question', LEVEL_PLACEMENT_DOMAIN_TEXT),
        'add_new'             => __('Add New', LEVEL_PLACEMENT_DOMAIN_TEXT),
        'edit_item'           => __('Edit Question', LEVEL_PLACEMENT_DOMAIN_TEXT),
        'update_item'         => __('Update Question', LEVEL_PLACEMENT_DOMAIN_TEXT),
        'search_items'        => __('Search Question', LEVEL_PLACEMENT_DOMAIN_TEXT),
        'not_found'           => __('Not found', LEVEL_PLACEMENT_DOMAIN_TEXT),
        'not_found_in_trash'  => __('Not found in Trash', LEVEL_PLACEMENT_DOMAIN_TEXT),
    );

    $args = array(
        'label'               => __('WP Level Placement', LEVEL_PLACEMENT_DOMAIN_TEXT),
        'description'         => __('WP Level Placement', LEVEL_PLACEMENT_DOMAIN_TEXT),
        'labels'              => $labels,
        'supports'            => array( 'title'),
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => false,
        'show_in_admin_bar'   => false,
        'menu_position'       => 8,
        'menu_icon'           => 'dashicons-hammer',
        'can_export'          => true,
        'has_archive'         => true,
        'rewrite' => array(
            'slug' => 'test'
        ),
        'exclude_from_search' => true,
        'publicly_queryable'  => true,
    );

    register_post_type('test', $args);


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

    register_taxonomy('category-test', 'test', $args);
}

add_action('init', 'TestCustomPost', 0);


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


function filter_test_by_taxonomies( $post_type, $which ) {

	// Apply this only on a specific post type
	if ( 'test' !== $post_type )
		return;

	// A list of taxonomy slugs to filter by
	$taxonomies = array( 'category-test');

	foreach ( $taxonomies as $taxonomy_slug ) {

		// Retrieve taxonomy data
		$taxonomy_obj = get_taxonomy( $taxonomy_slug );
		$taxonomy_name = $taxonomy_obj->labels->name;

		// Retrieve taxonomy terms
		$terms = get_terms( $taxonomy_slug );

		// Display filter HTML
		echo "<select name='{$taxonomy_slug}' id='{$taxonomy_slug}' class='postform'>";
		echo '<option value="">' . sprintf( esc_html__( 'Show all lvls', LEVEL_PLACEMENT_DOMAIN_TEXT ), $taxonomy_name ) . '</option>';
		foreach ( $terms as $term ) {
			printf(
				'<option value="%1$s" %2$s>%3$s (%4$s)</option>',
				$term->slug,
				( ( isset( $_GET[$taxonomy_slug] ) && ( $_GET[$taxonomy_slug] == $term->slug ) ) ? ' selected="selected"' : '' ),
				$term->name,
				$term->count
			);
		}
		echo '</select>';
	}

}
add_action( 'restrict_manage_posts', 'filter_test_by_taxonomies' , 10, 2);
