<?php
namespace RoyalAddons\Modules\Forms\Classes;

use Elementor\Core\Utils\Exceptions;
use RoyalAddons\Modules\Forms\Module;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Ajax_Handler {

	private static $initialized = false;
	
	public $is_success = true;
	public $messages = [
		'success' => [],
		'error' => [],
	];
	public $data = [];
	public $errors = [];
	public $field_errors = [];

	public function __construct() {
		// Prevent duplicate registration
		if ( self::$initialized ) {
			return;
		}
		self::$initialized = true;
		
		add_action( 'wp_ajax_royal_elementor_form_submit', [ $this, 'ajax_handler' ] );
		add_action( 'wp_ajax_nopriv_royal_elementor_form_submit', [ $this, 'ajax_handler' ] );
	}

	public function ajax_handler() {
		$data = $_REQUEST;

		// Basic security check
		if ( empty( $data['form_id'] ) || empty( $data['post_id'] ) ) {
			$this->add_error_message( esc_html__( 'Invalid form submission.', 'royal-addons-for-elementor' ) );
			$this->send();
			return;
		}

		// Prevent duplicate submissions (Server-side lock)
		$user_agent = isset( $_SERVER['HTTP_USER_AGENT'] ) ? $_SERVER['HTTP_USER_AGENT'] : '';
		$submission_hash = md5( serialize( $data ) . $_SERVER['REMOTE_ADDR'] . $user_agent );
		$transient_key = 'royal_form_submit_' . $submission_hash;

		// Debug duplicate
		error_log( "ROYAL FORM DEBUG: Hash: $transient_key" );

		if ( get_transient( $transient_key ) ) {
			error_log( "ROYAL FORM DEBUG: Duplicate blocked!" );
			$this->add_success_message( esc_html__( 'Form already submitted.', 'royal-addons-for-elementor' ) );
			$this->send();
			return;
		}
		
		// Set lock for 600 seconds (10 minutes)
		set_transient( $transient_key, true, 600 );

		$form_id = sanitize_text_field( $data['form_id'] );
		$post_id = absint( $data['post_id'] );
		$form_fields = isset( $data['form_fields'] ) ? $data['form_fields'] : [];

		// Get widget settings from Elementor document
		$document = \Elementor\Plugin::$instance->documents->get( $post_id );
		$widget_settings = [];
		
		if ( $document ) {
			$data_settings = $document->get_elements_data();
			$widget_settings = $this->find_element_recursive( $data_settings, $form_id );
		}

		if ( empty( $widget_settings ) ) {
			$this->add_error_message( esc_html__( 'Form not found.', 'royal-addons-for-elementor' ) );
			$this->send();
			return;
		}

		// Add form_id to settings
		$widget_settings['form_id'] = $form_id;

		// Create form record
		$record = new Form_Record( $form_fields, $_FILES );
		$record->set_form_settings( $widget_settings );

		// Validate all fields
		$validation = new Validation();
		$form_field_settings = isset( $widget_settings['form_fields'] ) ? $widget_settings['form_fields'] : [];
		$all_valid = true;

		// Check honeypot first
		$validation->validate_honeypot( $form_field_settings, $form_fields );
		if ( ! $validation->is_valid() ) {
			// Silently fail for bots - don't give them information
			$this->add_success_message( $widget_settings['success_message'] ?? esc_html__( 'The message was sent successfully.', 'royal-addons-for-elementor' ) );
			$this->send();
			return;
		}

		// Validate each field
		foreach ( $form_field_settings as $field ) {
			$field_id = $field['custom_id'] ?? '';
			$field_value = isset( $form_fields[ $field_id ] ) ? $form_fields[ $field_id ] : '';
			
			// Get files for this field if it's a file upload
			$field_files = [];
			$field_type = $field['field_type'] ?? 'text';
			if ( $field_type === 'file' && ! empty( $_FILES ) ) {
				foreach ( $_FILES as $key => $file_data ) {
					if ( strpos( $key, $field_id ) !== false ) {
						$field_files[] = $file_data;
					}
				}
			}

			$errors = $validation->validate_field( $field, $field_value, $field_files );
			
			if ( ! empty( $errors ) ) {
				$all_valid = false;
				$this->field_errors = array_merge( $this->field_errors, $errors );
				foreach ( $errors as $error_message ) {
					$this->add_error_message( $error_message );
				}
			}

			// Sanitize and update field value in record
			$sanitized_value = Validation::sanitize_value( $field_value, $field_type );
			$record->update_field( $field_id, $sanitized_value );
		}

		if ( ! $all_valid ) {
			$this->errors = $this->field_errors;
			$this->send();
			return;
		}

		// All validations passed, run actions
		$actions = Module::instance()->actions_registrar->get_all();
		$widget_actions = isset( $widget_settings['submit_actions'] ) ? $widget_settings['submit_actions'] : [ 'email' ];
		
		if ( ! is_array( $widget_actions ) ) {
			$widget_actions = [ $widget_actions ];
		}
		
		// Remove duplicates from widget_actions
		$widget_actions = array_unique( $widget_actions );

		foreach ( $actions as $action_name => $action ) {
			if ( in_array( $action_name, $widget_actions ) ) {
				$action->run( $record, $this );
			}
		}

		// If no success message was added by actions, add default
		if ( $this->is_success && empty( $this->messages['success'] ) ) {
			$this->add_success_message( 
				$widget_settings['success_message'] ?? esc_html__( 'The message was sent successfully.', 'royal-addons-for-elementor' ) 
			);
		}

		$this->send();
	}

	private function find_element_recursive( $elements, $form_id ) {
		foreach ( $elements as $element ) {
			if ( $form_id === $element['id'] ) {
				return $element['settings'];
			}

			if ( ! empty( $element['elements'] ) ) {
				$found = $this->find_element_recursive( $element['elements'], $form_id );
				if ( $found ) {
					return $found;
				}
			}
		}

		return false;
	}

	public function add_success_message( $message ) {
		$this->messages['success'][] = $message;
	}

	public function add_error_message( $message ) {
		$this->messages['error'][] = $message;
		$this->is_success = false;
	}

	public function add_response_data( $key, $data ) {
		$this->data[ $key ] = $data;
	}

	public function add_field_error( $field_id, $message ) {
		$this->field_errors[ $field_id ] = $message;
		$this->add_error_message( $message );
	}

	public function send() {
		$response = [
			'success' => $this->is_success,
			'data' => [
				'message' => $this->is_success 
					? implode( '<br>', $this->messages['success'] ) 
					: implode( '<br>', $this->messages['error'] ),
				'errors' => $this->errors,
				'field_errors' => $this->field_errors,
				'data' => $this->data,
			],
		];

		wp_send_json( $response );
	}
}

