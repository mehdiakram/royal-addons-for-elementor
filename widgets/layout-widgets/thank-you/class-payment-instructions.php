<?php
namespace RoyalAddons\Widgets\LayoutWidgets\ThankYou;
use Elementor\Widget_Base;
if ( ! defined( 'ABSPATH' ) ) exit;

class Payment_Instructions extends Widget_Base {
    public function get_name() { return 'royal-ty-payment-instructions'; }
    public function get_title() { return 'Payment Instructions'; }
    public function get_icon() { return 'eicon-info-circle-o rtbranding'; }
    public function get_categories() { return ['royaltech_singleproduct']; }
    public function get_keywords() { return [ 'payment', 'instructions', 'tech', 'technologies', 'royal', 'mehdi', 'akram' ]; }

    protected function register_controls() {}
    protected function render() {
        $order_id = absint(get_query_var('order-received'));
        $order = $order_id ? wc_get_order($order_id) : false;
        if (!$order) return;
        echo '<div class="royal-ty-payment-instructions woocommerce">';
        do_action('woocommerce_thankyou_'.$order->get_payment_method(), $order_id);
        echo '</div>';
    }
}
