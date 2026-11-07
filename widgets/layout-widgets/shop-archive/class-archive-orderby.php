<?php
namespace RoyalAddons\Widgets\LayoutWidgets\ShopArchive;
use Elementor\Widget_Base;
if ( ! defined( 'ABSPATH' ) ) exit;
class Archive_Orderby extends Widget_Base {
    public function get_name() { return 'royal-archive-orderby'; }
    public function get_title() { return 'Orderby'; }
    public function get_icon() { return 'eicon-sort-amount-desc rtbranding'; }
    public function get_categories() { return ['royaltech_shoparchive']; }
    public function get_keywords() { return [ 'orderby', 'archive', 'shop', 'woocommerce', 'tech', 'technologies', 'royal', 'mehdi', 'akram' ]; }

    protected function register_controls() {}
    protected function render() { if(!function_exists('WC')) return; echo '<div class="royal-archive-orderby woocommerce">'; woocommerce_catalog_ordering(); echo '</div>'; }
}
