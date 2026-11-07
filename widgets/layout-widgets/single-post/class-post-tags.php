<?php
namespace RoyalAddons\Widgets\LayoutWidgets\SinglePost;
use Elementor\Widget_Base;
if ( ! defined( 'ABSPATH' ) ) exit;

class Post_Tags extends Widget_Base {
    public function get_name() { return 'royal-post-tags'; }
    public function get_title() { return 'Post Tags'; }
    public function get_icon() { return 'eicon-tags rtbranding'; }
    public function get_categories() { return ['royaltech_singlepost']; }
    public function get_keywords() { return [ 'post', 'tags', 'single', 'blog', 'tech', 'technologies', 'royal', 'mehdi', 'akram' ]; }

    protected function register_controls() {}
    protected function render() {
        $tags = get_the_tag_list('',', ');
        if($tags) echo '<div class="royal-post-tags">'.$tags.'</div>';
    }
}
