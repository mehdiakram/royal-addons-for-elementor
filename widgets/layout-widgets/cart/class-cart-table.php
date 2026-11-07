<?php
namespace RoyalAddons\Widgets\LayoutWidgets\Cart;
use Elementor\Widget_Base;
if ( ! defined( 'ABSPATH' ) ) exit;

class Cart_Table extends Widget_Base {
    public function get_name() { return 'royal-cart-table'; }
    public function get_title() { return 'Cart Table'; }
    public function get_icon() { return 'eicon-table rtbranding'; }
    public function get_categories() { return ['royaltech_singleproduct']; }
    public function get_keywords() { return [ 'cart', 'table', 'woocommerce', 'tech', 'technologies', 'royal', 'mehdi', 'akram' ]; }

    protected function register_controls() {}
    protected function render() {
        if ( ! function_exists('WC') || ! WC()->cart ) return;
        echo '<div class="royal-cart-table woocommerce">';
        wc_get_template('cart/cart.php');
        echo '</div>';
    }
}
