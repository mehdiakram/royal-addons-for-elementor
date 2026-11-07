<?php
namespace RoyalAddons\Extensions\Conditions;

use Elementor\Controls_Manager;
use Elementor\Element_Base;

if ( ! defined( 'ABSPATH' ) ) exit;

// The class name now matches the file name for consistency.
class Royal_Condition_Time extends Royal_Condition_Base {

    public function get_name() {
        return 'time';
    }

    public function get_title() {
        return __( 'Time Range', 'royal-addons-for-elementor' );
    }

    /**
     * This was a MISSING METHOD.
     * It provides two time-picker controls for the start and end times.
     */
    public function get_controls() {
        return [
            'start_time' => [
                'label' => __( 'Start', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::DATE_TIME,
                'picker_options' => [
                    'enableTime' => true,
                    'noCalendar' => true,
                    'dateFormat' => 'H:i',
                ],
            ],
            'end_time' => [
                'label' => __( 'End', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::DATE_TIME,
                'picker_options' => [
                    'enableTime' => true,
                    'noCalendar' => true,
                    'dateFormat' => 'H:i',
                ],
            ],
        ];
    }

    /**
     * This was a MISSING METHOD.
     * It contains the logic to check if the current time is within the selected range.
     */
    public function check( $rule, $operator ) {
        $start_time_str = $rule['start_time'] ?? null;
        $end_time_str   = $rule['end_time'] ?? null;

        if ( empty( $start_time_str ) || empty( $end_time_str ) ) {
            return false;
        }

        // Get the current time in 24-hour format based on WordPress timezone.
        $now   = current_time( 'H:i' );
        $start = date( 'H:i', strtotime( $start_time_str ) );
        $end   = date( 'H:i', strtotime( $end_time_str ) );
        
        $condition_met = false;
        
        // This logic correctly handles overnight ranges (e.g., 22:00 to 02:00)
        if ( $start <= $end ) {
            // Normal range (e.g., 09:00 to 17:00)
            $condition_met = ( $now >= $start && $now <= $end );
        } else {
            // Overnight range (e.g., 22:00 to 02:00)
            $condition_met = ( $now >= $start || $now <= $end );
        }

        return ( 'is' === $operator ) ? $condition_met : ! $condition_met;
    }
}