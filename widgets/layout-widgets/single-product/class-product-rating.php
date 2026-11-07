<?php
namespace RoyalAddons\Widgets\LayoutWidgets\SingleProduct;
use Elementor\Widget_Base;
if ( ! defined( 'ABSPATH' ) ) exit;

class Product_Rating extends Widget_Base {
    public function get_name() { return 'royal-product-rating'; }
    public function get_title() { return 'Product Rating'; }
    public function get_icon() { return 'eicon-product-rating rtbranding'; }
    public function get_categories() { return ['royaltech_singleproduct']; }
    public function get_keywords() { return [ 'product', 'rating', 'woocommerce', 'single', 'tech', 'technologies', 'royal', 'mehdi', 'akram' ]; }

    protected function register_controls() {
        $this->start_controls_section('s',['label' => __('Style', 'royal-addons-for-elementor'),'tab'=>\Elementor\Controls_Manager::TAB_STYLE]);
        $this->add_control('star_color',['label' => __('Star Color', 'royal-addons-for-elementor'),'type'=>\Elementor\Controls_Manager::COLOR,
            'selectors'=>['{{WRAPPER}} .star-rating span'=>'color:{{VALUE}}']]);
        $this->end_controls_section();
    }
    protected function render() {
        global $product;
        $product = \RoyalAddons\Elementor\RoyalWooClass::get_current_product();
        if(!$product) return;
        echo '<div class="royal-product-rating">';
        wc_get_template('single-product/rating.php');
        echo '</div>';
    }
}
