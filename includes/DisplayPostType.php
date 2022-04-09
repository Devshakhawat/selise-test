<?php

namespace Selise;

defined( 'ABSPATH' ) || exit;

/**
 * Display Post type on frontend
 *
 * @since 1.0.0
 */
class DisplayPostType {

    /**
     * Declared Shortcode show_quiz
     *
     * @since 1.0.0
     */
    public function run() {
        add_shortcode( 'show_quiz', [ $this, 'display_post_type' ] );
    }

    /**
     * Callback of Shortcode
     * 
     * @param null
     *
     * @since 1.0.0
     */
    public function display_post_type() {
        wp_enqueue_script( 'quiz_app' );
        wp_enqueue_script( 'quiz_app_asset' );

        $args = [
            'post_type'      => 'quiz_system',
            'post_status'    => 'publish',
            'posts_per_page' => -1,
        ];

        $value = [];

        $query = new \WP_Query( $args );
        if( $query->have_posts() ) {
            while( $query->have_posts() ) {
                $query->the_post();
                $value[] = [
                    'title'   => get_the_title(),
                    'option'  =>  maybe_unserialize( get_post_meta( get_the_id(), 'mcq_question', true ) ),
                    'answer'  => get_post_meta( get_the_id(), 'mcq_answer', true )
                ];
            }
        }

        wp_reset_postdata();

        ob_start();

        include Qns_One_PATH . '/templates/mcq-template.php';

        return ob_get_clean();        
    } 
}