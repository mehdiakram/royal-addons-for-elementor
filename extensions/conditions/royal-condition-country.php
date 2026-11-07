<?php
namespace RoyalAddons\Extensions\Conditions;

use Elementor\Controls_Manager;
use Elementor\Element_Base;

if ( ! defined( 'ABSPATH' ) ) exit;

// The class extends the base class.
class Royal_Condition_Country extends Royal_Condition_Base {

    public function get_name() {
        return 'country';
    }

    public function get_title() {
        return __( 'Country', 'royal-addons-for-elementor' );
    }

    // get_controls() returns an array containing the control settings.
    public function get_controls() {
        // You would populate this with a real list of countries.
        return [
            'country_code' => [ // This is the control name
                'label' => __( 'Country', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'BD' => 'Bangladesh',
                    'US' => 'United States',
                    'CA' => 'Canada',
                    'GB' => 'United Kingdom',
                    'IN' => 'India',
                    // Add other countries here...
                ],
            ]
        ];
    }

    /**
     * The check() method now has the correct ($rule, $operator) signature.
     */
    public function check( $rule, $operator ) {
        // --- IMPORTANT ---
        // Proper country detection requires a GeoIP service (like MaxMind) 
        // integrated with your server. This is not a simple task.
        // The code below is a placeholder that assumes you have a function
        // that can give you the visitor's country code.
        
        $visitor_country = 'XX'; // Default to a non-matching country code.

        // Example of how you might get the country code if you have a service.
        if ( isset( $_SERVER['HTTP_CF_IPCOUNTRY'] ) ) {
            // Example for Cloudflare
            $visitor_country = $_SERVER['HTTP_CF_IPCOUNTRY'];
        }

        $selected_country = $rule['country_code'] ?? '';

        $condition_met = ( $visitor_country === $selected_country );

        return ( 'is' === $operator ) ? $condition_met : ! $condition_met;
    }
}