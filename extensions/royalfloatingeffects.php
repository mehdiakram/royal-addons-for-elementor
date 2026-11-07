<?php

use Elementor\Controls_Manager;
use Elementor\Element_Base;
use Elementor\Modules\AtomicWidgets\Controls\Section as AtomicSection;
use Elementor\Modules\AtomicWidgets\Controls\Types\Switch_Control as AtomicSwitch;
use Elementor\Modules\AtomicWidgets\Controls\Types\Size_Control as AtomicSize;
use Elementor\Modules\AtomicWidgets\PropTypes\Primitives\String_Prop_Type;
use Elementor\Modules\AtomicWidgets\PropTypes\Size_Prop_Type;
use Elementor\Modules\AtomicWidgets\Utils\Utils as AtomicUtils;

defined( 'ABSPATH' ) || die();

class RoyalFloatingEffects {

	static $should_script_enqueue = false;

	public static function init() {
		// Reliable hook for all elements (Widgets, Containers)
		add_action( 'elementor/element/after_section_end', [ __CLASS__, 'register' ], 10, 2 );

		// Elementor 4 Atomic API Hooks
		add_filter( 'elementor/atomic-widgets/props-schema', [ __CLASS__, 'add_atomic_props_schema' ], 10, 1 );
		add_filter( 'elementor/atomic-widgets/controls', [ __CLASS__, 'add_atomic_controls' ], 10, 2 );

		add_action( 'elementor/frontend/before_render', [ __CLASS__, 'render_fx' ] );
		add_action( 'elementor/frontend/before_render', [ __CLASS__, 'should_script_enqueue' ] );
		add_action( 'elementor/editor/after_enqueue_scripts', [ __CLASS__, 'enqueue_editor_scripts' ] );
		
		add_action( 'elementor/frontend/widget/before_render', [ __CLASS__, 'should_script_enqueue' ] );
		add_action( 'elementor/preview/enqueue_scripts', [ __CLASS__, 'royalfloatingeffects_enqueue' ] );
	}

	public static function enqueue_editor_scripts() {
		wp_enqueue_script('royalanime', ROYAL_ADDONS_DIR_URL.'assets/vendor/anime/lib/anime.min.js', [], '' );
		wp_enqueue_script('royalroyalfloatingeffects', ROYAL_ADDONS_DIR_URL.'assets/js/extension-royalfloatingeffects.js', [], '' );
	}

	public static function royalfloatingeffects_enqueue() {
		wp_enqueue_script('royalanime', ROYAL_ADDONS_DIR_URL.'assets/vendor/anime/lib/anime.min.js', [], '' );
		wp_enqueue_script('royalroyalfloatingeffects', ROYAL_ADDONS_DIR_URL.'assets/js/extension-royalfloatingeffects.js', [], '' );
	}

	public static function royal_magnetic_enqueue() {
		wp_enqueue_script('magnetic', ROYAL_ADDONS_DIR_URL.'assets/js/extension-royalmagnetic.js', [], '' );
	}

	static $should_floating_enqueue = false;
	static $should_magnetic_enqueue = false;

	public static function should_script_enqueue( $section ) {
		if ( self::$should_floating_enqueue && self::$should_magnetic_enqueue ) {
			return;
		}

		$el_name = $section->get_name();
		$is_atomic = in_array($el_name, ['div-block', 'e-div-block', 'e-flexbox', 'atomic-widget-base']) || (strpos($el_name, 'atomic-') === 0);
		$settings = $is_atomic && method_exists($section, 'get_atomic_settings') ? $section->get_atomic_settings() : $section->get_settings_for_display();

		if ( ! self::$should_floating_enqueue && ( 'yes' == ( $settings['royal_floating_fx'] ?? '' ) || true === ( $settings['royal_floating_fx'] ?? false ) ) ) {
			self::royalfloatingeffects_enqueue();
			self::$should_floating_enqueue = true;
		}

		if ( ! self::$should_magnetic_enqueue && ( 'yes' == ( $settings['royal_magnetic'] ?? '' ) || true === ( $settings['royal_magnetic'] ?? false ) ) ) {
			self::royal_magnetic_enqueue();
			self::$should_magnetic_enqueue = true;
		}

		if ( self::$should_floating_enqueue && self::$should_magnetic_enqueue ) {
			remove_action( 'elementor/frontend/before_render', [ __CLASS__, 'should_script_enqueue' ] );
			remove_action( 'elementor/frontend/section/before_render', [ __CLASS__, 'should_script_enqueue' ] );
			remove_action( 'elementor/frontend/widget/before_render', [ __CLASS__, 'should_script_enqueue' ] );
		}
	}

	private static function get_dependency( $path, $value = true ) {
		$manager = \Elementor\Modules\AtomicWidgets\PropDependencies\Manager::make();
		$manager->where( [
			'operator' => 'eq',
			'path' => [ $path ],
			'value' => $value,
		] );
		return $manager->get();
	}

	private static function get_multiple_dependencies( $paths, $value = true ) {
		$manager = \Elementor\Modules\AtomicWidgets\PropDependencies\Manager::make(\Elementor\Modules\AtomicWidgets\PropDependencies\Manager::RELATION_AND);
		foreach ( $paths as $path ) {
			$manager->where( [
				'operator' => 'eq',
				'path' => [ $path ],
				'value' => $value,
			] );
		}
		return $manager->get();
	}

	public static function add_atomic_props_schema( $schema ) {
		// Use Boolean_Prop_Type for switches since that's what Atomic API uses internally for toggles
		$schema['royal_magnetic'] = \Elementor\Modules\AtomicWidgets\PropTypes\Primitives\Boolean_Prop_Type::make()->default(false);
		$schema['royal_floating_fx'] = \Elementor\Modules\AtomicWidgets\PropTypes\Primitives\Boolean_Prop_Type::make()->default(false);

		// User requested that Translate, Rotate, Scale etc. should depend on Enable Magnetic (Wait, actually on Floating Effects as per updated request)
		$schema['royal_floating_fx_translate_toggle'] = \Elementor\Modules\AtomicWidgets\PropTypes\Primitives\Boolean_Prop_Type::make()->default(false)->set_dependencies( self::get_dependency('royal_floating_fx') );
		$schema['royal_floating_fx_translate_x'] = \Elementor\Modules\AtomicWidgets\PropTypes\Size_Prop_Type::make()->default(['size' => 5, 'unit' => 'px'])->set_dependencies( self::get_multiple_dependencies(['royal_floating_fx', 'royal_floating_fx_translate_toggle']) );
		$schema['royal_floating_fx_translate_y'] = \Elementor\Modules\AtomicWidgets\PropTypes\Size_Prop_Type::make()->default(['size' => 5, 'unit' => 'px'])->set_dependencies( self::get_multiple_dependencies(['royal_floating_fx', 'royal_floating_fx_translate_toggle']) );
		$schema['royal_floating_fx_translate_duration'] = \Elementor\Modules\AtomicWidgets\PropTypes\Size_Prop_Type::make()->default(['size' => 1000, 'unit' => 'px'])->set_dependencies( self::get_multiple_dependencies(['royal_floating_fx', 'royal_floating_fx_translate_toggle']) );
		$schema['royal_floating_fx_translate_delay'] = \Elementor\Modules\AtomicWidgets\PropTypes\Size_Prop_Type::make()->default(['size' => 0, 'unit' => 'px'])->set_dependencies( self::get_multiple_dependencies(['royal_floating_fx', 'royal_floating_fx_translate_toggle']) );

		$schema['royal_floating_fx_rotate_toggle'] = \Elementor\Modules\AtomicWidgets\PropTypes\Primitives\Boolean_Prop_Type::make()->default(false)->set_dependencies( self::get_dependency('royal_floating_fx') );
		$schema['royal_floating_fx_rotate_x'] = \Elementor\Modules\AtomicWidgets\PropTypes\Size_Prop_Type::make()->default(['size' => 5, 'unit' => 'px'])->set_dependencies( self::get_multiple_dependencies(['royal_floating_fx', 'royal_floating_fx_rotate_toggle']) );
		$schema['royal_floating_fx_rotate_y'] = \Elementor\Modules\AtomicWidgets\PropTypes\Size_Prop_Type::make()->default(['size' => 5, 'unit' => 'px'])->set_dependencies( self::get_multiple_dependencies(['royal_floating_fx', 'royal_floating_fx_rotate_toggle']) );
		$schema['royal_floating_fx_rotate_z'] = \Elementor\Modules\AtomicWidgets\PropTypes\Size_Prop_Type::make()->default(['size' => 5, 'unit' => 'px'])->set_dependencies( self::get_multiple_dependencies(['royal_floating_fx', 'royal_floating_fx_rotate_toggle']) );
		$schema['royal_floating_fx_rotate_duration'] = \Elementor\Modules\AtomicWidgets\PropTypes\Size_Prop_Type::make()->default(['size' => 1000, 'unit' => 'px'])->set_dependencies( self::get_multiple_dependencies(['royal_floating_fx', 'royal_floating_fx_rotate_toggle']) );
		$schema['royal_floating_fx_rotate_delay'] = \Elementor\Modules\AtomicWidgets\PropTypes\Size_Prop_Type::make()->default(['size' => 0, 'unit' => 'px'])->set_dependencies( self::get_multiple_dependencies(['royal_floating_fx', 'royal_floating_fx_rotate_toggle']) );

		$schema['royal_floating_fx_scale_toggle'] = \Elementor\Modules\AtomicWidgets\PropTypes\Primitives\Boolean_Prop_Type::make()->default(false)->set_dependencies( self::get_dependency('royal_floating_fx') );
		$schema['royal_floating_fx_scale_x'] = \Elementor\Modules\AtomicWidgets\PropTypes\Size_Prop_Type::make()->default(['size' => 1.1, 'unit' => 'px'])->set_dependencies( self::get_multiple_dependencies(['royal_floating_fx', 'royal_floating_fx_scale_toggle']) );
		$schema['royal_floating_fx_scale_y'] = \Elementor\Modules\AtomicWidgets\PropTypes\Size_Prop_Type::make()->default(['size' => 1.1, 'unit' => 'px'])->set_dependencies( self::get_multiple_dependencies(['royal_floating_fx', 'royal_floating_fx_scale_toggle']) );
		$schema['royal_floating_fx_scale_duration'] = \Elementor\Modules\AtomicWidgets\PropTypes\Size_Prop_Type::make()->default(['size' => 1000, 'unit' => 'px'])->set_dependencies( self::get_multiple_dependencies(['royal_floating_fx', 'royal_floating_fx_scale_toggle']) );
		$schema['royal_floating_fx_scale_delay'] = \Elementor\Modules\AtomicWidgets\PropTypes\Size_Prop_Type::make()->default(['size' => 0, 'unit' => 'px'])->set_dependencies( self::get_multiple_dependencies(['royal_floating_fx', 'royal_floating_fx_scale_toggle']) );

		return $schema;
	}

	public static function add_atomic_controls( $controls, $element ) {
		$items = [
			AtomicSwitch::bind_to( 'royal_magnetic' )->set_label( __( 'Enable Magnetic', 'royal-addons-for-elementor' ) ),
			AtomicSwitch::bind_to( 'royal_floating_fx' )->set_label( __( 'Enable Floating', 'royal-addons-for-elementor' ) ),

			AtomicSwitch::bind_to( 'royal_floating_fx_translate_toggle' )->set_label( __( 'Translate', 'royal-addons-for-elementor' ) ),
			AtomicSize::bind_to( 'royal_floating_fx_translate_x' )->set_label( __( 'Translate X', 'royal-addons-for-elementor' ) ),
			AtomicSize::bind_to( 'royal_floating_fx_translate_y' )->set_label( __( 'Translate Y', 'royal-addons-for-elementor' ) ),
			AtomicSize::bind_to( 'royal_floating_fx_translate_duration' )->set_label( __( 'Duration', 'royal-addons-for-elementor' ) ),
			AtomicSize::bind_to( 'royal_floating_fx_translate_delay' )->set_label( __( 'Delay', 'royal-addons-for-elementor' ) ),

			AtomicSwitch::bind_to( 'royal_floating_fx_rotate_toggle' )->set_label( __( 'Rotate', 'royal-addons-for-elementor' ) ),
			AtomicSize::bind_to( 'royal_floating_fx_rotate_x' )->set_label( __( 'Rotate X', 'royal-addons-for-elementor' ) ),
			AtomicSize::bind_to( 'royal_floating_fx_rotate_y' )->set_label( __( 'Rotate Y', 'royal-addons-for-elementor' ) ),
			AtomicSize::bind_to( 'royal_floating_fx_rotate_z' )->set_label( __( 'Rotate Z', 'royal-addons-for-elementor' ) ),
			AtomicSize::bind_to( 'royal_floating_fx_rotate_duration' )->set_label( __( 'Duration', 'royal-addons-for-elementor' ) ),
			AtomicSize::bind_to( 'royal_floating_fx_rotate_delay' )->set_label( __( 'Delay', 'royal-addons-for-elementor' ) ),

			AtomicSwitch::bind_to( 'royal_floating_fx_scale_toggle' )->set_label( __( 'Scale', 'royal-addons-for-elementor' ) ),
			AtomicSize::bind_to( 'royal_floating_fx_scale_x' )->set_label( __( 'Scale X', 'royal-addons-for-elementor' ) ),
			AtomicSize::bind_to( 'royal_floating_fx_scale_y' )->set_label( __( 'Scale Y', 'royal-addons-for-elementor' ) ),
			AtomicSize::bind_to( 'royal_floating_fx_scale_duration' )->set_label( __( 'Duration', 'royal-addons-for-elementor' ) ),
			AtomicSize::bind_to( 'royal_floating_fx_scale_delay' )->set_label( __( 'Delay', 'royal-addons-for-elementor' ) ),
		];

		$controls[] = AtomicSection::make()
			->set_id( 'royalcontrolsection_floatingeffects_atomic' )
			->set_label( __( 'Floating Effects [Royal]', 'royal-addons-for-elementor' ) )
			->set_items( $items );

		return $controls;
	}

	private static $registered_elements = [];

	public static function register( $element, $section_id = '' ) {
		if ( ! ( $element instanceof \Elementor\Element_Base ) ) return;

		// Only run once per element type, wait for the right section
		if ( ! in_array( $section_id, [ 'section_advanced', 'section_custom_css_pro', 'section_custom_css', 'section_effects' ] ) ) {
			return;
		}

		$element_id = $element->get_name();
		if ( isset( self::$registered_elements[ $element_id ] ) ) {
			return;
		}
		self::$registered_elements[ $element_id ] = true;
		$element->start_controls_section(
			'royalcontrolsection_floatingeffects',
			[
				'label' => __( 'Floating Effects [Royal]', 'royal-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_ADVANCED,
			]
		);

		$element->add_control(
			'royal_magnetic',
			[
				'label' => __( 'Enable Magnetic', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'frontend_available' => true,
			]
		);

		$element->add_control(
			'royal_floating_fx',
			[
				'label' => __( 'Enable Floating', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'frontend_available' => true,
			]
		);

		$element->add_control(
			'royal_floating_fx_translate_toggle',
			[
				'label' => __( 'Translate', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::POPOVER_TOGGLE,
				'return_value' => 'yes',
				'frontend_available' => true,
				'condition' => [
					'royal_floating_fx' => 'yes',
				]
			]
		);

		$element->start_popover();

		$element->add_control(
			'royal_floating_fx_translate_x',
			[
				'label' => __( 'Translate X', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'sizes' => [
						'from' => 0,
						'to' => 5,
					],
					'unit' => 'px',
				],
				'range' => [
					'px' => [
						'min' => -100,
						'max' => 100,
					]
				],
				'labels' => [
					__( 'From', 'royal-addons-for-elementor' ),
					__( 'To', 'royal-addons-for-elementor' ),
				],
				'scales' => 1,
				'handles' => 'range',
				'condition' => [
					'royal_floating_fx_translate_toggle' => 'yes',
					'royal_floating_fx' => 'yes',
				],
				'render_type' => 'none',
				'frontend_available' => true,
			]
		);

		$element->add_control(
			'royal_floating_fx_translate_y',
			[
				'label' => __( 'Translate Y', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'sizes' => [
						'from' => 0,
						'to' => 5,
					],
					'unit' => 'px',
				],
				'range' => [
					'px' => [
						'min' => -100,
						'max' => 100,
					]
				],
				'labels' => [
					__( 'From', 'royal-addons-for-elementor' ),
					__( 'To', 'royal-addons-for-elementor' ),
				],
				'scales' => 1,
				'handles' => 'range',
				'condition' => [
					'royal_floating_fx_translate_toggle' => 'yes',
					'royal_floating_fx' => 'yes',
				],
				'render_type' => 'none',
				'frontend_available' => true,
			]
		);

		$element->add_control(
			'royal_floating_fx_translate_duration',
			[
				'label' => __( 'Duration', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 10000,
						'step' => 100
					]
				],
				'default' => [
					'size' => 1000,
				],
				'condition' => [
					'royal_floating_fx_translate_toggle' => 'yes',
					'royal_floating_fx' => 'yes',
				],
				'render_type' => 'none',
				'frontend_available' => true,
			]
		);

		$element->add_control(
			'royal_floating_fx_translate_delay',
			[
				'label' => __( 'Delay', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 5000,
						'step' => 100
					]
				],
				'condition' => [
					'royal_floating_fx_translate_toggle' => 'yes',
					'royal_floating_fx' => 'yes',
				],
				'render_type' => 'none',
				'frontend_available' => true,
			]
		);

		$element->end_popover();

		$element->add_control(
			'royal_floating_fx_rotate_toggle',
			[
				'label' => __( 'Rotate', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::POPOVER_TOGGLE,
				'return_value' => 'yes',
				'frontend_available' => true,
				'condition' => [
					'royal_floating_fx' => 'yes',
				]
			]
		);

		$element->start_popover();

		$element->add_control(
			'royal_floating_fx_rotate_x',
			[
				'label' => __( 'Rotate X', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'sizes' => [
						'from' => 0,
						'to' => 45,
					],
					'unit' => 'px',
				],
				'range' => [
					'px' => [
						'min' => -180,
						'max' => 180,
					]
				],
				'labels' => [
					__( 'From', 'royal-addons-for-elementor' ),
					__( 'To', 'royal-addons-for-elementor' ),
				],
				'scales' => 1,
				'handles' => 'range',
				'condition' => [
					'royal_floating_fx_rotate_toggle' => 'yes',
					'royal_floating_fx' => 'yes',
				],
				'render_type' => 'none',
				'frontend_available' => true,
			]
		);

		$element->add_control(
			'royal_floating_fx_rotate_y',
			[
				'label' => __( 'Rotate Y', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'sizes' => [
						'from' => 0,
						'to' => 45,
					],
					'unit' => 'px',
				],
				'range' => [
					'px' => [
						'min' => -180,
						'max' => 180,
					]
				],
				'labels' => [
					__( 'From', 'royal-addons-for-elementor' ),
					__( 'To', 'royal-addons-for-elementor' ),
				],
				'scales' => 1,
				'handles' => 'range',
				'condition' => [
					'royal_floating_fx_rotate_toggle' => 'yes',
					'royal_floating_fx' => 'yes',
				],
				'render_type' => 'none',
				'frontend_available' => true,
			]
		);

		$element->add_control(
			'royal_floating_fx_rotate_z',
			[
				'label' => __( 'Rotate Z', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'sizes' => [
						'from' => 0,
						'to' => 45,
					],
					'unit' => 'px',
				],
				'range' => [
					'px' => [
						'min' => -180,
						'max' => 180,
					]
				],
				'labels' => [
					__( 'From', 'royal-addons-for-elementor' ),
					__( 'To', 'royal-addons-for-elementor' ),
				],
				'scales' => 1,
				'handles' => 'range',
				'condition' => [
					'royal_floating_fx_rotate_toggle' => 'yes',
					'royal_floating_fx' => 'yes',
				],
				'render_type' => 'none',
				'frontend_available' => true,
			]
		);

		$element->add_control(
			'royal_floating_fx_rotate_duration',
			[
				'label' => __( 'Duration', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 10000,
						'step' => 100
					]
				],
				'default' => [
					'size' => 1000,
				],
				'condition' => [
					'royal_floating_fx_rotate_toggle' => 'yes',
					'royal_floating_fx' => 'yes',
				],
				'render_type' => 'none',
				'frontend_available' => true,
			]
		);

		$element->add_control(
			'royal_floating_fx_rotate_delay',
			[
				'label' => __( 'Delay', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 5000,
						'step' => 100
					]
				],
				'condition' => [
					'royal_floating_fx_rotate_toggle' => 'yes',
					'royal_floating_fx' => 'yes',
				],
				'render_type' => 'none',
				'frontend_available' => true,
			]
		);

		$element->end_popover();

		$element->add_control(
			'royal_floating_fx_scale_toggle',
			[
				'label' => __( 'Scale', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::POPOVER_TOGGLE,
				'return_value' => 'yes',
				'frontend_available' => true,
				'condition' => [
					'royal_floating_fx' => 'yes',
				]
			]
		);

		$element->start_popover();

		$element->add_control(
			'royal_floating_fx_scale_x',
			[
				'label' => __( 'Scale X', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'sizes' => [
						'from' => 1,
						'to' => 1.2,
					],
					'unit' => 'px',
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 5,
						'step' => .1
					]
				],
				'labels' => [
					__( 'From', 'royal-addons-for-elementor' ),
					__( 'To', 'royal-addons-for-elementor' ),
				],
				'scales' => 1,
				'handles' => 'range',
				'condition' => [
					'royal_floating_fx_scale_toggle' => 'yes',
					'royal_floating_fx' => 'yes',
				],
				'render_type' => 'none',
				'frontend_available' => true,
			]
		);

		$element->add_control(
			'royal_floating_fx_scale_y',
			[
				'label' => __( 'Scale Y', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'sizes' => [
						'from' => 1,
						'to' => 1.2,
					],
					'unit' => 'px',
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 5,
						'step' => .1
					]
				],
				'labels' => [
					__( 'From', 'royal-addons-for-elementor' ),
					__( 'To', 'royal-addons-for-elementor' ),
				],
				'scales' => 1,
				'handles' => 'range',
				'condition' => [
					'royal_floating_fx_scale_toggle' => 'yes',
					'royal_floating_fx' => 'yes',
				],
				'render_type' => 'none',
				'frontend_available' => true,
			]
		);

		$element->add_control(
			'royal_floating_fx_scale_duration',
			[
				'label' => __( 'Duration', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 10000,
						'step' => 100
					]
				],
				'default' => [
					'size' => 1000,
				],
				'condition' => [
					'royal_floating_fx_scale_toggle' => 'yes',
					'royal_floating_fx' => 'yes',
				],
				'render_type' => 'none',
				'frontend_available' => true,
			]
		);

		$element->add_control(
			'royal_floating_fx_scale_delay',
			[
				'label' => __( 'Delay', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 5000,
						'step' => 100
					]
				],
				'condition' => [
					'royal_floating_fx_scale_toggle' => 'yes',
					'royal_floating_fx' => 'yes',
				],
				'render_type' => 'none',
				'frontend_available' => true,
			]
		);

		$element->end_popover();

		$element->end_controls_section();
	}

	public static function render_fx( $element ) {
		if ( ! ( $element instanceof \Elementor\Element_Base ) ) return;

		$el_name = $element->get_name();
		$is_atomic = in_array($el_name, ['div-block', 'e-div-block', 'e-flexbox', 'atomic-widget-base']) || (strpos($el_name, 'atomic-') === 0);
		
		// Extract settings properly based on element type
		$settings = $is_atomic && method_exists($element, 'get_atomic_settings') ? $element->get_atomic_settings() : $element->get_settings_for_display();

		if ( 'yes' == ( $settings['royal_magnetic'] ?? 'no' ) || true === ( $settings['royal_magnetic'] ?? false ) ) {
			$element->add_render_attribute( '_wrapper', 'class', 'magnetic' );
		}

		if ( 'yes' == ( $settings['royal_floating_fx'] ?? 'no' ) || true === ( $settings['royal_floating_fx'] ?? false ) ) {
			$element->add_render_attribute( '_wrapper', 'data-royal-floating-fx', 'yes' );
			
			if ( $is_atomic ) {
				// JS requires data-settings on the frontend to parse translate/rotate/scale values.
				// Since Elementor Atomic API might skip standard frontend settings output, we inject them manually.
				$element->add_render_attribute( '_wrapper', 'data-settings', wp_json_encode($settings) );
			}
		}
	}
}

RoyalFloatingEffects::init();
