<?php
namespace RoyalAddons\Widgets\LayoutWidgets\SingleProduct;
use Elementor\Widget_Base;
if ( ! defined( 'ABSPATH' ) ) exit;
class Product_Stock extends Widget_Base {
    public function get_name() { return 'royal-product-stock'; }
    public function get_title() { return 'Stock Status'; }
    public function get_icon() { return 'eicon-product-stock rtbranding'; }
    public function get_categories() { return ['royaltech_singleproduct']; }
    public function get_keywords() { return [ 'stock', 'status', 'product', 'woocommerce', 'single', 'tech', 'technologies', 'royal', 'mehdi', 'akram' ]; }

    protected function register_controls() {}
    protected function render() {
        $product = \RoyalAddons\Elementor\RoyalWooClass::get_current_product(); if(!$product) return;
        $html = wc_get_stock_html($product);
        if($html) echo '<div class="royal-product-stock">'.$html.'</div>';
    }
}
