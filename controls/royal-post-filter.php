<?php
namespace RoyalAddons\Controls;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Control_Select2;

class Royal_Post_Filter extends Control_Select2 {

	const TYPE = 'royal-post-filter';

	public function get_type() {
		return self::TYPE;
	}

}
