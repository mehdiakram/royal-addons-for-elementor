<?php
namespace RoyalAddons\Widgets\LayoutWidgets\SingleProduct;
use Elementor\Widget_Base;
if ( ! defined( 'ABSPATH' ) ) exit;
class Product_SKU extends Widget_Base {
    public function get_name() { return 'royal-product-sku'; }
    public function get_title() { return 'Product SKU'; }
    public function get_icon() { return 'eicon-barcode rtbranding'; }
    public function get_categories() { return ['royaltech_singleproduct']; }
    public function get_keywords() { return [ 'product', 'sku', 'woocommerce', 'single', 'tech', 'technologies', 'royal', 'mehdi', 'akram' ]; }

    protected function register_controls() {}
    protected function render() {
        $product = \RoyalAddons\Elementor\RoyalWooClass::get_current_product(); if(!$product) return;
        $sku = $product->get_sku();
        if($sku) echo '<div class="royal-product-sku"><span class="sku_wrapper">'.esc_html__('SKU:','woocommerce').' <span class="sku">'.esc_html($sku).'</span></span></div>';
    }
}
