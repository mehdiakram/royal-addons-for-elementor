<?php
namespace RoyalAddons\Widgets\LayoutWidgets\MyAccount;
use Elementor\Widget_Base;
if ( ! defined( 'ABSPATH' ) ) exit;

class Account_Login extends Widget_Base {
    public function get_name() { return 'royal-account-login'; }
    public function get_title() { return 'Login Form'; }
    public function get_icon() { return 'eicon-lock-user rtbranding'; }
    public function get_categories() { return ['royaltech_singleproduct']; }
    public function get_keywords() { return [ 'login', 'form', 'tech', 'technologies', 'royal', 'mehdi', 'akram' ]; }

    protected function register_controls() {}
    protected function render() {
        if ( ! function_exists('WC') ) return;
        echo '<div class="royal-account-login woocommerce">';
        wc_get_template('myaccount/form-login.php');
        echo '</div>';
    }
}
