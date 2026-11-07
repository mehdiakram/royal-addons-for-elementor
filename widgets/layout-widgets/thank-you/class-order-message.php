<?php
namespace RoyalAddons\Widgets\LayoutWidgets\ThankYou;
use Elementor\Widget_Base;
if ( ! defined( 'ABSPATH' ) ) exit;

class Order_Message extends Widget_Base {
    public function get_name() { return 'royal-ty-order-message'; }
    public function get_title() { return 'Order Message'; }
    public function get_icon() { return 'eicon-info-circle-o rtbranding'; }
    public function get_categories() { return ['royaltech_singleproduct']; }
    public function get_keywords() { return [ 'order', 'message', 'tech', 'technologies', 'royal', 'mehdi', 'akram' ]; }

    protected function register_controls() {}
    protected function render() {
        $order_id = absint(get_query_var('order-received'));
        $order = $order_id ? wc_get_order($order_id) : false;
        echo '<div class="royal-ty-message woocommerce">';
        if ($order) {
            $status = $order->has_status('failed') ? 'failure' : 'success';
            echo '<p class="woocommerce-notice woocommerce-notice--'.$status.' woocommerce-thankyou-order-received">';
            echo esc_html(apply_filters('woocommerce_thankyou_order_received_text', __('Thank you. Your order has been received.','woocommerce'), $order));
            echo '</p>';
        }
        echo '</div>';
    }
}
