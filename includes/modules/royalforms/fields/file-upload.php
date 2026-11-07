<?php
namespace RoyalAddons\Modules\Forms\Fields;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class File_Upload extends Field_Base {

	public function get_type() {
		return 'file';
	}

	public function get_name() {
		return esc_html__( 'File Upload', 'royal-addons-for-elementor' );
	}

	public function get_field_controls() {
		return [
			'file_types' => [
				'label' => esc_html__( 'Allowed File Types', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'condition' => [ 'field_type' => $this->get_type() ],
				'description' => esc_html__( 'Comma separated (e.g., jpg, png, pdf)', 'royal-addons-for-elementor' ),
				'default' => 'jpg, jpeg, png, gif, pdf',
			],
			'max_file_size' => [
				'label' => esc_html__( 'Max File Size (MB)', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'condition' => [ 'field_type' => $this->get_type() ],
				'default' => 5,
				'min' => 1,
				'max' => 100,
			],
			'allow_multiple_upload' => [
				'label' => esc_html__( 'Allow Multiple Files', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'condition' => [ 'field_type' => $this->get_type() ],
			],
			'max_files' => [
				'label' => esc_html__( 'Max Files', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'condition' => [
					'field_type' => $this->get_type(),
					'allow_multiple_upload' => 'yes',
				],
				'default' => 5,
				'min' => 1,
				'max' => 20,
			],
		];
	}

	public function render( $item, $item_index, $form ) {
		$this->render_field_wrapper_start( $item );
		$this->render_label( $item, $form );

		$attrs = $this->get_field_attributes( $item, $form );
		$attrs['type'] = 'file';
		$attrs['class'] .= ' royal-form-upload';

		// Set accepted file types
		if ( ! empty( $item['file_types'] ) ) {
			$types = array_map( 'trim', explode( ',', $item['file_types'] ) );
			$accept = array_map( function( $type ) {
				return '.' . ltrim( $type, '.' );
			}, $types );
			$attrs['accept'] = implode( ',', $accept );
		}

		// Multiple files
		if ( ! empty( $item['allow_multiple_upload'] ) ) {
			$attrs['multiple'] = 'multiple';
			$attrs['name'] .= '[]';
		}

		// Data attributes for JS validation
		if ( ! empty( $item['max_file_size'] ) ) {
			$attrs['data-max-size'] = intval( $item['max_file_size'] ) * 1024 * 1024; // Convert to bytes
		}

		if ( ! empty( $item['max_files'] ) ) {
			$attrs['data-max-files'] = intval( $item['max_files'] );
		}

		echo '<div class="royal-form-upload-wrapper">';
		echo '<input' . $this->render_attributes( $attrs ) . '>';
		echo '<div class="royal-form-upload-preview"></div>';
		echo '</div>';

		$this->render_field_wrapper_end();
	}

	public function validate( $field, $record, $ajax_handler ) {
		$files = $field['files'] ?? [];

		if ( ! empty( $field['required'] ) && empty( $files ) ) {
			$ajax_handler->add_error_message(
				sprintf(
					esc_html__( '%s is required.', 'royal-addons-for-elementor' ),
					$field['field_label']
				)
			);
			return false;
		}

		if ( empty( $files ) ) {
			return true;
		}

		// Validate file types
		$allowed_types = [];
		if ( ! empty( $field['file_types'] ) ) {
			$allowed_types = array_map( 'trim', explode( ',', strtolower( $field['file_types'] ) ) );
		}

		// Validate file size
		$max_size = ! empty( $field['max_file_size'] ) ? intval( $field['max_file_size'] ) * 1024 * 1024 : 5 * 1024 * 1024;

		foreach ( $files as $file ) {
			// Check file type
			if ( ! empty( $allowed_types ) ) {
				$ext = strtolower( pathinfo( $file['name'], PATHINFO_EXTENSION ) );
				if ( ! in_array( $ext, $allowed_types ) ) {
					$ajax_handler->add_error_message(
						sprintf(
							esc_html__( 'File type "%s" is not allowed for %s.', 'royal-addons-for-elementor' ),
							$ext,
							$field['field_label']
						)
					);
					return false;
				}
			}

			// Check file size
			if ( $file['size'] > $max_size ) {
				$ajax_handler->add_error_message(
					sprintf(
						esc_html__( 'File "%s" exceeds the maximum size of %d MB.', 'royal-addons-for-elementor' ),
						$file['name'],
						$field['max_file_size']
					)
				);
				return false;
			}
		}

		return true;
	}

	public function process_value( $value, $field ) {
		// File handling is done separately
		return $value;
	}
}
