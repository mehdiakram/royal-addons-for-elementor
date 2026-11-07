<?php
namespace RoyalAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Background;

if ( ! defined( 'ABSPATH' ) ) {	exit; }

class RoyalHeadingAnimated extends Widget_Base {

	public function get_name() {
		return 'royalheadinganimated';
	}

	
	public function get_title() {
		return __( 'Animated Heading', 'royal-addons-for-elementor' );
	}

	
	public function get_icon() { return 'eicon-animated-headline rtbranding'; }

	
	public function get_style_depends() {
		return ['royalheadinganimated'];
	}

	
	public function get_script_depends() {
		return ['typed', 'vticker', 'royalheadinganimated'];
	}

	
	public function get_keywords() {
		return ['fancy', 'typing', 'headline', 'heading', 'animation', 'tech', 'technologies', 'royal',  'mehdi',  'akram'];
	}

	
	public function get_categories() {
		return array( 'royaltech' );
	}

	
	public function is_reload_preview_required() {
		return true;
	}

	
	protected function register_controls() { // phpcs:ignore PSR2.Methods.MethodDeclaration.Underscore

		$this->start_controls_section(
			'general_section',
			array(
				'label' => __( 'General', 'royal-addons-for-elementor' ),
			)
		);

		$this->add_control(
			'style',
			array(
				'label'        => __( 'Text Style', 'royal-addons-for-elementor' ),
				'type'         => Controls_Manager::SELECT,
				'prefix_class' => 'royal-atext__',
				'options'      => array(
					'switch'    => __( 'Switched', 'royal-addons-for-elementor' ),
					'highlight' => __( 'Highlighted', 'royal-addons-for-elementor' ),
				),
				'default'      => 'switch',
				'render_type'  => 'template',
			)
		);

		$this->add_control(
			'royal_fancy_prefix_text',
			array(
				'label'       => __( 'Before Text', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => array( 'active' => true ),
				'default'     => __( 'This is', 'royal-addons-for-elementor' ),
				'label_block' => true,
			)
		);

		$this->add_control(
			'text',
			array(
				'label'       => __( 'Highlighted Text', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => array( 'active' => true ),
				'separator'   => 'before',
				'default'     => __( 'animated', 'royal-addons-for-elementor' ),
				'label_block' => true,
				'condition'   => array(
					'style' => 'highlight',
				),
			)
		);

		$repeater = new REPEATER();

		$repeater->add_control(
			'royal_text_strings_text_field',
			array(
				'label'       => __( 'Fancy String', 'royal-addons-for-elementor' ),
				'dynamic'     => array( 'active' => true ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
			)
		);

		$this->add_control(
			'royal_fancy_text_strings',
			array(
				'label'       => __( 'Fancy Text', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::REPEATER,
				'default'     => array(
					array(
						'royal_text_strings_text_field' => __( 'Designer', 'royal-addons-for-elementor' ),
					),
					array(
						'royal_text_strings_text_field' => __( 'Developer', 'royal-addons-for-elementor' ),
					),
					array(
						'royal_text_strings_text_field' => __( 'Awesome', 'royal-addons-for-elementor' ),
					),
				),
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ royal_text_strings_text_field }}}',
				'condition'   => array(
					'style' => 'switch',
				),
			)
		);

		$this->add_control(
			'royal_fancy_suffix_text',
			array(
				'label'       => __( 'After Text', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => array( 'active' => true ),
				'default'     => __( 'Text', 'royal-addons-for-elementor' ),
				'label_block' => true,
			)
		);

		$this->add_control(
			'link',
			array(
				'label'     => __( 'Link', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::URL,
				'dynamic'   => array(
					'active' => true,
				),
				'separator' => 'before',
			)
		);

		$this->add_responsive_control(
			'display',
			array(
				'label'       => __( 'Display', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'inline' => __( 'Inline', 'royal-addons-for-elementor' ),
					'block'  => __( 'Block', 'royal-addons-for-elementor' ),
				),
				'default'     => 'inline',
				'selectors'   => array(
					'{{WRAPPER}} .royal-prefix-text, {{WRAPPER}} .royal-suffix-text' => 'display: {{VALUE}}',
				),
				'label_block' => true,
			)
		);

		$this->add_responsive_control(
			'royal_fancy_text_align',
			array(
				'label'     => __( 'Alignment', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					'left'   => array(
						'title' => __( 'Left', 'royal-addons-for-elementor' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center' => array(
						'title' => __( 'Center', 'royal-addons-for-elementor' ),
						'icon'  => 'eicon-text-align-center',
					),
					'right'  => array(
						'title' => __( 'Right', 'royal-addons-for-elementor' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
				'default'   => 'center',
				'toggle'    => false,
				'selectors' => array(
					'{{WRAPPER}} .royal-atext__headline' => 'text-align: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'text_tag',
			array(
				'label'       => __( 'HTML Tag', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'h3',
				'options'     => array(
					'h1'   => 'H1',
					'h2'   => 'H2',
					'h3'   => 'H3',
					'h4'   => 'H4',
					'h5'   => 'H5',
					'h6'   => 'H6',
					'div'  => 'div',
					'span' => 'span',
					'p'    => 'p',
				),
				'label_block' => true,
				'separator'   => 'after',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'royal_fancy_additional_settings',
			array(
				'label' => __( 'Additional Settings', 'royal-addons-for-elementor' ),
			)
		);

		$this->add_control(
			'royal_fancy_text_effect',
			array(
				'label'       => __( 'Effect', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'typing'  => __( 'Typing', 'royal-addons-for-elementor' ),
					'clip'    => __( 'Clip', 'royal-addons-for-elementor' ),
					'slide'   => __( 'Slide Up', 'royal-addons-for-elementor' ),
					'zoomout' => __( 'Zoom Out', 'royal-addons-for-elementor' ),
					'rotate'  => __( 'Rotate', 'royal-addons-for-elementor' ),
					'custom'  => __( 'Custom', 'royal-addons-for-elementor' ),
				),
				'default'     => 'typing',
				'render_type' => 'template',
				'label_block' => true,
				'condition'   => array(
					'style' => 'switch',
				),
			)
		);

		$this->add_control(
			'highlight_effect',
			array(
				'label'       => __( 'Effect', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'shadow'    	=> __( 'Animated Shadow', 'royal-addons-for-elementor' ),
					'pattern'   	=> __( 'Animated Pattern', 'royal-addons-for-elementor' ),
					'fill'      	=> __( 'Animated Fill', 'royal-addons-for-elementor' ),
					'tilt'      	=> __( 'Tilt', 'royal-addons-for-elementor' ),
					'flipx'     	=> __( 'Flip X', 'royal-addons-for-elementor' ),
					'flipy'     	=> __( 'Flip Y', 'royal-addons-for-elementor' ),
					'wave'      	=> __( 'Wave', 'royal-addons-for-elementor' ),
					'pop'       	=> __( 'Pop', 'royal-addons-for-elementor' ),
					'reveal'    	=> __( 'Reveal', 'royal-addons-for-elementor'),
					'scaledown' 	=> __( 'Scale Down', 'royal-addons-for-elementor'),
					'revolvedrop'	=> __( 'Revolve Drop', 'royal-addons-for-elementor'),
					'revolvescale' 	=> __( 'Revolve Scale', 'royal-addons-for-elementor'),
					'balldrop' 		=> __( 'Ball Drop', 'royal-addons-for-elementor'),
					'sideslide'		=> __( 'Side Slide', 'royal-addons-for-elementor'),
					'dropvanish' 	=> __( 'Drop Vanish', 'royal-addons-for-elementor'),
					'twister' 		=> __( 'Twister', 'royal-addons-for-elementor'),
					'leftright' 	=> __( 'Left Right', 'royal-addons-for-elementor'),
					'lines'     	=> __( 'Moving Lines', 'royal-addons-for-elementor'),
					'underline' 	=> __( 'Color Highlight', 'royal-addons-for-elementor' ),
					'shape'     	=> __( 'Draw Shape', 'royal-addons-for-elementor'),
				),
				'default'     => 'shadow',
				'label_block' => true,
				'condition'   => array(
					'style' => 'highlight',
				),
			)
		);

		$this->add_control(
			'pattern_notice',
			array(
				'raw'             => __( 'This effect works only with one word highlighted text.', 'royal-addons-for-elementor' ),
				'type'            => Controls_Manager::RAW_HTML,
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-warning',
				'condition'       => array(
					'style'            => 'highlight',
					'highlight_effect' => 'pattern',

				),
			)
		);

		do_action( 'pa_atext_highlight_controls', $this );

		$this->add_control(
			'custom_animation',
			array(
				'label'       => __( 'Animations', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::ANIMATION,
				'render_type' => 'template',
				'default'     => 'fadeIn',
				'condition'   => array(
					'style'                     => 'switch',
					'royal_fancy_text_effect' => 'custom',
				),
			)
		);

		$this->add_control(
			'royal_fancy_text_type_speed',
			array(
				'label'       => __( 'Type Speed', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::NUMBER,
				'default'     => 30,
				'description' => __( 'Set typing effect speed in milliseconds.', 'royal-addons-for-elementor' ),
				'condition'   => array(
					'style'                     => 'switch',
					'royal_fancy_text_effect' => 'typing',
				),
			)
		);

		$this->add_control(
			'royal_fancy_text_zoom_speed',
			array(
				'label'       => __( 'Animation Speed', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::NUMBER,
				'default'     => 1000,
				'render_type' => 'template',
				'description' => __( 'Set animation speed in milliseconds. Default value is 1000', 'royal-addons-for-elementor' ),
				'condition'   => array(
					'style'                      => 'switch',
					'royal_fancy_text_effect!' => array( 'typing', 'slide' ),
				),
				'selectors'   => array(
					'{{WRAPPER}} .royal-atext__wrapper:not(.royal-atext__typing):not(.royal-atext__slide) .royal-fancy-list-items'   => 'animation-duration: {{VALUE}}ms',
				),
			)
		);

		$this->add_control(
			'royal_fancy_text_zoom_delay',
			array(
				'label'       => __( 'Animation Delay', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::NUMBER,
				'default'     => 2500,
				'description' => __( 'Set animation delay in milliseconds. Default value is 2500', 'royal-addons-for-elementor' ),
				'condition'   => array(
					'style'                      => 'switch',
					'royal_fancy_text_effect!' => array( 'typing', 'slide' ),
				),
			)
		);

		$this->add_control(
			'loop_count',
			array(
				'label'     => __( 'Loop Count', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'condition' => array(
					'style'                      => 'switch',
					'royal_fancy_text_effect!' => array( 'typing', 'slide' ),
				),
			)
		);

		$this->add_control(
			'royal_fancy_text_back_speed',
			array(
				'label'       => __( 'Back Speed', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::NUMBER,
				'default'     => 30,
				'description' => __( 'Set a speed for backspace effect in milliseconds.', 'royal-addons-for-elementor' ),
				'condition'   => array(
					'style'                     => 'switch',
					'royal_fancy_text_effect' => 'typing',
				),
			)
		);

		$this->add_control(
			'royal_fancy_text_start_delay',
			array(
				'label'       => __( 'Start Delay', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::NUMBER,
				'default'     => 30,
				'description' => __( 'If you set it on 5000 milliseconds, the first word/string will appear after 5 seconds.', 'royal-addons-for-elementor' ),
				'condition'   => array(
					'style'                     => 'switch',
					'royal_fancy_text_effect' => 'typing',
				),
			)
		);

		$this->add_control(
			'royal_fancy_text_back_delay',
			array(
				'label'       => __( 'Back Delay', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::NUMBER,
				'default'     => 30,
				'description' => __( 'If you set it on 5000 milliseconds, the word/string will remain visible for 5 seconds before backspace effect.', 'royal-addons-for-elementor' ),
				'condition'   => array(
					'style'                     => 'switch',
					'royal_fancy_text_effect' => 'typing',
				),
			)
		);

		$this->add_control(
			'royal_fancy_text_type_loop',
			array(
				'label'     => __( 'Loop', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'condition' => array(
					'style'                     => 'switch',
					'royal_fancy_text_effect' => 'typing',
				),
			)
		);

		$this->add_control(
			'royal_fancy_text_show_cursor',
			array(
				'label'     => __( 'Show Cursor', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'condition' => array(
					'style'                     => 'switch',
					'royal_fancy_text_effect' => 'typing',
				),
			)
		);

		$this->add_control(
			'royal_fancy_text_cursor_text',
			array(
				'label'     => __( 'Cursor Mark', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'dynamic'   => array( 'active' => true ),
				'default'   => '|',
				'condition' => array(
					'style'                          => 'switch',
					'royal_fancy_text_effect'      => 'typing',
					'royal_fancy_text_show_cursor' => 'yes',
				),
			)
		);

		$this->add_control(
			'royal_slide_up_speed',
			array(
				'label'       => __( 'Animation Speed', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::NUMBER,
				'default'     => 200,
				'description' => __( 'Set a duration value in milliseconds for slide up effect.', 'royal-addons-for-elementor' ),
				'condition'   => array(
					'style'                     => 'switch',
					'royal_fancy_text_effect' => 'slide',
				),
			)
		);

		$this->add_control(
			'royal_slide_up_pause_time',
			array(
				'label'       => __( 'Pause Time', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::NUMBER,
				'default'     => 3000,
				'description' => __( 'How long should the word/string stay visible? Set a value in milliseconds.', 'royal-addons-for-elementor' ),
				'condition'   => array(
					'style'                     => 'switch',
					'royal_fancy_text_effect' => 'slide',
				),
			)
		);

		$this->add_control(
			'royal_slide_up_shown_items',
			array(
				'label'       => __( 'Show Items', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::NUMBER,
				'default'     => 1,
				'description' => __( 'How many items should be visible at a time?', 'royal-addons-for-elementor' ),
				'condition'   => array(
					'style'                     => 'switch',
					'royal_fancy_text_effect' => 'slide',
				),
			)
		);

		$this->add_control(
			'royal_slide_up_hover_pause',
			array(
				'label'        => __( 'Pause on Hover', 'royal-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'prefix_class' => 'royal-atext__paused-',
				'render_type'  => 'template',
				'conditions'   => array(
					'relation' => 'or',
					'terms'    => array(
						array(
							'terms' => array(
								array(
									'name'  => 'style',
									'value' => 'highlight',
								),
								array(
									'name'     => 'highlight_effect',
									'operator' => '!==',
									'value'    => 'underline',
								),
								array(
									'name'     => 'highlight_effect',
									'operator' => '!==',
									'value'    => 'shape',
								),
							),
						),
						array(
							'terms' => array(
								array(
									'name'  => 'style',
									'value' => 'switch',
								),
								array(
									'name'  => 'royal_fancy_text_effect',
									'value' => 'slide',
								),
							),
						),
					),
				),
			)
		);

		$this->add_control(
			'loading_bar',
			array(
				'label'        => __( 'Loading Bar', 'royal-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'prefix_class' => 'royal-atext__loading-',
				'render_type'  => 'template',
				'condition'    => array(
					'style'                      => 'switch',
					'royal_fancy_text_effect!' => 'typing',
				),
			)
		);

		$this->add_responsive_control(
			'royal_fancy_slide_align',
			array(
				'label'     => __( 'Animated Text Alignment', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					'left'   => array(
						'title' => __( 'Left', 'royal-addons-for-elementor' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center' => array(
						'title' => __( 'Center', 'royal-addons-for-elementor' ),
						'icon'  => 'eicon-text-align-center',
					),
					'right'  => array(
						'title' => __( 'Right', 'royal-addons-for-elementor' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
				'default'   => 'center',
				'toggle'    => false,
				'selectors' => array(
					'{{WRAPPER}} .royal-fancy-list-items' => 'text-align: {{VALUE}}',
				),
				'condition' => array(
					'style'                     => 'switch',
					'royal_fancy_text_effect' => 'slide',
				),
			)
		);


		$this->add_control(
			'shape',
			array(
				'label'       => __( 'Shape', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'circle'    => __( 'Circle', 'royal-addons-for-elementor' ),
					'wavy'      => __( 'Wavy Zigzag', 'royal-addons-for-elementor' ),
					'underline' => __( 'Underline', 'royal-addons-for-elementor' ),
					'double'    => __( 'Double Underline', 'royal-addons-for-elementor' ),
					'zigzag'    => __( 'Underline Zigzag', 'royal-addons-for-elementor' ),
					'strike'    => __( 'Strikethrough', 'royal-addons-for-elementor' ),
					'cross'     => __( 'Cross X', 'royal-addons-for-elementor' ),
				),
				'default'     => 'circle',
				'label_block' => true,
				'condition'   => array(
					'style'            => 'highlight',
					'highlight_effect' => 'shape',
				),
			)
		);

		$this->add_control(
			'reveal_notice',
			array(
				'raw'             => __( 'To see this effect, you need to set background color from Style tab.', 'royal-addons-for-elementor' ),
				'type'            => Controls_Manager::RAW_HTML,
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-warning',
				'condition'       => array(
					'style'            => 'highlight',
					'highlight_effect' => 'reveal',

				),
			)
		);

		$this->add_control(
			'lines_notice',
			array(
				'raw'             => __( 'You need to set colors for this effect from style tab.', 'royal-addons-for-elementor' ),
				'type'            => Controls_Manager::RAW_HTML,
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-warning',
				'condition'       => array(
					'style'            => 'highlight',
					'highlight_effect' => 'lines',

				),
			)
		);

		$this->add_responsive_control(
			'royal_image_separator_image_size',
			array(
				'label'      => __( 'Width', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em', '%', 'custom' ),
				'range'      => array(
					'px' => array(
						'min' => 1,
						'max' => 1200,
					),
					'em' => array(
						'min' => 1,
						'max' => 30,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .royal-atext__text' => 'width: {{SIZE}}{{UNIT}} !important',
				),
				'condition'  => array(
					'style'            => 'highlight',
					'highlight_effect' => 'lines',
				),
			)
		);

		$this->add_responsive_control(
			'underline_voffset',
			array(
				'label'     => __( 'Vertical Offset (%)', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => array(
					'size' => 5,
					'unit' => '%',
				),
				'selectors' => array(
					'{{WRAPPER}} .royal-atext__underline .royal-atext__text::after'    => 'bottom: {{SIZE}}{{UNIT}}',
				),
				'condition' => array(
					'style'            => 'highlight',
					'highlight_effect' => 'underline',
				),
			)
		);

		$this->add_responsive_control(
			'lines_svg_height',
			array(
				'label'      => __( 'Height', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em', 'custom' ),
				'range'      => array(
					'px' => array(
						'min' => 1,
						'max' => 200,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .royal-atext__lines .royal-atext__text'    => 'height: {{SIZE}}{{UNIT}} !important',
					'{{WRAPPER}} .royal-atext__underline .royal-atext__text::after'    => 'height: {{SIZE}}{{UNIT}}',
				),
				'condition'  => array(
					'style'            => 'highlight',
					'highlight_effect' => array( 'lines', 'underline' ),
				),
			)
		);

		$this->end_controls_section();



		$this->start_controls_section(
			'animated_text_style_section',
			array(
				'label' => __( 'Animated Text', 'royal-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'fancy_text_typography',
				'label'    => __( 'Headline Typography', 'royal-addons-for-elementor' ),
				'selector' => '{{WRAPPER}} .royal-atext__headline, {{WRAPPER}} .royal-atext__text svg g > text',
				'global'   => array(
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				),
			)
		);

		$this->add_control(
			'royal_fancy_text_color',
			array(
				'label'     => __( 'Color', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => array(
					'default' => Global_Colors::COLOR_PRIMARY,
				),
				'selectors' => array(
					'{{WRAPPER}} .royal-atext__text' => 'color: {{VALUE}};',
					'{{WRAPPER}} .royal-fancy-svg-text .royal-fancy-list-items, {{WRAPPER}} .text' => 'fill : {{VALUE}};',
				),
				'condition' => array(
					'highlight_effect!' => array( 'fill', 'reveal' ),
				),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'      => 'fill_background',
				'types'     => array( 'classic', 'gradient' ),
				'condition' => array(
					'style'            => 'highlight',
					'highlight_effect' => 'fill',
				),
				'selector'  => '{{WRAPPER}} .royal-atext__text',
			)
		);

		$this->add_control(
			'highlight_color',
			array(
				'label'     => __( 'Highlight Color', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .royal-atext__text::after' => 'background-color: {{VALUE}}',
				),
				'condition' => array(
					'style'            => 'highlight',
					'highlight_effect' => 'underline',
				),
			)
		);

		$this->add_control(
			'shadow_first_color',
			array(
				'label'     => __( 'First Color', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => array(
					'default' => Global_Colors::COLOR_PRIMARY,
				),
				'selectors' => array(
					'{{WRAPPER}} .royal-atext__text' => '--pa-atext-fc: {{VALUE}}',
				),
				'condition' => array(
					'style'            => 'highlight',
					'highlight_effect' => array( 'shadow', 'pattern', 'lines' ),
				),
			)
		);

		$this->add_control(
			'shadow_second_color',
			array(
				'label'     => __( 'Second Color', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => array(
					'default' => Global_Colors::COLOR_SECONDARY,
				),
				'selectors' => array(
					'{{WRAPPER}} .royal-atext__text, {{WRAPPER}} .royal-atext__pattern .royal-atext__text::after' => '--pa-atext-sc: {{VALUE}}',
				),
				'condition' => array(
					'style'            => 'highlight',
					'highlight_effect' => array( 'shadow', 'pattern', 'lines' ),
				),
			)
		);

		$this->add_control(
			'shadow_third_color',
			array(
				'label'     => __( 'Third Color', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => array(
					'default' => Global_Colors::COLOR_TEXT,
				),
				'selectors' => array(
					'{{WRAPPER}} .royal-atext__text' => '--pa-atext-tc: {{VALUE}}',
				),
				'condition' => array(
					'style'            => 'highlight',
					'highlight_effect' => array( 'shadow', 'lines' ),
				),
			)
		);

		$this->add_control(
			'shadow_fourth_color',
			array(
				'label'     => __( 'Fourth Color', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => array(
					'default' => Global_Colors::COLOR_ACCENT,
				),
				'selectors' => array(
					'{{WRAPPER}} .royal-atext__text' => '--pa-atext-foc: {{VALUE}}',
				),
				'condition' => array(
					'style'            => 'highlight',
					'highlight_effect' => array( 'shadow', 'lines' ),
				),
			)
		);

		$this->add_control(
			'shadow_fifth_color',
			array(
				'label'     => __( 'Fifth Color', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .royal-atext__text' => '--pa-atext-fic: {{VALUE}}',
				),
				'condition' => array(
					'style'            => 'highlight',
					'highlight_effect' => 'lines',
				),
			)
		);

		$this->add_control(
			'royal_fancy_text_background_color',
			array(
				'label'     => __( 'Background Color', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .royal-atext__text' => 'background-color: {{VALUE}}',
				),
				'condition' => array(
					'highlight_effect!' => 'fill',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			array(
				'name'      => 'text_shadow',
				'selector'  => '{{WRAPPER}} .royal-atext__text',
				'condition' => array(
					'highlight_effect!' => array( 'shadow', 'lines' ),
				),
			)
		);

		$this->add_control(
			'stroke_width',
			array(
				'label'     => __( 'Stroke Width', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => array(
					'{{WRAPPER}} .royal-atext__text' => '-webkit-text-stroke-width: {{SIZE}}px',
					'{{WRAPPER}} .text'                => 'stroke-width: {{SIZE}}',
				),
			)
		);

		$this->add_control(
			'stroke_text_color',
			array(
				'label'     => __( 'Stroke Color', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => array(
					'highlight_effect!' => 'lines',
				),
				'selectors' => array(
					'{{WRAPPER}} .royal-atext__text' => '-webkit-text-stroke-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'animation_speed',
			array(
				'label'     => __( 'Animation Speed (sec)', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min'  => 0,
						'max'  => 15,
						'step' => 0.1,
					),
				),
				'default' => [
					'unit' => 'px',
					'size' => 5,
				],
				'selectors' => array(
					'{{WRAPPER}} .royal-atext__text, {{WRAPPER}} .royal-atext__text::after, {{WRAPPER}} .royal-atext__letter, {{WRAPPER}} .text' => 'animation-duration: {{SIZE}}s',
					'{{WRAPPER}} .royal-atext__shape svg path' => '--pa-animation-duration: {{SIZE}}s',
				),
				// 'condition' => array(
				// 	'style'             => 'highlight',
				// 	'highlight_effect!' => 'underline',
				// ),
			)
		);

		$this->add_control(
			'animation_delay',
			array(
				'label'     => __( 'Animation Delay (sec)', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					's' => array(
						'min' => 0,
						'max' => 15,
					),
				),
				'condition' => array(
					'style'            => 'highlight',
					'highlight_effect' => 'shape',
				),
			)
		);

		$this->add_responsive_control(
			'text_margin',
			array(
				'label'      => __( 'Margin', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .royal-atext__text' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		do_action( 'pa_atext_shape_style', $this );

		$this->start_controls_section(
			'royal_fancy_cursor_text_style_tab',
			array(
				'label'     => __( 'Cursor Text', 'royal-addons-for-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'style'                           => 'switch',
					'royal_fancy_text_cursor_text!' => '',
					'royal_fancy_text_effect'       => 'typing',
				),
			)
		);

		$this->add_control(
			'royal_fancy_text_cursor_color',
			array(
				'label'     => __( 'Color', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => array(
					'default' => Global_Colors::COLOR_PRIMARY,
				),
				'selectors' => array(
					'{{WRAPPER}} .typed-cursor' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'fancy_text_cursor_typography',
				'selector' => '{{WRAPPER}} .typed-cursor',
			)
		);

		$this->add_control(
			'royal_fancy_text_cursor_background',
			array(
				'label'     => __( 'Background Color', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .typed-cursor' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();


		$this->start_controls_section(
			'shape_style_section',
			array(
				'label'     => __( 'Shape', 'royal-addons-for-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'style'            => 'highlight',
					'highlight_effect' => 'shape',
				),
			)
		);

		$this->add_control(
			'shape_color',
			array(
				'label'     => __( 'Color', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => array(
					'default' => Global_Colors::COLOR_ACCENT,
				),
				'selectors' => array(
					'{{WRAPPER}} .royal-atext__shape path' => 'stroke: {{VALUE}}',
				),
			)
		);


		$this->add_control(
			'shape_stroke_width',
			[
				'label' => esc_html__( 'Width', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem', 'custom' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 50,
						'step' => 1,
					],
					'em' => [
						'min' => 1,
						'max' => 2,
					],
					'rem' => [
						'min' => 1,
						'max' => 2,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 5,
				],
				'selectors' => [
					'{{WRAPPER}} .royal-atext__shape path' => 'stroke-width: {{SIZE}}{{UNIT}}',
				],
			]
		);


		$this->add_control(
			'rounded_edges',
			array(
				'label'     => __( 'Rounded Edges', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'selectors' => array(
					'{{WRAPPER}} .royal-atext__shape path' => 'stroke-linecap: round; stroke-linejoin: round',
				),
			)
		);

		$this->end_controls_section();







		$this->start_controls_section(
			'royal_prefix_suffix_style_tab',
			array(
				'label' => __( 'Before & After Text', 'royal-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'royal_prefix_text_color',
			array(
				'label'     => __( 'Before Text Color', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => array(
					'default' => Global_Colors::COLOR_SECONDARY,
				),
				'selectors' => array(
					'{{WRAPPER}} .royal-prefix-text' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'royal_suffix_text_color',
			array(
				'label'     => __( 'After Text Color', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => array(
					'default' => Global_Colors::COLOR_SECONDARY,
				),
				'selectors' => array(
					'{{WRAPPER}} .royal-suffix-text' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'prefix_suffix_typography',
				'selector' => '{{WRAPPER}} .royal-prefix-text, {{WRAPPER}} .royal-suffix-text',
				'global'   => array(
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				),
				'exclude'  => array( 'font_size' ),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'loading_bar_style',
			array(
				'label'     => __( 'Loading Bar', 'royal-addons-for-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'style'                      => 'switch',
					'loading_bar'                => 'yes',
					'royal_fancy_text_effect!' => 'typing',
				),
			)
		);

		$this->add_control(
			'loading_bar_color',
			array(
				'label'     => __( 'Color', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => array(
					'default' => Global_Colors::COLOR_PRIMARY,
				),
				'selectors' => array(
					'{{WRAPPER}}.royal-atext__loading-yes .royal-loading-bar' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'loading_bar_height',
			array(
				'label'     => __( 'Height', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min' => 0,
						'max' => 10,
					),
				),
				'selectors' => array(
					'{{WRAPPER}}.royal-atext__loading-yes .royal-loading-bar' => 'height: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Render Fancy Text widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since  1.0.0
	 * @access protected
	 */
	protected function render() {

		$settings = $this->get_settings_for_display();


		$effect = $settings['royal_fancy_text_effect'];

		$title_tag = $settings['text_tag'];

		$this->add_render_attribute( 'wrapper', 'class', 'royal-atext__wrapper' );

		if ( 'switch' === $settings['style'] ) {

			$loading_bar = 'yes' === $settings['loading_bar'];

			$pause = '';

			if ( 'typing' === $effect ) {

				$show_cursor = ( ! empty( $settings['royal_fancy_text_show_cursor'] ) ) ? true : false;

				$cursor_text = addslashes( $settings['royal_fancy_text_cursor_text'] );

				$loop = ! empty( $settings['royal_fancy_text_type_loop'] ) ? true : false;

				$strings = array();

				foreach ( $settings['royal_fancy_text_strings'] as $item ) {
					if ( ! empty( $item['royal_text_strings_text_field'] ) ) {
						array_push( $strings, str_replace( '\'', '&#39;', $item['royal_text_strings_text_field'] ) );
					}
				}

				$cursor_text    = html_entity_decode( $cursor_text );
				$atext_settings = array(
					'effect'     => $effect,
					'strings'    => $strings,
					'typeSpeed'  => $settings['royal_fancy_text_type_speed'],
					'backSpeed'  => $settings['royal_fancy_text_back_speed'],
					'startDelay' => $settings['royal_fancy_text_start_delay'],
					'backDelay'  => $settings['royal_fancy_text_back_delay'],
					'showCursor' => $show_cursor,
					'cursorChar' => wp_kses_post( $cursor_text ),
					'loop'       => $loop,
				);

			} elseif ( 'slide' === $effect ) {

				$this->add_render_attribute( 'prefix', 'class', 'royal-atext__span-align' );
				$this->add_render_attribute( 'suffix', 'class', 'royal-atext__span-align' );

				$mouse_pause    = 'yes' === $settings['royal_slide_up_hover_pause'] ? true : false;
				$pause          = $mouse_pause ? 'pause' : '';
				$atext_settings = array(
					'effect'     => $effect,
					'speed'      => $settings['royal_slide_up_speed'],
					'showItems'  => $settings['royal_slide_up_shown_items'],
					'pause'      => $settings['royal_slide_up_pause_time'],
					'mousePause' => $mouse_pause,
				);
			} else {

				$atext_settings = array(
					'effect' => $effect,
					'delay'  => $settings['royal_fancy_text_zoom_delay'],
					'count'  => $settings['loop_count']
				);

				if ( 'custom' === $effect ) {
					$atext_settings['animation'] = $settings['custom_animation'];
				} elseif( 'clip' === $effect ) {
                    $atext_settings['speed'] = $settings['royal_fancy_text_zoom_speed'];
                }
			}

			$atext_settings['loading'] = $loading_bar;
			$atext_settings['style']   = $settings['style'];

			$this->add_render_attribute(
				'wrapper',
				array(
					'class'         => array(
						'royal-atext__' . $effect,
						$pause,
					),
					'data-settings' => wp_json_encode( $atext_settings ),
				)
			);

		} else {

			$this->add_render_attribute( 'wrapper', 'class', 'royal-atext' );

			$effect = $settings['highlight_effect'];

			$atext_settings = array(
				'effect' => $effect,
				'style'  => $settings['style'],
				'delay'  => $settings['animation_delay']['size'],
				'duration'  => $settings['animation_speed']['size'],
			);

			// if ( 'shape' === $effect ) {
			// 	$atext_settings['delay']    = $settings['animation_delay']['size'];
			// 	$atext_settings['duration'] = $settings['animation_speed']['size'];
			// }

			$this->add_render_attribute(
				'wrapper',
				array(
					'class'         => array(
						'royal-atext__' . $effect,
					),
					'data-settings' => wp_json_encode( $atext_settings ),
				)
			);

		}

		if ( ! empty( $settings['link']['url'] ) ) {
			$this->add_link_attributes( 'url', $settings['link'] );
		}

		?>
		<div <?php echo wp_kses_post( $this->get_render_attribute_string( 'wrapper' ) ); ?>>

			<<?php echo wp_kses_post( $title_tag ); ?> class="royal-atext__headline">
			<?php if ( ! empty( $settings['royal_fancy_prefix_text'] ) ) : ?>
				<span class="royal-prefix-text">
					<span <?php echo wp_kses_post( $this->get_render_attribute_string( 'prefix' ) ); ?>><?php echo wp_kses( ( $settings['royal_fancy_prefix_text'] ), true ); ?></span>
				</span>
			<?php endif; ?>

			<?php
			if ( 'highlight' === $settings['style'] ) :
				$this->render_highlight_text();
			else :
				$this->render_switch_text();
			endif;
			?>

			<?php if ( ! empty( $settings['royal_fancy_suffix_text'] ) ) : ?>
				<span class="royal-suffix-text">
					<span <?php echo wp_kses_post( $this->get_render_attribute_string( 'suffix' ) ); ?>><?php echo wp_kses( ( $settings['royal_fancy_suffix_text'] ), true ); ?></span>
				</span>
			<?php endif; ?>

			<?php if ( ! empty( $settings['link']['url'] ) ) : ?>
				<a <?php $this->print_render_attribute_string( 'url' ); ?>></a>
			<?php endif; ?>

			</<?php echo wp_kses_post( $title_tag ); ?>>
		</div>
		<?php
	}


	protected function render_switch_text() {

		$settings = $this->get_settings_for_display();

		$effect = $settings['royal_fancy_text_effect'];

		if ( 'typing' === $effect ) :
			?>
			<span id="<?php echo esc_attr( 'royal-atext__text-' . $this->get_id() ); ?>" class="royal-atext__text"></span>
		<?php else : ?>
			<div class="royal-atext__text" style='display: inline-block; text-align: center'>
				<ul class="royal-atext__items-wrapper">
			<?php
			foreach ( $settings['royal_fancy_text_strings'] as $index => $item ) :
				if ( ! empty( $item['royal_text_strings_text_field'] ) ) :
					$this->add_render_attribute( 'text_' . $item['_id'], 'class', 'royal-fancy-list-items' );

					if ( ( 'typing' !== $effect && 'slide' !== $effect ) && 0 !== $index ) {
						$this->add_render_attribute( 'text_' . $item['_id'], 'class', 'royal-fancy-item-hidden' );
					} else {
						$this->add_render_attribute( 'text_' . $item['_id'], 'class', 'royal-fancy-item-visible' );
					}

					?>
						<li <?php echo wp_kses_post( $this->get_render_attribute_string( 'text_' . $item['_id'] ) ); ?>>
							<?php echo wp_kses_post( $item['royal_text_strings_text_field'] ); ?>
						</li>
					<?php
				endif;
			endforeach;
			?>
				</ul>
			</div>
			<?php
		endif;
	}


	protected function render_highlight_text() {

		$settings = $this->get_settings_for_display();

		$this->add_render_attribute(
			'text',
			array(
				'class'     => 'royal-atext__text',
				'data-text' => $settings['text'],
			)
		);

		?>

			<?php if ( 'lines' !== $settings['highlight_effect'] ) : ?>
				<span <?php echo wp_kses_post( $this->get_render_attribute_string( 'text' ) ); ?>>
					<?php echo wp_kses_post( $settings['text'] ); ?>
					<?php if ( 'shape' === $settings['highlight_effect'] ) : ?>
						<?php $this->render_draw_shape(); ?>
					<?php endif; ?>
				</span>

			<?php else : ?>
				<svg class="royal-atext__text">
					<!-- Symbol -->
					<symbol id="s-text">
						<text text-anchor="middle" x="50%" y="50%" dy=".35em">
							<?php echo wp_kses_post( $settings['text'] ); ?>
						</text>
					</symbol>

					<!-- Duplicate symbols -->
					<use xlink:href="#s-text" class="text"></use>
					<use xlink:href="#s-text" class="text"></use>
					<use xlink:href="#s-text" class="text"></use>
					<use xlink:href="#s-text" class="text"></use>
					<use xlink:href="#s-text" class="text"></use>

				</svg>
			<?php endif; ?>

		<?php
	}

	protected function render_draw_shape() {

		$settings = $this->get_settings_for_display();

		$shape = $settings['shape'];

		$shapes_array = array(
			'circle'    => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 150" preserveAspectRatio="none"><path d="M325,18C228.7-8.3,118.5,8.3,78,21C22.4,38.4,4.6,54.6,5.6,77.6c1.4,32.4,52.2,54,142.6,63.7 c66.2,7.1,212.2,7.5,273.5-8.3c64.4-16.6,104.3-57.6,33.8-98.2C386.7-4.9,179.4-1.4,126.3,20.7"></path></svg>',

			'wavy'      => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 150" preserveAspectRatio="none"><path d="M3,146.1c17.1-8.8,33.5-17.8,51.4-17.8c15.6,0,17.1,18.1,30.2,18.1c22.9,0,36-18.6,53.9-18.6 c17.1,0,21.3,18.5,37.5,18.5c21.3,0,31.8-18.6,49-18.6c22.1,0,18.8,18.8,36.8,18.8c18.8,0,37.5-18.6,49-18.6c20.4,0,17.1,19,36.8,19 c22.9,0,36.8-20.6,54.7-18.6c17.7,1.4,7.1,19.5,33.5,18.8c17.1,0,47.2-6.5,61.1-15.6"></path></svg>',

			'underline' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 150" preserveAspectRatio="none"><path d="M7.7,145.6C109,125,299.9,116.2,401,121.3c42.1,2.2,87.6,11.8,87.3,25.7"></path></svg>',

			'double'    => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 150" preserveAspectRatio="none"><path d="M5,125.4c30.5-3.8,137.9-7.6,177.3-7.6c117.2,0,252.2,4.7,312.7,7.6"></path><path d="M26.9,143.8c55.1-6.1,126-6.3,162.2-6.1c46.5,0.2,203.9,3.2,268.9,6.4"></path></svg>',

			'zigzag'    => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 150" preserveAspectRatio="none"><path d="M9.3,127.3c49.3-3,150.7-7.6,199.7-7.4c121.9,0.4,189.9,0.4,282.3,7.2C380.1,129.6,181.2,130.6,70,139 c82.6-2.9,254.2-1,335.9,1.3c-56,1.4-137.2-0.3-197.1,9"></path></svg>',

			'strike'    => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 150" preserveAspectRatio="none"><path d="M3,75h493.5"></path></svg>',

			'cross'     => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 150" preserveAspectRatio="none"><path d="M497.4,23.9C301.6,40,155.9,80.6,4,144.4"></path><path d="M14.1,27.6c204.5,20.3,393.8,74,467.3,111.7"></path></svg>',

		);

		echo $shapes_array[ $shape ]; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}
