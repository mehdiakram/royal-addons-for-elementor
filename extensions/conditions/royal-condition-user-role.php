<?php
namespace RoyalAddons\Extensions\Conditions;

use Elementor\Controls_Manager;
use Elementor\Element_Base;

if ( ! defined( 'ABSPATH' ) ) exit;

// The class name now matches the file name for consistency.
class Royal_Condition_User_Role extends Royal_Condition_Base {

    public function get_name() {
        return 'user_role';
    }

    public function get_title() {
        return __( 'User Role', 'royal-addons-for-elementor' );
    }

    /**
     * This was a MISSING METHOD.
     * It provides the dropdown control with all available user roles.
     */
    public function get_controls() {
        // A helper function to get all registered user roles in WordPress.
        global $wp_roles;
        $all_roles = $wp_roles->get_names();

        return [
            'user_role_select' => [ // This is the control name
                'label' => __( 'Role', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::SELECT,
                'options' => $all_roles,
            ]
        ];
    }

    /**
     * This was a MISSING METHOD.
     * It contains the logic to check the current user's role.
     */
    public function check( $rule, $operator ) {
        // If the user isn't even logged in, they can't have a role.
        if ( ! is_user_logged_in() ) {
            return ( 'is_not' === $operator );
        }

        $selected_role = $rule['user_role_select'] ?? '';
        
        // Get the current user's roles (it's an array).
        $user_roles = wp_get_current_user()->roles;

        // Check if the selected role is in the user's list of roles.
        $condition_met = in_array( $selected_role, $user_roles, true );

        return ( 'is' === $operator ) ? $condition_met : ! $condition_met;
    }
}