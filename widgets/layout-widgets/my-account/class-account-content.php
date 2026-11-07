<?php
namespace RoyalAddons\Widgets\LayoutWidgets\MyAccount;
use Elementor\Widget_Base;
if ( ! defined( 'ABSPATH' ) ) exit;

class Account_Content extends Widget_Base {
    public function get_name() { return 'royal-account-content'; }
    public function get_title() { return 'Account Content'; }
    public function get_icon() { return 'eicon-post-content rtbranding'; }
    public function get_categories() { return ['royaltech_singleproduct']; }
    public function get_keywords() { return [ 'account', 'content', 'tech', 'technologies', 'royal', 'mehdi', 'akram' ]; }

    protected function register_controls() {}
    protected function render() {
        if ( ! function_exists('WC') ) return;
        echo '<div class="royal-account-content woocommerce">';
        wc_get_template('myaccount/my-account.php', ['current_user' => get_user_by('id', get_current_user_id())]);
        echo '</div>';
    }
}
