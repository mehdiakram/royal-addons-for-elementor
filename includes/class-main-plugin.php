<?php
// Main plugin class for Royal Addons for Elementor

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

final class Royal_Addons_for_Elementor {
    const MINIMUM_ELEMENTOR_VERSION = '3.0.0';
    const MINIMUM_PHP_VERSION = '7.0';

    public function __construct() {
        // Core Hooks
        add_filter( 'plugin_row_meta', [ $this, 'royal_addons_for_elementor_plugin_row_meta' ], 10, 2 );
        add_filter( 'plugin_action_links', [ $this, 'royal_addons_for_elementor_plugin_action_links' ], 1, 2 );
        add_action( 'init', array( $this, 'i18n' ) );
        add_action( 'init', array( $this, 'init' ) );

        // Custom Font Specific Loader Integration
        // loader.php is loaded in the main plugin file, and its functions are hooked globally there.

        // Main Loader (for widgets, extensions, etc.)
        require_once ROYAL_ADDONS_DIR_PATH . 'includes/includes.php';
        $royal_includes_loader = new RoyalAddons\Royal_Includes_Loader();
        add_action( 'plugins_loaded', [ $royal_includes_loader, 'load_all_files' ], 0 );
    }

    public function royal_addons_for_elementor_plugin_row_meta( $links_array, $plugin_file_name ) {
        if ( $plugin_file_name === plugin_basename(ROYALADDONSFILE) ) { // Use ROYALADDONSFILE constant
            $links_array[] = '<a href="https://www.royaltechbd.com/product/royal-addons-for-elementor/" target="_blank">Plugin Details</a>';
            $links_array[] = '<a href="https://www.messenger.com/t/190720437675055" target="_blank">FB Chat</a>';
        }
        return $links_array;
    }

    public function royal_addons_for_elementor_plugin_action_links( $links_array, $plugin_file_name ) {
        if ( $plugin_file_name === plugin_basename(ROYALADDONSFILE) ) { // Use ROYALADDONSFILE constant
            $links_array[] = '<a href="' . esc_url(admin_url('admin.php?page=royaladdonsforelementor')) . '">Settings</a>';
        }
        return $links_array;
    }
    
    public function i18n() {
        load_plugin_textdomain( 'royal-addons-for-elementor' );
    }

    public function init() {
        // Check if Elementor installed and activated
        if ( ! did_action( 'elementor/loaded' ) ) {
            add_action( 'admin_notices', array( $this, 'admin_notice_missing_main_plugin' ) );
            return;
        }

        // Check for required Elementor version
        if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
            add_action( 'admin_notices', array( $this, 'admin_notice_minimum_elementor_version' ) );
            return;
        }

        // Check for required PHP version
        if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
            add_action( 'admin_notices', array( $this, 'admin_notice_minimum_php_version' ) );
            return;
        }
    }

    public function admin_notice_missing_main_plugin() {
        if ( isset( $_GET['activate'] ) ) {
            unset( $_GET['activate'] );
        }

        $message = sprintf(
            esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'royal-addons-for-elementor' ),
            '<strong>' . esc_html__( 'Royal Addons for Elementor', 'royal-addons-for-elementor' ) . '</strong>',
            '<strong>' . esc_html__( 'Elementor', 'royal-addons-for-elementor' ) . '</strong>'
        );

        printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
    }

    public function admin_notice_minimum_elementor_version() {
        if ( isset( $_GET['activate'] ) ) {
            unset( $_GET['activate'] );
        }

        $message = sprintf(
            esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'royal-addons-for-elementor' ),
            '<strong>' . esc_html__( 'Royal Addons for Elementor', 'royal-addons-for-elementor' ) . '</strong>',
            '<strong>' . esc_html__( 'Elementor', 'royal-addons-for-elementor' ) . '</strong>',
            self::MINIMUM_ELEMENTOR_VERSION
        );

        printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
    }

    public function admin_notice_minimum_php_version() {
        if ( isset( $_GET['activate'] ) ) {
            unset( $_GET['activate'] );
        }

        $message = sprintf(
            esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'royal-addons-for-elementor' ),
            '<strong>' . esc_html__( 'Royal Addons for Elementor', 'royal-addons-for-elementor' ) . '</strong>',
            '<strong>' . esc_html__( 'PHP', 'royal-addons-for-elementor' ) . '</strong>',
            self::MINIMUM_PHP_VERSION
        );

        printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
    }
}