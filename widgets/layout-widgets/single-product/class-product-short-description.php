<?php
namespace RoyalAddons\Widgets\LayoutWidgets\SingleProduct;
use Elementor\Widget_Base;
if ( ! defined( 'ABSPATH' ) ) exit;

class Product_Short_Description extends Widget_Base {
    public function get_name() { return 'royal-product-short-desc'; }
    public function get_title() { return 'Short Description'; }
    public function get_icon() { return 'eicon-product-description rtbranding'; }
    public function get_categories() { return ['royaltech_singleproduct']; }
    public function get_keywords() { return [ 'short', 'description', 'product', 'woocommerce', 'single', 'tech', 'technologies', 'royal', 'mehdi', 'akram' ]; }

    protected function register_controls() {
        $this->start_controls_section('s',['label' => __('Style', 'royal-addons-for-elementor'),'tab'=>\Elementor\Controls_Manager::TAB_STYLE]);
        $this->add_control('color',['label' => __('Color', 'royal-addons-for-elementor'),'type'=>\Elementor\Controls_Manager::COLOR,'selectors'=>['{{WRAPPER}}'=>'color:{{VALUE}}']]);
        $this->add_group_control(\Elementor\Group_Control_Typography::get_type(),['name'=>'typo','selector'=>'{{WRAPPER}} .royal-product-short-desc']);
        $this->end_controls_section();
    }
    protected function render() {
        $product = \RoyalAddons\Elementor\RoyalWooClass::get_current_product();
        if(!$product) return;
        $desc = $product->get_short_description();
        if($desc) echo '<div class="royal-product-short-desc">'.wp_kses_post($desc).'</div>';
    }
}
