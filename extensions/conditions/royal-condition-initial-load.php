<?php
namespace RoyalAddons\Extensions\Conditions;

use Elementor\Controls_Manager;
use Elementor\Element_Base;

if ( ! defined( 'ABSPATH' ) ) exit;

class Royal_Condition_Initial_Load extends Royal_Condition_Base {

    public function get_name() {
        return 'initial_load';
    }

    public function get_title() {
        return __( 'On Initial Load', 'royal-addons-for-elementor' );
    }

    /**
     * This was a MISSING METHOD.
     * For this condition, we don't need any special controls, so we return an empty array.
     */
    public function get_controls() {
        // This condition doesn't require any user-configurable options in the repeater,
        // so we can return an empty array.
        return [];
    }

    /**
     * This was a MISSING METHOD.
     * The logic for this condition is handled by JavaScript, not PHP.
     * This PHP check will simply pass, allowing the element to render
     * so the JavaScript can then hide/show it.
     */
    public function check( $rule, $operator ) {
        // Since the actual effect (like a fade-in) is handled by JavaScript,
        // this PHP check should always pass so the element exists on the page
        // for the script to find.
        $condition_met = true;

        return ( 'is' === $operator ) ? $condition_met : ! $condition_met;
    }
}