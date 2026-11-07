<?php
namespace RoyalAddons\Widgets\LayoutWidgets\ShopArchive;
use Elementor\Widget_Base;
if ( ! defined( 'ABSPATH' ) ) exit;
class Active_Filters extends Widget_Base {
    public function get_name() { return 'royal-active-filters'; }
    public function get_title() { return 'Active Filters'; }
    public function get_icon() { return 'eicon-filter rtbranding'; }
    public function get_categories() { return ['royaltech_shoparchive']; }
    public function get_keywords() { return [ 'active', 'filters', 'archive', 'shop', 'woocommerce', 'tech', 'technologies', 'royal', 'mehdi', 'akram' ]; }

    protected function register_controls() {}
    protected function render() { echo '<div class="royal-active-filters woocommerce">'; the_widget('WC_Widget_Layered_Nav_Filters'); echo '</div>'; }
}
