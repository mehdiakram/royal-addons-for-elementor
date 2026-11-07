<?php
namespace RoyalAddons\Modules\Forms\Fields;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Html extends Field_Base {

	public function get_type() {
		return 'html';
	}

	public function get_name() {
		return esc_html__( 'HTML', 'royal-addons-for-elementor' );
	}

	public function get_field_controls() {
		return [
			'html_content' => [
				'label' => esc_html__( 'HTML Content', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::WYSIWYG,
				'condition' => [ 'field_type' => $this->get_type() ],
				'default' => '<p>' . esc_html__( 'Custom HTML content goes here...', 'royal-addons-for-elementor' ) . '</p>',
			],
		];
	}

	public function render( $item, $item_index, $form ) {
		$this->render_field_wrapper_start( $item );

		$content = $item['html_content'] ?? '';
		echo '<div class="royal-form-html-content">' . wp_kses_post( $content ) . '</div>';

		$this->render_field_wrapper_end();
	}

	public function validate( $field, $record, $ajax_handler ) {
		// HTML fields don't need validation
		return true;
	}

	public function process_value( $value, $field ) {
		// HTML fields don't submit values
		return '';
	}
}
