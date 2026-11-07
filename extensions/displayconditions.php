<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

if ( ! defined( 'ROYAL_ADDONS_DC_PATH' ) ) {
    define( 'ROYAL_ADDONS_DC_PATH', plugin_dir_path( __FILE__ ) );
}

// Crucially, load the base class FIRST.
require_once( ROYAL_ADDONS_DC_PATH . 'conditions/royal-condition-base.php' );

// Automatically load all other condition files.
foreach ( glob( ROYAL_ADDONS_DC_PATH . 'conditions/royal-condition-*.php' ) as $file ) {
    if ( strpos( $file, 'royal-condition-base.php' ) === false ) {
        require_once $file;
    }
}

// Load the manager.
require_once( ROYAL_ADDONS_DC_PATH . 'inc/royal-display-conditions-manager.php' );

// Initialize.
\RoyalAddons\Extensions\Inc\Royal_Display_Conditions_Manager::instance();