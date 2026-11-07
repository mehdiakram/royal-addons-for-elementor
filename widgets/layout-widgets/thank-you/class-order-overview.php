<?php
namespace RoyalAddons\Widgets\LayoutWidgets\ThankYou;
use Elementor\Widget_Base;
if ( ! defined( 'ABSPATH' ) ) exit;

class Order_Overview extends Widget_Base {
    public function get_name() { return 'royal-ty-order-overview'; }
    public function get_title() { return 'Order Overview'; }
    public function get_icon() { return 'eicon-info-circle rtbranding'; }
    public function get_categories() { return ['royaltech_singleproduct']; }
    public function get_keywords() { return [ 'order', 'overview', 'tech', 'technologies', 'royal', 'mehdi', 'akram' ]; }

    protected function register_controls() {}
    protected function render() {
        $order_id = absint(get_query_var('order-received'));
        $order = $order_id ? wc_get_order($order_id) : false;
        if (!$order) return;
        echo '<div class="royal-ty-overview woocommerce"><ul class="woocommerce-order-overview">';
        echo '<li>'.esc_html__('Order number:','woocommerce').' <strong>'.$order->get_order_number().'</strong></li>';
        echo '<li>'.esc_html__('Date:','woocommerce').' <strong>'.wc_format_datetime($order->get_date_created()).'</strong></li>';
        echo '<li>'.esc_html__('Total:','woocommerce').' <strong>'.$order->get_formatted_order_total().'</strong></li>';
        if ($order->get_payment_method_title()) echo '<li>'.esc_html__('Payment method:','woocommerce').' <strong>'.wp_kses_post($order->get_payment_method_title()).'</strong></li>';
        echo '</ul></div>';
    }
}
