<?php
/**
 * Plugin Name:    Selise Test
 * Plugin URI:     testquestion.me
 * Description:    This is a test question
 * Version:        1.0.0
 * Author:         Shakhawat
 * Author URI:     shakhawat.me
 * License:        GPL v2 or later
 * License URI:    https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:    quiz-qsn
 * Domain Path:    /languages
 */

// Prevent Direct access
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Require autoload file
require_once __DIR__ . '/vendor/autoload.php';

/**
 * Plugin Base class Exam_Qsn
 * 
 * @since 1.0.0
 */
final class Exam_Qsn {

    /**
     * Plugin version
     * 
     * @var string version
     */
    const version = '1.0.0';

    /**
     * Class construct for Exam_Qsn plugin
     * 
     * Setup all required hooks and actions
     *
     * @return void
     */
    private function __construct() {
        $this->define_constants();

        add_action( 'plugins_loaded', [ $this, 'init_plugin' ] );

    }

    /**
     * Define all plugin constants
     * 
     * @return void
     */
    public function define_constants() {
        define( 'Qns_One_VERSION', self::version );
        define( 'Qns_One_PATH', __DIR__ );
        define( 'Qns_One_FILE', __FILE__ );
        define( 'Qns_One_URL', plugins_url( '', Qns_One_FILE ) );
        define( 'Qns_One_ASSETS', Qns_One_URL . '/assets' );
    }

    /**
     * Plugin Init callback
     * 
     * @param null
     *
     * @return void
     */
    public function init_plugin() {
        $assets = new Selise\RegisterAssets();
        $assets->run();

        $post_type = new Selise\QuizPostType();
        $post_type->run();

        $shrtcode = new Selise\DisplayPostType();
        $shrtcode->run();
    }

    /**
     * Singleton Instance
     * 
     * @param null
     *
     * @return \Exam_Qsn
     */
    public static function init() {
        static $instance = false;

        if ( ! $instance ) {
            $instance = new self();
        }

        return $instance;
    }
}

/**
 * Initialize the plugin
 * 
 * @param null
 *
 * @return \Exam_Qsn
 */
function selise_qsn() {

    return Exam_Qsn::init();
}

// Start the plugin
selise_qsn();
