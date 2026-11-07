<?php
namespace RoyalAddons\Modules\Forms\Fields;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Step extends Field_Base {

	public function get_type() {
		return 'step';
	}

	public function get_name() {
		return esc_html__( 'Step', 'royal-addons-for-elementor' );
	}

	public function get_field_controls() {
		return [
			'step_title' => [
				'label' => esc_html__( 'Step Title', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'condition' => [ 'field_type' => $this->get_type() ],
				'default' => esc_html__( 'Step', 'royal-addons-for-elementor' ),
			],
			'step_icon' => [
				'label' => esc_html__( 'Step Icon', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::ICONS,
				'condition' => [ 'field_type' => $this->get_type() ],
			],
			'previous_button_text' => [
				'label' => esc_html__( 'Previous Button Text', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'condition' => [ 'field_type' => $this->get_type() ],
				'default' => esc_html__( 'Previous', 'royal-addons-for-elementor' ),
			],
			'next_button_text' => [
				'label' => esc_html__( 'Next Button Text', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'condition' => [ 'field_type' => $this->get_type() ],
				'default' => esc_html__( 'Next', 'royal-addons-for-elementor' ),
			],
		];
	}

	public function render( $item, $item_index, $form ) {
		static $step_count = 0;
		$step_count++;
		$is_first_step = ( $step_count === 1 );

		// Close previous step if not first
		if ( ! $is_first_step ) {
			// Previous step navigation
			echo '<div class="royal-form-step-navigation">';
			
			$prev_text = $item['previous_button_text'] ?? esc_html__( 'Previous', 'royal-addons-for-elementor' );
			echo '<button type="button" class="royal-form-step-prev elementor-button">' . esc_html( $prev_text ) . '</button>';
			
			$next_text = $item['next_button_text'] ?? esc_html__( 'Next', 'royal-addons-for-elementor' );
			echo '<button type="button" class="royal-form-step-next elementor-button">' . esc_html( $next_text ) . '</button>';
			
			echo '</div>';
			echo '</div>'; // Close previous step div
		}

		// Start new step
		$active_class = $is_first_step ? ' royal-form-step-active' : '';
		$step_title = $item['step_title'] ?? esc_html__( 'Step', 'royal-addons-for-elementor' ) . ' ' . $step_count;

		echo '<div class="royal-form-step' . esc_attr( $active_class ) . '" data-step="' . esc_attr( $step_count ) . '" data-step-title="' . esc_attr( $step_title ) . '">';
	}

	public function validate( $field, $record, $ajax_handler ) {
		// Step fields don't need validation
		return true;
	}

	public function process_value( $value, $field ) {
		// Step fields don't submit values
		return '';
	}
}
