<?php
namespace RoyalAddons\Widgets\LayoutWidgets\PostArchive;
use Elementor\Widget_Base;
if ( ! defined( 'ABSPATH' ) ) exit;
class Blog_Archive extends Widget_Base {
    public function get_name() { return 'royal-blog-archive'; }
    public function get_title() { return 'Blog Archive'; }
    public function get_icon() { return 'eicon-post-list rtbranding'; }
    public function get_categories() { return ['royaltech_postarchive']; }
    public function get_keywords() { return [ 'blog', 'archive', 'tech', 'technologies', 'royal', 'mehdi', 'akram' ]; }

    protected function register_controls() {
        $this->start_controls_section('s',['label' => __('Layout', 'royal-addons-for-elementor')]);
        $this->add_control('columns',['label' => __('Columns', 'royal-addons-for-elementor'),'type'=>\Elementor\Controls_Manager::SELECT,'default'=>'3','options'=>['1'=>'1','2'=>'2','3'=>'3','4'=>'4']]);
        $this->add_control('per_page',['label' => __('Posts Per Page', 'royal-addons-for-elementor'),'type'=>\Elementor\Controls_Manager::NUMBER,'default'=>9]);
        $this->end_controls_section();
    }
    protected function render() {
        $s = $this->get_settings_for_display();
        $paged = get_query_var('paged') ?: 1;
        $args = ['post_type'=>'post','posts_per_page'=>$s['per_page'],'paged'=>$paged];
        if(is_category()) $args['cat'] = get_queried_object_id();
        if(is_tag()) $args['tag_id'] = get_queried_object_id();
        if(is_author()) $args['author'] = get_queried_object_id();
        $q = new \WP_Query($args);
        echo '<div class="royal-blog-archive" style="display:grid;grid-template-columns:repeat('.$s['columns'].',1fr);gap:20px">';
        if($q->have_posts()): while($q->have_posts()): $q->the_post();
            echo '<article class="royal-blog-post">';
            if(has_post_thumbnail()) echo '<a href="'.esc_url(get_permalink()).'">'.get_the_post_thumbnail(null,'medium_large').'</a>';
            echo '<h3 style="margin:10px 0 5px"><a href="'.esc_url(get_permalink()).'">'.esc_html(get_the_title()).'</a></h3>';
            echo '<p style="color:#666;font-size:13px">'.esc_html(get_the_date()).' &bull; '.esc_html(get_the_author()).'</p>';
            echo '<p>'.esc_html(wp_trim_words(get_the_excerpt(),20)).'</p>';
            echo '</article>';
        endwhile; endif;
        echo '</div>';
        echo '<div class="royal-blog-pagination" style="margin-top:20px;text-align:center">';
        echo paginate_links(['total'=>$q->max_num_pages,'current'=>$paged]);
        echo '</div>';
        wp_reset_postdata();
    }
}
