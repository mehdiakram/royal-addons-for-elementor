<?php

use Elementor\Controls_Manager;
use Elementor\Widget_Base;
use Elementor\Utils;
use Elementor\Modules\AtomicWidgets\Controls\Section as AtomicSection;
use Elementor\Modules\AtomicWidgets\Controls\Types\Switch_Control as AtomicSwitch;
use Elementor\Modules\AtomicWidgets\Controls\Types\Select_Control as AtomicSelect;
use Elementor\Modules\AtomicWidgets\Controls\Types\Number_Control as AtomicNumber;
use Elementor\Modules\AtomicWidgets\Controls\Types\Text_Control as AtomicText;
use Elementor\Modules\AtomicWidgets\PropTypes\Primitives\String_Prop_Type;
use Elementor\Modules\AtomicWidgets\Utils\Utils as AtomicUtils;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class RoyalAOS {
	static $should_script_enqueue = false;
	
	public static function init() {
		// Universal hook that fires for ALL element types including Atomic Containers, Div Blocks, etc.
		// We check the section_id inside the callback to only register once per element.
		add_action( 'elementor/element/after_section_end', [ __CLASS__, 'royal_wrapper_aos_atomic' ], 10, 2 );

		// Elementor 4 Atomic API Hooks
		add_filter( 'elementor/atomic-widgets/props-schema', [ __CLASS__, 'add_atomic_props_schema' ], 10, 1 );
		add_filter( 'elementor/atomic-widgets/controls', [ __CLASS__, 'add_atomic_controls' ], 10, 2 );

		add_action('elementor/frontend/before_render', [__CLASS__, 'royalaos_before_render'], 10, 1 );	
		add_action('elementor/frontend/before_render', [__CLASS__, 'should_script_enqueue']);
		add_action('elementor/frontend/widget/before_render', [__CLASS__, 'should_script_enqueue']);
		add_action('elementor/preview/enqueue_scripts', [__CLASS__, 'royalaos_enqueue']);
	}
	
    public static function royalaos_enqueue() {
		wp_enqueue_script('royalaos', ROYAL_ADDONS_DIR_URL.'assets/vendor/aos/aos.js', [], '' );
		wp_enqueue_style('royalaos', ROYAL_ADDONS_DIR_URL . 'assets/vendor/aos/aos.css');
		
		add_action( 'wp_print_footer_scripts', function () { 
		?>
			<script>
				jQuery(document).ready(function(){
				AOS.init();	
			})
			</script>
		<?php 
		} );
		
    }


    public static function should_script_enqueue($section) {
        if (self::$should_script_enqueue) {
            return;
        }

		$el_name = $section->get_name();
		$is_atomic = in_array($el_name, ['div-block', 'e-div-block', 'e-flexbox', 'atomic-widget-base']) || (strpos($el_name, 'atomic-') === 0);
		$settings = $is_atomic && method_exists($section, 'get_atomic_settings') ? $section->get_atomic_settings() : $section->get_settings_for_display();

        if ('enable' == ($settings['royalaos_active'] ?? 'no')) {
            self::$should_script_enqueue = true;
            self::royalaos_enqueue();
            remove_action('elementor/frontend/before_render', [__CLASS__, 'should_script_enqueue']);
            remove_action('elementor/frontend/section/before_render', [__CLASS__, 'should_script_enqueue']);
            remove_action('elementor/frontend/widget/before_render', [__CLASS__, 'should_script_enqueue']);
        }
    }	
	
	
		
	/* Atomic Elements - registered tracker */
	private static $registered_elements = [];

	public static function add_atomic_props_schema( $schema ) {
		$schema['royalaos_active'] = String_Prop_Type::make()->default('no');
		$schema['royal_aos_animation'] = String_Prop_Type::make()->default('fade');
		$schema['royal_aos_easing_function'] = String_Prop_Type::make()->default('ease');
		$schema['royal_aos_placement'] = String_Prop_Type::make()->default('top-bottom');
		$schema['royal_aos_offset'] = String_Prop_Type::make()->default('120');
		$schema['royal_aos_delay'] = String_Prop_Type::make()->default('0');
		$schema['royal_aos_duration'] = String_Prop_Type::make()->default('400');
		$schema['royal_aos_placement_once'] = String_Prop_Type::make()->default('false');
		$schema['royal_aos_placement_mirror'] = String_Prop_Type::make()->default('true');
		$schema['royal_aos_anchor'] = String_Prop_Type::make()->default('');
		return $schema;
	}

	public static function add_atomic_controls( $controls, $element ) {
		$controls[] = AtomicSection::make()
			->set_id( 'royalcontrolsection_aos_atomic' )
			->set_label( __( 'AOS [Royal]', 'royal-addons-for-elementor' ) )
			->set_items( [
				AtomicSwitch::bind_to( 'royalaos_active' )
					->set_label( __( 'Enable AOS?', 'royal-addons-for-elementor' ) ),
				AtomicSelect::bind_to( 'royal_aos_animation' )
					->set_label( __( 'Animation', 'royal-addons-for-elementor' ) )
					->set_options( [
						[ 'value' => 'fade', 'label' => 'Fade' ],
						[ 'value' => 'fade-up', 'label' => 'Fade Up' ],
						[ 'value' => 'fade-down', 'label' => 'Fade Down' ],
						[ 'value' => 'fade-left', 'label' => 'Fade Left' ],
						[ 'value' => 'fade-right', 'label' => 'Fade Right' ],
						[ 'value' => 'flip-up', 'label' => 'Flip Up' ],
						[ 'value' => 'flip-down', 'label' => 'Flip Down' ],
						[ 'value' => 'flip-left', 'label' => 'Flip Left' ],
						[ 'value' => 'flip-right', 'label' => 'Flip Right' ],
						[ 'value' => 'slide-up', 'label' => 'Slide Up' ],
						[ 'value' => 'slide-down', 'label' => 'Slide Down' ],
						[ 'value' => 'zoom-in', 'label' => 'Zoom In' ],
						[ 'value' => 'zoom-out', 'label' => 'Zoom Out' ],
					] ),
				AtomicSelect::bind_to( 'royal_aos_easing_function' )
					->set_label( __( 'Easing Function', 'royal-addons-for-elementor' ) )
					->set_options( [
						[ 'value' => 'linear', 'label' => 'Linear' ],
						[ 'value' => 'ease', 'label' => 'Ease' ],
						[ 'value' => 'ease-in-out', 'label' => 'Ease In Out' ],
					] ),
				AtomicNumber::bind_to( 'royal_aos_duration' )
					->set_label( __( 'Duration (ms)', 'royal-addons-for-elementor' ) ),
				AtomicNumber::bind_to( 'royal_aos_delay' )
					->set_label( __( 'Delay (ms)', 'royal-addons-for-elementor' ) ),
				AtomicNumber::bind_to( 'royal_aos_offset' )
					->set_label( __( 'Offset (px)', 'royal-addons-for-elementor' ) ),
				AtomicSwitch::bind_to( 'royal_aos_placement_once' )
					->set_label( __( 'Once', 'royal-addons-for-elementor' ) ),
				AtomicSwitch::bind_to( 'royal_aos_placement_mirror' )
					->set_label( __( 'Mirror', 'royal-addons-for-elementor' ) ),
				AtomicText::bind_to( 'royal_aos_anchor' )
					->set_label( __( 'Anchor ID', 'royal-addons-for-elementor' ) ),
			] );

		return $controls;
	}

	public static function royal_wrapper_aos_atomic( $element, $section_id = '' ) {
		if ( ! ( $element instanceof \Elementor\Element_Base ) ) return;

		// Only register once, on the 'section_advanced' or 'section_custom_css_pro' hook
		if ( ! in_array( $section_id, [ 'section_advanced', 'section_custom_css_pro' ] ) ) return;

		$element_id = $element->get_name();
		if ( isset( self::$registered_elements[ $element_id ] ) ) {
			return;
		}
		self::$registered_elements[ $element_id ] = true;
		self::royal_wrapper_aos( $element );
	}

	public static function royal_wrapper_aos($element) {
		$el_name = $element->get_name();
		$is_atomic = in_array($el_name, ['div-block', 'e-div-block', 'e-flexbox', 'atomic-widget-base']) || (strpos($el_name, 'atomic-') === 0);
		
		$target_tab = $is_atomic ? Controls_Manager::TAB_ADVANCED : Controls_Manager::TAB_ADVANCED; // AOS usually stays in Advanced anyway, but this ensures consistency

		$element->start_controls_section(
			'royalcontrolsection_aos',
			[
				'label' => esc_html__( 'AOS [Royal]', 'royal-addons-for-elementor' ),
				'tab'   => $target_tab,
			]
		);
		
		$element->add_control(
			'royalaos_active',
			[
				'label'        => esc_html__( 'Enable AOS?', 'royal-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
                'label_on' => __('On', 'royal-addons-for-elementor'),
                'label_off' => __('Off', 'royal-addons-for-elementor'),
                'return_value' => 'enable',
				'default' 		=> 'no',
			]
		);

		$element->add_control(
			'royal_aos_animation',
			[
				'type' => \Elementor\Controls_Manager::SELECT,
				'label' => esc_html__( 'Animation', 'royal-addons-for-elementor' ),
				'options' => [
					'fade' 				=> esc_html__( 'Fade', 'royal-addons-for-elementor' ),
					'fade-up' 			=> esc_html__( 'Fade Up', 'royal-addons-for-elementor' ),
					'fade-down' 		=> esc_html__( 'Fade Down', 'royal-addons-for-elementor' ),
					'fade-left' 		=> esc_html__( 'Fade Left', 'royal-addons-for-elementor' ),
					'fade-right' 		=> esc_html__( 'Fade Right', 'royal-addons-for-elementor' ),
					'fade-up-right' 	=> esc_html__( 'Fade Up Right', 'royal-addons-for-elementor' ),
					'fade-up-left' 		=> esc_html__( 'Fade Up Left', 'royal-addons-for-elementor' ),
					'fade-down-right' 	=> esc_html__( 'Fade Down Right', 'royal-addons-for-elementor' ),
					'fade-down-left' 	=> esc_html__( 'Fade Down Left', 'royal-addons-for-elementor' ),
					'flip-up' 			=> esc_html__( 'Flip Up', 'royal-addons-for-elementor' ),
					'flip-down' 		=> esc_html__( 'Flip Down', 'royal-addons-for-elementor' ),
					'flip-left' 		=> esc_html__( 'Flip Left', 'royal-addons-for-elementor' ),
					'flip-right' 		=> esc_html__( 'Flip Right', 'royal-addons-for-elementor' ),	
					'slide-up' 			=> esc_html__( 'Slide Up', 'royal-addons-for-elementor' ),
					'slide-down' 		=> esc_html__( 'Slide Down', 'royal-addons-for-elementor' ),
					'slide-left' 		=> esc_html__( 'Slide Left', 'royal-addons-for-elementor' ),
					'slide-right' 		=> esc_html__( 'Slide Right', 'royal-addons-for-elementor' ),
					'zoom-in' 			=> esc_html__( 'Zoom In', 'royal-addons-for-elementor' ),
					'zoom-in-up' 		=> esc_html__( 'Zoom In Up', 'royal-addons-for-elementor' ),
					'zoom-in-down' 		=> esc_html__( 'Zoom In Down', 'royal-addons-for-elementor' ),
					'zoom-in-left' 		=> esc_html__( 'Zoom In Left', 'royal-addons-for-elementor' ),
					'zoom-in-right' 	=> esc_html__( 'Zoom In Right', 'royal-addons-for-elementor' ),
					'zoom-out' 			=> esc_html__( 'Zoom Out', 'royal-addons-for-elementor' ),
					'zoom-out-up' 		=> esc_html__( 'Zoom Out Up', 'royal-addons-for-elementor' ),
					'zoom-out-down' 	=> esc_html__( 'Zoom Out Down', 'royal-addons-for-elementor' ),
					'zoom-out-left' 	=> esc_html__( 'Zoom Out Left', 'royal-addons-for-elementor' ),
					'zoom-out-right' 	=> esc_html__( 'Zoom Out Right', 'royal-addons-for-elementor' ),
					
				],
				'default' => 'fade',
				'condition' => [
					'royalaos_active' => 'enable',
				],				
			]
		);		
		
		
		$element->add_control(
			'royal_aos_easing_function',
			[
				'type' => \Elementor\Controls_Manager::SELECT,
				'label' => esc_html__( 'Easing Function', 'royal-addons-for-elementor' ),
				'options' => [
					'linear' 				=> esc_html__( 'Linear', 'royal-addons-for-elementor' ),
					'ease' 					=> esc_html__( 'Ease', 'royal-addons-for-elementor' ),
					'ease-in' 				=> esc_html__( 'Ease In', 'royal-addons-for-elementor' ),
					'ease-out' 				=> esc_html__( 'Ease Out', 'royal-addons-for-elementor' ),
					'ease-in-out' 			=> esc_html__( 'Ease In Out', 'royal-addons-for-elementor' ),
					'ease-in-back' 			=> esc_html__( 'Ease In Back', 'royal-addons-for-elementor' ),
					'ease-out-back' 		=> esc_html__( 'Ease Out Back', 'royal-addons-for-elementor' ),
					'ease-in-out-back' 		=> esc_html__( 'Ease In Out Back', 'royal-addons-for-elementor' ),
					'ease-in-sine' 			=> esc_html__( 'Ease In Sine', 'royal-addons-for-elementor' ),
					'ease-out-sine' 		=> esc_html__( 'Ease Out Sine', 'royal-addons-for-elementor' ),
					'ease-in-out-sine' 		=> esc_html__( 'Ease In Out Sine', 'royal-addons-for-elementor' ),
					'ease-in-quad' 			=> esc_html__( 'Ease In Quad', 'royal-addons-for-elementor' ),
					'ease-out-quad' 		=> esc_html__( 'Ease Out Quad', 'royal-addons-for-elementor' ),
					'ease-in-out-quad' 		=> esc_html__( 'Ease In Out Quad', 'royal-addons-for-elementor' ),
					'ease-in-cubic' 		=> esc_html__( 'Ease In Cubic', 'royal-addons-for-elementor' ),
					'ease-out-cubic' 		=> esc_html__( 'Ease Out Cubic', 'royal-addons-for-elementor' ),
					'ease-in-out-cubic' 	=> esc_html__( 'Ease In Out Cubic', 'royal-addons-for-elementor' ),
					'ease-in-quart' 		=> esc_html__( 'Ease In Quart', 'royal-addons-for-elementor' ),
					'ease-out-quart' 		=> esc_html__( 'Ease Out Quart', 'royal-addons-for-elementor' ),
					'ease-in-out-quart' 	=> esc_html__( 'Ease In Out Quart', 'royal-addons-for-elementor' ),
				],
				'default' => 'ease',
				'condition' => [
					'royalaos_active' => 'enable',
				],				
			]
		);		
		
		
		
		$element->add_control(
			'royal_aos_placement',
			[
				'type' => \Elementor\Controls_Manager::SELECT,
				'label' => esc_html__( 'Anchor Placement', 'royal-addons-for-elementor' ),
				'options' => [
					'top-bottom' 			=> esc_html__( 'Top Bottom', 'royal-addons-for-elementor' ),
					'top-center' 			=> esc_html__( 'Top Center', 'royal-addons-for-elementor' ),
					'top-top' 				=> esc_html__( 'Top Top', 'royal-addons-for-elementor' ),					
					'center-bottom' 		=> esc_html__( 'Center Bottom', 'royal-addons-for-elementor' ),
					'center-center' 		=> esc_html__( 'Center Center', 'royal-addons-for-elementor' ),
					'center-top' 			=> esc_html__( 'Center Top', 'royal-addons-for-elementor' ),					
					'bottom-bottom' 		=> esc_html__( 'Bottom Bottom', 'royal-addons-for-elementor' ),
					'bottom-center' 		=> esc_html__( 'Bottom Center', 'royal-addons-for-elementor' ),
					'bottom-top' 			=> esc_html__( 'Bottom Top', 'royal-addons-for-elementor' ),
				],
				'default' => 'top-bottom',
				'condition' => [
					'royalaos_active' => 'enable',
				],				
			]
		);			
		
		
		$element->add_control(
			'royal_aos_offset',
			[
				'label' => esc_html__( 'Offset (px)', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 5000,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 120,
				],
				'condition' => [
					'royalaos_active' => 'enable',
				],					
			]
		);		
		
		
		
		$element->add_control(
			'royal_aos_delay',
			[
				'label' => esc_html__( 'Delay (Millisecond)', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'ms' ],
				'range' => [
					'ms' => [
						'min' => 0,
						'max' => 3000,
						'step' => 50,
					],
				],
				'default' => [
					'unit' => 'ms',
					'size' => 0,
				],
				'condition' => [
					'royalaos_active' => 'enable',
				],					
			]
		);			
		
		
		
		$element->add_control(
			'royal_aos_duration',
			[
				'label' => esc_html__( 'Duration (Millisecond)', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'ms' ],
				'range' => [
					'ms' => [
						'min' => 0,
						'max' => 5000,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'ms',
					'size' => 400,
				],
				'condition' => [
					'royalaos_active' => 'enable',
				],					
			]
		);			
		
		
		
		$element->add_control(
			'royal_aos_placement_once',
			[
				'label'        	=> esc_html__( 'Once', 'royal-addons-for-elementor' ),
				'type'         	=> Controls_Manager::SWITCHER,
				'label_on' 		=> esc_html__( 'True', 'royal-addons-for-elementor' ),
				'label_off' 	=> esc_html__( 'False', 'royal-addons-for-elementor' ),				
				'return_value' 	=> 'true',
				'default' 		=> 'false',
				'condition' => [
					'royalaos_active' => 'enable',
				],					
			]
		);		
		
		$element->add_control(
			'royal_aos_placement_mirror',
			[
				'label'        	=> esc_html__( 'Mirror', 'royal-addons-for-elementor' ),
				'type'         	=> Controls_Manager::SWITCHER,
				'label_on' 		=> esc_html__( 'True', 'royal-addons-for-elementor' ),
				'label_off' 	=> esc_html__( 'False', 'royal-addons-for-elementor' ),				
				'return_value' 	=> 'true',
				'default' 		=> 'true',
				'condition' => [
					'royalaos_active' => 'enable',
				],					
			]
		);	
		
		$element->add_control(
			'royal_aos_anchor',
			[
				'label'        	=> esc_html__( 'Anchor', 'royal-addons-for-elementor' ),
				'type'         	=> Controls_Manager::TEXT,
				'default' 		=> '',
				'condition' => [
					'royalaos_active' => 'enable',
				],					
			]
		);	
		
		$element->end_controls_section();
	}


	public static function royalaos_before_render( $element ) {
		if ( ! ( $element instanceof \Elementor\Element_Base ) ) return;

		$el_name = $element->get_name();
		$is_atomic = in_array($el_name, ['div-block', 'e-div-block', 'e-flexbox', 'atomic-widget-base']) || (strpos($el_name, 'atomic-') === 0);
		$settings = $is_atomic && method_exists($element, 'get_atomic_settings') ? $element->get_atomic_settings() : $element->get_settings_for_display();

		if ( ! empty( $settings['royalaos_active'] ) && $settings['royalaos_active'] === 'enable' ) {
			$aos_delay = is_array( $settings['royal_aos_delay'] ) ? $settings['royal_aos_delay']['size'] : ( $settings['royal_aos_delay'] ?? 0 );
			$aos_duration = is_array( $settings['royal_aos_duration'] ) ? $settings['royal_aos_duration']['size'] : ( $settings['royal_aos_duration'] ?? 400 );
			$aos_offset = is_array( $settings['royal_aos_offset'] ) ? $settings['royal_aos_offset']['size'] : ( $settings['royal_aos_offset'] ?? 120 );

			$element->add_render_attribute( '_wrapper', 
			array(			
				'data-aos' 						=> $settings['royal_aos_animation'] ?? 'fade',
				'data-aos-easing' 				=> $settings['royal_aos_easing_function'] ?? 'ease',
				'data-aos-anchor-placement' 	=> $settings['royal_aos_placement'] ?? 'top-bottom',
				'data-aos-delay' 				=> $aos_delay,
				'data-aos-duration' 			=> $aos_duration,
				'data-aos-once' 				=> $settings['royal_aos_placement_once'] ?? 'false',
				'data-aos-mirror' 				=> $settings['royal_aos_placement_mirror'] ?? 'true',
				'data-aos-offset' 				=> $aos_offset,
				'data-aos-anchor' 				=> $settings['royal_aos_anchor'] ?? '',
			) );
		}
	}

}

RoyalAOS::init();