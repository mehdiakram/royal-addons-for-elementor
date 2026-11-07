<?php
namespace RoyalAddons\Widgets\LayoutWidgets\Checkout;
use Elementor\Widget_Base;
if ( ! defined( 'ABSPATH' ) ) exit;

class Order_Review extends Widget_Base {
    public function get_name() { return 'royal-checkout-order-review'; }
    public function get_title() { return 'Order Review'; }
    public function get_icon() { return 'eicon-checkout rtbranding'; }
    public function get_categories() { return ['royaltech_singleproduct']; }
    public function get_keywords() { return [ 'order', 'review', 'checkout', 'woocommerce', 'tech', 'technologies', 'royal', 'mehdi', 'akram' ]; }

    protected function register_controls() {}
    protected function render() {
        if ( ! function_exists('WC') ) return;
        echo '<div class="royal-checkout-order-review woocommerce">';
        wc_get_template('checkout/review-order.php', ['checkout' => WC()->checkout()]);
        echo '</div>';
    }
}
