<?php
namespace RoyalAddons\Extensions\Conditions;

use Elementor\Controls_Manager;
use Elementor\Element_Base;

if ( ! defined( 'ABSPATH' ) ) exit;

class Royal_Condition_Browser extends Royal_Condition_Base {

    public function get_name() {
        return 'browser';
    }

    public function get_title() {
        return __( 'Browser', 'royal-addons-for-elementor' );
    }

    public function get_controls() {
        return [
            'browser_name' => [
                'label' => __( 'Browser', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'firefox' => 'Firefox',
                    'opera'   => 'Opera',
                    'edge'    => 'Edge',
                    'chrome'  => 'Chrome',
                    'safari'  => 'Safari',
                ],
            ]
        ];
    }

    /**
     * This check now uses PHP to inspect the User Agent string.
     */
    public function check( $rule, $operator ) {
        $selected_browser = $rule['browser_name'] ?? '';
        $user_agent = $_SERVER['HTTP_USER_AGENT'] ?? '';

        $current_browser = 'unknown';
        if (stripos($user_agent, 'Firefox') !== false) $current_browser = 'firefox';
        if (stripos($user_agent, 'OPR') !== false || stripos($user_agent, 'Opera') !== false) $current_browser = 'opera';
        if (stripos($user_agent, 'Edg') !== false) $current_browser = 'edge';
        if (stripos($user_agent, 'Chrome') !== false && stripos($user_agent, 'Edg') === false) $current_browser = 'chrome'; // Make sure it's not Edge
        if (stripos($user_agent, 'Safari') !== false && stripos($user_agent, 'Chrome') === false && stripos($user_agent, 'Edg') === false) $current_browser = 'safari'; // Make sure it's not Chrome or Edge

        $condition_met = ($current_browser === $selected_browser);

        return ( 'is' === $operator ) ? $condition_met : ! $condition_met;
    }
}