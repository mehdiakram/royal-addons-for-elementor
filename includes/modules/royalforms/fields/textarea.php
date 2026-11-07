<?php
namespace RoyalAddons\Modules\Forms\Fields;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Textarea extends Field_Base {

	public function get_type() {
		return 'textarea';
	}

	public function get_name() {
		return esc_html__( 'Textarea', 'royal-addons-for-elementor' );
	}

	public function get_field_controls() {
		return [
			'rows' => [
				'label' => esc_html__( 'Rows', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'condition' => [ 'field_type' => $this->get_type() ],
				'default' => 4,
				'min' => 1,
				'max' => 20,
			],
			'min_length' => [
				'label' => esc_html__( 'Min Length', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'condition' => [ 'field_type' => $this->get_type() ],
				'min' => 0,
			],
			'max_length' => [
				'label' => esc_html__( 'Max Length', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'condition' => [ 'field_type' => $this->get_type() ],
				'min' => 0,
			],
		];
	}

	public function render( $item, $item_index, $form ) {
		$this->render_field_wrapper_start( $item );
		$this->render_label( $item, $form );

		$attrs = $this->get_field_attributes( $item, $form );
		$attrs['rows'] = ! empty( $item['rows'] ) ? $item['rows'] : 4;

		if ( ! empty( $item['min_length'] ) ) {
			$attrs['minlength'] = $item['min_length'];
		}
		if ( ! empty( $item['max_length'] ) ) {
			$attrs['maxlength'] = $item['max_length'];
		}

		$value = ! empty( $item['field_value'] ) ? $item['field_value'] : '';

		echo '<textarea' . $this->render_attributes( $attrs ) . '>' . esc_textarea( $value ) . '</textarea>';

		$this->render_field_wrapper_end();
	}

	public function process_value( $value, $field ) {
		return sanitize_textarea_field( $value );
	}
}
