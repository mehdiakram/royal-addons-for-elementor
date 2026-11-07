<?php
namespace RoyalAddons\Widgets\LayoutWidgets\MyAccount;
use Elementor\Widget_Base;
if ( ! defined( 'ABSPATH' ) ) exit;

class Account_Lost_Password extends Widget_Base {
    public function get_name() { return 'royal-account-lost-password'; }
    public function get_title() { return 'Lost Password Form'; }
    public function get_icon() { return 'eicon-lock-user rtbranding'; }
    public function get_categories() { return ['royaltech_singleproduct']; }
    public function get_keywords() { return [ 'lost', 'password', 'form', 'tech', 'technologies', 'royal', 'mehdi', 'akram' ]; }

    protected function register_controls() {}
    protected function render() {
        if ( ! function_exists('WC') ) return;
        echo '<div class="royal-account-lost-password woocommerce">';
        wc_get_template('myaccount/form-lost-password.php');
        echo '</div>';
    }
}
