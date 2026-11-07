<?php
namespace RoyalAddons\Widgets\LayoutWidgets\Checkout;
use Elementor\Widget_Base;
if ( ! defined( 'ABSPATH' ) ) exit;

class Shipping_Details extends Widget_Base {
    public function get_name() { return 'royal-checkout-shipping'; }
    public function get_title() { return 'Shipping Details'; }
    public function get_icon() { return 'eicon-form-horizontal rtbranding'; }
    public function get_categories() { return ['royaltech_singleproduct']; }
    public function get_keywords() { return [ 'shipping', 'details', 'checkout', 'woocommerce', 'tech', 'technologies', 'royal', 'mehdi', 'akram' ]; }

    protected function register_controls() {}
    protected function render() {
        if ( ! function_exists('WC') ) return;
        $checkout = WC()->checkout();
        echo '<div class="royal-checkout-shipping woocommerce">';
        wc_get_template('checkout/form-shipping.php', ['checkout' => $checkout]);
        echo '</div>';
    }
}
