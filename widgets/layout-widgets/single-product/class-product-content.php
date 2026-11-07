<?php
namespace RoyalAddons\Widgets\LayoutWidgets\SingleProduct;
use Elementor\Widget_Base;
if ( ! defined( 'ABSPATH' ) ) exit;
class Product_Content extends Widget_Base {
    public function get_name() { return 'royal-product-content'; }
    public function get_title() { return 'Product Content'; }
    public function get_icon() { return 'eicon-post-content rtbranding'; }
    public function get_categories() { return ['royaltech_singleproduct']; }
    public function get_keywords() { return [ 'product', 'content', 'woocommerce', 'single', 'tech', 'technologies', 'royal', 'mehdi', 'akram' ]; }

    protected function register_controls() {}
    protected function render() {
        $product = \RoyalAddons\Elementor\RoyalWooClass::get_current_product(); if(!$product) return;
        $desc = $product->get_description();
        if($desc) echo '<div class="royal-product-content">'.wp_kses_post(wpautop($desc)).'</div>';
    }
}
