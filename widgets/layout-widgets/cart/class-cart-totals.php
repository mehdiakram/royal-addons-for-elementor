<?php
namespace RoyalAddons\Widgets\LayoutWidgets\Cart;
use Elementor\Widget_Base;
if ( ! defined( 'ABSPATH' ) ) exit;

class Cart_Totals extends Widget_Base {
    public function get_name() { return 'royal-cart-totals'; }
    public function get_title() { return 'Cart Totals'; }
    public function get_icon() { return 'eicon-price-list rtbranding'; }
    public function get_categories() { return ['royaltech_singleproduct']; }
    public function get_keywords() { return [ 'cart', 'totals', 'woocommerce', 'tech', 'technologies', 'royal', 'mehdi', 'akram' ]; }

    protected function register_controls() {}
    protected function render() {
        if ( ! function_exists('WC') || ! WC()->cart ) return;
        echo '<div class="royal-cart-totals woocommerce">';
        wc_get_template('cart/cart-totals.php');
        echo '</div>';
    }
}
