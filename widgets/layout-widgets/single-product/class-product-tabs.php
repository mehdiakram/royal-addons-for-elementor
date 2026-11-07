<?php
namespace RoyalAddons\Widgets\LayoutWidgets\SingleProduct;
use Elementor\Widget_Base;
if ( ! defined( 'ABSPATH' ) ) exit;

class Product_Tabs extends Widget_Base {
    public function get_name() { return 'royal-product-tabs'; }
    public function get_title() { return 'Product Tabs'; }
    public function get_icon() { return 'eicon-product-tabs rtbranding'; }
    public function get_categories() { return ['royaltech_singleproduct']; }
    public function get_keywords() { return [ 'product', 'tabs', 'woocommerce', 'single', 'tech', 'technologies', 'royal', 'mehdi', 'akram' ]; }

    protected function register_controls() {}

    protected function render() {
        global $product;
        $product = \RoyalAddons\Elementor\RoyalWooClass::get_current_product();
        if ( ! $product ) return;
        setup_postdata( $product->get_id() );
        echo '<div class="royal-product-tabs">';
        wc_get_template( 'single-product/tabs/tabs.php' );
        echo '</div>';
        wp_reset_postdata();
    }
}
