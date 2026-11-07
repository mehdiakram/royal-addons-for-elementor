<?php
namespace RoyalAddons\Extensions;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * Interface Royal_Condition_Interface
 *
 * This interface defines the contract that every condition class in
 * Royal Addons must follow. It ensures that the main Display Conditions
 * engine can work with any condition in a standardized way.
 */
interface Royal_Condition_Interface {

    /**
     * Get the unique, machine-readable name of the condition.
     * e.g., 'login_status', 'user_role'
     *
     * @return string
     */
    public function get_name();

    /**
     * Get the human-readable title of the condition for the UI.
     * e.g., 'Login Status', 'User Role'
     *
     * @return string
     */
    public function get_title();

    /**
     * Get the Elementor control field settings for this specific condition.
     * @return array
     */
    public function get_repeater_control();

    /**
     * Compare the condition against the user-defined rule.
     * This is the core logic function where the condition is actually checked.
     *
     * @param string $operator The comparison operator ('is' or 'is_not').
     * @param array  $rule The array of settings from the repeater rule.
     * @param \Elementor\Element_Base|null $element The element being checked.
     * @return bool True if the condition is met, false otherwise.
     */
    public function compare( $operator, $rule, ?\Elementor\Element_Base $element = null );
}