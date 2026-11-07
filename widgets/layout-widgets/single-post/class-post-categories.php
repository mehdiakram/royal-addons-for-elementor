<?php
namespace RoyalAddons\Widgets\LayoutWidgets\SinglePost;
use Elementor\Widget_Base;
if ( ! defined( 'ABSPATH' ) ) exit;

class Post_Categories extends Widget_Base {
    public function get_name() { return 'royal-post-categories'; }
    public function get_title() { return 'Post Categories'; }
    public function get_icon() { return 'eicon-flow rtbranding'; }
    public function get_categories() { return ['royaltech_singlepost']; }
    public function get_keywords() { return [ 'post', 'categories', 'single', 'blog', 'tech', 'technologies', 'royal', 'mehdi', 'akram' ]; }

    protected function register_controls() {}
    protected function render() {
        $cats = get_the_category_list(', ');
        if($cats) echo '<div class="royal-post-categories">'.$cats.'</div>';
    }
}
