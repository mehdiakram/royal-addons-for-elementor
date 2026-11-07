<?php
namespace RoyalAddons\Widgets\LayoutWidgets\SinglePost;
use Elementor\Widget_Base;
if ( ! defined( 'ABSPATH' ) ) exit;

class Post_Author_Bio extends Widget_Base {
    public function get_name() { return 'royal-post-author-bio'; }
    public function get_title() { return 'Author Bio'; }
    public function get_icon() { return 'eicon-person rtbranding'; }
    public function get_categories() { return ['royaltech_singlepost']; }
    public function get_keywords() { return [ 'author', 'bio', 'post', 'single', 'blog', 'tech', 'technologies', 'royal', 'mehdi', 'akram' ]; }

    protected function register_controls() {}
    protected function render() {
        $author_id = get_the_author_meta('ID');
        $bio = get_the_author_meta('description');
        echo '<div class="royal-post-author-bio">';
        echo '<div style="display:flex;gap:15px;align-items:center">';
        echo get_avatar($author_id, 80);
        echo '<div><strong>'.esc_html(get_the_author()).'</strong>';
        if($bio) echo '<p>'.esc_html($bio).'</p>';
        echo '</div></div></div>';
    }
}
