<?php
namespace RoyalAddons\Extensions\Conditions;

use Elementor\Controls_Manager;
use Elementor\Element_Base;

if ( ! defined( 'ABSPATH' ) ) exit;

class Royal_Condition_Login_Status extends Royal_Condition_Base {

    public function get_name() {
        return 'login_status';
    }

    public function get_title() {
        return __( 'Login Status', 'royal-addons-for-elementor' );
    }

    public function get_controls() {
        return [
            'login_status' => [ // Control name
                'label' => __( 'Status', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'logged_in' => __( 'Logged In', 'royal-addons-for-elementor' ),
                    'logged_out' => __( 'Logged Out', 'royal-addons-for-elementor' ),
                ],
            ]
        ];
    }

    // The check() method has the correct signature: ($rule, $operator)
    public function check( $rule, $operator ) {
        $user_status = $rule['login_status'] ?? 'logged_out';
        $is_logged_in = is_user_logged_in();

        $condition_met = false;
        if ( 'logged_in' === $user_status && $is_logged_in ) {
            $condition_met = true;
        }
        if ( 'logged_out' === $user_status && ! $is_logged_in ) {
            $condition_met = true;
        }

        return ( 'is' === $operator ) ? $condition_met : ! $condition_met;
    }
}