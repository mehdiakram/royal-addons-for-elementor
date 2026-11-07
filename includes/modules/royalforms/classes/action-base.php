<?php
namespace RoyalAddons\Modules\Forms\Classes;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Action_Base {

	private $actions = [];

	public function get_name() {
		return '';
	}

	public function get_label() {
		return '';
	}

	public function run( $record, $ajax_handler ) {
		// To be implemented by subclasses
	}

	public function register( $instance ) {
		$this->actions[ $instance->get_name() ] = $instance;
	}

	public function get_action( $name ) {
		return isset( $this->actions[ $name ] ) ? $this->actions[ $name ] : null;
	}
	
	public function get_all() {
		return $this->actions;
	}
}
