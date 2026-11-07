<?php
/*
Plugin Name: Royal Addons for Elementor
Description: Royal Addons for Elementor is one of the best Elementor addons comes with free Elementor widgets & custom css feature.
Requires Plugins: Elementor
Version: 26.11.11
Author: Royal Technologies
Author URI: https://www.royaltechbd.com
License: GPLv2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Requires at least: 6.7
Requires PHP: 7.4
Text Domain: royal-addons-for-elementor
Domain Path: /languages
Tested up to: 7.0
Elementor tested up to: 4.1.1
Elementor Pro tested up to: 4.1.1
*/


defined('ABSPATH') || exit; // Exit if accessed directly

// Define Plugin Constants
if ( ! defined( 'ROYAL_ADDONS_VERSION' ) ) {
    $plugin_data = get_file_data(
        __FILE__,
        array(
            'version' => 'Version',
        )
    );
    if ( ! empty( $plugin_data['version'] ) ) {
        define( 'ROYAL_ADDONS_VERSION', $plugin_data['version'] );
    } else {
        define('ROYAL_ADDONS_VERSION', '26.11.11');
    }
}

define('ROYALADDONSFILE', __FILE__);
define('ROYAL_ADDONS_DIR_PATH', plugin_dir_path(ROYALADDONSFILE));
define('ROYAL_ADDONS_DIR_URL', plugin_dir_url(ROYALADDONSFILE));

define('ROYAL_ADDONS_ASSETS', trailingslashit(ROYAL_ADDONS_DIR_URL . 'assets'));
define('ROYAL_HF_CORE_DIR', trailingslashit( ROYAL_ADDONS_DIR_PATH . 'includes/royal-hf/' ) );
define('ROYAL_MEGA_MENU_PATH', ROYAL_ADDONS_DIR_PATH . 'includes/royal-megamenu/');
define('ROYAL_MEGA_MENU_URL', ROYAL_ADDONS_DIR_URL . 'includes/royal-megamenu/');
define('ROYAL_LAYOUT_DIR', trailingslashit( ROYAL_ADDONS_DIR_PATH . 'includes/royal-layout' ) );
define('ROYAL_LAYOUT_URL', trailingslashit( ROYAL_ADDONS_DIR_URL . 'includes/royal-layout' ) );

// Load Global Functions and Helpers
require_once ROYAL_ADDONS_DIR_PATH . 'includes/functions.php';

// Load Custom Fonts specific loader (contains global functions and hooks)
require_once ROYAL_ADDONS_DIR_PATH . 'includes/custom-fonts/loader.php';

// Register global hooks for custom fonts loader functions
spl_autoload_register( 'royal_addons_custom_fonts_autoload' );
add_action( 'plugins_loaded', 'royal_addons_custom_fonts_initialize', 10 );
register_activation_hook( ROYALADDONSFILE, 'royal_addons_custom_fonts_activate' );
register_deactivation_hook( ROYALADDONSFILE, 'royal_addons_custom_fonts_deactivate' );

// Instantiate the main plugin class
require_once ROYAL_ADDONS_DIR_PATH . 'includes/class-main-plugin.php';
new Royal_Addons_for_Elementor();

require_once ROYAL_ADDONS_DIR_PATH . 'includes/royal-snippet/loader.php';

// Load Royal Templates Library
require_once ROYAL_ADDONS_DIR_PATH . 'includes/royal-templates/class-template-library.php';