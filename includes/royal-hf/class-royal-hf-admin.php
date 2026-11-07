<?php
/**
 * Admin Menu Setup
 */
namespace RoyalAddons\RoyalHF;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Admin {

    /**
	 * Admin instance.
	 *
	 * @var Admin
	 */
	private static $instance = null;

    /**
	 * Instance of Admin
	 *
	 * @return Admin
	 */
	public static function instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

    /**
	 * Constructor
	 */
    public function __construct() {
        add_action( 'admin_menu', [ $this, 'register_menu' ], 200 );
    }

    /**
     * Register the admin menu.
     */
    public function register_menu() {
        add_submenu_page(
            'royaladdonsforelementor',
            esc_html__( 'Header & Footer', 'royal-addons-for-elementor' ),
            esc_html__( 'Header & Footer', 'royal-addons-for-elementor' ),
            'edit_pages',
            'edit.php?post_type=royal-hf'
        );
    }
}
