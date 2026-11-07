<?php
namespace RoyalAddons\Widgets\LayoutWidgets\Checkout;
use Elementor\Widget_Base;
if ( ! defined( 'ABSPATH' ) ) exit;

class Login_Form extends Widget_Base {
    public function get_name() { return 'royal-checkout-login'; }
    public function get_title() { return 'Checkout Login'; }
    public function get_icon() { return 'eicon-lock-user rtbranding'; }
    public function get_categories() { return ['royaltech_singleproduct']; }
    public function get_keywords() { return [ 'checkout', 'login', 'woocommerce', 'tech', 'technologies', 'royal', 'mehdi', 'akram' ]; }

    protected function register_controls() {}
    protected function render() {
        if ( ! function_exists('WC') ) return;
        echo '<div class="royal-checkout-login woocommerce">';
        wc_get_template('checkout/form-login.php');
        echo '</div>';
    }
}
