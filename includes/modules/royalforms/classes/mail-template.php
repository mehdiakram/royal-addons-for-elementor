<?php
namespace RoyalAddons\Modules\Forms\Classes;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Mail Template renderer with token replacement
 */
class Mail_Template {

	/**
	 * Available tokens with descriptions
	 */
	public static function get_available_tokens() {
		return [
			// Field tokens
			'[field id="field_id"]' => __( 'Value of a specific field', 'royal-addons-for-elementor' ),
			'[all-fields]' => __( 'All submitted fields formatted as a table', 'royal-addons-for-elementor' ),
			
			// Submission tokens
			'[submission:date]' => __( 'Date of submission', 'royal-addons-for-elementor' ),
			'[submission:time]' => __( 'Time of submission', 'royal-addons-for-elementor' ),
			'[submission:id]' => __( 'Submission ID (if saved to database)', 'royal-addons-for-elementor' ),
			
			// Site tokens
			'[site:name]' => __( 'Site name', 'royal-addons-for-elementor' ),
			'[site:url]' => __( 'Site URL', 'royal-addons-for-elementor' ),
			'[site:admin_email]' => __( 'Site admin email', 'royal-addons-for-elementor' ),
			
			// User tokens
			'[user:ip]' => __( 'User IP address', 'royal-addons-for-elementor' ),
			'[user:browser]' => __( 'User browser/user agent', 'royal-addons-for-elementor' ),
			'[user:name]' => __( 'Logged-in user name', 'royal-addons-for-elementor' ),
			'[user:email]' => __( 'Logged-in user email', 'royal-addons-for-elementor' ),
			
			// Page tokens
			'[page:title]' => __( 'Page title', 'royal-addons-for-elementor' ),
			'[page:url]' => __( 'Page URL', 'royal-addons-for-elementor' ),
			'[page:id]' => __( 'Page ID', 'royal-addons-for-elementor' ),
			
			// Form tokens
			'[form:name]' => __( 'Form name', 'royal-addons-for-elementor' ),
			'[form:id]' => __( 'Form ID', 'royal-addons-for-elementor' ),
		];
	}

	/**
	 * Render email template with token replacement
	 */
	public static function render( $template, $record, $ajax_handler = null ) {
		$fields = $record->get_fields();
		$settings = $record->get_form_settings();
		$meta = $record->get_meta();

		// Get field settings for labels
		$form_fields = isset( $settings['form_fields'] ) ? $settings['form_fields'] : [];
		$field_labels = [];
		foreach ( $form_fields as $field ) {
			if ( isset( $field['custom_id'] ) && isset( $field['field_label'] ) ) {
				$field_labels[ $field['custom_id'] ] = $field['field_label'];
			}
		}

		// Replace field tokens [field id="xxx"]
		$template = preg_replace_callback(
			'/\[field id=["\']([^"\']+)["\']\]/',
			function( $matches ) use ( $fields, $field_labels ) {
				$field_id = $matches[1];
				$value = isset( $fields[ $field_id ] ) ? $fields[ $field_id ] : '';
				
				if ( is_array( $value ) ) {
					$value = implode( ', ', $value );
				}
				
				return esc_html( $value );
			},
			$template
		);

		// Replace [all-fields] token
		if ( strpos( $template, '[all-fields]' ) !== false ) {
			$is_plain = isset( $settings['email_content_type'] ) && $settings['email_content_type'] === 'plain';
			$all_fields_html = self::render_all_fields( $fields, $field_labels, ! $is_plain );
			$template = str_replace( '[all-fields]', $all_fields_html, $template );
		}

		// Replace shorthand field tokens [fieldId] - CF7-style format
		// This allows [name], [email], [subject], [message] etc.
		foreach ( $fields as $field_id => $value ) {
			$token = '[' . $field_id . ']';
			if ( strpos( $template, $token ) !== false ) {
				if ( is_array( $value ) ) {
					$value = implode( ', ', $value );
				}
				$template = str_replace( $token, esc_html( $value ), $template );
			}
		}

		// Replace submission tokens
		$submission_id = $ajax_handler ? ( $ajax_handler->data['submission_id'] ?? '' ) : '';
		$template = str_replace( '[submission:date]', current_time( 'F j, Y' ), $template );
		$template = str_replace( '[submission:time]', current_time( 'g:i a' ), $template );
		$template = str_replace( '[submission:id]', $submission_id, $template );

		// Replace site tokens
		$template = str_replace( '[site:name]', get_bloginfo( 'name' ), $template );
		$template = str_replace( '[site:url]', site_url(), $template );
		$template = str_replace( '[site:admin_email]', get_option( 'admin_email' ), $template );

		// Replace user tokens
		$template = str_replace( '[user:ip]', $meta['user_ip'] ?? '', $template );
		$template = str_replace( '[user:browser]', isset( $_SERVER['HTTP_USER_AGENT'] ) ? sanitize_text_field( $_SERVER['HTTP_USER_AGENT'] ) : '', $template );
		
		$current_user = wp_get_current_user();
		$template = str_replace( '[user:name]', $current_user->display_name ?? '', $template );
		$template = str_replace( '[user:email]', $current_user->user_email ?? '', $template );

		// Replace page tokens
		$post_id = $meta['post_id'] ?? 0;
		$template = str_replace( '[page:title]', $post_id ? get_the_title( $post_id ) : '', $template );
		$template = str_replace( '[page:url]', $meta['page_url'] ?? '', $template );
		$template = str_replace( '[page:id]', $post_id, $template );

		// Replace form tokens
		$template = str_replace( '[form:name]', $settings['form_name'] ?? '', $template );
		$template = str_replace( '[form:id]', $settings['form_id'] ?? '', $template );

		return $template;
	}

	/**
	 * Render all fields as formatted output
	 */
	public static function render_all_fields( $fields, $field_labels, $html = true ) {
		if ( empty( $fields ) ) {
			return '';
		}

		if ( $html ) {
			$output = '<table style="width: 100%; border-collapse: collapse; margin: 15px 0;">';
			
			foreach ( $fields as $field_id => $value ) {
				if ( $value === '' || ( is_array( $value ) && empty( $value ) ) ) {
					continue;
				}
				
				$label = isset( $field_labels[ $field_id ] ) ? $field_labels[ $field_id ] : ucfirst( str_replace( '_', ' ', $field_id ) );
				
				if ( is_array( $value ) ) {
					$value = implode( ', ', $value );
				}
				
				$output .= '<tr>';
				$output .= '<td style="padding: 8px 12px; border: 1px solid #ddd; background: #f9f9f9; font-weight: bold; width: 30%;">' . esc_html( $label ) . '</td>';
				$output .= '<td style="padding: 8px 12px; border: 1px solid #ddd;">' . nl2br( esc_html( $value ) ) . '</td>';
				$output .= '</tr>';
			}
			
			$output .= '</table>';
		} else {
			$output = '';
			
			foreach ( $fields as $field_id => $value ) {
				if ( $value === '' || ( is_array( $value ) && empty( $value ) ) ) {
					continue;
				}
				
				$label = isset( $field_labels[ $field_id ] ) ? $field_labels[ $field_id ] : ucfirst( str_replace( '_', ' ', $field_id ) );
				
				if ( is_array( $value ) ) {
					$value = implode( ', ', $value );
				}
				
				$output .= "{$label}: {$value}\n";
			}
		}

		return $output;
	}

	/**
	 * Get default email template
	 */
	public static function get_default_template( $html = true ) {
		if ( $html ) {
			return '
<div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;">
	<div style="background: linear-gradient(135deg, #6EC1E4, #4aa8d1); padding: 30px 20px; text-align: center;">
		<h1 style="color: #fff; margin: 0; font-size: 24px;">New Form Submission</h1>
	</div>
	
	<div style="padding: 30px 20px; background: #fff;">
		<p style="color: #666; font-size: 14px;">You have received a new submission from <strong>[form:name]</strong>.</p>
		
		<h2 style="color: #333; font-size: 18px; margin: 25px 0 15px;">Form Details</h2>
		[all-fields]
		
		<div style="margin-top: 25px; padding: 15px; background: #f5f5f5; border-radius: 5px;">
			<p style="margin: 5px 0; font-size: 13px; color: #666;"><strong>Submitted from:</strong> <a href="[page:url]">[page:title]</a></p>
			<p style="margin: 5px 0; font-size: 13px; color: #666;"><strong>Date:</strong> [submission:date] at [submission:time]</p>
			<p style="margin: 5px 0; font-size: 13px; color: #666;"><strong>IP Address:</strong> [user:ip]</p>
		</div>
	</div>
	
	<div style="padding: 20px; background: #f0f0f0; text-align: center;">
		<p style="margin: 0; font-size: 12px; color: #888;">This email was sent from <a href="[site:url]">[site:name]</a></p>
	</div>
</div>';
		} else {
			return 'New Form Submission: [form:name]
=====================================

[all-fields]

-------------------------------------
Submitted from: [page:url]
Date: [submission:date] at [submission:time]
IP Address: [user:ip]

This email was sent from [site:name] ([site:url])';
		}
	}
}
