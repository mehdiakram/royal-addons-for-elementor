<?php
namespace RoyalAddons\Widgets\LayoutWidgets\SingleProduct;
use Elementor\Widget_Base;
if ( ! defined( 'ABSPATH' ) ) exit;
class Product_Additional_Info extends Widget_Base {
    public function get_name() { return 'royal-product-additional-info'; }
    public function get_title() { return 'Additional Information'; }
    public function get_icon() { return 'eicon-info-circle-o rtbranding'; }
    public function get_categories() { return ['royaltech_singleproduct']; }
    public function get_keywords() { return [ 'additional', 'information', 'product', 'woocommerce', 'single', 'tech', 'technologies', 'royal', 'mehdi', 'akram' ]; }

    protected function register_controls() {}
    protected function render() {
        global $product; $product = \RoyalAddons\Elementor\RoyalWooClass::get_current_product(); if(!$product) return;
        echo '<div class="royal-product-additional-info woocommerce">';
        wc_get_template('single-product/product-attributes.php', ['product_attributes' => array_filter($product->get_attributes(),'wc_attributes_array_filter_visible'), 'display_dimensions' => apply_filters('wc_product_enable_dimensions_display',$product->has_weight()||$product->has_dimensions())]);
        echo '</div>';
    }
}
