<?php
namespace RoyalAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Css_Filter;
use Elementor\Icons_Manager;

if ( ! defined( 'ABSPATH' ) ) exit;

class RoyalMasonry extends Widget_Base {

    public function get_name() { return 'royalmasonry'; }
    public function get_title() { return esc_html__( 'Masonry', 'royal-addons-for-elementor' ); }
    public function get_icon() { return 'eicon-gallery-masonry rtbranding'; }
    public function get_keywords() { return [ 'masonry', 'gallery', 'portfolio', 'filter', 'grid', 'isotope', 'royal', 'tech', 'technologies', 'mehdi', 'akram' ]; }
    public function get_categories() { return [ 'royaltech' ]; }
    public function get_style_depends() { return [ 'royalmasonry-widget' ]; }
    public function get_script_depends() { return [ 'isotope', 'imagesloaded', 'magnific-popup', 'royalmasonry-widget' ]; }

    /* =========================================================
       HELPER: get public post types
       ========================================================= */
    private function get_post_types() {
        $excluded = ['attachment','revision','nav_menu_item','custom_css','customize_changeset','oembed_cache','user_request','wp_block','scheduled-action','product_variation','shop_order','shop_order_refund','shop_coupon','page','elementor_library','e-landing-page'];
        $types = get_post_types(['public' => true]);
        $types = array_diff($types, $excluded);
        $options = [];
        foreach ($types as $type) {
            $obj = get_post_type_object($type);
            $options[$type] = $obj ? $obj->labels->name : $type;
        }
        return $options;
    }

    private function get_taxonomies_for_post_type($post_type) {
        $taxonomies = get_object_taxonomies($post_type, 'objects');
        $options = [];
        foreach ($taxonomies as $tax) {
            if ($tax->public) $options[$tax->name] = $tax->labels->name;
        }
        return $options;
    }

    private function get_terms_for_taxonomy($taxonomy) {
        $terms = get_terms(['taxonomy' => $taxonomy, 'hide_empty' => true]);
        $options = [];
        if (!is_wp_error($terms)) {
            foreach ($terms as $term) {
                $options[$term->term_id] = $term->name;
            }
        }
        return $options;
    }

    private function get_posts_for_exclude($post_type) {
        $posts = get_posts(['post_type' => $post_type, 'posts_per_page' => -1, 'post_status' => 'publish']);
        $options = [];
        foreach ($posts as $post) { $options[$post->ID] = $post->post_title; }
        return $options;
    }

    /* =========================================================
       CONTROLS
       ========================================================= */
    protected function register_controls() {
        $this->register_content_controls();
        $this->register_gallery_controls();
        $this->register_query_controls();
        $this->register_layout_controls();
        $this->register_filter_style_controls();
        $this->register_item_style_controls();
        $this->register_overlay_style_controls();
        $this->register_icon_style_controls();
    }

    /* --- Content Source --- */
    private function register_content_controls() {
        $this->start_controls_section('section_content_source', [
            'label' => esc_html__('Content Source', 'royal-addons-for-elementor'),
        ]);
        $this->add_control('content_source', [
            'label' => esc_html__('Source', 'royal-addons-for-elementor'),
            'type' => Controls_Manager::SELECT,
            'default' => 'gallery',
            'options' => [
                'gallery'   => esc_html__('Gallery (Manual)', 'royal-addons-for-elementor'),
                'post_type' => esc_html__('Post Type (Dynamic)', 'royal-addons-for-elementor'),
            ],
        ]);
        $this->end_controls_section();
    }

    /* --- Gallery Repeater --- */
    private function register_gallery_controls() {
        $this->start_controls_section('section_gallery', [
            'label' => esc_html__('Gallery Items', 'royal-addons-for-elementor'),
            'condition' => ['content_source' => 'gallery'],
        ]);
        $repeater = new \Elementor\Repeater();
        $repeater->add_control('title', ['label' => esc_html__('Title', 'royal-addons-for-elementor'), 'type' => Controls_Manager::TEXT, 'default' => 'Gallery Item', 'label_block' => true]);
        $repeater->add_control('image', ['label' => esc_html__('Image', 'royal-addons-for-elementor'), 'type' => Controls_Manager::MEDIA, 'default' => ['url' => \Elementor\Utils::get_placeholder_image_src()]]);
        $repeater->add_control('filtername', ['label' => esc_html__('Filter Name', 'royal-addons-for-elementor'), 'type' => Controls_Manager::TEXT, 'description' => esc_html__('Comma separated. e.g. Design,Branding', 'royal-addons-for-elementor'), 'label_block' => true]);
        $repeater->add_control('popup_type', ['label' => esc_html__('Popup Type', 'royal-addons-for-elementor'), 'type' => Controls_Manager::SELECT, 'default' => 'image', 'options' => ['image' => 'Image', 'video' => 'Video', 'link' => 'Custom Link']]);
        $repeater->add_control('video_url', ['label' => esc_html__('Video URL', 'royal-addons-for-elementor'), 'type' => Controls_Manager::TEXT, 'default' => 'https://www.youtube.com/watch?v=XHOmBV4js_E', 'label_block' => true, 'condition' => ['popup_type' => 'video']]);
        $repeater->add_control('custom_link', ['label' => esc_html__('Custom Link', 'royal-addons-for-elementor'), 'type' => Controls_Manager::URL, 'placeholder' => 'https://your-link.com', 'condition' => ['popup_type' => 'link']]);
        $repeater->add_control('link_icon', ['label' => esc_html__('Link Icon', 'royal-addons-for-elementor'), 'type' => Controls_Manager::ICONS, 'default' => ['value' => 'fas fa-link', 'library' => 'fa-solid']]);
        $repeater->add_control('zoom_icon', ['label' => esc_html__('Zoom Icon', 'royal-addons-for-elementor'), 'type' => Controls_Manager::ICONS, 'default' => ['value' => 'fas fa-search', 'library' => 'fa-solid']]);

        $this->add_control('gallery_items', [
            'type' => Controls_Manager::REPEATER,
            'fields' => $repeater->get_controls(),
            'default' => [
                ['title' => __('Gallery One', 'royal-addons-for-elementor'), 'filtername' => 'Design,Branding'],
                ['title' => __('Gallery Two', 'royal-addons-for-elementor'), 'filtername' => 'Websites,Branding'],
                ['title' => __('Gallery Three', 'royal-addons-for-elementor'), 'filtername' => 'Design,Websites'],
                ['title' => __('Gallery Four', 'royal-addons-for-elementor'), 'filtername' => 'Design'],
                ['title' => __('Gallery Five', 'royal-addons-for-elementor'), 'filtername' => 'Branding'],
                ['title' => __('Gallery Six', 'royal-addons-for-elementor'), 'filtername' => 'Websites'],
            ],
            'title_field' => '{{{ title }}}',
        ]);
        $this->end_controls_section();
    }

    /* --- Query Controls (Post Type mode) --- */
    private function register_query_controls() {
        $this->start_controls_section('section_query', [
            'label' => esc_html__('Query Settings', 'royal-addons-for-elementor'),
            'condition' => ['content_source' => 'post_type'],
        ]);

        $this->add_control('post_type', [
            'label' => esc_html__('Post Type', 'royal-addons-for-elementor'),
            'type' => Controls_Manager::SELECT,
            'default' => 'post',
            'options' => $this->get_post_types(),
        ]);

        $this->add_control('display_type', [
            'label' => esc_html__('Display By', 'royal-addons-for-elementor'),
            'type' => Controls_Manager::SELECT,
            'default' => 'category',
            'options' => ['category' => 'Categories', 'posts' => 'All Posts'],
        ]);

        // Post categories
        $this->add_control('post_categories', [
            'label' => esc_html__('Categories', 'royal-addons-for-elementor'),
            'type' => Controls_Manager::SELECT2,
            'multiple' => true,
            'options' => $this->get_terms_for_taxonomy('category'),
            'condition' => ['post_type' => 'post', 'display_type' => 'category'],
        ]);

        // Product categories
        if (class_exists('WooCommerce')) {
            $this->add_control('product_categories', [
                'label' => esc_html__('Product Categories', 'royal-addons-for-elementor'),
                'type' => Controls_Manager::SELECT2,
                'multiple' => true,
                'options' => $this->get_terms_for_taxonomy('product_cat'),
                'condition' => ['post_type' => 'product', 'display_type' => 'category'],
            ]);
        }

        $this->add_control('taxonomy_name', [
            'label' => esc_html__('Taxonomy', 'royal-addons-for-elementor'),
            'type' => Controls_Manager::TEXT,
            'description' => esc_html__('Enter taxonomy slug for custom post type', 'royal-addons-for-elementor'),
            'conditions' => ['relation' => 'and', 'terms' => [
                ['name' => 'post_type', 'operator' => '!==', 'value' => 'post'],
                ['name' => 'post_type', 'operator' => '!==', 'value' => 'product'],
                ['name' => 'display_type', 'operator' => '===', 'value' => 'category'],
            ]],
        ]);

        $this->add_control('posts_per_page', ['label' => esc_html__('Posts Per Page', 'royal-addons-for-elementor'), 'type' => Controls_Manager::NUMBER, 'default' => -1, 'min' => -1, 'max' => 100]);
        $this->add_control('orderby', ['label' => esc_html__('Order By', 'royal-addons-for-elementor'), 'type' => Controls_Manager::SELECT, 'default' => 'date', 'options' => ['ID' => 'Post ID', 'title' => __('Title', 'royal-addons-for-elementor'), 'date' => 'Date', 'modified' => 'Modified', 'menu_order' => 'Menu Order', 'rand' => 'Random']]);
        $this->add_control('order', ['label' => esc_html__('Order', 'royal-addons-for-elementor'), 'type' => Controls_Manager::SELECT, 'default' => 'DESC', 'options' => ['ASC' => 'Ascending', 'DESC' => 'Descending']]);
        $this->add_control('hide_category_text', ['label' => esc_html__('Hide Category Text', 'royal-addons-for-elementor'), 'type' => Controls_Manager::SWITCHER, 'default' => 'no']);
        $this->add_control('show_full_title', ['label' => esc_html__('Show Full Title', 'royal-addons-for-elementor'), 'type' => Controls_Manager::SWITCHER, 'default' => 'no']);
        $this->add_control('show_excerpt', ['label' => esc_html__('Show Excerpt', 'royal-addons-for-elementor'), 'type' => Controls_Manager::SWITCHER, 'default' => 'no', 'condition' => ['item_style' => 'card']]);
        $this->add_control('excerpt_length', ['label' => esc_html__('Excerpt Length', 'royal-addons-for-elementor'), 'type' => Controls_Manager::NUMBER, 'default' => 120, 'min' => 20, 'max' => 500, 'condition' => ['show_excerpt' => 'yes']]);
        $this->add_control('zoom_icon', ['label' => esc_html__('Zoom Icon', 'royal-addons-for-elementor'), 'type' => Controls_Manager::ICONS, 'default' => ['value' => 'fas fa-search', 'library' => 'fa-solid']]);
        $this->add_control('link_icon', ['label' => esc_html__('Link Icon', 'royal-addons-for-elementor'), 'type' => Controls_Manager::ICONS, 'default' => ['value' => 'fas fa-link', 'library' => 'fa-solid']]);

        $this->end_controls_section();
    }

    /* --- Layout Controls --- */
    private function register_layout_controls() {
        $this->start_controls_section('section_layout', ['label' => esc_html__('Layout', 'royal-addons-for-elementor')]);

        $this->add_responsive_control('columns', ['label' => esc_html__('Columns', 'royal-addons-for-elementor'), 'type' => Controls_Manager::SELECT, 'default' => '3', 'options' => ['2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6']]);
        $this->add_control('item_style', ['label' => esc_html__('Item Style', 'royal-addons-for-elementor'), 'type' => Controls_Manager::SELECT, 'default' => 'overlay', 'options' => ['overlay' => 'Overlay', 'card' => 'Card']]);
        $this->add_control('hover_effect', ['label' => esc_html__('Hover Effect', 'royal-addons-for-elementor'), 'type' => Controls_Manager::SELECT, 'default' => 'eff1', 'options' => ['eff1' => 'Scale Fade', 'eff2' => 'Slide Down', 'eff3' => 'Curtain', 'eff4' => 'Zoom', 'eff5' => 'Flip'], 'condition' => ['item_style' => 'overlay']]);
        $this->add_control('show_filter', ['label' => esc_html__('Show Filter', 'royal-addons-for-elementor'), 'type' => Controls_Manager::SWITCHER, 'default' => 'yes']);
        $this->add_control('filter_style', ['label' => esc_html__('Filter Style', 'royal-addons-for-elementor'), 'type' => Controls_Manager::SELECT, 'default' => 'one', 'options' => ['one' => 'Underline', 'two' => 'Fill', 'three' => 'Border', 'four' => 'Pill', 'five' => 'Top Border'], 'condition' => ['show_filter' => 'yes']]);
        $this->add_control('all_text', ['label' => esc_html__('All Button Text', 'royal-addons-for-elementor'), 'type' => Controls_Manager::TEXT, 'default' => 'All', 'condition' => ['show_filter' => 'yes']]);
        $this->add_control('entrance_animation', ['label' => esc_html__('Entrance Animation', 'royal-addons-for-elementor'), 'type' => Controls_Manager::SWITCHER, 'default' => 'yes']);
        $this->add_control('show_readmore', ['label' => esc_html__('Show Read More', 'royal-addons-for-elementor'), 'type' => Controls_Manager::SWITCHER, 'default' => 'no']);
        $this->add_control('readmore_text', ['label' => esc_html__('Read More Text', 'royal-addons-for-elementor'), 'type' => Controls_Manager::TEXT, 'default' => 'View All', 'condition' => ['show_readmore' => 'yes']]);
        $this->add_control('readmore_link', ['label' => esc_html__('Read More Link', 'royal-addons-for-elementor'), 'type' => Controls_Manager::URL, 'condition' => ['show_readmore' => 'yes']]);
        $this->add_control('mobile_filter_stack', ['label' => esc_html__('Mobile Filter Stack', 'royal-addons-for-elementor'), 'type' => Controls_Manager::SWITCHER, 'default' => 'no', 'condition' => ['show_filter' => 'yes']]);

        $this->add_group_control(Group_Control_Image_Size::get_type(), ['name' => 'image_size', 'default' => 'large', 'separator' => 'before']);

        $this->add_responsive_control('item_gap', ['label' => esc_html__('Gap', 'royal-addons-for-elementor'), 'type' => Controls_Manager::SLIDER, 'range' => ['px' => ['min' => 0, 'max' => 50]], 'default' => ['size' => 5, 'unit' => 'px'], 'selectors' => ['{{WRAPPER}} .royal-masonry-item' => 'padding: {{SIZE}}{{UNIT}};']]);
        $this->add_control('item_border_radius', ['label' => esc_html__('Border Radius', 'royal-addons-for-elementor'), 'type' => Controls_Manager::DIMENSIONS, 'size_units' => ['px', '%'], 'selectors' => ['{{WRAPPER}} .royal-masonry-item-inner' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};']]);

        $this->end_controls_section();
    }

    /* --- Filter Style --- */
    private function register_filter_style_controls() {
        $this->start_controls_section('section_filter_style', ['label' => esc_html__('Filter Style', 'royal-addons-for-elementor'), 'tab' => Controls_Manager::TAB_STYLE, 'condition' => ['show_filter' => 'yes']]);
        $this->add_group_control(Group_Control_Typography::get_type(), ['name' => 'filter_typography', 'selector' => '{{WRAPPER}} .royal-masonry-filter ul li']);
        $this->add_responsive_control('filter_alignment', ['label' => esc_html__('Alignment', 'royal-addons-for-elementor'), 'type' => Controls_Manager::CHOOSE, 'options' => ['flex-start' => ['title' => __('Left', 'royal-addons-for-elementor'), 'icon' => 'eicon-text-align-left'], 'center' => ['title' => __('Center', 'royal-addons-for-elementor'), 'icon' => 'eicon-text-align-center'], 'flex-end' => ['title' => __('Right', 'royal-addons-for-elementor'), 'icon' => 'eicon-text-align-right']], 'default' => 'center', 'selectors' => ['{{WRAPPER}} .royal-masonry-filter ul' => 'justify-content: {{VALUE}};']]);
        $this->add_control('filter_spacing', ['label' => esc_html__('Bottom Spacing', 'royal-addons-for-elementor'), 'type' => Controls_Manager::SLIDER, 'range' => ['px' => ['min' => 0, 'max' => 100]], 'default' => ['size' => 25], 'selectors' => ['{{WRAPPER}} .royal-masonry-filter' => 'margin-bottom: {{SIZE}}{{UNIT}};']]);

        $this->start_controls_tabs('filter_tabs');
        $this->start_controls_tab('filter_normal', ['label' => esc_html__('Normal', 'royal-addons-for-elementor')]);
        $this->add_control('filter_color', ['label' => esc_html__('Color', 'royal-addons-for-elementor'), 'type' => Controls_Manager::COLOR, 'selectors' => ['{{WRAPPER}} .royal-masonry-filter ul li' => 'color: {{VALUE}};']]);
        $this->add_control('filter_bg', ['label' => esc_html__('Background', 'royal-addons-for-elementor'), 'type' => Controls_Manager::COLOR, 'selectors' => ['{{WRAPPER}} .royal-masonry-filter ul li' => 'background-color: {{VALUE}};']]);
        $this->end_controls_tab();
        $this->start_controls_tab('filter_active', ['label' => esc_html__('Active', 'royal-addons-for-elementor')]);
        $this->add_control('filter_active_color', ['label' => esc_html__('Color', 'royal-addons-for-elementor'), 'type' => Controls_Manager::COLOR, 'selectors' => ['{{WRAPPER}} .royal-masonry-filter ul li.active' => 'color: {{VALUE}};', '{{WRAPPER}} .royal-masonry-filter ul li:hover' => 'color: {{VALUE}};']]);
        $this->add_control('filter_active_bg', ['label' => esc_html__('Background', 'royal-addons-for-elementor'), 'type' => Controls_Manager::COLOR, 'selectors' => ['{{WRAPPER}} .royal-masonry-filter ul li.active' => 'background-color: {{VALUE}};', '{{WRAPPER}} .royal-masonry-filter ul li:hover' => 'background-color: {{VALUE}};']]);
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    /* --- Item Style --- */
    private function register_item_style_controls() {
        $this->start_controls_section('section_item_style', ['label' => esc_html__('Item Style', 'royal-addons-for-elementor'), 'tab' => Controls_Manager::TAB_STYLE]);
        $this->add_group_control(Group_Control_Box_Shadow::get_type(), ['name' => 'item_shadow', 'selector' => '{{WRAPPER}} .royal-masonry-item-inner']);
        $this->add_group_control(Group_Control_Box_Shadow::get_type(), ['name' => 'item_shadow_hover', 'label' => esc_html__('Hover Shadow', 'royal-addons-for-elementor'), 'selector' => '{{WRAPPER}} .royal-masonry-item-inner:hover']);
        $this->add_group_control(Group_Control_Css_Filter::get_type(), ['name' => 'image_css_filter', 'selector' => '{{WRAPPER}} .royal-masonry-item-inner img']);
        $this->add_group_control(Group_Control_Css_Filter::get_type(), ['name' => 'image_css_filter_hover', 'label' => esc_html__('Hover CSS Filters', 'royal-addons-for-elementor'), 'selector' => '{{WRAPPER}} .royal-masonry-item-inner:hover img']);
        $this->end_controls_section();
    }

    /* --- Overlay Style --- */
    private function register_overlay_style_controls() {
        $this->start_controls_section('section_overlay_style', ['label' => esc_html__('Overlay Style', 'royal-addons-for-elementor'), 'tab' => Controls_Manager::TAB_STYLE, 'condition' => ['item_style' => 'overlay']]);
        $this->add_group_control(Group_Control_Background::get_type(), ['name' => 'overlay_bg', 'label' => esc_html__('Background', 'royal-addons-for-elementor'), 'types' => ['classic', 'gradient'], 'selector' => '{{WRAPPER}} .royal-masonry-overlay']);
        $this->add_group_control(Group_Control_Typography::get_type(), ['name' => 'overlay_title_typography', 'label' => esc_html__('Title Typography', 'royal-addons-for-elementor'), 'selector' => '{{WRAPPER}} .royal-masonry-overlay-title']);
        $this->add_control('overlay_title_color', ['label' => esc_html__('Title Color', 'royal-addons-for-elementor'), 'type' => Controls_Manager::COLOR, 'selectors' => ['{{WRAPPER}} .royal-masonry-overlay-title' => 'color: {{VALUE}};']]);
        $this->add_control('overlay_line_color', ['label' => esc_html__('Line Color', 'royal-addons-for-elementor'), 'type' => Controls_Manager::COLOR, 'selectors' => ['{{WRAPPER}} .royal-masonry-overlay-title::after' => 'background-color: {{VALUE}};']]);
        $this->add_control('cat_badge_bg', ['label' => esc_html__('Category Badge BG', 'royal-addons-for-elementor'), 'type' => Controls_Manager::COLOR, 'selectors' => ['{{WRAPPER}} .royal-masonry-cat' => 'background-color: {{VALUE}};']]);
        $this->add_control('cat_badge_color', ['label' => esc_html__('Category Badge Color', 'royal-addons-for-elementor'), 'type' => Controls_Manager::COLOR, 'selectors' => ['{{WRAPPER}} .royal-masonry-cat' => 'color: {{VALUE}};']]);
        $this->end_controls_section();
    }

    /* --- Icon Style --- */
    private function register_icon_style_controls() {
        $this->start_controls_section('section_icon_style', ['label' => esc_html__('Icon Style', 'royal-addons-for-elementor'), 'tab' => Controls_Manager::TAB_STYLE]);
        $this->start_controls_tabs('icon_tabs');
        $this->start_controls_tab('icon_normal', ['label' => esc_html__('Normal', 'royal-addons-for-elementor')]);
        $this->add_control('icon_color', ['label' => esc_html__('Color', 'royal-addons-for-elementor'), 'type' => Controls_Manager::COLOR, 'selectors' => ['{{WRAPPER}} .royal-masonry-overlay-link' => 'color: {{VALUE}};']]);
        $this->add_control('icon_bg', ['label' => esc_html__('Background', 'royal-addons-for-elementor'), 'type' => Controls_Manager::COLOR, 'selectors' => ['{{WRAPPER}} .royal-masonry-overlay-link' => 'background-color: {{VALUE}};']]);
        $this->end_controls_tab();
        $this->start_controls_tab('icon_hover', ['label' => esc_html__('Hover', 'royal-addons-for-elementor')]);
        $this->add_control('icon_hover_color', ['label' => esc_html__('Color', 'royal-addons-for-elementor'), 'type' => Controls_Manager::COLOR, 'selectors' => ['{{WRAPPER}} .royal-masonry-overlay-link:hover' => 'color: {{VALUE}};']]);
        $this->add_control('icon_hover_bg', ['label' => esc_html__('Background', 'royal-addons-for-elementor'), 'type' => Controls_Manager::COLOR, 'selectors' => ['{{WRAPPER}} .royal-masonry-overlay-link:hover' => 'background-color: {{VALUE}};']]);
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    /* =========================================================
       RENDER
       ========================================================= */
    protected function render() {
        $settings = $this->get_settings_for_display();
        $id = $this->get_id();
        $source = $settings['content_source'];
        $columns = $settings['columns'] ?? '3';
        $show_filter = $settings['show_filter'] === 'yes';
        $filter_style = $settings['filter_style'] ?? 'one';
        $hover_effect = $settings['hover_effect'] ?? 'eff1';
        $item_style = $settings['item_style'] ?? 'overlay';
        $animate_class = ($settings['entrance_animation'] === 'yes') ? ' royal-masonry-animate' : '';
        $mobile_class = ($settings['mobile_filter_stack'] === 'yes') ? ' royal-masonry-filter-mobile' : '';
        $image_size = $settings['image_size_size'] ?? 'large';

        // Build items array
        $items = [];
        $filter_names = [];

        if ($source === 'gallery') {
            $items = $this->build_gallery_items($settings, $filter_names, $image_size);
        } else {
            $items = $this->build_post_items($settings, $filter_names, $image_size);
        }

        echo '<div class="royal-masonry-wrapper' . esc_attr($animate_class) . '" data-widget-id="' . esc_attr($id) . '">';

        // Filter Nav
        if ($show_filter && !empty($filter_names)) {
            $unique_filters = array_unique($filter_names);
            echo '<div class="royal-masonry-filter royal-masonry-filter-' . esc_attr($filter_style) . esc_attr($mobile_class) . '"><ul>';
            echo '<li class="active" data-filter="*">' . esc_html($settings['all_text'] ?? 'All') . '</li>';
            foreach ($unique_filters as $fn) {
                $slug = sanitize_title($fn);
                echo '<li data-filter=".' . esc_attr($slug) . '">' . esc_html($fn) . '</li>';
            }
            echo '</ul></div>';
        }

        // Grid
        echo '<div class="royal-masonry-grid royal-masonry-col-' . esc_attr($columns) . ' royal-masonry-popup-gallery" data-active-filter="*">';
        echo '<div class="royal-masonry-sizer"></div>';

        foreach ($items as $item) {
            $filter_classes = '';
            if (!empty($item['filters'])) {
                foreach ($item['filters'] as $f) { $filter_classes .= ' ' . sanitize_title($f); }
            }

            echo '<div class="royal-masonry-item' . esc_attr($filter_classes) . '">';

            if ($item_style === 'card') {
                $this->render_card_item($item, $settings);
            } else {
                $this->render_overlay_item($item, $hover_effect, $settings);
            }

            echo '</div>';
        }

        echo '</div>'; // .royal-masonry-grid

        // Read More
        if ($settings['show_readmore'] === 'yes' && !empty($settings['readmore_link']['url'])) {
            echo '<div class="royal-masonry-readmore"><a href="' . esc_url($settings['readmore_link']['url']) . '">' . esc_html($settings['readmore_text']) . '</a></div>';
        }

        echo '</div>'; // .royal-masonry-wrapper

        // Editor re-init
        if (\Elementor\Plugin::instance()->editor->is_edit_mode()) {
            echo '<script>jQuery(function($){
                var $g=$(".royal-masonry-grid");
                $g.imagesLoaded(function(){
                    $g.isotope({itemSelector:".royal-masonry-item",percentPosition:true,masonry:{columnWidth:".royal-masonry-sizer",gutter:0}});
                });
            });</script>';
        }
    }

    /* --- Build Gallery Items --- */
    private function build_gallery_items($settings, &$filter_names, $image_size) {
        $items = [];
        foreach ($settings['gallery_items'] as $gi) {
            $filters = array_map('trim', explode(',', $gi['filtername'] ?? ''));
            $filter_names = array_merge($filter_names, $filters);

            $img_url = $gi['image']['url'] ?? '';
            if (!empty($gi['image']['id'])) {
                $img_html = wp_get_attachment_image($gi['image']['id'], $image_size);
            } else {
                $img_html = '<img src="' . esc_url($img_url) . '" alt="' . esc_attr($gi['title']) . '" loading="lazy">';
            }

            $popup_url = $img_url;
            $popup_class = 'royal-masonry-lightbox';
            if ($gi['popup_type'] === 'video') { $popup_url = $gi['video_url']; $popup_class .= ' royal-masonry-video-popup'; }
            elseif ($gi['popup_type'] === 'link' && !empty($gi['custom_link']['url'])) { $popup_url = $gi['custom_link']['url']; $popup_class = ''; }

            $items[] = [
                'title'      => $gi['title'],
                'image_html' => $img_html,
                'filters'    => $filters,
                'popup_url'  => $popup_url,
                'popup_class'=> $popup_class,
                'link_url'   => ($gi['popup_type'] === 'link' && !empty($gi['custom_link']['url'])) ? $gi['custom_link']['url'] : '',
                'zoom_icon'  => $gi['zoom_icon'] ?? ['value' => 'fas fa-search', 'library' => 'fa-solid'],
                'link_icon'  => $gi['link_icon'] ?? ['value' => 'fas fa-link', 'library' => 'fa-solid'],
                'categories' => implode(', ', $filters),
                'excerpt'    => '',
                'permalink'  => '',
            ];
        }
        return $items;
    }

    /* --- Build Post Items --- */
    private function build_post_items($settings, &$filter_names, $image_size) {
        $items = [];
        $post_type = $settings['post_type'] ?? 'post';
        $display_type = $settings['display_type'] ?? 'category';

        // Determine taxonomy
        $taxonomy = 'category';
        $terms = [];
        if ($post_type === 'post') {
            $taxonomy = 'category';
            $terms = $settings['post_categories'] ?? [];
        } elseif ($post_type === 'product' && class_exists('WooCommerce')) {
            $taxonomy = 'product_cat';
            $terms = $settings['product_categories'] ?? [];
        } else {
            $taxonomy = $settings['taxonomy_name'] ?? '';
        }

        $args = [
            'post_type'      => $post_type,
            'posts_per_page' => $settings['posts_per_page'] ?? -1,
            'orderby'        => $settings['orderby'] ?? 'date',
            'order'          => $settings['order'] ?? 'DESC',
            'post_status'    => 'publish',
        ];

        if ($display_type === 'category' && !empty($terms) && !empty($taxonomy)) {
            $args['tax_query'] = [['taxonomy' => $taxonomy, 'field' => 'term_id', 'terms' => $terms]];
        }

        $query = new \WP_Query($args);
        $hide_cat = $settings['hide_category_text'] === 'yes';
        $full_title = $settings['show_full_title'] === 'yes';

        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                $post_id = get_the_ID();

                // Get taxonomy terms for filtering
                $post_terms = [];
                $term_names = [];
                if (!empty($taxonomy)) {
                    $t = get_the_terms($post_id, $taxonomy);
                    if ($t && !is_wp_error($t)) {
                        foreach ($t as $term) {
                            $post_terms[] = $term->name;
                            $term_names[] = $term->name;
                        }
                    }
                }
                $filter_names = array_merge($filter_names, $post_terms);

                // Image
                $img_html = '';
                if (has_post_thumbnail($post_id)) {
                    $img_html = get_the_post_thumbnail($post_id, $image_size);
                } else {
                    $img_html = '<img src="' . esc_url(\Elementor\Utils::get_placeholder_image_src()) . '" alt="' . esc_attr(get_the_title()) . '" loading="lazy">';
                }

                // Title
                $title = get_the_title();
                if (!$full_title && strlen($title) > 25) { $title = substr($title, 0, 25) . '...'; }

                // Excerpt
                $excerpt = '';
                if ($settings['show_excerpt'] === 'yes') {
                    $excerpt = wp_strip_all_tags(get_the_content());
                    $excerpt = substr($excerpt, 0, $settings['excerpt_length'] ?? 120);
                }

                $thumb_url = get_the_post_thumbnail_url($post_id, 'full') ?: \Elementor\Utils::get_placeholder_image_src();

                $items[] = [
                    'title'      => $title,
                    'image_html' => $img_html,
                    'filters'    => $post_terms,
                    'popup_url'  => $thumb_url,
                    'popup_class'=> 'royal-masonry-lightbox',
                    'link_url'   => get_the_permalink($post_id),
                    'zoom_icon'  => $settings['zoom_icon'] ?? ['value' => 'fas fa-search', 'library' => 'fa-solid'],
                    'link_icon'  => $settings['link_icon'] ?? ['value' => 'fas fa-link', 'library' => 'fa-solid'],
                    'categories' => $hide_cat ? '' : implode(', ', $term_names),
                    'excerpt'    => $excerpt,
                    'permalink'  => get_the_permalink($post_id),
                ];
            }
            wp_reset_postdata();
        }
        return $items;
    }

    /* --- Render Overlay Item --- */
    private function render_overlay_item($item, $effect, $settings) {
        echo '<div class="royal-masonry-item-inner royal-masonry-' . esc_attr($effect) . '">';
        echo wp_kses_post( $item['image_html'] );

        if (!empty($item['categories'])) {
            echo '<span class="royal-masonry-cat">' . esc_html($item['categories']) . '</span>';
        }

        echo '<div class="royal-masonry-overlay">';
        echo '<h3 class="royal-masonry-overlay-title">' . esc_html($item['title']) . '</h3>';
        echo '<div class="royal-masonry-overlay-links">';

        if (!empty($item['link_url'])) {
            echo '<a href="' . esc_url($item['link_url']) . '" class="royal-masonry-overlay-link">';
            Icons_Manager::render_icon($item['link_icon'], ['aria-hidden' => 'true']);
            echo '</a>';
        }
        if (!empty($item['popup_url']) && !empty($item['popup_class'])) {
            echo '<a href="' . esc_url($item['popup_url']) . '" class="royal-masonry-overlay-link ' . esc_attr($item['popup_class']) . '">';
            Icons_Manager::render_icon($item['zoom_icon'], ['aria-hidden' => 'true']);
            echo '</a>';
        }

        echo '</div></div></div>';
    }

    /* --- Render Card Item --- */
    private function render_card_item($item, $settings) {
        echo '<div class="royal-masonry-card">';
        echo '<div class="royal-masonry-item-inner">' . $item['image_html'] . '</div>';
        echo '<div class="royal-masonry-card-body">';
        if (!empty($item['permalink'])) {
            echo '<h4 class="royal-masonry-card-title"><a href="' . esc_url($item['permalink']) . '">' . esc_html($item['title']) . '</a></h4>';
        } else {
            echo '<h4 class="royal-masonry-card-title">' . esc_html($item['title']) . '</h4>';
        }
        if (!empty($item['excerpt'])) {
            echo '<p class="royal-masonry-card-excerpt">' . esc_html($item['excerpt']) . '</p>';
        }
        if (!empty($item['categories'])) {
            echo '<div class="royal-masonry-card-meta"><span>' . esc_html($item['categories']) . '</span></div>';
        }
        echo '</div></div>';
    }
}
