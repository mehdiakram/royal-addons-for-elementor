<?php
namespace RoyalAddons\Widgets\LayoutWidgets\Woocommerce;
use Elementor\Widget_Base;
if ( ! defined( 'ABSPATH' ) ) exit;
class Breadcrumb extends Widget_Base {
    public function get_name() { return 'royal-wc-breadcrumb'; }
    public function get_title() { return 'Breadcrumb'; }
    public function get_icon() { return 'eicon-product-breadcrumbs rtbranding'; }
    public function get_categories() { return ['royaltech_singleproduct']; }
    public function get_keywords() { return [ 'breadcrumb', 'tech', 'technologies', 'royal', 'mehdi', 'akram' ]; }

    protected function register_controls() {}
    protected function render() { echo '<div class="royal-breadcrumb woocommerce">'; woocommerce_breadcrumb(); echo '</div>'; }
}
