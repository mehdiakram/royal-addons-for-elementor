<?php
namespace RoyalAddons\Extensions\Conditions;

use Elementor\Element_Base;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * Abstract Class Royal_Condition_Base (v2)
 * A more flexible base for all display conditions.
 */
abstract class Royal_Condition_Base {

    /** Get the unique name of the condition. e.g., 'date_range'. */
    abstract public function get_name();
    
    /** Get the user-friendly title. e.g., 'Date Range'. */
    abstract public function get_title();

    /** Get the Elementor repeater controls for this condition. MUST return an array. */
    abstract public function get_controls();

    /**
     * The main logic check. The condition itself is now responsible
     * for checking the operator and its values.
     * @param array $rule The settings from the repeater rule.
     * @param string $operator The comparison operator ('is' or 'is_not').
     * @return bool True if the condition passes, false otherwise.
     */
    abstract public function check( $rule, $operator );
}