<?php
namespace RoyalAddons\Widgets\LayoutWidgets\Woocommerce;
use Elementor\Widget_Base;
if ( ! defined( 'ABSPATH' ) ) exit;
class Notices extends Widget_Base {
    public function get_name() { return 'royal-wc-notices'; }
    public function get_title() { return 'WC Notices'; }
    public function get_icon() { return 'eicon-alert rtbranding'; }
    public function get_categories() { return ['royaltech_singleproduct']; }
    public function get_keywords() { return [ 'notices', 'tech', 'technologies', 'royal', 'mehdi', 'akram' ]; }

    protected function register_controls() {}
    protected function render() { echo '<div class="royal-wc-notices woocommerce">'; wc_print_notices(); echo '</div>'; }
}
