<?php
namespace RoyalAddons\Widgets\LayoutWidgets\ThankYou;
use Elementor\Widget_Base;
if ( ! defined( 'ABSPATH' ) ) exit;

class Order_Meta extends Widget_Base {
    public function get_name() { return 'royal-ty-order-meta'; }
    public function get_title() { return 'Order Meta'; }
    public function get_icon() { return 'eicon-post-info rtbranding'; }
    public function get_categories() { return ['royaltech_singleproduct']; }
    public function get_keywords() { return [ 'order', 'meta', 'tech', 'technologies', 'royal', 'mehdi', 'akram' ]; }

    protected function register_controls() {}
    protected function render() {
        $order_id = absint(get_query_var('order-received'));
        $order = $order_id ? wc_get_order($order_id) : false;
        if (!$order) return;
        echo '<div class="royal-ty-order-meta woocommerce">';
        do_action('woocommerce_order_details_after_order_table', $order);
        echo '</div>';
    }
}
