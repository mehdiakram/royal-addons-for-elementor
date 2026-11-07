<?php
namespace RoyalAddons\Widgets\LayoutWidgets\MyAccount;
use Elementor\Widget_Base;
if ( ! defined( 'ABSPATH' ) ) exit;

class Account_Navigation extends Widget_Base {
    public function get_name() { return 'royal-account-navigation'; }
    public function get_title() { return 'Account Navigation'; }
    public function get_icon() { return 'eicon-nav-menu rtbranding'; }
    public function get_categories() { return ['royaltech_singleproduct']; }
    public function get_keywords() { return [ 'account', 'navigation', 'tech', 'technologies', 'royal', 'mehdi', 'akram' ]; }

    protected function register_controls() {}
    protected function render() {
        if ( ! function_exists('WC') ) return;
        echo '<div class="royal-account-nav woocommerce">';
        wc_get_template('myaccount/navigation.php');
        echo '</div>';
    }
}
