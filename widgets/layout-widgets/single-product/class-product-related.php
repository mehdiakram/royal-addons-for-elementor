<?php
namespace RoyalAddons\Widgets\LayoutWidgets\SingleProduct;
use Elementor\Widget_Base;
if ( ! defined( 'ABSPATH' ) ) exit;
class Product_Related extends Widget_Base {
    public function get_name() { return 'royal-product-related'; }
    public function get_title() { return 'Related Products'; }
    public function get_icon() { return 'eicon-products-archive rtbranding'; }
    public function get_categories() { return ['royaltech_singleproduct']; }
    public function get_keywords() { return [ 'related', 'products', 'product', 'woocommerce', 'single', 'tech', 'technologies', 'royal', 'mehdi', 'akram' ]; }

    protected function register_controls() {}
    protected function render() {
        global $product; $product = \RoyalAddons\Elementor\RoyalWooClass::get_current_product(); if(!$product) return;
        echo '<div class="royal-product-related woocommerce">'; woocommerce_output_related_products(); echo '</div>';
    }
}
