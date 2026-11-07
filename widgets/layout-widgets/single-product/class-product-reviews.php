<?php
namespace RoyalAddons\Widgets\LayoutWidgets\SingleProduct;
use Elementor\Widget_Base;
if ( ! defined( 'ABSPATH' ) ) exit;
class Product_Reviews extends Widget_Base {
    public function get_name() { return 'royal-product-reviews'; }
    public function get_title() { return 'Product Reviews'; }
    public function get_icon() { return 'eicon-review rtbranding'; }
    public function get_categories() { return ['royaltech_singleproduct']; }
    public function get_keywords() { return [ 'product', 'reviews', 'woocommerce', 'single', 'tech', 'technologies', 'royal', 'mehdi', 'akram' ]; }

    protected function register_controls() {}
    protected function render() {
        global $product; $product = \RoyalAddons\Elementor\RoyalWooClass::get_current_product(); if(!$product) return;
        echo '<div class="royal-product-reviews woocommerce">'; comments_template(); echo '</div>';
    }
}
