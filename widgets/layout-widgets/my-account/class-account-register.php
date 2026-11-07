<?php
namespace RoyalAddons\Widgets\LayoutWidgets\MyAccount;
use Elementor\Widget_Base;
if ( ! defined( 'ABSPATH' ) ) exit;

class Account_Register extends Widget_Base {
    public function get_name() { return 'royal-account-register'; }
    public function get_title() { return 'Register Form'; }
    public function get_icon() { return 'eicon-user-circle-o rtbranding'; }
    public function get_categories() { return ['royaltech_singleproduct']; }
    public function get_keywords() { return [ 'register', 'form', 'tech', 'technologies', 'royal', 'mehdi', 'akram' ]; }

    protected function register_controls() {}
    protected function render() {
        if ( ! function_exists('WC') ) return;
        echo '<div class="royal-account-register woocommerce">';
        do_action('woocommerce_register_form_start');
        wc_get_template('myaccount/form-login.php');
        echo '</div>';
    }
}
