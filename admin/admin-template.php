<?php
// admin-template.php

// Ensure functions.php is loaded where royaladdons_is_license_valid is defined.
// Assuming it's already loaded by the main plugin.
$saved_license = get_option('royaladdons_license_key', '');
$is_valid_license = false;

if ($saved_license && function_exists('royaladdons_is_license_valid')) {
    $is_valid_license = royaladdons_is_license_valid($saved_license);
}

// Mask the license key for display (show first 4 and last 4 characters)
$masked_license = '';
if ($saved_license && strlen($saved_license) > 8) {
    $masked_license = substr($saved_license, 0, 4) . str_repeat('*', strlen($saved_license) - 8) . substr($saved_license, -4);
} elseif ($saved_license) {
    $masked_license = str_repeat('*', strlen($saved_license));
}

// Load current tweak settings
// Assuming royal_addons_get_tweak_settings is loaded from includes/tweak.php via includes/includes.php
$tweak_settings = function_exists('royal_addons_get_tweak_settings') ? royal_addons_get_tweak_settings() : array();
$disable_dashboard_widget_checked = isset( $tweak_settings['disable_elementor_dashboard_widget'] ) && $tweak_settings['disable_elementor_dashboard_widget'] === 'yes' ? 'checked' : '';
$disable_default_colors_checked = isset( $tweak_settings['disable_elementor_default_colors'] ) && $tweak_settings['disable_elementor_default_colors'] === 'yes' ? 'checked' : '';
$disable_default_fonts_checked = isset( $tweak_settings['disable_elementor_default_fonts'] ) && $tweak_settings['disable_elementor_default_fonts'] === 'yes' ? 'checked' : '';
$disable_font_awesome_4_checked = isset( $tweak_settings['disable_elementor_font_awesome_4'] ) && $tweak_settings['disable_elementor_font_awesome_4'] === 'yes' ? 'checked' : '';
$disable_lightbox_checked = isset( $tweak_settings['disable_elementor_lightbox'] ) && $tweak_settings['disable_elementor_lightbox'] === 'yes' ? 'checked' : '';
$disable_go_pro_notices_checked = isset( $tweak_settings['disable_elementor_go_pro_notices'] ) && $tweak_settings['disable_elementor_go_pro_notices'] === 'yes' ? 'checked' : '';

?>

<div class="royaladdonadminwrapper">
    <div class="pageheading">
        <h1 class="pagetitle"><?php _e( 'Royal Addons for Elementor', 'royal-addons-for-elementor' ); ?></h1>
        <p class="pagedescription"><?php _e( 'Premium Quality Elements for Elementor', 'royal-addons-for-elementor' ); ?></p>
        <span class="royal-version-badge">v<?php echo esc_html( ROYAL_ADDONS_VERSION ); ?></span>
    </div>
    <div class="royalsettingstabs">
        <ul class="tabs">
            <?php if ( ! $is_valid_license ) : ?>
            <li class="active"><a href="#license"><span class="dashicons dashicons-admin-network"></span> License</a></li>
            <?php endif; ?>
            <li class="<?php echo $is_valid_license ? 'active' : ''; ?>"><a href="#widgetfree"><span class="dashicons dashicons-screenoptions"></span> Free Widgets</a></li>
            <li><a href="#widgetpro"><span class="dashicons dashicons-star-filled"></span> Pro Widgets</a></li>
            <li><a href="#extentionfree"><span class="dashicons dashicons-admin-plugins"></span> Free Extensions</a></li>
            <li><a href="#extentionpro"><span class="dashicons dashicons-awards"></span> Pro Extensions</a></li>
            <li><a href="#tweak"><span class="dashicons dashicons-admin-tools"></span> Tweak</a></li>
            <li><a href="#documentation"><span class="dashicons dashicons-media-document"></span> Documentation</a></li>
            <li><a href="#aboutus"><span class="dashicons dashicons-info-outline"></span> About Us</a></li>
            <?php if ( $is_valid_license ) : ?>
            <li><a href="#license"><span class="dashicons dashicons-admin-network"></span> License</a></li>
            <?php endif; ?>
        </ul>

        <div class="tabcontainer">

            <div id="license" class="tabcontent" style="display: <?php echo ! $is_valid_license ? 'block' : 'none'; ?>;">
                <div class="tab-content-inner">
                    <h3><?php _e('License Activation', 'royal-addons-for-elementor'); ?></h3>
                    <p><?php _e('Enter your license key to unlock all premium features and receive automatic updates.', 'royal-addons-for-elementor'); ?></p>
                    
                    <div class="royal-license-box">
                        <div class="royal-input-group">
                            <label for="license_key" style="display:block; margin-bottom:8px; font-weight:600; color:#334155;">
                                <?php _e('License Key', 'royal-addons-for-elementor'); ?>
                            </label>
                            <?php if ($is_valid_license && $masked_license): ?>
                                <!-- Show masked license when valid -->
                                <input type="text" 
                                    id="license_key_display" 
                                    value="<?php echo esc_attr($masked_license); ?>" 
                                    class="royal-input-field"
                                    readonly
                                    style="background: #f0fdf4; border-color: #86efac; color: #166534;">
                                <input type="hidden" id="license_key" value="">
                            <?php else: ?>
                                <input type="password" 
                                    id="license_key" 
                                    value="<?php echo esc_attr($saved_license); ?>" 
                                    placeholder="<?php esc_attr_e('XXXX-XXXX-XXXX-XXXX', 'royal-addons-for-elementor'); ?>" 
                                    class="royal-input-field">
                            <?php endif; ?>
                        </div>
                        
                        <div id="license_status" class="royal-status-message" style="color: <?php echo $is_valid_license ? '#059669' : '#dc2626'; ?>">
                            <?php 
                                if (!$saved_license) {
                                    echo '<span class="dashicons dashicons-info-outline"></span> ' . __('Please enter your license key.', 'royal-addons-for-elementor');
                                } else {
                                    if ($is_valid_license) {
                                        echo '<span class="dashicons dashicons-yes-alt"></span> ' . __('License is valid and active.', 'royal-addons-for-elementor');
                                    } else {
                                        echo '<span class="dashicons dashicons-warning"></span> <strong>' . __('License is invalid or expired!', 'royal-addons-for-elementor') . '</strong>';
                                    }
                                }
                            ?>
                        </div>
                        
                        <div style="margin-top: 25px; display:flex; align-items:center; gap:12px; flex-wrap:wrap;">
                            <?php if ($is_valid_license): ?>
                                <button type="button" id="save_license" class="button royal-activated-btn" disabled>
                                    <span class="dashicons dashicons-yes-alt" style="margin-top:3px;"></span>
                                    <?php _e('License Activated', 'royal-addons-for-elementor'); ?>
                                </button>
                                <button type="button" id="deactivate_license" class="button royal-deactivate-btn">
                                    <span class="dashicons dashicons-no-alt" style="margin-top:3px; font-size:16px;"></span>
                                    <?php _e('Deactivate License', 'royal-addons-for-elementor'); ?>
                                </button>
                            <?php else: ?>
                                <button type="button" id="save_license" class="button button-primary royal-save-button">
                                    <span class="dashicons dashicons-saved" style="margin-top:3px;"></span>
                                    <?php _e('Activate License', 'royal-addons-for-elementor'); ?>
                                </button>
                            <?php endif; ?>
                        </div>
                        <div id="license_message" class="royal-ajax-message"></div>
                    </div>
                </div>
            </div>

            <div id="widgetfree" class="tabcontent" style="display: <?php echo $is_valid_license ? 'block' : 'none'; ?>;">
                <div class="tab-content-inner">
                    <div class="royal-bulk-actions">
                        <h3><?php _e('Free Widgets', 'royal-addons-for-elementor'); ?></h3>
                        <div style="display:flex; align-items:center; gap:10px;">
                            <input type="text" class="royal-item-search" placeholder="<?php _e('Search...', 'royal-addons-for-elementor'); ?>" style="padding: 5px 10px; border-radius: 4px; border: 1px solid #ccc; max-width: 200px;">
                            <button type="button" class="button royal-enable-all" data-target=".royal-widget-free-toggle"><?php _e('Enable All', 'royal-addons-for-elementor'); ?></button>
                            <button type="button" class="button royal-disable-all" data-target=".royal-widget-free-toggle"><?php _e('Disable All', 'royal-addons-for-elementor'); ?></button>
                        </div>
                    </div>
                    <?php 
                        $widget_lists = require ROYAL_ADDONS_DIR_PATH . 'admin/royalwidgetslist.php';

                        if ( ! is_array( $widget_lists ) || ! isset( $widget_lists['free'], $widget_lists['pro'] ) ) {
                            error_log( 'royalwidgetslist.php did not return a valid widget list.' );
                            echo '<div class="notice notice-error is-dismissible"><p>' . __( 'Widget list could not be loaded.', 'royal-addons-for-elementor' ) . '</p></div>';
                            $free_widgets = [];
                        } else {
                            $free_widgets = $widget_lists['free'];
                        }
                    ?>
                    <div class="royalwidgetextensionlist">
                        <?php foreach ($free_widgets as $key => $widget): 
                            $widget_key = strtolower($key);
                            $is_enabled = get_option($widget_key) != 1;
                        ?>
                            <div class="royal-item-card">
                                <div class="royal-item-header">
                                    <strong><?php echo esc_html($widget['title']); ?></strong>
                                    <label class="royal-toggle-switch">
                                        <input type="checkbox" class="royal-widget-free-toggle royal-item-toggle" data-key="<?php echo esc_attr($widget_key); ?>" <?php echo $is_enabled ? 'checked' : ''; ?>>
                                        <span class="royal-toggle-slider"></span>
                                    </label>
                                </div>
                                <small><?php echo esc_html($widget['description']); ?></small><br>
                                <a href="<?php echo esc_url($widget['url']); ?>" target="_blank" rel="noopener noreferrer"><?php _e('Learn More', 'royal-addons-for-elementor'); ?></a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="royal-save-actions">
                        <button type="button" id="save_widgets_settings" class="button button-primary royal-save-button">
                            <span class="dashicons dashicons-saved" style="margin-top:3px;"></span>
                            <?php _e('Save Changes', 'royal-addons-for-elementor'); ?>
                        </button>
                    </div>
                </div>
            </div>            
            
            <div id="widgetpro" class="tabcontent" style="display: none;">
                <div class="tab-content-inner">
                    <div class="royal-bulk-actions">
                        <h3><?php _e('Pro Widgets', 'royal-addons-for-elementor'); ?></h3>
                        <div style="display:flex; align-items:center; gap:10px;">
                            <input type="text" class="royal-item-search" placeholder="<?php _e('Search...', 'royal-addons-for-elementor'); ?>" style="padding: 5px 10px; border-radius: 4px; border: 1px solid #ccc; max-width: 200px;">
                            <button type="button" class="button royal-enable-all" data-target=".royal-widget-pro-toggle"><?php _e('Enable All', 'royal-addons-for-elementor'); ?></button>
                            <button type="button" class="button royal-disable-all" data-target=".royal-widget-pro-toggle"><?php _e('Disable All', 'royal-addons-for-elementor'); ?></button>
                        </div>
                    </div>
                    <div class="royalwidgetextensionlist">
                        <?php 
                            if ( ! is_array( $widget_lists ) || ! isset( $widget_lists['free'], $widget_lists['pro'] ) ) {
                                $pro_widgets = [];
                            } else {
                                $pro_widgets = $widget_lists['pro'];
                            }
                        ?>
                        <?php foreach ($pro_widgets as $key => $widget): 
                            $widget_key = strtolower($key);
                            $is_enabled = get_option($widget_key) != 1;
                        ?>
                            <div class="royal-item-card">
                                <div class="royal-item-header">
                                    <strong><?php echo esc_html($widget['title']); ?> <span class="dashicons dashicons-star-filled" style="color:#fbbf24; font-size: 16px; margin-top:2px;"></span></strong>
                                    <label class="royal-toggle-switch">
                                        <input type="checkbox" class="royal-widget-pro-toggle royal-item-toggle" data-key="<?php echo esc_attr($widget_key); ?>" <?php echo $is_enabled ? 'checked' : ''; ?>>
                                        <span class="royal-toggle-slider"></span>
                                    </label>
                                </div>
                                <small><?php echo esc_html($widget['description']); ?></small><br>
                                <a href="<?php echo esc_url($widget['url']); ?>" target="_blank" rel="noopener noreferrer"><?php _e('Learn More', 'royal-addons-for-elementor'); ?></a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="royal-save-actions">
                        <button type="button" id="save_widgets_pro_settings" class="button button-primary royal-save-button save_widgets_trigger">
                            <span class="dashicons dashicons-saved" style="margin-top:3px;"></span>
                            <?php _e('Save Changes', 'royal-addons-for-elementor'); ?>
                        </button>
                    </div>
                </div>
            </div>            
            
            <div id="extentionfree" class="tabcontent" style="display: none;">
                <div class="tab-content-inner">
                    <div class="royal-bulk-actions">
                        <h3><?php _e('Free Extensions', 'royal-addons-for-elementor'); ?></h3>
                        <div style="display:flex; align-items:center; gap:10px;">
                            <input type="text" class="royal-item-search" placeholder="<?php _e('Search...', 'royal-addons-for-elementor'); ?>" style="padding: 5px 10px; border-radius: 4px; border: 1px solid #ccc; max-width: 200px;">
                            <button type="button" class="button royal-enable-all" data-target=".royal-ext-free-toggle"><?php _e('Enable All', 'royal-addons-for-elementor'); ?></button>
                            <button type="button" class="button royal-disable-all" data-target=".royal-ext-free-toggle"><?php _e('Disable All', 'royal-addons-for-elementor'); ?></button>
                        </div>
                    </div>
                    <?php 
                        $extention_list = require ROYAL_ADDONS_DIR_PATH . 'admin/royalextentionslist.php';

                        if ( ! is_array( $extention_list ) || ! isset( $extention_list['free'], $extention_list['pro'] ) ) {
                            error_log( 'royalextentionslist.php did not return a valid extension list.' );
                            echo '<div class="notice notice-error is-dismissible"><p>' . __( 'Extension list could not be loaded.', 'royal-addons-for-elementor' ) . '</p></div>';
                            $free_extentions = [];
                        } else {
                            $free_extentions = $extention_list['free'];
                        }
                    ?>
                    <div class="royalwidgetextensionlist">
                        <?php foreach ($free_extentions as $key => $extention): 
                            $ext_key = strtolower($key);
                            $is_enabled = get_option($ext_key) != 1;
                        ?>
                            <div class="royal-item-card">
                                <div class="royal-item-header">
                                    <strong><?php echo esc_html($extention['title']); ?></strong>
                                    <label class="royal-toggle-switch">
                                        <input type="checkbox" class="royal-ext-free-toggle royal-item-toggle royal-ext-toggle" data-key="<?php echo esc_attr($ext_key); ?>" <?php echo $is_enabled ? 'checked' : ''; ?>>
                                        <span class="royal-toggle-slider"></span>
                                    </label>
                                </div>
                                <small><?php echo esc_html($extention['description']); ?></small><br>
                                <a href="<?php echo esc_url($extention['url']); ?>" target="_blank" rel="noopener noreferrer">
                                    <?php _e('Learn More', 'royal-addons-for-elementor'); ?>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="royal-save-actions">
                        <button type="button" id="save_extentions_settings" class="button button-primary royal-save-button save_extentions_trigger">
                            <span class="dashicons dashicons-saved" style="margin-top:3px;"></span>
                            <?php _e('Save Changes', 'royal-addons-for-elementor'); ?>
                        </button>
                    </div>
                </div>
            </div>            
            
            <div id="extentionpro" class="tabcontent" style="display: none;">
                <div class="tab-content-inner">
                    <div class="royal-bulk-actions">
                        <h3><?php _e('Pro Extensions', 'royal-addons-for-elementor'); ?></h3>
                        <div style="display:flex; align-items:center; gap:10px;">
                            <input type="text" class="royal-item-search" placeholder="<?php _e('Search...', 'royal-addons-for-elementor'); ?>" style="padding: 5px 10px; border-radius: 4px; border: 1px solid #ccc; max-width: 200px;">
                            <button type="button" class="button royal-enable-all" data-target=".royal-ext-pro-toggle"><?php _e('Enable All', 'royal-addons-for-elementor'); ?></button>
                            <button type="button" class="button royal-disable-all" data-target=".royal-ext-pro-toggle"><?php _e('Disable All', 'royal-addons-for-elementor'); ?></button>
                        </div>
                    </div>
                    <div class="royalwidgetextensionlist">
                        <?php 
                            if ( ! is_array( $extention_list ) || ! isset( $extention_list['free'], $extention_list['pro'] ) ) {
                                $pro_extentions = [];
                            } else {
                                $pro_extentions = $extention_list['pro'];
                            }
                        ?>
                        <?php foreach ($pro_extentions as $key => $extention): 
                            $ext_key = strtolower($key);
                            $is_enabled = get_option($ext_key) != 1;
                        ?>
                            <div class="royal-item-card">
                                <div class="royal-item-header">
                                    <strong><?php echo esc_html($extention['title']); ?> <span class="dashicons dashicons-star-filled" style="color:#fbbf24; font-size: 16px; margin-top:2px;"></span></strong>
                                    <label class="royal-toggle-switch">
                                        <input type="checkbox" class="royal-ext-pro-toggle royal-item-toggle royal-ext-toggle" data-key="<?php echo esc_attr($ext_key); ?>" <?php echo $is_enabled ? 'checked' : ''; ?>>
                                        <span class="royal-toggle-slider"></span>
                                    </label>
                                </div>
                                <small><?php echo esc_html($extention['description']); ?></small><br>
                                <a href="<?php echo esc_url($extention['url']); ?>" target="_blank" rel="noopener noreferrer">
                                    <?php _e('Learn More', 'royal-addons-for-elementor'); ?>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="royal-save-actions">
                        <button type="button" id="save_extentions_pro_settings" class="button button-primary royal-save-button save_extentions_trigger">
                            <span class="dashicons dashicons-saved" style="margin-top:3px;"></span>
                            <?php _e('Save Changes', 'royal-addons-for-elementor'); ?>
                        </button>
                    </div>
                </div>
            </div>
            
            <div id="tweak" class="tabcontent" style="display: none;">
                <div class="tab-content-inner">
                    <h3><?php _e('Elementor Tweaks', 'royal-addons-for-elementor'); ?></h3>
                    <p><?php _e('Optimize and customize Elementor behavior. Enable these options to improve performance and reduce unnecessary features.', 'royal-addons-for-elementor'); ?></p>
                    
                    <div class="royal-tweak-options">
                        <label for="royal_tweak_disable_dashboard_widget" class="royal-checkbox-label">
                            <input type="checkbox" id="royal_tweak_disable_dashboard_widget" name="disable_elementor_dashboard_widget" value="yes" <?php echo $disable_dashboard_widget_checked; ?>>
                            <span>
                                <strong><?php _e('Disable Dashboard Widget', 'royal-addons-for-elementor'); ?></strong>
                                <small style="display:block; color:#94a3b8; font-size:12px; margin-top:2px;"><?php _e('Remove Elementor overview widget from WordPress dashboard', 'royal-addons-for-elementor'); ?></small>
                            </span>
                        </label>
                        <label for="royal_tweak_disable_default_colors" class="royal-checkbox-label">
                            <input type="checkbox" id="royal_tweak_disable_default_colors" name="disable_elementor_default_colors" value="yes" <?php echo $disable_default_colors_checked; ?>>
                            <span>
                                <strong><?php _e('Disable Default Colors', 'royal-addons-for-elementor'); ?></strong>
                                <small style="display:block; color:#94a3b8; font-size:12px; margin-top:2px;"><?php _e('Use your theme colors instead of Elementor defaults', 'royal-addons-for-elementor'); ?></small>
                            </span>
                        </label>
                        <label for="royal_tweak_disable_default_fonts" class="royal-checkbox-label">
                            <input type="checkbox" id="royal_tweak_disable_default_fonts" name="disable_elementor_default_fonts" value="yes" <?php echo $disable_default_fonts_checked; ?>>
                            <span>
                                <strong><?php _e('Disable Default Fonts', 'royal-addons-for-elementor'); ?></strong>
                                <small style="display:block; color:#94a3b8; font-size:12px; margin-top:2px;"><?php _e('Prevent loading Roboto and other Elementor fonts', 'royal-addons-for-elementor'); ?></small>
                            </span>
                        </label>
                        <label for="royal_tweak_disable_font_awesome_4" class="royal-checkbox-label">
                            <input type="checkbox" id="royal_tweak_disable_font_awesome_4" name="disable_elementor_font_awesome_4" value="yes" <?php echo $disable_font_awesome_4_checked; ?>>
                            <span>
                                <strong><?php _e('Disable Font Awesome 4', 'royal-addons-for-elementor'); ?></strong>
                                <small style="display:block; color:#94a3b8; font-size:12px; margin-top:2px;"><?php _e('Enable if you are using Font Awesome 5 or 6', 'royal-addons-for-elementor'); ?></small>
                            </span>
                        </label>
                        <label for="royal_tweak_disable_lightbox" class="royal-checkbox-label">
                            <input type="checkbox" id="royal_tweak_disable_lightbox" name="disable_elementor_lightbox" value="yes" <?php echo $disable_lightbox_checked; ?>>
                            <span>
                                <strong><?php _e('Disable Lightbox', 'royal-addons-for-elementor'); ?></strong>
                                <small style="display:block; color:#94a3b8; font-size:12px; margin-top:2px;"><?php _e('Remove built-in lightbox functionality', 'royal-addons-for-elementor'); ?></small>
                            </span>
                        </label>
                        <label for="royal_tweak_disable_go_pro_notices" class="royal-checkbox-label">
                            <input type="checkbox" id="royal_tweak_disable_go_pro_notices" name="disable_elementor_go_pro_notices" value="yes" <?php echo $disable_go_pro_notices_checked; ?>>
                            <span>
                                <strong><?php _e('Disable "Go Pro" Notices', 'royal-addons-for-elementor'); ?></strong>
                                <small style="display:block; color:#94a3b8; font-size:12px; margin-top:2px;"><?php _e('Hide upgrade prompts in editor and dashboard', 'royal-addons-for-elementor'); ?></small>
                            </span>
                        </label>
                    </div>
                    
                    <div style="margin-top: 30px;">
                        <button type="button" id="save_tweak_settings" class="button button-primary royal-save-button">
                            <span class="dashicons dashicons-saved" style="margin-top:3px;"></span>
                            <?php _e('Save Settings', 'royal-addons-for-elementor'); ?>
                        </button>
                    </div>
                    <div id="tweak_message" class="royal-ajax-message"></div>
                </div>
            </div>

            <div id="documentation" class="tabcontent" style="display: none;">
                <div class="royal-addons-about-container">
                    <div class="royal-addons-about-section">
                        <h3><span class="dashicons dashicons-book"></span> <?php esc_html_e( 'Documentation & User Guide', 'royal-addons-for-elementor' ); ?></h3>
                        <p><?php esc_html_e( 'Read our comprehensive documentation to learn how to use Royal Addons for Elementor effectively. Our guide covers installation, widget usage, and advanced extensions.', 'royal-addons-for-elementor' ); ?></p>
                        <a href="<?php echo ROYAL_ADDONS_DIR_URL; ?>docs/index.html" target="_blank" class="button button-primary royal-save-button" style="text-decoration: none; margin-top: 15px; display: inline-flex !important; padding: 5px 20px; align-items: center; gap: 5px;">
                            <span class="dashicons dashicons-external" style="margin-top:2px;"></span>
                            <?php esc_html_e( 'View Full Documentation', 'royal-addons-for-elementor' ); ?>
                        </a>
                    </div>
                </div>
            </div>

            <div id="aboutus" class="tabcontent" style="display: none;">
                <div class="royal-addons-about-container">

                    <!-- Description -->
                    <div class="royal-addons-about-section">
                        <h3><span class="dashicons dashicons-info"></span> <?php esc_html_e( 'About This Plugin', 'royal-addons-for-elementor' ); ?></h3>
                        <p><?php esc_html_e( 'Royal Addons for Elementor is one of the best Elementor addons that comes with 100+ Free & Pro Widgets, Header/Footer Builder, Mega Menu, Custom Fonts, Custom CSS, and Code Snippets. Build stunning websites faster with our professionally designed elements.', 'royal-addons-for-elementor' ); ?></p>
                    </div>

                    <!-- Features Grid -->
                    <div class="royal-addons-about-section">
                        <h3><span class="dashicons dashicons-star-filled"></span> <?php esc_html_e( 'Key Features', 'royal-addons-for-elementor' ); ?></h3>
                        <div class="royal-addons-feature-grid">
                            <div class="royal-addons-feature-item">
                                <span class="dashicons dashicons-grid-view"></span>
                                <?php esc_html_e( '100+ Widgets', 'royal-addons-for-elementor' ); ?>
                            </div>
                            <div class="royal-addons-feature-item">
                                <span class="dashicons dashicons-schedule"></span>
                                <?php esc_html_e( 'Header/Footer Builder', 'royal-addons-for-elementor' ); ?>
                            </div>
                            <div class="royal-addons-feature-item">
                                <span class="dashicons dashicons-menu"></span>
                                <?php esc_html_e( 'Mega Menu', 'royal-addons-for-elementor' ); ?>
                            </div>
                            <div class="royal-addons-feature-item">
                                <span class="dashicons dashicons-editor-textcolor"></span>
                                <?php esc_html_e( 'Custom Fonts', 'royal-addons-for-elementor' ); ?>
                            </div>
                            <div class="royal-addons-feature-item">
                                <span class="dashicons dashicons-editor-code"></span>
                                <?php esc_html_e( 'Custom CSS', 'royal-addons-for-elementor' ); ?>
                            </div>
                            <div class="royal-addons-feature-item">
                                <span class="dashicons dashicons-shortcode"></span>
                                <?php esc_html_e( 'Code Snippets', 'royal-addons-for-elementor' ); ?>
                            </div>
                            <div class="royal-addons-feature-item">
                                <span class="dashicons dashicons-performance"></span>
                                <?php esc_html_e( 'Performance Optimized', 'royal-addons-for-elementor' ); ?>
                            </div>
                            <div class="royal-addons-feature-item">
                                <span class="dashicons dashicons-admin-settings"></span>
                                <?php esc_html_e( 'Tweak Settings', 'royal-addons-for-elementor' ); ?>
                            </div>
                            <div class="royal-addons-feature-item">
                                <span class="dashicons dashicons-translation"></span>
                                <?php esc_html_e( 'Multi-language Ready', 'royal-addons-for-elementor' ); ?>
                            </div>
                            <div class="royal-addons-feature-item">
                                <span class="dashicons dashicons-update"></span>
                                <?php esc_html_e( 'Regular Updates', 'royal-addons-for-elementor' ); ?>
                            </div>
                        </div>
                    </div>

                    <!-- Popular Widgets -->
                    <div class="royal-addons-about-section">
                        <h3><span class="dashicons dashicons-star-empty"></span> <?php esc_html_e( 'Popular Widgets', 'royal-addons-for-elementor' ); ?></h3>
                        <div class="royal-addons-widgets-list">
                            <span class="widget-tag">Advanced Slider</span>
                            <span class="widget-tag">Image Gallery</span>
                            <span class="widget-tag">Testimonials</span>
                            <span class="widget-tag">Pricing Table</span>
                            <span class="widget-tag">Team Grid</span>
                            <span class="widget-tag">Contact Form</span>
                            <span class="widget-tag">Timeline</span>
                            <span class="widget-tag">Counter</span>
                            <span class="widget-tag">Progress Bar</span>
                            <span class="widget-tag">World Clock</span>
                            <span class="widget-tag">Icon Box</span>
                            <span class="widget-tag">And Many More...</span>
                        </div>
                    </div>

                    <!-- Developer Card -->
                    <div class="royal-addons-developer-card">
                        <h3>👨‍💻 <?php esc_html_e( 'Developer', 'royal-addons-for-elementor' ); ?></h3>
                        <p class="company-name">Royal Technologies</p>
                        <p class="company-desc"><?php esc_html_e( 'Professional Web Development & Design Solutions', 'royal-addons-for-elementor' ); ?></p>
                    </div>

                    <!-- Contact Grid -->
                    <div class="royal-addons-contact-grid">
                        <div class="royal-addons-contact-card website">
                            <h4>🌐 <?php esc_html_e( 'Website', 'royal-addons-for-elementor' ); ?></h4>
                            <a href="https://www.royaltechbd.com/" target="_blank">www.royaltechbd.com <span class="dashicons dashicons-external" style="font-size: 14px;"></span></a>
                        </div>
                        <div class="royal-addons-contact-card email">
                            <h4>📧 <?php esc_html_e( 'Email', 'royal-addons-for-elementor' ); ?></h4>
                            <a href="mailto:info@royaltechbd.com">info@royaltechbd.com</a>
                        </div>
                        <div class="royal-addons-contact-card phone">
                            <h4>📱 <?php esc_html_e( 'Mobile', 'royal-addons-for-elementor' ); ?></h4>
                            <a href="tel:+8801552333272">+880 1552-333272</a>
                        </div>
                        <div class="royal-addons-contact-card address">
                            <h4>📍 <?php esc_html_e( 'Address', 'royal-addons-for-elementor' ); ?></h4>
                            <p>D - 408, Housing Estate<br>Kushtia - 7000, Bangladesh</p>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="royal-addons-footer-text">
                        <?php printf( 
                            /* translators: %s: current year */
                            esc_html__( '© %s Royal Technologies. All rights reserved.', 'royal-addons-for-elementor' ), 
                            date( 'Y' ) 
                        ); ?>
                    </div>

                </div>
            </div> 
        </div>
    </div>
</div>