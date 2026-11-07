<?php
namespace RoyalAddons\Widgets\LayoutWidgets\SinglePost;
use Elementor\Widget_Base;
if ( ! defined( 'ABSPATH' ) ) exit;

class Post_Image extends Widget_Base {
    public function get_name() { return 'royal-post-image'; }
    public function get_title() { return 'Featured Image'; }
    public function get_icon() { return 'eicon-featured-image rtbranding'; }
    public function get_categories() { return ['royaltech_singlepost']; }
    public function get_keywords() { return [ 'featured', 'image', 'post', 'single', 'blog', 'tech', 'technologies', 'royal', 'mehdi', 'akram' ]; }

    protected function register_controls() {
        $this->start_controls_section('s',['label' => __('Style', 'royal-addons-for-elementor'),'tab'=>\Elementor\Controls_Manager::TAB_STYLE]);
        $this->add_control('border_radius',['label' => __('Border Radius', 'royal-addons-for-elementor'),'type'=>\Elementor\Controls_Manager::DIMENSIONS,
            'selectors'=>['{{WRAPPER}} img'=>'border-radius:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}']]);
        $this->end_controls_section();
    }
    protected function render() {
        if(!has_post_thumbnail()) return;
        echo '<div class="royal-post-image">';
        the_post_thumbnail('full');
        echo '</div>';
    }
}
