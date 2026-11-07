<?php
namespace RoyalAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Css_Filter;
use Elementor\Repeater;
use RoyalAddons\Elementor\Royal_Helpers;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class RoyalInfiniteScroll extends Widget_Base {

	public function get_name() {
		return 'royalinfinitescroll';
	}

	public function get_title() {
		return __( 'Infinite Scroll', 'royal-addons-for-elementor' );
	}

	public function get_icon() {
		return 'royalinfinitescroll rtbranding';
	}

	public function get_keywords() {
		return [ 'infinite', 'scroll', 'marquee', 'ticker', 'partner', 'logo', 'carousel', 'royal', 'mehdi', 'akram' ];
	}

	public function get_categories() {
		return [ 'royaltech' ];
	}

	public function get_style_depends() {
		return [ 'royalinfinitescroll' ];
	}

	public function get_script_depends() {
		return [ 'royalinfinitescroll' ];
	}

	protected function register_controls() {
		$this->register_preset_options();
		$this->register_source_options();
		$this->register_custom_items_options();
		$this->register_gallery_options();
		$this->register_text_options();
		$this->register_post_options();
		$this->register_layout_options();
		$this->register_animation_options();

		$this->register_style_general_options();
		$this->register_style_card_options();
		$this->register_style_media_options();
		$this->register_style_title_options();
		$this->register_style_subtitle_options();
		$this->register_style_badge_options();
	}

	/**
	 * Preset Style Options
	 */
	private function register_preset_options() {
		$this->start_controls_section(
			'section_preset',
			[
				'label' => esc_html__( 'Preset & Style', 'royal-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'preset_style',
			[
				'label'   => esc_html__( 'Design Style', 'royal-addons-for-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'partner_card',
				'options' => [
					'partner_card'   => esc_html__( 'Partner Card (Unnayan Prochesta Style)', 'royal-addons-for-elementor' ),
					'classic_badge'  => esc_html__( 'Classic Badge / Tech Tag', 'royal-addons-for-elementor' ),
					'modern_pill'    => esc_html__( 'Modern Floating Pill', 'royal-addons-for-elementor' ),
					'glassmorphism'  => esc_html__( 'Glassmorphism / Frosted Glass', 'royal-addons-for-elementor' ),
					'neon_border'    => esc_html__( 'Neon / Gradient Glow', 'royal-addons-for-elementor' ),
					'minimal_clean'  => esc_html__( 'Minimal Clean Logos', 'royal-addons-for-elementor' ),
					'detailed_card'  => esc_html__( 'Detailed Brand Card', 'royal-addons-for-elementor' ),
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Scroll Source Options
	 */
	private function register_source_options() {
		$this->start_controls_section(
			'section_source',
			[
				'label' => esc_html__( 'Scroll Source', 'royal-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'source',
			[
				'label'   => esc_html__( 'Content Source', 'royal-addons-for-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'custom',
				'options' => [
					'custom'  => esc_html__( 'Custom Cards / Logos (With Individual Links)', 'royal-addons-for-elementor' ),
					'gallery' => esc_html__( 'Image Gallery', 'royal-addons-for-elementor' ),
					'text'    => esc_html__( 'Text List', 'royal-addons-for-elementor' ),
					'post'    => esc_html__( 'Post Query', 'royal-addons-for-elementor' ),
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Default items for custom source
	 */
	public function get_default_custom_items() {
		$placeholder = Utils::get_placeholder_image_src();
		return [
			[
				'title'    => 'PKSF',
				'subtitle' => 'Palli Karma-Sahayak Foundation',
				'image'    => [ 'url' => $placeholder ],
				'link'     => [ 'url' => 'https://pksf.org.bd', 'is_external' => true ],
			],
			[
				'title'    => 'MRA',
				'subtitle' => 'Microcredit Regulatory Authority',
				'image'    => [ 'url' => $placeholder ],
				'link'     => [ 'url' => 'https://mra.gov.bd', 'is_external' => true ],
			],
			[
				'title'    => 'NGO Affairs',
				'subtitle' => 'Prime Minister Office BD',
				'image'    => [ 'url' => $placeholder ],
				'link'     => [ 'url' => 'http://www.ngoab.gov.bd', 'is_external' => true ],
			],
			[
				'title'    => 'Social Welfare',
				'subtitle' => 'Ministry of Social Welfare',
				'image'    => [ 'url' => $placeholder ],
				'link'     => [ 'url' => 'https://msw.gov.bd', 'is_external' => true ],
			],
			[
				'title'    => 'Bangladesh Bank',
				'subtitle' => 'Central Bank of Bangladesh',
				'image'    => [ 'url' => $placeholder ],
				'link'     => [ 'url' => 'https://www.bb.org.bd', 'is_external' => true ],
			],
			[
				'title'    => 'UNDP Partner',
				'subtitle' => 'Community Resilience Network',
				'image'    => [ 'url' => $placeholder ],
				'link'     => [ 'url' => 'https://www.undp.org', 'is_external' => true ],
			],
			[
				'title'    => 'WASH BD',
				'subtitle' => 'Water & Sanitation Initiative',
				'image'    => [ 'url' => $placeholder ],
				'link'     => [ 'url' => 'https://wateraid.org', 'is_external' => true ],
			],
			[
				'title'    => 'PKSF - ENRICH',
				'subtitle' => 'Enhancing Resources & Capacity',
				'image'    => [ 'url' => $placeholder ],
				'link'     => [ 'url' => 'https://pksf.org.bd', 'is_external' => true ],
			],
		];
	}

	/**
	 * Custom Items (with individual links, images, titles, subtitles, badges)
	 */
	private function register_custom_items_options() {
		$this->start_controls_section(
			'section_source_custom',
			[
				'label'     => esc_html__( 'Custom Cards & Logos', 'royal-addons-for-elementor' ),
				'condition' => [
					'source' => 'custom',
				],
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'image',
			[
				'label'   => esc_html__( 'Logo / Image', 'royal-addons-for-elementor' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$repeater->add_control(
			'link',
			[
				'label'       => esc_html__( 'Custom Link URL', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'royal-addons-for-elementor' ),
				'default'     => [
					'url'         => '',
					'is_external' => true,
					'nofollow'    => false,
				],
				'dynamic'     => [
					'active' => true,
				],
			]
		);

		$repeater->add_control(
			'title',
			[
				'label'       => esc_html__( 'Title (Optional)', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'label_block' => true,
				'dynamic'     => [
					'active' => true,
				],
			]
		);

		$repeater->add_control(
			'subtitle',
			[
				'label'       => esc_html__( 'Subtitle (Optional)', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'label_block' => true,
				'dynamic'     => [
					'active' => true,
				],
			]
		);

		$repeater->add_control(
			'badge',
			[
				'label'       => esc_html__( 'Tag / Badge (Optional)', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'label_block' => true,
			]
		);

		$this->add_control(
			'custom_items',
			[
				'label'       => esc_html__( 'Items List', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => $this->get_default_custom_items(),
				'title_field' => '{{{ title || "Card Item" }}}',
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'custom_image_thumbnail',
				'default'   => 'medium',
				'separator' => 'before',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Gallery Source Options
	 */
	private function register_gallery_options() {
		$this->start_controls_section(
			'section_source_gallery',
			[
				'label'     => esc_html__( 'Gallery Images', 'royal-addons-for-elementor' ),
				'condition' => [
					'source' => 'gallery',
				],
			]
		);

		$this->add_control(
			'image_gallery',
			[
				'label'      => esc_html__( 'Add Images', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::GALLERY,
				'default'    => [],
				'show_label' => false,
				'dynamic'    => [
					'active' => true,
				],
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'    => 'image_thumbnail',
				'default' => 'medium',
				'exclude' => [ 'custom' ],
			]
		);

		$this->add_control(
			'gallery_link_type',
			[
				'label'     => esc_html__( 'Link Images To', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'none',
				'separator' => 'before',
				'options'   => [
					'none'       => esc_html__( 'None', 'royal-addons-for-elementor' ),
					'custom'     => esc_html__( 'Custom Links (Per Image)', 'royal-addons-for-elementor' ),
					'file'       => esc_html__( 'Media File', 'royal-addons-for-elementor' ),
					'attachment' => esc_html__( 'Attachment Page', 'royal-addons-for-elementor' ),
				],
			]
		);

		$this->add_control(
			'gallery_custom_links',
			[
				'label'       => esc_html__( 'Custom Image Links', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXTAREA,
				'placeholder' => "https://link1.com\nhttps://link2.com\nhttps://link3.com",
				'description' => esc_html__( 'Enter individual URL for each gallery image in order, one per line.', 'royal-addons-for-elementor' ),
				'condition'   => [
					'gallery_link_type' => 'custom',
				],
			]
		);

		$this->add_control(
			'gallery_link_external',
			[
				'label'        => esc_html__( 'Open in New Window', 'royal-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'return_value' => 'yes',
				'condition'    => [
					'gallery_link_type!' => 'none',
				],
			]
		);

		$this->add_control(
			'gallery_link_nofollow',
			[
				'label'        => esc_html__( 'Add nofollow', 'royal-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'no',
				'return_value' => 'yes',
				'condition'    => [
					'gallery_link_type!' => 'none',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Text Source Options
	 */
	private function register_text_options() {
		$this->start_controls_section(
			'section_source_text',
			[
				'label'     => esc_html__( 'Text Items', 'royal-addons-for-elementor' ),
				'condition' => [
					'source' => 'text',
				],
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'text_title',
			[
				'label'       => esc_html__( 'Text', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Item', 'royal-addons-for-elementor' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'text_subtitle',
			[
				'label'       => esc_html__( 'Subtitle (Optional)', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'text_link',
			[
				'label'       => esc_html__( 'Link URL (Optional)', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'royal-addons-for-elementor' ),
				'default'     => [
					'url' => '',
				],
			]
		);

		$this->add_control(
			'text_all',
			[
				'label'       => esc_html__( 'Text List', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => [
					[ 'text_title' => esc_html__( 'HTML5', 'royal-addons-for-elementor' ) ],
					[ 'text_title' => esc_html__( 'CSS3', 'royal-addons-for-elementor' ) ],
					[ 'text_title' => esc_html__( 'JavaScript', 'royal-addons-for-elementor' ) ],
					[ 'text_title' => esc_html__( 'React', 'royal-addons-for-elementor' ) ],
					[ 'text_title' => esc_html__( 'WordPress', 'royal-addons-for-elementor' ) ],
					[ 'text_title' => esc_html__( 'Elementor', 'royal-addons-for-elementor' ) ],
					[ 'text_title' => esc_html__( 'PHP', 'royal-addons-for-elementor' ) ],
				],
				'title_field' => '{{{ text_title }}}',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Post Source Options
	 */
	private function register_post_options() {
		$this->start_controls_section(
			'section_source_post',
			[
				'label'     => esc_html__( 'Post Query', 'royal-addons-for-elementor' ),
				'condition' => [
					'source' => 'post',
				],
			]
		);

		$this->add_control(
			'posts_per_page',
			[
				'label'   => esc_html__( 'Number of Posts', 'royal-addons-for-elementor' ),
				'type'    => Controls_Manager::NUMBER,
				'min'     => -1,
				'max'     => 100,
				'step'    => 1,
				'default' => 10,
			]
		);

		$this->add_control(
			'post_categories',
			[
				'label'       => esc_html__( 'Categories', 'royal-addons-for-elementor' ),
				'label_block' => true,
				'type'        => Controls_Manager::SELECT2,
				'multiple'    => true,
				'options'     => Royal_Helpers::royal_categories( 'post' ),
			]
		);

		$this->add_control(
			'orderby',
			[
				'label'   => esc_html__( 'Order By', 'royal-addons-for-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'post_date',
				'options' => [
					'post_date'  => esc_html__( 'Date', 'royal-addons-for-elementor' ),
					'post_title' => esc_html__( 'Title', 'royal-addons-for-elementor' ),
					'rand'       => esc_html__( 'Random', 'royal-addons-for-elementor' ),
				],
			]
		);

		$this->add_control(
			'order',
			[
				'label'   => esc_html__( 'Order', 'royal-addons-for-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'desc',
				'options' => [
					'asc'  => esc_html__( 'ASC', 'royal-addons-for-elementor' ),
					'desc' => esc_html__( 'DESC', 'royal-addons-for-elementor' ),
				],
			]
		);

		$this->add_control(
			'post_title_or_image',
			[
				'label'   => esc_html__( 'Display Post Format', 'royal-addons-for-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'both',
				'options' => [
					'title' => esc_html__( 'Title Only', 'royal-addons-for-elementor' ),
					'image' => esc_html__( 'Featured Image Only', 'royal-addons-for-elementor' ),
					'both'  => esc_html__( 'Image + Title Card', 'royal-addons-for-elementor' ),
				],
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'post_thumbnail',
				'default'   => 'medium',
				'condition' => [
					'post_title_or_image!' => 'title',
				],
				'exclude'   => [ 'custom' ],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Layout, Full Width & Mask Options
	 */
	private function register_layout_options() {
		$this->start_controls_section(
			'section_layout_settings',
			[
				'label' => esc_html__( 'Layout & Display', 'royal-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'card_sizing_mode',
			[
				'label'   => esc_html__( 'Item Sizing Mode', 'royal-addons-for-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'columns',
				'options' => [
					'columns' => esc_html__( 'Items to Show / Columns (Responsive)', 'royal-addons-for-elementor' ),
					'custom'  => esc_html__( 'Custom Fixed Width (px / %)', 'royal-addons-for-elementor' ),
				],
			]
		);

		$this->add_responsive_control(
			'items_to_show',
			[
				'label'           => esc_html__( 'Items to Show (Per View)', 'royal-addons-for-elementor' ),
				'type'            => Controls_Manager::SLIDER,
				'range'           => [
					'px' => [
						'min'  => 1,
						'max'  => 12,
						'step' => 0.1,
					],
				],
				'desktop_default' => [
					'size' => 5,
				],
				'tablet_default'  => [
					'size' => 3,
				],
				'mobile_default'  => [
					'size' => 2,
				],
				'selectors'       => [
					'{{WRAPPER}} .royalinfinitescroll' => '--royal-items-to-show: {{SIZE}};',
				],
				'condition'       => [
					'card_sizing_mode' => 'columns',
				],
				'description'     => esc_html__( 'Set how many items are visible on screen for Desktop, Tablet, and Mobile.', 'royal-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'full_width',
			[
				'label'        => esc_html__( 'Full Width (Bleed to Screen Edge)', 'royal-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'no',
				'return_value' => 'yes',
				'description'  => esc_html__( 'Enable to stretch the scroll 100vw edge-to-edge of the browser screen.', 'royal-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'pause_on_hover',
			[
				'label'        => esc_html__( 'Pause on Hover', 'royal-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'return_value' => 'yes',
			]
		);

		$this->add_control(
			'fade_mask',
			[
				'label'        => esc_html__( 'Fade Edges (Gradient Mask)', 'royal-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'return_value' => 'yes',
				'description'  => esc_html__( 'Creates an elegant edge fade effect on both sides.', 'royal-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'fade_mask_size',
			[
				'label'      => esc_html__( 'Fade Mask Size (%)', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ '%' ],
				'range'      => [
					'%' => [
						'min' => 2,
						'max' => 30,
					],
				],
				'default'    => [
					'unit' => '%',
					'size' => 8,
				],
				'selectors'  => [
					'{{WRAPPER}} .royalinfinitescroll' => '--royal-mask-size: {{SIZE}}%;',
				],
				'condition'  => [
					'fade_mask' => 'yes',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Animation Options
	 */
	private function register_animation_options() {
		$this->start_controls_section(
			'section_animation',
			[
				'label' => esc_html__( 'Animation Settings', 'royal-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'direction',
			[
				'label'   => esc_html__( 'Scroll Direction', 'royal-addons-for-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'left',
				'options' => [
					'left'  => esc_html__( 'Left', 'royal-addons-for-elementor' ),
					'right' => esc_html__( 'Right', 'royal-addons-for-elementor' ),
					'up'    => esc_html__( 'Up (Vertical)', 'royal-addons-for-elementor' ),
					'down'  => esc_html__( 'Down (Vertical)', 'royal-addons-for-elementor' ),
				],
			]
		);

		$this->add_control(
			'duration',
			[
				'label'       => esc_html__( 'Duration / Speed (Seconds)', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::NUMBER,
				'min'         => 3,
				'max'         => 200,
				'step'        => 1,
				'default'     => 30,
				'description' => esc_html__( 'Higher number = Slower smoother speed.', 'royal-addons-for-elementor' ),
			]
		);

		$this->end_controls_section();
	}

	/**
	 * STYLE: General Options
	 */
	private function register_style_general_options() {
		$this->start_controls_section(
			'style_section_general',
			[
				'label' => esc_html__( 'General Container', 'royal-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'width',
			[
				'label'      => esc_html__( 'Container Width', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ '%', 'px', 'vw', 'rem' ],
				'range'      => [
					'%'  => [ 'min' => 10, 'max' => 100 ],
					'px' => [ 'min' => 100, 'max' => 1920 ],
				],
				'default'    => [
					'unit' => '%',
					'size' => 100,
				],
				'selectors'  => [
					'{{WRAPPER}} .royalinfinitescroll:not(.royal-is-fullwidth)' => 'width: {{SIZE}}{{UNIT}};',
				],
				'condition'  => [
					'full_width!' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'height',
			[
				'label'      => esc_html__( 'Container Height', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'vh', 'rem' ],
				'range'      => [
					'px' => [ 'min' => 40, 'max' => 1200 ],
				],
				'selectors'  => [
					'{{WRAPPER}} .royalinfinitescroll' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'gap',
			[
				'label'      => esc_html__( 'Item Gap', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'rem' ],
				'range'      => [
					'px' => [ 'min' => 0, 'max' => 100 ],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 18,
				],
				'selectors'  => [
					'{{WRAPPER}} .royalinfinitescroll' => '--royal-item-gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'container_padding',
			[
				'label'      => esc_html__( 'Padding', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem' ],
				'selectors'  => [
					'{{WRAPPER}} .royalinfinitescroll' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'container_bg',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .royalinfinitescroll',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'container_border',
				'selector' => '{{WRAPPER}} .royalinfinitescroll',
			]
		);

		$this->add_control(
			'container_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors'  => [
					'{{WRAPPER}} .royalinfinitescroll' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * STYLE: Card / Item Options
	 */
	private function register_style_card_options() {
		$this->start_controls_section(
			'style_section_card',
			[
				'label' => esc_html__( 'Cards & Badges', 'royal-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'card_width',
			[
				'label'      => esc_html__( 'Card Width', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'rem', '%' ],
				'range'      => [
					'px' => [ 'min' => 40, 'max' => 800 ],
					'%'  => [ 'min' => 10, 'max' => 100 ],
				],
				'condition'  => [
					'card_sizing_mode' => 'custom',
				],
				'selectors'  => [
					'{{WRAPPER}} .royalinfinitescroll .royal-item-card, {{WRAPPER}} .royalinfinitescroll .scrollerinner li' => 'width: {{SIZE}}{{UNIT}} !important; flex: 0 0 {{SIZE}}{{UNIT}} !important;',
				],
			]
		);

		$this->add_responsive_control(
			'card_height',
			[
				'label'      => esc_html__( 'Card Height', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'rem' ],
				'range'      => [
					'px' => [ 'min' => 30, 'max' => 350 ],
				],
				'selectors'  => [
					'{{WRAPPER}} .royalinfinitescroll .royal-item-card, {{WRAPPER}} .royalinfinitescroll .scrollerinner li' => 'height: {{SIZE}}{{UNIT}} !important;',
				],
			]
		);

		$this->add_responsive_control(
			'card_padding',
			[
				'label'      => esc_html__( 'Card Padding', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem' ],
				'selectors'  => [
					'{{WRAPPER}} .royalinfinitescroll .royal-item-card, {{WRAPPER}} .royalinfinitescroll .scrollerinner li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_card_style' );

		// Normal State Tab
		$this->start_controls_tab(
			'tab_card_normal',
			[
				'label' => esc_html__( 'Normal', 'royal-addons-for-elementor' ),
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'card_background',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .royalinfinitescroll .royal-item-card, {{WRAPPER}} .royalinfinitescroll .scrollerinner li',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'card_border',
				'selector' => '{{WRAPPER}} .royalinfinitescroll .royal-item-card, {{WRAPPER}} .royalinfinitescroll .scrollerinner li',
			]
		);

		$this->add_control(
			'card_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem' ],
				'selectors'  => [
					'{{WRAPPER}} .royalinfinitescroll .royal-item-card, {{WRAPPER}} .royalinfinitescroll .scrollerinner li' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'card_box_shadow',
				'selector' => '{{WRAPPER}} .royalinfinitescroll .royal-item-card, {{WRAPPER}} .royalinfinitescroll .scrollerinner li',
			]
		);

		$this->end_controls_tab();

		// Hover State Tab
		$this->start_controls_tab(
			'tab_card_hover',
			[
				'label' => esc_html__( 'Hover', 'royal-addons-for-elementor' ),
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'card_background_hover',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .royalinfinitescroll .royal-item-card:hover, {{WRAPPER}} .royalinfinitescroll .scrollerinner li:hover',
			]
		);

		$this->add_control(
			'card_border_color_hover',
			[
				'label'     => esc_html__( 'Border Color', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .royalinfinitescroll .royal-item-card:hover, {{WRAPPER}} .royalinfinitescroll .scrollerinner li:hover' => 'border-color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'card_box_shadow_hover',
				'selector' => '{{WRAPPER}} .royalinfinitescroll .royal-item-card:hover, {{WRAPPER}} .royalinfinitescroll .scrollerinner li:hover',
			]
		);

		$this->add_responsive_control(
			'card_hover_lift',
			[
				'label'       => esc_html__( 'Hover Lift (Translate Y)', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::SLIDER,
				'range'       => [
					'px' => [ 'min' => -30, 'max' => 30 ],
				],
				'selectors'   => [
					'{{WRAPPER}} .royalinfinitescroll .royal-item-card:hover, {{WRAPPER}} .royalinfinitescroll .scrollerinner li:hover' => 'transform: translateY({{SIZE}}px) !important;',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	/**
	 * STYLE: Media / Logo Options
	 */
	private function register_style_media_options() {
		$this->start_controls_section(
			'style_section_media',
			[
				'label' => esc_html__( 'Images & Logos', 'royal-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'media_max_width',
			[
				'label'      => esc_html__( 'Max Width', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'rem' ],
				'range'      => [
					'px' => [ 'min' => 20, 'max' => 800 ],
					'%'  => [ 'min' => 10, 'max' => 100 ],
				],
				'selectors'  => [
					'{{WRAPPER}} .royalinfinitescroll .royal-card-media img, {{WRAPPER}} .royalinfinitescroll .scrollerinner.gallery img, {{WRAPPER}} .royalinfinitescroll .scrollerinner.post img' => 'max-width: {{SIZE}}{{UNIT}} !important;',
				],
			]
		);

		$this->add_responsive_control(
			'media_max_height',
			[
				'label'      => esc_html__( 'Max Height', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'rem', '%' ],
				'range'      => [
					'px' => [ 'min' => 15, 'max' => 400 ],
				],
				'selectors'  => [
					'{{WRAPPER}} .royalinfinitescroll .royal-card-media img, {{WRAPPER}} .royalinfinitescroll .scrollerinner.gallery img, {{WRAPPER}} .royalinfinitescroll .scrollerinner.post img' => 'max-height: {{SIZE}}{{UNIT}} !important;',
				],
			]
		);

		$this->add_control(
			'media_object_fit',
			[
				'label'     => esc_html__( 'Object Fit', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'contain',
				'options'   => [
					'contain' => esc_html__( 'Contain', 'royal-addons-for-elementor' ),
					'cover'   => esc_html__( 'Cover', 'royal-addons-for-elementor' ),
					'fill'    => esc_html__( 'Fill', 'royal-addons-for-elementor' ),
					'none'    => esc_html__( 'None', 'royal-addons-for-elementor' ),
				],
				'selectors' => [
					'{{WRAPPER}} .royalinfinitescroll .royal-card-media img, {{WRAPPER}} .royalinfinitescroll .scrollerinner.gallery img, {{WRAPPER}} .royalinfinitescroll .scrollerinner.post img' => 'object-fit: {{VALUE}} !important;',
				],
			]
		);

		$this->add_control(
			'image_grayscale',
			[
				'label'        => esc_html__( 'Grayscale Logos (Color on Hover)', 'royal-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'no',
				'return_value' => 'yes',
				'description'  => esc_html__( 'Displays subtle black & white logos that reveal full color on hover.', 'royal-addons-for-elementor' ),
			]
		);

		$this->add_responsive_control(
			'media_opacity',
			[
				'label'     => esc_html__( 'Normal Opacity', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [ 'min' => 0.1, 'max' => 1, 'step' => 0.05 ],
				],
				'selectors' => [
					'{{WRAPPER}} .royalinfinitescroll .royal-card-media img, {{WRAPPER}} .royalinfinitescroll .scrollerinner.gallery img' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->add_responsive_control(
			'media_hover_opacity',
			[
				'label'     => esc_html__( 'Hover Opacity', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [ 'min' => 0.1, 'max' => 1, 'step' => 0.05 ],
				],
				'selectors' => [
					'{{WRAPPER}} .royalinfinitescroll .royal-item-card:hover .royal-card-media img, {{WRAPPER}} .royalinfinitescroll .scrollerinner.gallery img:hover' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->add_control(
			'media_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors'  => [
					'{{WRAPPER}} .royalinfinitescroll .royal-card-media img, {{WRAPPER}} .royalinfinitescroll .scrollerinner.gallery img, {{WRAPPER}} .royalinfinitescroll .scrollerinner.post img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * STYLE: Title Options
	 */
	private function register_style_title_options() {
		$this->start_controls_section(
			'style_section_title',
			[
				'label' => esc_html__( 'Title Style', 'royal-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .royalinfinitescroll .royal-card-title, {{WRAPPER}} .royalinfinitescroll .scrollerinner li, {{WRAPPER}} .royalinfinitescroll .scrollerinner.post li a',
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Title Color', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .royalinfinitescroll .royal-card-title, {{WRAPPER}} .royalinfinitescroll .scrollerinner li, {{WRAPPER}} .royalinfinitescroll .scrollerinner.post li a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'title_color_hover',
			[
				'label'     => esc_html__( 'Title Color (Hover)', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .royalinfinitescroll .royal-item-card:hover .royal-card-title, {{WRAPPER}} .royalinfinitescroll .scrollerinner li:hover, {{WRAPPER}} .royalinfinitescroll .scrollerinner.post li a:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'title_margin',
			[
				'label'      => esc_html__( 'Margin', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem' ],
				'selectors'  => [
					'{{WRAPPER}} .royalinfinitescroll .royal-card-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * STYLE: Subtitle Options
	 */
	private function register_style_subtitle_options() {
		$this->start_controls_section(
			'style_section_subtitle',
			[
				'label' => esc_html__( 'Subtitle Style', 'royal-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'subtitle_typography',
				'selector' => '{{WRAPPER}} .royalinfinitescroll .royal-card-subtitle',
			]
		);

		$this->add_control(
			'subtitle_color',
			[
				'label'     => esc_html__( 'Color', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .royalinfinitescroll .royal-card-subtitle' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'subtitle_color_hover',
			[
				'label'     => esc_html__( 'Color (Hover)', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .royalinfinitescroll .royal-item-card:hover .royal-card-subtitle' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'subtitle_margin',
			[
				'label'      => esc_html__( 'Margin', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem' ],
				'selectors'  => [
					'{{WRAPPER}} .royalinfinitescroll .royal-card-subtitle' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * STYLE: Badge Options
	 */
	private function register_style_badge_options() {
		$this->start_controls_section(
			'style_section_badge',
			[
				'label' => esc_html__( 'Badge / Tag Style', 'royal-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'badge_typography',
				'selector' => '{{WRAPPER}} .royalinfinitescroll .royal-card-badge',
			]
		);

		$this->add_control(
			'badge_color',
			[
				'label'     => esc_html__( 'Text Color', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .royalinfinitescroll .royal-card-badge' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'badge_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .royalinfinitescroll .royal-card-badge' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'badge_padding',
			[
				'label'      => esc_html__( 'Padding', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'rem' ],
				'selectors'  => [
					'{{WRAPPER}} .royalinfinitescroll .royal-card-badge' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'badge_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'rem' ],
				'selectors'  => [
					'{{WRAPPER}} .royalinfinitescroll .royal-card-badge' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Main Render (Clean single track per widget)
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();
		$id       = $this->get_id();
		$scrollid = 'royalsliderbuck' . $id;

		$preset         = ! empty( $settings['preset_style'] ) ? $settings['preset_style'] : 'partner_card';
		$duration       = ! empty( $settings['duration'] ) ? $settings['duration'] : 30;
		$direction      = ! empty( $settings['direction'] ) ? $settings['direction'] : 'left';
		$is_fullwidth   = ( 'yes' === ( $settings['full_width'] ?? 'no' ) );
		$pause_on_hover = ( 'yes' === ( $settings['pause_on_hover'] ?? 'yes' ) );
		$fade_mask      = ( 'yes' === ( $settings['fade_mask'] ?? 'yes' ) );
		$grayscale      = ( 'yes' === ( $settings['image_grayscale'] ?? 'no' ) );
		$is_vertical    = in_array( $direction, [ 'up', 'down' ], true );
		$sizing_mode    = ! empty( $settings['card_sizing_mode'] ) ? $settings['card_sizing_mode'] : 'columns';

		$classes = [
			'royalinfinitescroll',
			'preset-' . sanitize_html_class( $preset ),
			'sizing-' . sanitize_html_class( $sizing_mode ),
		];

		if ( $is_fullwidth ) {
			$classes[] = 'royal-is-fullwidth';
		}
		if ( $pause_on_hover ) {
			$classes[] = 'pause-on-hover';
		}
		if ( $fade_mask ) {
			$classes[] = 'has-fade-mask';
		}
		if ( $grayscale ) {
			$classes[] = 'grayscale-logos';
		}
		if ( $is_vertical ) {
			$classes[] = 'is-vertical';
		}

		$this->add_render_attribute(
			'wrapper',
			[
				'id'             => $scrollid,
				'class'          => implode( ' ', $classes ),
				'data-direction' => $direction,
				'data-duration'  => $duration,
			]
		);

		// Collect items from selected source
		$items = $this->collect_items( $settings );
		if ( empty( $items ) ) {
			return;
		}
		?>
		<div class="royalinfinitescroll-wrap">
			<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
				<div class="scrollerinner direction-<?php echo esc_attr( $direction ); ?>">
					<?php
					foreach ( $items as $index => $item ) {
						$this->render_single_item( $item, $index, $settings );
					}
					?>
				</div>
			</div>
		</div>
		<?php
	}

	/**
	 * Normalize all sources into a unified items list
	 */
	protected function collect_items( $settings ) {
		$source = $settings['source'] ?? 'custom';
		$items  = [];

		if ( 'custom' === $source ) {
			$custom_items = ! empty( $settings['custom_items'] ) ? $settings['custom_items'] : $this->get_default_custom_items();
			foreach ( $custom_items as $item ) {
				$items[] = [
					'type'     => 'custom',
					'image'    => $item['image'] ?? [],
					'title'    => $item['title'] ?? '',
					'subtitle' => $item['subtitle'] ?? '',
					'badge'    => $item['badge'] ?? '',
					'link'     => $item['link'] ?? [],
				];
			}
		} elseif ( 'gallery' === $source ) {
			if ( ! empty( $settings['image_gallery'] ) ) {
				$link_type    = $settings['gallery_link_type'] ?? 'none';
				$custom_links = [];
				if ( 'custom' === $link_type && ! empty( $settings['gallery_custom_links'] ) ) {
					$lines = preg_split( '/[\r\n]+/', trim( $settings['gallery_custom_links'] ) );
					foreach ( $lines as $line ) {
						$trimmed = trim( $line );
						if ( ! empty( $trimmed ) ) {
							$custom_links[] = $trimmed;
						}
					}
				}

				foreach ( $settings['image_gallery'] as $idx => $img ) {
					$custom_url = $custom_links[ $idx ] ?? '';
					$items[]    = [
						'type'        => 'gallery',
						'image_id'    => $img['id'] ?? 0,
						'image_url'   => $img['url'] ?? '',
						'link_type'   => $link_type,
						'custom_url'  => $custom_url,
						'is_external' => ( 'yes' === ( $settings['gallery_link_external'] ?? 'yes' ) ),
						'nofollow'    => ( 'yes' === ( $settings['gallery_link_nofollow'] ?? 'no' ) ),
					];
				}
			}
		} elseif ( 'text' === $source ) {
			if ( ! empty( $settings['text_all'] ) ) {
				foreach ( $settings['text_all'] as $item ) {
					$items[] = [
						'type'     => 'text',
						'title'    => $item['text_title'] ?? '',
						'subtitle' => $item['text_subtitle'] ?? '',
						'link'     => $item['text_link'] ?? [],
					];
				}
			}
		} elseif ( 'post' === $source ) {
			$posts_per_page = ! empty( $settings['posts_per_page'] ) ? absint( $settings['posts_per_page'] ) : 10;
			$cats           = is_array( $settings['post_categories'] ) ? implode( ',', $settings['post_categories'] ) : $settings['post_categories'];

			$query_args = [
				'posts_per_page'      => $posts_per_page,
				'no_found_rows'       => true,
				'post_status'         => 'publish',
				'ignore_sticky_posts' => true,
			];

			if ( ! empty( $cats ) ) {
				$query_args['category_name'] = $cats;
			}
			if ( ! empty( $settings['orderby'] ) ) {
				$query_args['orderby'] = $settings['orderby'];
			}
			if ( ! empty( $settings['order'] ) ) {
				$query_args['order'] = $settings['order'];
			}

			$posts_query = new \WP_Query( $query_args );
			if ( $posts_query->have_posts() ) {
				while ( $posts_query->have_posts() ) {
					$posts_query->the_post();
					$items[] = [
						'type'      => 'post',
						'post_id'   => get_the_ID(),
						'title'     => get_the_title(),
						'permalink' => get_permalink(),
						'thumb_id'  => get_post_thumbnail_id(),
						'format'    => $settings['post_title_or_image'] ?? 'both',
					];
				}
				wp_reset_postdata();
			}
		}

		return $items;
	}

	/**
	 * Render Single Item Card with individual links
	 */
	protected function render_single_item( $item, $index, $settings ) {
		$type        = $item['type'] ?? 'custom';
		$link_url    = '';
		$is_external = false;
		$nofollow    = false;

		// Resolve Link according to source type
		if ( 'custom' === $type ) {
			$link = $item['link'] ?? [];
			if ( is_array( $link ) && ! empty( $link['url'] ) ) {
				$link_url    = $link['url'];
				$is_external = ! empty( $link['is_external'] );
				$nofollow    = ! empty( $link['nofollow'] );
			} elseif ( is_string( $link ) && ! empty( $link ) ) {
				$link_url = $link;
			}
		} elseif ( 'gallery' === $type ) {
			$ltype = $item['link_type'] ?? 'none';
			if ( 'custom' === $ltype && ! empty( $item['custom_url'] ) ) {
				$link_url    = $item['custom_url'];
				$is_external = ! empty( $item['is_external'] );
				$nofollow    = ! empty( $item['nofollow'] );
			} elseif ( 'file' === $ltype && ! empty( $item['image_id'] ) ) {
				$link_url = wp_get_attachment_url( $item['image_id'] );
				$is_external = ! empty( $item['is_external'] );
			} elseif ( 'attachment' === $ltype && ! empty( $item['image_id'] ) ) {
				$link_url = get_permalink( $item['image_id'] );
				$is_external = ! empty( $item['is_external'] );
			}
		} elseif ( 'text' === $type ) {
			$link = $item['link'] ?? [];
			if ( is_array( $link ) && ! empty( $link['url'] ) ) {
				$link_url    = $link['url'];
				$is_external = ! empty( $link['is_external'] );
				$nofollow    = ! empty( $link['nofollow'] );
			}
		} elseif ( 'post' === $type ) {
			$link_url = $item['permalink'] ?? '';
		}

		$is_link   = ! empty( $link_url );
		$card_tag  = $is_link ? 'a' : 'div';
		$has_link  = $is_link ? ' has-link' : '';
		$tag_attrs = '';

		if ( $is_link ) {
			$target_attr = $is_external ? ' target="_blank"' : '';
			$rel_attr    = $nofollow ? ' rel="nofollow noopener"' : ( $is_external ? ' rel="noopener"' : '' );
			$tag_attrs   = ' href="' . esc_url( $link_url ) . '"' . $target_attr . $rel_attr;
		}
		?>
		<<?php echo $card_tag; ?><?php echo $tag_attrs; ?> class="royal-item-card<?php echo esc_attr( $has_link ); ?>">
			<div class="royal-card-content">
				<?php
				if ( 'custom' === $type ) {
					$img      = $item['image'] ?? [];
					$img_html = '';

					if ( is_array( $img ) && ! empty( $img['id'] ) ) {
						$size     = ! empty( $settings['custom_image_thumbnail_size'] ) ? $settings['custom_image_thumbnail_size'] : 'medium';
						$img_html = wp_get_attachment_image( $img['id'], $size, false, [ 'loading' => 'lazy', 'alt' => esc_attr( $item['title'] ?? '' ) ] );
					}
					if ( empty( $img_html ) ) {
						$img_url = is_array( $img ) ? ( $img['url'] ?? '' ) : ( is_string( $img ) ? $img : '' );
						if ( ! empty( $img_url ) ) {
							$img_html = '<img src="' . esc_url( $img_url ) . '" alt="' . esc_attr( $item['title'] ?? '' ) . '" loading="lazy">';
						}
					}
					if ( ! empty( $img_html ) ) {
						echo '<div class="royal-card-media">' . $img_html . '</div>';
					}

					if ( ! empty( $item['badge'] ) || ! empty( $item['title'] ) || ! empty( $item['subtitle'] ) ) {
						echo '<div class="royal-card-body">';
						if ( ! empty( $item['badge'] ) ) {
							echo '<span class="royal-card-badge">' . esc_html( $item['badge'] ) . '</span>';
						}
						if ( ! empty( $item['title'] ) ) {
							echo '<h4 class="royal-card-title">' . esc_html( $item['title'] ) . '</h4>';
						}
						if ( ! empty( $item['subtitle'] ) ) {
							echo '<p class="royal-card-subtitle">' . esc_html( $item['subtitle'] ) . '</p>';
						}
						echo '</div>';
					}
				} elseif ( 'gallery' === $type ) {
					$img_id   = $item['image_id'] ?? 0;
					$img_url  = $item['image_url'] ?? '';
					$size     = ! empty( $settings['image_thumbnail_size'] ) ? $settings['image_thumbnail_size'] : 'medium';
					$img_html = '';

					if ( $img_id ) {
						$alt      = get_post_meta( $img_id, '_wp_attachment_image_alt', true );
						$img_html = wp_get_attachment_image( $img_id, $size, false, [ 'loading' => 'lazy', 'alt' => $alt ] );
					}
					if ( empty( $img_html ) && ! empty( $img_url ) ) {
						$img_html = '<img src="' . esc_url( $img_url ) . '" alt="" loading="lazy">';
					}
					if ( ! empty( $img_html ) ) {
						echo '<div class="royal-card-media">' . $img_html . '</div>';
					}
				} elseif ( 'text' === $type ) {
					echo '<div class="royal-card-body">';
					if ( ! empty( $item['title'] ) ) {
						echo '<h4 class="royal-card-title">' . esc_html( $item['title'] ) . '</h4>';
					}
					if ( ! empty( $item['subtitle'] ) ) {
						echo '<p class="royal-card-subtitle">' . esc_html( $item['subtitle'] ) . '</p>';
					}
					echo '</div>';
				} elseif ( 'post' === $type ) {
					$format   = $item['format'] ?? 'both';
					$thumb_id = $item['thumb_id'] ?? 0;
					$size     = ! empty( $settings['post_thumbnail_size'] ) ? $settings['post_thumbnail_size'] : 'medium';

					if ( in_array( $format, [ 'image', 'both' ], true ) && $thumb_id ) {
						echo '<div class="royal-card-media">';
						echo wp_get_attachment_image( $thumb_id, $size, false, [ 'loading' => 'lazy', 'alt' => esc_attr( $item['title'] ) ] );
						echo '</div>';
					}
					if ( in_array( $format, [ 'title', 'both' ], true ) && ! empty( $item['title'] ) ) {
						echo '<div class="royal-card-body">';
						echo '<h4 class="royal-card-title">' . esc_html( $item['title'] ) . '</h4>';
						echo '</div>';
					}
				}
				?>
			</div>
		</<?php echo $card_tag; ?>>
		<?php
	}
}
