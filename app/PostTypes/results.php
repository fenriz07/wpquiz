<?php

use App\Repository\ResultRepository;

/**
 *
 */

class ResultPostType
{
    public static function register()
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
            'capabilities' => [
                'create_posts' => 'do_not_allow',
            ],
            'map_meta_cap' => true,
    
        );
    
        register_post_type('resultwpquiz', $args);
    }

    public static function rowActions( $actions, $post)
    {
        $site =  site_url('descargar/resultado/') . $post->ID;

        if ($post->post_type =='resultwpquiz'){

            $link = '<a target="_self" href="'. esc_url($site). '" > Ver Resultados </a>';
    
            return ['view' => $link];        
        }
        return $actions;
    }

    public static function addColumns( $columns )
    {
        $columns = [
            'cb' => '&lt;input type="checkbox" />',
            'title' => __( 'Test' ),
            'point' => __( 'Puntaje' ),
            'email' => __( 'Correo' ),
            'date' => __( 'Date' )
        ];

        return $columns;
    }

    public static function fillRows( $column, $post_id )
    {
        $result = get_post_meta($post_id, 'result');
        $result = json_decode($result[0],true);

        switch( $column ) {

            case 'point' :
                echo ($result['point'] == null ? 0 : $result['point']);
                break;
            case 'email':
                echo $result['email'] ;
                break;
            default :
                break;
        }
    }

}


add_action('init', [ResultPostType::class,'register'], 0);
add_filter('post_row_actions', [ResultPostType::class, 'rowActions'], 10, 2);
add_filter( 'manage_edit-resultwpquiz_columns', [ResultPostType::class,'addColumns'] ) ;
add_action( 'manage_resultwpquiz_posts_custom_column', [ResultPostType::class,'fillRows'], 10, 2 );


?>

