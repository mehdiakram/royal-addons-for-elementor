<?php
namespace RoyalAddons\Modules\Forms\Classes;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Validation class for form fields
 */
class Validation {

	private $errors = [];

	/**
	 * Validate a single field
	 */
	public function validate_field( $field, $value, $files = [] ) {
		$this->errors = [];
		$field_type = $field['field_type'] ?? 'text';
		$field_label = $field['field_label'] ?? $field['custom_id'];

		// Required validation
		if ( ! empty( $field['required'] ) ) {
			if ( $this->is_empty( $value ) && empty( $files ) ) {
				$this->add_error( $field['custom_id'], sprintf(
					esc_html__( '%s is required.', 'royal-addons-for-elementor' ),
					$field_label
				));
				return $this->get_errors();
			}
		}

		// Skip further validation if empty and not required
		if ( $this->is_empty( $value ) && empty( $files ) ) {
			return $this->get_errors();
		}

		// Type-specific validation
		switch ( $field_type ) {
			case 'email':
				$this->validate_email( $field, $value );
				break;

			case 'url':
				$this->validate_url( $field, $value );
				break;

			case 'number':
				$this->validate_number( $field, $value );
				break;

			case 'tel':
				$this->validate_tel( $field, $value );
				break;

			case 'text':
			case 'textarea':
				$this->validate_length( $field, $value );
				break;

			case 'file':
				$this->validate_file( $field, $files );
				break;

			case 'date':
				$this->validate_date( $field, $value );
				break;

			case 'acceptance':
				$this->validate_acceptance( $field, $value );
				break;
		}

		return $this->get_errors();
	}

	/**
	 * Check if value is empty
	 */
	private function is_empty( $value ) {
		if ( is_null( $value ) ) {
			return true;
		}
		if ( is_string( $value ) && trim( $value ) === '' ) {
			return true;
		}
		if ( is_array( $value ) && empty( $value ) ) {
			return true;
		}
		return false;
	}

	/**
	 * Validate email format
	 */
	private function validate_email( $field, $value ) {
		if ( ! is_email( $value ) ) {
			$this->add_error( $field['custom_id'], sprintf(
				esc_html__( '%s is not a valid email address.', 'royal-addons-for-elementor' ),
				$field['field_label'] ?? $field['custom_id']
			));
		}
	}

	/**
	 * Validate URL format
	 */
	private function validate_url( $field, $value ) {
		if ( ! filter_var( $value, FILTER_VALIDATE_URL ) ) {
			$this->add_error( $field['custom_id'], sprintf(
				esc_html__( '%s is not a valid URL.', 'royal-addons-for-elementor' ),
				$field['field_label'] ?? $field['custom_id']
			));
		}
	}

	/**
	 * Validate number with min/max
	 */
	private function validate_number( $field, $value ) {
		if ( ! is_numeric( $value ) ) {
			$this->add_error( $field['custom_id'], sprintf(
				esc_html__( '%s must be a number.', 'royal-addons-for-elementor' ),
				$field['field_label'] ?? $field['custom_id']
			));
			return;
		}

		$num_value = floatval( $value );

		if ( isset( $field['min_value'] ) && $field['min_value'] !== '' ) {
			if ( $num_value < floatval( $field['min_value'] ) ) {
				$this->add_error( $field['custom_id'], sprintf(
					esc_html__( '%s must be at least %s.', 'royal-addons-for-elementor' ),
					$field['field_label'] ?? $field['custom_id'],
					$field['min_value']
				));
			}
		}

		if ( isset( $field['max_value'] ) && $field['max_value'] !== '' ) {
			if ( $num_value > floatval( $field['max_value'] ) ) {
				$this->add_error( $field['custom_id'], sprintf(
					esc_html__( '%s must be no more than %s.', 'royal-addons-for-elementor' ),
					$field['field_label'] ?? $field['custom_id'],
					$field['max_value']
				));
			}
		}
	}

	/**
	 * Validate phone with pattern
	 */
	private function validate_tel( $field, $value ) {
		if ( ! empty( $field['phone_pattern'] ) ) {
			$pattern = '/' . $field['phone_pattern'] . '/';
			if ( ! preg_match( $pattern, $value ) ) {
				$this->add_error( $field['custom_id'], sprintf(
					esc_html__( '%s is not in the correct format.', 'royal-addons-for-elementor' ),
					$field['field_label'] ?? $field['custom_id']
				));
			}
		}
	}

	/**
	 * Validate text length
	 */
	private function validate_length( $field, $value ) {
		$length = mb_strlen( $value );

		if ( ! empty( $field['min_length'] ) ) {
			if ( $length < intval( $field['min_length'] ) ) {
				$this->add_error( $field['custom_id'], sprintf(
					esc_html__( '%s must be at least %d characters.', 'royal-addons-for-elementor' ),
					$field['field_label'] ?? $field['custom_id'],
					$field['min_length']
				));
			}
		}

		if ( ! empty( $field['max_length'] ) ) {
			if ( $length > intval( $field['max_length'] ) ) {
				$this->add_error( $field['custom_id'], sprintf(
					esc_html__( '%s must be no more than %d characters.', 'royal-addons-for-elementor' ),
					$field['field_label'] ?? $field['custom_id'],
					$field['max_length']
				));
			}
		}
	}

	/**
	 * Validate file upload
	 */
	private function validate_file( $field, $files ) {
		if ( empty( $files ) ) {
			return;
		}

		// Allowed file types
		$allowed_types = [];
		if ( ! empty( $field['file_types'] ) ) {
			$allowed_types = array_map( 'trim', explode( ',', strtolower( $field['file_types'] ) ) );
		}

		// Max file size (in bytes)
		$max_size = ! empty( $field['max_file_size'] ) ? intval( $field['max_file_size'] ) * 1024 * 1024 : 5 * 1024 * 1024;

		// Max files
		$max_files = ! empty( $field['max_files'] ) ? intval( $field['max_files'] ) : 5;

		$file_count = 0;
		foreach ( $files as $file ) {
			$file_count++;

			// Check file count
			if ( $file_count > $max_files ) {
				$this->add_error( $field['custom_id'], sprintf(
					esc_html__( 'You can only upload up to %d files for %s.', 'royal-addons-for-elementor' ),
					$max_files,
					$field['field_label'] ?? $field['custom_id']
				));
				break;
			}

			// Check file type
			if ( ! empty( $allowed_types ) ) {
				$ext = strtolower( pathinfo( $file['name'], PATHINFO_EXTENSION ) );
				if ( ! in_array( $ext, $allowed_types ) ) {
					$this->add_error( $field['custom_id'], sprintf(
						esc_html__( 'File type "%s" is not allowed for %s.', 'royal-addons-for-elementor' ),
						$ext,
						$field['field_label'] ?? $field['custom_id']
					));
				}
			}

			// Check file size
			if ( $file['size'] > $max_size ) {
				$this->add_error( $field['custom_id'], sprintf(
					esc_html__( 'File "%s" exceeds the maximum size of %dMB.', 'royal-addons-for-elementor' ),
					$file['name'],
					$field['max_file_size'] ?? 5
				));
			}
		}
	}

	/**
	 * Validate date with min/max
	 */
	private function validate_date( $field, $value ) {
		$date = strtotime( $value );
		
		if ( $date === false ) {
			$this->add_error( $field['custom_id'], sprintf(
				esc_html__( '%s is not a valid date.', 'royal-addons-for-elementor' ),
				$field['field_label'] ?? $field['custom_id']
			));
			return;
		}

		if ( ! empty( $field['min_date'] ) ) {
			$min_date = strtotime( $field['min_date'] );
			if ( $date < $min_date ) {
				$this->add_error( $field['custom_id'], sprintf(
					esc_html__( '%s must be on or after %s.', 'royal-addons-for-elementor' ),
					$field['field_label'] ?? $field['custom_id'],
					date( 'Y-m-d', $min_date )
				));
			}
		}

		if ( ! empty( $field['max_date'] ) ) {
			$max_date = strtotime( $field['max_date'] );
			if ( $date > $max_date ) {
				$this->add_error( $field['custom_id'], sprintf(
					esc_html__( '%s must be on or before %s.', 'royal-addons-for-elementor' ),
					$field['field_label'] ?? $field['custom_id'],
					date( 'Y-m-d', $max_date )
				));
			}
		}
	}

	/**
	 * Validate acceptance field
	 */
	private function validate_acceptance( $field, $value ) {
		if ( ! empty( $field['required'] ) && empty( $value ) ) {
			$this->add_error( $field['custom_id'], 
				esc_html__( 'You must accept the terms to continue.', 'royal-addons-for-elementor' )
			);
		}
	}

	/**
	 * Add an error
	 */
	private function add_error( $field_id, $message ) {
		$this->errors[ $field_id ] = $message;
	}

	/**
	 * Get all errors
	 */
	public function get_errors() {
		return $this->errors;
	}

	/**
	 * Check if validation passed
	 */
	public function is_valid() {
		return empty( $this->errors );
	}

	/**
	 * Validate honeypot field (bot protection)
	 */
	public function validate_honeypot( $fields, $value ) {
		foreach ( $fields as $field ) {
			$field_type = $field['field_type'] ?? '';
			if ( $field_type === 'honeypot' ) {
				if ( ! empty( $value[ $field['custom_id'] ] ) ) {
					$this->add_error( 'honeypot', esc_html__( 'Bot detected.', 'royal-addons-for-elementor' ) );
					return false;
				}
			}
		}
		return true;
	}

	/**
	 * Sanitize field value based on type
	 */
	public static function sanitize_value( $value, $field_type ) {
		switch ( $field_type ) {
			case 'email':
				return sanitize_email( $value );

			case 'url':
				return esc_url_raw( $value );

			case 'textarea':
				return sanitize_textarea_field( $value );

			case 'number':
				return is_numeric( $value ) ? floatval( $value ) : '';

			case 'checkbox':
			case 'select':
				if ( is_array( $value ) ) {
					return array_map( 'sanitize_text_field', $value );
				}
				return sanitize_text_field( $value );

			default:
				return sanitize_text_field( $value );
		}
	}
}
