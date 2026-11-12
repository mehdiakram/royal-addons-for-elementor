<?php
use Elementor\Controls_Manager;
use Elementor\Element_Base;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;

if ( ! defined( 'ABSPATH' ) ) {	exit; }


class RoyalCounterz {

	static $should_script_enqueue = false;


	public static function init() {
		// Universal hook that fires for ALL element types including Atomic Containers, Div Blocks, etc.
		add_action( 'elementor/element/after_section_end', [ __CLASS__, 'royal_counterz_opts_atomic' ], 10, 2 );

		// Elementor 4 Atomic API Hooks
		add_filter( 'elementor/atomic-widgets/props-schema', [ __CLASS__, 'add_atomic_props_schema' ], 10, 1 );
		add_filter( 'elementor/atomic-widgets/controls', [ __CLASS__, 'add_atomic_controls' ], 10, 2 );

		add_action( 'elementor/element/counter/section_title/after_section_end',  [ __CLASS__, 'royal_counterz_opts' ], 10, 1 ); 
        add_action( 'elementor/element/after_add_attributes',  [ __CLASS__, 'add_attributes' ] );

        /* should enqueue? */
		add_action( 'elementor/frontend/before_render', [ __CLASS__, 'should_script_enqueue' ] );
        add_action( 'elementor/frontend/widget/before_render', [ __CLASS__, 'should_script_enqueue' ] );
        /* add script */
        add_action( 'elementor/preview/enqueue_scripts', [ __CLASS__, 'enqueue_scripts' ] );

    }

    /* enqueue script JS */
    public static function enqueue_scripts() {
		wp_enqueue_script('royalcounterz', ROYAL_ADDONS_DIR_URL.'assets/js/extension-counterz.js', [], '' );
    }

    /* should enqueue? */
    public static function should_script_enqueue( $element ) {

        if( self::$should_script_enqueue ) return;

        if( 'yes' == $element->get_settings_for_display( '_royal_use_counterz' ) ) {

            self::$should_script_enqueue = true;
            self::enqueue_scripts();

            remove_action( 'elementor/element/counter/section_title/after_section_end', [ __CLASS__, 'should_script_enqueue' ] );
        }
    }

    public static function add_attributes( $element ) {

        if( ! in_array( $element->get_name(), [ 'counter' ] ) ) return;
		$settings = $element->get_settings();
        $is_counterz = isset( $settings[ '_royal_use_counterz' ] ) ? $settings[ '_royal_use_counterz' ] : '';
        
        if( 'yes' === $is_counterz ) 
            $element->add_render_attribute( '_wrapper', 'class', 'royal-use-counterz' );

    }
    
	public static function royal_counterz_opts( $element ) {
		if ( ! ( $element instanceof \Elementor\Element_Base ) ) return;

		$element_id = $element->get_name();
		if ( isset( self::$registered_elements[ $element_id ] ) ) {
			return;
		}
		self::$registered_elements[ $element_id ] = true;

		$element->start_controls_section(
            'royalcontrolsection_counterz',
            [
                'label' => 'CounterZ',
				'tab' => Controls_Manager::TAB_STYLE, 
				'hide_in_inner' => true, 
            ]
        );

		// --------------------------------------------------------------------------------------------- CONTROL: Use Counterz
		$element->add_control(
			'_royal_use_counterz',
			[
                'label' => esc_html__( 'Enable Counterz?', 'royal-addons-for-elementor' ), 
				'separator' => 'after', 
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'royal-addons-for-elementor' ),
				'label_off' => esc_html__( 'No', 'royal-addons-for-elementor' ),
				'return_value' => 'yes',
				'default' => 'yes',
				'frontend_available' => true,
			]
		);

        // --------------------------------------------------------------------------------------------- CONTROL Description - Faker !!!!!
        $element->add_control(
            '_royal_use_counterz_fake_descr_1',
            [
                'type' => Controls_Manager::RAW_HTML, 
                'label' => __( 'Numbers', 'royal-addons-for-elementor' ),
                'raw' => __( 'Additional options to the Numbers element', 'royal-addons-for-elementor' ), 
                'content_classes' => 'elementor-control-field-description', 
				'condition' => [
					'_royal_use_counterz' => 'yes', 
				],
            ]
        );
        // ------------------------------------------------------------------------- CONTROL: Numbers alignment
		$element->add_responsive_control(
			'_ob_counterz_numbers_align',
			[
				'label' => __( 'Align numbers', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SELECT,
                'default' => 'center', 
				'options' => [
					'flex-start' => __( 'Start', 'royal-addons-for-elementor' ),
					'center' => __( 'Center', 'royal-addons-for-elementor' ), 
					'flex-end' => __( 'End', 'royal-addons-for-elementor' ), 
					'space-between' => __( 'Space Between', 'royal-addons-for-elementor' ), 
					'space-around' => __( 'Space Around', 'royal-addons-for-elementor' ), 
					'space-evenly' => __( 'Space Evenly', 'royal-addons-for-elementor' ),
				],
				'selectors' => [
					'{{WRAPPER}}.royal-use-counterz span[class*="elementor-counter-number"]' => 'flex-grow: unset;', 
                    '{{WRAPPER}}.royal-use-counterz .elementor-counter-number-wrapper' => 'justify-content: {{VALUE}};', 
				],
				'condition' => [
					'_royal_use_counterz' => 'yes', 
				],
			]
		);
		// ------------------------------------------------------------------------- CONTROL: Counterz title MARGIN
		$element->add_responsive_control(
			'_ob_counterz_numbers_marginz',
			[
				'label' => __( 'Margin', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%', 'custom' ],
				'default' => [
					'unit' => 'px',
					'size' => 0,
                ],
				'selectors' => [
					'{{WRAPPER}}.royal-use-counterz .elementor-counter-number-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
				'condition' => [
					'_royal_use_counterz' => 'yes', 
				],
			]
        );

 		// ------------------------------------------------------------------------- CONTROL: Counterz title PADDING
         $element->add_responsive_control(
			'_ob_counterz_numbers_padding',
			[
				'label' => __( 'Padding', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%', 'custom' ],
				'default' => [
					'unit' => 'px',
					'size' => 0,
                ],
				'selectors' => [
					'{{WRAPPER}}.royal-use-counterz .elementor-counter-number-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
				'condition' => [
					'_royal_use_counterz' => 'yes', 
				],
			]
        );
		// --------------------------------------------------------------------------------------------- CONTROL BACKGROUND
		$element->add_group_control(
            Group_Control_Background::get_type(),
            [
				'name' => '_ob_counterz_numbers_bg', 
                'selector' => '{{WRAPPER}}.royal-use-counterz .elementor-counter-number-wrapper',
				'condition' => [
					'_royal_use_counterz' => 'yes', 
				],
            ]
		);
		// --------------------------------------------------------------------------------------------- CONTROL BORDER Regular
		$element->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => '_ob_counterz_numbers_border', 
				'label' => __( 'Border', 'royal-addons-for-elementor' ), 
				'separator' => 'before', 
				'selector' => '{{WRAPPER}}.royal-use-counterz .elementor-counter-number-wrapper',
				'condition' => [
                    '_royal_use_counterz' => 'yes',
                ],
			]
		);


        // --------------------------------------------------------------------------------------------- CONTROL Description - Faker !!!!!
        $element->add_control(
            '_royal_use_counterz_fake_descr_2',
            [
                'type' => Controls_Manager::RAW_HTML, 
                'label' => __( 'Title', 'royal-addons-for-elementor' ),
                'raw' => __( 'Additional options to the Title element', 'royal-addons-for-elementor' ), 
                'content_classes' => 'elementor-control-field-description', 
				'condition' => [
					'_royal_use_counterz' => 'yes', 
				],
            ]
        );

        // ------------------------------------------------------------------------- CONTROL: Counterz title alignment
		$element->add_responsive_control(
			'_ob_counterz_title_align',
			[
				'label' => __( 'Align title', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SELECT,
                'default' => 'center', 
				'options' => [
					'left' => __( 'Left', 'royal-addons-for-elementor' ),
					'center' => __( 'Center', 'royal-addons-for-elementor' ), 
					'right' => __( 'Right', 'royal-addons-for-elementor' ), 
				],
				'selectors' => [
					'{{WRAPPER}}.royal-use-counterz .elementor-counter-title' => 'text-align: {{VALUE}};',
				],
				'condition' => [
					'_royal_use_counterz' => 'yes', 
				],
			]
		);
		// ------------------------------------------------------------------------- CONTROL: Counterz title MARGIN
		$element->add_responsive_control(
			'_ob_counterz_title_marginz',
			[
				'label' => __( 'Margin', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%', 'custom' ],
				'default' => [
					'unit' => 'px',
					'size' => 0,
                ],
				'selectors' => [
					'{{WRAPPER}}.royal-use-counterz .elementor-counter-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
				'condition' => [
					'_royal_use_counterz' => 'yes', 
				],
			]
        );

 		// ------------------------------------------------------------------------- CONTROL: Counterz title PADDING
         $element->add_responsive_control(
			'_ob_counterz_title_padding',
			[
				'label' => __( 'Padding', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%', 'custom' ],
				'default' => [
					'unit' => 'px',
					'size' => 0,
                ],
				'selectors' => [
					'{{WRAPPER}}.royal-use-counterz .elementor-counter-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
				'condition' => [
					'_royal_use_counterz' => 'yes', 
				],
			]
        );
		// --------------------------------------------------------------------------------------------- CONTROL BACKGROUND
		$element->add_group_control(
            Group_Control_Background::get_type(),
            [
				'name' => '_ob_counterz_title_bg', 
                'selector' => '{{WRAPPER}}.royal-use-counterz .elementor-counter-title',
				'condition' => [
					'_royal_use_counterz' => 'yes', 
				],
            ]
		);
		// --------------------------------------------------------------------------------------------- CONTROL BORDER Regular
		$element->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => '_ob_counterz_title_border', 
				'label' => __( 'Border', 'royal-addons-for-elementor' ), 
				'separator' => 'before', 
				'selector' => '{{WRAPPER}}.royal-use-counterz .elementor-counter-title',
				'condition' => [
                    '_royal_use_counterz' => 'yes',
                ],
			]
		);


        $element->end_controls_section();
	}

	/* Atomic Elements - registered tracker */
	private static $registered_elements = [];

	public static function add_atomic_props_schema( $schema ) {
		$schema['_royal_use_counterz'] = \Elementor\Modules\AtomicWidgets\PropTypes\Primitives\String_Prop_Type::make()->default('no');
		return $schema;
	}

	public static function add_atomic_controls( $controls, $element ) {
		$controls[] = \Elementor\Modules\AtomicWidgets\Controls\Section::make()
			->set_id( 'royalcontrolsection_counterz_atomic' )
			->set_label( __( 'CounterZ [Royal]', 'royal-addons-for-elementor' ) )
			->set_items( [
				\Elementor\Modules\AtomicWidgets\Controls\Types\Switch_Control::bind_to( '_royal_use_counterz' )
					->set_label( __( 'Enable Counterz', 'royal-addons-for-elementor' ) )
			] );

		return $controls;
	}

	public static function royal_counterz_opts_atomic( $element, $section_id = '' ) {
		// Only register once, on the 'section_advanced' hook
		if ( ! in_array( $section_id, [ 'section_advanced', 'section_custom_css_pro' ] ) ) return;

		self::royal_counterz_opts( $element );
	}

}

RoyalCounterz::init();