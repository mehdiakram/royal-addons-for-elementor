<?php
namespace RoyalAddons\Modules\Forms\Fields;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Date extends Field_Base {

	public function get_type() {
		return 'date';
	}

	public function get_name() {
		return esc_html__( 'Date', 'royal-addons-for-elementor' );
	}

	public function get_field_controls() {
		return [
			'min_date' => [
				'label' => esc_html__( 'Min Date', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::DATE_TIME,
				'picker_options' => [
					'enableTime' => false,
				],
				'condition' => [ 'field_type' => $this->get_type() ],
			],
			'max_date' => [
				'label' => esc_html__( 'Max Date', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::DATE_TIME,
				'picker_options' => [
					'enableTime' => false,
				],
				'condition' => [ 'field_type' => $this->get_type() ],
			],
		];
	}

	public function render( $item, $item_index, $form ) {
		$this->render_field_wrapper_start( $item );
		$this->render_label( $item, $form );

		$attrs = $this->get_field_attributes( $item, $form );
		$attrs['type'] = 'date';

		if ( ! empty( $item['min_date'] ) ) {
			$attrs['min'] = date( 'Y-m-d', strtotime( $item['min_date'] ) );
		}
		if ( ! empty( $item['max_date'] ) ) {
			$attrs['max'] = date( 'Y-m-d', strtotime( $item['max_date'] ) );
		}
		if ( ! empty( $item['field_value'] ) ) {
			$attrs['value'] = $item['field_value'];
		}

		echo '<input' . $this->render_attributes( $attrs ) . '>';

		$this->render_field_wrapper_end();
	}
}
