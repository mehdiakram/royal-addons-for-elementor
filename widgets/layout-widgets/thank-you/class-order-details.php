<?php
namespace RoyalAddons\Widgets\LayoutWidgets\ThankYou;
use Elementor\Widget_Base;
if ( ! defined( 'ABSPATH' ) ) exit;

class Order_Details extends Widget_Base {
    public function get_name() { return 'royal-ty-order-details'; }
    public function get_title() { return 'Order Details'; }
    public function get_icon() { return 'eicon-table rtbranding'; }
    public function get_categories() { return ['royaltech_singleproduct']; }
    public function get_keywords() { return [ 'order', 'details', 'tech', 'technologies', 'royal', 'mehdi', 'akram' ]; }

    protected function register_controls() {}
    protected function render() {
        $order_id = absint(get_query_var('order-received'));
        $order = $order_id ? wc_get_order($order_id) : false;
        if (!$order) return;
        echo '<div class="royal-ty-order-details woocommerce">';
        wc_get_template('order/order-details.php', ['order_id' => $order_id]);
        echo '</div>';
    }
}
