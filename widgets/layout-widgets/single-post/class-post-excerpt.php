<?php
namespace RoyalAddons\Widgets\LayoutWidgets\SinglePost;
use Elementor\Widget_Base;
if ( ! defined( 'ABSPATH' ) ) exit;
class Post_Excerpt extends Widget_Base {
    public function get_name() { return 'royal-post-excerpt'; }
    public function get_title() { return 'Post Excerpt'; }
    public function get_icon() { return 'eicon-post-excerpt rtbranding'; }
    public function get_categories() { return ['royaltech_singlepost']; }
    public function get_keywords() { return [ 'post', 'excerpt', 'single', 'blog', 'tech', 'technologies', 'royal', 'mehdi', 'akram' ]; }

    protected function register_controls() {}
    protected function render() { $e=get_the_excerpt(); if($e) echo '<div class="royal-post-excerpt">'.esc_html($e).'</div>'; }
}
