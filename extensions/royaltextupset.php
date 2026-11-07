<?php
use Elementor\Controls_Manager;
use Elementor\Element_Base;
use Elementor\Group_Control_Background;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Royal TextUpset Extension Class
 */
class RoyalTextUpset {

	private static $script_enqueued = false;
	private static $registered_elements = [];

	private static $supported_widgets = [
		'heading',
		'text-editor',
	];

	public static function init() {
		// Classic widget hooks (using after_section_end to avoid nesting error)
		add_action( 'elementor/element/heading/section_title_style/after_section_end', [ __CLASS__, 'add_section' ] );
		add_action( 'elementor/element/text-editor/section_style/after_section_end', [ __CLASS__, 'add_section' ] );

		// Universal hook for Atomic widgets
		add_action( 'elementor/element/after_section_end', [ __CLASS__, 'add_section_atomic' ], 10, 2 );

		// Hook to add CSS classes and attributes to the widget's wrapper
		add_action( 'elementor/element/after_add_attributes', [ __CLASS__, 'add_attributes' ] );

		// Script enqueue hooks
		add_action( 'elementor/frontend/before_render', [ __CLASS__, 'maybe_enqueue_scripts' ] );
		add_action( 'elementor/frontend/widget/before_render', [ __CLASS__, 'maybe_enqueue_scripts' ] );
		add_action( 'elementor/preview/enqueue_scripts', [ __CLASS__, 'enqueue_scripts' ] );
	}

	public static function enqueue_scripts() {
		wp_enqueue_script(
			'royal-textupset',
			ROYAL_ADDONS_DIR_URL . 'assets/js/extension-textupset.js',
			[ 'elementor-frontend' ],
			'2.0.3',
			true
		);
	}

	public static function maybe_enqueue_scripts( $element ) {
		if ( ! ( $element instanceof \Elementor\Element_Base ) ) return;
		if ( self::$script_enqueued ) return;

		$settings = $element->get_settings_for_display();
		if ( isset( $settings['_ob_use_harakiri'] ) && 'yes' === $settings['_ob_use_harakiri'] ) {
			self::enqueue_scripts();
			self::$script_enqueued = true;
		}
	}

	public static function add_attributes( $element ) {
		if ( ! ( $element instanceof \Elementor\Element_Base ) ) return;
		
		if ( ! in_array( $element->get_name(), self::$supported_widgets ) ) {
			return;
		}

		$settings = $element->get_settings_for_display();

		if ( isset( $settings['_ob_use_harakiri'] ) && 'yes' === $settings['_ob_use_harakiri'] ) {
			$element->add_render_attribute( '_wrapper', 'class', 'royal-textupset' );
		}
	}

	public static function add_section_atomic( $element, $section_id = '' ) {
		if ( ! ( $element instanceof \Elementor\Element_Base ) ) return;

		$el_name = $element->get_name();

		if ( in_array( $el_name, [ 'heading', 'text-editor' ] ) ) return;
		if ( ! in_array( $section_id, [ 'section_advanced', 'section_custom_css_pro', 'section_style', 'section_layout' ] ) ) return;
	}

	public static function add_section( $element ) {
		if ( ! ( $element instanceof \Elementor\Element_Base ) ) return;

		$element_id = $element->get_name();
		if ( isset( self::$registered_elements[ $element_id ] ) ) return;
		self::$registered_elements[ $element_id ] = true;

		$el_name = $element->get_name();
		$is_atomic = in_array( $el_name, [ 'e-div-block', 'e-flexbox' ] ) || ( strpos( $el_name, 'atomic-' ) === 0 );

		$element->start_controls_section(
			'royalcontrolsection_textupset',
			[
				'label' => 'TextUpset [Royal]',
				'tab'   => $is_atomic ? Controls_Manager::TAB_ADVANCED : Controls_Manager::TAB_STYLE,
			]
		);

		$element->add_control(
			'_ob_use_harakiri',
			[
				'label'              => esc_html__( 'Enable TextUpSet?', 'royal-addons-for-elementor' ),
				'separator'          => 'after',
				'type'               => Controls_Manager::SWITCHER,
				'label_on'           => esc_html__( 'Yes', 'royal-addons-for-elementor' ),
				'label_off'          => esc_html__( 'No', 'royal-addons-for-elementor' ),
				'return_value'       => 'yes',
				'default'            => 'no',
				'frontend_available' => true,
				'render_type'        => 'template',
			]
		);

		$element->add_control(
			'_ob_harakiri_color_hover',
			[
				'label'     => __( 'Color - HOVER', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'separator' => 'before',
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}}.royal-textupset .elementor-heading-title:hover, {{WRAPPER}}.royal-textupset .elementor-widget-container:hover, {{WRAPPER}}.royal-textupset:hover' => 'color: {{VALUE}};',
				],
				'condition' => [ '_ob_use_harakiri' => 'yes' ],
			]
		);

		$element->add_responsive_control(
			'_ob_harakiri_writing_mode',
			[
				'label'     => __( 'Writing Mode', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'inherit',
				'options'   => [
					'vertical-lr' => __( 'Vertical LR', 'royal-addons-for-elementor' ),
					'vertical-rl' => __( 'Vertical RL', 'royal-addons-for-elementor' ),
					'inherit'     => __( 'Normal', 'royal-addons-for-elementor' ),
				],
				'selectors' => [
					'{{WRAPPER}}.royal-textupset .elementor-heading-title, {{WRAPPER}}.royal-textupset .elementor-widget-container > div, {{WRAPPER}}.royal-textupset .elementor-widget-container, {{WRAPPER}}.royal-textupset' => 'writing-mode: {{VALUE}};',
				],
				'condition' => [ '_ob_use_harakiri' => 'yes' ],
			]
		);

		$element->add_responsive_control(
			'_ob_harakiri_make_inline',
			[
				'label'                => __( 'Flip', 'royal-addons-for-elementor' ),
				'type'                 => Controls_Manager::SELECT,
				'default'              => 'no',
				'options'              => [
					'yes' => __( 'Yes', 'royal-addons-for-elementor' ),
					'no'  => __( 'No', 'royal-addons-for-elementor' ),
				],
				'selectors_dictionary' => [
					'yes' => 'rotate(180deg)',
					'no'  => 'rotate(0deg)',
				],
				'selectors' => [
					'{{WRAPPER}}.royal-textupset .elementor-heading-title, {{WRAPPER}}.royal-textupset .elementor-widget-container > div, {{WRAPPER}}.royal-textupset .elementor-widget-container, {{WRAPPER}}.royal-textupset' => 'transform: {{VALUE}};',
				],
				'condition' => [ '_ob_use_harakiri' => 'yes' ],
			]
		);

		$element->add_responsive_control(
			'_ob_harakiri_height',
			[
				'label'     => __( 'Height', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '',
				'options'   => [
					''        => __( 'Default', 'royal-addons-for-elementor' ),
					'auto'    => __( 'Inline', 'royal-addons-for-elementor' ) . ' (auto)',
					'initial' => __( 'Custom', 'royal-addons-for-elementor' ),
				],
				'selectors' => [
					'{{WRAPPER}}.royal-textupset' => 'inline-size: {{VALUE}}; width: unset;',
				],
				'condition' => [
					'_ob_use_harakiri'           => 'yes',
					'_ob_harakiri_writing_mode!' => 'inherit',
				],
			]
		);

		$element->add_responsive_control(
			'_ob_harakiri_height_custom',
			[
				'label'       => __( 'Custom Height', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::SLIDER,
				'range'       => [
					'px' => [ 'max' => 1000, 'step' => 1 ],
					'%'  => [ 'max' => 100, 'step' => 1 ],
					'vh' => [ 'max' => 100, 'step' => 1 ],
				],
				'default'     => [ 'unit' => '%', 'size' => 100 ],
				'size_units'  => [ 'px', '%', 'vh', 'custom' ],
				'selectors'   => [
					'{{WRAPPER}}.royal-textupset' => 'inline-size: {{SIZE}}{{UNIT}}; width: unset;',
				],
				'condition' => [
					'_ob_use_harakiri'           => 'yes',
					'_ob_harakiri_height'        => [ 'initial' ],
					'_ob_harakiri_writing_mode!' => 'inherit',
				],
			]
		);

		$element->add_responsive_control(
			'_ob_harakiri_txt_indent',
			[
				'label'      => __( 'Text Indent', 'royal-addons-for-elementor' ),
				'separator'  => 'before',
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'vw', 'custom' ],
				'range'      => [
					'px' => [ 'max' => 200 ],
					'%'  => [ 'max' => 100, 'step' => 0.1 ],
					'vw' => [ 'max' => 100, 'step' => 0.1 ],
					'em' => [ 'max' => 100, 'step' => 0.1 ],
				],
				'default'    => [ 'unit' => 'px', 'size' => 0 ],
				'selectors'  => [
					'{{WRAPPER}}.royal-textupset .elementor-widget-container, {{WRAPPER}}.royal-textupset' => 'text-indent: {{SIZE}}{{UNIT}};',
				],
				'condition' => [ '_ob_use_harakiri' => 'yes' ],
			]
		);

		$element->add_responsive_control(
			'_ob_harakiri_mix_blend',
			[
				'label'   => __( 'Mix Blend Mode', 'royal-addons-for-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'inherit',
				'options' => [
					'inherit'      => __( 'Default', 'royal-addons-for-elementor' ),
					'multiply'     => __( 'Multiply', 'royal-addons-for-elementor' ),
					'screen'       => __( 'Screen', 'royal-addons-for-elementor' ),
					'overlay'      => __( 'Overlay', 'royal-addons-for-elementor' ),
					'darken'       => __( 'Darken', 'royal-addons-for-elementor' ),
					'lighten'      => __( 'Lighten', 'royal-addons-for-elementor' ),
					'color-dodge'  => __( 'Color-dodge', 'royal-addons-for-elementor' ),
					'color-burn'   => __( 'Color-burn', 'royal-addons-for-elementor' ),
					'hard-light'   => __( 'Hard-light', 'royal-addons-for-elementor' ),
					'soft-light'   => __( 'Soft-light', 'royal-addons-for-elementor' ),
					'difference'   => __( 'Difference', 'royal-addons-for-elementor' ),
					'exclusion'    => __( 'Exclusion', 'royal-addons-for-elementor' ),
					'hue'          => __( 'Hue', 'royal-addons-for-elementor' ),
					'saturation'   => __( 'Saturation', 'royal-addons-for-elementor' ),
					'color'        => __( 'Color', 'royal-addons-for-elementor' ),
					'luminosity'   => __( 'Luminosity', 'royal-addons-for-elementor' ),
				],
				'selectors' => [
					'{{WRAPPER}}.royal-textupset .elementor-widget-container, {{WRAPPER}}.royal-textupset' => 'mix-blend-mode: {{VALUE}};',
				],
				'condition' => [ '_ob_use_harakiri' => 'yes' ],
			]
		);

		if ( in_array( $element->get_name(), [ 'heading' ] ) ) {
			$element->add_control(
				'_ob_harakiri_clip_bg_block_desc',
				[
					'label'           => esc_html__( 'Clip Text', 'royal-addons-for-elementor' ),
					'type'            => Controls_Manager::RAW_HTML,
					'raw'             => esc_html__( 'Add the background (image or gradient), select "Clip to text", and your Heading text color will change.', 'royal-addons-for-elementor' ),
					'content_classes' => 'elementor-control-field-description',
					'condition'       => [ '_ob_use_harakiri' => 'yes' ],
				]
			);

			$element->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'      => '_royaltextupset_text_clip_bg',
					'types'     => [ 'classic', 'gradient' ],
					'separator' => 'before',
					'selector'  => '{{WRAPPER}}.royal-textupset .elementor-heading-title, {{WRAPPER}}.royal-textupset',
					'condition' => [ '_ob_use_harakiri' => 'yes' ],
				]
			);

			$element->add_control(
				'_royaltextupset_text_clip',
				[
					'label'              => __( 'Background clip', 'royal-addons-for-elementor' ),
					'description'        => __( 'Apply the background to text only', 'royal-addons-for-elementor' ),
					'type'               => Controls_Manager::SELECT,
					'default'            => 'none',
					'options'            => [
						'none' => __( 'Normal', 'royal-addons-for-elementor' ),
						'clip' => __( 'Clip to text', 'royal-addons-for-elementor' ),
					],
					'frontend_available' => true,
					'separator'          => 'after',
					'condition'          => [
						'_ob_use_harakiri'                         => 'yes',
						'_royaltextupset_text_clip_bg_image[url]!' => '',
					],
				]
			);
		}

		if ( in_array( $element->get_name(), [ 'text-editor' ] ) ) {
			$element->add_control(
				'_ob_harakiri_cut_bottom_margin',
				[
					'label'        => __( 'Cut off the bottom margin', 'royal-addons-for-elementor' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => __( 'Yes', 'royal-addons-for-elementor' ),
					'label_off'    => __( 'No', 'royal-addons-for-elementor' ),
					'return_value' => 'inherit',
					'selectors'    => [
						'{{WRAPPER}}.royal-textupset .elementor-widget-container p:last-child, {{WRAPPER}}.royal-textupset p:last-child' => 'margin-bottom: 0px;',
					],
					'condition' => [ '_ob_use_harakiri' => 'yes' ],
				]
			);
		}

		$element->end_controls_section();
	}
}

RoyalTextUpset::init();