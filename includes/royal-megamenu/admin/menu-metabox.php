<?php
// wp-content/plugins/royal-addons-for-elementor/includes/royal-megamenu/admin/menu-metabox.php
if ( ! defined( 'ABSPATH' ) ) exit;

if ( !class_exists('Royal_Mega_Menu_Metabox')) {
    class Royal_Mega_Menu_Metabox {

        function __construct(){
            // *** START: CORRECTED HOOK ***
            // Use 'current_screen' which is the correct hook for checking the admin page
            add_action( 'current_screen', array($this, 'load_on_correct_page') );
            // *** END: CORRECTED HOOK ***

            add_action( "wp_ajax_royal_get_menu_switch", array ( $this, 'royal_get_menu_switch' ) );
        }

        // The callback function now uses the screen object passed by the hook
        public function load_on_correct_page( $current_screen ){
            // Only add the actions if we are on the nav-menus page
            if ( 'nav-menus' === $current_screen->id ) {
                add_action( 'admin_footer', array($this, 'royal_mega_menu_nav_contents_script') );
                add_action( 'admin_footer', array( $this, 'royal_mega_menu_pop_up_content' ) );
            }
        }

        public function royal_get_menu_switch (){
            check_ajax_referer('royal_mega_menu_nonce', 'nonce');

            $selected_menu_id = isset( $_REQUEST['menu_id'] ) ? absint( $_REQUEST['menu_id'] ) : 0;
            $menu = wp_get_nav_menu_object($selected_menu_id);
            $royal_menu_options_switch = '';

            if ($menu) {
                $menu_slug = $menu->slug;
                $royal_menu_options = get_option( 'royal_menu_settings_'.$menu_slug);
                $royal_menu_options_switch = isset($royal_menu_options['enable_menu']) ? $royal_menu_options['enable_menu'] : '';
            }
            ?>
                <div class="royal-mega-menu-switch-wrapper">
                    <div class="ajax-loader">
                        <div class="ajax-loader-spin"></div>
                    </div>
                    <label class="menu-item-title">
                        <input
                        type="checkbox"
                        class="menu-item-checkbox royal_mega_menu_switch"
                        name="royal_mega_menu_switch"
                        value="<?php echo esc_attr( $royal_menu_options_switch == 'on' ? 'on' : '' ) ?>" <?php echo esc_attr( $royal_menu_options_switch == 'on' ? 'checked' : '' ) ?>>
                            Enable Royal Mega Menu
                    </label>
                    <p><input type="submit" class="button button-primary button-large save-royal-mega-menu" value="Save"></p>
                    </div>
            <?php

            wp_die();

        }

        public function royal_mega_menu_nav_contents_script() {
            ?>
            <script>
                (function($){
                    $(document).ready(function () {
                        let seleceted_menu = $('input[name="menu"]').val();
                        $.ajax({
                            type: 'POST',
                            url: royal_mega_menu_ajax.ajaxurl,
                            data: {
                                action          : "royal_get_menu_switch",
                                menu_id         : seleceted_menu,
                                nonce : royal_mega_menu_ajax.nonce,
                            },
                            cache: false,
                            success: function(response) {
                                $('#menu-management').append(response);
                                let checkRoyalMegaMneu = $('input.royal_mega_menu_switch').val();

                                if(checkRoyalMegaMneu == 'on'){
                                    $('#menu-to-edit li').each(function () {
                                        let menuItemId = $(this).find('.menu-item-checkbox').attr('data-menu-item-id');
                                        $(this).addClass('has-royal-mega-menu');
                                        $(this).find('label.item-title').append('<span class="royal-mega-menu-opener" data-menu_item_id="'+menuItemId+'"><span class="dashicons dashicons-welcome-widgets-menus"></span>Royal Mega Menu</span>')

                                        let royalMegaMenuOpener =  $(this).find('.royal-mega-menu-opener');
                                        $.ajax({
                                            type: 'POST',
                                            url: royal_mega_menu_ajax.ajaxurl,
                                            data: {
                                                action          : "royal_check_menu_item_mega_status",
                                                menu_item_id    : menuItemId,
                                                nonce : royal_mega_menu_ajax.nonce,
                                            },
                                            cache: false,
                                            success: function(response) {
                                                if(response.success && response.data && response.data.enable_mega_menu == 'on'){
                                                    $(royalMegaMenuOpener).addClass('has-mega-menu-content');
                                                }
                                            }
                                        });
                                    })
                                }
                            }
                        });
                    });
                })(jQuery);
            </script>
        <?php }

        public function royal_mega_menu_pop_up_content(){
            ob_start();
            $contents = ob_get_clean();
            ?>
                <div id="royal-mega-menu-setting-modal" style="display: none;">
                    <div class="royal-mega-menu-overlay"></div>
                    <div class="royal-modal-body">
                        <div class="ajax-loader">
                            <div class="ajax-loader-spin"></div>
                        </div>
                        <button type="button" class="royal-mega-menu-modal-closer"><span class="dashicons dashicons-no"></span></button>
                        <div class="royal-modal-content">
                                <div class="tabs">
                                    <ul id="tabs-nav">
                                        <li><a href="#tab1">Content Template</a></li>
                                        <li><a href="#tab2">Style</a></li>
                                    </ul> <div class="tab-contents-wrapper">
                                    </div>
                                    <p class="form-status"></p>
                                    <div class="tab-footer">
                                        <button type="button" data-action="save" class="button save-royal-menu-item-options">Save</button>
                                        <button type="button" data-action="save-close" class="button save-royal-menu-item-options">Save & Close</button>
                                        <button type="button" data-action="disable" class="button disable-royal-mega-menu-item">Disable Mega Menu</button>
                                    </div>
                                </div> </div>
                    </div>
                </div>
            <?php
            echo esc_html($contents);
        }
    }
    $Royal_Mega_Menu_Metabox = new Royal_Mega_Menu_Metabox();
}