<?php
// wp-content/plugins/royal-addons-for-elementor/includes/royal-megamenu/class-royal-mega-menu.php
if ( ! defined( 'ABSPATH' ) ) exit;

class Royal_Mega_Menu {

    private static $_instance = null;

    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function __construct() {
        require_once ROYAL_MEGA_MENU_PATH . 'admin/admin-ajax-request.php';
        require_once ROYAL_MEGA_MENU_PATH . 'admin/menu-metabox.php';
        require_once ROYAL_MEGA_MENU_PATH . 'public/royal-mega-nav-walker.php';
        require_once ROYAL_MEGA_MENU_PATH . 'public/royal-mega-menu-terms.php';
        require_once ROYAL_MEGA_MENU_PATH . 'public/plugin-scripts.php';
        require_once ROYAL_MEGA_MENU_PATH . 'admin/plugin-scripts.php';
    }

}