<?php
namespace RoyalAddons\Widgets\LayoutWidgets\SingleProduct;
use Elementor\Widget_Base;
if ( ! defined( 'ABSPATH' ) ) exit;
class Product_Sale_Badge extends Widget_Base {
    public function get_name() { return 'royal-product-sale-badge'; }
    public function get_title() { return 'Sale Badge'; }
    public function get_icon() { return 'eicon-product-stock rtbranding'; }
    public function get_categories() { return ['royaltech_singleproduct']; }
    public function get_keywords() { return [ 'sale', 'badge', 'product', 'woocommerce', 'single', 'tech', 'technologies', 'royal', 'mehdi', 'akram' ]; }

    protected function register_controls() {}
    protected function render() {
        global $product; $product = \RoyalAddons\Elementor\RoyalWooClass::get_current_product(); if(!$product) return;
        echo '<div class="royal-product-sale-badge">'; wc_get_template('loop/sale-flash.php'); echo '</div>';
    }
}
