<?php
/**
 * @package Test E
 * @version 1.1.1
 */
/*
Plugin Name: Test E
Plugin URI: http://auerserg
Description: ---
Author: Auerserg
Version: 1.1.1
*/

defined( 'ABSPATH' ) || exit;

// Define default path.
if ( ! defined( 'TEST_E_BASE' ) ) {
    define( 'TEST_E_BASE', __FILE__ );
}
if ( ! defined( 'TEST_E_URL' ) ) {
    define( 'TEST_E_URL', plugins_url( '/', __FILE__ ) );
}
if ( ! defined( 'TEST_E_PATH' ) ) {
    define( 'TEST_E_PATH', plugin_dir_path( __FILE__ ) );
}

require_once TEST_E_PATH . 'include/Elementor_TestE.php';

final class  Elementor_TestE {
    const MINIMUM_ELEMENTOR_VERSION = '2.0.0';
    const MINIMUM_PHP_VERSION = '7.0';

    public function __construct() {
        add_action( 'init', array( $this, 'i18n' ) );
        add_action( 'plugins_loaded', array( $this, 'init' ) );
    }

    public function i18n() {
        load_plugin_textdomain( 'test-e' );
    }

    public function init() {
        if ( ! did_action( 'elementor/loaded' ) ) {
            add_action( 'admin_notices', array( $this, 'admin_notice_missing_main_plugin' ) );

            return;
        }

        if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
            add_action( 'admin_notices', array( $this, 'admin_notice_minimum_elementor_version' ) );

            return;
        }

        if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
            add_action( 'admin_notices', array( $this, 'admin_notice_minimum_php_version' ) );

            return;
        }
        add_action( 'elementor/widgets/widgets_registered', array( $this, 'register_widgets' ) );
    }


    public function register_widgets() {
        require_once TEST_E_PATH . 'widgets/class-awesomesauce.php';

        \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \ElementorTestE\Widgets\TestE() );
    }

    public function admin_notice_missing_main_plugin() {
        deactivate_plugins( plugin_basename( TEST_E_BASE ) );

        return sprintf(
            wp_kses(
                '<div class="notice notice-warning is-dismissible"><p><strong>"%1$s"</strong> requires <strong>"%2$s"</strong> to be installed and activated.</p></div>',
                array(
                    'div' => array(
                        'class'  => array(),
                        'p'      => array(),
                        'strong' => array(),
                    ),
                )
            ),
            'TestE',
            'Elementor'
        );
    }

    public function admin_notice_minimum_elementor_version() {
        deactivate_plugins( plugin_basename( TEST_E_BASE ) );

        return sprintf(
            wp_kses(
                '<div class="notice notice-warning is-dismissible"><p><strong>"%1$s"</strong> requires <strong>"%2$s"</strong> version %3$s or greater.</p></div>',
                array(
                    'div' => array(
                        'class'  => array(),
                        'p'      => array(),
                        'strong' => array(),
                    ),
                )
            ),
            'TestE',
            'Elementor',
            self::MINIMUM_ELEMENTOR_VERSION
        );
    }

    public function admin_notice_minimum_php_version() {
        deactivate_plugins( plugin_basename( TEST_E_BASE ) );

        return sprintf(
            wp_kses(
                '<div class="notice notice-warning is-dismissible"><p><strong>"%1$s"</strong> requires <strong>"%2$s"</strong> version %3$s or greater.</p></div>',
                array(
                    'div' => array(
                        'class'  => array(),
                        'p'      => array(),
                        'strong' => array(),
                    ),
                )
            ),
            'TestE',
            'Elementor',
            self::MINIMUM_ELEMENTOR_VERSION
        );
    }
}
new Elementor_TestE();