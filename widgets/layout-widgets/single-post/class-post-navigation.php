<?php
namespace RoyalAddons\Widgets\LayoutWidgets\SinglePost;
use Elementor\Widget_Base;
if ( ! defined( 'ABSPATH' ) ) exit;

class Post_Navigation extends Widget_Base {
    public function get_name() { return 'royal-post-navigation'; }
    public function get_title() { return 'Post Navigation'; }
    public function get_icon() { return 'eicon-post-navigation rtbranding'; }
    public function get_categories() { return ['royaltech_singlepost']; }
    public function get_keywords() { return [ 'post', 'navigation', 'single', 'blog', 'tech', 'technologies', 'royal', 'mehdi', 'akram' ]; }

    protected function register_controls() {}
    protected function render() {
        echo '<div class="royal-post-navigation">';
        the_post_navigation(['prev_text'=>'&larr; %title','next_text'=>'%title &rarr;']);
        echo '</div>';
    }
}
