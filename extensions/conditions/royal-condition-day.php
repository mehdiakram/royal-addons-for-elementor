<?php
namespace RoyalAddons\Extensions\Conditions;

use Elementor\Controls_Manager;
use Elementor\Element_Base;

if ( ! defined( 'ABSPATH' ) ) exit;

class Royal_Condition_Day extends Royal_Condition_Base {

    // 1. Get the unique name for the condition
    public function get_name() {
        return 'day';
    }

    // 2. Get the title for the UI
    public function get_title() {
        return __( 'Day of the Week', 'royal-addons-for-elementor' );
    }

    /**
     * 3. This was a MISSING METHOD.
     * It provides the dropdown control with the days of the week.
     */
    public function get_controls() {
        return [
            'day_of_week' => [
                'label' => __( 'Day', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    '1' => __( 'Monday', 'royal-addons-for-elementor' ),
                    '2' => __( 'Tuesday', 'royal-addons-for-elementor' ),
                    '3' => __( 'Wednesday', 'royal-addons-for-elementor' ),
                    '4' => __( 'Thursday', 'royal-addons-for-elementor' ),
                    '5' => __( 'Friday', 'royal-addons-for-elementor' ),
                    '6' => __( 'Saturday', 'royal-addons-for-elementor' ),
                    '7' => __( 'Sunday', 'royal-addons-for-elementor' ),
                ],
            ]
        ];
    }

    /**
     * 4. This was a MISSING METHOD.
     * It contains the logic to check if today is the selected day.
     */
    public function check( $rule, $operator ) {
        $selected_day = $rule['day_of_week'] ?? '';

        // Get today's day of the week (1 for Monday, 7 for Sunday)
        // This uses your WordPress timezone settings.
        $today = current_time('N');

        $condition_met = ( $today === $selected_day );

        return ( 'is' === $operator ) ? $condition_met : ! $condition_met;
    }
}