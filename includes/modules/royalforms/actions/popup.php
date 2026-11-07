<?php
namespace RoyalAddons\Modules\Forms\Actions;

use RoyalAddons\Modules\Forms\Classes\Action_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Popup extends Action_Base {

	public function get_name() {
		return 'popup';
	}

	public function get_label() {
		return esc_html__( 'Popup', 'royal-addons-for-elementor' );
	}

	public function run( $record, $ajax_handler ) {
		$settings = $record->get_form_settings();
		
		$popup_action = isset( $settings['popup_action'] ) ? $settings['popup_action'] : 'close';
		
		switch ( $popup_action ) {
			case 'close':
				$ajax_handler->add_response_data( 'popup_action', 'close' );
				break;
				
			case 'open':
				$popup_id = isset( $settings['popup_to_open'] ) ? absint( $settings['popup_to_open'] ) : 0;
				if ( $popup_id ) {
					$ajax_handler->add_response_data( 'popup_action', 'open' );
					$ajax_handler->add_response_data( 'popup_id', $popup_id );
				}
				break;
				
			case 'close_and_open':
				$popup_id = isset( $settings['popup_to_open'] ) ? absint( $settings['popup_to_open'] ) : 0;
				if ( $popup_id ) {
					$ajax_handler->add_response_data( 'popup_action', 'close_and_open' );
					$ajax_handler->add_response_data( 'popup_id', $popup_id );
				}
				break;
		}
	}
}
