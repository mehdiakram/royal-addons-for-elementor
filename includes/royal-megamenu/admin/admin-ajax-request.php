<?php
// wp-content/plugins/royal-addons-for-elementor/includes/royal-megamenu/admin/admin-ajax-request.php
if ( ! defined( 'ABSPATH' ) ) exit;

class Royal_Mega_Menu_Admin_Ajax {
    function __construct(){
        add_action( "wp_ajax_royal_update_menu_options", array ( $this, 'royal_update_menu_options' ) );
        add_action( "wp_ajax_royal_get_menu_options", array ( $this, 'royal_get_menu_options' ) );
        add_action( "wp_ajax_royal_check_menu_item_mega_status", array ( $this, 'royal_check_menu_item_mega_status' ) );
        add_action( "wp_ajax_royal_delete_menu_options", array ( $this, 'royal_delete_menu_options' ) );
    }

    public function royal_update_menu_options() {
        check_ajax_referer('royal_mega_menu_nonce', 'nonce');

        if (!isset($_POST['actualAction'])) {
            wp_send_json_error(['message' => esc_html__('Invalid request.', 'royal-mega-menu')]);
            wp_die();
        }

        $actual_action = sanitize_text_field($_POST['actualAction']);
        $menu_id = absint($_POST['menu_id']);

        if ($actual_action === 'saveMenuOptions') {
            $menu = wp_get_nav_menu_object($menu_id);
            if ($menu) {
                $menu_slug = $menu->slug;
                $settings = isset($_POST['settings']) ? array_map('sanitize_text_field', (array)$_POST['settings']) : [];
                update_option("royal_menu_settings_$menu_slug", $settings);
            }
        } else { // saveMenuItemSettings
            if (!isset($_POST['menu_item_id'])) {
                wp_send_json_error(['message' => esc_html__('Menu item ID is missing.', 'royal-mega-menu')]);
                wp_die();
            }

            $menu_item_id = absint($_POST['menu_item_id']);
            $settings_content = !empty($_POST['settings']) ? (array)$_POST['settings'] : [];
            $css_settings = !empty($_POST['css']) ? (array)$_POST['css'] : [];

            $sanitized_settings = [];
            foreach ($settings_content as $key => $value) {
                $sanitized_settings[$key] = sanitize_text_field($value);
            }

            // Sanitize and include new CSS fields
            $sanitized_css = [];
            foreach ($css_settings as $key => $value) {
                // Allow specific CSS properties to be saved directly
                if (in_array($key, ['left', 'right', 'top', 'width', 'background_color'])) {
                    $sanitized_css[$key] = sanitize_text_field($value);
                } elseif ($key === 'full_width' || $key === 'hide_submenu_icon') { // Checkbox values
                    $sanitized_css[$key] = sanitize_text_field($value);
                } else {
                    // Fallback for any other unexpected keys, though they shouldn't appear with proper forms
                    $sanitized_css[$key] = sanitize_text_field($value);
                }
            }


            $final_settings = [
                'enable_mega_menu' => $sanitized_settings['enable_mega_menu'] ?? 'off',
                'template_id'      => $sanitized_settings['template_id'] ?? '',
                'css'              => $sanitized_css,
            ];

            update_post_meta($menu_item_id, 'royal_mega_menu_settings', $final_settings);
        }

        wp_send_json_success(['message' => esc_html__('Successfully saved data.', 'royal-mega-menu')]);
        wp_die();
    }

    public function royal_delete_menu_options() {
        check_ajax_referer('royal_mega_menu_nonce', 'nonce');
        if(isset($_POST['menu_item_id'])){
            $menu_item_id = sanitize_text_field($_POST['menu_item_id']);
            $royal_mega_menu_item_settings = get_post_meta( $menu_item_id, 'royal_mega_menu_settings', true );

            if(isset($royal_mega_menu_item_settings)){
                delete_post_meta( $menu_item_id, 'royal_mega_menu_settings' );
                wp_send_json_success( ['message' => esc_html__('Settings Deleted!', 'royal-mega-menu')], 200 );
            }else{
                wp_send_json_error( ['message' => esc_html__('Settings not found!', 'royal-mega-menu')], 404 );
            }
        }
        wp_die();
    }

    public function royal_get_menu_options() {
        check_ajax_referer('royal_mega_menu_nonce', 'nonce');

        if(isset($_POST['menu_item_id'])){
            $menu_item_id = sanitize_text_field($_POST['menu_item_id']);

            $royal_menu_item_settings = get_post_meta($menu_item_id, 'royal_mega_menu_settings', true);

            $selected_template = $royal_menu_item_settings['template_id'] ?? '';
            $css_settings = $royal_menu_item_settings['css'] ?? [];
            $enable_mega_menu = $royal_menu_item_settings['enable_mega_menu'] ?? '';

            $bg_color = $css_settings['background_color'] ?? '';
            // Note: The name 'hide_submenu_icon' is kept for backward compatibility, but the label is 'Show'.
            $hide_submenu_icon = $css_settings['hide_submenu_icon'] ?? 'off';


            $elementor_library_query = new WP_Query([
                'post_type' => 'elementor_library',
                'posts_per_page' => -1,
                'orderby' => 'title',
                'order' => 'ASC'
            ]);

            ?>
            <div id="tabs-content">
                <div id="tab1" class="tab-content">
                    <h2>Select a template</h2>
                    <form action="" onsubmit="return false" id='royal_mega_menu_items_settings'>
                        <ul class="royal-menu-option-input-list">
                            <li>
                                <label>
                                    <input type="checkbox" name="enable_mega_menu" value="on" <?php checked($enable_mega_menu, 'on'); ?>> Enable Mega Menu for this item
                                </label>
                            </li>
                            <li>
                                <?php if($elementor_library_query->have_posts()){ ?>
                                    <select name="template_id" id="royal-template-select">
                                        <option value="">Select Template</option>
                                        <?php
                                        while ($elementor_library_query->have_posts()) {
                                            $elementor_library_query->the_post();
                                            ?>
                                            <option value="<?php echo esc_attr(get_the_ID());?>" <?php selected($selected_template, get_the_ID()); ?> ><?php the_title();?></option>
                                            <?php
                                        }
                                        wp_reset_postdata();
                                        ?>
                                    </select>
                                <?php } else { ?>
                                    <strong class="royal-text-danger ">Ops! Templates not found. <a href="<?php echo esc_url(admin_url('edit.php?post_type=elementor_library&tabs_group=library')) ?>" title="Click here to create a template.">Create</a> a new template.</strong>
                                <?php } ?>
                                <?php if($elementor_library_query->have_posts()){ ?>
                                    <a href="<?php echo esc_url(admin_url('post.php?post='.$selected_template.'&action=elementor')) ?>" id="edit-royal-selected-template" class="button" target="_blank">Edit Template</a>
                                <?php } ?>
                            </li>
                        </ul>
                    </form>
                </div>
                <div id="tab2" class="tab-content" style="display: none;">
                    <h2>Custom Styles</h2>
                    <form action="" onsubmit="return false" id='royal_mega_menu_items_css'>
                        <ul class="royal-menu-option-input-list">
                            <li>
                                <div class="option-label">Position : </div>
                                <div class="option-inputs">
                                    <label>
                                        <strong>Left (ex: 100px or 100%)</strong>
                                        <input type="text" name="left" value="<?php echo esc_attr($css_settings['left'] ?? ''); ?>">
                                    </label>
                                    <label>
                                        <strong>Right (ex: 100px or 100%)</strong>
                                        <input type="text" name="right" value="<?php echo esc_attr($css_settings['right'] ?? ''); ?>">
                                    </label>
                                    <label>
                                        <strong>Top (ex: 100px or 100%)</strong>
                                        <input type="text" name="top" value="<?php echo esc_attr($css_settings['top'] ?? ''); ?>">
                                    </label>
                                </div>
                            </li>
                            <li>
                                <div class="option-label">Mega Menu Size : </div>
                                <div class="option-inputs">
                                    <label>
                                        <strong>Width (ex: 100px or 100%)</strong>
                                        <input type="text" name="width" value="<?php echo esc_attr($css_settings['width'] ?? ''); ?>">
                                    </label>
                                    <label>
                                        <strong>Full Width</strong>
                                        <input type="checkbox" class="menu-item-checkbox royal_full_width_switch" name="full_width" value="on" <?php checked($css_settings['full_width'] ?? '', 'on'); ?>>
                                    </label>
                                </div>
                            </li>
                            <li>
                                <div class="option-label">Submenu Background : </div>
                                <div class="option-inputs">
                                    <label>
                                        <strong>Color</strong>
                                        <input type="text" class="royal-color-picker" name="background_color" value="<?php echo esc_attr($bg_color); ?>">
                                    </label>
                                </div>
                            </li>
                            <li>
                                <div class="option-label">Submenu Icon : </div>
                                <div class="option-inputs">
                                    <label>
                                        <input type="checkbox" class="menu-item-checkbox royal_hide_submenu_icon_switch" name="hide_submenu_icon" value="on" <?php checked($hide_submenu_icon, 'on'); ?>>
                                    </label>
                                </div>
                            </li>
                        </ul>
                    </form>
                </div>
            </div>
            <script>
                (function($){
                    // *** START: NEW LOGIC FOR FULL WIDTH CHECKBOX ***
                    var fullWidthCheckbox = $('.royal_full_width_switch');
                    var widthInput = $('input[name="width"]');

                    function toggleWidthInput() {
                        if (fullWidthCheckbox.is(':checked')) {
                            widthInput.prop('disabled', true);
                        } else {
                            widthInput.prop('disabled', false);
                        }
                    }

                    // Set initial state on load
                    toggleWidthInput();
                    
                    // Handle change event
                    fullWidthCheckbox.on('change', function() {
                        if($(this).prop('checked')) {
                            $(this).val('on');
                        } else {
                            $(this).val('off');
                        }
                        toggleWidthInput();
                    });
                    // *** END: NEW LOGIC ***

                    $(".royal_hide_submenu_icon_switch").change(function() {
                        if($(this).prop('checked')) { $(this).val('on'); } else { $(this).val('off'); }
                    });

                    if (typeof $.fn.wpColorPicker === 'function') {
                        $('.royal-color-picker').wpColorPicker();
                    }
                })(jQuery);
            </script>
            <?php
        }
        wp_die();
    }

    public function royal_check_menu_item_mega_status() {
        check_ajax_referer('royal_mega_menu_nonce', 'nonce');
        if ( isset( $_POST['menu_item_id'] ) ) {
            $menu_item_id = absint( $_POST['menu_item_id'] );
            $settings = get_post_meta( $menu_item_id, 'royal_mega_menu_settings', true );
            if ( ! empty( $settings ) && isset( $settings['enable_mega_menu'] ) && $settings['enable_mega_menu'] == 'on' ) {
                wp_send_json_success( [ 'enable_mega_menu' => 'on' ] );
            } else {
                wp_send_json_success( [ 'enable_mega_menu' => 'off' ] );
            }
        }
        wp_send_json_error( [ 'message' => 'Invalid Request' ] );
        wp_die();
    }
}
// Correct placement: OUTSIDE the class definition
new Royal_Mega_Menu_Admin_Ajax();