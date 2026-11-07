<?php
namespace RoyalAddons\Widgets\LayoutWidgets\SingleProduct;

use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) exit;

class Product_Title extends Widget_Base {
    public function get_name() { return 'royal-product-title'; }
    public function get_title() { return 'Product Title'; }
    public function get_icon() { return 'eicon-product-title rtbranding'; }
    public function get_categories() { return ['royaltech_singleproduct']; }
    public function get_keywords() { return [ 'product', 'title', 'woocommerce', 'single', 'tech', 'technologies', 'royal', 'mehdi', 'akram' ]; }


    protected function register_controls() {
        $this->start_controls_section( 'section_content', [
            'label' => __('Content', 'royal-addons-for-elementor'),
        ] );
        $this->add_control( 'html_tag', [
            'label' => __('HTML Tag', 'royal-addons-for-elementor'),
            'type'    => \Elementor\Controls_Manager::SELECT,
            'default' => 'h1',
            'options' => [ 'h1'=>'H1','h2'=>'H2','h3'=>'H3','h4'=>'H4','div'=>'div','span'=>'span' ],
        ] );
        $this->end_controls_section();

        $this->start_controls_section( 'section_style', [
            'label' => __('Style', 'royal-addons-for-elementor'),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ] );
        $this->add_control( 'title_color', [
            'label' => __('Color', 'royal-addons-for-elementor'),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => [ '{{WRAPPER}} .royal-product-title' => 'color: {{VALUE}}' ],
        ] );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
            'name'     => 'title_typography',
            'selector' => '{{WRAPPER}} .royal-product-title',
        ] );
        $this->end_controls_section();
    }

    protected function render() {
        $product = \RoyalAddons\Elementor\RoyalWooClass::get_current_product();
        if ( ! $product ) return;
        $tag = $this->get_settings_for_display( 'html_tag' );
        echo '<' . esc_attr( $tag ) . ' class="royal-product-title">' . esc_html( $product->get_name() ) . '</' . esc_attr( $tag ) . '>';
    }
}
