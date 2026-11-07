<?php

use Elementor\Controls_Manager;
use Elementor\Widget_Base;
use Elementor\Utils;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class RoyalEqualHeight {
	
	static $should_script_enqueue = false;

	public static function init() {
		// Universal hook that fires for ALL element types including Atomic Containers, Div Blocks, etc.
		add_action( 'elementor/element/after_section_end', [ __CLASS__, 'royal_equalheight_controls_atomic' ], 10, 2 );

		// Elementor 4 Atomic API Hooks
		add_filter( 'elementor/atomic-widgets/props-schema', [ __CLASS__, 'add_atomic_props_schema' ], 10, 1 );
		add_filter( 'elementor/atomic-widgets/controls', [ __CLASS__, 'add_atomic_controls' ], 10, 2 );

		add_action('elementor/frontend/before_render', [__CLASS__, 'royal_equalheight_render'], 10, 1 );		
		add_action('elementor/frontend/before_render', [__CLASS__, 'should_script_enqueue']);
        add_action('elementor/frontend/widget/before_render', [__CLASS__, 'should_script_enqueue']);
        add_action('elementor/editor/before_enqueue_scripts', [__CLASS__, 'royalequalheight_enqueue']);
	}	
	
	
    public static function royalequalheight_enqueue() {
		wp_enqueue_script('royalequalheight', ROYAL_ADDONS_DIR_URL.'assets/js/extension-royalequalheight.js', [], '' );
    }


    public static function should_script_enqueue($section) {
        if (self::$should_script_enqueue) {
            return;
        }

		$el_name = $section->get_name();
		$is_atomic = in_array($el_name, ['div-block', 'e-div-block', 'e-flexbox', 'atomic-widget-base']) || (strpos($el_name, 'atomic-') === 0);
		$settings = $is_atomic && method_exists($section, 'get_atomic_settings') ? $section->get_atomic_settings() : $section->get_settings_for_display();

        if ('yes' == ($settings['royaleh_switch'] ?? 'no')) {
            self::$should_script_enqueue = true;
            self::royalequalheight_enqueue();
            remove_action('elementor/frontend/before_render', [__CLASS__, 'should_script_enqueue']);
            remove_action('elementor/frontend/section/before_render', [__CLASS__, 'should_script_enqueue']);
            remove_action('elementor/frontend/widget/before_render', [__CLASS__, 'should_script_enqueue']);
        }
    }
	/* Atomic Elements - registered tracker */
	private static $registered_elements = [];

	public static function add_atomic_props_schema( $schema ) {
		$schema['royaleh_switch'] = \Elementor\Modules\AtomicWidgets\PropTypes\Primitives\String_Prop_Type::make()->default('no');
		return $schema;
	}

	public static function add_atomic_controls( $controls, $element ) {
		$controls[] = \Elementor\Modules\AtomicWidgets\Controls\Section::make()
			->set_id( 'royalcontrolsection_equalheight_atomic' )
			->set_label( __( 'Equal Height [Royal]', 'royal-addons-for-elementor' ) )
			->set_items( [
				\Elementor\Modules\AtomicWidgets\Controls\Types\Switch_Control::bind_to( 'royaleh_switch' )
					->set_label( __( 'Enable Equal Height', 'royal-addons-for-elementor' ) )
			] );

		return $controls;
	}

	public static function royal_equalheight_controls_atomic( $element, $section_id = '' ) {
		if ( ! ( $element instanceof \Elementor\Element_Base ) ) return;

		// Only register once, on the 'section_advanced' or 'section_custom_css_pro' hook
		if ( ! in_array( $section_id, [ 'section_advanced', 'section_custom_css_pro' ] ) ) return;

		$element_id = $element->get_name();
		if ( isset( self::$registered_elements[ $element_id ] ) ) {
			return;
		}
		self::$registered_elements[ $element_id ] = true;
		self::royal_equalheight_controls( $element );
	}

	public static function royal_equalheight_controls($element) {		
		$el_name = $element->get_name();
		$is_atomic = in_array($el_name, ['div-block', 'e-div-block', 'e-flexbox', 'atomic-widget-base']) || (strpos($el_name, 'atomic-') === 0);
		
		$target_tab = $is_atomic ? Controls_Manager::TAB_ADVANCED : Controls_Manager::TAB_ADVANCED;

		$element->start_controls_section(
			'royalcontrolsection_equalheight',
			[
				'label' => esc_html__( 'Equal Height [Royal]', 'royal-addons-for-elementor' ),
				'tab'   => $target_tab,
			]
		);
		$element->add_control(
			'royaleh_switch',
			[
				'label'        => esc_html__( 'Equal Height', 'royal-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Enable', 'royal-addons-for-elementor' ),
				'label_off' => esc_html__( 'Disable', 'royal-addons-for-elementor' ),
				'return_value' => 'yes',
				'default' 		=> 'no',
			]
		);		
		$element->add_control(
			'royaleh_mode',
			[
				'label'     => esc_html__( 'Mode Based on', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'bodl' => 'Div Level',
					'bouc' => 'Unique Class',
				],
				'default'   => 'bodl',
				'condition' => [
					'royaleh_switch' => 'yes',
				],
			]
		);		
		$element->add_control(
			'royaleh_opt',
			[
				'label'     => esc_html__( 'Select Nested Level', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [					
					'widgets'    => 'Legacy Widgets (.elementor-widget-container)',
					'atomic'     => 'Atomic Elements (.e-widget-container)',
					'children'   => 'Direct Children (> .elementor-element)',
					'1' => 'Nested Level 1',
					'2' => 'Nested Level 2',
					'3' => 'Nested Level 3',
					'4' => 'Nested Level 4',
					'5' => 'Nested Level 5',					
					'6' => 'Nested Level 6',					
					'7' => 'Nested Level 7',					
					'8' => 'Nested Level 8',					
					'9' => 'Nested Level 9',					
					'10' => 'Nested Level 10',
				],
				'default'   => 'widgets',
				'condition' => [
					'royaleh_switch' => 'yes',
					'royaleh_mode' => 'bodl',
				],
			]
		);
		$element->add_control(
			'royaleh_eql_opt',
			[
				'label'     => esc_html__( 'Select Sub Nested Level', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'1' => 'Level 1',
					'2' => 'Level 2',
					'3' => 'Level 3',
					'4' => 'Level 4',
					'5' => 'Level 5',
					'6' => 'Level 6',
					'7' => 'Level 7',
					'8' => 'Level 8',
					'9' => 'Level 9',
					'10' => 'Level 10',
				],
				'default'   => '1',
				'condition' => [
					'royaleh_switch' => 'yes',
					'royaleh_mode' => 'bodl',
				],
			]
		);


		$element->add_control(
			'royaleh_opt_custom',
			[
				'label'       => esc_html__( 'Enter Unique Class', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( '.class-name', 'royal-addons-for-elementor' ),
				'condition'   => [
					'royaleh_switch' => 'yes',
					'royaleh_mode' => 'bouc',
				],
			]
		);
		$element->end_controls_section();
	}
	
	public static function royal_equalheight_render($element) {	
		if ( ! ( $element instanceof \Elementor\Element_Base ) ) return;

		$el_name = $element->get_name();
		$is_atomic = in_array($el_name, ['div-block', 'e-div-block', 'e-flexbox', 'atomic-widget-base']) || (strpos($el_name, 'atomic-') === 0);
		
		$settings = $is_atomic && method_exists($element, 'get_atomic_settings') ? $element->get_atomic_settings() : $element->get_settings_for_display();
		
		if( !empty($settings['royaleh_switch']) && $settings['royaleh_switch'] == 'yes' ){			
			$opt='';
			if(!empty($settings['royaleh_mode']) && $settings['royaleh_mode']=='bodl'){			
				if($settings['royaleh_opt'] == 'widgets'){
					$opt = '.elementor-widget-container';
				} elseif($settings['royaleh_opt'] == 'atomic'){
					$opt = '.e-widget-container, .e-div-block';
				} elseif($settings['royaleh_opt'] == 'children'){
					$opt = '> .elementor-element, > .e-con-inner > .elementor-element';
				} elseif($settings['royaleh_opt'] == 'widgets_l1' && $settings['royaleh_eql_opt'] == '1'){
					$opt = '.elementor-widget-container > div:nth-of-type(1)';
				}
				
				$nested_opt=$eql_opt='';
				$nested_opt= array('2', '3', '4', '5', "6", "7", "8", "9", "10");
				if((in_array($settings['royaleh_opt'], $nested_opt)) && !empty($settings['royaleh_eql_opt'])){				
					$royaleh_opt_add='';
					for( $i=2;$i<=$settings['royaleh_opt'];$i++) {
						$royaleh_opt_add .= ' > div ';
					}
					$opt = '.elementor-widget-container '.$royaleh_opt_add.' > div:nth-of-type('.$settings['royaleh_eql_opt'].')';
					
				}
			}
			
			if((!empty($settings['royaleh_mode']) && $settings['royaleh_mode']=='bouc') && !empty($settings['royaleh_opt_custom']) ){					
					$opt = esc_attr($settings['royaleh_opt_custom']) ;	
			}
			
			if ($opt){							
				$element->add_render_attribute( '_wrapper', 
				array(
					'class' => '',
					'data-royal-equal-height-loadded' => $opt,
				));
			}
		}
		
	}

}
RoyalEqualHeight::init();