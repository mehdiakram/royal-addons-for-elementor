<?php
namespace RoyalAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Royal Branches Locator Widget
 * Modern nationwide Branch Network & GIS Explorer with 4 layout styles:
 * Modern Card Grid, Interactive Split Map, Grouped District Directory, and Data Table.
 *
 * Developed by Royal Technologies (https://royaltechbd.com)
 */
class RoyalBranchesLocator extends Widget_Base {

	public function get_name() {
		return 'royalbrancheslocator';
	}

	public function get_title() {
		return esc_html__( 'Branches Locator', 'royal-addons-for-elementor' );
	}

	public function get_icon() {
		return 'eicon-site-search rtbranding';
	}

	public function get_categories() {
		return [ 'royaltech' ];
	}

	public function get_keywords() {
		return [ 'branch', 'branches', 'locator', 'map', 'leaflet', 'openstreetmap', 'cards', 'directory', 'table', 'gis', 'near me', 'bangladesh', 'royal' ];
	}

	public function get_style_depends() {
		return [ 'bootstrap-icons', 'leaflet', 'royalbrancheslocator' ];
	}

	public function get_script_depends() {
		return [ 'leaflet', 'royalbrancheslocator' ];
	}

	protected function register_controls() {

		/* =====================================================================
		 * TAB: CONTENT -> Section 1: Layout & Views (Cards Switch etc.)
		 * ===================================================================== */
		$this->start_controls_section(
			'section_layout_settings',
			[
				'label' => esc_html__( 'Layout & Views Settings', 'royal-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		// Switch for Card Grid (Explicit User Requirement)
		$this->add_control(
			'show_cards',
			[
				'label'        => esc_html__( 'Show Cards (Card Grid View)', 'royal-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'royal-addons-for-elementor' ),
				'label_off'    => esc_html__( 'No', 'royal-addons-for-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'description'  => esc_html__( 'Toggle whether the Modern Cards Grid view is available and displayed.', 'royal-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'show_map',
			[
				'label'        => esc_html__( 'Show Interactive Map View', 'royal-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'royal-addons-for-elementor' ),
				'label_off'    => esc_html__( 'No', 'royal-addons-for-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'show_directory',
			[
				'label'        => esc_html__( 'Show District Directory View', 'royal-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'royal-addons-for-elementor' ),
				'label_off'    => esc_html__( 'No', 'royal-addons-for-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'show_table',
			[
				'label'        => esc_html__( 'Show Data Table View', 'royal-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'royal-addons-for-elementor' ),
				'label_off'    => esc_html__( 'No', 'royal-addons-for-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'default_style',
			[
				'label'   => esc_html__( 'Default Active Layout', 'royal-addons-for-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'cards',
				'options' => [
					'cards'     => esc_html__( 'Modern Card Grid', 'royal-addons-for-elementor' ),
					'map'       => esc_html__( 'Interactive Split Map', 'royal-addons-for-elementor' ),
					'directory' => esc_html__( 'Grouped District Directory', 'royal-addons-for-elementor' ),
					'table'     => esc_html__( 'Administrative Data Table', 'royal-addons-for-elementor' ),
				],
			]
		);

		$this->add_control(
			'theme_preset',
			[
				'label'   => esc_html__( 'Theme Preset', 'royal-addons-for-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'default',
				'options' => [
					'default'  => esc_html__( 'Emerald Nature (Signature Green & Gold)', 'royal-addons-for-elementor' ),
					'sapphire' => esc_html__( 'Sapphire Blue (Corporate Blue)', 'royal-addons-for-elementor' ),
					'dark'     => esc_html__( 'Dark Luxury (Modern Dark Mode)', 'royal-addons-for-elementor' ),
				],
			]
		);

		$this->add_responsive_control(
			'cards_columns',
			[
				'label'          => esc_html__( 'Columns per Row', 'royal-addons-for-elementor' ),
				'type'           => Controls_Manager::SELECT,
				'default'        => '4',
				'tablet_default' => '2',
				'mobile_default' => '1',
				'options'        => [
					'1' => esc_html__( '1 Column', 'royal-addons-for-elementor' ),
					'2' => esc_html__( '2 Columns', 'royal-addons-for-elementor' ),
					'3' => esc_html__( '3 Columns', 'royal-addons-for-elementor' ),
					'4' => esc_html__( '4 Columns', 'royal-addons-for-elementor' ),
					'5' => esc_html__( '5 Columns', 'royal-addons-for-elementor' ),
					'6' => esc_html__( '6 Columns', 'royal-addons-for-elementor' ),
				],
				'condition'      => [
					'show_cards' => 'yes',
				],
				'selectors'      => [
					'{{WRAPPER}} .royal-branches-locator-wrap .rbl-cards-grid' => 'grid-template-columns: repeat({{VALUE}}, 1fr);',
				],
			]
		);

		$this->add_responsive_control(
			'layout_cards_gap',
			[
				'label'      => esc_html__( 'Cards Grid Gap', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 60,
						'step' => 1,
					],
				],
				'condition'  => [
					'show_cards' => 'yes',
				],
				'selectors'  => [
					'{{WRAPPER}} .royal-branches-locator-wrap .rbl-cards-grid' => 'gap: {{SIZE}}{{UNIT}} !important;',
				],
			]
		);

		$this->end_controls_section();


		/* =====================================================================
		 * TAB: CONTENT -> Section 2: Header & Top Bar Settings
		 * (Header / Breadcrumbs are OFF by default as requested; customizable here)
		 * ===================================================================== */
		$this->start_controls_section(
			'section_header_settings',
			[
				'label' => esc_html__( 'Header & Bar Settings', 'royal-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		// Switch for Style Switcher Bar
		$this->add_control(
			'show_style_switcher',
			[
				'label'        => esc_html__( 'Show Top Style Switcher Bar', 'royal-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'royal-addons-for-elementor' ),
				'label_off'    => esc_html__( 'No', 'royal-addons-for-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'show_brand',
			[
				'label'        => esc_html__( 'Show Brand Title in Bar', 'royal-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'royal-addons-for-elementor' ),
				'label_off'    => esc_html__( 'No', 'royal-addons-for-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => [
					'show_style_switcher' => 'yes',
				],
			]
		);

		$this->add_control(
			'brand_title',
			[
				'label'       => esc_html__( 'Brand Title', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Branches Locator', 'royal-addons-for-elementor' ),
				'condition'   => [
					'show_style_switcher' => 'yes',
					'show_brand'          => 'yes',
				],
			]
		);

		$this->add_control(
			'brand_sub',
			[
				'label'       => esc_html__( 'Brand Subtitle', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Branch Network & Directory', 'royal-addons-for-elementor' ),
				'condition'   => [
					'show_style_switcher' => 'yes',
					'show_brand'          => 'yes',
				],
			]
		);

		$this->add_control(
			'show_theme_toggle',
			[
				'label'        => esc_html__( 'Show Theme Switcher Button', 'royal-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'royal-addons-for-elementor' ),
				'label_off'    => esc_html__( 'No', 'royal-addons-for-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => [
					'show_style_switcher' => 'yes',
				],
			]
		);

		$this->add_control(
			'hr_hero_divider',
			[
				'type' => Controls_Manager::DIVIDER,
			]
		);

		// Switch for Hero Section (NO HEADER / BREADCRUMB BY DEFAULT as requested)
		$this->add_control(
			'show_hero',
			[
				'label'        => esc_html__( 'Show Hero Banner Header', 'royal-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'royal-addons-for-elementor' ),
				'label_off'    => esc_html__( 'No', 'royal-addons-for-elementor' ),
				'return_value' => 'yes',
				'default'      => 'no', // Explicitly OFF by default
				'description'  => esc_html__( 'Disabled by default so the widget integrates seamlessly into your page without a redundant page header.', 'royal-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'hero_tag',
			[
				'label'       => esc_html__( 'Hero Badge Tag', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'BRANCH NETWORK', 'royal-addons-for-elementor' ),
				'condition'   => [
					'show_hero' => 'yes',
				],
			]
		);

		$this->add_control(
			'hero_title',
			[
				'label'       => esc_html__( 'Hero Main Title', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Our Branches', 'royal-addons-for-elementor' ),
				'condition'   => [
					'show_hero' => 'yes',
				],
			]
		);

		$this->add_control(
			'hero_sub',
			[
				'label'       => esc_html__( 'Hero Subtitle', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXTAREA,
				'rows'        => 2,
				'default'     => esc_html__( 'Nationwide network serving communities across Bangladesh', 'royal-addons-for-elementor' ),
				'condition'   => [
					'show_hero' => 'yes',
				],
			]
		);

		$this->add_control(
			'show_wave',
			[
				'label'        => esc_html__( 'Hero Wave Transition', 'royal-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'royal-addons-for-elementor' ),
				'label_off'    => esc_html__( 'No', 'royal-addons-for-elementor' ),
				'return_value' => 'yes',
				'default'      => 'no',
				'condition'    => [
					'show_hero' => 'yes',
				],
			]
		);

		$this->end_controls_section();


		/* =====================================================================
		 * TAB: CONTENT -> Section 3: Stats Counters Bar
		 * ===================================================================== */
		$this->start_controls_section(
			'section_stats_settings',
			[
				'label' => esc_html__( 'Stats Counters Bar', 'royal-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'show_stats',
			[
				'label'        => esc_html__( 'Show Stats Counters', 'royal-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'royal-addons-for-elementor' ),
				'label_off'    => esc_html__( 'No', 'royal-addons-for-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'stats_auto_count',
			[
				'label'        => esc_html__( 'Auto Calculate Numbers from Data', 'royal-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'royal-addons-for-elementor' ),
				'label_off'    => esc_html__( 'No', 'royal-addons-for-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => [
					'show_stats' => 'yes',
				],
			]
		);

		$this->add_control(
			'stat_1_label',
			[
				'label'     => esc_html__( 'Stat 1 Label (Districts)', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Districts', 'royal-addons-for-elementor' ),
				'condition' => [
					'show_stats' => 'yes',
				],
			]
		);

		$this->add_control(
			'stat_1_val',
			[
				'label'     => esc_html__( 'Stat 1 Override Value', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 4,
				'condition' => [
					'show_stats'       => 'yes',
					'stats_auto_count' => '',
				],
			]
		);

		$this->add_control(
			'stat_2_label',
			[
				'label'     => esc_html__( 'Stat 2 Label (Upazilas)', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Upazilas', 'royal-addons-for-elementor' ),
				'condition' => [
					'show_stats' => 'yes',
				],
			]
		);

		$this->add_control(
			'stat_2_val',
			[
				'label'     => esc_html__( 'Stat 2 Override Value', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 16,
				'condition' => [
					'show_stats'       => 'yes',
					'stats_auto_count' => '',
				],
			]
		);

		$this->add_control(
			'stat_3_label',
			[
				'label'     => esc_html__( 'Stat 3 Label (Total Branches)', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Total Branches', 'royal-addons-for-elementor' ),
				'condition' => [
					'show_stats' => 'yes',
				],
			]
		);

		$this->add_control(
			'stat_3_val',
			[
				'label'     => esc_html__( 'Stat 3 Override Value', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 30,
				'condition' => [
					'show_stats'       => 'yes',
					'stats_auto_count' => '',
				],
			]
		);

		$this->end_controls_section();


		/* =====================================================================
		 * TAB: CONTENT -> Section 4: Search & Filters Bar Settings
		 * ===================================================================== */
		$this->start_controls_section(
			'section_filters_settings',
			[
				'label' => esc_html__( 'Search & Filters Settings', 'royal-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'show_search',
			[
				'label'        => esc_html__( 'Show Live Search Input', 'royal-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'royal-addons-for-elementor' ),
				'label_off'    => esc_html__( 'No', 'royal-addons-for-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'search_placeholder',
			[
				'label'       => esc_html__( 'Search Placeholder Text', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Search by branch name, district, upazila, address, phone...', 'royal-addons-for-elementor' ),
				'label_block' => true,
				'condition'   => [
					'show_search' => 'yes',
				],
			]
		);

		$this->add_control(
			'show_district_filter',
			[
				'label'        => esc_html__( 'Show District Dropdown', 'royal-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'royal-addons-for-elementor' ),
				'label_off'    => esc_html__( 'No', 'royal-addons-for-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'show_gps_btn',
			[
				'label'        => esc_html__( 'Show GPS "Near Me" Button', 'royal-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'royal-addons-for-elementor' ),
				'label_off'    => esc_html__( 'No', 'royal-addons-for-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'show_area_chips',
			[
				'label'        => esc_html__( 'Show Area Filter Chips', 'royal-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'royal-addons-for-elementor' ),
				'label_off'    => esc_html__( 'No', 'royal-addons-for-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'show_result_bar',
			[
				'label'        => esc_html__( 'Show Result Count Bar', 'royal-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'royal-addons-for-elementor' ),
				'label_off'    => esc_html__( 'No', 'royal-addons-for-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'show_reset_btn',
			[
				'label'        => esc_html__( 'Show Reset Filters Button', 'royal-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'royal-addons-for-elementor' ),
				'label_off'    => esc_html__( 'No', 'royal-addons-for-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => [
					'show_result_bar' => 'yes',
				],
			]
		);

		$this->end_controls_section();


		/* =====================================================================
		 * TAB: CONTENT -> Section 5: Branch Locations Data Source
		 * ===================================================================== */
		$this->start_controls_section(
			'section_branches_data',
			[
				'label' => esc_html__( 'Branch Locations Data', 'royal-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'data_source',
			[
				'label'   => esc_html__( 'Data Source', 'royal-addons-for-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'preset',
				'options' => [
					'preset'      => esc_html__( 'Preset Demo (30 Verified Branches across BD)', 'royal-addons-for-elementor' ),
					'custom'      => esc_html__( 'Custom Branches (Elementor Repeater)', 'royal-addons-for-elementor' ),
					'remote_json' => esc_html__( 'Remote / Local JSON URL', 'royal-addons-for-elementor' ),
				],
				'description' => esc_html__( 'Preset contains the complete 30-branch network across Satkhira, Jashore, Khulna, and Jhenaidah.', 'royal-addons-for-elementor' ),
			]
		);

		$demo_json_url = ROYAL_ADDONS_DIR_URL . 'assets/data/branches.json';

		$this->add_control(
			'json_url',
			[
				'label'       => esc_html__( 'JSON URL', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => 'https://example.com/branches.json',
				'label_block' => true,
				'condition'   => [
					'data_source' => 'remote_json',
				],
			]
		);

		$this->add_control(
			'download_sample_json',
			[
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => '<div style="margin: 10px 0 16px; padding: 12px 14px; background: #eef6ff; border: 1px dashed #3b82f6; border-radius: 8px;">'
					. '<div style="display: flex; align-items: flex-start; gap: 8px; margin-bottom: 8px;">'
					. '<i class="eicon-info-circle-o" style="color: #2563eb; font-size: 16px; margin-top: 2px;"></i>'
					. '<span style="font-size: 12px; color: #1e3a8a; line-height: 1.4;"><strong>' . esc_html__( 'Sample JSON Dataset', 'royal-addons-for-elementor' ) . ':</strong> '
					. esc_html__( 'Download the 30-branch sample demo JSON to structure your custom JSON file.', 'royal-addons-for-elementor' ) . '</span>'
					. '</div>'
					. '<a href="' . esc_url( $demo_json_url ) . '" download="sample-branches.json" target="_blank" class="elementor-button elementor-button-default" style="display: inline-flex; align-items: center; gap: 6px; background: #2563eb; color: #ffffff !important; padding: 7px 14px; border-radius: 6px; text-decoration: none; font-size: 11px; font-weight: 600;">'
					. '<i class="eicon-download-bold" aria-hidden="true"></i> '
					. esc_html__( 'Download Sample JSON', 'royal-addons-for-elementor' )
					. '</a>'
					. '</div>',
				'content_classes' => 'royal-sample-json-box',
				'condition'       => [
					'data_source' => 'remote_json',
				],
			]
		);

		// Card Media for Preset Demo Data
		$this->add_control(
			'demo_media_heading',
			[
				'label'     => esc_html__( 'Card Media (Demo Preset)', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'data_source' => 'preset',
				],
			]
		);

		$this->add_control(
			'default_media_type',
			[
				'label'       => esc_html__( 'Media Type', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::CHOOSE,
				'options'     => [
					'icon' => [
						'title' => esc_html__( 'Icon', 'royal-addons-for-elementor' ),
						'icon'  => 'eicon-info-circle',
					],
					'image' => [
						'title' => esc_html__( 'Image', 'royal-addons-for-elementor' ),
						'icon'  => 'eicon-image-bold',
					],
				],
				'default'     => 'icon',
				'toggle'      => false,
				'condition'   => [
					'data_source' => 'preset',
				],
			]
		);

		$this->add_control(
			'default_card_icon',
			[
				'label'       => esc_html__( 'Card Icon', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::ICONS,
				'default'     => [
					'value'   => 'bi bi-buildings',
					'library' => 'bootstrap-icons',
				],
				'condition'   => [
					'data_source'        => 'preset',
					'default_media_type' => 'icon',
				],
			]
		);

		$this->add_control(
			'default_card_image',
			[
				'label'       => esc_html__( 'Card Image', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::MEDIA,
				'default'     => [
					'url' => '',
				],
				'condition'   => [
					'data_source'        => 'preset',
					'default_media_type' => 'image',
				],
			]
		);

		// Repeater for Custom Branches
		$repeater = new Repeater();

		$repeater->add_control(
			'media_type',
			[
				'label'   => esc_html__( 'Media Type', 'royal-addons-for-elementor' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'icon' => [
						'title' => esc_html__( 'Icon', 'royal-addons-for-elementor' ),
						'icon'  => 'eicon-info-circle',
					],
					'image' => [
						'title' => esc_html__( 'Image', 'royal-addons-for-elementor' ),
						'icon'  => 'eicon-image-bold',
					],
				],
				'default' => 'icon',
				'toggle'  => false,
			]
		);

		$repeater->add_control(
			'branch_icon',
			[
				'label'       => esc_html__( 'Branch Icon', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::ICONS,
				'default'     => [
					'value'   => 'bi bi-buildings',
					'library' => 'bootstrap-icons',
				],
				'condition'   => [
					'media_type' => 'icon',
				],
			]
		);

		$repeater->add_control(
			'branch_image',
			[
				'label'       => esc_html__( 'Branch Image', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::MEDIA,
				'default'     => [
					'url' => '',
				],
				'condition'   => [
					'media_type' => 'image',
				],
			]
		);

		$repeater->add_control(
			'name',
			[
				'label'       => esc_html__( 'Branch Name (English)', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Tala Branch', 'royal-addons-for-elementor' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'bn_name',
			[
				'label'   => esc_html__( 'Branch Name (Bengali)', 'royal-addons-for-elementor' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'তালা শাখা', 'royal-addons-for-elementor' ),
			]
		);

		$repeater->add_control(
			'area',
			[
				'label'   => esc_html__( 'Area / Region', 'royal-addons-for-elementor' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Tala', 'royal-addons-for-elementor' ),
			]
		);

		$repeater->add_control(
			'district',
			[
				'label'   => esc_html__( 'District (Bengali)', 'royal-addons-for-elementor' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'সাতক্ষীরা', 'royal-addons-for-elementor' ),
			]
		);

		$repeater->add_control(
			'district_en',
			[
				'label'   => esc_html__( 'District (English)', 'royal-addons-for-elementor' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Satkhira', 'royal-addons-for-elementor' ),
			]
		);

		$repeater->add_control(
			'upazila',
			[
				'label'   => esc_html__( 'Upazila (Bengali)', 'royal-addons-for-elementor' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'তালা', 'royal-addons-for-elementor' ),
			]
		);

		$repeater->add_control(
			'upazila_en',
			[
				'label'   => esc_html__( 'Upazila (English)', 'royal-addons-for-elementor' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Tala', 'royal-addons-for-elementor' ),
			]
		);

		$repeater->add_control(
			'address',
			[
				'label'       => esc_html__( 'Full Address', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXTAREA,
				'rows'        => 2,
				'default'     => esc_html__( 'গ্রামঃ তালা সদর, থানাঃ তালা, জেলাঃ সাতক্ষীরা।', 'royal-addons-for-elementor' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'phone',
			[
				'label'   => esc_html__( 'Phone Number', 'royal-addons-for-elementor' ),
				'type'    => Controls_Manager::TEXT,
				'default' => '01334917500',
			]
		);

		$repeater->add_control(
			'email',
			[
				'label'   => esc_html__( 'Email Address', 'royal-addons-for-elementor' ),
				'type'    => Controls_Manager::TEXT,
				'default' => 'uptala001@gmail.com',
			]
		);

		$repeater->add_control(
			'lat',
			[
				'label'   => esc_html__( 'Latitude', 'royal-addons-for-elementor' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 22.7542,
				'step'    => 0.0001,
			]
		);

		$repeater->add_control(
			'lng',
			[
				'label'   => esc_html__( 'Longitude', 'royal-addons-for-elementor' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 89.1458,
				'step'    => 0.0001,
			]
		);

		$repeater->add_control(
			'map_url',
			[
				'label'       => esc_html__( 'Google Maps Directions URL', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => 'https://maps.google.com/?q=22.7542,89.1458',
				'label_block' => true,
			]
		);

		$this->add_control(
			'custom_branches',
			[
				'label'       => esc_html__( 'Custom Branches List', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => [
					[
						'name'        => esc_html__( 'Tala Main Branch', 'royal-addons-for-elementor' ),
						'bn_name'     => esc_html__( 'তালা প্রধান শাখা', 'royal-addons-for-elementor' ),
						'area'        => 'Tala',
						'district'    => 'সাতক্ষীরা',
						'district_en' => 'Satkhira',
						'upazila'     => 'তালা',
						'upazila_en'  => 'Tala',
						'address'     => esc_html__( 'গ্রামঃ তালা সদর, পোস্টঃ তালা, থানাঃ তালা, জেলাঃ সাতক্ষীরা।', 'royal-addons-for-elementor' ),
						'phone'       => '01334917500',
						'email'       => 'uptala001@gmail.com',
						'lat'         => 22.7542,
						'lng'         => 89.1458,
						'map_url'     => 'https://maps.google.com/?q=22.7542,89.1458',
					],
				],
				'title_field' => '{{{ name }}} ({{{ district_en }}})',
				'condition'   => [
					'data_source' => 'custom',
				],
			]
		);

		$this->end_controls_section();


		/* =====================================================================
		 * TAB: STYLE -> Section 1: Colors & General Styling
		 * ===================================================================== */
		$this->start_controls_section(
			'section_style_general',
			[
				'label' => esc_html__( 'Theme & General Style', 'royal-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'primary_color',
			[
				'label'     => esc_html__( 'Primary Color', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .royal-branches-locator-wrap' => '--br-g2: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'secondary_color',
			[
				'label'     => esc_html__( 'Secondary / Accent Color', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .royal-branches-locator-wrap' => '--br-g3: {{VALUE}}; --br-accent: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'accent_gold_color',
			[
				'label'     => esc_html__( 'Gold / Highlight Color', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .royal-branches-locator-wrap' => '--br-gold: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'wrap_bg_color',
			[
				'label'     => esc_html__( 'Widget Container Background', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .royal-branches-locator-wrap' => 'background-color: {{VALUE}}; --bg-page: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'wrap_border',
				'selector' => '{{WRAPPER}} .royal-branches-locator-wrap',
			]
		);

		$this->add_control(
			'wrap_border_radius',
			[
				'label'      => esc_html__( 'Container Border Radius', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .royal-branches-locator-wrap' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'wrap_box_shadow',
				'selector' => '{{WRAPPER}} .royal-branches-locator-wrap',
			]
		);

		$this->add_responsive_control(
			'general_margin',
			[
				'label'      => esc_html__( 'Margin', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem' ],
				'selectors'  => [
					'{{WRAPPER}} .royal-branches-locator-wrap .br-stats-wrap.no-hero' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .royal-branches-locator-wrap .br-stats-wrap' => 'margin-top: {{TOP}}{{UNIT}}; margin-bottom: {{BOTTOM}}{{UNIT}}; margin-left: {{LEFT}}{{UNIT}}; margin-right: {{RIGHT}}{{UNIT}};',
					'{{WRAPPER}} .royal-branches-locator-wrap' => '--rbl-stats-margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'general_padding',
			[
				'label'      => esc_html__( 'Padding', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem' ],
				'selectors'  => [
					'{{WRAPPER}} .royal-branches-locator-wrap .br-stats-wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .royal-branches-locator-wrap .br-main' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .royal-branches-locator-wrap' => '--rbl-padding-x: {{RIGHT}}{{UNIT}}; --rbl-padding-y: {{TOP}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


		/* =====================================================================
		 * TAB: STYLE -> Section 2: Cards Styling
		 * ===================================================================== */
		$this->start_controls_section(
			'section_style_cards',
			[
				'label'     => esc_html__( 'Cards Grid Styling', 'royal-addons-for-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_cards' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'cards_gap',
			[
				'label'      => esc_html__( 'Cards Gap', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 60,
						'step' => 1,
					],
				],
				'default'    => [
					'size' => 18,
					'unit' => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .royal-branches-locator-wrap .rbl-cards-grid' => 'gap: {{SIZE}}{{UNIT}} !important;',
				],
			]
		);

		$this->add_responsive_control(
			'card_padding',
			[
				'label'      => esc_html__( 'Card Content Padding', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .royal-branches-locator-wrap .br-body' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'card_border_radius',
			[
				'label'      => esc_html__( 'Card Border Radius', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .royal-branches-locator-wrap .br-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'card_bg_color',
			[
				'label'     => esc_html__( 'Card Background', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .royal-branches-locator-wrap .br-card' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'card_media_height',
			[
				'label'      => esc_html__( 'Media Header Height', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'vh' ],
				'range'      => [
					'px' => [
						'min' => 60,
						'max' => 300,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .royal-branches-locator-wrap .br-img' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'card_icon_size',
			[
				'label'      => esc_html__( 'Icon Size', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min' => 16,
						'max' => 80,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .royal-branches-locator-wrap .br-img-empty' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .royal-branches-locator-wrap .br-img-empty svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .royal-branches-locator-wrap .br-img-empty i' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'card_icon_color',
			[
				'label'     => esc_html__( 'Icon Color', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .royal-branches-locator-wrap .br-img-empty' => 'color: {{VALUE}};',
					'{{WRAPPER}} .royal-branches-locator-wrap .br-img-empty svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'card_title_typography',
				'label'    => esc_html__( 'Branch Title Typography', 'royal-addons-for-elementor' ),
				'selector' => '{{WRAPPER}} .royal-branches-locator-wrap .br-name',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'card_box_shadow',
				'selector' => '{{WRAPPER}} .royal-branches-locator-wrap .br-card',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Retrieve branch dataset
	 */
	protected function get_branches_dataset( $settings ) {
		$source = $settings['data_source'] ?? 'preset';

		if ( 'custom' === $source && ! empty( $settings['custom_branches'] ) ) {
			$branches = [];
			$id = 1;
			foreach ( $settings['custom_branches'] as $item ) {
				$media_type = $item['media_type'] ?? 'icon';
				$image_url  = ! empty( $item['branch_image']['url'] ) ? esc_url( $item['branch_image']['url'] ) : '';

				$icon_html = '';
				if ( 'icon' === $media_type ) {
					ob_start();
					if ( ! empty( $item['branch_icon']['value'] ) ) {
						\Elementor\Icons_Manager::render_icon( $item['branch_icon'], [ 'aria-hidden' => 'true' ] );
					} else {
						echo '<i class="bi bi-buildings"></i>';
					}
					$icon_html = ob_get_clean();
				}

				$branches[] = [
					'id'          => $id++,
					'name'        => $item['name'] ?? '',
					'bn_name'     => $item['bn_name'] ?? '',
					'area'        => $item['area'] ?? '',
					'district'    => $item['district'] ?? '',
					'district_en' => $item['district_en'] ?? '',
					'upazila'     => $item['upazila'] ?? '',
					'upazila_en'  => $item['upazila_en'] ?? '',
					'address'     => $item['address'] ?? '',
					'phone'       => $item['phone'] ?? '',
					'email'       => $item['email'] ?? '',
					'lat'         => ! empty( $item['lat'] ) ? (float) $item['lat'] : 0,
					'lng'         => ! empty( $item['lng'] ) ? (float) $item['lng'] : 0,
					'map_url'     => $item['map_url'] ?? '',
					'media_type'  => $media_type,
					'image_url'   => $image_url,
					'icon_html'   => $icon_html,
				];
			}
			return $branches;
		}

		if ( 'remote_json' === $source && ! empty( $settings['json_url'] ) ) {
			$response = wp_remote_get( esc_url_raw( $settings['json_url'] ), [ 'timeout' => 10 ] );
			if ( ! is_wp_error( $response ) && 200 === wp_remote_retrieve_response_code( $response ) ) {
				$body = wp_remote_retrieve_body( $response );
				$decoded = json_decode( $body, true );
				if ( is_array( $decoded ) && ! empty( $decoded ) ) {
					return $decoded;
				}
			}
		}

		// Preset Data from JSON file
		$preset_file = ROYAL_ADDONS_DIR_PATH . 'assets/data/branches.json';
		if ( file_exists( $preset_file ) ) {
			$raw = file_get_contents( $preset_file );
			$decoded = json_decode( $raw, true );
			if ( is_array( $decoded ) ) {
				return $decoded;
			}
		}

		return [];
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$widget_id = $this->get_id();

		// Requirements: Cards switcher check
		$show_cards       = ( 'yes' === $settings['show_cards'] );
		$show_map         = ( 'yes' === $settings['show_map'] );
		$show_directory   = ( 'yes' === $settings['show_directory'] );
		$show_table       = ( 'yes' === $settings['show_table'] );
		$default_style    = $settings['default_style'] ?? 'cards';

		if ( ! $show_cards && 'cards' === $default_style ) {
			$default_style = $show_map ? 'map' : ( $show_directory ? 'directory' : 'table' );
		}

		$theme_preset = $settings['theme_preset'] ?? 'default';

		// Global Card Media Defaults
		$default_media_type = $settings['default_media_type'] ?? 'icon';
		$default_image_url  = ! empty( $settings['default_card_image']['url'] ) ? esc_url( $settings['default_card_image']['url'] ) : '';

		ob_start();
		if ( ! empty( $settings['default_card_icon']['value'] ) ) {
			\Elementor\Icons_Manager::render_icon( $settings['default_card_icon'], [ 'aria-hidden' => 'true' ] );
		} else {
			echo '<i class="bi bi-buildings"></i>';
		}
		$default_icon_html = ob_get_clean();

		// Data
		$branches = $this->get_branches_dataset( $settings );
		$total_branches = count( $branches );

		// Compute unique districts & upazilas
		$districts = [];
		$areas     = [];
		foreach ( $branches as $b ) {
			if ( ! empty( $b['district_en'] ) ) {
				$districts[ $b['district_en'] ] = $b['district'] ?? $b['district_en'];
			}
			if ( ! empty( $b['area'] ) ) {
				$areas[ $b['area'] ] = $b['area'];
			}
		}
		$total_districts = count( $districts );
		$total_upazilas  = 16; // verified nationwide count in preset

		// Override stats if not auto-counted
		if ( 'yes' !== ( $settings['stats_auto_count'] ?? 'yes' ) ) {
			$total_districts = $settings['stat_1_val'] ?? 4;
			$total_upazilas  = $settings['stat_2_val'] ?? 16;
			$total_branches  = $settings['stat_3_val'] ?? 30;
		}
		?>

		<div class="royal-branches-locator-wrap"
		     id="royal-branches-locator-<?php echo esc_attr( $widget_id ); ?>"
		     data-theme="<?php echo esc_attr( $theme_preset ); ?>"
		     data-allow-cards="<?php echo $show_cards ? 'yes' : 'no'; ?>"
		     data-default-style="<?php echo esc_attr( $default_style ); ?>"
		     data-default-media-type="<?php echo esc_attr( $default_media_type ); ?>"
		     data-default-image-url="<?php echo esc_attr( $default_image_url ); ?>"
		     data-json-url="<?php echo esc_url( $settings['json_url'] ?? '' ); ?>">

			<template class="rbl-default-icon-tpl"><?php echo $default_icon_html; ?></template>

			<!-- Inline Branches Dataset for fast instant rendering -->
			<script type="application/json" class="rbl-raw-data">
				<?php echo wp_json_encode( $branches ); ?>
			</script>

			<?php
			/* =============================================================
			 * 1. Top Control Bar (Style Switcher & Theme Toggle)
			 * ============================================================= */
			if ( 'yes' === ( $settings['show_style_switcher'] ?? 'yes' ) ) :
			?>
			<div class="rbl-control-bar">
				<?php if ( 'yes' === ( $settings['show_brand'] ?? 'yes' ) ) : ?>
				<div class="rbl-brand">
					<div class="rbl-brand-icon">
						<i class="bi bi-buildings"></i>
					</div>
					<div class="rbl-brand-title">
						<span><?php echo esc_html( $settings['brand_title'] ?? 'Branches Locator' ); ?></span>
						<small><?php echo esc_html( $settings['brand_sub'] ?? 'Branch Network & Directory' ); ?></small>
					</div>
				</div>
				<?php endif; ?>

				<div class="rbl-actions">
					<nav class="rbl-style-switcher" aria-label="Layout selector">
						<?php if ( $show_cards ) : ?>
						<button type="button" class="style-pill <?php echo ( 'cards' === $default_style ) ? 'active' : ''; ?>" data-style="cards" title="<?php esc_attr_e( 'Modern Card Grid View', 'royal-addons-for-elementor' ); ?>">
							<i class="bi bi-grid-fill"></i>
							<span><?php esc_html_e( 'Card Grid', 'royal-addons-for-elementor' ); ?></span>
						</button>
						<?php endif; ?>

						<?php if ( $show_map ) : ?>
						<button type="button" class="style-pill <?php echo ( 'map' === $default_style ) ? 'active' : ''; ?>" data-style="map" title="<?php esc_attr_e( 'Interactive Split Map View', 'royal-addons-for-elementor' ); ?>">
							<i class="bi bi-map-fill"></i>
							<span><?php esc_html_e( 'Interactive Map', 'royal-addons-for-elementor' ); ?></span>
						</button>
						<?php endif; ?>

						<?php if ( $show_directory ) : ?>
						<button type="button" class="style-pill <?php echo ( 'directory' === $default_style ) ? 'active' : ''; ?>" data-style="directory" title="<?php esc_attr_e( 'District Directory View', 'royal-addons-for-elementor' ); ?>">
							<i class="bi bi-folder-fill"></i>
							<span><?php esc_html_e( 'District Directory', 'royal-addons-for-elementor' ); ?></span>
						</button>
						<?php endif; ?>

						<?php if ( $show_table ) : ?>
						<button type="button" class="style-pill <?php echo ( 'table' === $default_style ) ? 'active' : ''; ?>" data-style="table" title="<?php esc_attr_e( 'Administrative Data Table View', 'royal-addons-for-elementor' ); ?>">
							<i class="bi bi-table"></i>
							<span><?php esc_html_e( 'Data Table', 'royal-addons-for-elementor' ); ?></span>
						</button>
						<?php endif; ?>
					</nav>

					<?php if ( 'yes' === ( $settings['show_theme_toggle'] ?? 'yes' ) ) : ?>
					<button type="button" class="theme-toggle-btn rbl-theme-toggle" title="<?php esc_attr_e( 'Switch Theme', 'royal-addons-for-elementor' ); ?>">
						<i class="bi bi-sun-fill"></i>
					</button>
					<?php endif; ?>
				</div>
			</div>
			<?php endif; ?>

			<?php
			/* =============================================================
			 * 2. Hero Section (NO HEADER / BREADCRUMB BY DEFAULT)
			 * Only displayed if explicitly enabled by user in settings
			 * ============================================================= */
			if ( 'yes' === ( $settings['show_hero'] ?? 'no' ) ) :
			?>
			<div class="br-hero">
				<div class="br-hero-blob br-hero-blob-1"></div>
				<div class="br-hero-blob br-hero-blob-2"></div>
				<span class="br-ring br-ring-1"></span>
				<span class="br-ring br-ring-2"></span>

				<div style="position:relative;z-index:2;">
					<?php if ( ! empty( $settings['hero_tag'] ) ) : ?>
					<span class="br-tag">
						<i class="br-dot"></i> <?php echo esc_html( $settings['hero_tag'] ); ?>
					</span>
					<?php endif; ?>

					<?php if ( ! empty( $settings['hero_title'] ) ) : ?>
					<h2 class="br-title">
						<?php echo esc_html( $settings['hero_title'] ); ?>
					</h2>
					<?php endif; ?>

					<?php if ( ! empty( $settings['hero_sub'] ) ) : ?>
					<p class="br-sub">
						<?php echo esc_html( $settings['hero_sub'] ); ?>
					</p>
					<?php endif; ?>
				</div>

				<?php if ( 'yes' === ( $settings['show_wave'] ?? 'no' ) ) : ?>
				<svg class="br-wave" viewBox="0 0 1440 80" preserveAspectRatio="none" aria-hidden="true">
					<path d="M0,40 C240,90 480,0 720,30 C960,60 1200,90 1440,35 L1440,80 L0,80 Z"></path>
				</svg>
				<?php endif; ?>
			</div>
			<?php endif; ?>

			<?php
			/* =============================================================
			 * 3. Stats Counters Bar
			 * ============================================================= */
			if ( 'yes' === ( $settings['show_stats'] ?? 'yes' ) ) :
				$no_hero_class = ( 'yes' !== ( $settings['show_hero'] ?? 'no' ) ) ? 'no-hero' : '';
			?>
			<div class="br-stats-wrap <?php echo esc_attr( $no_hero_class ); ?>">
				<div class="br-stats">
					<div class="br-stat">
						<span class="br-stat-ico"><i class="bi bi-geo-alt-fill"></i></span>
						<div class="br-count rbl-stat-dist-val" data-auto-count="<?php echo esc_attr( $settings['stats_auto_count'] ?? 'yes' ); ?>">
							<?php echo esc_html( $total_districts ); ?>
						</div>
						<small><?php echo esc_html( $settings['stat_1_label'] ?? 'Districts' ); ?></small>
					</div>

					<div class="br-stat">
						<span class="br-stat-ico"><i class="bi bi-pin-map-fill"></i></span>
						<div class="br-count rbl-stat-upazila-val" data-auto-count="<?php echo esc_attr( $settings['stats_auto_count'] ?? 'yes' ); ?>">
							<?php echo esc_html( $total_upazilas ); ?>
						</div>
						<small><?php echo esc_html( $settings['stat_2_label'] ?? 'Upazilas' ); ?></small>
					</div>

					<div class="br-stat">
						<span class="br-stat-ico"><i class="bi bi-buildings-fill"></i></span>
						<div class="br-count rbl-stat-total-val" data-auto-count="<?php echo esc_attr( $settings['stats_auto_count'] ?? 'yes' ); ?>">
							<?php echo esc_html( $total_branches ); ?>
						</div>
						<small><?php echo esc_html( $settings['stat_3_label'] ?? 'Total Branches' ); ?></small>
					</div>
				</div>
			</div>
			<?php endif; ?>

			<!-- =============================================================
			 * 4. Main Body: Search, Filters & 4 Layout Views
			 * ============================================================= -->
			<div class="br-main">

				<!-- Filter Box -->
				<div class="br-filter">
					<div class="br-search-row">
						<?php if ( 'yes' === ( $settings['show_search'] ?? 'yes' ) ) : ?>
						<div class="br-search">
							<i class="bi bi-search"></i>
							<input type="text" class="rbl-search-input" placeholder="<?php echo esc_attr( $settings['search_placeholder'] ?? 'Search branches, districts, address...' ); ?>" autocomplete="off">
						</div>
						<?php endif; ?>

						<div class="br-search-actions">
							<?php if ( 'yes' === ( $settings['show_district_filter'] ?? 'yes' ) ) : ?>
							<select class="br-filter-select rbl-district-select" aria-label="Filter by District">
								<option value="all"><?php esc_html_e( 'All Districts', 'royal-addons-for-elementor' ); ?></option>
								<?php foreach ( $districts as $en => $bn ) : ?>
								<option value="<?php echo esc_attr( $en ); ?>"><?php echo esc_html( $en . ' (' . $bn . ')' ); ?></option>
								<?php endforeach; ?>
							</select>
							<?php endif; ?>

							<?php if ( 'yes' === ( $settings['show_gps_btn'] ?? 'yes' ) ) : ?>
							<button type="button" class="br-btn-gps rbl-btn-gps" title="<?php esc_attr_e( 'Find nearest branches with GPS', 'royal-addons-for-elementor' ); ?>">
								<i class="bi bi-geo-alt-fill"></i>
								<span><?php esc_html_e( 'Near Me', 'royal-addons-for-elementor' ); ?></span>
							</button>
							<?php endif; ?>
						</div>
					</div>

					<?php if ( 'yes' === ( $settings['show_area_chips'] ?? 'yes' ) && ! empty( $areas ) ) : ?>
					<div class="br-areas">
						<span class="br-areas-label"><i class="bi bi-funnel-fill"></i> <?php esc_html_e( 'Area', 'royal-addons-for-elementor' ); ?></span>
						<div class="br-chips">
							<button type="button" class="br-chip rbl-chip active" data-area="all"><?php esc_html_e( 'All Areas', 'royal-addons-for-elementor' ); ?></button>
							<?php foreach ( $areas as $area_name ) : ?>
							<button type="button" class="br-chip rbl-chip" data-area="<?php echo esc_attr( $area_name ); ?>"><?php echo esc_html( $area_name ); ?></button>
							<?php endforeach; ?>
						</div>
					</div>
					<?php endif; ?>
				</div>

				<?php if ( 'yes' === ( $settings['show_result_bar'] ?? 'yes' ) ) : ?>
				<div class="br-result-bar">
					<span class="rbl-result-count">
						<?php
						printf(
							/* translators: %1$d: current count, %2$d: total count */
							esc_html__( 'Showing %1$d of %2$d branches', 'royal-addons-for-elementor' ),
							$total_branches,
							$total_branches
						);
						?>
					</span>
					<?php if ( 'yes' === ( $settings['show_reset_btn'] ?? 'yes' ) ) : ?>
					<button type="button" class="btn-reset-filters">
						<i class="bi bi-arrow-clockwise"></i> <?php esc_html_e( 'Reset Filters', 'royal-addons-for-elementor' ); ?>
					</button>
					<?php endif; ?>
				</div>
				<?php endif; ?>

				<!-- Empty State -->
				<div class="br-empty rbl-empty-state" style="display:none;">
					<div class="br-empty-ico">
						<i class="bi bi-search"></i>
					</div>
					<h4><?php esc_html_e( 'No Branches Found', 'royal-addons-for-elementor' ); ?></h4>
					<p><?php esc_html_e( 'No branch locations match your active search and filter criteria.', 'royal-addons-for-elementor' ); ?></p>
					<button type="button" class="btn-export btn-reset-filters" style="margin: 0 auto;">
						<i class="bi bi-arrow-clockwise"></i> <?php esc_html_e( 'Clear Filters', 'royal-addons-for-elementor' ); ?>
					</button>
				</div>

				<?php
				/* =============================================================
				 * Style 1: Modern Card Grid (Unnayan Prochesta signature design)
				 * ============================================================= */
				if ( $show_cards ) :
				?>
				<div class="rbl-cards-grid rbl-cards-container" style="<?php echo ( 'cards' === $default_style ) ? 'display:grid;' : 'display:none;'; ?>">
					<!-- Populated dynamically by royalbrancheslocator.js -->
				</div>
				<?php endif; ?>

				<?php
				/* =============================================================
				 * Style 2: Interactive Split Map & GIS Explorer
				 * ============================================================= */
				if ( $show_map ) :
				?>
				<div class="map-layout rbl-map-layout" style="<?php echo ( 'map' === $default_style ) ? 'display:grid;' : 'display:none;'; ?>">
					<aside class="map-sidebar">
						<div class="map-sidebar-head">
							<h5><i class="bi bi-pin-map-fill" style="color:var(--br-g2);"></i> <?php esc_html_e( 'Branches List', 'royal-addons-for-elementor' ); ?></h5>
							<small style="color:var(--text-muted);font-size:0.75rem;"><?php esc_html_e( 'Click to view on map', 'royal-addons-for-elementor' ); ?></small>
						</div>
						<div class="map-sidebar-list rbl-map-sidebar-list">
							<!-- Populated dynamically by royalbrancheslocator.js -->
						</div>
					</aside>

					<section class="map-canvas-container">
						<div class="rbl-leaflet-map"></div>
					</section>
				</div>
				<?php endif; ?>

				<?php
				/* =============================================================
				 * Style 3: Grouped District Directory
				 * ============================================================= */
				if ( $show_directory ) :
				?>
				<div class="rbl-directory-container" style="<?php echo ( 'directory' === $default_style ) ? 'display:block;' : 'display:none;'; ?>">
					<!-- Populated dynamically by royalbrancheslocator.js -->
				</div>
				<?php endif; ?>

				<?php
				/* =============================================================
				 * Style 4: Administrative Data Table View
				 * ============================================================= */
				if ( $show_table ) :
				?>
				<div class="table-panel rbl-table-container" style="<?php echo ( 'table' === $default_style ) ? 'display:block;' : 'display:none;'; ?>">
					<div class="table-panel-header">
						<h5><i class="bi bi-table" style="color:var(--br-g2);"></i> <?php esc_html_e( 'Branch Network Directory', 'royal-addons-for-elementor' ); ?></h5>
						<div class="table-export-btns">
							<button type="button" class="btn-export rbl-export-csv" title="<?php esc_attr_e( 'Export as CSV Spreadsheet', 'royal-addons-for-elementor' ); ?>">
								<i class="bi bi-file-earmark-spreadsheet-fill" style="color:var(--br-g2);"></i> <?php esc_html_e( 'Export CSV', 'royal-addons-for-elementor' ); ?>
							</button>
							<button type="button" class="btn-export rbl-print-table" title="<?php esc_attr_e( 'Print Directory', 'royal-addons-for-elementor' ); ?>">
								<i class="bi bi-printer-fill" style="color:#0d6efd;"></i> <?php esc_html_e( 'Print', 'royal-addons-for-elementor' ); ?>
							</button>
						</div>
					</div>

					<div class="br-table-responsive">
						<table class="br-table">
							<thead>
								<tr>
									<th>#</th>
									<th><?php esc_html_e( 'Branch Name', 'royal-addons-for-elementor' ); ?></th>
									<th><?php esc_html_e( 'District', 'royal-addons-for-elementor' ); ?></th>
									<th><?php esc_html_e( 'Upazila / Area', 'royal-addons-for-elementor' ); ?></th>
									<th><?php esc_html_e( 'Address', 'royal-addons-for-elementor' ); ?></th>
									<th><?php esc_html_e( 'Contact', 'royal-addons-for-elementor' ); ?></th>
									<th><?php esc_html_e( 'Actions', 'royal-addons-for-elementor' ); ?></th>
								</tr>
							</thead>
							<tbody class="rbl-table-body">
								<!-- Populated dynamically by royalbrancheslocator.js -->
							</tbody>
						</table>
					</div>
				</div>
				<?php endif; ?>

			</div>

		</div>

		<?php
	}
}
