<?php
namespace RoyalAddons\Widgets\LayoutWidgets\SinglePost;
use Elementor\Widget_Base;
if ( ! defined( 'ABSPATH' ) ) exit;
class Post_Date extends Widget_Base {
    public function get_name() { return 'royal-post-date'; }
    public function get_title() { return 'Post Date'; }
    public function get_icon() { return 'eicon-calendar rtbranding'; }
    public function get_categories() { return ['royaltech_singlepost']; }
    public function get_keywords() { return [ 'post', 'date', 'single', 'blog', 'tech', 'technologies', 'royal', 'mehdi', 'akram' ]; }

    protected function register_controls() {}
    protected function render() { echo '<div class="royal-post-date"><time datetime="'.esc_attr(get_the_date('c')).'">'.esc_html(get_the_date()).'</time></div>'; }
}
