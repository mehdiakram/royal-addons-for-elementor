<?php
namespace RoyalAddons\Widgets\LayoutWidgets\SinglePost;
use Elementor\Widget_Base;
if ( ! defined( 'ABSPATH' ) ) exit;

class Post_Content extends Widget_Base {
    public function get_name() { return 'royal-post-content'; }
    public function get_title() { return 'Post Content'; }
    public function get_icon() { return 'eicon-post-content rtbranding'; }
    public function get_categories() { return ['royaltech_singlepost']; }
    public function get_keywords() { return [ 'post', 'content', 'single', 'blog', 'tech', 'technologies', 'royal', 'mehdi', 'akram' ]; }

    protected function register_controls() {}
    protected function render() {
        echo '<div class="royal-post-content entry-content">';
        the_content();
        wp_link_pages();
        echo '</div>';
    }
}
