<?php
namespace RoyalAddons\Extensions\Conditions;

use Elementor\Controls_Manager;
use Elementor\Element_Base;

if ( ! defined( 'ABSPATH' ) ) exit;

class Royal_Condition_Date extends Royal_Condition_Base {

    // You already had this method. It's correct.
    public function get_name() {
        return 'date';
    }

    // You already had this method. It's correct.
    public function get_title() {
        return __( 'Specific Date', 'royal-addons-for-elementor' );
    }

    /**
     * This was a MISSING METHOD.
     * It provides the date picker control in the editor.
     */
    public function get_controls() {
        return [
            'specific_date' => [
                'label' => __( 'Date', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::DATE_TIME,
                'picker_options' => [
                    'enableTime' => false, // We only want to compare the date, not the time
                ],
            ]
        ];
    }

    /**
     * This was a MISSING METHOD.
     * It contains the logic to check if today is the selected date.
     */
    public function check( $rule, $operator ) {
        $selected_date_str = $rule['specific_date'] ?? null;

        if ( empty( $selected_date_str ) ) {
            return false;
        }

        // Get today's date based on your WordPress timezone settings
        $today = current_time( 'Y-m-d' );
        
        // Get the date selected by the user
        $selected_date = date( 'Y-m-d', strtotime( $selected_date_str ) );

        $condition_met = ( $today === $selected_date );

        return ( 'is' === $operator ) ? $condition_met : ! $condition_met;
    }
}