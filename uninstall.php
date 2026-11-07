<?php
/**
 * Royal Addons for Elementor Uninstall
 *
 * Uninstalling Royal Addons deletes user options and transients.
 *
 * @package RoyalAddons
 */

// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

// 1. Delete Options
$options_to_delete = array(
	'royal_addons_settings',
	'royal_license_key',
	'royal_addons_version',
	'royal_addons_pro_active',
	'royal_addons_pro_license',
	'royal_active_widgets',
	'royal_active_extensions'
);

foreach ( $options_to_delete as $option ) {
	delete_option( $option );
	delete_site_option( $option ); // For multisite
}

// 2. Delete Custom Post Type Posts (Custom Fonts)
$custom_fonts = get_posts( array(
	'post_type'      => 'royal_custom_font',
	'post_status'    => 'any',
	'numberposts'    => -1,
	'fields'         => 'ids',
) );

if ( $custom_fonts ) {
	foreach ( $custom_fonts as $font_id ) {
		// This will also trigger the 'before_delete_post' hook in our CPT class to delete associated font files.
		wp_delete_post( $font_id, true );
	}
}

// 3. Clear Transients
delete_transient( 'royal_addons_notice_dismissed' );
delete_transient( 'royal_license_check' );

// Clear cache (if any specific caching plugin integration was used)
// ...
