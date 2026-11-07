<?php
namespace RoyalAddons\Modules\Forms\Actions;

use RoyalAddons\Modules\Forms\Classes\Action_Base;
use RoyalAddons\Modules\Forms\Classes\Mail_Template;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Email extends Action_Base {

	public function get_name() {
		return 'email';
	}

	public function get_label() {
		return esc_html__( 'Email', 'royal-addons-for-elementor' );
	}

	public function run( $record, $ajax_handler ) {
		$settings = $record->get_form_settings();

		// Get email settings with defaults
		$to = ! empty( $settings['email_to'] ) ? $settings['email_to'] : get_option( 'admin_email' );
		$subject = ! empty( $settings['email_subject'] ) ? $settings['email_subject'] : __( 'New Form Submission', 'royal-addons-for-elementor' );
		$from_name = ! empty( $settings['email_from_name'] ) ? $settings['email_from_name'] : get_bloginfo( 'name' );
		$from_email = ! empty( $settings['email_from'] ) ? $settings['email_from'] : get_option( 'admin_email' );
		$reply_to = ! empty( $settings['email_reply_to'] ) ? $settings['email_reply_to'] : '';
		$cc = ! empty( $settings['email_cc'] ) ? $settings['email_cc'] : '';
		$bcc = ! empty( $settings['email_bcc'] ) ? $settings['email_bcc'] : '';
		$content_type = isset( $settings['email_content_type'] ) && $settings['email_content_type'] === 'plain' ? 'plain' : 'html';

		// Process tokens in email fields
		$to = Mail_Template::render( $to, $record, $ajax_handler );
		$subject = Mail_Template::render( $subject, $record, $ajax_handler );
		$from_name = Mail_Template::render( $from_name, $record, $ajax_handler );

		// Get email body content
		if ( ! empty( $settings['email_content'] ) ) {
			$body = $settings['email_content'];
		} else {
			$body = Mail_Template::get_default_template( $content_type === 'html' );
		}

		// Render template with tokens
		$body = Mail_Template::render( $body, $record, $ajax_handler );

		// Append Metadata Footer
		// Error log to debug
		if ( isset( $settings['email_append_footer'] ) ) {
			// error_log('Royal Forms Debug: Footer Setting Found: ' . $settings['email_append_footer']);
		} else {
			// error_log('Royal Forms Debug: Footer Setting XML NOT FOUND');
		}

		// Check if footer should be appended (Default is yes, so check if not explicitly empty/no)
		$append_footer = isset( $settings['email_append_footer'] ) ? $settings['email_append_footer'] : 'yes';
		
		if ( ! empty( $append_footer ) && $append_footer !== 'no' ) {
			$footer_html = '';
			
			// Force footer for both HTML and Plain Text
			if ( $content_type === 'html' ) {
				$footer_html = '<div style="margin-top: 25px; padding: 15px; background: #f5f5f5; border-radius: 5px; font-family: sans-serif;">
				<p style="margin: 5px 0; font-size: 13px; color: #666;"><strong>Submitted from:</strong> <a href="[page:url]" target="_blank" rel="noopener noreferrer">[page:title]</a></p>
				<p style="margin: 5px 0; font-size: 13px; color: #666;"><strong>Date:</strong> [submission:date] at [submission:time]</p>
				<p style="margin: 5px 0; font-size: 13px; color: #666;"><strong>IP Address:</strong> [user:ip]</p>
			</div>';
			
				$footer_html = Mail_Template::render( $footer_html, $record, $ajax_handler );

				// Inject inside </body> or </html> if present (Case insensitive)
				if ( stripos( $body, '</body>' ) !== false ) {
					$body = str_ireplace( '</body>', $footer_html . '</body>', $body );
				} elseif ( stripos( $body, '</html>' ) !== false ) {
					$body = str_ireplace( '</html>', $footer_html . '</html>', $body );
				} else {
					$body .= $footer_html;
				}

			} else {
				// Plain Text Footer
				$footer_text = "\n\n----------------------------------------\n";
				$footer_text .= "Submitted from: [page:title] - [page:url]\n";
				$footer_text .= "Date: [submission:date] at [submission:time]\n";
				$footer_text .= "IP Address: [user:ip]\n";

				$body .= Mail_Template::render( $footer_text, $record, $ajax_handler );
			}
		}

		// Build headers
		$headers = [];
		$headers[] = "From: {$from_name} <{$from_email}>";

		if ( $content_type === 'html' ) {
			$headers[] = 'Content-Type: text/html; charset=UTF-8';
		}

		if ( ! empty( $reply_to ) ) {
			$reply_to = Mail_Template::render( $reply_to, $record, $ajax_handler );
			$headers[] = "Reply-To: {$reply_to}";
		}

		if ( ! empty( $cc ) ) {
			$cc = Mail_Template::render( $cc, $record, $ajax_handler );
			$headers[] = "Cc: {$cc}";
		}

		if ( ! empty( $bcc ) ) {
			$bcc = Mail_Template::render( $bcc, $record, $ajax_handler );
			$headers[] = "Bcc: {$bcc}";
		}

		// Handle file attachments - always attach uploaded files with original names
		$attachments = [];
		$temp_files = []; // Track temp files to clean up if needed
		$files = $record->get_files();
		
		if ( ! empty( $files ) ) {
			$upload_dir = wp_upload_dir();
			$temp_dir = $upload_dir['basedir'] . '/royal-form-temp/';
			
			// Create temp directory if it doesn't exist
			if ( ! file_exists( $temp_dir ) ) {
				wp_mkdir_p( $temp_dir );
			}
			
			foreach ( $files as $field_key => $file_data ) {
				if ( isset( $file_data['tmp_name'] ) ) {
					// Handle multiple files
					if ( is_array( $file_data['tmp_name'] ) ) {
						foreach ( $file_data['tmp_name'] as $index => $tmp_name ) {
							// If it is still an array, it means multiple files for this field
							if ( is_array( $tmp_name ) ) {
								foreach ( $tmp_name as $sub_index => $sub_tmp_name ) {
									if ( ! empty( $sub_tmp_name ) && is_string( $sub_tmp_name ) && is_uploaded_file( $sub_tmp_name ) ) {
										$name_to_use = isset( $file_data['name'][ $index ][ $sub_index ] ) ? $file_data['name'][ $index ][ $sub_index ] : 'file_' . $index . '_' . $sub_index;
										$original_name = sanitize_file_name( $name_to_use );
										$new_path = $temp_dir . uniqid() . '_' . $original_name;
										
										if ( copy( $sub_tmp_name, $new_path ) ) {
											$attachments[] = $new_path;
											$temp_files[] = $new_path;
										}
									}
								}
							} else {
								// This is likely when input name is like field_id[]
								if ( ! empty( $tmp_name ) && is_string( $tmp_name ) && is_uploaded_file( $tmp_name ) ) {
									$name_to_use = isset( $file_data['name'][ $index ] ) ? $file_data['name'][ $index ] : 'file_' . $index;
									$original_name = sanitize_file_name( $name_to_use );
									$new_path = $temp_dir . uniqid() . '_' . $original_name;
									
									if ( copy( $tmp_name, $new_path ) ) {
										$attachments[] = $new_path;
										$temp_files[] = $new_path;
									}
								}
							}
						}
					} else {
						// Single file - strict check
						$tmp_name = $file_data['tmp_name'];
						if ( ! empty( $tmp_name ) && is_string( $tmp_name ) && is_uploaded_file( $tmp_name ) ) {
							$name_to_use = isset( $file_data['name'] ) ? $file_data['name'] : 'file';
							$original_name = sanitize_file_name( $name_to_use );
							$new_path = $temp_dir . uniqid() . '_' . $original_name;
							
							if ( copy( $tmp_name, $new_path ) ) {
								$attachments[] = $new_path;
								$temp_files[] = $new_path;
							}
						}
					}
				}
			}
		}


		// Debug email sending
		error_log( 'ROYAL FORM DEBUG: Sending email to ' . $to . ' | Subject: ' . $subject );

		// Send email
		$sent = wp_mail( $to, $subject, $body, $headers, $attachments );

		// Clean up temp files
		foreach ( $temp_files as $temp_file ) {
			if ( file_exists( $temp_file ) ) {
				@unlink( $temp_file );
			}
		}

		if ( $sent ) {
			$ajax_handler->add_success_message( 
				$settings['success_message'] ?? esc_html__( ' sent successfully.', 'royal-addons-for-elementor' ) 
			);
		} else {
			$ajax_handler->add_error_message( 
				$settings['error_message'] ?? esc_html__( 'There was an error sending the email.', 'royal-addons-for-elementor' ) 
			);
		}
	}
}

