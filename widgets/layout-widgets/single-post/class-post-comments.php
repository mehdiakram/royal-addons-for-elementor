<?php
namespace RoyalAddons\Widgets\LayoutWidgets\SinglePost;
use Elementor\Widget_Base;
if ( ! defined( 'ABSPATH' ) ) exit;

class Post_Comments extends Widget_Base {
    public function get_name() { return 'royal-post-comments'; }
    public function get_title() { return 'Post Comments'; }
    public function get_icon() { return 'eicon-comments rtbranding'; }
    public function get_categories() { return ['royaltech_singlepost']; }
    public function get_keywords() { return [ 'post', 'comments', 'single', 'blog', 'tech', 'technologies', 'royal', 'mehdi', 'akram' ]; }

    protected function register_controls() {}
    protected function render() {
        if(!comments_open() && !get_comments_number()) return;
        echo '<div class="royal-post-comments">';
        comments_template();
        echo '</div>';
    }
}
