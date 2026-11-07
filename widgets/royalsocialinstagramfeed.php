<?php
namespace RoyalAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;

if ( ! defined( 'ABSPATH' ) ) exit;

class RoyalSocialInstagramFeed extends Widget_Base {

    public function get_name() {
        return 'royalsocialinstagramfeed';
    }

    public function get_title() {
        return __( 'Instagram Feed', 'royal-addons-for-elementor' );
    }

    public function get_icon() { return 'eicon-instagram-gallery rtbranding'; }

    public function get_categories() {
        return [ 'royaltech' ];
    }

    public function get_keywords() {
        return [ 'instagram', 'feed', 'social', 'photos', 'gallery', 'insta', 'tech', 'technologies', 'royal', 'mehdi', 'akram' ];
    }

    protected function register_controls() {

        // ═══════════════════════════════════════════════════════════════════
        //  CONTENT TAB
        // ═══════════════════════════════════════════════════════════════════

        // ─── Instagram Settings ──────────────────────────────────────────
        $this->start_controls_section( 'section_instagram_content', [
            'label' => __( 'Instagram Settings', 'royal-addons-for-elementor' ),
        ]);

        $is_connected = get_option('royaladdons_instagram_connected') === 'yes';

        if ( ! $is_connected ) {
            $this->add_control( 'not_connected_notice', [
                'type' => Controls_Manager::RAW_HTML,
                'raw'  => sprintf(
                    __( 'Instagram is not connected. Please connect your account from %sRoyal Addons -> Social%s settings.', 'royal-addons-for-elementor' ),
                    '<a href="' . admin_url('admin.php?page=royaladdons-social') . '" target="_blank" style="font-weight:bold; color:#e1306c;">', '</a>'
                ),
                'content_classes' => 'elementor-panel-alert elementor-panel-alert-danger',
            ]);
        } else {
            $this->add_control( 'connected_notice', [
                'type' => Controls_Manager::RAW_HTML,
                'raw'  => __( 'Instagram account is connected successfully.', 'royal-addons-for-elementor' ),
                'content_classes' => 'elementor-panel-alert elementor-panel-alert-success',
            ]);
        }

        $this->add_control( 'posts_count', [
            'label'   => __( 'Number of Posts', 'royal-addons-for-elementor' ),
            'type'    => Controls_Manager::NUMBER,
            'min'     => 1,
            'max'     => 50,
            'default' => 9,
        ]);

        $this->add_control( 'link_target', [
            'label'   => __( 'Link Target', 'royal-addons-for-elementor' ),
            'type'    => Controls_Manager::SELECT,
            'default' => '_blank',
            'options' => [
                '_self'  => __( 'Same Tab', 'royal-addons-for-elementor' ),
                '_blank' => __( 'New Tab', 'royal-addons-for-elementor' ),
            ],
        ]);

        $this->add_control( 'cache_duration', [
            'label'   => __( 'Cache Duration', 'royal-addons-for-elementor' ),
            'type'    => Controls_Manager::SELECT,
            'default' => '3600',
            'options' => [
                '0'     => __( 'No Cache', 'royal-addons-for-elementor' ),
                '900'   => __( '15 Minutes', 'royal-addons-for-elementor' ),
                '1800'  => __( '30 Minutes', 'royal-addons-for-elementor' ),
                '3600'  => __( '1 Hour', 'royal-addons-for-elementor' ),
                '21600' => __( '6 Hours', 'royal-addons-for-elementor' ),
                '86400' => __( '24 Hours', 'royal-addons-for-elementor' ),
            ],
        ]);

        $this->end_controls_section();

        // ─── Header ──────────────────────────────────────────────────────
        $this->start_controls_section( 'section_header', [
            'label' => __( 'Header', 'royal-addons-for-elementor' ),
        ]);

        $this->add_control( 'show_header', [
            'label'        => __( 'Show Header', 'royal-addons-for-elementor' ),
            'type'         => Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default'      => 'yes',
        ]);

        $this->add_control( 'header_profile_image', [
            'label'     => __( 'Profile Picture', 'royal-addons-for-elementor' ),
            'type'      => Controls_Manager::MEDIA,
            'default'   => [],
            'condition' => [ 'show_header' => 'yes' ],
        ]);

        $this->add_control( 'header_username', [
            'label'       => __( 'Username', 'royal-addons-for-elementor' ),
            'type'        => Controls_Manager::TEXT,
            'default'     => __( '@myinstagram', 'royal-addons-for-elementor' ),
            'label_block' => true,
            'condition'   => [ 'show_header' => 'yes' ],
        ]);

        $this->add_control( 'header_full_name', [
            'label'       => __( 'Full Name', 'royal-addons-for-elementor' ),
            'type'        => Controls_Manager::TEXT,
            'default'     => '',
            'label_block' => true,
            'condition'   => [ 'show_header' => 'yes' ],
        ]);

        $this->add_control( 'header_bio', [
            'label'     => __( 'Bio', 'royal-addons-for-elementor' ),
            'type'      => Controls_Manager::TEXTAREA,
            'default'   => '',
            'rows'      => 2,
            'condition' => [ 'show_header' => 'yes' ],
        ]);

        $this->add_control( 'header_posts_count', [
            'label'       => __( 'Posts Count Text', 'royal-addons-for-elementor' ),
            'type'        => Controls_Manager::TEXT,
            'default'     => '',
            'placeholder' => __( 'e.g. 250 posts', 'royal-addons-for-elementor' ),
            'condition'   => [ 'show_header' => 'yes' ],
        ]);

        $this->add_control( 'header_followers_count', [
            'label'       => __( 'Followers Count Text', 'royal-addons-for-elementor' ),
            'type'        => Controls_Manager::TEXT,
            'default'     => '',
            'placeholder' => __( 'e.g. 12.5K followers', 'royal-addons-for-elementor' ),
            'condition'   => [ 'show_header' => 'yes' ],
        ]);

        $this->add_control( 'header_following_count', [
            'label'       => __( 'Following Count Text', 'royal-addons-for-elementor' ),
            'type'        => Controls_Manager::TEXT,
            'default'     => '',
            'placeholder' => __( 'e.g. 500 following', 'royal-addons-for-elementor' ),
            'condition'   => [ 'show_header' => 'yes' ],
        ]);

        $this->add_control( 'header_verified', [
            'label'     => __( 'Verified Badge', 'royal-addons-for-elementor' ),
            'type'      => Controls_Manager::SWITCHER,
            'default'   => '',
            'condition' => [ 'show_header' => 'yes' ],
        ]);

        $this->end_controls_section();

        // ─── Follow Button ───────────────────────────────────────────────
        $this->start_controls_section( 'section_follow_button', [
            'label' => __( 'Follow Button', 'royal-addons-for-elementor' ),
        ]);

        $this->add_control( 'show_follow_btn', [
            'label'        => __( 'Show Follow Button', 'royal-addons-for-elementor' ),
            'type'         => Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default'      => 'yes',
        ]);

        $this->add_control( 'follow_btn_text', [
            'label'     => __( 'Button Text', 'royal-addons-for-elementor' ),
            'type'      => Controls_Manager::TEXT,
            'default'   => __( 'Follow', 'royal-addons-for-elementor' ),
            'condition' => [ 'show_follow_btn' => 'yes' ],
        ]);

        $this->add_control( 'follow_btn_url', [
            'label'       => __( 'Profile URL', 'royal-addons-for-elementor' ),
            'type'        => Controls_Manager::URL,
            'placeholder' => __( 'https://instagram.com/username', 'royal-addons-for-elementor' ),
            'default'     => [ 'url' => '', 'is_external' => true, 'nofollow' => true ],
            'condition'   => [ 'show_follow_btn' => 'yes' ],
        ]);

        $this->add_control( 'follow_btn_position', [
            'label'   => __( 'Position', 'royal-addons-for-elementor' ),
            'type'    => Controls_Manager::SELECT,
            'default' => 'header',
            'options' => [
                'header' => __( 'In Header', 'royal-addons-for-elementor' ),
                'bottom' => __( 'Below Feed', 'royal-addons-for-elementor' ),
            ],
            'condition' => [ 'show_follow_btn' => 'yes' ],
        ]);

        $this->end_controls_section();

        // ─── Layout ──────────────────────────────────────────────────────
        $this->start_controls_section( 'section_layout', [
            'label' => __( 'Layout', 'royal-addons-for-elementor' ),
        ]);

        $this->add_control( 'layout_type', [
            'label'   => __( 'Layout', 'royal-addons-for-elementor' ),
            'type'    => Controls_Manager::SELECT,
            'default' => 'grid',
            'options' => [
                'grid' => __( 'Grid', 'royal-addons-for-elementor' ),
                'list' => __( 'List', 'royal-addons-for-elementor' ),
            ],
        ]);

        $this->add_responsive_control( 'posts_per_row', [
            'label'          => __( 'Posts Per Row', 'royal-addons-for-elementor' ),
            'type'           => Controls_Manager::NUMBER,
            'min'            => 1,
            'max'            => 6,
            'step'           => 1,
            'default'        => 3,
            'tablet_default' => 2,
            'mobile_default' => 1,
            'selectors'      => [
                '{{WRAPPER}} .royal-ig-feed-grid' => 'grid-template-columns: repeat({{VALUE}}, 1fr);',
            ],
            'condition' => [ 'layout_type' => 'grid' ],
        ]);

        $this->add_responsive_control( 'grid_gap', [
            'label'      => __( 'Gap', 'royal-addons-for-elementor' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => [ 'px' ],
            'range'      => [ 'px' => [ 'min' => 0, 'max' => 100, 'step' => 1 ] ],
            'default'    => [ 'unit' => 'px', 'size' => 6 ],
            'selectors'  => [
                '{{WRAPPER}} .royal-ig-feed-grid' => 'gap: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .royal-ig-feed-list .royal-ig-feed-card:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->end_controls_section();

        // ─── Post Elements ───────────────────────────────────────────────
        $this->start_controls_section( 'section_post_elements', [
            'label' => __( 'Post Elements', 'royal-addons-for-elementor' ),
        ]);

        $this->add_control( 'show_caption', [
            'label'        => __( 'Show Caption', 'royal-addons-for-elementor' ),
            'type'         => Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default'      => '',
        ]);

        $this->add_control( 'caption_length', [
            'label'     => __( 'Caption Length (Words)', 'royal-addons-for-elementor' ),
            'type'      => Controls_Manager::NUMBER,
            'min'       => 5,
            'max'       => 200,
            'default'   => 15,
            'condition' => [ 'show_caption' => 'yes' ],
        ]);

        $this->add_control( 'show_overlay', [
            'label'        => __( 'Show Hover Overlay', 'royal-addons-for-elementor' ),
            'type'         => Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default'      => 'yes',
        ]);

        $this->add_control( 'show_media_type_icon', [
            'label'        => __( 'Show Media Type Icon', 'royal-addons-for-elementor' ),
            'type'         => Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default'      => 'yes',
            'description'  => __( 'Show video/carousel icon badge on posts.', 'royal-addons-for-elementor' ),
        ]);

        $this->end_controls_section();

        // ─── Load More ───────────────────────────────────────────────────
        $this->start_controls_section( 'section_load_more', [
            'label' => __( 'Load More', 'royal-addons-for-elementor' ),
        ]);

        $this->add_control( 'show_load_more', [
            'label'        => __( 'Show Load More Button', 'royal-addons-for-elementor' ),
            'type'         => Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default'      => '',
        ]);

        $this->add_control( 'load_more_text', [
            'label'     => __( 'Button Text', 'royal-addons-for-elementor' ),
            'type'      => Controls_Manager::TEXT,
            'default'   => __( 'Load More', 'royal-addons-for-elementor' ),
            'condition' => [ 'show_load_more' => 'yes' ],
        ]);

        $this->end_controls_section();

        // ═══════════════════════════════════════════════════════════════════
        //  STYLE TAB
        // ═══════════════════════════════════════════════════════════════════

        // ─── Style: Container ────────────────────────────────────────────
        $this->start_controls_section( 'section_container_style', [
            'label' => __( 'Container', 'royal-addons-for-elementor' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control( 'container_bg_color', [
            'label'     => __( 'Background Color', 'royal-addons-for-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [ '{{WRAPPER}} .royal-ig-feed-wrapper' => 'background-color: {{VALUE}};' ],
        ]);

        $this->add_responsive_control( 'container_padding', [
            'label'      => __( 'Padding', 'royal-addons-for-elementor' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', '%', 'em' ],
            'selectors'  => [ '{{WRAPPER}} .royal-ig-feed-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
        ]);

        $this->add_group_control( Group_Control_Border::get_type(), [
            'name'     => 'container_border',
            'selector' => '{{WRAPPER}} .royal-ig-feed-wrapper',
        ]);

        $this->add_control( 'container_border_radius', [
            'label'      => __( 'Border Radius', 'royal-addons-for-elementor' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', '%' ],
            'selectors'  => [ '{{WRAPPER}} .royal-ig-feed-wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
        ]);

        $this->add_group_control( Group_Control_Box_Shadow::get_type(), [
            'name'     => 'container_box_shadow',
            'selector' => '{{WRAPPER}} .royal-ig-feed-wrapper',
        ]);

        $this->end_controls_section();

        // ─── Style: Header ───────────────────────────────────────────────
        $this->start_controls_section( 'section_header_style', [
            'label'     => __( 'Header', 'royal-addons-for-elementor' ),
            'tab'       => Controls_Manager::TAB_STYLE,
            'condition' => [ 'show_header' => 'yes' ],
        ]);

        $this->add_control( 'header_bg_color', [
            'label'     => __( 'Background Color', 'royal-addons-for-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#fafafa',
            'selectors' => [ '{{WRAPPER}} .royal-ig-feed-header' => 'background-color: {{VALUE}};' ],
        ]);

        $this->add_responsive_control( 'header_padding', [
            'label'      => __( 'Padding', 'royal-addons-for-elementor' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', '%', 'em' ],
            'default'    => [ 'top' => '15', 'right' => '15', 'bottom' => '15', 'left' => '15', 'unit' => 'px', 'isLinked' => true ],
            'selectors'  => [ '{{WRAPPER}} .royal-ig-feed-header' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
        ]);

        $this->add_group_control( Group_Control_Border::get_type(), [
            'name'     => 'header_border',
            'selector' => '{{WRAPPER}} .royal-ig-feed-header',
        ]);

        $this->add_control( 'header_border_radius', [
            'label'      => __( 'Border Radius', 'royal-addons-for-elementor' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', '%' ],
            'selectors'  => [ '{{WRAPPER}} .royal-ig-feed-header' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
        ]);

        $this->add_responsive_control( 'header_avatar_size', [
            'label'      => __( 'Avatar Size', 'royal-addons-for-elementor' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => [ 'px' ],
            'range'      => [ 'px' => [ 'min' => 30, 'max' => 150 ] ],
            'default'    => [ 'unit' => 'px', 'size' => 60 ],
            'selectors'  => [
                '{{WRAPPER}} .royal-ig-feed-header-avatar img' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
            ],
            'separator' => 'before',
        ]);

        $this->add_control( 'header_username_color', [
            'label'     => __( 'Username Color', 'royal-addons-for-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#262626',
            'selectors' => [ '{{WRAPPER}} .royal-ig-feed-header-username' => 'color: {{VALUE}};' ],
            'separator' => 'before',
        ]);

        $this->add_group_control( Group_Control_Typography::get_type(), [
            'name'     => 'header_username_typography',
            'selector' => '{{WRAPPER}} .royal-ig-feed-header-username',
        ]);

        $this->add_control( 'header_fullname_color', [
            'label'     => __( 'Full Name Color', 'royal-addons-for-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#262626',
            'selectors' => [ '{{WRAPPER}} .royal-ig-feed-header-fullname' => 'color: {{VALUE}};' ],
            'separator' => 'before',
        ]);

        $this->add_group_control( Group_Control_Typography::get_type(), [
            'name'     => 'header_fullname_typography',
            'selector' => '{{WRAPPER}} .royal-ig-feed-header-fullname',
        ]);

        $this->add_control( 'header_bio_color', [
            'label'     => __( 'Bio Color', 'royal-addons-for-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#8e8e8e',
            'selectors' => [ '{{WRAPPER}} .royal-ig-feed-header-bio' => 'color: {{VALUE}};' ],
            'separator' => 'before',
        ]);

        $this->add_group_control( Group_Control_Typography::get_type(), [
            'name'     => 'header_bio_typography',
            'selector' => '{{WRAPPER}} .royal-ig-feed-header-bio',
        ]);

        $this->add_control( 'header_stats_color', [
            'label'     => __( 'Stats Color', 'royal-addons-for-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#262626',
            'selectors' => [ '{{WRAPPER}} .royal-ig-feed-header-stats span' => 'color: {{VALUE}};' ],
            'separator' => 'before',
        ]);

        $this->add_group_control( Group_Control_Typography::get_type(), [
            'name'     => 'header_stats_typography',
            'selector' => '{{WRAPPER}} .royal-ig-feed-header-stats span',
        ]);

        $this->end_controls_section();

        // ─── Style: Follow Button ────────────────────────────────────────
        $this->start_controls_section( 'section_follow_btn_style', [
            'label'     => __( 'Follow Button', 'royal-addons-for-elementor' ),
            'tab'       => Controls_Manager::TAB_STYLE,
            'condition' => [ 'show_follow_btn' => 'yes' ],
        ]);

        $this->add_group_control( Group_Control_Typography::get_type(), [
            'name'     => 'follow_btn_typography',
            'selector' => '{{WRAPPER}} .royal-ig-feed-follow-btn',
        ]);

        $this->start_controls_tabs( 'follow_btn_tabs' );

        $this->start_controls_tab( 'follow_btn_normal', [ 'label' => __( 'Normal', 'royal-addons-for-elementor' ) ] );
        $this->add_control( 'follow_btn_color', [
            'label' => __( 'Text Color', 'royal-addons-for-elementor' ), 'type' => Controls_Manager::COLOR,
            'default' => '#ffffff', 'selectors' => [ '{{WRAPPER}} .royal-ig-feed-follow-btn' => 'color: {{VALUE}};' ],
        ]);
        $this->add_control( 'follow_btn_bg', [
            'label' => __( 'Background', 'royal-addons-for-elementor' ), 'type' => Controls_Manager::COLOR,
            'default' => '#0095f6', 'selectors' => [ '{{WRAPPER}} .royal-ig-feed-follow-btn' => 'background-color: {{VALUE}};' ],
        ]);
        $this->end_controls_tab();

        $this->start_controls_tab( 'follow_btn_hover_tab', [ 'label' => __( 'Hover', 'royal-addons-for-elementor' ) ] );
        $this->add_control( 'follow_btn_hover_color', [
            'label' => __( 'Text Color', 'royal-addons-for-elementor' ), 'type' => Controls_Manager::COLOR,
            'selectors' => [ '{{WRAPPER}} .royal-ig-feed-follow-btn:hover' => 'color: {{VALUE}};' ],
        ]);
        $this->add_control( 'follow_btn_hover_bg', [
            'label' => __( 'Background', 'royal-addons-for-elementor' ), 'type' => Controls_Manager::COLOR,
            'selectors' => [ '{{WRAPPER}} .royal-ig-feed-follow-btn:hover' => 'background-color: {{VALUE}};' ],
        ]);
        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control( 'follow_btn_padding', [
            'label'      => __( 'Padding', 'royal-addons-for-elementor' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', 'em' ],
            'default'    => [ 'top' => '7', 'right' => '20', 'bottom' => '7', 'left' => '20', 'unit' => 'px', 'isLinked' => false ],
            'selectors'  => [ '{{WRAPPER}} .royal-ig-feed-follow-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
            'separator'  => 'before',
        ]);

        $this->add_control( 'follow_btn_border_radius', [
            'label'      => __( 'Border Radius', 'royal-addons-for-elementor' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', '%' ],
            'default'    => [ 'top' => '8', 'right' => '8', 'bottom' => '8', 'left' => '8', 'unit' => 'px', 'isLinked' => true ],
            'selectors'  => [ '{{WRAPPER}} .royal-ig-feed-follow-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
        ]);

        $this->end_controls_section();

        // ─── Style: Card ─────────────────────────────────────────────────
        $this->start_controls_section( 'section_card_style', [
            'label' => __( 'Post Card', 'royal-addons-for-elementor' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control( 'card_bg_color', [
            'label'     => __( 'Background', 'royal-addons-for-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#ffffff',
            'selectors' => [ '{{WRAPPER}} .royal-ig-feed-card' => 'background-color: {{VALUE}};' ],
        ]);

        $this->add_responsive_control( 'card_padding', [
            'label'      => __( 'Padding', 'royal-addons-for-elementor' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', '%', 'em' ],
            'selectors'  => [ '{{WRAPPER}} .royal-ig-feed-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
        ]);

        $this->add_group_control( Group_Control_Border::get_type(), [
            'name'     => 'card_border',
            'selector' => '{{WRAPPER}} .royal-ig-feed-card',
        ]);

        $this->add_control( 'card_border_radius', [
            'label'      => __( 'Border Radius', 'royal-addons-for-elementor' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', '%' ],
            'selectors'  => [ '{{WRAPPER}} .royal-ig-feed-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
        ]);

        $this->add_group_control( Group_Control_Box_Shadow::get_type(), [
            'name'     => 'card_box_shadow',
            'selector' => '{{WRAPPER}} .royal-ig-feed-card',
        ]);

        $this->end_controls_section();

        // ─── Style: Image ────────────────────────────────────────────────
        $this->start_controls_section( 'section_image_style', [
            'label' => __( 'Image', 'royal-addons-for-elementor' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_responsive_control( 'image_height', [
            'label'      => __( 'Height', 'royal-addons-for-elementor' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => [ 'px' ],
            'range'      => [ 'px' => [ 'min' => 100, 'max' => 600 ] ],
            'default'    => [ 'unit' => 'px', 'size' => 280 ],
            'selectors'  => [ '{{WRAPPER}} .royal-ig-feed-card-image img' => 'height: {{SIZE}}{{UNIT}};' ],
        ]);

        $this->add_control( 'image_border_radius', [
            'label'      => __( 'Border Radius', 'royal-addons-for-elementor' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', '%' ],
            'selectors'  => [ '{{WRAPPER}} .royal-ig-feed-card-image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
        ]);

        $this->end_controls_section();

        // ─── Style: Hover Overlay ────────────────────────────────────────
        $this->start_controls_section( 'section_overlay_style', [
            'label'     => __( 'Hover Overlay', 'royal-addons-for-elementor' ),
            'tab'       => Controls_Manager::TAB_STYLE,
            'condition' => [ 'show_overlay' => 'yes' ],
        ]);

        $this->add_control( 'overlay_bg_color', [
            'label'     => __( 'Background Color', 'royal-addons-for-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => 'rgba(0,0,0,0.5)',
            'selectors' => [ '{{WRAPPER}} .royal-ig-feed-card-overlay' => 'background-color: {{VALUE}};' ],
        ]);

        $this->add_control( 'overlay_icon_color', [
            'label'     => __( 'Icon Color', 'royal-addons-for-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#ffffff',
            'selectors' => [ '{{WRAPPER}} .royal-ig-feed-card-overlay svg' => 'fill: {{VALUE}};' ],
        ]);

        $this->add_responsive_control( 'overlay_icon_size', [
            'label'      => __( 'Icon Size', 'royal-addons-for-elementor' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => [ 'px' ],
            'range'      => [ 'px' => [ 'min' => 16, 'max' => 80 ] ],
            'default'    => [ 'unit' => 'px', 'size' => 28 ],
            'selectors'  => [ '{{WRAPPER}} .royal-ig-feed-card-overlay svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};' ],
        ]);

        $this->end_controls_section();

        // ─── Style: Caption ──────────────────────────────────────────────
        $this->start_controls_section( 'section_caption_style', [
            'label'     => __( 'Caption', 'royal-addons-for-elementor' ),
            'tab'       => Controls_Manager::TAB_STYLE,
            'condition' => [ 'show_caption' => 'yes' ],
        ]);

        $this->add_control( 'caption_color', [
            'label'     => __( 'Color', 'royal-addons-for-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [ '{{WRAPPER}} .royal-ig-feed-card-caption' => 'color: {{VALUE}};' ],
        ]);

        $this->add_group_control( Group_Control_Typography::get_type(), [
            'name'     => 'caption_typography',
            'selector' => '{{WRAPPER}} .royal-ig-feed-card-caption',
        ]);

        $this->add_responsive_control( 'caption_padding', [
            'label'      => __( 'Padding', 'royal-addons-for-elementor' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', 'em', '%' ],
            'selectors'  => [ '{{WRAPPER}} .royal-ig-feed-card-caption' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
        ]);

        $this->add_responsive_control( 'caption_margin', [
            'label'      => __( 'Margin', 'royal-addons-for-elementor' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', 'em', '%' ],
            'selectors'  => [ '{{WRAPPER}} .royal-ig-feed-card-caption' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
        ]);

        $this->end_controls_section();

        // ─── Style: Load More ────────────────────────────────────────────
        $this->start_controls_section( 'section_load_more_style', [
            'label'     => __( 'Load More Button', 'royal-addons-for-elementor' ),
            'tab'       => Controls_Manager::TAB_STYLE,
            'condition' => [ 'show_load_more' => 'yes' ],
        ]);

        $this->add_group_control( Group_Control_Typography::get_type(), [
            'name'     => 'load_more_typography',
            'selector' => '{{WRAPPER}} .royal-ig-feed-load-more',
        ]);

        $this->start_controls_tabs( 'load_more_tabs' );
        $this->start_controls_tab( 'load_more_normal_tab', [ 'label' => __( 'Normal', 'royal-addons-for-elementor' ) ] );
        $this->add_control( 'load_more_color', [ 'label' => __( 'Text Color', 'royal-addons-for-elementor' ), 'type' => Controls_Manager::COLOR, 'default' => '#ffffff', 'selectors' => [ '{{WRAPPER}} .royal-ig-feed-load-more' => 'color: {{VALUE}};' ] ] );
        $this->add_control( 'load_more_bg', [ 'label' => __( 'Background', 'royal-addons-for-elementor' ), 'type' => Controls_Manager::COLOR, 'default' => '#0095f6', 'selectors' => [ '{{WRAPPER}} .royal-ig-feed-load-more' => 'background-color: {{VALUE}};' ] ] );
        $this->end_controls_tab();
        $this->start_controls_tab( 'load_more_hover_tab', [ 'label' => __( 'Hover', 'royal-addons-for-elementor' ) ] );
        $this->add_control( 'load_more_hover_color', [ 'label' => __( 'Text Color', 'royal-addons-for-elementor' ), 'type' => Controls_Manager::COLOR, 'selectors' => [ '{{WRAPPER}} .royal-ig-feed-load-more:hover' => 'color: {{VALUE}};' ] ] );
        $this->add_control( 'load_more_hover_bg', [ 'label' => __( 'Background', 'royal-addons-for-elementor' ), 'type' => Controls_Manager::COLOR, 'selectors' => [ '{{WRAPPER}} .royal-ig-feed-load-more:hover' => 'background-color: {{VALUE}};' ] ] );
        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_responsive_control( 'load_more_padding', [
            'label'      => __( 'Padding', 'royal-addons-for-elementor' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', 'em' ],
            'default'    => [ 'top' => '10', 'right' => '30', 'bottom' => '10', 'left' => '30', 'unit' => 'px', 'isLinked' => false ],
            'selectors'  => [ '{{WRAPPER}} .royal-ig-feed-load-more' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
            'separator'  => 'before',
        ]);

        $this->add_control( 'load_more_border_radius', [
            'label'      => __( 'Border Radius', 'royal-addons-for-elementor' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', '%' ],
            'default'    => [ 'top' => '8', 'right' => '8', 'bottom' => '8', 'left' => '8', 'unit' => 'px', 'isLinked' => true ],
            'selectors'  => [ '{{WRAPPER}} .royal-ig-feed-load-more' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
        ]);

        $this->add_responsive_control( 'load_more_margin', [
            'label'      => __( 'Margin', 'royal-addons-for-elementor' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', 'em', '%' ],
            'default'    => [ 'top' => '20', 'right' => '0', 'bottom' => '0', 'left' => '0', 'unit' => 'px', 'isLinked' => false ],
            'selectors'  => [ '{{WRAPPER}} .royal-ig-feed-load-more-wrap' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
        ]);

        $this->end_controls_section();
    }

    // =====================================================================
    //  RENDER
    // =====================================================================
    protected function render() {
        $settings = $this->get_settings_for_display();

        $is_connected = get_option('royaladdons_instagram_connected') === 'yes';
        $license_key  = get_option('royaladdons_license_key', '');

        if ( ! $is_connected || empty($license_key) ) {
            if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
                echo '<div class="elementor-alert elementor-alert-warning">' . esc_html__( 'Please connect your Instagram account from Royal Addons -> Social settings.', 'royal-addons-for-elementor' ) . '</div>';
            }
            return;
        }

        // ── Fetch posts from RoyalAuth API ───────────────────────────────
        $transient_key = 'royal_ig_feed_proxy_' . md5( $license_key . $posts_count );
        $posts = get_transient( $transient_key );

        if ( false === $posts ) {
            $api_url = "https://auth.royaltechbd.com/api/social/feed";
            $api_url = add_query_arg( [
                'platform' => 'instagram',
                'limit'    => $posts_count,
            ], $api_url );

            $response = wp_remote_get( $api_url, [
                'headers' => [
                    'X-License-Key' => $license_key
                ],
                'timeout' => 15
            ]);

            if ( is_wp_error( $response ) ) {
                if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
                    echo '<div class="elementor-alert elementor-alert-danger">' . esc_html__( 'Unable to connect to RoyalAuth API.', 'royal-addons-for-elementor' ) . '</div>';
                }
                return;
            }

            $body = json_decode( wp_remote_retrieve_body( $response ), true );

            if ( isset( $body['success'] ) && $body['success'] === false ) {
                if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
                    $error_msg = isset($body['error']) ? $body['error'] : 'Unknown Error';
                    echo '<div class="elementor-alert elementor-alert-danger">' . esc_html( 'API Error: ' . $error_msg ) . '</div>';
                }
                return;
            }

            if ( empty( $body['data'] ) ) {
                if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
                    echo '<div class="elementor-alert elementor-alert-info">' . esc_html__( 'No posts found.', 'royal-addons-for-elementor' ) . '</div>';
                }
                return;
            }

            $posts = [];
            foreach ( $body['data'] as $item ) {
                $posts[] = [
                    'id'            => isset( $item['id'] ) ? $item['id'] : '',
                    'caption'       => isset( $item['caption'] ) ? $item['caption'] : '',
                    'media_type'    => isset( $item['media_type'] ) ? $item['media_type'] : '',
                    'media_url'     => isset( $item['media_url'] ) ? $item['media_url'] : '',
                    'thumbnail_url' => isset( $item['thumbnail_url'] ) ? $item['thumbnail_url'] : '',
                    'permalink'     => isset( $item['permalink'] ) ? $item['permalink'] : '',
                    'timestamp'     => isset( $item['timestamp'] ) ? $item['timestamp'] : '',
                ];
            }

            if ( $cache_time > 0 ) {
                set_transient( $transient_key, $posts, $cache_time );
            }
        }

        if ( empty( $posts ) ) return;

        // ── Inline CSS ──────────────────────────────────────────────────
        ?>
        <style>
            .royal-ig-feed-card-image { position: relative; overflow: hidden; }
            .royal-ig-feed-card-overlay {
                position: absolute; top: 0; left: 0; right: 0; bottom: 0;
                display: flex; justify-content: center; align-items: center; gap: 12px;
                opacity: 0; transition: opacity 0.3s ease;
            }
            .royal-ig-feed-card-image:hover .royal-ig-feed-card-overlay { opacity: 1; }
            .royal-ig-feed-card-image img { transition: transform 0.35s ease; }
            .royal-ig-feed-card-image:hover img { transform: scale(1.05); }
            .royal-ig-feed-card-badge {
                position: absolute; top: 8px; right: 8px; z-index: 2;
                background: rgba(0,0,0,0.6); border-radius: 4px; padding: 4px 6px;
                display: flex; align-items: center;
            }
            .royal-ig-feed-card-badge svg { width: 16px; height: 16px; fill: #ffffff; }
        </style>
        <?php

        // ── Follow button HTML ──────────────────────────────────────────
        $follow_btn_html = '';
        if ( 'yes' === $settings['show_follow_btn'] ) {
            $btn_url = ! empty( $settings['follow_btn_url']['url'] ) ? esc_url( $settings['follow_btn_url']['url'] ) : '#';
            $btn_ext = ! empty( $settings['follow_btn_url']['is_external'] ) ? ' target="_blank"' : '';
            $btn_nf  = ! empty( $settings['follow_btn_url']['nofollow'] ) ? ' rel="nofollow noopener"' : '';
            $follow_btn_html = '<a href="' . $btn_url . '"' . $btn_ext . $btn_nf . ' class="royal-ig-feed-follow-btn" style="display:inline-block; text-decoration:none; font-weight:600; transition: all 0.3s ease;">'
                . esc_html( $settings['follow_btn_text'] )
                . '</a>';
        }

        // ── Wrapper ─────────────────────────────────────────────────────
        echo '<div class="royal-ig-feed-wrapper">';

        // ── Header ──────────────────────────────────────────────────────
        if ( 'yes' === $settings['show_header'] ) {
            $avatar_url   = ! empty( $settings['header_profile_image']['url'] ) ? esc_url( $settings['header_profile_image']['url'] ) : '';
            $username     = esc_html( $settings['header_username'] );
            $full_name    = esc_html( $settings['header_full_name'] );
            $bio          = esc_html( $settings['header_bio'] );
            $h_posts      = esc_html( $settings['header_posts_count'] );
            $h_followers  = esc_html( $settings['header_followers_count'] );
            $h_following  = esc_html( $settings['header_following_count'] );

            echo '<div class="royal-ig-feed-header" style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px;">';
            echo '<div style="display:flex; align-items:center; gap:14px; flex:1; min-width:0;">';

            if ( $avatar_url ) {
                echo '<div class="royal-ig-feed-header-avatar" style="flex-shrink:0;">';
                echo '<img src="' . $avatar_url . '" alt="' . $username . '" style="border-radius:50%; object-fit:cover; border:3px solid #e4405f;" />';
                echo '</div>';
            }

            echo '<div style="min-width:0;">';

            // Username + verified
            echo '<div class="royal-ig-feed-header-username" style="font-weight:700; display:flex; align-items:center; gap:5px;">';
            echo $username;
            if ( 'yes' === $settings['header_verified'] ) {
                echo '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" style="width:16px;height:16px;fill:#0095f6;flex-shrink:0;"><path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM369 209L241 337c-9.4 9.4-24.6 9.4-33.9 0l-64-64c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l47 47L335 175c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9z"/></svg>';
            }
            echo '</div>';

            if ( $full_name ) {
                echo '<div class="royal-ig-feed-header-fullname" style="font-weight:600; margin-top:2px;">' . $full_name . '</div>';
            }

            if ( $bio ) {
                echo '<div class="royal-ig-feed-header-bio" style="margin-top:4px;">' . $bio . '</div>';
            }

            // Stats row
            if ( $h_posts || $h_followers || $h_following ) {
                echo '<div class="royal-ig-feed-header-stats" style="display:flex; gap:16px; margin-top:6px; font-size:14px;">';
                if ( $h_posts ) echo '<span>' . $h_posts . '</span>';
                if ( $h_followers ) echo '<span>' . $h_followers . '</span>';
                if ( $h_following ) echo '<span>' . $h_following . '</span>';
                echo '</div>';
            }

            echo '</div>'; // text
            echo '</div>'; // left

            if ( 'yes' === $settings['show_follow_btn'] && $settings['follow_btn_position'] === 'header' ) {
                echo $follow_btn_html;
            }

            echo '</div>'; // header
        }

        // ── Feed ────────────────────────────────────────────────────────
        $grid_class = $layout === 'grid' ? 'royal-ig-feed-grid' : 'royal-ig-feed-list';
        $grid_style = $layout === 'grid' ? 'display:grid;' : '';
        echo '<div class="' . $grid_class . '" style="' . $grid_style . '">';

        foreach ( $posts as $post ) {
            $media_type    = $post['media_type'];
            $media_url     = esc_url( $post['media_url'] );
            $thumbnail_url = ! empty( $post['thumbnail_url'] ) ? esc_url( $post['thumbnail_url'] ) : $media_url;
            $permalink     = esc_url( $post['permalink'] );
            $caption       = esc_html( $post['caption'] );
            $display_image = ( $media_type === 'VIDEO' ) ? $thumbnail_url : $media_url;

            echo '<div class="royal-ig-feed-card" style="overflow:hidden;">';

            // Image
            echo '<div class="royal-ig-feed-card-image">';
            echo '<a href="' . $permalink . '" target="' . esc_attr( $link_target ) . '" rel="nofollow noopener" style="display:block; position:relative;">';
            echo '<img src="' . $display_image . '" alt="' . esc_attr( wp_trim_words( $post['caption'], 10, '' ) ) . '" loading="lazy" style="width:100%; display:block; object-fit:cover;" />';

            // Media type badge (top-right)
            if ( 'yes' === $settings['show_media_type_icon'] ) {
                if ( $media_type === 'VIDEO' ) {
                    echo '<span class="royal-ig-feed-card-badge"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path d="M73 39c-14.8-9.1-33.4-9.4-48.5-.9S0 62.6 0 80V432c0 17.4 9.4 33.4 24.5 41.9s33.7 8.1 48.5-.9L361 297c14.3-8.8 23-24.2 23-41s-8.7-32.2-23-41L73 39z"/></svg></span>';
                } elseif ( $media_type === 'CAROUSEL_ALBUM' ) {
                    echo '<span class="royal-ig-feed-card-badge"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M0 96C0 60.7 28.7 32 64 32H448c35.3 0 64 28.7 64 64V416c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V96zM323.8 202.5c-4.5-6.6-11.9-10.5-19.8-10.5s-15.4 3.9-19.8 10.5l-87 127.6L170.7 297c-4.6-5.7-11.5-9-18.7-9s-14.2 3.3-18.7 9l-64 80c-5.8 7.2-6.9 17.1-2.9 25.4s12.4 13.6 21.6 13.6h96 32H424c8.9 0 17.1-4.9 21.2-12.8s3.6-17.4-1.4-24.7l-120-176zM112 192a48 48 0 1 0 0-96 48 48 0 1 0 0 96z"/></svg></span>';
                }
            }

            // Hover overlay
            if ( 'yes' === $settings['show_overlay'] ) {
                echo '<div class="royal-ig-feed-card-overlay">';
                echo '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z"/></svg>';
                echo '</div>';
            }

            echo '</a>';
            echo '</div>'; // card-image

            // Caption
            if ( 'yes' === $settings['show_caption'] && ! empty( $caption ) ) {
                $trimmed = wp_trim_words( $caption, absint( $settings['caption_length'] ), '...' );
                echo '<div class="royal-ig-feed-card-caption">' . $trimmed . '</div>';
            }

            echo '</div>'; // card
        }

        echo '</div>'; // grid/list

        // ── Follow Button (bottom) ──────────────────────────────────────
        if ( 'yes' === $settings['show_follow_btn'] && $settings['follow_btn_position'] === 'bottom' ) {
            echo '<div style="text-align:center; margin-top:20px;">' . $follow_btn_html . '</div>';
        }

        // ── Load More ───────────────────────────────────────────────────
        if ( 'yes' === $settings['show_load_more'] ) {
            echo '<div class="royal-ig-feed-load-more-wrap" style="text-align:center;">';
            echo '<button class="royal-ig-feed-load-more" style="border:none; cursor:pointer; display:inline-block; text-decoration:none; font-weight:600; transition: all 0.3s ease;">';
            echo esc_html( $settings['load_more_text'] );
            echo '</button></div>';
        }

        echo '</div>'; // wrapper
    }
}
