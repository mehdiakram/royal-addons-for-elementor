<?php
namespace RoyalAddons\Widgets\LayoutWidgets\Cart;
use Elementor\Widget_Base;
if ( ! defined( 'ABSPATH' ) ) exit;

class Empty_Cart extends Widget_Base {
    public function get_name() { return 'royal-empty-cart'; }
    public function get_title() { return 'Empty Cart'; }
    public function get_icon() { return 'eicon-product-upsell rtbranding'; }
    public function get_categories() { return ['royaltech_singleproduct']; }
    public function get_keywords() { return [ 'empty', 'cart', 'woocommerce', 'tech', 'technologies', 'royal', 'mehdi', 'akram' ]; }

    protected function register_controls() {}
    protected function render() {
        echo '<div class="royal-empty-cart woocommerce">';
        wc_get_template('cart/cart-empty.php');
        echo '</div>';
    }
}
