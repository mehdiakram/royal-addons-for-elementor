<?php
namespace RoyalAddons\Modules\Forms\Fields;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Tel extends Field_Base {

	public function get_type() {
		return 'tel';
	}

	public function get_name() {
		return esc_html__( 'Phone', 'royal-addons-for-elementor' );
	}

	public function get_field_controls() {
		return [
			'phone_pattern' => [
				'label' => esc_html__( 'Pattern', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'condition' => [ 'field_type' => $this->get_type() ],
				'description' => esc_html__( 'e.g., [0-9]{10} for 10 digits', 'royal-addons-for-elementor' ),
			],
		];
	}

	public function render( $item, $item_index, $form ) {
		$this->render_field_wrapper_start( $item );
		$this->render_label( $item, $form );

		$attrs = $this->get_field_attributes( $item, $form );
		$attrs['type'] = 'tel';

		if ( ! empty( $item['phone_pattern'] ) ) {
			$attrs['pattern'] = $item['phone_pattern'];
		}

		if ( ! empty( $item['field_value'] ) ) {
			$attrs['value'] = $item['field_value'];
		}

		echo '<input' . $this->render_attributes( $attrs ) . '>';

		$this->render_field_wrapper_end();
	}
}
