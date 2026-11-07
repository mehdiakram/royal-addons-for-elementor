<?php
namespace RoyalAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use RoyalAddons\Elementor\Royal_Helpers;
use RoyalAddons\Traits\ProWidgetTrait;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class RoyalHeadingScrollTrigger extends Widget_Base {
	use ProWidgetTrait;

	public function get_name() {
		return 'royalheadingscrolltrigger';
	}


	public function get_title() {
		return __( 'ScrollTrigger Heading [Pro]', 'royal-addons-for-elementor' );
	}


	public function get_icon() { return 'eicon-heading rtbranding'; }


	public function get_keywords() {
		return [ 'heading', 'header', 'title', 'gsap', 'splitting', 'scrolltrigger', 'scroll', 'trigger', 'animation', 'tech', 'technologies', 'royal',  'mehdi',  'akram', 'pro'];
	}


	public function get_categories() {
		return [ 'royaltech' ];
	}

	
	public function get_style_depends() {
		$styles = [ 'royalheading' ];
		return $styles;
	}

	public function get_script_depends() {
		return ['gsap', 'scrolltrigger', 'splitting', 'royalheadingscrolltrigger'];
	}



	protected function register_controls() {
			$this->rt_heading_options();
			$this->rt_heading_style();
	}


	private function rt_heading_options() {

		$this->start_controls_section(
			'section_content',
			[
				'label' => __( 'Content', 'royal-addons-for-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);


        // Load presets for this widget
        $presets = royal_elementor_presets();
        $widget_presets = isset($presets['royalheadingscrolltrigger']) ? $presets['royalheadingscrolltrigger'] : [];

        $preset_options = ['' => 'Default'];
        foreach ($widget_presets as $key => $preset) {
            $preset_options[$key] = $preset['title'];
        }

   		// Preset selection dropdown
        $this->add_control(
            'preset',
            [
                'label' => __( 'Choose Preset', 'plugin-name' ),
                'type' => Controls_Manager::SELECT,
                'options' => $preset_options,
                'default' => '',
                'label_block' => true,
            ]
        );


		$this->add_control(
			'heading',
			[
				'label' => __( 'Heading', 'royal-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'label_block' => true,
                'default' => 'Royal Technologies',		
				'placeholder' => __( 'Write Sub Heading Here', 'royal-addons-for-elementor' ),
			]
        );


		$this->add_control(
			'html_tag',
			[
				'label' => __( 'HTML Tag', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SELECT,
				'options'   => Royal_Helpers::royal_title_tags(),
				'default' => 'h2',
			]
		);
        

		$this->add_control(
			'gsap_element',
			[
				'label' => esc_html__( 'GSAP Element ', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'char',
				'options' => [
					'char' 		=> esc_html__( 'Character', 'royal-addons-for-elementor' ),
					'word' 		=> esc_html__( 'Word', 'royal-addons-for-elementor' ),
					'all' 		=> esc_html__( 'All', 'royal-addons-for-elementor' ),
				],
			]
		);

		$this->add_control(
			'line_break',
			[
				'label' => esc_html__( 'Line Break', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'normal',
				'options' => [
					'normal' => esc_html__( 'Normal', 'royal-addons-for-elementor' ),
					'nowrap' => esc_html__( 'No Wrap', 'royal-addons-for-elementor' ),
				],
				'selectors' => [
					'{{WRAPPER}} .royaltext' => 'white-space: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'more_options',
			[
				'label' => esc_html__( 'Controls', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);




		$this->add_control(
			'duration',
			[
				'label' => __( 'Duration', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0.00001,
				],
				'range' => [
					'px' => [
						'max' => 20,
						'min' => 0.00001,
						'step' => 0.00001,
					],
				],
			]
		);


		$this->add_control(
			'staggeramount',
			[
				'label' => __( 'Stagger Amount', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 1,
				],
				'range' => [
					'px' => [
						'max' =>100,
						'min' => .1,
						'step' => .1,
					],
				],
			]
		);

		
		$this->add_control(
			'staggereach',
			[
				'label' => __( 'Stagger Each', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => .01,
				],
				'range' => [
					'px' => [
						'max' =>10,
						'min' => .01,
						'step' => .01,
					],
				],
			]
		);

		$this->add_control(
			'staggerfrom',
			[
				'label' => esc_html__( 'Stagger From', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'start',
				'options' => [
					'start' => esc_html__( 'Start', 'royal-addons-for-elementor' ),
					'center' => esc_html__( 'Center', 'royal-addons-for-elementor' ),
					'edges'  => esc_html__( 'Edges', 'royal-addons-for-elementor' ),
					'end' 	=> esc_html__( 'End', 'royal-addons-for-elementor' ),
					'random' => esc_html__( 'Random', 'royal-addons-for-elementor' ),
				],
			]
		);

		$this->add_control(
			'staggergrid',
			[
				'label' => esc_html__( 'Stagger Grid', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'none',
				'options' => [
					'none' => esc_html__( 'Null', 'royal-addons-for-elementor' ),
					'auto' => esc_html__( 'Auto', 'royal-addons-for-elementor' ),
				],
			]
		);


		$this->add_control(
			'staggeraxis',
			[
				'label' => esc_html__( 'Stagger Axis', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'x',
				'options' => [
					'x' => esc_html__( 'X', 'royal-addons-for-elementor' ),
					'y' => esc_html__( 'Y', 'royal-addons-for-elementor' ),
				],
			]
		);


		$this->add_control(
			'staggerease',
			[
				'label' => esc_html__( 'Stagger Ease', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'none',
				'options' => [
					'none' => esc_html__( 'None', 'royal-addons-for-elementor' ),
					'power1.in' => esc_html__( 'Power1 In', 'royal-addons-for-elementor' ),
					'power1.inout' => esc_html__( 'Power1 In Out', 'royal-addons-for-elementor' ),
					'power1.Out' => esc_html__( 'Power1 Out', 'royal-addons-for-elementor' ),
					'power2.in' => esc_html__( 'Power2 In', 'royal-addons-for-elementor' ),
					'power2.inout' => esc_html__( 'Power2 In Out', 'royal-addons-for-elementor' ),
					'power2.Out' => esc_html__( 'Power2 Out', 'royal-addons-for-elementor' ),
					'power3.in' => esc_html__( 'Power3 In', 'royal-addons-for-elementor' ),
					'power3.inout' => esc_html__( 'Power3 In Out', 'royal-addons-for-elementor' ),
					'power3.Out' => esc_html__( 'Power3 Out', 'royal-addons-for-elementor' ),
					'power4.in' => esc_html__( 'Power4 In', 'royal-addons-for-elementor' ),
					'power4.inout' => esc_html__( 'Power4 In Out', 'royal-addons-for-elementor' ),
					'power4.Out' => esc_html__( 'Power4 Out', 'royal-addons-for-elementor' ),
					'bounce.in' => esc_html__( 'Bounce In', 'royal-addons-for-elementor' ),
					'bounce.inout' => esc_html__( 'Bounce In Out', 'royal-addons-for-elementor' ),
					'bounce.Out' => esc_html__( 'Bounce Out', 'royal-addons-for-elementor' ),
					'circ.in' => esc_html__( 'Circ In', 'royal-addons-for-elementor' ),
					'circ.inout' => esc_html__( 'Circ In Out', 'royal-addons-for-elementor' ),
					'circ.Out' => esc_html__( 'Circ Out', 'royal-addons-for-elementor' ),
					'expo.in' => esc_html__( 'Expo In', 'royal-addons-for-elementor' ),
					'expo.inout' => esc_html__( 'Expo In Out', 'royal-addons-for-elementor' ),
					'expo.Out' => esc_html__( 'Expo Out', 'royal-addons-for-elementor' ),
					'sine.in' => esc_html__( 'Sine In', 'royal-addons-for-elementor' ),
					'sine.inout' => esc_html__( 'Sine In Out', 'royal-addons-for-elementor' ),
					'sine.Out' => esc_html__( 'Sine Out', 'royal-addons-for-elementor' ),
				],
			]
		);


		$this->add_control(
			'scrolltriggerpin',
			[
				'label' => esc_html__( 'ScrollTrigger Pin', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'false',
				'options' => [
					'true' => esc_html__( 'True', 'royal-addons-for-elementor' ),
					'false' => esc_html__( 'False', 'royal-addons-for-elementor' ),
				],
			]
		);
		
		$this->add_control(
			'scrolltriggerstart',
			[
				'label' => esc_html__( 'ScrollTrigger Start', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'top center',
				'options' => [
					'center center' => __( 'Center Center', 'royal-addons-for-elementor' ),
					'center left'   => __( 'Center Left', 'royal-addons-for-elementor' ),
					'center right'  => __( 'Center Right', 'royal-addons-for-elementor' ),
					'top center'    => __( 'Top Center', 'royal-addons-for-elementor' ),
					'top left'      => __( 'Top Left', 'royal-addons-for-elementor' ),
					'top right'     => __( 'Top Right', 'royal-addons-for-elementor' ),
					'bottom center' => __( 'Bottom Center', 'royal-addons-for-elementor' ),
					'bottom left'   => __( 'Bottom Left', 'royal-addons-for-elementor' ),
					'bottom right'  => __( 'Bottom Right', 'royal-addons-for-elementor' ),
					'custom'  		=> __( 'Custom', 'royal-addons-for-elementor' ),
				],
			]
		);

		$this->add_control(
			'scrolltriggerstart_custom',
			[
				'label' => __( 'Custom Start', 'royal-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'label_block' => true,
				'condition' => [
					'scrolltriggerstart' => [ 'custom' ],
				],
                'default' => 'top 75%',
			]
        );

		$this->add_control(
			'scrolltriggerend',
			[
				'label' => esc_html__( 'ScrollTrigger End', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'bottom center',
				'options' => [
					'center center' => __( 'Center Center', 'royal-addons-for-elementor' ),
					'center left'   => __( 'Center Left', 'royal-addons-for-elementor' ),
					'center right'  => __( 'Center Right', 'royal-addons-for-elementor' ),
					'top center'    => __( 'Top Center', 'royal-addons-for-elementor' ),
					'top left'      => __( 'Top Left', 'royal-addons-for-elementor' ),
					'top right'     => __( 'Top Right', 'royal-addons-for-elementor' ),
					'bottom center' => __( 'Bottom Center', 'royal-addons-for-elementor' ),
					'bottom left'   => __( 'Bottom Left', 'royal-addons-for-elementor' ),
					'bottom right'  => __( 'Bottom Right', 'royal-addons-for-elementor' ),
					'custom'  		=> __( 'Custom', 'royal-addons-for-elementor' ),
				],
			]
		);

		$this->add_control(
			'scrolltriggerend_custom',
			[
				'label' => __( 'Custom End', 'royal-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'label_block' => true,
				'condition' => [
					'scrolltriggerend' => [ 'custom' ],
				],
                'default' => 'bottom 10%',
			]
        );

		$this->add_control(
			'scrolltriggerscrub',
			[
				'label' => esc_html__( 'Scrolltrigger Scrub', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'true',
				'options' => [
					'true' => esc_html__( 'True', 'royal-addons-for-elementor' ),
					'false' => esc_html__( 'False', 'royal-addons-for-elementor' ),
				],
			]
		);
		
		$this->add_control(
			'scrolltriggerease',
			[
				'label' => esc_html__( 'Scrolltrigger Ease', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'none',
				'options' => [
					'none' => esc_html__( 'None', 'royal-addons-for-elementor' ),
					'power1.in' => esc_html__( 'Power1 In', 'royal-addons-for-elementor' ),
					'power1.inout' => esc_html__( 'Power1 In Out', 'royal-addons-for-elementor' ),
					'power1.Out' => esc_html__( 'Power1 Out', 'royal-addons-for-elementor' ),
					'power2.in' => esc_html__( 'Power2 In', 'royal-addons-for-elementor' ),
					'power2.inout' => esc_html__( 'Power2 In Out', 'royal-addons-for-elementor' ),
					'power2.Out' => esc_html__( 'Power2 Out', 'royal-addons-for-elementor' ),
					'power3.in' => esc_html__( 'Power3 In', 'royal-addons-for-elementor' ),
					'power3.inout' => esc_html__( 'Power3 In Out', 'royal-addons-for-elementor' ),
					'power3.Out' => esc_html__( 'Power3 Out', 'royal-addons-for-elementor' ),
					'power4.in' => esc_html__( 'Power4 In', 'royal-addons-for-elementor' ),
					'power4.inout' => esc_html__( 'Power4 In Out', 'royal-addons-for-elementor' ),
					'power4.Out' => esc_html__( 'Power4 Out', 'royal-addons-for-elementor' ),
					'bounce.in' => esc_html__( 'Bounce In', 'royal-addons-for-elementor' ),
					'bounce.inout' => esc_html__( 'Bounce In Out', 'royal-addons-for-elementor' ),
					'bounce.Out' => esc_html__( 'Bounce Out', 'royal-addons-for-elementor' ),
					'circ.in' => esc_html__( 'Circ In', 'royal-addons-for-elementor' ),
					'circ.inout' => esc_html__( 'Circ In Out', 'royal-addons-for-elementor' ),
					'circ.Out' => esc_html__( 'Circ Out', 'royal-addons-for-elementor' ),
					'expo.in' => esc_html__( 'Expo In', 'royal-addons-for-elementor' ),
					'expo.inout' => esc_html__( 'Expo In Out', 'royal-addons-for-elementor' ),
					'expo.Out' => esc_html__( 'Expo Out', 'royal-addons-for-elementor' ),
					'sine.in' => esc_html__( 'Sine In', 'royal-addons-for-elementor' ),
					'sine.inout' => esc_html__( 'Sine In Out', 'royal-addons-for-elementor' ),
					'sine.Out' => esc_html__( 'Sine Out', 'royal-addons-for-elementor' ),
				],
			]
		);

		$this->add_control(
			'scrolltriggermarkers',
			[
				'label' => esc_html__( 'ScrollTrigger Markers', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'false',
				'options' => [
					'true' => esc_html__( 'True', 'royal-addons-for-elementor' ),
					'false' => esc_html__( 'False', 'royal-addons-for-elementor' ),
				],
			]
		);

		$this->start_controls_tabs(
			'gsap_methods_tabs'
		);
		
		$this->start_controls_tab(
			'gsap_method_from',
			[
				'label' => esc_html__( 'From', 'royal-addons-for-elementor' ),
			]
		);
		
		$this->add_control(
			'from_opacity',
			[
				'label' => __( 'Opacity', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'default' => [
					'size' => 0.25,
				],
				'range' => [
					'px' => [
						'min' => 0.01,
						'max' => 1,
						'step' => 0.01,
					],
				],
			]
		);

		$this->add_control(
			'from_color',
			[
				'label' => __( 'Color', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
			]
        );

		$this->add_control(
			'from_filter_blur',
			[
				'label' => __( 'Filter Blur', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0,
				],
				'range' => [
					'px' => [
						'max' => 100,
						'min' => 0,
						'step' => 1,
					],
				],
			]
		);

		$this->add_control(
			'from_scalex',
			[
				'label' => __( 'Scale X', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 1,
				],
				'range' => [
					'px' => [
						'max' => 50,
						'min' => -50,
						'step' => .1,
					],
				],
			]
		);

		$this->add_control(
			'from_scaley',
			[
				'label' => __( 'Scale Y', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 1,
				],
				'range' => [
					'px' => [
						'max' => 50,
						'min' => -50,
						'step' => .1,
					],
				],
			]
		);

		$this->add_control(
			'from_xpercent',
			[
				'label' => __( 'X Percent', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0,
				],
				'range' => [
					'px' => [
						'max' => 100,
						'min' => -100,
						'step' => 1,
					],
				],
			]
		);

		$this->add_control(
			'from_ypercent',
			[
				'label' => __( 'Y Percent', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0,
				],
				'range' => [
					'px' => [
						'max' => 100,
						'min' => -100,
						'step' => 1,
					],
				],
			]
		);

		$this->add_control(
			'from_xposition',
			[
				'label' => __( 'X Position', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0,
				],
				'range' => [
					'px' => [
						'max' => 1000,
						'min' => -1000,
						'step' => 1,
					],
				],
			]
		);

		$this->add_control(
			'from_yposition',
			[
				'label' => __( 'Y Position', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0,
				],
				'range' => [
					'px' => [
						'max' => 1000,
						'min' => -1000,
						'step' => 1,
					],
				],
			]
		);

		$this->add_control(
			'from_rotatex',
			[
				'label' => __( 'Rotate X', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0,
				],
				'range' => [
					'px' => [
						'max' => 360,
						'min' => -360,
						'step' => 1,
					],
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'gsap_method_to',
			[
				'label' => esc_html__( 'To', 'royal-addons-for-elementor' ),
			]
		);
		
		$this->add_control(
			'to_opacity',
			[
				'label' => __( 'Opacity', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 1,
				],
				'range' => [
					'px' => [
						'max' => 1,
						'min' => 0.10,
						'step' => 0.01,
					],
				],
			]
		);

		$this->add_control(
			'to_color',
			[
				'label' => __( 'Color', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
			]
        );

		$this->add_control(
			'to_filter_blur',
			[
				'label' => __( 'Filter Blur', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0,
				],
				'range' => [
					'px' => [
						'max' => 100,
						'min' => 0,
						'step' => 1,
					],
				],
			]
		);

		$this->add_control(
			'to_scalex',
			[
				'label' => __( 'Scale X', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 1,
				],
				'range' => [
					'px' => [
						'max' => 50,
						'min' => -50,
						'step' => .1,
					],
				],
			]
		);

		$this->add_control(
			'to_scaley',
			[
				'label' => __( 'Scale Y', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 1,
				],
				'range' => [
					'px' => [
						'max' => 50,
						'min' => -50,
						'step' => .1,
					],
				],
			]
		);

		$this->add_control(
			'to_xpercent',
			[
				'label' => __( ' X Percent', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0,
				],
				'range' => [
					'px' => [
						'max' => 100,
						'min' => -100,
						'step' => 1,
					],
				],
			]
		);

		$this->add_control(
			'to_ypercent',
			[
				'label' => __( 'Y Percent', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0,
				],
				'range' => [
					'px' => [
						'max' => 100,
						'min' => -100,
						'step' => 1,
					],
				],
			]
		);

		$this->add_control(
			'to_xposition',
			[
				'label' => __( 'X Position', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0,
				],
				'range' => [
					'px' => [
						'max' => 1000,
						'min' => -1000,
						'step' => 1,
					],
				],
			]
		);

		$this->add_control(
			'to_yposition',
			[
				'label' => __( 'Y Position', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0,
				],
				'range' => [
					'px' => [
						'max' => 1000,
						'min' => -1000,
						'step' => 1,
					],
				],
			]
		);

		$this->add_control(
			'to_rotatex',
			[
				'label' => __( 'Rotate X', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0,
				],
				'range' => [
					'px' => [
						'max' => 360,
						'min' => -360,
						'step' => 1,
					],
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

        $this->end_controls_section();

	}


	private function rt_heading_style() {
		$this->start_controls_section(
			'section_style',
			[
				'label' => __( 'Heading Style', 'royal-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'heading_typography',
				'label' => __( 'Typography', 'royal-addons-for-elementor' ),
				'separator'=> 'after',			
				'global' => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_PRIMARY,
				],
				'selector' => '{{WRAPPER}} .royalheadingscrolltrigger .royaltext',				
			]
        );

		$this->add_control(
			'heading_color',
			[
				'label' => __( 'Color', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#000000',
				'selectors' => [
					'{{WRAPPER}} .royalheadingscrolltrigger .royaltext' => 'color: {{VALUE}}',
				],
			]
        );

		$this->add_responsive_control(
			'heading_align',
			[
				'label' => __( 'Alignment', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'royal-addons-for-elementor' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'royal-addons-for-elementor' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'royal-addons-for-elementor' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'separator'=> 'before',				
				'default' => 'center',
				'selectors' => [
					'{{WRAPPER}} .royalheadingscrolltrigger .royaltext' => 'text-align: {{VALUE}};',
				],
			]
		);		

		$this->end_controls_section();
	}



	protected function render() {
		if ( $this->maybe_render_license_notice() ) {
			return;
		}
		
        $settings = $this->get_settings_for_display();

        $presets = royal_elementor_presets();
        $widget_presets = isset($presets['royalheadingscrolltrigger']) ? $presets['royalheadingscrolltrigger'] : [];

        // Apply preset settings if a preset is selected
        if (!empty($settings['preset']) && isset($widget_presets[$settings['preset']])) {
            $preset_settings = $widget_presets[$settings['preset']]['settings'];
            $settings = array_merge($settings, $preset_settings);
        }

		$id             	= $this->get_id();
        $triggerid      	= 'royalheadingscrolltrigger'.$id;
		$heading 			= $settings['heading'];
		$html_tag 			= $settings['html_tag'];
		$gsap_element 		= $settings['gsap_element'];

        $from_opacity   	= $settings['from_opacity']['size'];
        $to_opacity    		= $settings['to_opacity']['size'];
		$from_color    		= $settings['from_color'];
        $to_color    		= $settings['to_color'];
		$from_filter_blur   = $settings['from_filter_blur']['size'];
        $to_filter_blur     = $settings['to_filter_blur']['size'];
        $from_scalex     	= $settings['from_scalex']['size'];
        $to_scalex     		= $settings['to_scalex']['size'];
		$from_scaley     	= $settings['from_scaley']['size'];
        $to_scaley     		= $settings['to_scaley']['size'];
        $from_xpercent     	= $settings['from_xpercent']['size'];
        $to_xpercent     	= $settings['to_xpercent']['size'];
		$from_ypercent     	= $settings['from_ypercent']['size'];
        $to_ypercent     	= $settings['to_ypercent']['size'];
        $from_xposition     = $settings['from_xposition']['size'];
        $to_xposition     	= $settings['to_xposition']['size'];
        $from_yposition    	= $settings['from_yposition']['size'];
        $to_yposition     	= $settings['to_yposition']['size'];
        $from_rotatex     	= $settings['from_rotatex']['size'];
        $to_rotatex     	= $settings['to_rotatex']['size'];


        $duration       	= $settings['duration']['size'];
        $staggeramount  	= $settings['staggeramount']['size'];
        $staggereach  		= $settings['staggereach']['size'];
		$staggerfrom  		= $settings['staggerfrom'];
        $staggergrid  		= $settings['staggergrid'];
        $staggeraxis  		= $settings['staggeraxis'];
        $staggerease  		= $settings['staggerease'];

        $scrolltriggerpin  	= $settings['scrolltriggerpin'];
        
		if ($settings['scrolltriggerstart'] == 'custom') {
			$scrolltriggerstart	= $settings['scrolltriggerstart_custom'];
		} else {
			$scrolltriggerstart	= $settings['scrolltriggerstart'];
		}

		if ($settings['scrolltriggerend'] == 'custom') {
			$scrolltriggerend	= $settings['scrolltriggerend_custom'];
		} else {
			$scrolltriggerend  	= $settings['scrolltriggerend'];
		}

        $scrolltriggerscrub	= $settings['scrolltriggerscrub'];
        $scrolltriggerease	= $settings['scrolltriggerease'];
        $scrolltriggermarkers	= $settings['scrolltriggermarkers'];

        $this->add_render_attribute(
            'options',
            [
                'id'             	    	=> $triggerid,
                'data-gsap_element'			=> $gsap_element,

                'data-from_opacity'			=> $from_opacity,
                'data-to_opacity'			=> $to_opacity,
                'data-from_color'			=> $from_color,
                'data-to_color'				=> $to_color,
                'data-from_filter_blur'		=> $from_filter_blur,
                'data-to_filter_blur'		=> $to_filter_blur,
                'data-from_scalex'			=> $from_scalex,
                'data-to_scalex'			=> $to_scalex,
				'data-from_scaley'			=> $from_scaley,
                'data-to_scaley'			=> $to_scaley,
                'data-from_xpercent'		=> $from_xpercent,
                'data-to_xpercent'			=> $to_xpercent,
				'data-from_ypercent'		=> $from_ypercent,
                'data-to_ypercent'			=> $to_ypercent,
                'data-from_xposition'		=> $from_xposition,
                'data-to_xposition'			=> $to_xposition,
                'data-from_yposition'		=> $from_yposition,
                'data-to_yposition'			=> $to_yposition,
                'data-from_rotatex'			=> $from_rotatex,
                'data-to_rotatex'			=> $to_rotatex,


                'data-duration'				=> $duration,
                'data-staggeramount'		=> $staggeramount,
                'data-staggerfrom'			=> $staggerfrom,
                'data-staggereach'			=> $staggereach,
                'data-staggergrid'			=> $staggergrid,
                'data-staggeraxis'			=> $staggeraxis,
                'data-staggerease'			=> $staggerease,
                'data-scrolltriggerpin'		=> $scrolltriggerpin,
                'data-scrolltriggerstart'	=> $scrolltriggerstart,
                'data-scrolltriggerend'		=> $scrolltriggerend,
                'data-scrolltriggerscrub'	=> $scrolltriggerscrub,
                'data-scrolltriggerease'	=> $scrolltriggerease,
                'data-scrolltriggermarkers'	=> $scrolltriggermarkers,
            ]
        );	
		?>
		<div class="royalheadingscrolltrigger" <?php echo $this->get_render_attribute_string( 'options' ) ?>><<?php echo $html_tag; ?> class="royaltext"><?php echo $heading; ?></<?php echo $html_tag; ?>></div>
	
	<?php
	}

}