<?php
namespace RoyalAddons\Widgets\LayoutWidgets\SingleProduct;

use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) exit;

class Product_Add_To_Cart extends Widget_Base {
    public function get_name() { return 'royal-product-add-to-cart'; }
    public function get_title() { return 'Add to Cart'; }
    public function get_icon() { return 'eicon-product-add-to-cart rtbranding'; }
    public function get_categories() { return ['royaltech_singleproduct']; }
    public function get_keywords() { return [ 'add', 'cart', 'product', 'woocommerce', 'single', 'tech', 'technologies', 'royal', 'mehdi', 'akram' ]; }


    protected function register_controls() {
        $this->start_controls_section( 'section_style', [
            'label' => __('Button Style', 'royal-addons-for-elementor'), 'tab' => \Elementor\Controls_Manager::TAB_STYLE,
        ] );
        $this->add_control( 'btn_bg', [
            'label' => __('Background', 'royal-addons-for-elementor'), 'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [ '{{WRAPPER}} .single_add_to_cart_button' => 'background-color: {{VALUE}}' ],
        ] );
        $this->add_control( 'btn_color', [
            'label' => __('Text Color', 'royal-addons-for-elementor'), 'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [ '{{WRAPPER}} .single_add_to_cart_button' => 'color: {{VALUE}}' ],
        ] );
        $this->end_controls_section();
    }

    protected function render() {
        global $product;
        $product = \RoyalAddons\Elementor\RoyalWooClass::get_current_product();
        if ( ! $product ) return;
        echo '<div class="royal-product-add-to-cart">';
        woocommerce_template_single_add_to_cart();
        echo '</div>';
    }
}
