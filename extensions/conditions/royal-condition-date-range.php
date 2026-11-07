<?php
namespace RoyalAddons\Extensions\Conditions;

use Elementor\Controls_Manager;
use Elementor\Element_Base;

if ( ! defined( 'ABSPATH' ) ) exit;

class Royal_Condition_Date_Range extends Royal_Condition_Base {

    public function get_name() {
        return 'date_range';
    }

    public function get_title() {
        return __( 'Date Range', 'royal-addons-for-elementor' );
    }

    // Returns an array with MULTIPLE controls for the repeater
    public function get_controls() {
        return [
            'start_date' => [
                'label' => __( 'Start', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::DATE_TIME,
            ],
            'end_date' => [
                'label' => __( 'End', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::DATE_TIME,
            ],
        ];
    }

    // The check method now contains all the logic.
    public function check( $rule, $operator ) {
        $start_date_str = $rule['start_date'] ?? null;
        $end_date_str   = $rule['end_date'] ?? null;

        // If dates aren't set, condition fails
        if ( empty( $start_date_str ) || empty( $end_date_str ) ) {
            return false;
        }
        
        // Get wordpress's current time, which respects timezone settings
        $now = current_time('timestamp');
        $start = strtotime( $start_date_str );
        $end = strtotime( $end_date_str );

        $condition_met = ( $now >= $start && $now <= $end );
        
        return ( 'is' === $operator ) ? $condition_met : ! $condition_met;
    }
}