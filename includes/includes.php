<?php
namespace RoyalAddons;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * Manages loading all plugin files.
 */
class Royal_Includes_Loader {

    /**
     * Includes all necessary plugin files.
     * This function is hooked into 'init' to run at the correct time.
     */
    public function load_all_files() {
        // Files from the main plugin file's init() method
        require_once ROYAL_ADDONS_DIR_PATH . 'includes/infinitescroll.php';
        require_once ROYAL_ADDONS_DIR_PATH . 'includes/helpers.php';
        require_once ROYAL_ADDONS_DIR_PATH . 'admin/admin.php';
        require_once ROYAL_ADDONS_DIR_PATH . 'elementor.php';
        require_once ROYAL_ADDONS_DIR_PATH . 'includes/traits/ProWidgetTrait.php';
        require_once ROYAL_ADDONS_DIR_PATH . 'includes/elementor-ajax.php';
        require_once ROYAL_ADDONS_DIR_PATH . 'includes/tweak.php';

        // Files from the old filesinclude() method in elementor.php
        
        // Extensions
        $extention_lists = require ROYAL_ADDONS_DIR_PATH . 'admin/royalextentionslist.php';
        if ( is_array( $extention_lists ) && isset( $extention_lists['free'], $extention_lists['pro'] ) ) {
            foreach (['free', 'pro'] as $type) {
                if (!empty($extention_lists[$type])) {
                    foreach ($extention_lists[$type] as $extention => $data) {
                        if (get_option($extention) != 1) {
                            if ($type === 'pro' && (!defined('ROYAL_ADDONS_PRO_ACTIVE') || ROYAL_ADDONS_PRO_ACTIVE !== true)) {
                                continue;
                            }
                            include ROYAL_ADDONS_DIR_PATH . 'extensions/' . $extention . '.php';
                        }
                    }
                }
            }
        }
        
        // Common Classes
        include ROYAL_ADDONS_DIR_PATH. 'class/royalclass.php';
        include ROYAL_ADDONS_DIR_PATH. 'class/royalclone.php';
        include ROYAL_ADDONS_DIR_PATH. 'class/royalnavmenuwalker.php';

        require_once ROYAL_ADDONS_DIR_PATH . 'includes/presets.php';
        require_once ROYAL_ADDONS_DIR_PATH . 'includes/royal-hf/loader.php';
        require_once ROYAL_ADDONS_DIR_PATH . 'includes/royal-layout/loader.php';
        require_once ROYAL_ADDONS_DIR_PATH . 'includes/royal-slide/loader.php';
        require_once ROYAL_ADDONS_DIR_PATH . 'includes/royal-social-login.php';

        // Woo Commerce Class
        if (! function_exists( 'is_woocommerce_activated' ) ) {
            include ROYAL_ADDONS_DIR_PATH. 'class/royalwooclass.php';
        }
    }
}