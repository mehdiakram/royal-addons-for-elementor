<?php
namespace RoyalAddons\Widgets\LayoutWidgets\SingleProduct;
use Elementor\Widget_Base;
if ( ! defined( 'ABSPATH' ) ) exit;
class Product_Navigation extends Widget_Base {
    public function get_name() { return 'royal-product-navigation'; }
    public function get_title() { return 'Product Navigation'; }
    public function get_icon() { return 'eicon-post-navigation rtbranding'; }
    public function get_categories() { return ['royaltech_singleproduct']; }
    public function get_keywords() { return [ 'product', 'navigation', 'woocommerce', 'single', 'tech', 'technologies', 'royal', 'mehdi', 'akram' ]; }

    protected function register_controls() {}
    protected function render() {
        echo '<div class="royal-product-navigation">';
        $prev = get_previous_post(); $next = get_next_post();
        echo '<div style="display:flex;justify-content:space-between">';
        if($prev) echo '<a href="'.esc_url(get_permalink($prev)).'">&larr; '.esc_html($prev->post_title).'</a>';
        echo '<span></span>';
        if($next) echo '<a href="'.esc_url(get_permalink($next)).'">'.esc_html($next->post_title).' &rarr;</a>';
        echo '</div></div>';
    }
}
