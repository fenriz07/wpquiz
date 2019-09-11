<?php
define('PREFIX_META_BOX_VIDEOS' , 'product-post-');

class MetaBoxTest{

    public static function typeQuestion( $meta_boxes )
    {
        $meta_boxes[] = [
            'id'            => 'metabox-test-type-question-uc',
            'title'         => 'Tipo de pregunta',
            'post_types'    => ['test'],
            'context'       => 'side',
            'priority'      => 'high',
            'fields'        => [
                [
                    'id'              => LEVEL_PLACEMENT_PREFIX_META_BOX . 'type_question',
                    'type'            => 'select',
                    // Array of 'value' => 'Label' pairs
                    'options'         => [
                        'imagenes'  => 'Imagenes',
                        'parrafos'  => 'Parrafos',
                        'lista'     => 'Lista',
                        'audio'     => 'Audio',
    
                    ],
                    // Allow to select multiple value?
                    'multiple'        => false,
                    // Placeholder text
                    'placeholder'     => 'Select an Item',
                    'required'        => true,
                ],
            ],
        ];
    
        return $meta_boxes;
    
    }


    public static function questions( $meta_boxes )
    {

        $types = [
            'imagenes',
            'parrafos',
            'lista'   ,
            'audio'   ,
        ];

        if( !isset( $_GET['action'] ) && is_admin() )
        {            
            
            return self::allMetabox($meta_boxes);
        }
    
        if( $_GET['action'] == 'edit')
        {
            if( !isset( $_GET['post'] ) )
            {
                return $meta_boxes;
            }
    
            $type =  rwmb_meta( LEVEL_PLACEMENT_PREFIX_META_BOX . 'type_question','',$_GET['post']);

            if( in_array( $type,$types ) )
            {
                return self::{$type}( $meta_boxes );
            }

            return $meta_boxes;
        }

        return $meta_boxes;
    
    }

    public static function description( $meta_boxes )
    {
        $meta_boxes[] = [
            'id'            => 'metabox-test-description-question-uc',
            'title'         => 'Descripciones',
            'post_types'    => ['test'],
            'priority'      => 'high',
            'fields'        => [
                [
                    'name' => 'Primera descripción',
                    'id'   => LEVEL_PLACEMENT_PREFIX_META_BOX . 'first-description',
                    'type' => 'textarea',
                ],
                [
                    'name' => 'Segunda descripción',
                    'id'   => LEVEL_PLACEMENT_PREFIX_META_BOX . 'second-description',
                    'type' => 'textarea',
                ]
            ],
        ];

        return $meta_boxes;
    }

    private static function imagenes( $meta_boxes )
    {


        $meta_boxes[] = [
            'title'      => 'Tipo: Imágenes',
            'post_types' => ['test'],
            'attributes' => [
                'hidden' => true,
            ],
            'fields'     => [
                [
                    'name'       => 'Preguntas',
                    'id'         => 'questions',
                    'type'       => 'group',
                    'clone'      => true,
                    'add_button' => 'Nueva pregunta',
                    'fields' => [
                        [
                            'name' => 'Imagen',
                            'id'   => LEVEL_PLACEMENT_PREFIX_META_BOX . 'image',
                            'type' => 'image_advanced',
                            'max_file_uploads' => 1,
                        ],
                        [
                            'id' => LEVEL_PLACEMENT_PREFIX_META_BOX . 'answers',
                            'type' => 'text',
                            'name' => esc_html__('La primera respuesta es la valida', LEVEL_PLACEMENT_DOMAIN_TEXT),
                            'clone' => true,
                            'placeholder' => 'Respuesta',
                            'size' =>  60,
                            'add_button' => 'Nueva respuesta',
                        ]
                    ]
                ],
            ]

        ];

        return $meta_boxes;
    }

    private static function allMetabox($meta_boxes)
    {
        $meta_boxes = self::imagenes( $meta_boxes );
        $meta_boxes = self::parrafos( $meta_boxes );
        $meta_boxes = self::lista( $meta_boxes );

        return $meta_boxes;
    }

    private static function parrafos( $meta_boxes )
    {
        return $meta_boxes;
    }

    private static function lista( $meta_boxes )
    {
        return $meta_boxes;
    }

    private static function audio( $meta_boxes )
    {
        return $meta_boxes;
    }
}

add_filter( 'rwmb_meta_boxes', [ MetaBoxTest::class,'typeQuestion' ]  );
add_filter( 'rwmb_meta_boxes', [ MetaBoxTest::class,'questions'    ]  );
add_filter( 'rwmb_meta_boxes', [ MetaBoxTest::class,'description'  ]  );






function load_custom_wp_admin_style($hook) {

    if($hook == 'post-new.php') 
    {
        wp_enqueue_style( 'custom_wp_admin_css', LEVEL_PLACEMENT_URI . 'assets/css/admin.css' );
    }

    return;
}
//add_action( 'admin_enqueue_scripts', 'load_custom_wp_admin_style' );