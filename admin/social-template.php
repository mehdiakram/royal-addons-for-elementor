<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

$license_key = get_option('royaladdons_license_key', '');

// Handle Redirect Back from OAuth
if (isset($_GET['social_connected'])) {
    $platform = sanitize_text_field($_GET['social_connected']);
    if (in_array($platform, ['facebook', 'instagram', 'google', 'linkedin', 'twitter', 'x'])) {
        if ($platform === 'x') $platform = 'twitter'; // Save options as twitter for consistency
        update_option("royaladdons_{$platform}_connected", 'yes');
        
        if (isset($_GET['social_name'])) update_option("royaladdons_{$platform}_name", sanitize_text_field($_GET['social_name']));
        if (isset($_GET['social_email'])) update_option("royaladdons_{$platform}_email", sanitize_email($_GET['social_email']));
        if (isset($_GET['social_picture'])) update_option("royaladdons_{$platform}_picture", esc_url_raw($_GET['social_picture']));

        // Redirect to clean URL
        $redirect_url = remove_query_arg(['social_connected', 'social_name', 'social_email', 'social_picture', 'social_id']);
        wp_safe_redirect($redirect_url);
        exit;
    }
}

// Check Disconnect
if (isset($_GET['social_disconnect']) && check_admin_referer('royal_social_disconnect')) {
    $platform = sanitize_text_field($_GET['social_disconnect']);
    if (in_array($platform, ['facebook', 'instagram', 'google', 'linkedin', 'twitter', 'x'])) {
        if ($platform === 'x') $platform = 'twitter';
        delete_option("royaladdons_{$platform}_connected");
        delete_option("royaladdons_{$platform}_name");
        delete_option("royaladdons_{$platform}_email");
        delete_option("royaladdons_{$platform}_picture");
        
        $redirect_url = remove_query_arg(['social_disconnect', '_wpnonce']);
        wp_safe_redirect($redirect_url);
        exit;
    }
}

$is_fb_connected = get_option('royaladdons_facebook_connected') === 'yes';
$is_ig_connected = get_option('royaladdons_instagram_connected') === 'yes';
$is_google_connected = get_option('royaladdons_google_connected') === 'yes';
$is_linkedin_connected = get_option('royaladdons_linkedin_connected') === 'yes';
$is_twitter_connected = get_option('royaladdons_twitter_connected') === 'yes';

$return_url = admin_url('admin.php?page=royaladdons-social');
$royal_auth_url = 'https://auth.royaltechbd.com';

if (!function_exists('royaladdons_render_social_profile')) {
    function royaladdons_render_social_profile($platform, $default_name, $theme_color) {
        $name = get_option("royaladdons_{$platform}_name", $default_name);
        $email = get_option("royaladdons_{$platform}_email", '');
        $picture = get_option("royaladdons_{$platform}_picture", '');
        $disconnect_url = esc_url(wp_nonce_url(admin_url("admin.php?page=royaladdons-social&social_disconnect={$platform}"), 'royal_social_disconnect'));
        
        ?>
        <div style="display: flex; align-items: center; justify-content: space-between; gap: 20px; background: #f8fafc; padding: 10px 15px; border-radius: 8px; border: 1px solid #e2e8f0;">
            <div style="display: flex; align-items: center; gap: 12px;">
                <?php if ($picture): ?>
                    <img src="<?php echo esc_url($picture); ?>" alt="Profile" style="width: 36px; height: 36px; border-radius: 50%; object-fit: cover; border: 2px solid #fff; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                <?php else: ?>
                    <div style="width: 36px; height: 36px; border-radius: 50%; background: <?php echo esc_attr($theme_color); ?>; color: #fff; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 16px;">
                        <?php echo esc_html(strtoupper(substr($name, 0, 1))); ?>
                    </div>
                <?php endif; ?>
                <div>
                    <div style="font-weight: 600; color: #1e293b; font-size: 14px; display: flex; align-items: center; gap: 5px;">
                        <?php echo esc_html($name); ?>
                        <span style="color: #10b981; display: inline-flex;"><span class="dashicons dashicons-yes-alt" style="font-size: 16px; width: 16px; height: 16px;"></span></span>
                    </div>
                    <?php if ($email): ?>
                        <div style="font-size: 12px; color: #64748b;"><?php echo esc_html($email); ?></div>
                    <?php endif; ?>
                </div>
            </div>
            <a href="<?php echo $disconnect_url; ?>" class="button button-secondary" style="color: #ef4444; border-color: #fca5a5; background: #fff; transition: all 0.2s;" onmouseover="this.style.background='#fef2f2'" onmouseout="this.style.background='#fff'">Disconnect</a>
        </div>
        <?php
    }
}
?>

<div class="wrap" style="max-width: 800px; margin-top: 20px;">
    <div style="background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
        <h1 style="margin-top: 0; padding-bottom: 15px; border-bottom: 1px solid #eee;"><?php _e('Social Integrations', 'royal-addons-for-elementor'); ?></h1>
        
        <?php if (empty($license_key)): ?>
            <div class="notice notice-error inline" style="margin: 20px 0;">
                <p><?php _e('Please activate your Royal Addons license first to use Social Integrations.', 'royal-addons-for-elementor'); ?></p>
            </div>
        <?php else: ?>
            <p style="font-size: 15px; color: #555; margin-bottom: 30px;"><?php _e('Connect your social media accounts seamlessly without dealing with complex APIs. Once connected, your widgets will automatically fetch your feeds.', 'royal-addons-for-elementor'); ?></p>
            
            <table class="form-table" style="background: #f8f9fa; border: 1px solid #e2e8f0; border-radius: 8px; padding: 20px; display: block;">
                <!-- Facebook Integration -->
                <tr style="display: flex; align-items: center; padding: 15px; border-bottom: 1px solid #e2e8f0;">
                    <th scope="row" style="width: 150px; padding: 0; display: flex; align-items: center; gap: 10px;">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" style="width: 24px; height: 24px; fill: #1877f2;"><path d="M504 256C504 119 393 8 256 8S8 119 8 256c0 123.78 90.69 226.38 209.25 245V327.69h-63V256h63v-54.64c0-62.15 37-96.48 93.67-96.48 27.14 0 55.52 4.84 55.52 4.84v61h-31.28c-30.8 0-40.41 19.12-40.41 38.73V256h68.78l-11 71.69h-57.78V501C413.31 482.38 504 379.78 504 256z"/></svg>
                        <strong style="font-size: 16px;">Facebook</strong>
                    </th>
                    <td style="padding: 0; flex-grow: 1;">
                        <?php if ($is_fb_connected): ?>
                            <?php royaladdons_render_social_profile('facebook', 'Facebook Page', '#1877f2'); ?>
                        <?php else: ?>
                            <a href="<?php echo esc_url($royal_auth_url . '/connect/facebook?software=royaladdonsforelementor&license_key=' . urlencode($license_key) . '&return_url=' . urlencode($return_url)); ?>" class="button button-primary" style="background: #1877f2; border-color: #1877f2;">Connect to Facebook</a>
                        <?php endif; ?>
                    </td>
                </tr>

                <!-- Instagram Integration -->
                <tr style="display: flex; align-items: center; padding: 15px; border-bottom: 1px solid #e2e8f0;">
                    <th scope="row" style="width: 150px; padding: 0; display: flex; align-items: center; gap: 10px;">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" style="width: 24px; height: 24px; fill: #e1306c;"><path d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z"/></svg>
                        <strong style="font-size: 16px;">Instagram</strong>
                    </th>
                    <td style="padding: 0; flex-grow: 1;">
                        <?php if ($is_ig_connected): ?>
                            <?php royaladdons_render_social_profile('instagram', 'Instagram Account', '#e1306c'); ?>
                        <?php else: ?>
                            <a href="<?php echo esc_url($royal_auth_url . '/connect/instagram?software=royaladdonsforelementor&license_key=' . urlencode($license_key) . '&return_url=' . urlencode($return_url)); ?>" class="button button-primary" style="background: #e1306c; border-color: #e1306c;">Connect to Instagram</a>
                        <?php endif; ?>
                    </td>
                </tr>
                <!-- Google Integration -->
                <tr style="display: flex; align-items: center; padding: 15px; border-bottom: 1px solid #e2e8f0;">
                    <th scope="row" style="width: 150px; padding: 0; display: flex; align-items: center; gap: 10px;">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 488 512" style="width: 24px; height: 24px; fill: #4285F4;"><path d="M488 261.8C488 403.3 391.1 504 248 504 110.8 504 0 393.2 0 256S110.8 8 248 8c66.8 0 123 24.5 166.3 64.9l-67.5 64.9C258.5 52.6 94.3 116.6 94.3 256c0 86.5 69.1 156.6 153.7 156.6 98.2 0 135-70.4 140.8-106.9H248v-85.3h236.1c2.3 12.7 3.9 24.9 3.9 41.4z"/></svg>
                        <strong style="font-size: 16px;">Google</strong>
                    </th>
                    <td style="padding: 0; flex-grow: 1;">
                        <?php if ($is_google_connected): ?>
                            <?php royaladdons_render_social_profile('google', 'Google Business', '#4285F4'); ?>
                        <?php else: ?>
                            <a href="<?php echo esc_url($royal_auth_url . '/connect/google-reviews?software=royaladdonsforelementor&license_key=' . urlencode($license_key) . '&return_url=' . urlencode($return_url)); ?>" class="button button-primary" style="background: #4285F4; border-color: #4285F4;">Connect to Google</a>
                        <?php endif; ?>
                    </td>
                </tr>
                <!-- LinkedIn Integration -->
                <tr style="display: flex; align-items: center; padding: 15px; border-bottom: 1px solid #e2e8f0;">
                    <th scope="row" style="width: 150px; padding: 0; display: flex; align-items: center; gap: 10px;">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" style="width: 24px; height: 24px; fill: #0a66c2;"><path d="M100.28 448H7.4V148.9h92.88zM53.79 108.1C24.09 108.1 0 83.5 0 53.8a53.79 53.79 0 0 1 107.58 0c0 29.7-24.1 54.3-53.79 54.3zM447.9 448h-92.68V302.4c0-34.7-.7-79.2-48.29-79.2-48.29 0-55.69 37.7-55.69 76.7V448h-92.78V148.9h89.08v40.8h1.3c12.4-23.5 42.69-48.3 87.88-48.3 94 0 111.28 61.9 111.28 142.3V448z"/></svg>
                        <strong style="font-size: 16px;">LinkedIn</strong>
                    </th>
                    <td style="padding: 0; flex-grow: 1;">
                        <?php if ($is_linkedin_connected): ?>
                            <?php royaladdons_render_social_profile('linkedin', 'LinkedIn Profile', '#0a66c2'); ?>
                        <?php else: ?>
                            <a href="<?php echo esc_url($royal_auth_url . '/connect/linkedin?software=royaladdonsforelementor&license_key=' . urlencode($license_key) . '&return_url=' . urlencode($return_url)); ?>" class="button button-primary" style="background: #0a66c2; border-color: #0a66c2;">Connect to LinkedIn</a>
                        <?php endif; ?>
                    </td>
                </tr>
                <!-- Twitter Integration -->
                <tr style="display: flex; align-items: center; padding: 15px;">
                    <th scope="row" style="width: 150px; padding: 0; display: flex; align-items: center; gap: 10px;">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" style="width: 24px; height: 24px; fill: #000000;"><path d="M389.2 48h70.6L305.6 224.2 487 464H345L233.7 318.6 106.5 464H35.8L200.7 275.5 26.8 48H172.4L272.9 180.9 389.2 48zM364.4 421.8h39.1L151.1 88h-42L364.4 421.8z"/></svg>
                        <strong style="font-size: 16px;">Twitter (X)</strong>
                    </th>
                    <td style="padding: 0; flex-grow: 1;">
                        <?php if ($is_twitter_connected): ?>
                            <?php royaladdons_render_social_profile('twitter', 'Twitter Account', '#000000'); ?>
                        <?php else: ?>
                            <a href="<?php echo esc_url($royal_auth_url . '/connect/x?software=royaladdonsforelementor&license_key=' . urlencode($license_key) . '&return_url=' . urlencode($return_url)); ?>" class="button button-primary" style="background: #000000; border-color: #000000;">Connect to Twitter</a>
                        <?php endif; ?>
                    </td>
                </tr>


            </table>
        <?php endif; ?>
    </div>
</div>


