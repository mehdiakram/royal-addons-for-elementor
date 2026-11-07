<?php
namespace RoyalAddons\Widgets\LayoutWidgets\SinglePost;
use Elementor\Widget_Base;
if ( ! defined( 'ABSPATH' ) ) exit;
class Post_Author extends Widget_Base {
    public function get_name() { return 'royal-post-author'; }
    public function get_title() { return 'Post Author'; }
    public function get_icon() { return 'eicon-person rtbranding'; }
    public function get_categories() { return ['royaltech_singlepost']; }
    public function get_keywords() { return [ 'post', 'author', 'single', 'blog', 'tech', 'technologies', 'royal', 'mehdi', 'akram' ]; }

    protected function register_controls() {}
    protected function render() { echo '<div class="royal-post-author"><a href="'.esc_url(get_author_posts_url(get_the_author_meta('ID'))).'">'.esc_html(get_the_author()).'</a></div>'; }
}
