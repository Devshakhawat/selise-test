<?php

namespace Selise;

defined( 'ABSPATH' ) || exit;

class QuizPostType {
    
    /**
     * PostType name
     * 
     * @var string $post_type
     */
    public $post_type = 'quiz_system';

    /**
     * Declare necessary hooks
     *
     * @since 1.0.0
     */
    public function run() {
        add_action( 'init', [ $this, 'register_custom_post_type' ] );
        add_action( 'add_meta_boxes', [ $this, 'register_meta_boxes' ] );
        add_action( 'save_post', [ $this, 'quiz_meta_values' ] );
    }

    /**
     * Register custom post type
     * 
     * @param null
     * 
     * @return void
     */
    public function register_custom_post_type() {
        $labels = [
            'name'                  => _x( 'Quizes', 'Post type general name', 'stock-email-notifier' ),
            'singular_name'         => _x( 'Quiz', 'Post type singular name', 'stock-email-notifier' ),
            'menu_name'             => _x( 'Quizes', 'Admin Menu text', 'stock-email-notifier' ),
            'name_admin_bar'        => _x( 'MCQ', 'Add New on Toolbar', 'stock-email-notifier' ),
            'add_new'               => __( 'Add New', 'stock-email-notifier' ),
            'add_new_item'          => __( 'Add New MCQ', 'stock-email-notifier' ),
            'new_item'              => __( 'New MCQ', 'stock-email-notifier' ),
            'edit_item'             => __( 'Edit MCQ', 'stock-email-notifier' ),
            'view_item'             => __( 'View MCQ', 'stock-email-notifier' ),
            'all_items'             => __( 'All Quizes', 'stock-email-notifier' ),
            'search_items'          => __( 'Search Quizes', 'stock-email-notifier' ),
            'parent_item_colon'     => __( 'Parent Quizes:', 'stock-email-notifier' ),
            'not_found'             => __( 'No Quizes found.', 'stock-email-notifier' ),
            'not_found_in_trash'    => __( 'No Quizes found in Trash.', 'stock-email-notifier' ),
            'featured_image'        => _x( 'MCQ Cover Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'stock-email-notifier' ),
            'set_featured_image'    => _x( 'Set cover image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'stock-email-notifier' ),
            'remove_featured_image' => _x( 'Remove cover image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'stock-email-notifier' ),
            'use_featured_image'    => _x( 'Use as cover image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'stock-email-notifier' ),
            'archives'              => _x( 'MCQ archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'stock-email-notifier' ),
            'insert_into_item'      => _x( 'Insert into MCQ', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'stock-email-notifier' ),
            'uploaded_to_this_item' => _x( 'Uploaded to this MCQ', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'stock-email-notifier' ),
            'filter_items_list'     => _x( 'Filter Quizes list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'stock-email-notifier' ),
            'items_list_navigation' => _x( 'Quizes list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'stock-email-notifier' ),
            'items_list'            => _x( 'Quizes list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'stock-email-notifier' ),
        ];

        $args = apply_filters( 'quiz_system_post_type', [
            [
                'labels'               => $labels,
                'public'               => true,
                'publicly_queryable'   => true,
                'show_ui'              => true,
                'show_in_menu'         => true,
                'query_var'            => true,
                'rewrite'              => array( 'slug' => $this->post_type ),
                'capability_type'      => 'post',
                'has_archive'          => true,
                'show_in_rest'         => true,
                'hierarchical'         => false,
                'menu_position'        => null,
                'supports'             => array( 'title', 'editor' ),
            ]
        ]);
    
        foreach ( $args as $arg ) {
            register_post_type( $this->post_type, $arg );
        }
    }

    /**
     * Render meta boxes
     * 
     * @param null
     * 
     * @return void
     */
    public function register_meta_boxes() {
        $metaboxes = $this->get_metaboxes();

        foreach ( $metaboxes as $meta ) {
            add_meta_box( $meta[ 'id' ], $meta[ 'title' ], $meta[ 'callback' ], $meta[ 'screen' ], $meta[ 'context' ] );
        }
    }

    /**
     * Retrieve meta boxes
     * 
     * @param null
     * 
     * @return array
     */
    public function get_metaboxes() {
        $metaboxes = [
            [
                'id'            => 'mcq_question_items',
                'title'         => __( 'Quiz Questions', 'quiz-qsn' ),
                'callback'      => [ $this, 'render_mcq_items' ],
                'screen'        => $this->post_type,
                'context'       => 'normal',
            ],
            [
                'id'            => 'mcq_answer',
                'title'         => __( 'Quiz Answer', 'quiz-qsn' ),
                'callback'      => [ $this, 'quiz_answer' ],
                'screen'        => $this->post_type,
                'context'       => 'normal',
                
            ]
        ];

        return apply_filters( 'register_mcq_metaboxes', $metaboxes );
    }

    /**
     * Show questions inputs
     * 
     * @param null
     * 
     * @return void
     */
    public function render_mcq_items() {
        ?>
            <p>
                <input type="text" class="regular-text" name="mcq_question[]" placeholder="Option one" required>
            </p>
            <p>
                <input type="text" class="regular-text" name="mcq_question[]" placeholder="Option two" required>
            </p>
            <p>
                <input type="text" class="regular-text" name="mcq_question[]" placeholder="Option three" required>
            </p>
            <p>
                <input type="text" class="regular-text" name="mcq_question[]" placeholder="Option four" required>
            </p>
        <?php
    }

    /**
     * Display answers input
     * 
     * @param null
     * 
     * @return void
     */
    public function quiz_answer() {
        echo '<input type="text" class="regular-text" name="mcq_answer" placeholder="Answer" >';
    }

    /**
     * AutoSave Quiz Datas
     * 
     * @param int $post_id
     * 
     * @return void
     */
    public function quiz_meta_values( $post_id ) {

        // If this is an autosave, so don't want to do anything.
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return;
        }

        // Check the user's permissions.
        if ( ! current_user_can( 'edit_page', $post_id ) ) {
            return;
        }

        if ( ! empty( $_POST['mcq_answer'] ) && ! empty( $_POST['mcq_question'] ) ) {
            $questions = array_map( 'sanitize_text_field', $_POST['mcq_question'] );
            $answer    = sanitize_text_field( $_POST['mcq_answer'] );

            update_post_meta( $post_id, 'mcq_question', maybe_serialize( $questions ) );
            update_post_meta( $post_id, 'mcq_answer', $answer );
        }
    }
}
