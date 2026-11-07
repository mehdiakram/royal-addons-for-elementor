<?php
// wp-content/plugins/royal-addons-for-elementor/includes/royal-megamenu/public/royal-mega-menu-terms.php
if ( ! defined( 'ABSPATH' ) ) exit;

class Royal_Mega_Menu_Term_Meta{

    /**
     * Singleton
     */
    private static $_instance = null;
    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * Constructor
     */
    private function __construct(){

        add_filter( 'wp_setup_nav_menu_item', [ $this, 'custom_nav_fields_data' ] );
        add_filter('wp_nav_menu_args', [ $this, '_change_nav_menu_args' ], PHP_INT_MAX);

    }

    public function custom_nav_fields_data( $menu_item ){

        // Get Menu Item Custom Data
        $item_settings = get_post_meta( $menu_item->ID, 'royal_mega_menu_settings', true );


        if( !empty( $item_settings['template_id'] ) ){
            $menu_item->template = $item_settings['template_id'];
        }
        // Attach all custom settings for easier access in walker
        $menu_item->royal_mega_menu_settings = $item_settings;


        return $menu_item;
    }

    function _change_nav_menu_args( $args ){

        if ( is_admin() ) {
            return $args;
        }

        $current_theme_location = isset( $args['theme_location'] ) ? $args['theme_location'] : '';
        $menu_id = false;
        if ($current_theme_location) {
            $locations = get_nav_menu_locations();
            $menu_id = isset( $locations[ $current_theme_location ] ) ? $locations[ $current_theme_location ] : false;
        } elseif (isset($args['menu'])) {
            $menu_obj = wp_get_nav_menu_object($args['menu']);
            if ($menu_obj) {
                $menu_id = $menu_obj->term_id;
            }
        }

        if (!isset($menu_id) || !$menu_id) {
            return $args;
        }

        $menu = wp_get_nav_menu_object($menu_id);
        $settings = [];
        if ($menu) {
            $menu_slug = $menu->slug;
            $settings = get_option( 'royal_menu_settings_'.$menu_slug);
        }

        $enable_mega_menu_for_this_menu = isset ( $settings['enable_menu'] ) && $settings['enable_menu'] == 'on';
        $original_args = (array) $args;

        if ( $enable_mega_menu_for_this_menu ) {

            $submenu_parent_icon = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M201.4 406.6c12.5 12.5 32.8 12.5 45.3 0l192-192c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L224 338.7 54.6 169.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l192 192z"/></svg>';
            $vertical_menu_active_icon = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M502.6 278.6c12.5-12.5 12.5-32.8 0-45.3l-128-128c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L402.7 224 32 224c-17.7 0-32 14.3-32 32s14.3 32 32 32l370.7 0-73.4 73.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0l128-128z"/></svg>';

            // *** START: CORRECTED LOGIC FOR MENU CLASS ***
            // Get the existing menu class from the widget
            $existing_menu_class = $original_args['menu_class'] ?? '';
            
            // Prepare the mega menu's required classes
            $mega_menu_base_classes = 'menu royal-mega-menu default-nav';

            $mega_menu_args = [
                'container_class' => 'menu-wrapper royal-menu-container royal-menu-area',
                'fallback_cb'     => false,
                'walker'          => new Royal_Mega_Nav_Walker(),
                'submenu_parent_icon' => $submenu_parent_icon,
                'vertical_menu_active_icon' => $vertical_menu_active_icon,
                'pointer_hover_effect' => 'none',
            ];

            // Combine the existing class with the mega menu classes
            $mega_menu_args['menu_class'] = trim($existing_menu_class . ' ' . $mega_menu_base_classes);
            // *** END: CORRECTED LOGIC ***

            $args = array_merge($original_args, $mega_menu_args);

            return apply_filters( 'royal_megamenu_nav_menu_args', $args );

        } else {
            return $original_args;
        }

    }
}
Royal_Mega_Menu_Term_Meta::instance();