<?php
namespace RoyalAddons\Widgets\LayoutWidgets\ShopArchive;
use Elementor\Widget_Base;
if ( ! defined( 'ABSPATH' ) ) exit;
class Archive_Description extends Widget_Base {
    public function get_name() { return 'royal-archive-description'; }
    public function get_title() { return 'Archive Description'; }
    public function get_icon() { return 'eicon-post-excerpt rtbranding'; }
    public function get_categories() { return ['royaltech_shoparchive']; }
    public function get_keywords() { return [ 'archive', 'description', 'shop', 'woocommerce', 'tech', 'technologies', 'royal', 'mehdi', 'akram' ]; }

    protected function register_controls() {}
    protected function render() { echo '<div class="royal-archive-description">'; do_action('woocommerce_archive_description'); echo '</div>'; }
}
