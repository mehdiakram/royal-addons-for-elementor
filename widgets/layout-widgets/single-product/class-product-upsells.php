<?php
namespace RoyalAddons\Widgets\LayoutWidgets\SingleProduct;
use Elementor\Widget_Base;
if ( ! defined( 'ABSPATH' ) ) exit;
class Product_Upsells extends Widget_Base {
    public function get_name() { return 'royal-product-upsells'; }
    public function get_title() { return 'Upsell Products'; }
    public function get_icon() { return 'eicon-product-upsell rtbranding'; }
    public function get_categories() { return ['royaltech_singleproduct']; }
    public function get_keywords() { return [ 'upsell', 'products', 'product', 'woocommerce', 'single', 'tech', 'technologies', 'royal', 'mehdi', 'akram' ]; }

    protected function register_controls() {}
    protected function render() {
        global $product; $product = \RoyalAddons\Elementor\RoyalWooClass::get_current_product(); if(!$product) return;
        echo '<div class="royal-product-upsells woocommerce">'; woocommerce_upsell_display(); echo '</div>';
    }
}
