<?php
namespace RoyalAddons\Extensions\Conditions;

use Elementor\Controls_Manager;
use Elementor\Element_Base;

if ( ! defined( 'ABSPATH' ) ) exit;

class Royal_Condition_Operating_System extends Royal_Condition_Base {

    public function get_name() {
        return 'operating_system';
    }

    public function get_title() {
        return __( 'Operating System', 'royal-addons-for-elementor' );
    }

    /**
     * This method is now correctly named get_controls().
     */
    public function get_controls() {
        return [
            // The key of this array is the control name used in the check() method.
            'os_name' => [
                'label'   => $this->get_title(),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    'windows'    => __( 'Windows', 'royal-addons-for-elementor' ),
                    'mac_os'     => __( 'Mac OS', 'royal-addons-for-elementor' ),
                    'linux'      => __( 'Linux', 'royal-addons-for-elementor' ),
                    'ubuntu'     => __( 'Ubuntu', 'royal-addons-for-elementor' ),
                    'iphone'     => __( 'iPhone', 'royal-addons-for-elementor' ),
                    'ipad'       => __( 'iPad', 'royal-addons-for-elementor' ),
                    'android'    => __( 'Android', 'royal-addons-for-elementor' ),
                    'search_bot' => __( 'Search Bot', 'royal-addons-for-elementor' ),
                ],
            ]
        ];
    }

    /**
     * This is the required check() method.
     * It now contains all the logic.
     */
    public function check( $rule, $operator ) {
        $selected_os = $rule['os_name'] ?? '';
        $current_os  = $this->get_current_os();

        $condition_met = ( $selected_os === $current_os );

        return ( 'is' === $operator ) ? $condition_met : $condition_met;
    }

    /**
     * Your helper function to get the current visitor's OS.
     * This is a good way to check the OS on the backend.
     */
    private function get_current_os() {
        $user_agent = $_SERVER['HTTP_USER_AGENT'] ?? '';
        if ( empty( $user_agent ) ) {
            return 'unknown';
        }
        
        // Match for bots first
        if ( preg_match( '/bot|crawl|slurp|spider|mediapartners/i', $user_agent ) ) {
            return 'search_bot';
        }

        // OS matching - order is important (e.g., check for ubuntu before linux)
        if ( preg_match( '/windows nt/i', $user_agent ) ) return 'windows';
        if ( preg_match( '/macintosh|mac os x/i', $user_agent ) ) return 'mac_os';
        if ( preg_match( '/ubuntu/i', $user_agent ) ) return 'ubuntu';
        if ( preg_match( '/linux/i', $user_agent ) ) return 'linux';
        if ( preg_match( '/iphone/i', $user_agent ) ) return 'iphone';
        if ( preg_match( '/ipad/i', $user_agent ) ) return 'ipad';
        if ( preg_match( '/android/i', $user_agent ) ) return 'android';
        
        return 'unknown';
    }
}