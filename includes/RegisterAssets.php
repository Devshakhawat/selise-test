<?php 

namespace Selise;

defined( 'ABSPATH' ) || exit;

/**
 * Register all css and js files
 *
 * @since 1.0.0
 */
class RegisterAssets {

    public function run() {
        add_action( 'wp_enqueue_scripts', [ $this, 'load_scripts' ] );
        add_action( 'admin_enqueue_scripts', [ $this, 'load_scripts' ] );
    } 

    /**
     * Load asset js
     *
     * @since 1.0.0
     *
     * @param null
     *
     * @return void
     */
    public function load_scripts() {

        //Register Scripts
        wp_register_script( 'quiz_app', Qns_One_ASSETS . '/js/display-data.js', ['jquery'], false, true );
        wp_register_script( 'quiz_app_asset', Qns_One_URL . '/build/index.js', ['jquery'], false, true );    
    } 

}