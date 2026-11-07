<?php
namespace RoyalAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;

defined('ABSPATH') || die();

class RoyalAds extends Widget_Base {

	public function get_name() {
		return 'royalads';
	}

	public function get_title() {
		return __('Royal Ads', 'royal-addons-for-elementor');
	}

	public function get_icon() {
		return 'eicon-code-highlight rtbranding';
	}

	public function get_keywords() {
		return [ 'ads', 'random', 'code', 'image', 'banner', 'popup', 'royal-addons-for-elementor', 'royal', 'mehdi', 'akram', 'tech' ];
	}

	public function get_style_depends() {
		return [ 'royalads' ];
	}

	public function get_script_depends() {
		return [ 'royalads' ];
	}

	public function get_categories() {
		return [ 'royal-addons-for-elementor' ];
	}

	protected function register_controls() {
		$this->ads_content_controls();
		$this->ads_display_controls();
		$this->ads_size_controls();
		$this->ads_popup_controls();
		$this->ads_style_controls();
	}

	/* =============================================
	   Content Tab → Ads Items
	   ============================================= */
	protected function ads_content_controls() {
		$this->start_controls_section(
			'ads_section',
			[
				'label' => __('Royal Ads', 'royal-addons-for-elementor'),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		/* ─── Style: Code or Image ─── */
		$this->add_control(
			'ad_style',
			[
				'label'   => esc_html__('Ad Content Type', 'royal-addons-for-elementor'),
				'type'    => Controls_Manager::SELECT,
				'default' => 'randomcode',
				'options' => [
					'randomcode'  => esc_html__('Code (HTML/Script)', 'royal-addons-for-elementor'),
					'randomimage' => esc_html__('Image', 'royal-addons-for-elementor'),
				],
			]
		);

		/* ─── Repeater ─── */
		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'royal_ad_title',
			[
				'label'       => __('Label', 'royal-addons-for-elementor'),
				'type'        => Controls_Manager::TEXT,
				'default'     => __('Ad 1', 'royal-addons-for-elementor'),
				'label_block' => true,
			]
		);

		/* Code field */
		$repeater->add_control(
			'royal_ad_code',
			[
				'label'     => __('Ad Code (HTML / Script)', 'royal-addons-for-elementor'),
				'type'      => Controls_Manager::CODE,
				'language'  => 'html',
				'rows'      => 10,
				'default'   => '<!-- Paste your ad code here -->',
				'condition' => [ 'royal_ad_type_note!' => 'dummy' ], // always shown; controlled via PHP
			]
		);

		/* Image field */
		$repeater->add_control(
			'royal_ad_image',
			[
				'label'   => __('Ad Image', 'royal-addons-for-elementor'),
				'type'    => Controls_Manager::MEDIA,
				'default' => [ 'url' => \Elementor\Utils::get_placeholder_image_src() ],
			]
		);

		$repeater->add_control(
			'royal_ad_link',
			[
				'label'         => __('Link', 'royal-addons-for-elementor'),
				'type'          => Controls_Manager::URL,
				'placeholder'   => 'https://example.com',
				'show_external' => true,
				'default'       => [ 'url' => '' ],
			]
		);

		$repeater->add_control(
			'royal_ad_alt',
			[
				'label'   => __('Image Alt Text', 'royal-addons-for-elementor'),
				'type'    => Controls_Manager::TEXT,
				'default' => '',
			]
		);

		$this->add_control(
			'royal_ads',
			[
				'label'       => __('Ads', 'royal-addons-for-elementor'),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => [
					[ 'royal_ad_title' => 'Ad 1' ],
					[ 'royal_ad_title' => 'Ad 2' ],
					[ 'royal_ad_title' => 'Ad 3' ],
				],
				'title_field' => '{{{ royal_ad_title }}}',
			]
		);

		$this->end_controls_section();
	}

	/* =============================================
	   Content Tab → Display / Rotation Settings
	   ============================================= */
	protected function ads_display_controls() {
		$this->start_controls_section(
			'ads_display_section',
			[
				'label' => __('Display & Rotation', 'royal-addons-for-elementor'),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		/* Order */
		$this->add_control(
			'ad_order',
			[
				'label'   => esc_html__('Show Ad', 'royal-addons-for-elementor'),
				'type'    => Controls_Manager::SELECT,
				'default' => 'random',
				'options' => [
					'random'     => esc_html__('Random (pick one)', 'royal-addons-for-elementor'),
					'sequential' => esc_html__('Sequential (one by one)', 'royal-addons-for-elementor'),
					'all'        => esc_html__('All at once', 'royal-addons-for-elementor'),
				],
			]
		);

		/* Auto-change */
		$this->add_control(
			'ad_auto_change',
			[
				'label'        => esc_html__('Auto Change', 'royal-addons-for-elementor'),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __('Yes', 'royal-addons-for-elementor'),
				'label_off'    => __('No', 'royal-addons-for-elementor'),
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => [ 'ad_order' => 'sequential' ],
			]
		);

		$this->add_control(
			'ad_auto_interval',
			[
				'label'       => esc_html__('Change Interval (seconds)', 'royal-addons-for-elementor'),
				'type'        => Controls_Manager::NUMBER,
				'min'         => 1,
				'max'         => 120,
				'step'        => 1,
				'default'     => 5,
				'condition'   => [
					'ad_order'       => 'sequential',
					'ad_auto_change' => 'yes',
				],
			]
		);

		/* When to change */
		$this->add_control(
			'ad_change_on',
			[
				'label'   => esc_html__('Trigger', 'royal-addons-for-elementor'),
				'type'    => Controls_Manager::SELECT,
				'default' => 'load',
				'options' => [
					'load'   => esc_html__('On Page Load (once)', 'royal-addons-for-elementor'),
					'timer'  => esc_html__('Every X Seconds (interval)', 'royal-addons-for-elementor'),
				],
				'condition' => [ 'ad_order!' => 'all' ],
			]
		);

		/* Transition */
		$this->add_control(
			'ad_transition',
			[
				'label'     => esc_html__('Transition Effect', 'royal-addons-for-elementor'),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'fade',
				'options'   => [
					'none'  => esc_html__('None', 'royal-addons-for-elementor'),
					'fade'  => esc_html__('Fade', 'royal-addons-for-elementor'),
					'slide' => esc_html__('Slide', 'royal-addons-for-elementor'),
				],
				'condition' => [ 'ad_order' => 'sequential' ],
			]
		);

		/* Show dots */
		$this->add_control(
			'ad_show_dots',
			[
				'label'        => esc_html__('Show Navigation Dots', 'royal-addons-for-elementor'),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __('Yes', 'royal-addons-for-elementor'),
				'label_off'    => __('No', 'royal-addons-for-elementor'),
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => [ 'ad_order' => 'sequential' ],
			]
		);

		/* Show arrows */
		$this->add_control(
			'ad_show_arrows',
			[
				'label'        => esc_html__('Show Arrows', 'royal-addons-for-elementor'),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __('Yes', 'royal-addons-for-elementor'),
				'label_off'    => __('No', 'royal-addons-for-elementor'),
				'return_value' => 'yes',
				'default'      => 'no',
				'condition'    => [ 'ad_order' => 'sequential' ],
			]
		);

		$this->end_controls_section();
	}

	/* =============================================
	   Content Tab → Size Settings
	   ============================================= */
	protected function ads_size_controls() {
		$this->start_controls_section(
			'ads_size_section',
			[
				'label' => __('Size & Dimensions', 'royal-addons-for-elementor'),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'size_notice',
			[
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => __('<small>Set width/height for desktop, tablet, and mobile separately. Leave blank to use auto/parent size.</small>', 'royal-addons-for-elementor'),
				'content_classes' => 'elementor-descriptor',
			]
		);

		/* ── Desktop ── */
		$this->add_control(
			'size_desktop_heading',
			[
				'label'     => __('Desktop', 'royal-addons-for-elementor'),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'ad_width',
			[
				'label'      => esc_html__('Width', 'royal-addons-for-elementor'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vw' ],
				'range'      => [
					'px' => [ 'min' => 50, 'max' => 2000 ],
					'%'  => [ 'min' => 10, 'max' => 100  ],
					'vw' => [ 'min' => 10, 'max' => 100  ],
				],
				'default'    => [ 'unit' => '%', 'size' => 100 ],
				'selectors'  => [
					'{{WRAPPER}} .royalads-wrapper' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'ad_height',
			[
				'label'      => esc_html__('Height', 'royal-addons-for-elementor'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'vh', 'em' ],
				'range'      => [
					'px' => [ 'min' => 50,  'max' => 1200 ],
					'vh' => [ 'min' => 10,  'max' => 100  ],
					'em' => [ 'min' => 1,   'max' => 100  ],
				],
				'default'    => [ 'unit' => 'px', 'size' => 250 ],
				'selectors'  => [
					'{{WRAPPER}} .royalads-wrapper'    => 'height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .royaladscontainer'   => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		/* Max constraints */
		$this->add_responsive_control(
			'ad_max_width',
			[
				'label'      => esc_html__('Max Width', 'royal-addons-for-elementor'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vw' ],
				'range'      => [
					'px' => [ 'min' => 50, 'max' => 2000 ],
					'%'  => [ 'min' => 10, 'max' => 100  ],
				],
				'default'    => [ 'unit' => 'px', 'size' => '' ],
				'selectors'  => [
					'{{WRAPPER}} .royalads-wrapper' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'ad_max_height',
			[
				'label'      => esc_html__('Max Height', 'royal-addons-for-elementor'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'vh' ],
				'range'      => [
					'px' => [ 'min' => 50,  'max' => 1200 ],
					'vh' => [ 'min' => 10,  'max' => 100  ],
				],
				'selectors'  => [
					'{{WRAPPER}} .royalads-wrapper' => 'max-height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		/* Image object-fit */
		$this->add_control(
			'ad_image_fit',
			[
				'label'     => esc_html__('Image Fit', 'royal-addons-for-elementor'),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'cover',
				'options'   => [
					'cover'   => esc_html__('Cover', 'royal-addons-for-elementor'),
					'contain' => esc_html__('Contain', 'royal-addons-for-elementor'),
					'fill'    => esc_html__('Fill', 'royal-addons-for-elementor'),
					'none'    => esc_html__('None', 'royal-addons-for-elementor'),
				],
				'selectors' => [
					'{{WRAPPER}} .royalad-image-wrap img' => 'object-fit: {{VALUE}};',
				],
				'condition' => [ 'ad_style' => 'randomimage' ],
			]
		);

		$this->end_controls_section();
	}

	/* =============================================
	   Content Tab → Popup Settings
	   ============================================= */
	protected function ads_popup_controls() {
		$this->start_controls_section(
			'ads_popup_section',
			[
				'label' => __('Popup Settings', 'royal-addons-for-elementor'),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'popup_enable',
			[
				'label'        => esc_html__('Show as Popup', 'royal-addons-for-elementor'),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __('Yes', 'royal-addons-for-elementor'),
				'label_off'    => __('No', 'royal-addons-for-elementor'),
				'return_value' => 'yes',
				'default'      => '',
			]
		);

		$this->add_control(
			'popup_trigger',
			[
				'label'     => esc_html__('Popup Trigger', 'royal-addons-for-elementor'),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'load',
				'options'   => [
					'load'  => esc_html__('On Page Load', 'royal-addons-for-elementor'),
					'delay' => esc_html__('After Delay', 'royal-addons-for-elementor'),
					'scroll' => esc_html__('On Scroll (%)', 'royal-addons-for-elementor'),
				],
				'condition' => [ 'popup_enable' => 'yes' ],
			]
		);

		$this->add_control(
			'popup_delay',
			[
				'label'     => esc_html__('Delay (seconds)', 'royal-addons-for-elementor'),
				'type'      => Controls_Manager::NUMBER,
				'min'       => 0,
				'max'       => 60,
				'step'      => 1,
				'default'   => 3,
				'condition' => [
					'popup_enable'  => 'yes',
					'popup_trigger' => 'delay',
				],
			]
		);

		$this->add_control(
			'popup_scroll_pct',
			[
				'label'     => esc_html__('Scroll Percentage (%)', 'royal-addons-for-elementor'),
				'type'      => Controls_Manager::NUMBER,
				'min'       => 5,
				'max'       => 100,
				'step'      => 5,
				'default'   => 30,
				'condition' => [
					'popup_enable'  => 'yes',
					'popup_trigger' => 'scroll',
				],
			]
		);

		$this->add_control(
			'popup_show_close',
			[
				'label'        => esc_html__('Show Close Button', 'royal-addons-for-elementor'),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __('Yes', 'royal-addons-for-elementor'),
				'label_off'    => __('No', 'royal-addons-for-elementor'),
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => [ 'popup_enable' => 'yes' ],
			]
		);

		$this->add_control(
			'popup_close_delay',
			[
				'label'     => esc_html__('Auto-close After (seconds, 0 = never)', 'royal-addons-for-elementor'),
				'type'      => Controls_Manager::NUMBER,
				'min'       => 0,
				'max'       => 120,
				'step'      => 1,
				'default'   => 0,
				'condition' => [ 'popup_enable' => 'yes' ],
			]
		);

		$this->add_control(
			'popup_overlay_close',
			[
				'label'        => esc_html__('Close on Overlay Click', 'royal-addons-for-elementor'),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __('Yes', 'royal-addons-for-elementor'),
				'label_off'    => __('No', 'royal-addons-for-elementor'),
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => [ 'popup_enable' => 'yes' ],
			]
		);

		/* Popup width / height */
		$this->add_control(
			'popup_width',
			[
				'label'      => esc_html__('Popup Width', 'royal-addons-for-elementor'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vw' ],
				'range'      => [
					'px' => [ 'min' => 100, 'max' => 2000 ],
					'%'  => [ 'min' => 10,  'max' => 100  ],
					'vw' => [ 'min' => 10,  'max' => 100  ],
				],
				'default'    => [ 'unit' => 'px', 'size' => 728 ],
				'selectors'  => [
					'{{WRAPPER}} .royalads-popup-box' => 'width: {{SIZE}}{{UNIT}};',
				],
				'condition'  => [ 'popup_enable' => 'yes' ],
			]
		);

		$this->add_control(
			'popup_height',
			[
				'label'      => esc_html__('Popup Height', 'royal-addons-for-elementor'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'vh' ],
				'range'      => [
					'px' => [ 'min' => 50,  'max' => 1200 ],
					'vh' => [ 'min' => 10,  'max' => 100  ],
				],
				'default'    => [ 'unit' => 'px', 'size' => 90 ],
				'selectors'  => [
					'{{WRAPPER}} .royalads-popup-box'              => 'height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .royalads-popup-box .royalads-wrapper' => 'height: {{SIZE}}{{UNIT}};',
				],
				'condition'  => [ 'popup_enable' => 'yes' ],
			]
		);

		$this->end_controls_section();
	}

	/* =============================================
	   Style Tab
	   ============================================= */
	protected function ads_style_controls() {
		$this->start_controls_section(
			'ads_style_section',
			[
				'label' => __('Container Style', 'royal-addons-for-elementor'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'ad_bg_color',
			[
				'label'     => esc_html__('Background Color', 'royal-addons-for-elementor'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .royalads-wrapper' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'ad_border',
				'selector' => '{{WRAPPER}} .royalads-wrapper',
			]
		);

		$this->add_responsive_control(
			'ad_border_radius',
			[
				'label'      => esc_html__('Border Radius', 'royal-addons-for-elementor'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .royalads-wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'ad_box_shadow',
				'selector' => '{{WRAPPER}} .royalads-wrapper',
			]
		);

		$this->add_responsive_control(
			'ad_padding',
			[
				'label'      => esc_html__('Padding', 'royal-addons-for-elementor'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .royalads-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		/* Dot style */
		$this->add_control(
			'dots_heading',
			[
				'label'     => __('Dots Style', 'royal-addons-for-elementor'),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'dot_color',
			[
				'label'     => esc_html__('Dot Color', 'royal-addons-for-elementor'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#cccccc',
				'selectors' => [
					'{{WRAPPER}} .royalads-dot' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'dot_active_color',
			[
				'label'     => esc_html__('Active Dot Color', 'royal-addons-for-elementor'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#333333',
				'selectors' => [
					'{{WRAPPER}} .royalads-dot.active' => 'background: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/* =============================================
	   Render
	   ============================================= */
	protected function render() {
		$settings   = $this->get_settings_for_display();
		$id         = $this->get_id();
		$uid        = 'royalad_' . $id;
		$ads        = $settings['royal_ads'];
		$ad_style   = $settings['ad_style'];         // 'randomcode' | 'randomimage'
		$ad_order   = $settings['ad_order'];          // 'random' | 'sequential' | 'all'
		$change_on  = $settings['ad_change_on'];      // 'load' | 'timer'
		$auto       = $settings['ad_auto_change'];    // 'yes' | ''
		$interval   = (int) $settings['ad_auto_interval'] ?: 5;
		$transition = $settings['ad_transition'];     // 'none' | 'fade' | 'slide'
		$show_dots  = $settings['ad_show_dots'];
		$show_arrows= $settings['ad_show_arrows'];

		// Popup
		$popup_on     = $settings['popup_enable'];
		$pop_trigger  = $settings['popup_trigger'];
		$pop_delay    = (int) $settings['popup_delay'];
		$pop_scroll   = (int) $settings['popup_scroll_pct'];
		$pop_close    = $settings['popup_show_close'];
		$pop_autoclose= (int) $settings['popup_close_delay'];
		$pop_overlay  = $settings['popup_overlay_close'];

		// Transition class
		$trans_class = ( $ad_order === 'sequential' && in_array( $transition, ['fade', 'slide'], true ) )
			? 'royalads-' . $transition
			: '';

		// JS config passed to script
		$js_config = [
			'uid'        => $uid,
			'order'      => $ad_order,
			'changeOn'   => $change_on,
			'auto'       => ( $auto === 'yes' ),
			'interval'   => $interval * 1000,
			'transition' => $transition,
			'showDots'   => ( $show_dots === 'yes' ),
			'showArrows' => ( $show_arrows === 'yes' ),
			'popup'      => [
				'enable'        => ( $popup_on === 'yes' ),
				'trigger'       => $pop_trigger,
				'delay'         => $pop_delay * 1000,
				'scrollPct'     => $pop_scroll,
				'autoClose'     => $pop_autoclose * 1000,
				'overlayClose'  => ( $pop_overlay === 'yes' ),
			],
		];

		$wrapper_class = implode( ' ', array_filter([
			'royalads-wrapper',
			$trans_class,
		]) );

		// ── Popup outer ──
		if ( $popup_on === 'yes' ) :
			echo '<div id="' . esc_attr($uid) . '_overlay" class="royalads-popup-overlay">';
			echo '<div class="royalads-popup-box">';
			if ( $pop_close === 'yes' ) {
				echo '<button class="royalads-close" aria-label="' . esc_attr__('Close', 'royal-addons-for-elementor') . '">&times;</button>';
			}
		endif;

		// ── Wrapper ──
		echo '<div id="' . esc_attr($uid) . '" class="' . esc_attr($wrapper_class) . '">';

		// Arrows
		if ( $ad_order === 'sequential' && $show_arrows === 'yes' ) {
			echo '<button class="royalads-nav royalads-nav-prev" aria-label="Previous">&#10094;</button>';
			echo '<button class="royalads-nav royalads-nav-next" aria-label="Next">&#10095;</button>';
		}

		echo '<div class="royaladscontainer">';

		foreach ( $ads as $ad ) {
			echo '<div class="royalad">';

			if ( $ad_style === 'randomimage' ) {
				$img_url = ! empty($ad['royal_ad_image']['url']) ? $ad['royal_ad_image']['url'] : '';
				$img_alt = ! empty($ad['royal_ad_alt']) ? esc_attr($ad['royal_ad_alt']) : esc_attr($ad['royal_ad_title']);
				$link    = ! empty($ad['royal_ad_link']['url']) ? $ad['royal_ad_link']['url'] : '';
				$target  = ( ! empty($ad['royal_ad_link']['is_external']) ) ? '_blank' : '_self';
				$nofollow= ( ! empty($ad['royal_ad_link']['nofollow']) ) ? ' rel="nofollow"' : '';

				if ( $link ) {
					echo '<a href="' . esc_url($link) . '" target="' . esc_attr($target) . '"' . $nofollow . ' class="royalad-image-wrap">';
					echo '<img src="' . esc_url($img_url) . '" alt="' . $img_alt . '" loading="lazy">';
					echo '</a>';
				} else {
					echo '<span class="royalad-image-wrap">';
					echo '<img src="' . esc_url($img_url) . '" alt="' . $img_alt . '" loading="lazy">';
					echo '</span>';
				}
			} else {
				// Raw code – intentional, ad networks need raw HTML/script
				echo $ad['royal_ad_code']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}

			echo '</div>'; // .royalad
		}

		echo '</div>'; // .royaladscontainer

		// Navigation dots
		if ( $ad_order === 'sequential' && $show_dots === 'yes' ) {
			echo '<div class="royalads-dots">';
			foreach ( $ads as $i => $ad ) {
				$active = ($i === 0) ? ' active' : '';
				echo '<span class="royalads-dot' . $active . '" data-index="' . $i . '"></span>';
			}
			echo '</div>';
		}

		echo '</div>'; // .royalads-wrapper

		// Close popup markup
		if ( $popup_on === 'yes' ) :
			echo '</div>'; // .royalads-popup-box
			echo '</div>'; // .royalads-popup-overlay
		endif;

		// ── Inline JS config ──
		?>
		<script>
		(function(){
			var cfg = <?php echo wp_json_encode( $js_config ); ?>;
			if ( typeof window.RoyalAdsQueue === 'undefined' ) { window.RoyalAdsQueue = []; }
			window.RoyalAdsQueue.push(cfg);
		})();
		</script>
		<?php
	}
}
