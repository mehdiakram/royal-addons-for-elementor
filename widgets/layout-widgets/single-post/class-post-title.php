<?php
namespace RoyalAddons\Widgets\LayoutWidgets\SinglePost;
use Elementor\Widget_Base;
if ( ! defined( 'ABSPATH' ) ) exit;

class Post_Title extends Widget_Base {
    public function get_name() { return 'royal-post-title'; }
    public function get_title() { return 'Post Title'; }
    public function get_icon() { return 'eicon-post-title rtbranding'; }
    public function get_categories() { return ['royaltech_singlepost']; }
    public function get_keywords() { return [ 'post', 'title', 'single', 'blog', 'tech', 'technologies', 'royal', 'mehdi', 'akram' ]; }

    protected function register_controls() {
        $this->start_controls_section('c',['label' => __('Content', 'royal-addons-for-elementor')]);
        $this->add_control('tag',['label' => __('Tag', 'royal-addons-for-elementor'),'type'=>\Elementor\Controls_Manager::SELECT,'default'=>'h1',
            'options'=>['h1'=>'H1','h2'=>'H2','h3'=>'H3','div'=>'div']]);
        $this->end_controls_section();
        $this->start_controls_section('s',['label' => __('Style', 'royal-addons-for-elementor'),'tab'=>\Elementor\Controls_Manager::TAB_STYLE]);
        $this->add_control('color',['label' => __('Color', 'royal-addons-for-elementor'),'type'=>\Elementor\Controls_Manager::COLOR,'selectors'=>['{{WRAPPER}} .royal-post-title'=>'color:{{VALUE}}']]);
        $this->add_group_control(\Elementor\Group_Control_Typography::get_type(),['name'=>'t','selector'=>'{{WRAPPER}} .royal-post-title']);
        $this->end_controls_section();
    }
    protected function render() {
        $tag = $this->get_settings_for_display('tag');
        echo '<'.esc_attr($tag).' class="royal-post-title">'.esc_html(get_the_title()).'</'.esc_attr($tag).'>';
    }
}
