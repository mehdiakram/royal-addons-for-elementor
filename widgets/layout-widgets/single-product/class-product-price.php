<?php
namespace RoyalAddons\Widgets\LayoutWidgets\SingleProduct;

use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) exit;

class Product_Price extends Widget_Base {
    public function get_name() { return 'royal-product-price'; }
    public function get_title() { return 'Product Price'; }
    public function get_icon() { return 'eicon-product-price rtbranding'; }
    public function get_categories() { return ['royaltech_singleproduct']; }
    public function get_keywords() { return [ 'product', 'price', 'woocommerce', 'single', 'tech', 'technologies', 'royal', 'mehdi', 'akram' ]; }


    protected function register_controls() {
        $this->start_controls_section( 'section_style', [
            'label' => __('Style', 'royal-addons-for-elementor'),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ] );
        $this->add_control( 'price_color', [
            'label' => __('Color', 'royal-addons-for-elementor'),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => [ '{{WRAPPER}} .royal-product-price' => 'color: {{VALUE}}' ],
        ] );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
            'name' => 'price_typography', 'selector' => '{{WRAPPER}} .royal-product-price',
        ] );
        $this->end_controls_section();
    }

    protected function render() {
        $product = \RoyalAddons\Elementor\RoyalWooClass::get_current_product();
        if ( ! $product ) return;
        echo '<div class="royal-product-price">' . $product->get_price_html() . '</div>';
    }
}
