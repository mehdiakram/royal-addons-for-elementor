<?php
namespace RoyalAddons\Modules\Forms\Classes;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Form_Record {

	private $fields = [];
	private $form_settings = [];
	private $files = [];
	private $meta = [];

	public function __construct( $fields, $files ) {
		$this->fields = $fields;
		$this->files = $files;
		
		// Collect meta data
		$this->meta = [
			'page_url'    => isset( $_POST['page_url'] ) ? esc_url_raw( $_POST['page_url'] ) : '',
			'post_id'     => isset( $_POST['post_id'] ) ? absint( $_POST['post_id'] ) : 0,
			'referrer'    => wp_get_referer() ?: '',
			'user_id'     => get_current_user_id(),
			'user_ip'     => $this->get_user_ip(),
			'submit_time' => current_time( 'mysql' ),
		];
	}

	public function set_form_settings( $settings ) {
		$this->form_settings = $settings;
	}

	public function get_form_settings( $setting = null ) {
		if ( $setting ) {
			return isset( $this->form_settings[ $setting ] ) ? $this->form_settings[ $setting ] : null;
		}

		return $this->form_settings;
	}

	public function get( $name ) {
		if ( isset( $this->fields[ $name ] ) ) {
			return $this->fields[ $name ];
		}

		return null;
	}

	public function update_field( $field_id, $value ) {
		$this->fields[ $field_id ] = $value;
	}

	public function get_formatted_data() {
		$formatted = [];
		
		foreach ( $this->fields as $key => $value ) {
			// Handle arrays (checkbox, multi-select)
			if ( is_array( $value ) ) {
				$formatted[ $key ] = implode( ', ', $value );
			} else {
				$formatted[ $key ] = $value;
			}
		}
		
		return $formatted;
	}

	public function get_fields() {
		return $this->fields;
	}

	public function get_field( $id ) {
		if ( isset( $this->fields[ $id ] ) ) {
			return $this->fields[ $id ];
		}

		// Also check form_fields settings for field config
		$form_fields = isset( $this->form_settings['form_fields'] ) ? $this->form_settings['form_fields'] : [];
		foreach ( $form_fields as $field ) {
			if ( isset( $field['custom_id'] ) && $id === $field['custom_id'] ) {
				$field['value'] = isset( $this->fields[ $id ] ) ? $this->fields[ $id ] : '';
				return $field;
			}
		}
		
		return false;
	}

	public function get_field_with_settings( $field_id ) {
		$form_fields = isset( $this->form_settings['form_fields'] ) ? $this->form_settings['form_fields'] : [];
		
		foreach ( $form_fields as $field ) {
			if ( isset( $field['custom_id'] ) && $field_id === $field['custom_id'] ) {
				$field['value'] = isset( $this->fields[ $field_id ] ) ? $this->fields[ $field_id ] : '';
				return $field;
			}
		}
		
		return null;
	}

	public function get_files() {
		return $this->files;
	}

	public function get_meta( $key = null ) {
		if ( $key ) {
			return isset( $this->meta[ $key ] ) ? $this->meta[ $key ] : null;
		}
		return $this->meta;
	}

	private function get_user_ip() {
		$ip = '';

		if ( ! empty( $_SERVER['HTTP_CLIENT_IP'] ) ) {
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		} elseif ( ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} elseif ( ! empty( $_SERVER['REMOTE_ADDR'] ) ) {
			$ip = $_SERVER['REMOTE_ADDR'];
		}

		return sanitize_text_field( $ip );
	}
}

