<?php
namespace RoyalAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Icons_Manager;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class RoyalPreviewCard extends Widget_Base {

    public function get_name() {
        return 'royalpreviewcard';
    }

    public function get_title() {
        return esc_html__( 'Preview Card', 'royal-addons-for-elementor' );
    }

    public function get_icon() {
        return 'eicon-lightbox rtbranding';
    }

    public function get_keywords() {
        return [ 'preview', 'card', 'price', 'sell', 'price card', 'tech', 'technologies', 'royal', 'creed', 'unnayan', 'program', 'branch', 'stats', 'mehdi', 'akram' ];
    }

    public function get_categories() {
        return [ 'royaltech' ];
    }

    public function get_style_depends() {
        return [ 'royalpreviewcard' ];
    }

    protected function register_controls() {
        // Section: Layout & Preset
        $this->start_controls_section(
            'section_card_preset',
            [
                'label' => esc_html__( 'Layout & Preset', 'royal-addons-for-elementor' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'card_style',
            [
                'label'   => esc_html__( 'Card Style', 'royal-addons-for-elementor' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'style-1',
                'options' => [
                    'style-1'  => esc_html__( 'Style 1 - Classic Price Card (Default)', 'royal-addons-for-elementor' ),
                    'style-2'  => esc_html__( 'Style 2 - Program Card with Checklist', 'royal-addons-for-elementor' ),
                    'style-3'  => esc_html__( 'Style 3 - Minimal Feature Icon Card', 'royal-addons-for-elementor' ),
                    'style-4'  => esc_html__( 'Style 4 - Step Process Card (Dark Mode)', 'royal-addons-for-elementor' ),
                    'style-5'  => esc_html__( 'Style 5 - Step Process Card (Light Mode)', 'royal-addons-for-elementor' ),
                    'style-6'  => esc_html__( 'Style 6 - Branch & HQ Card (Dark Mode)', 'royal-addons-for-elementor' ),
                    'style-7'  => esc_html__( 'Style 7 - Branch & Hub Card (Light Mode)', 'royal-addons-for-elementor' ),
                    'style-8'  => esc_html__( 'Style 8 - Registration & Legal Card', 'royal-addons-for-elementor' ),
                    'style-9'  => esc_html__( 'Style 9 - Modern Contact Card (Glow Ring)', 'royal-addons-for-elementor' ),
                    'style-10' => esc_html__( 'Style 10 - Social Follow Card (Glow Ring)', 'royal-addons-for-elementor' ),
                    'style-11' => esc_html__( 'Style 11 - Impact & Stat Metric Card', 'royal-addons-for-elementor' ),
                ],
            ]
        );

        $this->add_control(
            'card_accent_color',
            [
                'label'     => esc_html__( 'Accent Color', 'royal-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#0b4d26',
                'selectors' => [
                    '{{WRAPPER}} .royal-preview-card' => '--rpc-accent: {{VALUE}};',
                ],
                'condition' => [
                    'card_style!' => 'style-1',
                ],
            ]
        );

        $this->end_controls_section();

        // Image Settings
        $this->start_controls_section(
            'image_section',
            [
                'label'     => esc_html__( 'Image', 'royal-addons-for-elementor' ),
                'tab'       => Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'card_style' => [ 'style-1', 'style-2' ],
                ],
            ]
        );

        $this->add_control(
            'image',
            [
                'label'   => esc_html__( 'Choose Image', 'royal-addons-for-elementor' ),
                'type'    => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $this->add_control(
            'show_image_link',
            [
                'label'        => esc_html__( 'Show Image Link', 'royal-addons-for-elementor' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Show', 'royal-addons-for-elementor' ),
                'label_off'    => esc_html__( 'Hide', 'royal-addons-for-elementor' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );

        $this->add_control(
            'image_link',
            [
                'label'         => esc_html__( 'Image Link', 'royal-addons-for-elementor' ),
                'type'          => Controls_Manager::URL,
                'placeholder'   => esc_html__( 'https://your-link.com', 'royal-addons-for-elementor' ),
                'show_external' => true,
                'default'       => [
                    'url'         => '',
                    'is_external' => true,
                    'nofollow'    => true,
                ],
                'condition'     => [
                    'show_image_link' => 'yes',
                ],
            ]
        );

        $this->end_controls_section();

        // Icon Settings
        $this->start_controls_section(
            'icon_section',
            [
                'label'     => esc_html__( 'Icon Settings', 'royal-addons-for-elementor' ),
                'tab'       => Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'card_style' => [ 'style-3', 'style-4', 'style-5', 'style-6', 'style-7', 'style-8', 'style-9', 'style-10', 'style-11' ],
                ],
            ]
        );

        $this->add_control(
            'card_icon',
            [
                'label'   => esc_html__( 'Main Icon', 'royal-addons-for-elementor' ),
                'type'    => Controls_Manager::ICONS,
                'default' => [
                    'value'   => 'fas fa-shield-alt',
                    'library' => 'fa-solid',
                ],
            ]
        );

        $this->add_control(
            'secondary_icon',
            [
                'label'     => esc_html__( 'Corner / Secondary Icon', 'royal-addons-for-elementor' ),
                'type'      => Controls_Manager::ICONS,
                'default'   => [
                    'value'   => 'far fa-lightbulb',
                    'library' => 'fa-regular',
                ],
                'condition' => [
                    'card_style' => [ 'style-4', 'style-5', 'style-6', 'style-7' ],
                ],
            ]
        );

        $this->end_controls_section();

        // Content Settings
        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__( 'Content', 'royal-addons-for-elementor' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'card_title',
            [
                'label'       => esc_html__( 'Title', 'royal-addons-for-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => esc_html__( 'Card Title', 'royal-addons-for-elementor' ),
                'label_block' => true,
                'placeholder' => esc_html__( 'Type your title here', 'royal-addons-for-elementor' ),
            ]
        );

        $this->add_control(
            'card_subtitle',
            [
                'label'       => esc_html__( 'Subtitle / Address', 'royal-addons-for-elementor' ),
                'type'        => Controls_Manager::TEXTAREA,
                'default'     => esc_html__( 'Detailed address or subtitle note goes here.', 'royal-addons-for-elementor' ),
                'rows'        => 3,
                'condition'   => [
                    'card_style' => [ 'style-6', 'style-7', 'style-8' ],
                ],
            ]
        );

        $this->add_control(
            'show_divider',
            [
                'label'        => esc_html__( 'Show Divider', 'royal-addons-for-elementor' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Show', 'royal-addons-for-elementor' ),
                'label_off'    => esc_html__( 'Hide', 'royal-addons-for-elementor' ),
                'return_value' => 'yes',
                'default'      => 'yes',
                'condition'    => [
                    'card_style' => [ 'style-1', 'style-2', 'style-4', 'style-5', 'style-6', 'style-7' ],
                ],
            ]
        );

        $this->add_control(
            'item_description',
            [
                'label'       => esc_html__( 'Description', 'royal-addons-for-elementor' ),
                'type'        => Controls_Manager::WYSIWYG,
                'default'     => esc_html__( 'Default description text for the card.', 'royal-addons-for-elementor' ),
                'placeholder' => esc_html__( 'Type your description here', 'royal-addons-for-elementor' ),
                'condition'   => [
                    'card_style' => [ 'style-1', 'style-2', 'style-3', 'style-4', 'style-5', 'style-11' ],
                ],
            ]
        );

        $this->end_controls_section();

        // Badge & Meta Settings
        $this->start_controls_section(
            'badge_section',
            [
                'label'     => esc_html__( 'Badges & Numbers', 'royal-addons-for-elementor' ),
                'tab'       => Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'card_style' => [ 'style-1', 'style-2', 'style-4', 'style-5', 'style-6', 'style-7', 'style-11' ],
                ],
            ]
        );

        // Style 1 Badges
        $this->add_control(
            'show_top_badge',
            [
                'label'        => esc_html__( 'Show Top Badge', 'royal-addons-for-elementor' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Show', 'royal-addons-for-elementor' ),
                'label_off'    => esc_html__( 'Hide', 'royal-addons-for-elementor' ),
                'return_value' => 'yes',
                'default'      => 'yes',
                'condition'    => [
                    'card_style' => 'style-1',
                ],
            ]
        );

        $this->add_control(
            'top_badge_text',
            [
                'label'     => esc_html__( 'Top Badge Text', 'royal-addons-for-elementor' ),
                'type'      => Controls_Manager::TEXT,
                'default'   => esc_html__( 'On Sale!', 'royal-addons-for-elementor' ),
                'condition' => [
                    'card_style'     => 'style-1',
                    'show_top_badge' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'show_middle_badge',
            [
                'label'        => esc_html__( 'Show Middle Badge', 'royal-addons-for-elementor' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Show', 'royal-addons-for-elementor' ),
                'label_off'    => esc_html__( 'Hide', 'royal-addons-for-elementor' ),
                'return_value' => 'yes',
                'default'      => 'yes',
                'condition'    => [
                    'card_style' => 'style-1',
                ],
            ]
        );

        $this->add_control(
            'middle_badge_text',
            [
                'label'     => esc_html__( 'Middle Badge Text', 'royal-addons-for-elementor' ),
                'type'      => Controls_Manager::TEXT,
                'default'   => esc_html__( '$19.99', 'royal-addons-for-elementor' ),
                'condition' => [
                    'card_style'        => 'style-1',
                    'show_middle_badge' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'show_bottom_badge',
            [
                'label'        => esc_html__( 'Show Bottom Badge', 'royal-addons-for-elementor' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Show', 'royal-addons-for-elementor' ),
                'label_off'    => esc_html__( 'Hide', 'royal-addons-for-elementor' ),
                'return_value' => 'yes',
                'default'      => 'yes',
                'condition'    => [
                    'card_style' => 'style-1',
                ],
            ]
        );

        $this->add_control(
            'bottom_badge_text',
            [
                'label'     => esc_html__( 'Bottom Badge Text', 'royal-addons-for-elementor' ),
                'type'      => Controls_Manager::TEXT,
                'default'   => esc_html__( '$19.99', 'royal-addons-for-elementor' ),
                'condition' => [
                    'card_style'        => 'style-1',
                    'show_bottom_badge' => 'yes',
                ],
            ]
        );

        // General Badge Text (Styles 2, 6, 7)
        $this->add_control(
            'badge_text',
            [
                'label'     => esc_html__( 'Badge Text', 'royal-addons-for-elementor' ),
                'type'      => Controls_Manager::TEXT,
                'default'   => esc_html__( 'Featured Focus', 'royal-addons-for-elementor' ),
                'condition' => [
                    'card_style' => [ 'style-2', 'style-6', 'style-7' ],
                ],
            ]
        );

        // Step Number (Styles 4, 5)
        $this->add_control(
            'step_number',
            [
                'label'     => esc_html__( 'Step Number', 'royal-addons-for-elementor' ),
                'type'      => Controls_Manager::TEXT,
                'default'   => '03',
                'condition' => [
                    'card_style' => [ 'style-4', 'style-5' ],
                ],
            ]
        );

        // Metric Prefix / Number / Suffix (Style 11)
        $this->add_control(
            'metric_prefix',
            [
                'label'     => esc_html__( 'Metric Prefix', 'royal-addons-for-elementor' ),
                'type'      => Controls_Manager::TEXT,
                'default'   => '৳',
                'condition' => [
                    'card_style' => 'style-11',
                ],
            ]
        );

        $this->add_control(
            'metric_number',
            [
                'label'     => esc_html__( 'Metric Number', 'royal-addons-for-elementor' ),
                'type'      => Controls_Manager::TEXT,
                'default'   => '62.8',
                'condition' => [
                    'card_style' => 'style-11',
                ],
            ]
        );

        $this->add_control(
            'metric_suffix',
            [
                'label'     => esc_html__( 'Metric Suffix', 'royal-addons-for-elementor' ),
                'type'      => Controls_Manager::TEXT,
                'default'   => 'Cr+',
                'condition' => [
                    'card_style' => 'style-11',
                ],
            ]
        );

        // Footer Note (Styles 4, 5, 6, 7)
        $this->add_control(
            'footer_note',
            [
                'label'     => esc_html__( 'Footer Highlight Note', 'royal-addons-for-elementor' ),
                'type'      => Controls_Manager::TEXT,
                'default'   => esc_html__( 'Practical Viability', 'royal-addons-for-elementor' ),
                'condition' => [
                    'card_style' => [ 'style-4', 'style-5', 'style-6', 'style-7' ],
                ],
            ]
        );

        $this->end_controls_section();

        // Checklist Items (Style 2)
        $this->start_controls_section(
            'checklist_section',
            [
                'label'     => esc_html__( 'Checklist Items', 'royal-addons-for-elementor' ),
                'tab'       => Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'card_style' => 'style-2',
                ],
            ]
        );

        $checklist_repeater = new Repeater();

        $checklist_repeater->add_control(
            'item_text',
            [
                'label'       => esc_html__( 'Item Text', 'royal-addons-for-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => esc_html__( 'Checklist item point', 'royal-addons-for-elementor' ),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'checklist_items',
            [
                'label'       => esc_html__( 'Items', 'royal-addons-for-elementor' ),
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $checklist_repeater->get_controls(),
                'default'     => [
                    [ 'item_text' => esc_html__( '5 full primary classes', 'royal-addons-for-elementor' ) ],
                    [ 'item_text' => esc_html__( '100% remote island coverage', 'royal-addons-for-elementor' ) ],
                    [ 'item_text' => esc_html__( '23+ years unbroken running', 'royal-addons-for-elementor' ) ],
                ],
                'title_field' => '{{{ item_text }}}',
            ]
        );

        $this->end_controls_section();

        // Info / Contact Rows (Styles 6, 7, 8, 9)
        $this->start_controls_section(
            'info_rows_section',
            [
                'label'     => esc_html__( 'Info / Contact Rows', 'royal-addons-for-elementor' ),
                'tab'       => Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'card_style' => [ 'style-6', 'style-7', 'style-8', 'style-9' ],
                ],
            ]
        );

        $info_repeater = new Repeater();

        $info_repeater->add_control(
            'row_icon',
            [
                'label'   => esc_html__( 'Icon', 'royal-addons-for-elementor' ),
                'type'    => Controls_Manager::ICONS,
                'default' => [
                    'value'   => 'fas fa-phone-alt',
                    'library' => 'fa-solid',
                ],
            ]
        );

        $info_repeater->add_control(
            'row_label',
            [
                'label'   => esc_html__( 'Label / Key', 'royal-addons-for-elementor' ),
                'type'    => Controls_Manager::TEXT,
                'default' => esc_html__( 'Phone', 'royal-addons-for-elementor' ),
            ]
        );

        $info_repeater->add_control(
            'row_value',
            [
                'label'       => esc_html__( 'Value / Detail', 'royal-addons-for-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => esc_html__( '+880 1711-608288', 'royal-addons-for-elementor' ),
                'label_block' => true,
            ]
        );

        $info_repeater->add_control(
            'row_link',
            [
                'label'         => esc_html__( 'Link URL', 'royal-addons-for-elementor' ),
                'type'          => Controls_Manager::URL,
                'placeholder'   => 'tel:+880... or mailto:...',
                'show_external' => true,
                'default'       => [
                    'url'         => '',
                    'is_external' => false,
                ],
            ]
        );

        $this->add_control(
            'info_rows',
            [
                'label'       => esc_html__( 'Rows', 'royal-addons-for-elementor' ),
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $info_repeater->get_controls(),
                'default'     => [
                    [
                        'row_label' => 'Phone',
                        'row_value' => '+880 1711-608288',
                    ],
                    [
                        'row_label' => 'Phone',
                        'row_value' => '+880 1313-046002',
                    ],
                    [
                        'row_label' => 'Email',
                        'row_value' => 'info@creedbd.org',
                    ],
                ],
                'title_field' => '{{{ row_label }}}: {{{ row_value }}}',
            ]
        );

        $this->end_controls_section();

        // Social Links (Style 10)
        $this->start_controls_section(
            'social_links_section',
            [
                'label'     => esc_html__( 'Social Media Links', 'royal-addons-for-elementor' ),
                'tab'       => Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'card_style' => 'style-10',
                ],
            ]
        );

        $social_repeater = new Repeater();

        $social_repeater->add_control(
            'social_platform',
            [
                'label'   => esc_html__( 'Platform', 'royal-addons-for-elementor' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'facebook',
                'options' => [
                    'facebook' => 'Facebook',
                    'youtube'  => 'YouTube',
                    'linkedin' => 'LinkedIn',
                    'twitter'  => 'X / Twitter',
                    'whatsapp' => 'WhatsApp',
                    'custom'   => 'Custom',
                ],
            ]
        );

        $social_repeater->add_control(
            'social_icon',
            [
                'label'     => esc_html__( 'Custom Icon', 'royal-addons-for-elementor' ),
                'type'      => Controls_Manager::ICONS,
                'condition' => [
                    'social_platform' => 'custom',
                ],
            ]
        );

        $social_repeater->add_control(
            'social_url',
            [
                'label'       => esc_html__( 'Profile URL', 'royal-addons-for-elementor' ),
                'type'        => Controls_Manager::URL,
                'default'     => [
                    'url'         => '#',
                    'is_external' => true,
                ],
                'label_block' => true,
            ]
        );

        $this->add_control(
            'social_links',
            [
                'label'       => esc_html__( 'Buttons', 'royal-addons-for-elementor' ),
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $social_repeater->get_controls(),
                'default'     => [
                    [
                        'social_platform' => 'facebook',
                        'social_url'      => [ 'url' => 'https://facebook.com/' ],
                    ],
                    [
                        'social_platform' => 'youtube',
                        'social_url'      => [ 'url' => 'https://youtube.com/' ],
                    ],
                ],
                'title_field' => '{{{ social_platform }}}',
            ]
        );

        $this->end_controls_section();

        // Button Settings
        $this->start_controls_section(
            'button_section',
            [
                'label' => esc_html__( 'Button & Link', 'royal-addons-for-elementor' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'show_button',
            [
                'label'        => esc_html__( 'Show Action / Link', 'royal-addons-for-elementor' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Show', 'royal-addons-for-elementor' ),
                'label_off'    => esc_html__( 'Hide', 'royal-addons-for-elementor' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );

        $this->add_control(
            'button_text',
            [
                'label'       => esc_html__( 'Text', 'royal-addons-for-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => esc_html__( 'View Story', 'royal-addons-for-elementor' ),
                'placeholder' => esc_html__( 'Type your button text', 'royal-addons-for-elementor' ),
                'condition'   => [
                    'show_button' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'button_link',
            [
                'label'         => esc_html__( 'Link URL', 'royal-addons-for-elementor' ),
                'type'          => Controls_Manager::URL,
                'placeholder'   => esc_html__( 'https://your-link.com', 'royal-addons-for-elementor' ),
                'show_external' => true,
                'default'       => [
                    'url'         => '',
                    'is_external' => true,
                    'nofollow'    => true,
                ],
            ]
        );

        $this->end_controls_section();

        // Style Tab
        $this->style_tab();
    }

    private function style_tab() {
        // Card Container Style Settings
        $this->start_controls_section(
            'card_box_style_section',
            [
                'label' => esc_html__( 'Card Container', 'royal-addons-for-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'card_bg_color',
            [
                'label'     => esc_html__( 'Background Color', 'royal-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .royal-preview-card .rpc-card' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'card_padding',
            [
                'label'      => esc_html__( 'Padding', 'royal-addons-for-elementor' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors'  => [
                    '{{WRAPPER}} .royal-preview-card .rpc-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'card_border',
                'label'    => esc_html__( 'Border', 'royal-addons-for-elementor' ),
                'selector' => '{{WRAPPER}} .royal-preview-card .rpc-card',
            ]
        );

        $this->add_responsive_control(
            'card_border_radius',
            [
                'label'      => esc_html__( 'Border Radius', 'royal-addons-for-elementor' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors'  => [
                    '{{WRAPPER}} .royal-preview-card .rpc-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'card_box_shadow',
                'label'    => esc_html__( 'Box Shadow', 'royal-addons-for-elementor' ),
                'selector' => '{{WRAPPER}} .royal-preview-card .rpc-card',
            ]
        );

        $this->end_controls_section();

        // Image Style Settings
        $this->start_controls_section(
            'image_style_section',
            [
                'label'     => esc_html__( 'Image', 'royal-addons-for-elementor' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'card_style' => [ 'style-1', 'style-2' ],
                ],
            ]
        );

        $this->add_responsive_control(
            'image_width',
            [
                'label'       => esc_html__( 'Width', 'royal-addons-for-elementor' ),
                'type'        => Controls_Manager::SLIDER,
                'size_units'  => [ 'px', '%' ],
                'description' => 'Default: 100%',
                'range'       => [
                    'px' => [ 'min' => 0, 'max' => 1000, 'step' => 1 ],
                    '%'  => [ 'min' => 0, 'max' => 100 ],
                ],
                'default'     => [ 'unit' => '%', 'size' => 100 ],
                'selectors'   => [
                    '{{WRAPPER}} .image-card .image'               => 'width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .rpc-style-2 .rpc-image-wrap'     => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'image_height',
            [
                'label'       => esc_html__( 'Height', 'royal-addons-for-elementor' ),
                'type'        => Controls_Manager::SLIDER,
                'size_units'  => [ 'px', '%' ],
                'description' => 'Default: 230px',
                'range'       => [
                    'px' => [ 'min' => 0, 'max' => 1000, 'step' => 1 ],
                    '%'  => [ 'min' => 0, 'max' => 100 ],
                ],
                'default'     => [ 'unit' => 'px', 'size' => 230 ],
                'selectors'   => [
                    '{{WRAPPER}} .image-card .image'           => 'height: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .rpc-style-2 .rpc-image-wrap' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'image_border_radius',
            [
                'label'      => esc_html__( 'Border Radius', 'royal-addons-for-elementor' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors'  => [
                    '{{WRAPPER}} .image-card .image-wrapper'       => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .image-card .image-wrapper .image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .rpc-style-2 .rpc-image-wrap'     => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Icon Style Settings
        $this->start_controls_section(
            'icon_style_section',
            [
                'label'     => esc_html__( 'Icon Styling', 'royal-addons-for-elementor' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'card_style' => [ 'style-3', 'style-4', 'style-5', 'style-6', 'style-7', 'style-8', 'style-9', 'style-10', 'style-11' ],
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_font_size',
            [
                'label'      => esc_html__( 'Icon Size', 'royal-addons-for-elementor' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em' ],
                'range'      => [
                    'px' => [ 'min' => 10, 'max' => 100 ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .royal-preview-card .rpc-icon-box i'    => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .royal-preview-card .rpc-reg-icon i'     => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .royal-preview-card .rpc-float-ico i'    => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .royal-preview-card .rpc-stat-icon-box i' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'icon_custom_color',
            [
                'label'     => esc_html__( 'Icon Color', 'royal-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .royal-preview-card .rpc-icon-box'       => 'color: {{VALUE}};',
                    '{{WRAPPER}} .royal-preview-card .rpc-reg-icon'       => 'color: {{VALUE}};',
                    '{{WRAPPER}} .royal-preview-card .rpc-float-ico'      => 'color: {{VALUE}};',
                    '{{WRAPPER}} .royal-preview-card .rpc-stat-icon-box'  => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'icon_box_bg_color',
            [
                'label'     => esc_html__( 'Icon Box Background', 'royal-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .royal-preview-card .rpc-icon-box'      => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .royal-preview-card .rpc-reg-icon'      => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .royal-preview-card .rpc-float-ico'     => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .royal-preview-card .rpc-stat-icon-box' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Content Style Settings
        $this->start_controls_section(
            'content_style_section',
            [
                'label' => esc_html__( 'Content', 'royal-addons-for-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'content_title_heading',
            [
                'label'     => esc_html__( 'Title', 'royal-addons-for-elementor' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'content_title_color',
            [
                'label'     => esc_html__( 'Title Color', 'royal-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .image-card .title h2'            => 'color: {{VALUE}};',
                    '{{WRAPPER}} .royal-preview-card .rpc-title'  => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'content_title_typography',
                'label'    => esc_html__( 'Typography', 'royal-addons-for-elementor' ),
                'selector' => '{{WRAPPER}} .image-card .title h2, {{WRAPPER}} .royal-preview-card .rpc-title',
            ]
        );

        $this->add_control(
            'content_desc_heading',
            [
                'label'     => esc_html__( 'Description', 'royal-addons-for-elementor' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'content_description_color',
            [
                'label'     => esc_html__( 'Description Color', 'royal-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .image-card .excerpt'                     => 'color: {{VALUE}};',
                    '{{WRAPPER}} .royal-preview-card .rpc-desc'            => 'color: {{VALUE}};',
                    '{{WRAPPER}} .royal-preview-card .rpc-stat-desc'       => 'color: {{VALUE}};',
                    '{{WRAPPER}} .royal-preview-card .rpc-address'         => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'content_description_typography',
                'label'    => esc_html__( 'Typography', 'royal-addons-for-elementor' ),
                'selector' => '{{WRAPPER}} .image-card .excerpt, {{WRAPPER}} .royal-preview-card .rpc-desc, {{WRAPPER}} .royal-preview-card .rpc-stat-desc',
            ]
        );

        $this->end_controls_section();

        // Divider Style Settings
        $this->start_controls_section(
            'divider_style_section',
            [
                'label'     => esc_html__( 'Divider', 'royal-addons-for-elementor' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_divider' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'divider_backgorund_color',
            [
                'label'     => esc_html__( 'Background Color', 'royal-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => 'rgba( 0,0,0,0.05 )',
                'selectors' => [
                    '{{WRAPPER}} .image-card .divider'               => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .royal-preview-card .rpc-divider'   => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Badge & Highlight Style
        $this->start_controls_section(
            'top_badge_style_section',
            [
                'label' => esc_html__( 'Badges & Highlights', 'royal-addons-for-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'top_badge_backgorund_color',
            [
                'label'     => esc_html__( 'Badge Background Color', 'royal-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .image-card .image .top-price-badge'    => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .royal-preview-card .rpc-badge'         => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .royal-preview-card .rpc-badge-gold'    => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .royal-preview-card .rpc-badge-emerald' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .royal-preview-card .rpc-step-num'      => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'top_badge_text_color',
            [
                'label'     => esc_html__( 'Badge Text Color', 'royal-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .image-card .image .top-price-badge'    => 'color: {{VALUE}};',
                    '{{WRAPPER}} .royal-preview-card .rpc-badge'         => 'color: {{VALUE}};',
                    '{{WRAPPER}} .royal-preview-card .rpc-badge-gold'    => 'color: {{VALUE}};',
                    '{{WRAPPER}} .royal-preview-card .rpc-badge-emerald' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .royal-preview-card .rpc-step-num'      => 'color: {{VALUE}};',
                    '{{WRAPPER}} .royal-preview-card .rpc-footer-note'   => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Button Style Settings
        $this->start_controls_section(
            'buy_button_style_section',
            [
                'label' => esc_html__( 'Action & Button', 'royal-addons-for-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs( 'buy_button_style_tabs' );

        $this->start_controls_tab(
            'buy_button_normal_state',
            [ 'label' => esc_html__( 'Normal', 'royal-addons-for-elementor' ) ]
        );

        $this->add_control(
            'but_button_normal_bg_color',
            [
                'label'     => esc_html__( 'Background Color', 'royal-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .image-card .readmore a.button-readmore' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .royal-preview-card .rpc-link-btn'       => 'color: {{VALUE}};',
                    '{{WRAPPER}} .royal-preview-card .rpc-pill-link'      => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'but_button_normal_text_color',
            [
                'label'     => esc_html__( 'Text Color', 'royal-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .image-card .readmore a.button-readmore' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .royal-preview-card .rpc-link-btn'       => 'color: {{VALUE}};',
                    '{{WRAPPER}} .royal-preview-card .rpc-pill-link'      => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'buy_button_hover_state',
            [ 'label' => esc_html__( 'Hover', 'royal-addons-for-elementor' ) ]
        );

        $this->add_control(
            'but_button_hover_bg_color',
            [
                'label'     => esc_html__( 'Background Color', 'royal-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .image-card .readmore a.button-readmore:hover' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .royal-preview-card .rpc-pill-link:hover'      => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'but_button_hover_text_color',
            [
                'label'     => esc_html__( 'Text Color', 'royal-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .image-card .readmore a.button-readmore:hover' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .royal-preview-card .rpc-link-btn:hover'       => 'color: {{VALUE}};',
                    '{{WRAPPER}} .royal-preview-card .rpc-pill-link:hover'      => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'buy_button_typography',
                'label'    => esc_html__( 'Typography', 'royal-addons-for-elementor' ),
                'selector' => '{{WRAPPER}} .image-card .readmore a.button-readmore, {{WRAPPER}} .royal-preview-card .rpc-link-btn, {{WRAPPER}} .royal-preview-card .rpc-pill-link',
            ]
        );

        $this->end_controls_section();
    }

    protected function render_card_icon( $icon_setting, $fallback_class = 'fas fa-star' ) {
        if ( ! empty( $icon_setting['value'] ) ) {
            Icons_Manager::render_icon( $icon_setting, [ 'aria-hidden' => 'true' ] );
        } else {
            echo '<i class="' . esc_attr( $fallback_class ) . '" aria-hidden="true"></i>';
        }
    }

    protected function render_social_platform_icon( $network, $custom_icon = [] ) {
        switch ( $network ) {
            case 'facebook':
                echo '<i class="fab fa-facebook-f" aria-hidden="true"></i>';
                break;
            case 'youtube':
                echo '<i class="fab fa-youtube" aria-hidden="true"></i>';
                break;
            case 'linkedin':
                echo '<i class="fab fa-linkedin-in" aria-hidden="true"></i>';
                break;
            case 'twitter':
                echo '<i class="fab fa-x-twitter" aria-hidden="true"></i>';
                break;
            case 'whatsapp':
                echo '<i class="fab fa-whatsapp" aria-hidden="true"></i>';
                break;
            default:
                if ( ! empty( $custom_icon['value'] ) ) {
                    Icons_Manager::render_icon( $custom_icon, [ 'aria-hidden' => 'true' ] );
                } else {
                    echo '<i class="fas fa-share-alt" aria-hidden="true"></i>';
                }
                break;
        }
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $card_style = ! empty( $settings['card_style'] ) ? $settings['card_style'] : 'style-1';
        $accent_color = ! empty( $settings['card_accent_color'] ) ? $settings['card_accent_color'] : '#0b4d26';

        // Targets & links
        $image_target   = ! empty( $settings['image_link']['is_external'] ) ? ' target="_blank"' : '';
        $image_nofollow = ! empty( $settings['image_link']['nofollow'] ) ? ' rel="nofollow"' : '';
        $button_target  = ! empty( $settings['button_link']['is_external'] ) ? ' target="_blank"' : '';
        $button_nofollow= ! empty( $settings['button_link']['nofollow'] ) ? ' rel="nofollow"' : '';

        // Inline editing attributes
        $this->add_inline_editing_attributes( 'card_title', 'none' );
        $this->add_inline_editing_attributes( 'item_description', 'advanced' );
        ?>
        <div class="royal-preview-card rpc-<?php echo esc_attr( $card_style ); ?>" style="--rpc-accent: <?php echo esc_attr( $accent_color ); ?>;">

            <?php if ( 'style-1' === $card_style ) : ?>
                <!-- STYLE 1: Classic Price Card -->
                <div class="image-card">
                    <div class="image-wrapper">
                        <div class="image" style="background-image: url(<?php echo esc_url( $settings['image']['url'] ); ?>);">
                            <?php if ( 'yes' === $settings['show_image_link'] && ! empty( $settings['image_link']['url'] ) ) : ?>
                                <a href="<?php echo esc_url( $settings['image_link']['url'] ); ?>" <?php echo $image_target; ?> <?php echo $image_nofollow; ?>></a>
                            <?php endif; ?>
                            <?php if ( 'yes' === $settings['show_top_badge'] ) : ?>
                                <span class="top-price-badge badge-blue"><?php echo esc_html( $settings['top_badge_text'] ); ?></span>
                            <?php endif; ?>
                            <?php if ( 'yes' === $settings['show_middle_badge'] ) : ?>
                                <span class="middle-price-badge badge-blue"><?php echo esc_html( $settings['middle_badge_text'] ); ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="content">
                        <div class="title">
                            <h2 <?php echo $this->get_render_attribute_string( 'card_title' ); ?>><?php echo esc_html( $settings['card_title'] ); ?></h2>
                        </div>
                        <?php if ( 'yes' === $settings['show_divider'] ) : ?>
                            <div class="divider"></div>
                        <?php endif; ?>
                        <div class="excerpt">
                            <div <?php echo $this->get_render_attribute_string( 'item_description' ); ?>>
                                <?php echo $settings['item_description']; ?>
                            </div>
                        </div>
                        <div class="readmore">
                            <?php if ( ! empty( $settings['button_text'] ) ) : ?>
                                <a href="<?php echo esc_url( $settings['button_link']['url'] ); ?>" <?php echo $button_target; ?> <?php echo $button_nofollow; ?> class="button button-readmore"><?php echo esc_html( $settings['button_text'] ); ?></a>
                            <?php endif; ?>
                            <?php if ( 'yes' === $settings['show_bottom_badge'] ) : ?>
                                <span class="bottom-price-badge badge-blue"><?php echo esc_html( $settings['bottom_badge_text'] ); ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

            <?php elseif ( 'style-2' === $card_style ) : ?>
                <!-- STYLE 2: Program Card with Checklist & Arrow Link (CreedBD) -->
                <div class="rpc-card rpc-style-2">
                    <div class="rpc-image-wrap">
                        <?php if ( ! empty( $settings['image']['url'] ) ) : ?>
                            <img src="<?php echo esc_url( $settings['image']['url'] ); ?>" alt="<?php echo esc_attr( $settings['card_title'] ); ?>">
                        <?php endif; ?>
                        <?php if ( 'yes' === $settings['show_image_link'] && ! empty( $settings['image_link']['url'] ) ) : ?>
                            <a href="<?php echo esc_url( $settings['image_link']['url'] ); ?>" <?php echo $image_target; ?> <?php echo $image_nofollow; ?> class="rpc-img-overlay-link"></a>
                        <?php endif; ?>
                        <?php if ( ! empty( $settings['badge_text'] ) ) : ?>
                            <span class="rpc-badge"><?php echo esc_html( $settings['badge_text'] ); ?></span>
                        <?php endif; ?>
                    </div>
                    <div class="rpc-body">
                        <h3 class="rpc-title" <?php echo $this->get_render_attribute_string( 'card_title' ); ?>><?php echo esc_html( $settings['card_title'] ); ?></h3>
                        <?php if ( ! empty( $settings['item_description'] ) ) : ?>
                            <div class="rpc-desc" <?php echo $this->get_render_attribute_string( 'item_description' ); ?>>
                                <?php echo $settings['item_description']; ?>
                            </div>
                        <?php endif; ?>
                        <?php if ( ! empty( $settings['checklist_items'] ) && is_array( $settings['checklist_items'] ) ) : ?>
                            <ul class="rpc-checklist">
                                <?php foreach ( $settings['checklist_items'] as $item ) : ?>
                                    <?php if ( ! empty( $item['item_text'] ) ) : ?>
                                        <li>
                                            <span class="rpc-check-icon">&#10003;</span>
                                            <span><?php echo esc_html( $item['item_text'] ); ?></span>
                                        </li>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </div>
                    <?php if ( 'yes' === $settings['show_button'] && ! empty( $settings['button_text'] ) ) : ?>
                        <div class="rpc-footer">
                            <a href="<?php echo esc_url( $settings['button_link']['url'] ); ?>" <?php echo $button_target; ?> <?php echo $button_nofollow; ?> class="rpc-link-btn">
                                <span><?php echo esc_html( $settings['button_text'] ); ?></span>
                                <span class="rpc-link-arrow">&rarr;</span>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>

            <?php elseif ( 'style-3' === $card_style ) : ?>
                <!-- STYLE 3: Minimal Feature Icon Card (CreedBD) -->
                <div class="rpc-card rpc-style-3">
                    <?php if ( ! empty( $settings['button_link']['url'] ) ) : ?>
                        <a href="<?php echo esc_url( $settings['button_link']['url'] ); ?>" <?php echo $button_target; ?> <?php echo $button_nofollow; ?> class="rpc-card-cover-link"></a>
                    <?php endif; ?>
                    <div class="rpc-icon-box">
                        <?php $this->render_card_icon( $settings['card_icon'], 'fas fa-hand-holding-usd' ); ?>
                    </div>
                    <h4 class="rpc-title" <?php echo $this->get_render_attribute_string( 'card_title' ); ?>><?php echo esc_html( $settings['card_title'] ); ?></h4>
                    <?php if ( ! empty( $settings['item_description'] ) ) : ?>
                        <div class="rpc-desc" <?php echo $this->get_render_attribute_string( 'item_description' ); ?>>
                            <?php echo $settings['item_description']; ?>
                        </div>
                    <?php endif; ?>
                </div>

            <?php elseif ( 'style-4' === $card_style ) : ?>
                <!-- STYLE 4: Process Step Card - Dark Forest Mode (CreedBD) -->
                <div class="rpc-card rpc-style-4">
                    <div>
                        <div class="rpc-top-row">
                            <span class="rpc-step-num"><?php echo esc_html( $settings['step_number'] ); ?></span>
                            <div class="rpc-corner-icon">
                                <?php $this->render_card_icon( $settings['secondary_icon'], 'far fa-lightbulb' ); ?>
                            </div>
                        </div>
                        <h4 class="rpc-title" <?php echo $this->get_render_attribute_string( 'card_title' ); ?>><?php echo esc_html( $settings['card_title'] ); ?></h4>
                        <?php if ( ! empty( $settings['item_description'] ) ) : ?>
                            <div class="rpc-desc" <?php echo $this->get_render_attribute_string( 'item_description' ); ?>>
                                <?php echo $settings['item_description']; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div>
                        <?php if ( 'yes' === $settings['show_divider'] ) : ?>
                            <div class="rpc-divider"></div>
                        <?php endif; ?>
                        <?php if ( ! empty( $settings['footer_note'] ) ) : ?>
                            <div class="rpc-footer-note"><?php echo esc_html( $settings['footer_note'] ); ?></div>
                        <?php endif; ?>
                    </div>
                </div>

            <?php elseif ( 'style-5' === $card_style ) : ?>
                <!-- STYLE 5: Process Step Card - Light Mode (CreedBD) -->
                <div class="rpc-card rpc-style-5">
                    <div>
                        <div class="rpc-top-row">
                            <span class="rpc-step-num"><?php echo esc_html( $settings['step_number'] ); ?></span>
                            <div class="rpc-corner-icon">
                                <?php $this->render_card_icon( $settings['secondary_icon'], 'fas fa-calendar-check' ); ?>
                            </div>
                        </div>
                        <h4 class="rpc-title" <?php echo $this->get_render_attribute_string( 'card_title' ); ?>><?php echo esc_html( $settings['card_title'] ); ?></h4>
                        <?php if ( ! empty( $settings['item_description'] ) ) : ?>
                            <div class="rpc-desc" <?php echo $this->get_render_attribute_string( 'item_description' ); ?>>
                                <?php echo $settings['item_description']; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div>
                        <?php if ( 'yes' === $settings['show_divider'] ) : ?>
                            <div class="rpc-divider"></div>
                        <?php endif; ?>
                        <?php if ( ! empty( $settings['footer_note'] ) ) : ?>
                            <div class="rpc-footer-note"><?php echo esc_html( $settings['footer_note'] ); ?></div>
                        <?php endif; ?>
                    </div>
                </div>

            <?php elseif ( 'style-6' === $card_style ) : ?>
                <!-- STYLE 6: Branch & HQ Card - Dark Mode (CreedBD) -->
                <div class="rpc-card rpc-style-6">
                    <div>
                        <div class="rpc-top-row">
                            <?php if ( ! empty( $settings['badge_text'] ) ) : ?>
                                <span class="rpc-badge-gold"><?php echo esc_html( $settings['badge_text'] ); ?></span>
                            <?php endif; ?>
                            <div class="rpc-corner-icon">
                                <?php $this->render_card_icon( $settings['secondary_icon'], 'fas fa-building' ); ?>
                            </div>
                        </div>
                        <h3 class="rpc-title" <?php echo $this->get_render_attribute_string( 'card_title' ); ?>><?php echo esc_html( $settings['card_title'] ); ?></h3>
                        <?php if ( ! empty( $settings['card_subtitle'] ) ) : ?>
                            <div class="rpc-address"><?php echo esc_html( $settings['card_subtitle'] ); ?></div>
                        <?php endif; ?>
                        <?php if ( ! empty( $settings['info_rows'] ) && is_array( $settings['info_rows'] ) ) : ?>
                            <ul class="rpc-info-list">
                                <?php foreach ( $settings['info_rows'] as $row ) : ?>
                                    <li>
                                        <?php if ( ! empty( $row['row_icon']['value'] ) ) : ?>
                                        <span class="rpc-info-icon">
                                            <?php $this->render_card_icon( $row['row_icon'] ); ?>
                                        </span>
                                        <?php endif; ?>
                                        <?php if ( ! empty( $row['row_link']['url'] ) ) : ?>
                                            <a href="<?php echo esc_url( $row['row_link']['url'] ); ?>"><?php echo esc_html( $row['row_value'] ); ?></a>
                                        <?php else : ?>
                                            <span><?php echo esc_html( $row['row_value'] ); ?></span>
                                        <?php endif; ?>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </div>
                    <div>
                        <?php if ( 'yes' === $settings['show_divider'] ) : ?>
                            <div class="rpc-divider"></div>
                        <?php endif; ?>
                        <?php if ( ! empty( $settings['footer_note'] ) ) : ?>
                            <div class="rpc-footer-note"><?php echo esc_html( $settings['footer_note'] ); ?></div>
                        <?php endif; ?>
                    </div>
                </div>

            <?php elseif ( 'style-7' === $card_style ) : ?>
                <!-- STYLE 7: Branch & Hub Card - Light Mode (CreedBD) -->
                <div class="rpc-card rpc-style-7">
                    <div>
                        <div class="rpc-top-row">
                            <?php if ( ! empty( $settings['badge_text'] ) ) : ?>
                                <span class="rpc-badge-emerald"><?php echo esc_html( $settings['badge_text'] ); ?></span>
                            <?php endif; ?>
                            <div class="rpc-corner-icon">
                                <?php $this->render_card_icon( $settings['secondary_icon'], 'fas fa-map-marker-alt' ); ?>
                            </div>
                        </div>
                        <h3 class="rpc-title" <?php echo $this->get_render_attribute_string( 'card_title' ); ?>><?php echo esc_html( $settings['card_title'] ); ?></h3>
                        <?php if ( ! empty( $settings['card_subtitle'] ) ) : ?>
                            <div class="rpc-address"><?php echo esc_html( $settings['card_subtitle'] ); ?></div>
                        <?php endif; ?>
                        <?php if ( ! empty( $settings['info_rows'] ) && is_array( $settings['info_rows'] ) ) : ?>
                            <ul class="rpc-info-list">
                                <?php foreach ( $settings['info_rows'] as $row ) : ?>
                                    <li>
                                        <?php if ( ! empty( $row['row_icon']['value'] ) ) : ?>
                                        <span class="rpc-info-icon">
                                            <?php $this->render_card_icon( $row['row_icon'] ); ?>
                                        </span>
                                        <?php endif; ?>
                                        <?php if ( ! empty( $row['row_label'] ) ) : ?>
                                            <strong><?php echo esc_html( $row['row_label'] ); ?>:</strong>
                                        <?php endif; ?>
                                        <?php if ( ! empty( $row['row_link']['url'] ) ) : ?>
                                            <a href="<?php echo esc_url( $row['row_link']['url'] ); ?>"><?php echo esc_html( $row['row_value'] ); ?></a>
                                        <?php else : ?>
                                            <span><?php echo esc_html( $row['row_value'] ); ?></span>
                                        <?php endif; ?>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </div>
                    <div>
                        <?php if ( 'yes' === $settings['show_divider'] ) : ?>
                            <div class="rpc-divider"></div>
                        <?php endif; ?>
                        <?php if ( ! empty( $settings['footer_note'] ) ) : ?>
                            <div class="rpc-footer-note"><?php echo esc_html( $settings['footer_note'] ); ?></div>
                        <?php endif; ?>
                    </div>
                </div>

            <?php elseif ( 'style-8' === $card_style ) : ?>
                <!-- STYLE 8: Registration & Legal Info Card (Unnayan Prochesta `ab-reg`) -->
                <div class="rpc-card rpc-style-8">
                    <span class="rpc-shine"></span>
                    <div class="rpc-reg-inner">
                        <div class="rpc-reg-icon">
                            <?php $this->render_card_icon( $settings['card_icon'], 'far fa-id-card' ); ?>
                        </div>
                        <div class="rpc-reg-content">
                            <h3 class="rpc-title" <?php echo $this->get_render_attribute_string( 'card_title' ); ?>><?php echo esc_html( $settings['card_title'] ); ?></h3>
                            <?php if ( ! empty( $settings['info_rows'] ) && is_array( $settings['info_rows'] ) ) : ?>
                                <dl class="rpc-dl-list">
                                    <?php foreach ( $settings['info_rows'] as $row ) : ?>
                                        <div class="rpc-dl-row">
                                            <dt><?php echo esc_html( $row['row_label'] ); ?></dt>
                                            <dd><?php echo esc_html( $row['row_value'] ); ?></dd>
                                        </div>
                                    <?php endforeach; ?>
                                </dl>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

            <?php elseif ( 'style-9' === $card_style ) : ?>
                <!-- STYLE 9: Modern Contact Card with Floating Icon & Glow Dash Ring (Unnayan Prochesta `ct-card`) -->
                <div class="rpc-card rpc-style-9">
                    <span class="rpc-shine"></span>
                    <div class="rpc-accent-bar"></div>
                    <div class="rpc-glow-circle"></div>
                    <div class="rpc-float-ico">
                        <?php $this->render_card_icon( $settings['card_icon'], 'fas fa-envelope' ); ?>
                        <span class="rpc-dashed-ring"></span>
                    </div>
                    <h5 class="rpc-title" <?php echo $this->get_render_attribute_string( 'card_title' ); ?>><?php echo esc_html( $settings['card_title'] ); ?></h5>
                    <?php if ( ! empty( $settings['info_rows'] ) && is_array( $settings['info_rows'] ) ) : ?>
                        <div class="rpc-contact-pills">
                            <?php foreach ( $settings['info_rows'] as $row ) : ?>
                                <?php
                                $row_target = ! empty( $row['row_link']['is_external'] ) ? ' target="_blank"' : '';
                                $row_url = ! empty( $row['row_link']['url'] ) ? $row['row_link']['url'] : ( strpos( $row['row_value'], '@' ) !== false ? 'mailto:' . $row['row_value'] : '#' );
                                ?>
                                <a href="<?php echo esc_url( $row_url ); ?>" <?php echo $row_target; ?> class="rpc-pill-link">
                                    <?php if ( ! empty( $row['row_icon']['value'] ) ) : ?>
                                    <span class="rpc-pill-icon">
                                        <?php $this->render_card_icon( $row['row_icon'] ); ?>
                                    </span>
                                    <?php endif; ?>
                                    <span><?php echo esc_html( $row['row_value'] ); ?></span>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>

            <?php elseif ( 'style-10' === $card_style ) : ?>
                <!-- STYLE 10: Social Media & Follow Card with Glow Dash Ring (Unnayan Prochesta `ct-card`) -->
                <div class="rpc-card rpc-style-10">
                    <span class="rpc-shine"></span>
                    <div class="rpc-accent-bar"></div>
                    <div class="rpc-glow-circle"></div>
                    <div class="rpc-float-ico">
                        <?php $this->render_card_icon( $settings['card_icon'], 'fas fa-share-alt' ); ?>
                        <span class="rpc-dashed-ring"></span>
                    </div>
                    <h5 class="rpc-title" <?php echo $this->get_render_attribute_string( 'card_title' ); ?>><?php echo esc_html( $settings['card_title'] ); ?></h5>
                    <?php if ( ! empty( $settings['social_links'] ) && is_array( $settings['social_links'] ) ) : ?>
                        <div class="rpc-social-buttons">
                            <?php foreach ( $settings['social_links'] as $item ) : ?>
                                <?php
                                $platform = ! empty( $item['social_platform'] ) ? $item['social_platform'] : 'facebook';
                                $class_map = [
                                    'facebook' => 'rpc-soc-fb',
                                    'youtube'  => 'rpc-soc-yt',
                                    'linkedin' => 'rpc-soc-in',
                                    'twitter'  => 'rpc-soc-tw',
                                    'whatsapp' => 'rpc-soc-wa',
                                ];
                                $btn_class = isset( $class_map[ $platform ] ) ? $class_map[ $platform ] : 'rpc-soc-fb';
                                $soc_url = ! empty( $item['social_url']['url'] ) ? $item['social_url']['url'] : '#';
                                $soc_target = ! empty( $item['social_url']['is_external'] ) ? ' target="_blank"' : '';
                                ?>
                                <a href="<?php echo esc_url( $soc_url ); ?>" <?php echo $soc_target; ?> class="rpc-soc-btn <?php echo esc_attr( $btn_class ); ?>" aria-label="<?php echo esc_attr( $platform ); ?>">
                                    <?php $this->render_social_platform_icon( $platform, $item['social_icon'] ?? [] ); ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>

            <?php elseif ( 'style-11' === $card_style ) : ?>
                <!-- STYLE 11: Impact & Stat Metric Card (CreedBD) -->
                <div class="rpc-card rpc-style-11">
                    <div class="rpc-stat-icon-box">
                        <?php $this->render_card_icon( $settings['card_icon'], 'fas fa-coins' ); ?>
                    </div>
                    <div class="rpc-stat-value">
                        <?php if ( ! empty( $settings['metric_prefix'] ) ) : ?>
                            <span class="rpc-stat-prefix"><?php echo esc_html( $settings['metric_prefix'] ); ?></span>
                        <?php endif; ?>
                        <span class="rpc-stat-number"><?php echo esc_html( $settings['metric_number'] ); ?></span>
                        <?php if ( ! empty( $settings['metric_suffix'] ) ) : ?>
                            <span class="rpc-stat-suffix"><?php echo esc_html( $settings['metric_suffix'] ); ?></span>
                        <?php endif; ?>
                    </div>
                    <h4 class="rpc-stat-title" <?php echo $this->get_render_attribute_string( 'card_title' ); ?>><?php echo esc_html( $settings['card_title'] ); ?></h4>
                    <?php if ( ! empty( $settings['item_description'] ) ) : ?>
                        <div class="rpc-stat-desc" <?php echo $this->get_render_attribute_string( 'item_description' ); ?>>
                            <?php echo $settings['item_description']; ?>
                        </div>
                    <?php endif; ?>
                </div>

            <?php endif; ?>

        </div>
        <?php
    }

    protected function content_template() {
        ?>
        <#
        var card_style = settings.card_style || 'style-1';
        var accent_color = settings.card_accent_color || '#0b4d26';

        var image_target = settings.image_link && settings.image_link.is_external ? ' target="_blank"' : '';
        var image_nofollow = settings.image_link && settings.image_link.nofollow ? ' rel="nofollow"' : '';

        var link_target = settings.button_link && settings.button_link.is_external ? ' target="_blank"' : '';
        var link_nofollow = settings.button_link && settings.button_link.nofollow ? ' rel="nofollow"' : '';

        view.addInlineEditingAttributes( 'card_title', 'none' );
        view.addInlineEditingAttributes( 'item_description', 'none' );

        var renderIcon = function( iconSetting, fallbackClass ) {
            if ( iconSetting && iconSetting.value ) {
                var iconHTML = elementor.helpers.renderIcon( view, iconSetting, { 'aria-hidden': true }, 'i', 'object' );
                if ( iconHTML && iconHTML.rendered ) {
                    print( iconHTML.value );
                    return;
                }
            }
            print( '<i class="' + fallbackClass + '" aria-hidden="true"></i>' );
        };

        var renderSocialIcon = function( network, customIcon ) {
            if ( network === 'facebook' ) {
                print( '<i class="fab fa-facebook-f" aria-hidden="true"></i>' );
            } else if ( network === 'youtube' ) {
                print( '<i class="fab fa-youtube" aria-hidden="true"></i>' );
            } else if ( network === 'linkedin' ) {
                print( '<i class="fab fa-linkedin-in" aria-hidden="true"></i>' );
            } else if ( network === 'twitter' ) {
                print( '<i class="fab fa-x-twitter" aria-hidden="true"></i>' );
            } else if ( network === 'whatsapp' ) {
                print( '<i class="fab fa-whatsapp" aria-hidden="true"></i>' );
            } else {
                renderIcon( customIcon, 'fas fa-share-alt' );
            }
        };
        #>
        <div class="royal-preview-card rpc-{{ card_style }}" style="--rpc-accent: {{ accent_color }};">

            <# if ( 'style-1' === card_style ) { #>
                <div class="image-card">
                    <div class="image-wrapper">
                        <div class="image" style="background-image: url({{ settings.image.url }});">
                            <# if( 'yes' === settings.show_image_link && settings.image_link && settings.image_link.url ) { #>
                                <a href="{{ settings.image_link.url }}" {{ image_target }} {{ image_nofollow }}></a>
                            <# } #>
                            <# if( 'yes' === settings.show_top_badge ) { #>
                                <span class="top-price-badge badge-blue">{{{ settings.top_badge_text }}}</span>
                            <# } #>
                            <# if( 'yes' === settings.show_middle_badge ) { #>
                                <span class="middle-price-badge badge-blue">{{{ settings.middle_badge_text }}}</span>
                            <# } #>
                        </div>
                    </div>
                    <div class="content">
                        <div class="title">
                            <h2 {{{ view.getRenderAttributeString( 'card_title' ) }}} >{{{ settings.card_title }}}</h2>
                        </div>
                        <# if( 'yes' === settings.show_divider ) { #>
                            <div class="divider"></div>
                        <# } #>
                        <div class="excerpt">
                            <div {{{ view.getRenderAttributeString( 'item_description' ) }}}>
                                {{{ settings.item_description }}}
                            </div>
                        </div>
                        <div class="readmore">
                            <# if( settings.button_text ) { #>
                                <a href="{{ settings.button_link.url }}" {{ link_target }} {{ link_nofollow }} class="button button-readmore">{{{ settings.button_text }}}</a>
                            <# } #>
                            <# if( 'yes' === settings.show_bottom_badge ) { #>
                                <span class="bottom-price-badge badge-blue">{{{ settings.bottom_badge_text }}}</span>
                            <# } #>
                        </div>
                    </div>
                </div>

            <# } else if ( 'style-2' === card_style ) { #>
                <div class="rpc-card rpc-style-2">
                    <div class="rpc-image-wrap">
                        <# if ( settings.image && settings.image.url ) { #>
                            <img src="{{ settings.image.url }}" alt="{{ settings.card_title }}">
                        <# } #>
                        <# if ( 'yes' === settings.show_image_link && settings.image_link && settings.image_link.url ) { #>
                            <a href="{{ settings.image_link.url }}" {{ image_target }} class="rpc-img-overlay-link"></a>
                        <# } #>
                        <# if ( settings.badge_text ) { #>
                            <span class="rpc-badge">{{{ settings.badge_text }}}</span>
                        <# } #>
                    </div>
                    <div class="rpc-body">
                        <h3 class="rpc-title" {{{ view.getRenderAttributeString( 'card_title' ) }}}>{{{ settings.card_title }}}</h3>
                        <# if ( settings.item_description ) { #>
                            <div class="rpc-desc" {{{ view.getRenderAttributeString( 'item_description' ) }}}>
                                {{{ settings.item_description }}}
                            </div>
                        <# } #>
                        <# if ( settings.checklist_items && settings.checklist_items.length ) { #>
                            <ul class="rpc-checklist">
                                <# _.each( settings.checklist_items, function( item ) { #>
                                    <# if ( item.item_text ) { #>
                                        <li>
                                            <span class="rpc-check-icon">&#10003;</span>
                                            <span>{{{ item.item_text }}}</span>
                                        </li>
                                    <# } #>
                                <# }); #>
                            </ul>
                        <# } #>
                    </div>
                    <# if ( 'yes' === settings.show_button && settings.button_text ) { #>
                        <div class="rpc-footer">
                            <a href="{{ settings.button_link.url }}" {{ link_target }} class="rpc-link-btn">
                                <span>{{{ settings.button_text }}}</span>
                                <span class="rpc-link-arrow">&rarr;</span>
                            </a>
                        </div>
                    <# } #>
                </div>

            <# } else if ( 'style-3' === card_style ) { #>
                <div class="rpc-card rpc-style-3">
                    <# if ( settings.button_link && settings.button_link.url ) { #>
                        <a href="{{ settings.button_link.url }}" {{ link_target }} class="rpc-card-cover-link"></a>
                    <# } #>
                    <div class="rpc-icon-box">
                        <# renderIcon( settings.card_icon, 'fas fa-hand-holding-usd' ); #>
                    </div>
                    <h4 class="rpc-title" {{{ view.getRenderAttributeString( 'card_title' ) }}}>{{{ settings.card_title }}}</h4>
                    <# if ( settings.item_description ) { #>
                        <div class="rpc-desc" {{{ view.getRenderAttributeString( 'item_description' ) }}}>
                            {{{ settings.item_description }}}
                        </div>
                    <# } #>
                </div>

            <# } else if ( 'style-4' === card_style ) { #>
                <div class="rpc-card rpc-style-4">
                    <div>
                        <div class="rpc-top-row">
                            <span class="rpc-step-num">{{{ settings.step_number }}}</span>
                            <div class="rpc-corner-icon">
                                <# renderIcon( settings.secondary_icon, 'far fa-lightbulb' ); #>
                            </div>
                        </div>
                        <h4 class="rpc-title" {{{ view.getRenderAttributeString( 'card_title' ) }}}>{{{ settings.card_title }}}</h4>
                        <# if ( settings.item_description ) { #>
                            <div class="rpc-desc" {{{ view.getRenderAttributeString( 'item_description' ) }}}>
                                {{{ settings.item_description }}}
                            </div>
                        <# } #>
                    </div>
                    <div>
                        <# if ( 'yes' === settings.show_divider ) { #>
                            <div class="rpc-divider"></div>
                        <# } #>
                        <# if ( settings.footer_note ) { #>
                            <div class="rpc-footer-note">{{{ settings.footer_note }}}</div>
                        <# } #>
                    </div>
                </div>

            <# } else if ( 'style-5' === card_style ) { #>
                <div class="rpc-card rpc-style-5">
                    <div>
                        <div class="rpc-top-row">
                            <span class="rpc-step-num">{{{ settings.step_number }}}</span>
                            <div class="rpc-corner-icon">
                                <# renderIcon( settings.secondary_icon, 'fas fa-calendar-check' ); #>
                            </div>
                        </div>
                        <h4 class="rpc-title" {{{ view.getRenderAttributeString( 'card_title' ) }}}>{{{ settings.card_title }}}</h4>
                        <# if ( settings.item_description ) { #>
                            <div class="rpc-desc" {{{ view.getRenderAttributeString( 'item_description' ) }}}>
                                {{{ settings.item_description }}}
                            </div>
                        <# } #>
                    </div>
                    <div>
                        <# if ( 'yes' === settings.show_divider ) { #>
                            <div class="rpc-divider"></div>
                        <# } #>
                        <# if ( settings.footer_note ) { #>
                            <div class="rpc-footer-note">{{{ settings.footer_note }}}</div>
                        <# } #>
                    </div>
                </div>

            <# } else if ( 'style-6' === card_style ) { #>
                <div class="rpc-card rpc-style-6">
                    <div>
                        <div class="rpc-top-row">
                            <# if ( settings.badge_text ) { #>
                                <span class="rpc-badge-gold">{{{ settings.badge_text }}}</span>
                            <# } #>
                            <div class="rpc-corner-icon">
                                <# renderIcon( settings.secondary_icon, 'fas fa-building' ); #>
                            </div>
                        </div>
                        <h3 class="rpc-title" {{{ view.getRenderAttributeString( 'card_title' ) }}}>{{{ settings.card_title }}}</h3>
                        <# if ( settings.card_subtitle ) { #>
                            <div class="rpc-address">{{{ settings.card_subtitle }}}</div>
                        <# } #>
                        <# if ( settings.info_rows && settings.info_rows.length ) { #>
                            <ul class="rpc-info-list">
                                <# _.each( settings.info_rows, function( row ) { #>
                                    <li>
                                        <# if ( row.row_icon && row.row_icon.value ) { #>
                                        <span class="rpc-info-icon">
                                            <# renderIcon( row.row_icon ); #>
                                        </span>
                                        <# } #>
                                        <# if ( row.row_link && row.row_link.url ) { #>
                                            <a href="{{ row.row_link.url }}">{{{ row.row_value }}}</a>
                                        <# } else { #>
                                            <span>{{{ row.row_value }}}</span>
                                        <# } #>
                                    </li>
                                <# }); #>
                            </ul>
                        <# } #>
                    </div>
                    <div>
                        <# if ( 'yes' === settings.show_divider ) { #>
                            <div class="rpc-divider"></div>
                        <# } #>
                        <# if ( settings.footer_note ) { #>
                            <div class="rpc-footer-note">{{{ settings.footer_note }}}</div>
                        <# } #>
                    </div>
                </div>

            <# } else if ( 'style-7' === card_style ) { #>
                <div class="rpc-card rpc-style-7">
                    <div>
                        <div class="rpc-top-row">
                            <# if ( settings.badge_text ) { #>
                                <span class="rpc-badge-emerald">{{{ settings.badge_text }}}</span>
                            <# } #>
                            <div class="rpc-corner-icon">
                                <# renderIcon( settings.secondary_icon, 'fas fa-map-marker-alt' ); #>
                            </div>
                        </div>
                        <h3 class="rpc-title" {{{ view.getRenderAttributeString( 'card_title' ) }}}>{{{ settings.card_title }}}</h3>
                        <# if ( settings.card_subtitle ) { #>
                            <div class="rpc-address">{{{ settings.card_subtitle }}}</div>
                        <# } #>
                        <# if ( settings.info_rows && settings.info_rows.length ) { #>
                            <ul class="rpc-info-list">
                                <# _.each( settings.info_rows, function( row ) { #>
                                    <li>
                                        <# if ( row.row_icon && row.row_icon.value ) { #>
                                        <span class="rpc-info-icon">
                                            <# renderIcon( row.row_icon ); #>
                                        </span>
                                        <# } #>
                                        <# if ( row.row_label ) { #>
                                            <strong>{{{ row.row_label }}}:</strong>
                                        <# } #>
                                        <# if ( row.row_link && row.row_link.url ) { #>
                                            <a href="{{ row.row_link.url }}">{{{ row.row_value }}}</a>
                                        <# } else { #>
                                            <span>{{{ row.row_value }}}</span>
                                        <# } #>
                                    </li>
                                <# }); #>
                            </ul>
                        <# } #>
                    </div>
                    <div>
                        <# if ( 'yes' === settings.show_divider ) { #>
                            <div class="rpc-divider"></div>
                        <# } #>
                        <# if ( settings.footer_note ) { #>
                            <div class="rpc-footer-note">{{{ settings.footer_note }}}</div>
                        <# } #>
                    </div>
                </div>

            <# } else if ( 'style-8' === card_style ) { #>
                <div class="rpc-card rpc-style-8">
                    <span class="rpc-shine"></span>
                    <div class="rpc-reg-inner">
                        <div class="rpc-reg-icon">
                            <# renderIcon( settings.card_icon, 'far fa-id-card' ); #>
                        </div>
                        <div class="rpc-reg-content">
                            <h3 class="rpc-title" {{{ view.getRenderAttributeString( 'card_title' ) }}}>{{{ settings.card_title }}}</h3>
                            <# if ( settings.info_rows && settings.info_rows.length ) { #>
                                <dl class="rpc-dl-list">
                                    <# _.each( settings.info_rows, function( row ) { #>
                                        <div class="rpc-dl-row">
                                            <dt>{{{ row.row_label }}}</dt>
                                            <dd>{{{ row.row_value }}}</dd>
                                        </div>
                                    <# }); #>
                                </dl>
                            <# } #>
                        </div>
                    </div>
                </div>

            <# } else if ( 'style-9' === card_style ) { #>
                <div class="rpc-card rpc-style-9">
                    <span class="rpc-shine"></span>
                    <div class="rpc-accent-bar"></div>
                    <div class="rpc-glow-circle"></div>
                    <div class="rpc-float-ico">
                        <# renderIcon( settings.card_icon, 'fas fa-envelope' ); #>
                        <span class="rpc-dashed-ring"></span>
                    </div>
                    <h5 class="rpc-title" {{{ view.getRenderAttributeString( 'card_title' ) }}}>{{{ settings.card_title }}}</h5>
                    <# if ( settings.info_rows && settings.info_rows.length ) { #>
                        <div class="rpc-contact-pills">
                            <# _.each( settings.info_rows, function( row ) { #>
                                <#
                                var row_url = row.row_link && row.row_link.url ? row.row_link.url : ( row.row_value.indexOf('@') !== -1 ? 'mailto:' + row.row_value : '#' );
                                var row_target = row.row_link && row.row_link.is_external ? ' target="_blank"' : '';
                                #>
                                <a href="{{ row_url }}" {{ row_target }} class="rpc-pill-link">
                                    <# if ( row.row_icon && row.row_icon.value ) { #>
                                    <span class="rpc-pill-icon">
                                        <# renderIcon( row.row_icon ); #>
                                    </span>
                                    <# } #>
                                    <span>{{{ row.row_value }}}</span>
                                </a>
                            <# }); #>
                        </div>
                    <# } #>
                </div>

            <# } else if ( 'style-10' === card_style ) { #>
                <div class="rpc-card rpc-style-10">
                    <span class="rpc-shine"></span>
                    <div class="rpc-accent-bar"></div>
                    <div class="rpc-glow-circle"></div>
                    <div class="rpc-float-ico">
                        <# renderIcon( settings.card_icon, 'fas fa-share-alt' ); #>
                        <span class="rpc-dashed-ring"></span>
                    </div>
                    <h5 class="rpc-title" {{{ view.getRenderAttributeString( 'card_title' ) }}}>{{{ settings.card_title }}}</h5>
                    <# if ( settings.social_links && settings.social_links.length ) { #>
                        <div class="rpc-social-buttons">
                            <# _.each( settings.social_links, function( item ) { #>
                                <#
                                var platform = item.social_platform || 'facebook';
                                var classMap = {
                                    'facebook': 'rpc-soc-fb',
                                    'youtube':  'rpc-soc-yt',
                                    'linkedin': 'rpc-soc-in',
                                    'twitter':  'rpc-soc-tw',
                                    'whatsapp': 'rpc-soc-wa'
                                };
                                var btnClass = classMap[ platform ] || 'rpc-soc-fb';
                                var socUrl = item.social_url && item.social_url.url ? item.social_url.url : '#';
                                var socTarget = item.social_url && item.social_url.is_external ? ' target="_blank"' : '';
                                #>
                                <a href="{{ socUrl }}" {{ socTarget }} class="rpc-soc-btn {{ btnClass }}" aria-label="{{ platform }}">
                                    <# renderSocialIcon( platform, item.social_icon ); #>
                                </a>
                            <# }); #>
                        </div>
                    <# } #>
                </div>

            <# } else if ( 'style-11' === card_style ) { #>
                <div class="rpc-card rpc-style-11">
                    <div class="rpc-stat-icon-box">
                        <# renderIcon( settings.card_icon, 'fas fa-coins' ); #>
                    </div>
                    <div class="rpc-stat-value">
                        <# if ( settings.metric_prefix ) { #>
                            <span class="rpc-stat-prefix">{{{ settings.metric_prefix }}}</span>
                        <# } #>
                        <span class="rpc-stat-number">{{{ settings.metric_number }}}</span>
                        <# if ( settings.metric_suffix ) { #>
                            <span class="rpc-stat-suffix">{{{ settings.metric_suffix }}}</span>
                        <# } #>
                    </div>
                    <h4 class="rpc-stat-title" {{{ view.getRenderAttributeString( 'card_title' ) }}}>{{{ settings.card_title }}}</h4>
                    <# if ( settings.item_description ) { #>
                        <div class="rpc-stat-desc" {{{ view.getRenderAttributeString( 'item_description' ) }}}>
                            {{{ settings.item_description }}}
                        </div>
                    <# } #>
                </div>

            <# } #>

        </div>
        <?php
    }
}
