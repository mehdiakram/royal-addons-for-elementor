<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! defined( 'ROYAL_ADDONS_DIR_PATH' ) || ! defined( 'ROYAL_ADDONS_VERSION' ) ) {
    error_log( 'Custom Fonts Loader: Required constants are not defined.' );
    return;
}

if ( ! function_exists( 'royal_addons_custom_fonts_autoload' ) ) {
    function royal_addons_custom_fonts_autoload( $class_name ) {
        if ( false === strpos( $class_name, 'Royal_Addons_Custom_Fonts_' ) ) {
            return;
        }

        if ( 'Royal_Addons_Custom_Fonts_Cpt' === $class_name ) {
            $file_name = 'royal-custom-fonts-cpt';
        } elseif ( 'Royal_Addons_Custom_Fonts_Elementor_Fonts_Integration' === $class_name ) {
            $file_name = 'royal-elementor-fonts-integration';
        } else {
            $file_name = strtolower( str_replace( '_', '-', str_replace( 'Royal_Addons_Custom_Fonts_', '', $class_name ) ) );
        }

        $file_path = ROYAL_ADDONS_DIR_PATH . 'includes/custom-fonts/class-' . $file_name . '.php';

        if ( file_exists( $file_path ) ) {
            require_once $file_path;
        }
    }
}


/**
 * Initialize Custom Fonts classes.
 * This function will be hooked into 'plugins_loaded' by the main plugin.
 */
if ( ! function_exists( 'royal_addons_custom_fonts_initialize' ) ) {
    function royal_addons_custom_fonts_initialize() {
        if ( class_exists( 'Royal_Addons_Custom_Fonts_Cpt' ) ) {
            $cpt_instance = new Royal_Addons_Custom_Fonts_Cpt();
            // Try increasing the priority for admin_enqueue_scripts
            // add_action( 'admin_enqueue_scripts', array( $cpt_instance, 'enqueue_admin_scripts' ), 10 ); // OLD PRIORITY (default)
            // Add action with higher priority
            add_action( 'admin_enqueue_scripts', array( $cpt_instance, 'enqueue_admin_scripts' ), 999 ); // <-- run after default admin scripts
        }
        if ( class_exists( 'Royal_Addons_Custom_Fonts_Elementor_Fonts_Integration' ) ) {
            new Royal_Addons_Custom_Fonts_Elementor_Fonts_Integration();
        }
    }
}

/**
 * Handles Custom Fonts activation logic.
 * This function will be hooked into plugin activation hook by the main plugin.
 */
if ( ! function_exists( 'royal_addons_custom_fonts_activate' ) ) {
    function royal_addons_custom_fonts_activate() {
        if ( class_exists( 'Royal_Addons_Custom_Fonts_Cpt' ) ) {
            $cpt_instance = new Royal_Addons_Custom_Fonts_Cpt();
            $cpt_instance->register_cpt();
            flush_rewrite_rules();
        }
    }
}

/**
 * Handles Custom Fonts deactivation logic.
 * This function will be hooked into plugin deactivation hook by the main plugin.
 */
if ( ! function_exists( 'royal_addons_custom_fonts_deactivate' ) ) {
    function royal_addons_custom_fonts_deactivate() {
        flush_rewrite_rules();
    }
}