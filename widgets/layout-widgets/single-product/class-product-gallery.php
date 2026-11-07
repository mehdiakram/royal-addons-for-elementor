<?php
namespace RoyalAddons\Widgets\LayoutWidgets\SingleProduct;

use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) exit;

class Product_Gallery extends Widget_Base {
    public function get_name() { return 'royal-product-gallery'; }
    public function get_title() { return 'Product Gallery'; }
    public function get_icon() { return 'eicon-product-images rtbranding'; }
    public function get_categories() { return ['royaltech_singleproduct']; }
    public function get_keywords() { return [ 'product', 'gallery', 'woocommerce', 'single', 'tech', 'technologies', 'royal', 'mehdi', 'akram' ]; }


    protected function register_controls() {
        $this->start_controls_section( 'section_style', [
            'label' => __('Style', 'royal-addons-for-elementor'), 'tab' => \Elementor\Controls_Manager::TAB_STYLE,
        ] );
        $this->add_control( 'gallery_border_radius', [
            'label' => __('Border Radius', 'royal-addons-for-elementor'), 'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'selectors' => [ '{{WRAPPER}} .woocommerce-product-gallery img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
        ] );
        $this->end_controls_section();
    }

    protected function render() {
        global $product;
        $product = \RoyalAddons\Elementor\RoyalWooClass::get_current_product();
        if ( ! $product ) return;
        echo '<div class="royal-product-gallery">';
        wc_get_template( 'single-product/product-image.php' );
        echo '</div>';
    }
}
