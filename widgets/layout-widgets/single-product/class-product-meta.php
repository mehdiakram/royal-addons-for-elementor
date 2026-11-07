<?php
namespace RoyalAddons\Widgets\LayoutWidgets\SingleProduct;
use Elementor\Widget_Base;
if ( ! defined( 'ABSPATH' ) ) exit;

class Product_Meta extends Widget_Base {
    public function get_name() { return 'royal-product-meta'; }
    public function get_title() { return 'Product Meta'; }
    public function get_icon() { return 'eicon-product-meta rtbranding'; }
    public function get_categories() { return ['royaltech_singleproduct']; }
    public function get_keywords() { return [ 'product', 'meta', 'woocommerce', 'single', 'tech', 'technologies', 'royal', 'mehdi', 'akram' ]; }

    protected function register_controls() {}
    protected function render() {
        global $product;
        $product = \RoyalAddons\Elementor\RoyalWooClass::get_current_product();
        if(!$product) return;
        echo '<div class="royal-product-meta">';
        wc_get_template('single-product/meta.php');
        echo '</div>';
    }
}
