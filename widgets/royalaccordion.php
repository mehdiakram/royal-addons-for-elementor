<?php

namespace RoyalAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Icons_Manager;
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Scheme_Color;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use RoyalAddons\Elementor\Royal_Helpers;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class RoyalAccordion extends Widget_Base {

  public function get_name() {
    return 'royalaccordion';
  }

  public function get_title() {
    return __( 'Royal Accordion', 'royal-addons-for-elementor' );
  }

  public function get_icon() {
    return 'eicon-accordion rtbranding';
  }

  public function get_keywords() {
    return [ 'accordion', 'faq', 'tabs', 'toggle', 'columns', 'grid', 'royal', 'technologies', 'mehdi', 'akram' ];
  }

  public function get_categories() {
    return [ 'royaltech' ];
  }

  public function get_style_depends() {
    return [ 'royalaccordion' ];
  }

  public function get_script_depends() {
    return [ 'jquery', 'royalaccordion' ];
  }

  protected function register_controls() {

    // =========================================================================
    // CONTENT TAB: ACCORDION ITEMS
    // =========================================================================
    $this->start_controls_section(
      'content_section',
      [
        'label' => __( 'Accordion Items', 'royal-addons-for-elementor' ),
        'tab'   => Controls_Manager::TAB_CONTENT,
      ]
    );

    $repeater = new Repeater();

    $repeater->add_control(
      'royal_acc_title',
      [
        'label'       => __( 'Title', 'royal-addons-for-elementor' ),
        'type'        => Controls_Manager::TEXT,
        'default'     => __( 'What is the Royal Technologies Affiliate Program?', 'royal-addons-for-elementor' ),
        'placeholder' => __( 'Type your title here', 'royal-addons-for-elementor' ),
        'label_block' => true,
        'dynamic'     => [ 'active' => true ],
      ]
    );

    $repeater->add_control(
      'title_tag',
      [
        'label'   => __( 'Title Tag', 'royal-addons-for-elementor' ),
        'type'    => Controls_Manager::SELECT,
        'options' => Royal_Helpers::royal_title_tags(),
        'default' => 'h3',
      ]
    );

    $repeater->add_control(
      'royal_acc_description',
      [
        'label'       => __( 'Description', 'royal-addons-for-elementor' ),
        'type'        => Controls_Manager::WYSIWYG,
        'rows'        => 8,
        'default'     => __( 'The Royal Technologies Affiliate Program allows you to earn generous commissions by referring clients and users to our premium plugins, templates, and digital services.', 'royal-addons-for-elementor' ),
        'placeholder' => __( 'Type your description here', 'royal-addons-for-elementor' ),
      ]
    );

    $repeater->add_control(
      'item_hash_id',
      [
        'label'       => __( 'Custom ID / Hash (Optional)', 'royal-addons-for-elementor' ),
        'type'        => Controls_Manager::TEXT,
        'placeholder' => __( 'e.g. affiliate-program', 'royal-addons-for-elementor' ),
        'description' => __( 'Used for URL deep linking (e.g. page.com/#affiliate-program).', 'royal-addons-for-elementor' ),
      ]
    );

    $this->add_control(
      'royalaccordions',
      [
        'label'       => __( 'Items', 'royal-addons-for-elementor' ),
        'type'        => Controls_Manager::REPEATER,
        'fields'      => $repeater->get_controls(),
        'default'     => [
          [
            'royal_acc_title'       => __( 'What is the Royal Technologies Affiliate Program?', 'royal-addons-for-elementor' ),
            'royal_acc_description' => __( 'The Royal Technologies Affiliate Program allows you to earn recurring commissions by promoting our powerful WordPress solutions to your audience.', 'royal-addons-for-elementor' ),
            'item_hash_id'          => 'faq-affiliate-program',
          ],
          [
            'royal_acc_title'       => __( 'How much commission can I earn?', 'royal-addons-for-elementor' ),
            'royal_acc_description' => __( 'You can earn up to 40% commission on every eligible sale generated through your unique affiliate link with monthly payouts.', 'royal-addons-for-elementor' ),
            'item_hash_id'          => 'faq-commission',
          ],
          [
            'royal_acc_title'       => __( 'Is it free to join?', 'royal-addons-for-elementor' ),
            'royal_acc_description' => __( 'Yes, completely free! There are zero signup fees, no minimum requirements, and you can get started within minutes.', 'royal-addons-for-elementor' ),
            'item_hash_id'          => 'faq-free-to-join',
          ],
          [
            'royal_acc_title'       => __( 'How do I get my affiliate link?', 'royal-addons-for-elementor' ),
            'royal_acc_description' => __( 'Once your affiliate account is approved, log in to your dashboard to generate custom tracking links and promotional banners.', 'royal-addons-for-elementor' ),
            'item_hash_id'          => 'faq-affiliate-link',
          ],
          [
            'royal_acc_title'       => __( 'How and when will I get paid?', 'royal-addons-for-elementor' ),
            'royal_acc_description' => __( 'Affiliate payouts are processed on the 1st of every month via PayPal, Direct Bank Transfer, or Stripe with a very low minimum threshold.', 'royal-addons-for-elementor' ),
            'item_hash_id'          => 'faq-payment-schedule',
          ],
          [
            'royal_acc_title'       => __( 'Who can join the program?', 'royal-addons-for-elementor' ),
            'royal_acc_description' => __( 'Bloggers, web designers, WordPress agencies, YouTubers, and anyone with an audience interested in premium web design tools can join.', 'royal-addons-for-elementor' ),
            'item_hash_id'          => 'faq-who-can-join',
          ],
        ],
        'title_field' => '{{{ royal_acc_title }}}',
      ]
    );

    $this->end_controls_section();


    // =========================================================================
    // CONTENT TAB: LAYOUT & PRESETS (1 / 2 COLUMNS RESPONSIVE)
    // =========================================================================
    $this->start_controls_section(
      'section_layout',
      [
        'label' => __( 'Layout & Columns', 'royal-addons-for-elementor' ),
        'tab'   => Controls_Manager::TAB_CONTENT,
      ]
    );

    $this->add_control(
      'preset',
      [
        'label'   => __( 'Style Preset', 'royal-addons-for-elementor' ),
        'type'    => Controls_Manager::SELECT,
        'default' => 'modern_card',
        'options' => [
          'modern_card'   => __( 'Modern Card (Clean Boxed)', 'royal-addons-for-elementor' ),
          'minimal_line'  => __( 'Minimal Line (Divider Only)', 'royal-addons-for-elementor' ),
          'soft_filled'   => __( 'Soft Tinted Background', 'royal-addons-for-elementor' ),
          'left_accent'   => __( 'Left Accent Border', 'royal-addons-for-elementor' ),
          'classic_boxed' => __( 'Classic Boxed', 'royal-addons-for-elementor' ),
        ],
        'description' => __( 'Select a pre-designed modern layout. You can further customize any design in the Style tab.', 'royal-addons-for-elementor' ),
      ]
    );

    $this->add_responsive_control(
      'columns',
      [
        'label'          => __( 'Columns', 'royal-addons-for-elementor' ),
        'type'           => Controls_Manager::SELECT,
        'default'        => '2',
        'tablet_default' => '1',
        'mobile_default' => '1',
        'options'        => [
          '1' => __( '1 Column', 'royal-addons-for-elementor' ),
          '2' => __( '2 Columns', 'royal-addons-for-elementor' ),
          '3' => __( '3 Columns', 'royal-addons-for-elementor' ),
        ],
        'selectors'      => [
          '{{WRAPPER}} .royalacc-items-grid' => 'grid-template-columns: repeat({{VALUE}}, 1fr);',
        ],
      ]
    );

    $this->add_responsive_control(
      'columns_gap',
      [
        'label'      => __( 'Columns Gap', 'royal-addons-for-elementor' ),
        'type'       => Controls_Manager::SLIDER,
        'size_units' => [ 'px', 'em', 'rem' ],
        'range'      => [
          'px' => [ 'min' => 0, 'max' => 80 ],
        ],
        'default'    => [ 'unit' => 'px', 'size' => 20 ],
        'selectors'  => [
          '{{WRAPPER}} .royalacc-items-grid' => 'column-gap: {{SIZE}}{{UNIT}};',
        ],
      ]
    );

    $this->add_responsive_control(
      'rows_gap',
      [
        'label'      => __( 'Rows Gap', 'royal-addons-for-elementor' ),
        'type'       => Controls_Manager::SLIDER,
        'size_units' => [ 'px', 'em', 'rem' ],
        'range'      => [
          'px' => [ 'min' => 0, 'max' => 80 ],
        ],
        'default'    => [ 'unit' => 'px', 'size' => 16 ],
        'selectors'  => [
          '{{WRAPPER}} .royalacc-items-grid' => 'row-gap: {{SIZE}}{{UNIT}};',
          '{{WRAPPER}} .royalacc-column'     => 'gap: {{SIZE}}{{UNIT}};',
        ],
      ]
    );

    $this->add_control(
      'column_distribution',
      [
        'label'       => __( 'Column Distribution', 'royal-addons-for-elementor' ),
        'type'        => Controls_Manager::SELECT,
        'default'     => 'split',
        'options'     => [
          'split'       => __( 'Split Evenly (1, 2, 3 | 4, 5, 6)', 'royal-addons-for-elementor' ),
          'alternating' => __( 'Alternating (1, 3, 5 | 2, 4, 6)', 'royal-addons-for-elementor' ),
        ],
        'description' => __( 'Evenly split groups the first half in column 1 and the rest in column 2 so columns expand completely independently.', 'royal-addons-for-elementor' ),
      ]
    );

    $this->end_controls_section();


    // =========================================================================
    // CONTENT TAB: SEARCH / FAQ FILTER
    // =========================================================================
    $this->start_controls_section(
      'section_search',
      [
        'label' => __( 'Search / Filter', 'royal-addons-for-elementor' ),
        'tab'   => Controls_Manager::TAB_CONTENT,
      ]
    );

    $this->add_control(
      'enable_search',
      [
        'label'        => __( 'Enable Live Search', 'royal-addons-for-elementor' ),
        'type'         => Controls_Manager::SWITCHER,
        'label_on'     => __( 'Yes', 'royal-addons-for-elementor' ),
        'label_off'    => __( 'No', 'royal-addons-for-elementor' ),
        'return_value' => 'yes',
        'default'      => '',
      ]
    );

    $this->add_control(
      'search_placeholder',
      [
        'label'       => __( 'Search Placeholder', 'royal-addons-for-elementor' ),
        'type'        => Controls_Manager::TEXT,
        'default'     => __( 'Search questions...', 'royal-addons-for-elementor' ),
        'condition'   => [ 'enable_search' => 'yes' ],
      ]
    );

    $this->add_control(
      'search_no_results',
      [
        'label'       => __( 'No Results Text', 'royal-addons-for-elementor' ),
        'type'        => Controls_Manager::TEXT,
        'default'     => __( 'No matching questions found.', 'royal-addons-for-elementor' ),
        'condition'   => [ 'enable_search' => 'yes' ],
      ]
    );

    $this->add_control(
      'search_icon',
      [
        'label'       => __( 'Search Icon', 'royal-addons-for-elementor' ),
        'type'        => Controls_Manager::ICONS,
        'default'     => [
          'value'   => 'fas fa-search',
          'library' => 'fa-solid',
        ],
        'condition'   => [ 'enable_search' => 'yes' ],
      ]
    );

    $this->end_controls_section();


    // =========================================================================
    // CONTENT TAB: INTERACTIONS & ICONS
    // =========================================================================
    $this->start_controls_section(
      'section_interactions',
      [
        'label' => __( 'Interactions & Icons', 'royal-addons-for-elementor' ),
        'tab'   => Controls_Manager::TAB_CONTENT,
      ]
    );

    $this->add_control(
      'defaultstate',
      [
        'label'   => esc_html__( 'Default State', 'royal-addons-for-elementor' ),
        'type'    => Controls_Manager::SELECT,
        'default' => 'collapsed',
        'options' => [
          'collapsed'    => esc_html__( 'All Collapsed (Closed)', 'royal-addons-for-elementor' ),
          'expanded'     => esc_html__( 'First Expanded', 'royal-addons-for-elementor' ),
          'all_expanded' => esc_html__( 'All Expanded', 'royal-addons-for-elementor' ),
        ],
      ]
    );

    $this->add_control(
      'collapsible',
      [
        'label'   => esc_html__( 'All Collapsible', 'royal-addons-for-elementor' ),
        'type'    => Controls_Manager::SELECT,
        'default' => 'true',
        'options' => [
          'true'  => esc_html__( 'Collapsible', 'royal-addons-for-elementor' ),
          'false' => esc_html__( 'Not Collapsible', 'royal-addons-for-elementor' ),
        ],
      ]
    );

    $this->add_control(
      'maxitemsexpanded',
      [
        'label'   => esc_html__( 'Max Items Expanded', 'royal-addons-for-elementor' ),
        'type'    => Controls_Manager::SELECT,
        'default' => 'multiple',
        'options' => [
          'multiple' => esc_html__( 'Multiple (Independent Toggle)', 'royal-addons-for-elementor' ),
          'one'      => esc_html__( 'One Only (Classic Accordion)', 'royal-addons-for-elementor' ),
        ],
      ]
    );

    $this->add_control(
      'duration',
      [
        'label'   => esc_html__( 'Animation Duration (MS)', 'royal-addons-for-elementor' ),
        'type'    => Controls_Manager::NUMBER,
        'min'     => 50,
        'max'     => 2000,
        'step'    => 50,
        'default' => 300,
      ]
    );

    $this->add_control(
      'icon_animation',
      [
        'label'       => __( 'Icon Animation Style', 'royal-addons-for-elementor' ),
        'type'        => Controls_Manager::SELECT,
        'default'     => 'rotate',
        'options'     => [
          'rotate' => __( 'Rotate Icon (e.g. + rotates 45° to ×)', 'royal-addons-for-elementor' ),
          'swap'   => __( 'Swap Open / Close Icons', 'royal-addons-for-elementor' ),
        ],
        'separator'   => 'before',
      ]
    );

    $this->add_control(
      'icon_rotate_angle',
      [
        'label'      => __( 'Icon Rotate Angle (Deg)', 'royal-addons-for-elementor' ),
        'type'       => Controls_Manager::SLIDER,
        'size_units' => [ 'px' ],
        'range'      => [
          'px' => [ 'min' => 0, 'max' => 360, 'step' => 5 ],
        ],
        'default'    => [ 'unit' => 'px', 'size' => 45 ],
        'condition'  => [ 'icon_animation' => 'rotate' ],
        'selectors'  => [
          '{{WRAPPER}}' => '--royalacc-icon-rotate: {{SIZE}}deg;',
        ],
      ]
    );

    $this->add_control(
      'icon_closed',
      [
        'label'       => esc_html__( 'Icon (Closed / Default)', 'royal-addons-for-elementor' ),
        'type'        => Controls_Manager::ICONS,
        'default'     => [
          'value'   => 'fas fa-plus',
          'library' => 'fa-solid',
        ],
        'skin'        => 'inline',
        'label_block' => false,
      ]
    );

    $this->add_control(
      'icon_open',
      [
        'label'       => esc_html__( 'Icon (Open / Active)', 'royal-addons-for-elementor' ),
        'type'        => Controls_Manager::ICONS,
        'default'     => [
          'value'   => 'fas fa-minus',
          'library' => 'fa-solid',
        ],
        'skin'        => 'inline',
        'label_block' => false,
        'condition'   => [ 'icon_animation' => 'swap' ],
      ]
    );

    $this->add_responsive_control(
      'iconposition',
      [
        'label'     => esc_html__( 'Icon Position', 'royal-addons-for-elementor' ),
        'type'      => Controls_Manager::CHOOSE,
        'options'   => [
          'row-reverse' => [
            'title' => esc_html__( 'Left', 'royal-addons-for-elementor' ),
            'icon'  => 'eicon-h-align-left',
          ],
          'row'         => [
            'title' => esc_html__( 'Right', 'royal-addons-for-elementor' ),
            'icon'  => 'eicon-h-align-right',
          ],
        ],
        'default'   => 'row',
        'selectors' => [
          '{{WRAPPER}} .royalaccitemheading' => 'flex-direction: {{VALUE}};',
        ],
      ]
    );

    $this->add_responsive_control(
      'icon_size',
      [
        'label'      => esc_html__( 'Icon Size', 'royal-addons-for-elementor' ),
        'type'       => Controls_Manager::SLIDER,
        'size_units' => [ 'px', 'em', 'rem' ],
        'range'      => [
          'px' => [ 'min' => 8, 'max' => 60 ],
        ],
        'default'    => [ 'unit' => 'px', 'size' => 16 ],
        'selectors'  => [
          '{{WRAPPER}} .royalaccicon'     => 'font-size: {{SIZE}}{{UNIT}};',
          '{{WRAPPER}} .royalaccicon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
        ],
      ]
    );

    $this->add_control(
      'enable_hash',
      [
        'label'        => esc_html__( 'URL Hash / Deep Linking', 'royal-addons-for-elementor' ),
        'type'         => Controls_Manager::SWITCHER,
        'label_on'     => esc_html__( 'Yes', 'royal-addons-for-elementor' ),
        'label_off'    => esc_html__( 'No', 'royal-addons-for-elementor' ),
        'return_value' => 'yes',
        'default'      => '',
        'separator'    => 'before',
        'description'  => __( 'Automatically scrolls to and expands an accordion item matching the URL hash (e.g. #faq-1).', 'royal-addons-for-elementor' ),
      ]
    );

    $this->add_control(
      'scroll_offset',
      [
        'label'     => __( 'Scroll Offset (px)', 'royal-addons-for-elementor' ),
        'type'      => Controls_Manager::NUMBER,
        'default'   => 80,
        'condition' => [ 'enable_hash' => 'yes' ],
      ]
    );

    $this->add_control(
      'faq_schema',
      [
        'label'        => esc_html__( 'SEO FAQ Schema', 'royal-addons-for-elementor' ),
        'type'         => Controls_Manager::SWITCHER,
        'label_on'     => esc_html__( 'Yes', 'royal-addons-for-elementor' ),
        'label_off'    => esc_html__( 'No', 'royal-addons-for-elementor' ),
        'return_value' => 'yes',
        'default'      => '',
        'description'  => __( 'Generates structured JSON-LD data for Google FAQ Rich Results.', 'royal-addons-for-elementor' ),
      ]
    );

    $this->end_controls_section();


    // =========================================================================
    // STYLE TAB: SEARCH BAR STYLE
    // =========================================================================
    $this->start_controls_section(
      'section_search_style',
      [
        'label'     => __( 'Search Bar Style', 'royal-addons-for-elementor' ),
        'tab'       => Controls_Manager::TAB_STYLE,
        'condition' => [ 'enable_search' => 'yes' ],
      ]
    );

    $this->add_group_control(
      Group_Control_Typography::get_type(),
      [
        'name'     => 'search_typo',
        'selector' => '{{WRAPPER}} .royalacc-search-input',
      ]
    );

    $this->add_control(
      'search_input_color',
      [
        'label'     => __( 'Text Color', 'royal-addons-for-elementor' ),
        'type'      => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .royalacc-search-input' => 'color: {{VALUE}};',
        ],
      ]
    );

    $this->add_control(
      'search_placeholder_color',
      [
        'label'     => __( 'Placeholder Color', 'royal-addons-for-elementor' ),
        'type'      => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .royalacc-search-input::placeholder' => 'color: {{VALUE}};',
        ],
      ]
    );

    $this->add_control(
      'search_icon_color',
      [
        'label'     => __( 'Icon Color', 'royal-addons-for-elementor' ),
        'type'      => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .royalacc-search-icon' => 'color: {{VALUE}};',
          '{{WRAPPER}} .royalacc-search-icon svg' => 'fill: {{VALUE}};',
        ],
      ]
    );

    $this->add_control(
      'search_bg_color',
      [
        'label'     => __( 'Background Color', 'royal-addons-for-elementor' ),
        'type'      => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .royalacc-search-input' => 'background-color: {{VALUE}};',
        ],
      ]
    );

    $this->add_group_control(
      Group_Control_Border::get_type(),
      [
        'name'     => 'search_border',
        'selector' => '{{WRAPPER}} .royalacc-search-input',
      ]
    );

    $this->add_responsive_control(
      'search_border_radius',
      [
        'label'      => __( 'Border Radius', 'royal-addons-for-elementor' ),
        'type'       => Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', '%', 'em', 'rem' ],
        'selectors'  => [
          '{{WRAPPER}} .royalacc-search-input' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
      ]
    );

    $this->add_group_control(
      Group_Control_Box_Shadow::get_type(),
      [
        'name'     => 'search_box_shadow',
        'selector' => '{{WRAPPER}} .royalacc-search-input',
      ]
    );

    $this->add_responsive_control(
      'search_padding',
      [
        'label'      => __( 'Padding', 'royal-addons-for-elementor' ),
        'type'       => Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', 'em', 'rem' ],
        'selectors'  => [
          '{{WRAPPER}} .royalacc-search-input' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
      ]
    );

    $this->add_responsive_control(
      'search_margin',
      [
        'label'      => __( 'Margin Bottom', 'royal-addons-for-elementor' ),
        'type'       => Controls_Manager::SLIDER,
        'size_units' => [ 'px', 'em' ],
        'range'      => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
        'selectors'  => [
          '{{WRAPPER}} .royalacc-search-wrap' => 'margin-bottom: {{SIZE}}{{UNIT}};',
        ],
      ]
    );

    $this->end_controls_section();


    // =========================================================================
    // STYLE TAB: CARD / ITEM BOX STYLE
    // =========================================================================
    $this->start_controls_section(
      'section_card_style',
      [
        'label' => __( 'Card / Item Box Style', 'royal-addons-for-elementor' ),
        'tab'   => Controls_Manager::TAB_STYLE,
      ]
    );

    $this->add_responsive_control(
      'card_padding',
      [
        'label'      => __( 'Card Padding', 'royal-addons-for-elementor' ),
        'type'       => Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', '%', 'em', 'rem' ],
        'selectors'  => [
          '{{WRAPPER}} .royalaccitem' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
      ]
    );

    $this->add_responsive_control(
      'card_border_radius',
      [
        'label'      => __( 'Border Radius', 'royal-addons-for-elementor' ),
        'type'       => Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', '%', 'em', 'rem' ],
        'selectors'  => [
          '{{WRAPPER}} .royalaccitem' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
      ]
    );

    $this->start_controls_tabs( 'tabs_card_style' );

    // Tab: Normal (Closed)
    $this->start_controls_tab(
      'tab_card_normal',
      [ 'label' => __( 'Normal', 'royal-addons-for-elementor' ) ]
    );

    $this->add_control(
      'card_bg_normal',
      [
        'label'     => __( 'Background Color', 'royal-addons-for-elementor' ),
        'type'      => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .royalaccitem' => 'background-color: {{VALUE}};',
        ],
      ]
    );

    $this->add_group_control(
      Group_Control_Border::get_type(),
      [
        'name'     => 'card_border_normal',
        'selector' => '{{WRAPPER}} .royalaccitem',
      ]
    );

    $this->add_group_control(
      Group_Control_Box_Shadow::get_type(),
      [
        'name'     => 'card_shadow_normal',
        'selector' => '{{WRAPPER}} .royalaccitem',
      ]
    );

    $this->end_controls_tab();

    // Tab: Hover
    $this->start_controls_tab(
      'tab_card_hover',
      [ 'label' => __( 'Hover', 'royal-addons-for-elementor' ) ]
    );

    $this->add_control(
      'card_bg_hover',
      [
        'label'     => __( 'Background Color', 'royal-addons-for-elementor' ),
        'type'      => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .royalaccitem:hover' => 'background-color: {{VALUE}};',
        ],
      ]
    );

    $this->add_control(
      'card_border_color_hover',
      [
        'label'     => __( 'Border Color', 'royal-addons-for-elementor' ),
        'type'      => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .royalaccitem:hover' => 'border-color: {{VALUE}};',
        ],
      ]
    );

    $this->add_group_control(
      Group_Control_Box_Shadow::get_type(),
      [
        'name'     => 'card_shadow_hover',
        'selector' => '{{WRAPPER}} .royalaccitem:hover',
      ]
    );

    $this->end_controls_tab();

    // Tab: Active (Open)
    $this->start_controls_tab(
      'tab_card_active',
      [ 'label' => __( 'Active (Open)', 'royal-addons-for-elementor' ) ]
    );

    $this->add_control(
      'card_bg_active',
      [
        'label'     => __( 'Background Color', 'royal-addons-for-elementor' ),
        'type'      => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .royalaccitem.royalacc-active' => 'background-color: {{VALUE}};',
        ],
      ]
    );

    $this->add_control(
      'card_border_color_active',
      [
        'label'     => __( 'Border Color', 'royal-addons-for-elementor' ),
        'type'      => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .royalaccitem.royalacc-active' => 'border-color: {{VALUE}};',
        ],
      ]
    );

    $this->add_group_control(
      Group_Control_Box_Shadow::get_type(),
      [
        'name'     => 'card_shadow_active',
        'selector' => '{{WRAPPER}} .royalaccitem.royalacc-active',
      ]
    );

    $this->end_controls_tab();

    $this->end_controls_tabs();

    $this->end_controls_section();


    // =========================================================================
    // STYLE TAB: TITLE / HEADING STYLE
    // =========================================================================
    $this->start_controls_section(
      'title_style_section',
      [
        'label' => __( 'Title Style', 'royal-addons-for-elementor' ),
        'tab'   => Controls_Manager::TAB_STYLE,
      ]
    );

    $this->add_group_control(
      Group_Control_Typography::get_type(),
      [
        'name'     => 'title_typo',
        'label'    => __( 'Title Typography', 'royal-addons-for-elementor' ),
        'global'   => [
          'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_PRIMARY,
        ],
        'selector' => '{{WRAPPER}} .royalaccitemheading .title',
      ]
    );

    $this->add_responsive_control(
      'title_padding',
      [
        'label'      => esc_html__( 'Heading Padding', 'royal-addons-for-elementor' ),
        'type'       => Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', '%', 'em', 'rem' ],
        'selectors'  => [
          '{{WRAPPER}} .royalaccitemheading' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
      ]
    );

    $this->add_responsive_control(
      'title_margin',
      [
        'label'      => esc_html__( 'Heading Margin', 'royal-addons-for-elementor' ),
        'type'       => Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', '%', 'em', 'rem' ],
        'selectors'  => [
          '{{WRAPPER}} .royalaccitemheading' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
      ]
    );

    $this->add_group_control(
      Group_Control_Border::get_type(),
      [
        'name'     => 'heading_border',
        'selector' => '{{WRAPPER}} .royalaccitemheading',
      ]
    );

    $this->add_responsive_control(
      'title_radius',
      [
        'label'      => __( 'Border Radius', 'royal-addons-for-elementor' ),
        'type'       => Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', '%' ],
        'selectors'  => [
          '{{WRAPPER}} .royalaccitemheading' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
      ]
    );

    $this->start_controls_tabs( 'button_style_tabs' );

    // Tab: Normal / Closed
    $this->start_controls_tab(
      'style_close_tab',
      [ 'label' => esc_html__( 'Normal', 'royal-addons-for-elementor' ) ]
    );

    $this->add_control(
      'title_color_close',
      [
        'label'     => __( 'Title Color', 'royal-addons-for-elementor' ),
        'type'      => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .royalaccitemheading .title' => 'color: {{VALUE}};',
          '{{WRAPPER}} .ui-accordion-header-collapsed .title' => 'color: {{VALUE}};',
        ],
      ]
    );

    $this->add_control(
      'title_bg_close',
      [
        'label'     => __( 'Heading Background', 'royal-addons-for-elementor' ),
        'type'      => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .royalaccitemheading' => 'background-color: {{VALUE}};',
          '{{WRAPPER}} .ui-accordion-header-collapsed' => 'background-color: {{VALUE}};',
        ],
      ]
    );

    $this->end_controls_tab();

    // Tab: Active / Open
    $this->start_controls_tab(
      'style_open_tab',
      [ 'label' => esc_html__( 'Active', 'royal-addons-for-elementor' ) ]
    );

    $this->add_control(
      'title_color_open',
      [
        'label'     => __( 'Title Color', 'royal-addons-for-elementor' ),
        'type'      => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .ui-accordion-header-active .title' => 'color: {{VALUE}};',
        ],
      ]
    );

    $this->add_control(
      'title_bg_open',
      [
        'label'     => __( 'Heading Background', 'royal-addons-for-elementor' ),
        'type'      => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .ui-accordion-header-active' => 'background-color: {{VALUE}};',
        ],
      ]
    );

    $this->end_controls_tab();

    $this->end_controls_tabs();

    $this->end_controls_section();


    // =========================================================================
    // STYLE TAB: ICON STYLE
    // =========================================================================
    $this->start_controls_section(
      'icon_style_section',
      [
        'label' => __( 'Icon Style', 'royal-addons-for-elementor' ),
        'tab'   => Controls_Manager::TAB_STYLE,
      ]
    );

    $this->add_responsive_control(
      'icon_box_size',
      [
        'label'      => esc_html__( 'Icon Box Size', 'royal-addons-for-elementor' ),
        'type'       => Controls_Manager::SLIDER,
        'size_units' => [ 'px' ],
        'range'      => [ 'px' => [ 'min' => 16, 'max' => 80 ] ],
        'selectors'  => [
          '{{WRAPPER}} .royalaccicon' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
        ],
      ]
    );

    $this->add_group_control(
      Group_Control_Border::get_type(),
      [
        'name'     => 'icon_border',
        'selector' => '{{WRAPPER}} .royalaccicon',
      ]
    );

    $this->add_responsive_control(
      'icon_border_radius',
      [
        'label'      => __( 'Border Radius', 'royal-addons-for-elementor' ),
        'type'       => Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', '%' ],
        'selectors'  => [
          '{{WRAPPER}} .royalaccicon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
      ]
    );

    $this->start_controls_tabs( 'tabs_icon_style' );

    // Tab: Normal (Closed)
    $this->start_controls_tab(
      'tab_icon_normal',
      [ 'label' => __( 'Normal', 'royal-addons-for-elementor' ) ]
    );

    $this->add_control(
      'icon_color_close',
      [
        'label'     => __( 'Icon Color', 'royal-addons-for-elementor' ),
        'type'      => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .royalaccicon' => 'color: {{VALUE}};',
          '{{WRAPPER}} .royalaccicon svg' => 'fill: {{VALUE}};',
        ],
      ]
    );

    $this->add_control(
      'icon_bg_close',
      [
        'label'     => __( 'Background Color', 'royal-addons-for-elementor' ),
        'type'      => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .royalaccicon' => 'background-color: {{VALUE}};',
        ],
      ]
    );

    $this->end_controls_tab();

    // Tab: Active (Open)
    $this->start_controls_tab(
      'tab_icon_active',
      [ 'label' => __( 'Active', 'royal-addons-for-elementor' ) ]
    );

    $this->add_control(
      'icon_color_open',
      [
        'label'     => __( 'Icon Color', 'royal-addons-for-elementor' ),
        'type'      => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .ui-accordion-header-active .royalaccicon' => 'color: {{VALUE}};',
          '{{WRAPPER}} .ui-accordion-header-active .royalaccicon svg' => 'fill: {{VALUE}};',
        ],
      ]
    );

    $this->add_control(
      'icon_bg_open',
      [
        'label'     => __( 'Background Color', 'royal-addons-for-elementor' ),
        'type'      => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .ui-accordion-header-active .royalaccicon' => 'background-color: {{VALUE}};',
        ],
      ]
    );

    $this->end_controls_tab();

    $this->end_controls_tabs();

    $this->end_controls_section();


    // =========================================================================
    // STYLE TAB: CONTENT / DESCRIPTION STYLE
    // =========================================================================
    $this->start_controls_section(
      'content_style_section',
      [
        'label' => __( 'Content Style', 'royal-addons-for-elementor' ),
        'tab'   => Controls_Manager::TAB_STYLE,
      ]
    );

    $this->add_group_control(
      Group_Control_Typography::get_type(),
      [
        'name'     => 'content_typo',
        'label'    => __( 'Content Typography', 'royal-addons-for-elementor' ),
        'global'   => [
          'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_TEXT,
        ],
        'selector' => '{{WRAPPER}} .royalaccitemcontent, {{WRAPPER}} .royalaccitemcontent-inner, {{WRAPPER}} .royalaccitemcontent-inner p',
      ]
    );

    $this->add_control(
      'content_color_open',
      [
        'label'     => __( 'Content Color', 'royal-addons-for-elementor' ),
        'type'      => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .royalaccitemcontent' => 'color: {{VALUE}};',
          '{{WRAPPER}} .royalaccitemcontent-inner' => 'color: {{VALUE}};',
        ],
      ]
    );

    $this->add_control(
      'content_bg_color_open',
      [
        'label'     => __( 'Content Background', 'royal-addons-for-elementor' ),
        'type'      => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .royalaccitemcontent' => 'background-color: {{VALUE}};',
        ],
      ]
    );

    $this->add_responsive_control(
      'content_padding',
      [
        'label'      => __( 'Padding', 'royal-addons-for-elementor' ),
        'type'       => Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', '%', 'em', 'rem' ],
        'selectors'  => [
          '{{WRAPPER}} .royalaccitemcontent' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
      ]
    );

    $this->add_group_control(
      Group_Control_Border::get_type(),
      [
        'name'     => 'content_border',
        'label'    => __( 'Content Border', 'royal-addons-for-elementor' ),
        'selector' => '{{WRAPPER}} .royalaccitemcontent',
      ]
    );

    $this->add_responsive_control(
      'content_border_radius',
      [
        'label'      => __( 'Border Radius', 'royal-addons-for-elementor' ),
        'type'       => Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', '%' ],
        'selectors'  => [
          '{{WRAPPER}} .royalaccitemcontent' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
      ]
    );

    $this->end_controls_section();


    // =========================================================================
    // STYLE TAB: ACCORDION WRAPPER (CONTAINER) STYLE
    // =========================================================================
    $this->start_controls_section(
      'accordion_style_section',
      [
        'label' => __( 'Wrapper Container Style', 'royal-addons-for-elementor' ),
        'tab'   => Controls_Manager::TAB_STYLE,
      ]
    );

    $this->add_responsive_control(
      'padding',
      [
        'label'      => esc_html__( 'Padding', 'royal-addons-for-elementor' ),
        'type'       => Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', '%', 'em', 'rem' ],
        'selectors'  => [
          '{{WRAPPER}} .royalaccwrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
      ]
    );

    $this->add_group_control(
      Group_Control_Background::get_type(),
      [
        'name'     => 'background',
        'label'    => __( 'Background', 'royal-addons-for-elementor' ),
        'types'    => [ 'classic', 'gradient' ],
        'selector' => '{{WRAPPER}} .royalaccwrapper',
      ]
    );

    $this->add_group_control(
      Group_Control_Border::get_type(),
      [
        'name'     => 'wrapper_border',
        'selector' => '{{WRAPPER}} .royalaccwrapper',
      ]
    );

    $this->add_responsive_control(
      'wrapper_radius',
      [
        'label'      => __( 'Border Radius', 'royal-addons-for-elementor' ),
        'type'       => Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', '%' ],
        'selectors'  => [
          '{{WRAPPER}} .royalaccwrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
      ]
    );

    $this->add_group_control(
      Group_Control_Box_Shadow::get_type(),
      [
        'name'     => 'accordion_box_shadow',
        'selector' => '{{WRAPPER}} .royalaccwrapper',
      ]
    );

    $this->end_controls_section();
  }

  protected function render() {
    $settings   = $this->get_settings_for_display();
    $royalaccid = 'royalacc' . $this->get_id();

    $preset           = !empty($settings['preset']) ? $settings['preset'] : 'modern_card';
    $icon_animation   = !empty($settings['icon_animation']) ? $settings['icon_animation'] : 'rotate';
    $duration         = !empty($settings['duration']) ? $settings['duration'] : 300;
    $defaultstate     = !empty($settings['defaultstate']) ? $settings['defaultstate'] : 'collapsed';
    $collapsible      = ($settings['collapsible'] === 'false') ? 'false' : 'true';
    $maxitemsexpanded = ($settings['maxitemsexpanded'] === 'one') ? 'false' : 'true';
    $enable_hash      = !empty($settings['enable_hash']) ? $settings['enable_hash'] : '';
    $scroll_offset    = !empty($settings['scroll_offset']) ? $settings['scroll_offset'] : 80;

    $has_open_icon   = !empty($settings['icon_open']['value']);
    $has_closed_icon = !empty($settings['icon_closed']['value']);
    $faq_schema      = ($settings['faq_schema'] === 'yes');

    if ( !empty($settings['royalaccordions']) ) {

      // Output FAQ Schema JSON-LD
      if ( $faq_schema ) {
        echo '<script type="application/ld+json">{"@context":"https://schema.org","@type":"FAQPage","mainEntity":[';
        $faq_items = [];
        foreach ( $settings['royalaccordions'] as $faq_item ) {
          $faq_items[] = '{"@type":"Question","name":' . wp_json_encode($faq_item['royal_acc_title']) . ',"acceptedAnswer":{"@type":"Answer","text":' . wp_json_encode(wp_strip_all_tags($faq_item['royal_acc_description'])) . '}}';
        }
        echo implode( ',', $faq_items );
        echo ']}</script>';
      }

      $wrapper_classes = [
        'royalaccwrapper',
        'royalacc-preset-' . sanitize_html_class($preset),
        'royalacc-icon-anim-' . sanitize_html_class($icon_animation),
      ];
      ?>
      <div id="<?php echo esc_attr( $royalaccid ); ?>"
           class="<?php echo esc_attr( implode(' ', $wrapper_classes) ); ?>"
           data-multiple="<?php echo esc_attr( $maxitemsexpanded ); ?>"
           data-collapsible="<?php echo esc_attr( $collapsible ); ?>"
           data-duration="<?php echo esc_attr( $duration ); ?>"
           data-default-state="<?php echo esc_attr( $defaultstate ); ?>"
           data-hash-linking="<?php echo esc_attr( $enable_hash ); ?>"
           data-scroll-offset="<?php echo esc_attr( $scroll_offset ); ?>">

        <?php if ( !empty($settings['enable_search']) && $settings['enable_search'] === 'yes' ) : ?>
          <div class="royalacc-search-wrap">
            <span class="royalacc-search-icon">
              <?php Icons_Manager::render_icon( $settings['search_icon'], [ 'aria-hidden' => 'true' ] ); ?>
            </span>
            <input type="text" class="royalacc-search-input" placeholder="<?php echo esc_attr( $settings['search_placeholder'] ); ?>" aria-label="<?php echo esc_attr( $settings['search_placeholder'] ); ?>" />
          </div>
          <div class="royalacc-no-results" style="display: none;">
            <?php echo esc_html( $settings['search_no_results'] ); ?>
          </div>
        <?php endif; ?>

        <?php
        $num_cols     = !empty($settings['columns']) ? max(1, intval($settings['columns'])) : 2;
        $distribution = !empty($settings['column_distribution']) ? $settings['column_distribution'] : 'split';
        $all_items    = !empty($settings['royalaccordions']) && is_array($settings['royalaccordions']) ? $settings['royalaccordions'] : [];
        $total_items  = count($all_items);

        // Group items into separate column arrays so each column is independent
        $columns_items = [];
        for ( $c = 0; $c < $num_cols; $c++ ) {
          $columns_items[$c] = [];
        }

        if ( $num_cols === 1 ) {
          foreach ( $all_items as $idx => $item ) {
            $columns_items[0][] = [ 'index' => $idx, 'item' => $item ];
          }
        } elseif ( $distribution === 'alternating' ) {
          foreach ( $all_items as $idx => $item ) {
            $col_idx = $idx % $num_cols;
            $columns_items[$col_idx][] = [ 'index' => $idx, 'item' => $item ];
          }
        } else {
          // Evenly split items across columns (1, 2, 3 in col 1; 4, 5, 6 in col 2)
          $items_per_col = (int) ceil( $total_items / $num_cols );
          if ( $items_per_col < 1 ) {
            $items_per_col = 1;
          }
          foreach ( $all_items as $idx => $item ) {
            $col_idx = (int) floor( $idx / $items_per_col );
            if ( $col_idx >= $num_cols ) {
              $col_idx = $num_cols - 1;
            }
            $columns_items[$col_idx][] = [ 'index' => $idx, 'item' => $item ];
          }
        }
        ?>

        <div class="royalacc-items-grid">
          <?php if ( !empty($columns_items) && is_array($columns_items) ) : ?>
            <?php foreach ( $columns_items as $c_idx => $c_items ) : ?>
              <div class="royalacc-column royalacc-col-<?php echo ($c_idx + 1); ?>">
                <?php foreach ( $c_items as $item_wrapper ) :
                $index = $item_wrapper['index'];
                $item  = $item_wrapper['item'];

                $is_active = false;
                if ( $defaultstate === 'expanded' && $index === 0 ) {
                  $is_active = true;
                } elseif ( $defaultstate === 'all_expanded' ) {
                  $is_active = true;
                }

                $heading_classes = [
                  'royalaccitemheading',
                  'ui-accordion-header',
                  $is_active ? 'ui-accordion-header-active' : 'ui-accordion-header-collapsed',
                ];

                $item_classes = [
                  'royalaccitem',
                  $is_active ? 'royalacc-active' : '',
                ];

                $content_style = $is_active ? 'display: block;' : 'display: none;';
                $item_hash_id  = !empty($item['item_hash_id']) ? sanitize_title($item['item_hash_id']) : ($royalaccid . '-item-' . ($index + 1));
                $title_tag     = !empty($item['title_tag']) ? $item['title_tag'] : 'h3';
              ?>
                <div class="<?php echo esc_attr( trim(implode(' ', $item_classes)) ); ?>" id="<?php echo esc_attr( $item_hash_id ); ?>" data-index="<?php echo esc_attr( $index ); ?>">
                  <dt class="<?php echo esc_attr( implode(' ', $heading_classes) ); ?>" role="button" tabindex="0" aria-expanded="<?php echo $is_active ? 'true' : 'false'; ?>">
                    <<?php echo tag_escape($title_tag); ?> class="title"><?php echo wp_kses_post( $item['royal_acc_title'] ); ?></<?php echo tag_escape($title_tag); ?>>
                    <?php if ( $has_open_icon || $has_closed_icon ) : ?>
                      <div class="royalaccicon">
                        <span class="icon-open"><?php Icons_Manager::render_icon( $settings['icon_open'], [ 'aria-hidden' => 'true' ] ); ?></span>
                        <span class="icon-closed"><?php Icons_Manager::render_icon( $settings['icon_closed'], [ 'aria-hidden' => 'true' ] ); ?></span>
                      </div>
                    <?php endif; ?>
                  </dt>
                  <div class="royalaccitemcontent" style="<?php echo esc_attr( $content_style ); ?>">
                    <div class="royalaccitemcontent-inner">
                      <?php echo $item['royal_acc_description']; ?>
                    </div>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
          <?php endforeach; ?>
          <?php endif; ?>
        </div>
      </div>

      <script type="text/javascript">
        if ( typeof window.royalAccordionInit === 'function' ) {
          jQuery(function($) {
            window.royalAccordionInit( $('#<?php echo esc_js($royalaccid); ?>'), $ );
          });
        }
      </script>
      <?php
    }
  }

}
