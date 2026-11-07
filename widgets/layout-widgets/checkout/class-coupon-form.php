<?php
namespace RoyalAddons\Widgets\LayoutWidgets\Checkout;
use Elementor\Widget_Base;
if ( ! defined( 'ABSPATH' ) ) exit;

class Coupon_Form extends Widget_Base {
    public function get_name() { return 'royal-checkout-coupon'; }
    public function get_title() { return 'Coupon Form'; }
    public function get_icon() { return 'eicon-price-table rtbranding'; }
    public function get_categories() { return ['royaltech_singleproduct']; }
    public function get_keywords() { return [ 'coupon', 'form', 'checkout', 'woocommerce', 'tech', 'technologies', 'royal', 'mehdi', 'akram' ]; }

    protected function register_controls() {}
    protected function render() {
        if ( ! function_exists('WC') ) return;
        echo '<div class="royal-checkout-coupon woocommerce">';
        wc_get_template('checkout/form-coupon.php');
        echo '</div>';
    }
}
