<?php
namespace RoyalAddons\Widgets\LayoutWidgets\ShopArchive;
use Elementor\Widget_Base;
if ( ! defined( 'ABSPATH' ) ) exit;

class Archive_Products extends Widget_Base {
    public function get_name() { return 'royal-archive-products'; }
    public function get_title() { return 'Archive Products'; }
    public function get_icon() { return 'eicon-products rtbranding'; }
    public function get_categories() { return ['royaltech_shoparchive']; }
    public function get_keywords() { return [ 'archive', 'products', 'shop', 'woocommerce', 'tech', 'technologies', 'royal', 'mehdi', 'akram' ]; }

    protected function register_controls() {
        $this->start_controls_section('s',['label' => __('Layout', 'royal-addons-for-elementor')]);
        $this->add_control('columns',['label' => __('Columns', 'royal-addons-for-elementor'),'type'=>\Elementor\Controls_Manager::SELECT,'default'=>'4','options'=>['2'=>'2','3'=>'3','4'=>'4','5'=>'5','6'=>'6']]);
        $this->add_control('per_page',['label' => __('Per Page', 'royal-addons-for-elementor'),'type'=>\Elementor\Controls_Manager::NUMBER,'default'=>12]);
        $this->end_controls_section();
    }
    protected function render() {
        if (!function_exists('WC')) return;
        $s = $this->get_settings_for_display();
        echo '<div class="royal-archive-products woocommerce">';
        echo do_shortcode('[products limit="'.$s['per_page'].'" columns="'.$s['columns'].'" paginate="true"]');
        echo '</div>';
    }
}
