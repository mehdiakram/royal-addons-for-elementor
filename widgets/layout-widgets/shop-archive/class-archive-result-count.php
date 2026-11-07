<?php
namespace RoyalAddons\Widgets\LayoutWidgets\ShopArchive;
use Elementor\Widget_Base;
if ( ! defined( 'ABSPATH' ) ) exit;
class Archive_Result_Count extends Widget_Base {
    public function get_name() { return 'royal-archive-result-count'; }
    public function get_title() { return 'Result Count'; }
    public function get_icon() { return 'eicon-counter rtbranding'; }
    public function get_categories() { return ['royaltech_shoparchive']; }
    public function get_keywords() { return [ 'result', 'count', 'archive', 'shop', 'woocommerce', 'tech', 'technologies', 'royal', 'mehdi', 'akram' ]; }

    protected function register_controls() {}
    protected function render() { if(!function_exists('WC')) return; echo '<div class="royal-archive-result-count woocommerce">'; woocommerce_result_count(); echo '</div>'; }
}
