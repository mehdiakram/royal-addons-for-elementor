<?php
namespace RoyalAddons\Widgets\LayoutWidgets\SingleProduct;
use Elementor\Widget_Base;
if ( ! defined( 'ABSPATH' ) ) exit;
class Product_Sharing extends Widget_Base {
    public function get_name() { return 'royal-product-sharing'; }
    public function get_title() { return 'Product Sharing'; }
    public function get_icon() { return 'eicon-share rtbranding'; }
    public function get_categories() { return ['royaltech_singleproduct']; }
    public function get_keywords() { return [ 'product', 'sharing', 'woocommerce', 'single', 'tech', 'technologies', 'royal', 'mehdi', 'akram' ]; }

    protected function register_controls() {}
    protected function render() {
        echo '<div class="royal-product-sharing">';
        do_action('woocommerce_share');
        echo '</div>';
    }
}
