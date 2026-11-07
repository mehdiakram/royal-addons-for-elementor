<?php
namespace RoyalAddons\Widgets\LayoutWidgets\Checkout;
use Elementor\Widget_Base;
if ( ! defined( 'ABSPATH' ) ) exit;

class Payment_Methods extends Widget_Base {
    public function get_name() { return 'royal-checkout-payment'; }
    public function get_title() { return 'Payment Methods'; }
    public function get_icon() { return 'eicon-product-breadcrumbs rtbranding'; }
    public function get_categories() { return ['royaltech_singleproduct']; }
    public function get_keywords() { return [ 'payment', 'methods', 'checkout', 'woocommerce', 'tech', 'technologies', 'royal', 'mehdi', 'akram' ]; }

    protected function register_controls() {}
    protected function render() {
        if ( ! function_exists('WC') ) return;
        echo '<div class="royal-checkout-payment woocommerce">';
        wc_get_template('checkout/payment.php', ['checkout' => WC()->checkout()]);
        echo '</div>';
    }
}
