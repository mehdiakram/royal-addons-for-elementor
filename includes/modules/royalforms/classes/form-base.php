<?php
namespace RoyalAddons\Modules\Forms\Classes;

use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

abstract class Form_Base extends Widget_Base {
	// Common methods for rendering fields can go here, similar to Pro Elements Form_Base
	// For now, we will leave it relatively empty or add helper methods as needed by the main widget.
	
	public static function get_button_sizes() {
		return [
			'xs' => esc_html__( 'Extra Small', 'royal-addons-for-elementor' ),
			'sm' => esc_html__( 'Small', 'royal-addons-for-elementor' ),
			'md' => esc_html__( 'Medium', 'royal-addons-for-elementor' ),
			'lg' => esc_html__( 'Large', 'royal-addons-for-elementor' ),
			'xl' => esc_html__( 'Extra Large', 'royal-addons-for-elementor' ),
		];
	}
}
