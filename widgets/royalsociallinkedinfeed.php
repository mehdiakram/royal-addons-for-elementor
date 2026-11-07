<?php
namespace RoyalAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;

if ( ! defined( 'ABSPATH' ) ) exit;

class RoyalSocialLinkedinFeed extends Widget_Base {

    public function get_name() {
        return 'royalsociallinkedinfeed';
    }

    public function get_title() {
        return __( 'LinkedIn Feed', 'royal-addons-for-elementor' );
    }

    public function get_icon() { return 'eicon-linkedin rtbranding'; }

    public function get_categories() {
        return [ 'royaltech' ];
    }

    public function get_keywords() {
        return [ 'linkedin', 'feed', 'social', 'posts', 'page', 'tech', 'technologies', 'royal', 'mehdi', 'akram' ];
    }

    protected function register_controls() {

        // ═══════════════════════════════════════════════════════════════════
        //  CONTENT TAB
        // ═══════════════════════════════════════════════════════════════════

        // ─── LinkedIn Settings ───────────────────────────────────────────
        $this->start_controls_section( 'section_LinkedIn_content', [
            'label' => __( 'LinkedIn Settings', 'royal-addons-for-elementor' ),
        ]);

        $is_connected = get_option('royaladdons_linkedin_connected') === 'yes';

        if ( ! $is_connected ) {
            $this->add_control( 'not_connected_notice', [
                'type' => Controls_Manager::RAW_HTML,
                'raw'  => sprintf(
                    __( 'LinkedIn is not connected. Please connect your account from %sRoyal Addons -> Social%s settings.', 'royal-addons-for-elementor' ),
                    '<a href="' . admin_url('admin.php?page=royaladdons-social') . '" target="_blank" style="font-weight:bold; color:#1877f2;">', '</a>'
                ),
                'content_classes' => 'elementor-panel-alert elementor-panel-alert-danger',
            ]);
        } else {
            $this->add_control( 'connected_notice', [
                'type' => Controls_Manager::RAW_HTML,
                'raw'  => __( 'LinkedIn account is connected successfully.', 'royal-addons-for-elementor' ),
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

        // ─── Header Section ──────────────────────────────────────────────
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

        $this->add_control( 'header_page_name', [
            'label'       => __( 'Page Name', 'royal-addons-for-elementor' ),
            'type'        => Controls_Manager::TEXT,
            'default'     => __( 'My LinkedIn Page', 'royal-addons-for-elementor' ),
            'label_block' => true,
            'condition'   => [ 'show_header' => 'yes' ],
        ]);

        $this->add_control( 'header_bio', [
            'label'       => __( 'Bio / Description', 'royal-addons-for-elementor' ),
            'type'        => Controls_Manager::TEXTAREA,
            'default'     => '',
            'rows'        => 2,
            'condition'   => [ 'show_header' => 'yes' ],
        ]);

        $this->add_control( 'header_followers_count', [
            'label'       => __( 'Followers Count', 'royal-addons-for-elementor' ),
            'type'        => Controls_Manager::TEXT,
            'default'     => '',
            'placeholder' => __( 'e.g. 12.5K followers', 'royal-addons-for-elementor' ),
            'condition'   => [ 'show_header' => 'yes' ],
        ]);

        $this->add_control( 'header_icon', [
            'label'   => __( 'Verified Badge', 'royal-addons-for-elementor' ),
            'type'    => Controls_Manager::SWITCHER,
            'default' => '',
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
            'default'   => __( 'Follow Page', 'royal-addons-for-elementor' ),
            'condition' => [ 'show_follow_btn' => 'yes' ],
        ]);

        $this->add_control( 'follow_btn_url', [
            'label'       => __( 'Page URL', 'royal-addons-for-elementor' ),
            'type'        => Controls_Manager::URL,
            'placeholder' => __( 'https://LinkedIn.com/yourpage', 'royal-addons-for-elementor' ),
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

        // ─── Layout Options ──────────────────────────────────────────────
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
                '{{WRAPPER}} .royal-linkedin-feed-grid' => 'grid-template-columns: repeat({{VALUE}}, 1fr);',
            ],
            'condition' => [ 'layout_type' => 'grid' ],
        ]);

        $this->add_responsive_control( 'grid_gap', [
            'label'      => __( 'Gap', 'royal-addons-for-elementor' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => [ 'px' ],
            'range'      => [ 'px' => [ 'min' => 0, 'max' => 100, 'step' => 1 ] ],
            'default'    => [ 'unit' => 'px', 'size' => 20 ],
            'selectors'  => [
                '{{WRAPPER}} .royal-linkedin-feed-grid' => 'gap: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .royal-linkedin-feed-list .royal-linkedin-feed-card:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->end_controls_section();

        // ─── Post Elements ───────────────────────────────────────────────
        $this->start_controls_section( 'section_post_elements', [
            'label' => __( 'Post Elements', 'royal-addons-for-elementor' ),
        ]);

        $this->add_control( 'show_image', [
            'label'        => __( 'Show Image', 'royal-addons-for-elementor' ),
            'type'         => Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default'      => 'yes',
        ]);

        $this->add_control( 'show_excerpt', [
            'label'        => __( 'Show Message', 'royal-addons-for-elementor' ),
            'type'         => Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default'      => 'yes',
        ]);

        $this->add_control( 'excerpt_length', [
            'label'     => __( 'Message Length (Words)', 'royal-addons-for-elementor' ),
            'type'      => Controls_Manager::NUMBER,
            'min'       => 5,
            'max'       => 200,
            'default'   => 25,
            'condition' => [ 'show_excerpt' => 'yes' ],
        ]);

        $this->add_control( 'show_date', [
            'label'        => __( 'Show Date', 'royal-addons-for-elementor' ),
            'type'         => Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default'      => 'yes',
        ]);

        $this->add_control( 'show_read_more', [
            'label'        => __( 'Show "View on LinkedIn"', 'royal-addons-for-elementor' ),
            'type'         => Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default'      => 'yes',
        ]);

        $this->add_control( 'read_more_text', [
            'label'     => __( 'Link Text', 'royal-addons-for-elementor' ),
            'type'      => Controls_Manager::TEXT,
            'default'   => __( 'View on LinkedIn', 'royal-addons-for-elementor' ),
            'condition' => [ 'show_read_more' => 'yes' ],
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
            'selectors' => [ '{{WRAPPER}} .royal-linkedin-feed-wrapper' => 'background-color: {{VALUE}};' ],
        ]);

        $this->add_responsive_control( 'container_padding', [
            'label'      => __( 'Padding', 'royal-addons-for-elementor' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', '%', 'em' ],
            'selectors'  => [ '{{WRAPPER}} .royal-linkedin-feed-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
        ]);

        $this->add_group_control( Group_Control_Border::get_type(), [
            'name'     => 'container_border',
            'selector' => '{{WRAPPER}} .royal-linkedin-feed-wrapper',
        ]);

        $this->add_control( 'container_border_radius', [
            'label'      => __( 'Border Radius', 'royal-addons-for-elementor' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', '%' ],
            'selectors'  => [ '{{WRAPPER}} .royal-linkedin-feed-wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
        ]);

        $this->add_group_control( Group_Control_Box_Shadow::get_type(), [
            'name'     => 'container_box_shadow',
            'selector' => '{{WRAPPER}} .royal-linkedin-feed-wrapper',
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
            'default'   => '#f0f2f5',
            'selectors' => [ '{{WRAPPER}} .royal-linkedin-feed-header' => 'background-color: {{VALUE}};' ],
        ]);

        $this->add_responsive_control( 'header_padding', [
            'label'      => __( 'Padding', 'royal-addons-for-elementor' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', '%', 'em' ],
            'default'    => [ 'top' => '15', 'right' => '15', 'bottom' => '15', 'left' => '15', 'unit' => 'px', 'isLinked' => true ],
            'selectors'  => [ '{{WRAPPER}} .royal-linkedin-feed-header' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
        ]);

        $this->add_group_control( Group_Control_Border::get_type(), [
            'name'     => 'header_border',
            'selector' => '{{WRAPPER}} .royal-linkedin-feed-header',
        ]);

        $this->add_control( 'header_border_radius', [
            'label'      => __( 'Border Radius', 'royal-addons-for-elementor' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', '%' ],
            'selectors'  => [ '{{WRAPPER}} .royal-linkedin-feed-header' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
        ]);

        $this->add_responsive_control( 'header_avatar_size', [
            'label'      => __( 'Avatar Size', 'royal-addons-for-elementor' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => [ 'px' ],
            'range'      => [ 'px' => [ 'min' => 30, 'max' => 150 ] ],
            'default'    => [ 'unit' => 'px', 'size' => 60 ],
            'selectors'  => [
                '{{WRAPPER}} .royal-linkedin-feed-header-avatar img' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->add_control( 'header_name_color', [
            'label'     => __( 'Page Name Color', 'royal-addons-for-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#1c1e21',
            'selectors' => [ '{{WRAPPER}} .royal-linkedin-feed-header-name' => 'color: {{VALUE}};' ],
            'separator' => 'before',
        ]);

        $this->add_group_control( Group_Control_Typography::get_type(), [
            'name'     => 'header_name_typography',
            'selector' => '{{WRAPPER}} .royal-linkedin-feed-header-name',
        ]);

        $this->add_control( 'header_bio_color', [
            'label'     => __( 'Bio Color', 'royal-addons-for-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#65676b',
            'selectors' => [ '{{WRAPPER}} .royal-linkedin-feed-header-bio' => 'color: {{VALUE}};' ],
            'separator' => 'before',
        ]);

        $this->add_group_control( Group_Control_Typography::get_type(), [
            'name'     => 'header_bio_typography',
            'selector' => '{{WRAPPER}} .royal-linkedin-feed-header-bio',
        ]);

        $this->add_control( 'header_followers_color', [
            'label'     => __( 'Followers Color', 'royal-addons-for-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#65676b',
            'selectors' => [ '{{WRAPPER}} .royal-linkedin-feed-header-followers' => 'color: {{VALUE}};' ],
            'separator' => 'before',
        ]);

        $this->add_group_control( Group_Control_Typography::get_type(), [
            'name'     => 'header_followers_typography',
            'selector' => '{{WRAPPER}} .royal-linkedin-feed-header-followers',
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
            'selector' => '{{WRAPPER}} .royal-linkedin-feed-follow-btn',
        ]);

        $this->start_controls_tabs( 'follow_btn_tabs' );

        $this->start_controls_tab( 'follow_btn_normal', [ 'label' => __( 'Normal', 'royal-addons-for-elementor' ) ] );
        $this->add_control( 'follow_btn_color', [
            'label'     => __( 'Text Color', 'royal-addons-for-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#ffffff',
            'selectors' => [ '{{WRAPPER}} .royal-linkedin-feed-follow-btn' => 'color: {{VALUE}};' ],
        ]);
        $this->add_control( 'follow_btn_bg', [
            'label'     => __( 'Background', 'royal-addons-for-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#1877f2',
            'selectors' => [ '{{WRAPPER}} .royal-linkedin-feed-follow-btn' => 'background-color: {{VALUE}};' ],
        ]);
        $this->end_controls_tab();

        $this->start_controls_tab( 'follow_btn_hover_tab', [ 'label' => __( 'Hover', 'royal-addons-for-elementor' ) ] );
        $this->add_control( 'follow_btn_hover_color', [
            'label'     => __( 'Text Color', 'royal-addons-for-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [ '{{WRAPPER}} .royal-linkedin-feed-follow-btn:hover' => 'color: {{VALUE}};' ],
        ]);
        $this->add_control( 'follow_btn_hover_bg', [
            'label'     => __( 'Background', 'royal-addons-for-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [ '{{WRAPPER}} .royal-linkedin-feed-follow-btn:hover' => 'background-color: {{VALUE}};' ],
        ]);
        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control( 'follow_btn_padding', [
            'label'      => __( 'Padding', 'royal-addons-for-elementor' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', 'em' ],
            'default'    => [ 'top' => '8', 'right' => '20', 'bottom' => '8', 'left' => '20', 'unit' => 'px', 'isLinked' => false ],
            'selectors'  => [ '{{WRAPPER}} .royal-linkedin-feed-follow-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
            'separator'  => 'before',
        ]);

        $this->add_control( 'follow_btn_border_radius', [
            'label'      => __( 'Border Radius', 'royal-addons-for-elementor' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', '%' ],
            'default'    => [ 'top' => '6', 'right' => '6', 'bottom' => '6', 'left' => '6', 'unit' => 'px', 'isLinked' => true ],
            'selectors'  => [ '{{WRAPPER}} .royal-linkedin-feed-follow-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
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
            'selectors' => [ '{{WRAPPER}} .royal-linkedin-feed-card' => 'background-color: {{VALUE}};' ],
        ]);

        $this->add_responsive_control( 'card_padding', [
            'label'      => __( 'Padding', 'royal-addons-for-elementor' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', '%', 'em' ],
            'selectors'  => [ '{{WRAPPER}} .royal-linkedin-feed-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
        ]);

        $this->add_group_control( Group_Control_Border::get_type(), [
            'name'     => 'card_border',
            'selector' => '{{WRAPPER}} .royal-linkedin-feed-card',
        ]);

        $this->add_control( 'card_border_radius', [
            'label'      => __( 'Border Radius', 'royal-addons-for-elementor' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', '%' ],
            'selectors'  => [ '{{WRAPPER}} .royal-linkedin-feed-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
        ]);

        $this->add_group_control( Group_Control_Box_Shadow::get_type(), [
            'name'     => 'card_box_shadow',
            'selector' => '{{WRAPPER}} .royal-linkedin-feed-card',
        ]);

        $this->end_controls_section();

        // ─── Style: Image ────────────────────────────────────────────────
        $this->start_controls_section( 'section_image_style', [
            'label'     => __( 'Image', 'royal-addons-for-elementor' ),
            'tab'       => Controls_Manager::TAB_STYLE,
            'condition' => [ 'show_image' => 'yes' ],
        ]);

        $this->add_responsive_control( 'image_height', [
            'label'      => __( 'Height', 'royal-addons-for-elementor' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => [ 'px' ],
            'range'      => [ 'px' => [ 'min' => 100, 'max' => 600 ] ],
            'default'    => [ 'unit' => 'px', 'size' => 220 ],
            'selectors'  => [ '{{WRAPPER}} .royal-linkedin-feed-card-image img' => 'height: {{SIZE}}{{UNIT}};' ],
        ]);

        $this->add_control( 'image_border_radius', [
            'label'      => __( 'Border Radius', 'royal-addons-for-elementor' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', '%' ],
            'selectors'  => [ '{{WRAPPER}} .royal-linkedin-feed-card-image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
        ]);

        $this->end_controls_section();

        // ─── Style: Message ──────────────────────────────────────────────
        $this->start_controls_section( 'section_message_style', [
            'label'     => __( 'Message', 'royal-addons-for-elementor' ),
            'tab'       => Controls_Manager::TAB_STYLE,
            'condition' => [ 'show_excerpt' => 'yes' ],
        ]);

        $this->add_control( 'message_color', [
            'label'     => __( 'Color', 'royal-addons-for-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [ '{{WRAPPER}} .royal-linkedin-feed-card-message' => 'color: {{VALUE}};' ],
        ]);

        $this->add_group_control( Group_Control_Typography::get_type(), [
            'name'     => 'message_typography',
            'selector' => '{{WRAPPER}} .royal-linkedin-feed-card-message',
        ]);

        $this->add_responsive_control( 'message_margin', [
            'label'      => __( 'Margin', 'royal-addons-for-elementor' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', 'em', '%' ],
            'selectors'  => [ '{{WRAPPER}} .royal-linkedin-feed-card-message' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
        ]);

        $this->end_controls_section();

        // ─── Style: Date ─────────────────────────────────────────────────
        $this->start_controls_section( 'section_date_style', [
            'label'     => __( 'Date', 'royal-addons-for-elementor' ),
            'tab'       => Controls_Manager::TAB_STYLE,
            'condition' => [ 'show_date' => 'yes' ],
        ]);

        $this->add_control( 'date_color', [
            'label'     => __( 'Color', 'royal-addons-for-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#65676b',
            'selectors' => [ '{{WRAPPER}} .royal-linkedin-feed-card-date' => 'color: {{VALUE}};' ],
        ]);

        $this->add_group_control( Group_Control_Typography::get_type(), [
            'name'     => 'date_typography',
            'selector' => '{{WRAPPER}} .royal-linkedin-feed-card-date',
        ]);

        $this->add_responsive_control( 'date_margin', [
            'label'      => __( 'Margin', 'royal-addons-for-elementor' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', 'em', '%' ],
            'selectors'  => [ '{{WRAPPER}} .royal-linkedin-feed-card-date' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
        ]);

        $this->end_controls_section();

        // ─── Style: Read More Link ───────────────────────────────────────
        $this->start_controls_section( 'section_read_more_style', [
            'label'     => __( 'View on LinkedIn Link', 'royal-addons-for-elementor' ),
            'tab'       => Controls_Manager::TAB_STYLE,
            'condition' => [ 'show_read_more' => 'yes' ],
        ]);

        $this->add_group_control( Group_Control_Typography::get_type(), [
            'name'     => 'read_more_typography',
            'selector' => '{{WRAPPER}} .royal-linkedin-feed-card-link a',
        ]);

        $this->start_controls_tabs( 'read_more_tabs' );
        $this->start_controls_tab( 'read_more_normal', [ 'label' => __( 'Normal', 'royal-addons-for-elementor' ) ] );
        $this->add_control( 'link_color', [
            'label' => __( 'Color', 'royal-addons-for-elementor' ), 'type' => Controls_Manager::COLOR,
            'default' => '#1877f2', 'selectors' => [ '{{WRAPPER}} .royal-linkedin-feed-card-link a' => 'color: {{VALUE}};' ],
        ]);
        $this->end_controls_tab();
        $this->start_controls_tab( 'read_more_hover', [ 'label' => __( 'Hover', 'royal-addons-for-elementor' ) ] );
        $this->add_control( 'link_hover_color', [
            'label' => __( 'Color', 'royal-addons-for-elementor' ), 'type' => Controls_Manager::COLOR,
            'selectors' => [ '{{WRAPPER}} .royal-linkedin-feed-card-link a:hover' => 'color: {{VALUE}};' ],
        ]);
        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();

        // ─── Style: Load More Button ─────────────────────────────────────
        $this->start_controls_section( 'section_load_more_style', [
            'label'     => __( 'Load More Button', 'royal-addons-for-elementor' ),
            'tab'       => Controls_Manager::TAB_STYLE,
            'condition' => [ 'show_load_more' => 'yes' ],
        ]);

        $this->add_group_control( Group_Control_Typography::get_type(), [
            'name'     => 'load_more_typography',
            'selector' => '{{WRAPPER}} .royal-linkedin-feed-load-more',
        ]);

        $this->start_controls_tabs( 'load_more_tabs' );
        $this->start_controls_tab( 'load_more_normal_tab', [ 'label' => __( 'Normal', 'royal-addons-for-elementor' ) ] );
        $this->add_control( 'load_more_color', [ 'label' => __( 'Text Color', 'royal-addons-for-elementor' ), 'type' => Controls_Manager::COLOR, 'default' => '#ffffff', 'selectors' => [ '{{WRAPPER}} .royal-linkedin-feed-load-more' => 'color: {{VALUE}};' ] ] );
        $this->add_control( 'load_more_bg', [ 'label' => __( 'Background', 'royal-addons-for-elementor' ), 'type' => Controls_Manager::COLOR, 'default' => '#1877f2', 'selectors' => [ '{{WRAPPER}} .royal-linkedin-feed-load-more' => 'background-color: {{VALUE}};' ] ] );
        $this->end_controls_tab();
        $this->start_controls_tab( 'load_more_hover_tab', [ 'label' => __( 'Hover', 'royal-addons-for-elementor' ) ] );
        $this->add_control( 'load_more_hover_color', [ 'label' => __( 'Text Color', 'royal-addons-for-elementor' ), 'type' => Controls_Manager::COLOR, 'selectors' => [ '{{WRAPPER}} .royal-linkedin-feed-load-more:hover' => 'color: {{VALUE}};' ] ] );
        $this->add_control( 'load_more_hover_bg', [ 'label' => __( 'Background', 'royal-addons-for-elementor' ), 'type' => Controls_Manager::COLOR, 'selectors' => [ '{{WRAPPER}} .royal-linkedin-feed-load-more:hover' => 'background-color: {{VALUE}};' ] ] );
        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_responsive_control( 'load_more_padding', [
            'label'      => __( 'Padding', 'royal-addons-for-elementor' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', 'em' ],
            'default'    => [ 'top' => '10', 'right' => '30', 'bottom' => '10', 'left' => '30', 'unit' => 'px', 'isLinked' => false ],
            'selectors'  => [ '{{WRAPPER}} .royal-linkedin-feed-load-more' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
            'separator'  => 'before',
        ]);

        $this->add_control( 'load_more_border_radius', [
            'label'      => __( 'Border Radius', 'royal-addons-for-elementor' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', '%' ],
            'default'    => [ 'top' => '6', 'right' => '6', 'bottom' => '6', 'left' => '6', 'unit' => 'px', 'isLinked' => true ],
            'selectors'  => [ '{{WRAPPER}} .royal-linkedin-feed-load-more' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
        ]);

        $this->add_responsive_control( 'load_more_margin', [
            'label'      => __( 'Margin', 'royal-addons-for-elementor' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', 'em', '%' ],
            'default'    => [ 'top' => '20', 'right' => '0', 'bottom' => '0', 'left' => '0', 'unit' => 'px', 'isLinked' => false ],
            'selectors'  => [ '{{WRAPPER}} .royal-linkedin-feed-load-more-wrap' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
        ]);

        $this->end_controls_section();
    }

    // =====================================================================
    //  RENDER
    // =====================================================================
    protected function render() {
        $settings = $this->get_settings_for_display();

        $is_connected = get_option('royaladdons_linkedin_connected') === 'yes';
        $license_key  = get_option('royaladdons_license_key', '');

        $posts_count = ! empty( $settings['posts_count'] ) ? absint( $settings['posts_count'] ) : 9;
        $cache_time  = isset( $settings['cache_duration'] ) ? absint( $settings['cache_duration'] ) : 3600;
        $layout      = ! empty( $settings['layout_type'] ) ? $settings['layout_type'] : 'grid';

        if ( ! $is_connected || empty($license_key) ) {
            if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
                echo '<div class="elementor-alert elementor-alert-warning">' . esc_html__( 'Please connect your LinkedIn account from Royal Addons -> Social settings.', 'royal-addons-for-elementor' ) . '</div>';
            }
            return;
        }

        // ── Fetch posts from RoyalAuth API ───────────────────────────────
        $transient_key = 'royal_fb_feed_proxy_' . md5( $license_key . $posts_count );
        $posts = get_transient( $transient_key );

        if ( false === $posts ) {
            $api_url = "https://auth.royaltechbd.com/api/social/feed";
            $api_url = add_query_arg( [
                'platform' => 'linkedin',
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
            foreach ( $body['data'] as $post ) {
                $posts[] = [
                    'message'       => isset( $post['message'] ) ? $post['message'] : '',
                    'created_time'  => isset( $post['created_time'] ) ? $post['created_time'] : '',
                    'full_picture'  => isset( $post['full_picture'] ) ? $post['full_picture'] : '',
                    'permalink_url' => isset( $post['permalink_url'] ) ? $post['permalink_url'] : '',
                ];
            }

            if ( $cache_time > 0 ) {
                set_transient( $transient_key, $posts, $cache_time );
            }
        }

        if ( empty( $posts ) ) return;

        // ── Build follow button HTML ────────────────────────────────────
        $follow_btn_html = '';
        if ( 'yes' === $settings['show_follow_btn'] ) {
            $btn_url  = ! empty( $settings['follow_btn_url']['url'] ) ? esc_url( $settings['follow_btn_url']['url'] ) : '#';
            $btn_ext  = ! empty( $settings['follow_btn_url']['is_external'] ) ? ' target="_blank"' : '';
            $btn_nf   = ! empty( $settings['follow_btn_url']['nofollow'] ) ? ' rel="nofollow noopener"' : '';
            $follow_btn_html = '<a href="' . $btn_url . '"' . $btn_ext . $btn_nf . ' class="royal-linkedin-feed-follow-btn">'
                . '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" style="width:14px;height:14px;fill:currentColor;margin-right:6px;vertical-align:middle;"><path d="M100.28 448H7.4V148.9h92.88zM53.79 108.1C24.09 108.1 0 83.5 0 53.8a53.79 53.79 0 0 1 107.58 0c0 29.7-24.1 54.3-53.79 54.3zM447.9 448h-92.68V302.4c0-34.7-.7-79.2-48.29-79.2-48.29 0-55.69 37.7-55.69 76.7V448h-92.78V148.9h89.08v40.8h1.3c12.4-23.5 42.69-48.3 87.88-48.3 94 0 111.28 61.9 111.28 142.3V448z"/></svg>'
                . esc_html( $settings['follow_btn_text'] )
                . '</a>';
        }

        // ── Wrapper ─────────────────────────────────────────────────────
        echo '<div class="royal-linkedin-feed-wrapper">';

        // ── Header ──────────────────────────────────────────────────────
        if ( 'yes' === $settings['show_header'] ) {
            $avatar_url = ! empty( $settings['header_profile_image']['url'] ) ? esc_url( $settings['header_profile_image']['url'] ) : '';
            $page_name  = esc_html( $settings['header_page_name'] );
            $bio        = esc_html( $settings['header_bio'] );
            $followers  = esc_html( $settings['header_followers_count'] );

            echo '<div class="royal-linkedin-feed-header" style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap;">';
            echo '<div style="display:flex; align-items:center; gap:12px; flex:1; min-width:0;">';

            if ( $avatar_url ) {
                echo '<div class="royal-linkedin-feed-header-avatar"><img src="' . $avatar_url . '" alt="' . $page_name . '" style="border-radius:50%; object-fit:cover;" /></div>';
            }

            echo '<div style="min-width:0;">';
            echo '<div class="royal-linkedin-feed-header-name" style="font-weight:700; display:flex; align-items:center; gap:5px;">';
            echo $page_name;
            if ( 'yes' === $settings['header_icon'] ) {
                echo '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" style="width:16px;height:16px;fill:#0a66c2;flex-shrink:0;"><path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM369 209L241 337c-9.4 9.4-24.6 9.4-33.9 0l-64-64c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l47 47L335 175c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9z"/></svg>';
            }
            echo '</div>';

            if ( $bio ) {
                echo '<div class="royal-linkedin-feed-header-bio" style="margin-top:2px;">' . $bio . '</div>';
            }
            if ( $followers ) {
                echo '<div class="royal-linkedin-feed-header-followers" style="margin-top:2px; font-size:13px;">' . $followers . '</div>';
            }
            echo '</div>'; // text
            echo '</div>'; // left

            if ( 'yes' === $settings['show_follow_btn'] && $settings['follow_btn_position'] === 'header' ) {
                echo $follow_btn_html;
            }

            echo '</div>'; // .royal-linkedin-feed-header
        }

        // ── Feed Grid/List ──────────────────────────────────────────────
        $grid_class = $layout === 'grid' ? 'royal-linkedin-feed-grid' : 'royal-linkedin-feed-list';
        $grid_style = $layout === 'grid' ? 'display:grid;' : '';
        echo '<div class="' . $grid_class . '" style="' . $grid_style . '">';

        foreach ( $posts as $post ) {
            $message       = esc_html( $post['message'] );
            $created_time  = ! empty( $post['created_time'] ) ? date( 'F j, Y', strtotime( $post['created_time'] ) ) : '';
            $full_picture  = esc_url( $post['full_picture'] );
            $permalink_url = ! empty( $post['permalink_url'] ) ? esc_url( $post['permalink_url'] ) : '#';

            if ( 'yes' === $settings['show_excerpt'] && ! empty( $message ) ) {
                $message = wp_trim_words( $message, absint( $settings['excerpt_length'] ), '...' );
            }

            echo '<div class="royal-linkedin-feed-card" style="overflow:hidden;">';

            if ( 'yes' === $settings['show_image'] && $full_picture ) {
                echo '<div class="royal-linkedin-feed-card-image">';
                echo '<a href="' . $permalink_url . '" target="_blank" rel="nofollow noopener">';
                echo '<img src="' . $full_picture . '" alt="' . esc_attr( wp_trim_words( $post['message'], 10, '' ) ) . '" loading="lazy" style="width:100%; display:block; object-fit:cover;" />';
                echo '</a></div>';
            }

            echo '<div class="royal-linkedin-feed-card-body" style="padding:12px;">';

            if ( 'yes' === $settings['show_excerpt'] && ! empty( $message ) ) {
                echo '<div class="royal-linkedin-feed-card-message">' . $message . '</div>';
            }

            if ( 'yes' === $settings['show_date'] && $created_time ) {
                echo '<div class="royal-linkedin-feed-card-date" style="margin-top:8px; font-size:13px;">' . esc_html( $created_time ) . '</div>';
            }

            if ( 'yes' === $settings['show_read_more'] ) {
                echo '<div class="royal-linkedin-feed-card-link" style="margin-top:8px;">';
                echo '<a href="' . $permalink_url . '" target="_blank" rel="nofollow noopener">' . esc_html( $settings['read_more_text'] ) . '</a>';
                echo '</div>';
            }

            echo '</div></div>'; // card-body, card
        }

        echo '</div>'; // grid/list

        // ── Follow Button (bottom position) ─────────────────────────────
        if ( 'yes' === $settings['show_follow_btn'] && $settings['follow_btn_position'] === 'bottom' ) {
            echo '<div style="text-align:center; margin-top:20px;">' . $follow_btn_html . '</div>';
        }

        // ── Load More Button ────────────────────────────────────────────
        if ( 'yes' === $settings['show_load_more'] ) {
            echo '<div class="royal-linkedin-feed-load-more-wrap" style="text-align:center;">';
            echo '<button class="royal-linkedin-feed-load-more" style="border:none; cursor:pointer; display:inline-block; text-decoration:none;">';
            echo esc_html( $settings['load_more_text'] );
            echo '</button></div>';
        }

        echo '</div>'; // .royal-linkedin-feed-wrapper
    }
}



