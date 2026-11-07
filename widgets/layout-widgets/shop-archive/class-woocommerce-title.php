<?php
namespace RoyalAddons\Widgets\LayoutWidgets\ShopArchive;
use Elementor\Widget_Base;
if ( ! defined( 'ABSPATH' ) ) exit;
class Woocommerce_Title extends Widget_Base {
    public function get_name() { return 'royal-wc-title'; }
    public function get_title() { return 'WooCommerce Title'; }
    public function get_icon() { return 'eicon-site-title rtbranding'; }
    public function get_categories() { return ['royaltech_shoparchive']; }
    public function get_keywords() { return [ 'woocommerce', 'title', 'archive', 'shop', 'tech', 'technologies', 'royal', 'mehdi', 'akram' ]; }

    protected function register_controls() {
        $this->start_controls_section('s',['label' => __('Style', 'royal-addons-for-elementor'),'tab'=>\Elementor\Controls_Manager::TAB_STYLE]);
        $this->add_control('color',['label' => __('Color', 'royal-addons-for-elementor'),'type'=>\Elementor\Controls_Manager::COLOR,'selectors'=>['{{WRAPPER}} .royal-wc-title'=>'color:{{VALUE}}']]);
        $this->add_group_control(\Elementor\Group_Control_Typography::get_type(),['name'=>'t','selector'=>'{{WRAPPER}} .royal-wc-title']);
        $this->end_controls_section();
    }
    protected function render() {
        echo '<h1 class="royal-wc-title woocommerce-products-header__title page-title">';
        woocommerce_page_title();
        echo '</h1>';
    }
}
