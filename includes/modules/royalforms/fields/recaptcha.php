<?php
namespace RoyalAddons\Modules\Forms\Fields;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Recaptcha extends Field_Base {

	public function get_type() {
		return 'recaptcha';
	}

	public function get_name() {
		return esc_html__( 'reCAPTCHA', 'royal-addons-for-elementor' );
	}

	public function get_field_controls() {
		return [
			'recaptcha_version' => [
				'label' => esc_html__( 'reCAPTCHA Version', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'condition' => [ 'field_type' => $this->get_type() ],
				'options' => [
					'v2' => esc_html__( 'reCAPTCHA v2', 'royal-addons-for-elementor' ),
					'v3' => esc_html__( 'reCAPTCHA v3', 'royal-addons-for-elementor' ),
				],
				'default' => 'v2',
			],
			'recaptcha_theme' => [
				'label' => esc_html__( 'Theme', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'condition' => [
					'field_type' => $this->get_type(),
					'recaptcha_version' => 'v2',
				],
				'options' => [
					'light' => esc_html__( 'Light', 'royal-addons-for-elementor' ),
					'dark' => esc_html__( 'Dark', 'royal-addons-for-elementor' ),
				],
				'default' => 'light',
			],
			'recaptcha_size' => [
				'label' => esc_html__( 'Size', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'condition' => [
					'field_type' => $this->get_type(),
					'recaptcha_version' => 'v2',
				],
				'options' => [
					'normal' => esc_html__( 'Normal', 'royal-addons-for-elementor' ),
					'compact' => esc_html__( 'Compact', 'royal-addons-for-elementor' ),
				],
				'default' => 'normal',
			],
			'recaptcha_badge' => [
				'label' => esc_html__( 'Badge Position', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'condition' => [
					'field_type' => $this->get_type(),
					'recaptcha_version' => 'v3',
				],
				'options' => [
					'bottomright' => esc_html__( 'Bottom Right', 'royal-addons-for-elementor' ),
					'bottomleft' => esc_html__( 'Bottom Left', 'royal-addons-for-elementor' ),
					'inline' => esc_html__( 'Inline', 'royal-addons-for-elementor' ),
				],
				'default' => 'bottomright',
			],
		];
	}

	public function render( $item, $item_index, $form ) {
		$site_key = get_option( 'royal_recaptcha_site_key', '' );
		$version = $item['recaptcha_version'] ?? 'v2';

		if ( empty( $site_key ) ) {
			if ( current_user_can( 'manage_options' ) ) {
				echo '<div class="royal-form-recaptcha-error">';
				echo esc_html__( 'reCAPTCHA site key not configured. Please set it in Royal Addons settings.', 'royal-addons-for-elementor' );
				echo '</div>';
			}
			return;
		}

		$this->render_field_wrapper_start( $item );

		if ( 'v2' === $version ) {
			$theme = $item['recaptcha_theme'] ?? 'light';
			$size = $item['recaptcha_size'] ?? 'normal';

			echo '<div class="g-recaptcha" ';
			echo 'data-sitekey="' . esc_attr( $site_key ) . '" ';
			echo 'data-theme="' . esc_attr( $theme ) . '" ';
			echo 'data-size="' . esc_attr( $size ) . '">';
			echo '</div>';
		} else {
			// v3 uses invisible captcha
			echo '<input type="hidden" name="g-recaptcha-response" class="royal-recaptcha-v3-token">';
			echo '<input type="hidden" name="recaptcha_version" value="v3">';
		}

		$this->render_field_wrapper_end();
	}

	public function validate( $field, $record, $ajax_handler ) {
		$recaptcha_response = $_POST['g-recaptcha-response'] ?? '';
		$secret_key = get_option( 'royal_recaptcha_secret_key', '' );

		if ( empty( $secret_key ) ) {
			// If not configured, skip validation
			return true;
		}

		if ( empty( $recaptcha_response ) ) {
			$ajax_handler->add_error_message(
				esc_html__( 'Please complete the reCAPTCHA verification.', 'royal-addons-for-elementor' )
			);
			return false;
		}

		$response = wp_remote_post( 'https://www.google.com/recaptcha/api/siteverify', [
			'body' => [
				'secret' => $secret_key,
				'response' => $recaptcha_response,
				'remoteip' => $_SERVER['REMOTE_ADDR'],
			],
		] );

		if ( is_wp_error( $response ) ) {
			$ajax_handler->add_error_message(
				esc_html__( 'reCAPTCHA verification failed. Please try again.', 'royal-addons-for-elementor' )
			);
			return false;
		}

		$result = json_decode( wp_remote_retrieve_body( $response ), true );

		if ( empty( $result['success'] ) ) {
			$ajax_handler->add_error_message(
				esc_html__( 'reCAPTCHA verification failed. Please try again.', 'royal-addons-for-elementor' )
			);
			return false;
		}

		// For v3, check score
		if ( isset( $result['score'] ) && $result['score'] < 0.5 ) {
			$ajax_handler->add_error_message(
				esc_html__( 'reCAPTCHA verification failed. Please try again.', 'royal-addons-for-elementor' )
			);
			return false;
		}

		return true;
	}

	public function process_value( $value, $field ) {
		return ''; // reCAPTCHA doesn't submit a value to store
	}
}
