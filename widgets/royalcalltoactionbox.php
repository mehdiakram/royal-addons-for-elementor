<?php
namespace RoyalAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Control_Media;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
if (!defined('ABSPATH')) exit; // Exit if accessed directly


class RoyalCallToActionBox extends Widget_Base {

	public function get_name() {
		return 'royalcalltoactionbox';
	}

	public function get_title() {
		return __( 'Call To Action Box', 'royal-addons-for-elementor' );
	}


	public function get_icon() { return 'eicon-call-to-action rtbranding'; }


	public function get_keywords() {
		return ['call', 'action', 'call to action', 'cta', 'tech', 'technologies', 'royal',  'mehdi',  'akram'];
	}

	  
	public function get_categories() {
		return [ 'royaltech' ];
	}


	public function get_style_depends() {
		$styles = [ 'royalcalltoactionbox' ];
		return $styles;
	}

	
	public function get_script_depends() {
		$scripts = ['royalcalltoactionbox'];
		return $scripts;
	}	


	public static function get_button_sizes() {
		return [
			'xs' => __( 'Extra Small', 'royal-addons-for-elementor' ),
			'sm' => __( 'Small', 'royal-addons-for-elementor' ),
			'md' => __( 'Medium', 'royal-addons-for-elementor' ),
			'lg' => __( 'Large', 'royal-addons-for-elementor' ),
			'xl' => __( 'Extra Large', 'royal-addons-for-elementor' ),
		];
	}

	
	protected function register_controls() {

		$this->start_controls_section(
			'section_icon',
			[
				'label' => __( 'Box Animate Element', 'royal-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'box_blurb_style',
			[
				'label' => __( 'Blurb Element', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options' => [
					'none' => [
						'title' => __( 'None', 'royal-addons-for-elementor' ),
						'icon' => 'fa fa-ban',
					],
					'icon' => [
						'title' => __( 'Icon', 'royal-addons-for-elementor' ),
						'icon' => 'fa fa-star',
					],
					'image' => [
						'title' => __( 'Image', 'royal-addons-for-elementor' ),
						'icon' => 'fa fa-picture-o',
					],
				],
				'separator' => 'before',
				'default' => 'none',
			]
		);

		$this->add_control(
			'icon',
			[
				'label' => __( 'Choose Icon', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::ICON,
				'default' => 'fa fa-star',
				'condition' => [
					'box_blurb_style' => 'icon',
				],
			]
		);





		$this->add_control(
			'view',
			[
				'label' => __( 'View', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'default' => __( 'Default', 'royal-addons-for-elementor' ),
					'stacked' => __( 'Stacked', 'royal-addons-for-elementor' ),
					'framed' => __( 'Framed', 'royal-addons-for-elementor' ),
				],
				'default' => 'default',
				'prefix_class' => 'elementor-view-',
				'condition' => [
					'box_blurb_style' => 'icon',
					'icon!' => '',
				],
			]
		);

		$this->add_control(
			'shape',
			[
				'label' => __( 'Shape', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'circle' => __( 'Circle', 'royal-addons-for-elementor' ),
					'square' => __( 'Square', 'royal-addons-for-elementor' ),
				],
				'default' => 'circle',
				'condition' => [
					'box_blurb_style' => 'icon',
					'view!' => 'default',
					'icon!' => '',
				],
				'prefix_class' => 'elementor-shape-',
			]
		);

		$this->add_control(
			'image',
			[
				'label' => __( 'Choose Image', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::MEDIA,
				'dynamic' => [
					'active' => true,
				],
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'condition' => [
					'box_blurb_style' => 'image',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'thumbnail', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `thumbnail_size` and `thumbnail_custom_dimension`.
				'default' => 'full',
				'separator' => 'none',
				'condition' => [
					'box_blurb_style' => 'image',
				],
			]
		);





		$this->add_control(
			'divider',
			[
				'label' => __( 'Use Divider line', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'royal-addons-for-elementor' ),
				'label_off' => __( 'Off', 'royal-addons-for-elementor' ),
				'separator' => 'before',
			]
		);

		$this->add_control(
			'divider_placement',
			[
				'label' => __( 'Placement', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'before' => 'Before Title',
					'after' => 'After Title',
				],
				'default' => 'after',
				'condition' => [
					'divider' => 'yes',
				],
			]
		);

		$this->add_control(
			'divider_style',
			[
				'label' => __( 'Style', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'solid' => __( 'Solid', 'royal-addons-for-elementor' ),
					'double' => __( 'Double', 'royal-addons-for-elementor' ),
					'dotted' => __( 'Dotted', 'royal-addons-for-elementor' ),
					'dashed' => __( 'Dashed', 'royal-addons-for-elementor' ),
				],
				'default' => 'solid',
				'selectors' => [
					'{{WRAPPER}} .elementor-divider-separator' => 'border-top-style: {{VALUE}};',
				],
				'condition' => [
					'divider' => 'yes',
				],
			]
		);

		$this->add_control(
			'divider_weight',
			[
				'label' => __( 'Weight', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 1,
				],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 10,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-divider-separator' => 'border-top-width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'divider' => 'yes',
				],
			]
		);

		$this->add_control(
			'divider_color',
			[
				'label' => __( 'Color', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .elementor-divider-separator' => 'border-top-color: {{VALUE}};',
				],
				'condition' => [
					'divider' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'divider_width',
			[
				'label' => __( 'Width', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ '%', 'px' ],
				'range' => [
					'px' => [
						'max' => 1000,
					],
				],
				'default' => [
					'size' => 20,
					'unit' => '%',
				],
				'tablet_default' => [
					'unit' => '%',
				],
				'mobile_default' => [
					'unit' => '%',
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-divider-separator' => 'width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'divider' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'divider_gap',
			[
				'label' => __( 'Gap', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 15,
				],
				'range' => [
					'px' => [
						'min' => 2,
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-divider' => 'padding-top: {{SIZE}}{{UNIT}}; padding-bottom: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'divider' => 'yes',
				],
				'separator' => 'after',
			]
		);

		$this->add_control(
			'title_text',
			[
				'label' => __( 'Title, Subtitle & Description', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'default' => __( 'This is the heading', 'royal-addons-for-elementor' ),
				'placeholder' => __( 'Enter your title', 'royal-addons-for-elementor' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'subtitle_text',
			[
				'label' => __( 'Sub Title', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'default' => __( 'This is the subtitle', 'royal-addons-for-elementor' ),
				'placeholder' => __( 'Enter your subtitle', 'royal-addons-for-elementor' ),
				'label_block' => true,
				'separator' => 'none',
			]
		);

		$this->add_control(
			'subtitle_text_placement',
			[
				'label' => __( 'Subtitle Placement', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'before' => 'Before Title',
					'after' => 'After Title',
				],
				'default' => 'after',
				'condition' => [
					'subtitle_text!' => '',
				],
				'separator' => 'none',
			]
		);

		$this->add_control(
			'description_text',
			[
				'label' => __('', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::TEXTAREA,
				'dynamic' => [
					'active' => true,
				],
				'default' => __( 'Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'royal-addons-for-elementor' ),
				'placeholder' => __( 'Enter your description', 'royal-addons-for-elementor' ),
				'rows' => 10,
				'separator' => 'none',
				'show_label' => false,
			]
		);

		$this->add_control(
			'button_one_text',
			[
				'label' => __( 'Button #1 Text', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'default' => __( 'Click me', 'royal-addons-for-elementor' ),
				'placeholder' => __( 'Click me', 'royal-addons-for-elementor' ),
				'separator' => 'before',
			]
		);

		$this->add_control(
			'button_two_text',
			[
				'label' => __( 'Button #2 Text', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'default' => __( 'Click me', 'royal-addons-for-elementor' ),
				'placeholder' => __( 'Click me', 'royal-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'button_separator',
			[
				'label' => esc_html__( 'Use Separator Text', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'button_separator_text',
			[
				'label' => __( 'Separator Text', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'or', 'royal-addons-for-elementor' ),
				'placeholder' => __( 'or', 'royal-addons-for-elementor' ),
				'condition' => [
					'button_separator' => 'yes',
				],
			]
		);

		$this->add_control(
			'link',
			[
				'label' => __( 'Link', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::URL,
				'dynamic' => [
					'active' => true,
				],
				'placeholder' => __( 'https://your-link.com', 'royal-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'link_to_element',
			[
				'label' => __( 'Link to', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'default' => 'Title & Icon',
					'entire_div' => 'Entire DIV as a link',
				],
				'default' => 'default',
			]
		);

		$this->add_control(
			'title_size',
			[
				'label' => __( 'Title HTML Tag', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'h1' => 'H1',
					'h2' => 'H2',
					'h3' => 'H3',
					'h4' => 'H4',
					'h5' => 'H5',
					'h6' => 'H6',
					'div' => 'div',
					'span' => 'span',
					'p' => 'p',
				],
				'default' => 'h3',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_button_setting',
			[
				'label' => __( 'Button Settings', 'royal-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'button_spacing',
			[
				'label' => __( 'Button Spacing', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 5,
				],
				'range' => [
					'px' => [
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .royalctabutton-one' => 'margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .royalctabutton-two' => 'margin-left: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'button_two_text!' => '',
				],
				'separator' => 'after',
			]
		);

		$this->add_control(
			'button_one_label',
			[
				'label' => __( 'Button #1', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'button_one_text!' => '',
				],
			]
		);

		$this->add_control(
			'button_one_type',
			[
				'label' => __( 'Type', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __( 'Default', 'royal-addons-for-elementor' ),
					'info' => __( 'Info', 'royal-addons-for-elementor' ),
					'success' => __( 'Success', 'royal-addons-for-elementor' ),
					'warning' => __( 'Warning', 'royal-addons-for-elementor' ),
					'danger' => __( 'Danger', 'royal-addons-for-elementor' ),
				],
				'condition' => [
					'button_one_text!' => '',
				],
			]
		);

		$this->add_control(
			'button_one_link',
			[
				'label' => __( 'Link', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::URL,
				'dynamic' => [
					'active' => true,
				],
				'placeholder' => __( 'https://your-link.com', 'royal-addons-for-elementor' ),
				'default' => [
					'url' => '#',
				],
				'condition' => [
					'button_one_text!' => '',
				],
			]
		);


		$this->add_control(
			'button_one_size',
			[
				'label' => __( 'Size', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'sm',
				'options' => self::get_button_sizes(),
				'condition' => [
					'button_one_text!' => '',
				],
			]
		);

		$this->add_control(
			'button_one_icon',
			[
				'label' => __( 'Icon', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::ICON,
				'label_block' => true,
				'default' => '',
				'condition' => [
					'button_one_text!' => '',
				],
			]
		);

		$this->add_control(
			'button_one_icon_align',
			[
				'label' => __( 'Icon Position', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'left',
				'options' => [
					'left' => __( 'Before', 'royal-addons-for-elementor' ),
					'right' => __( 'After', 'royal-addons-for-elementor' ),
				],
				'condition' => [
					'button_one_icon!' => '',
				],
			]
		);

		$this->add_control(
			'button_one_icon_indent',
			[
				'label' => __( 'Icon Spacing', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 50,
					],
				],
				'condition' => [
					'button_one_icon!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .royalctabutton .elementor-align-icon-right' => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .royalctabutton .elementor-align-icon-left' => 'margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'button_one_view',
			[
				'label' => __( 'View', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::HIDDEN,
				'default' => 'traditional',
				'condition' => [
					'button_one_text!' => '',
				],
			]
		);

		$this->add_control(
			'button_two_label',
			[
				'label' => __( 'Button #2', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'button_two_text!' => '',
				],
			]
		);

		$this->add_control(
			'button_two_type',
			[
				'label' => __( 'Type', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __( 'Default', 'royal-addons-for-elementor' ),
					'info' => __( 'Info', 'royal-addons-for-elementor' ),
					'success' => __( 'Success', 'royal-addons-for-elementor' ),
					'warning' => __( 'Warning', 'royal-addons-for-elementor' ),
					'danger' => __( 'Danger', 'royal-addons-for-elementor' ),
				],
				'condition' => [
					'button_two_text!' => '',
				],
			]
		);

		$this->add_control(
			'button_two_link',
			[
				'label' => __( 'Link', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::URL,
				'dynamic' => [
					'active' => true,
				],
				'placeholder' => __( 'https://your-link.com', 'royal-addons-for-elementor' ),
				'default' => [
					'url' => '#',
				],
				'condition' => [
					'button_two_text!' => '',
				],
			]
		);


		$this->add_control(
			'button_two_size',
			[
				'label' => __( 'Size', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'sm',
				'options' => self::get_button_sizes(),
				'condition' => [
					'button_two_text!' => '',
				],
			]
		);

		$this->add_control(
			'button_two_icon',
			[
				'label' => __( 'Icon', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::ICON,
				'label_block' => true,
				'default' => '',
				'condition' => [
					'button_two_text!' => '',
				],
			]
		);

		$this->add_control(
			'button_two_icon_align',
			[
				'label' => __( 'Icon Position', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'left',
				'options' => [
					'left' => __( 'Before', 'royal-addons-for-elementor' ),
					'right' => __( 'After', 'royal-addons-for-elementor' ),
				],
				'condition' => [
					'button_two_icon!' => '',
				],
			]
		);

		$this->add_control(
			'button_two_icon_indent',
			[
				'label' => __( 'Icon Spacing', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 50,
					],
				],
				'condition' => [
					'button_two_icon!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .royalctabutton-two .elementor-align-icon-right' => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .royalctabutton-two .elementor-align-icon-left' => 'margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'button_two_view',
			[
				'label' => __( 'View', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::HIDDEN,
				'default' => 'traditional',
				'condition' => [
					'button_two_text!' => '',
				],
			]
		);

		$this->end_controls_section();

		//Button Separator
		$this->start_controls_section(
			'section_button_separator',
			[
				'label' => __( 'Button Separator', 'royal-addons-for-elementor' ),
				'condition' => [
					'button_separator' => 'yes',
				],
			]
		);

		$this->add_control(
			'button_separator_space',
			[
				'label' => __( 'Spacing in Between', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .royalctabox-btn-separator' => 'margin-left: {{SIZE}}{{UNIT}}; margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		//Hover Effects
		$this->start_controls_section(
			'section_hover_effect',
			[
				'label' => __( 'Content Hover Animation', 'royal-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'hover_content_animation',
			[
				'label' => __( 'Content Animation', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SELECT,
				'groups' => [
					[
						'label' => __( 'None', 'royal-addons-for-elementor' ),
						'options' => [
							'' => __( 'None', 'royal-addons-for-elementor' ),
						],
					],
					[
						'label' => __( 'Fade', 'royal-addons-for-elementor' ),
						'options' => [							
							'fade-in' => 'Fade In',
							'fade-in-up' => 'Fade In Up',
							'fade-in-down' => 'Fade In Down',
							'fade-in-left' => 'Fade In Left',
							'fade-in-right' => 'Fade In Right',
						],
					],
					[
						'label' => __( 'Slide', 'royal-addons-for-elementor' ),
						'options' => [
							'slide-up' => 'Slide Up',
							'slide-down' => 'Slide Down',
							'slide-left' => 'Slide Left',
							'slide-right' => 'Slide Right',
							'slide-top-left' => 'Slide Top Left',
							'slide-top-right' => 'Slide Top Right',
							'slide-bottom-left' => 'Slide Bottom Left',
							'slide-bottom-right' => 'Slide Bottom Right',
						],
					],
				],
				'default' => '',
			]
		);

		$this->add_control(
			'hover_content_sequenced_animation',
			[
				'label' => __( 'Sequenced Animation', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'royal-addons-for-elementor' ),
				'label_off' => __( 'Off', 'royal-addons-for-elementor' ),
				'condition' => [
					'hover_content_animation!' => '',
				],
			]
		);

		$this->add_control(
			'hover_content_transition_speed',
			[
				'label' => __( 'Transition Speed (s)', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .royalctabox.royalctabox-hover-sequenced-off .royalctabox-content-wrapper' => '-webkit-transition: {{SIZE}}s; -o-transition: {{SIZE}}s; transition: {{SIZE}}s;',

				],
				'default' => [
					'size' => 0.35,
				],
				'range' => [
					'px' => [
						'min' => 0.1,
						'max' => 5,
					],
				],
				'condition' => [
					'hover_content_animation!' => '',
					'hover_content_sequenced_animation' => '',
				],
			]
		);

		$this->add_control(
			'hover_content_sequenced_transition_speed',
			[
				'label' => __( 'Transition Speed (s)', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .royalctabox.royalctabox-hover-sequenced-on .royalctabox-hover-sequenced-item' => '-webkit-transition-duration: {{SIZE}}s; -o-transition-duration: {{SIZE}}s; transition-duration: {{SIZE}}s;',
				],
				'default' => [
					'size' => 0.35,
				],
				'range' => [
					'px' => [
						'min' => 0.1,
						'max' => 5,
					],
				],
				'condition' => [
					'hover_content_animation!' => '',
					'hover_content_sequenced_animation' => 'yes',
				],
			]
		);

		//Overlay Text
		$this->add_control(
			'eb_overlay_text',
			[
				'label' => __( 'Show Overylay Text', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'royal-addons-for-elementor' ),
				'label_off' => __( 'Off', 'royal-addons-for-elementor' ),
				'separator' => 'before',
				'condition' => [
					'hover_content_animation!' => '',
				],
			]
		);

		$this->add_control(
			'eb_overlay_animation',
			[
				'label' => __( 'Overlay Animation', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SELECT,
				'groups' => [
					[
						'label' => __( 'Fade Out', 'royal-addons-for-elementor' ),
						'options' => [							
							'fade-out' => 'Fade Out',
							'fade-out-up' => 'Fade Out Up',
							'fade-out-down' => 'Fade Out Down',
							'fade-out-left' => 'Fade Out Left',
							'fade-out-right' => 'Fade Out Right',
						],
					],
				],
				'default' => 'fade-out',
				'condition' => [
					'eb_overlay_text!' => '',
				],
			]
		);

		$this->add_control(
			'eb_overlay_animation_transition_speed',
			[
				'label' => __( 'Transition Speed (s)', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .eb-overlay-text-wrapper' => '-webkit-transition: {{SIZE}}s; -o-transition: {{SIZE}}s; transition: {{SIZE}}s;',
				],
				'default' => [
					'size' => 0.25,
				],
				'range' => [
					'px' => [
						'min' => 0.1,
						'max' => 5,
					],
				],
				'condition' => [
					'eb_overlay_text!' => '',
				],
			]
		);

		$this->add_control(
			'eb_overlay_title_text',
			[
				'label' => __( 'Overlay Title Text', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'default' => __( 'Overlay text', 'royal-addons-for-elementor' ),
				'placeholder' => __( 'Enter your overlay title text', 'royal-addons-for-elementor' ),
				'label_block' => true,
				'condition' => [
					'eb_overlay_text' => 'yes',
				],
			]
		);

		$this->add_control(
			'eb_overlay_description_text',
			[
				'label' => __('', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::TEXTAREA,
				'dynamic' => [
					'active' => true,
				],
				'default' => __( 'Overlay Description', 'royal-addons-for-elementor' ),
				'placeholder' => __( 'Enter your overlay description', 'royal-addons-for-elementor' ),
				'rows' => 10,
				'separator' => 'none',
				'show_label' => false,
				'condition' => [
					'eb_overlay_text' => 'yes',
				],
			]
		);

		$this->add_control(
			'eb_overlay_title_size',
			[
				'label' => __( 'Title HTML Tag', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'h1' => 'H1',
					'h2' => 'H2',
					'h3' => 'H3',
					'h4' => 'H4',
					'h5' => 'H5',
					'h6' => 'H6',
					'div' => 'div',
					'span' => 'span',
					'p' => 'p',
				],
				'default' => 'h5',
				'condition' => [
					'eb_overlay_text' => 'yes',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_cta_box_animate',
			[
				'label' => __( 'Main Layout', 'royal-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'cta_box_animate_height',
			[
				'label' => __( 'Height', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 100,
						'max' => 1000,
					],
					'vh' => [
						'min' => 10,
						'max' => 100,
					],
				],
				'size_units' => [ 'px', 'vh' ],
				'selectors' => [
					'{{WRAPPER}} .royalctabox .royalctabox-content-wrapper' => 'height: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			'cta_box_animate_padding',
			[
				'label' => __( 'Padding', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .royalctabox' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'cta_box_animate_content_slide_up',
			[
				'label' => __( 'Content Animation Padding', 'royal-addons-for-elementor' ),
				'description' => __( 'Some animation, padding is needed if you are using padding on the main element. Some animation, padding is needed if you are using padding on the main element. This value must be the same as the above up or bottom padding.', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .royalctabox-content-wrapper' => '-webkit-transform: translateY(100%) translateY(+{{SIZE}}{{UNIT}});
					    -moz-transform: translateY(100%) translateY(+{{SIZE}}{{UNIT}});
					    -ms-transform: translateY(100%) translateY(+{{SIZE}}{{UNIT}});
					    -o-transform: translateY(100%) translateY(+{{SIZE}}{{UNIT}});
					    transform: translateY(100%) translateY(+{{SIZE}}{{UNIT}});',
					'{{WRAPPER}} .royalctabox-hover:hover .royalctabox-content-wrapper' => '-webkit-transform: translate(0, 0);
					    -moz-transform: translate(0, 0);
					    -ms-transform: translate(0, 0);
					    -o-transform: translate(0, 0);
					    transform: translate(0, 0);',
				],
				'condition' => [
					'cta_box_animate_padding!' => '',
					'hover_content_animation' => 'slide-up',
				],
			]
		);

		$this->add_responsive_control(
			'cta_box_animate_content_slide_down',
			[
				'label' => __( 'Content Animation Padding', 'royal-addons-for-elementor' ),
				'description' => __( 'Some animation, padding is needed if you are using padding on the main element. This value must be the same as the above up or bottom padding.', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .royalctabox-content-wrapper' => '-webkit-transform: translateY(-100%) translateY(-{{SIZE}}{{UNIT}});
					    -moz-transform: translateY(-100%) translateY(-{{SIZE}}{{UNIT}});
					    -ms-transform: translateY(-100%) translateY(-{{SIZE}}{{UNIT}});
					    -o-transform: translateY(-100%) translateY(-{{SIZE}}{{UNIT}});
					    transform: translateY(-100%) translateY(-{{SIZE}}{{UNIT}});',
					'{{WRAPPER}} .royalctabox-hover:hover .royalctabox-content-wrapper' => '-webkit-transform: translate(0, 0);
					    -moz-transform: translate(0, 0);
					    -ms-transform: translate(0, 0);
					    -o-transform: translate(0, 0);
					    transform: translate(0, 0);',
				],
				'condition' => [
					'cta_box_animate_padding!' => '',
					'hover_content_animation' => 'slide-down',
				],
			]
		);

		$this->add_responsive_control(
			'cta_box_animate_content_slide_left',
			[
				'label' => __( 'Content Animation Padding', 'royal-addons-for-elementor' ),
				'description' => __( 'Some animation, padding is needed if you are using padding on the main element. This value must be the same as the above left or right padding.', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .royalctabox-content-wrapper' => '-webkit-transform: translateX(100%) translateX(+{{SIZE}}{{UNIT}});
					    -moz-transform: translateX(100%) translateX(+{{SIZE}}{{UNIT}});
					    -ms-transform: translateX(100%) translateX(+{{SIZE}}{{UNIT}});
					    -o-transform: translateX(100%) translateX(+{{SIZE}}{{UNIT}});
					    transform: translateX(100%) translateX(+{{SIZE}}{{UNIT}});',
					'{{WRAPPER}} .royalctabox-hover:hover .royalctabox-content-wrapper' => '-webkit-transform: translate(0, 0);
					    -moz-transform: translate(0, 0);
					    -ms-transform: translate(0, 0);
					    -o-transform: translate(0, 0);
					    transform: translate(0, 0);',
				],
				'condition' => [
					'cta_box_animate_padding!' => '',
					'hover_content_animation' => 'slide-left',
				],
			]
		);

		$this->add_responsive_control(
			'cta_box_animate_content_slide_right',
			[
				'label' => __( 'Content Hover Padding', 'royal-addons-for-elementor' ),
				'description' => __( 'Some animation, padding is needed if you are using padding on the main element. This value must be the same as the above left or right padding.', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .royalctabox-content-wrapper' => '-webkit-transform: translateX(-100%) translateX(-{{SIZE}}{{UNIT}});
					    -moz-transform: translateX(-100%) translateX(-{{SIZE}}{{UNIT}});
					    -ms-transform: translateX(-100%) translateX(-{{SIZE}}{{UNIT}});
					    -o-transform: translateX(-100%) translateX(-{{SIZE}}{{UNIT}});
					    transform: translateX(-100%) translateX(-{{SIZE}}{{UNIT}});',
					'{{WRAPPER}} .royalctabox-hover:hover .royalctabox-content-wrapper' => '-webkit-transform: translate(0, 0);
					    -moz-transform: translate(0, 0);
					    -ms-transform: translate(0, 0);
					    -o-transform: translate(0, 0);
					    transform: translate(0, 0);',
				],
				'condition' => [
					'cta_box_animate_padding!' => '',
					'hover_content_animation' => 'slide-right',
				],
			]
		);

		$this->add_responsive_control(
			'cta_box_animate_content_slide_top_left',
			[
				'label' => __( 'Content Hover Padding', 'royal-addons-for-elementor' ),
				'description' => __( 'Some animation, padding is needed if you are using padding on the main element. This value must be the same as the above left or right padding.', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .royalctabox-content-wrapper' => '-webkit-transform: translate(-100%, -100%) translate(-{{SIZE}}{{UNIT}}, -{{SIZE}}{{UNIT}});
					    -moz-transform: translate(-100%, -100%) translate(-{{SIZE}}{{UNIT}}, -{{SIZE}}{{UNIT}});
					    -ms-transform: translate(-100%, -100%) translate(-{{SIZE}}{{UNIT}}, -{{SIZE}}{{UNIT}});
					    -o-transform: translate(-100%, -100%) translate(-{{SIZE}}{{UNIT}}, -{{SIZE}}{{UNIT}});
					    transform: translate(-100%, -100%) translate(-{{SIZE}}{{UNIT}}, -{{SIZE}}{{UNIT}});',
					'{{WRAPPER}} .royalctabox-hover:hover .royalctabox-content-wrapper' => '-webkit-transform: translate(0, 0);
					    -moz-transform: translate(0, 0);
					    -ms-transform: translate(0, 0);
					    -o-transform: translate(0, 0);
					    transform: translate(0, 0);',
				],
				'condition' => [
					'cta_box_animate_padding!' => '',
					'hover_content_animation' => 'slide-top-left',
				],
			]
		);

		$this->add_responsive_control(
			'cta_box_animate_content_slide_top_right',
			[
				'label' => __( 'Content Hover Padding', 'royal-addons-for-elementor' ),
				'description' => __( 'Some animation, padding is needed if you are using padding on the main element. This value must be the same as the above left or right padding.', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .royalctabox-content-wrapper' => '-webkit-transform: translate(100%, -100%) translate(+{{SIZE}}{{UNIT}}, -{{SIZE}}{{UNIT}});
					    -moz-transform: translate(100%, -100%) translate(+{{SIZE}}{{UNIT}}, -{{SIZE}}{{UNIT}});
					    -ms-transform: translate(100%, -100%) translate(+{{SIZE}}{{UNIT}}, -{{SIZE}}{{UNIT}});
					    -o-transform: translate(100%, -100%) translate(+{{SIZE}}{{UNIT}}, -{{SIZE}}{{UNIT}});
					    transform: translate(100%, -100%) translate(+{{SIZE}}{{UNIT}}, -{{SIZE}}{{UNIT}});',
					'{{WRAPPER}} .royalctabox-hover:hover .royalctabox-content-wrapper' => '-webkit-transform: translate(0, 0);
					    -moz-transform: translate(0, 0);
					    -ms-transform: translate(0, 0);
					    -o-transform: translate(0, 0);
					    transform: translate(0, 0);',
				],
				'condition' => [
					'cta_box_animate_padding!' => '',
					'hover_content_animation' => 'slide-top-right',
				],
			]
		);

		$this->add_responsive_control(
			'cta_box_animate_content_slide_bottom_left',
			[
				'label' => __( 'Content Hover Padding', 'royal-addons-for-elementor' ),
				'description' => __( 'Some animation, padding is needed if you are using padding on the main element. This value must be the same as the above left or right padding.', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .royalctabox-content-wrapper' => '-webkit-transform: translate(-100%, 100%) translate(-{{SIZE}}{{UNIT}}, +{{SIZE}}{{UNIT}});
					    -moz-transform: translate(-100%, 100%) translate(-{{SIZE}}{{UNIT}}, +{{SIZE}}{{UNIT}});
					    -ms-transform: translate(-100%, 100%) translate(-{{SIZE}}{{UNIT}}, +{{SIZE}}{{UNIT}});
					    -o-transform: translate(-100%, 100%) translate(-{{SIZE}}{{UNIT}}, +{{SIZE}}{{UNIT}});
					    transform: translate(-100%, 100%) translate(-{{SIZE}}{{UNIT}}, +{{SIZE}}{{UNIT}});',
					'{{WRAPPER}} .royalctabox-hover:hover .royalctabox-content-wrapper' => '-webkit-transform: translate(0, 0);
					    -moz-transform: translate(0, 0);
					    -ms-transform: translate(0, 0);
					    -o-transform: translate(0, 0);
					    transform: translate(0, 0);',
				],
				'condition' => [
					'cta_box_animate_padding!' => '',
					'hover_content_animation' => 'slide-bottom-left',
				],
			]
		);

		$this->add_responsive_control(
			'cta_box_animate_content_slide_bottom_right',
			[
				'label' => __( 'Content Hover Padding', 'royal-addons-for-elementor' ),
				'description' => __( 'Some animation, padding is needed if you are using padding on the main element. This value must be the same as the above left or right padding.', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .royalctabox-content-wrapper' => '-webkit-transform: translate(100%, 100%) translate(+{{SIZE}}{{UNIT}}, +{{SIZE}}{{UNIT}});
					    -moz-transform: translate(100%, 100%) translate(+{{SIZE}}{{UNIT}}, +{{SIZE}}{{UNIT}});
					    -ms-transform: translate(100%, 100%) translate(+{{SIZE}}{{UNIT}}, +{{SIZE}}{{UNIT}});
					    -o-transform: translate(100%, 100%) translate(+{{SIZE}}{{UNIT}}, +{{SIZE}}{{UNIT}});
					    transform: translate(100%, 100%) translate(+{{SIZE}}{{UNIT}}, +{{SIZE}}{{UNIT}});',
					'{{WRAPPER}} .royalctabox-hover:hover .royalctabox-content-wrapper' => '-webkit-transform: translate(0, 0);
					    -moz-transform: translate(0, 0);
					    -ms-transform: translate(0, 0);
					    -o-transform: translate(0, 0);
					    transform: translate(0, 0);',
				],
				'condition' => [
					'cta_box_animate_padding!' => '',
					'hover_content_animation' => 'slide-bottom-right',
				],
			]
		);

		$this->add_responsive_control(
			'text_align',
			[
				'label' => __( 'Alignment', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::CHOOSE,
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
					'justify' => [
						'title' => __( 'Justified', 'royal-addons-for-elementor' ),
						'icon' => 'fa fa-align-justify',
					],
				],
				'default' => 'center',
				'selectors' => [
					'{{WRAPPER}} .royalctaiconbox-wrapper' => 'text-align: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'cta_box_animate_content_vertical_position',
			[
				'label' => __( 'Vertical Position', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => true,
				'options' => [
					'top' => [
						'title' => __( 'Top', 'royal-addons-for-elementor' ),
						'icon' => 'eicon-v-align-top',
					],
					'middle' => [
						'title' => __( 'Middle', 'royal-addons-for-elementor' ),
						'icon' => 'eicon-v-align-middle',
					],
					'bottom' => [
						'title' => __( 'Bottom', 'royal-addons-for-elementor' ),
						'icon' => 'eicon-v-align-bottom',
					],
				],
				'default' => 'middle',
				'prefix_class' => 'royalctabox-vertical-align-',
				'separator' => 'none',
			]
		);

		$this->add_control(
			'icon_vertical_alignment',
			[
				'label' => __( 'Icon Vertical Alignment', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => true,
				'options' => [
					'top' => [
						'title' => __( 'Top', 'royal-addons-for-elementor' ),
						'icon' => 'eicon-v-align-top',
					],
					'middle' => [
						'title' => __( 'Middle', 'royal-addons-for-elementor' ),
						'icon' => 'eicon-v-align-middle',
					],
					'bottom' => [
						'title' => __( 'Bottom', 'royal-addons-for-elementor' ),
						'icon' => 'eicon-v-align-bottom',
					],
				],
				'default' => 'top',
				'prefix_class' => 'elementor-vertical-align-',
				'condition' => [
					'box_blurb_style!' => 'none',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'eb_effect_image_bg',
				'label' => __( 'Background Color', 'royal-addons-for-elementor' ),
				'types' => [ 'classic','gradient' ],
				'selector' => '{{WRAPPER}} .royalctabox-animate-bg',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'eb_background_overlay',
			[
				'label' => __( 'Background Overlay', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .royalctabox-animate-bg-wrapper .royalctabox-overlay' => 'background-color: {{VALUE}};',
				],
				'separator' => 'before',
				'condition' => [
					'eb_effect_image_bg_image[id]!' => '',
				],
			]
		);

		$this->add_control(
			'eb_background_overlay_option',
			[
				'label' => __( 'Show Overylay on Hover', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'royal-addons-for-elementor' ),
				'label_off' => __( 'Off', 'royal-addons-for-elementor' ),
				'separator' => 'after',
				'condition' => [
					'eb_background_overlay!' => '',
				],
			]
		);

		$this->add_control(
			'eb_effect_image_transition',
			[
				'label' => __( 'Background Hover Transition', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SELECT,
				'label_block' => true,
				'options' => [
					'' => 'None',
					'greyscale' => 'Greyscale',
					'blur' => 'Blur',
					'sepia' => 'Sepia',
					'saturate' => 'Saturate',
					'brightness' => 'Brightness',
					'contrast' => 'Contrast',
					'invert' => 'Invert',
					'hue-rotate' => 'Hue Rotate',
				],
				'default' => '',
				'condition' => [
					'eb_effect_image_bg_image[id]!' => '',
				],
			]
		);

		$this->add_control(
			'eb_effect_image_transition_speed',
			[
				'label' => __( 'Transition Speed (s)', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .royalctabox .royalctabox-animate-bg, {{WRAPPER}} .royalctabox .royalctabox-overlay' => '-webkit-transition: {{SIZE}}s; -o-transition: {{SIZE}}s; transition: {{SIZE}}s;',
				],
				'default' => [
					'size' => 0.35,
				],
				'range' => [
					'px' => [
						'min' => 0.1,
						'max' => 5,
					],
				],
				'condition' => [
					'eb_effect_image_transition!' => '',
				],
			]
		);

		$this->add_control(
			'eb_effect_image_blur',
			[
				'label' => __( 'Blur', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .royalctabox:hover .royalctabox-bg-blur' => '-webkit-filter: blur({{SIZE}}{{UNIT}}); filter: blur({{SIZE}}{{UNIT}}); -moz-filter: blur({{SIZE}}{{UNIT}}); -ms-filter: blur({{SIZE}}{{UNIT}}); -o-filter: blur({{SIZE}}{{UNIT}});',
				],
				'default' => [
					'size' => 2,
				],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 50,
					],
				],
				'condition' => [
					'eb_effect_image_transition' => 'blur',
				],
			]
		);

		$this->add_control(
			'eb_effect_image_greyscale',
			[
				'label' => __( 'Greyscale (%)', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .royalctabox:hover .royalctabox-bg-greyscale' => '-webkit-filter: grayscale({{SIZE}}%); filter: grayscale({{SIZE}}%); -moz-filter: grayscale({{SIZE}}%); -ms-filter: grayscale({{SIZE}}%); -o-filter: grayscale({{SIZE}}%);',
				],
				'default' => [
					'size' => 100,
				],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'condition' => [
					'eb_effect_image_transition' => 'greyscale',
				],
			]
		);

		$this->add_control(
			'eb_effect_image_sepia',
			[
				'label' => __( 'Sepia (%)', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .royalctabox:hover .royalctabox-bg-sepia' => '-webkit-filter: sepia({{SIZE}}%); filter: sepia({{SIZE}}%); -moz-filter: sepia({{SIZE}}%); -ms-filter: sepia({{SIZE}}%); -o-filter: sepia({{SIZE}}%);',
				],
				'default' => [
					'size' => 100,
				],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'condition' => [
					'eb_effect_image_transition' => 'sepia',
				],
			]
		);

		$this->add_control(
			'eb_effect_image_saturate',
			[
				'label' => __( 'Saturate', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .royalctabox:hover .royalctabox-bg-saturate' => '-webkit-filter: saturate({{SIZE}}); filter: saturate({{SIZE}}); -moz-filter: saturate({{SIZE}}); -ms-filter: saturate({{SIZE}}); -o-filter: saturate({{SIZE}});',
				],
				'default' => [
					'size' => 100,
				],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'condition' => [
					'eb_effect_image_transition' => 'saturate',
				],
			]
		);

		$this->add_control(
			'eb_effect_image_brightness',
			[
				'label' => __( 'Brightness (%)', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .royalctabox:hover .royalctabox-bg-brightness' => '-webkit-filter: brightness({{SIZE}}%); filter: brightness({{SIZE}}%); -moz-filter: brightness({{SIZE}}%); -ms-filter: brightness({{SIZE}}%); -o-filter: brightness({{SIZE}}%);',
				],
				'default' => [
					'size' => 100,
				],
				'range' => [
					'px' => [
						'min' => 100,
						'max' => 1000,
					],
				],
				'condition' => [
					'eb_effect_image_transition' => 'brightness',
				],
			]
		);

		$this->add_control(
			'eb_effect_image_contrast',
			[
				'label' => __( 'Contrast (%)', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .royalctabox:hover .royalctabox-bg-contrast' => '-webkit-filter: contrast({{SIZE}}%); filter: contrast({{SIZE}}%); -moz-filter: contrast({{SIZE}}%); -ms-filter: contrast({{SIZE}}%); -o-filter: contrast({{SIZE}}%);',
				],
				'default' => [
					'size' => 100,
				],
				'range' => [
					'px' => [
						'min' => 100,
						'max' => 500,
					],
				],
				'condition' => [
					'eb_effect_image_transition' => 'contrast',
				],
			]
		);

		$this->add_control(
			'eb_effect_image_invert',
			[
				'label' => __( 'Invert (%)', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .royalctabox:hover .royalctabox-bg-invert' => '-webkit-filter: invert({{SIZE}}%); filter: invert({{SIZE}}%); -moz-filter: invert({{SIZE}}%); -ms-filter: invert({{SIZE}}%); -o-filter: invert({{SIZE}}%);',
				],
				'default' => [
					'size' => 0,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'condition' => [
					'eb_effect_image_transition' => 'invert',
				],
			]
		);

		$this->add_control(
			'eb_effect_image_hue_rotate',
			[
				'label' => __( 'Hue-Rotate (Deg)', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .royalctabox:hover .royalctabox-bg-hue-rotate' => '-webkit-filter: hue-rotate({{SIZE}}deg); filter: hue-rotate({{SIZE}}deg); -moz-filter: hue-rotate({{SIZE}}deg); -ms-filter: hue-rotate({{SIZE}}deg); -o-filter: hue-rotate({{SIZE}}deg);',
				],
				'default' => [
					'size' => 0,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'condition' => [
					'eb_effect_image_transition' => 'hue-rotate',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_icon',
			[
				'label' => __( 'Blurb Icon', 'royal-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'icon!' => '',
					'box_blurb_style' => 'icon',
				],
			]
		);

		$this->add_control(
			'primary_color',
			[
				'label' => __( 'Primary Color', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}}.elementor-view-stacked .elementor-icon' => 'background-color: {{VALUE}};',
					'{{WRAPPER}}.elementor-view-framed .elementor-icon, {{WRAPPER}}.elementor-view-default .elementor-icon' => 'color: {{VALUE}}; border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'secondary_color',
			[
				'label' => __( 'Secondary Color', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'condition' => [
					'view!' => 'default',
				],
				'selectors' => [
					'{{WRAPPER}}.elementor-view-framed .elementor-icon' => 'background-color: {{VALUE}};',
					'{{WRAPPER}}.elementor-view-stacked .elementor-icon' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'position',
			[
				'label' => __( 'Icon Position', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::CHOOSE,
				'default' => 'top',
				'options' => [
					'left' => [
						'title' => __( 'Left', 'royal-addons-for-elementor' ),
						'icon' => 'eicon-text-align-left',
					],
					'top' => [
						'title' => __( 'Top', 'royal-addons-for-elementor' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'royal-addons-for-elementor' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'prefix_class' => 'elementor-position-',
				'toggle' => false,
				'condition' => [
					'icon!' => '',
				],
			]
		);

		$this->add_responsive_control(
			'icon_space',
			[
				'label' => __( 'Spacing', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 15,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}}.elementor-position-right .royalctaiconbox-icon' => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.elementor-position-left .royalctaiconbox-icon' => 'margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.elementor-position-top .royalctaiconbox-icon' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					'(mobile){{WRAPPER}} .royalctaiconbox-icon' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'icon_size',
			[
				'label' => __( 'Size', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 6,
						'max' => 300,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-icon' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'icon_padding',
			[
				'label' => __( 'Padding', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .elementor-icon' => 'padding: {{SIZE}}{{UNIT}};',
				],
				'range' => [
					'em' => [
						'min' => 0,
						'max' => 5,
					],
				],
				'condition' => [
					'view!' => 'default',
				],
			]
		);

		$this->add_control(
			'rotate',
			[
				'label' => __( 'Rotate', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0,
					'unit' => 'deg',
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-icon i' => 'transform: rotate({{SIZE}}{{UNIT}});',
				],
			]
		);

		$this->add_control(
			'border_width',
			[
				'label' => __( 'Border Width', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'selectors' => [
					'{{WRAPPER}} .elementor-icon' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'view' => 'framed',
				],
			]
		);

		$this->add_control(
			'border_radius',
			[
				'label' => __( 'Border Radius', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .elementor-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'view!' => 'default',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_hover',
			[
				'label' => __( 'Blurb Icon Hover', 'royal-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'icon!' => '',
					'box_blurb_style' => 'icon',
				],
			]
		);

		$this->add_control(
			'hover_primary_color',
			[
				'label' => __( 'Primary Color', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}}.elementor-view-stacked .elementor-icon:hover' => 'background-color: {{VALUE}};',
					'{{WRAPPER}}.elementor-view-framed .elementor-icon:hover, {{WRAPPER}}.elementor-view-default .elementor-icon:hover' => 'color: {{VALUE}}; border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'hover_secondary_color',
			[
				'label' => __( 'Secondary Color', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'condition' => [
					'view!' => 'default',
				],
				'selectors' => [
					'{{WRAPPER}}.elementor-view-framed .elementor-icon:hover' => 'background-color: {{VALUE}};',
					'{{WRAPPER}}.elementor-view-stacked .elementor-icon:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'hover_animation',
			[
				'label' => __( 'Hover Animation', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::HOVER_ANIMATION,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_image',
			[
				'label' => __( 'Blurb Image', 'royal-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'box_blurb_style' => 'image',
				],
			]
		);

		$this->add_control(
			'image_position',
			[
				'label' => __( 'Image Position', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::CHOOSE,
				'default' => 'top',
				'options' => [
					'left' => [
						'title' => __( 'Left', 'royal-addons-for-elementor' ),
						'icon' => 'eicon-text-align-left',
					],
					'top' => [
						'title' => __( 'Top', 'royal-addons-for-elementor' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'royal-addons-for-elementor' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'prefix_class' => 'elementor-position-',
				'toggle' => false,
			]
		);

		$this->add_responsive_control(
			'image_space',
			[
				'label' => __( 'Image Spacing', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 15,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}}.elementor-position-right .royalctaimagebox-img' => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.elementor-position-left .royalctaimagebox-img' => 'margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.elementor-position-top .royalctaimagebox-img' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					'(mobile){{WRAPPER}} .royalctaimagebox-img' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'image_size',
			[
				'label' => __( 'Image Size', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 30,
					'unit' => '%',
				],
				'tablet_default' => [
					'unit' => '%',
				],
				'mobile_default' => [
					'unit' => '%',
				],
				'size_units' => [ '%' ],
				'range' => [
					'%' => [
						'min' => 5,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .royalctaiconbox-wrapper .royalctaimagebox-img' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'image_opacity',
			[
				'label' => __( 'Opacity (%)', 'royal-addons-for-elementor' ),
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
				'selectors' => [
					'{{WRAPPER}} .royalctaiconbox-wrapper .royalctaimagebox-img img' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'image_border',
				'placeholder' => '1px',
				'default' => '1px',
				'selector' => '{{WRAPPER}} .royalctaiconbox-wrapper .royalctaimagebox-img img',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'image_border_radius',
			[
				'label' => __( 'Border Radius', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .royalctaiconbox-wrapper .royalctaimagebox-img img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'image_hover_animation',
			[
				'label' => __( 'Hover Animation', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::HOVER_ANIMATION,
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'image_box_shadow',
				'selector' => '{{WRAPPER}} .royalctaiconbox-wrapper .royalctaimagebox-img img',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_content',
			[
				'label' => __( 'Content Area', 'royal-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'eb_content_image_bg',
				'label' => __( 'Background Color', 'royal-addons-for-elementor' ),
				'types' => [ 'classic','gradient' ],
				'selector' => '{{WRAPPER}} .royalctabox .royalctabox-content-wrapper',
				'separator' => 'none',
			]
		);

		$this->add_control(
			'cta_box_animate_content_padding',
			[
				'label' => __( 'Padding', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .royalctabox .royalctaiconbox-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);	

		$this->add_control(
			'heading_title',
			[
				'label' => __( 'Title', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'title_bottom_space',
			[
				'label' => __( 'Spacing', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .royalctaiconbox-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => __( 'Color', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .royalctaiconbox-content .royalctaiconbox-title' => 'color: {{VALUE}};',
				],

			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'selector' => '{{WRAPPER}} .royalctaiconbox-content .royalctaiconbox-title',
				'global' => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_PRIMARY,
				  ],
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'title_typography_text_shadow',
				'selector' => '{{WRAPPER}} .royalctaiconbox-content .royalctaiconbox-title',
			]
		);

		$this->add_control(
			'heading_subtitle',
			[
				'label' => __( 'Subtitle', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'subtitle_text!' => '',
				],
			]
		);

		$this->add_responsive_control(
			'subtitle_bottom_space',
			[
				'label' => __( 'Spacing', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .royalctabox-animate-subtitle' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'subtitle_text!' => '',
				],
			]
		);

		$this->add_control(
			'subtitle_color',
			[
				'label' => __( 'Color', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .royalctaiconbox-content .royalctabox-animate-subtitle' => 'color: {{VALUE}};',
				],
				'global' => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_TEXT,
				  ],
				'condition' => [
					'subtitle_text!' => '',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'subtitle_typography',
				'selector' => '{{WRAPPER}} .royalctaiconbox-content .royalctabox-animate-subtitle',
				'global' => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_TEXT,
				  ],
				'condition' => [
					'subtitle_text!' => '',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'subtitle_typography_text_shadow',
				'selector' => '{{WRAPPER}} .royalctaiconbox-content .royalctabox-animate-subtitle',
				'condition' => [
					'subtitle_text!' => '',
				],
			]
		);

		$this->add_control(
			'heading_description',
			[
				'label' => __( 'Description', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'description_bottom_space',
			[
				'label' => __( 'Spacing', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .royalctaiconbox-content .royalctaiconbox-description' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'description_color',
			[
				'label' => __( 'Color', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .royalctaiconbox-content .royalctaiconbox-description' => 'color: {{VALUE}};',
				],
				'global' => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_TEXT,
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'description_typography',
				'selector' => '{{WRAPPER}} .royalctaiconbox-content .royalctaiconbox-description',
				'global' => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_TEXT,
				],
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'description_typography_text_shadow',
				'selector' => '{{WRAPPER}} .royalctaiconbox-content .royalctaiconbox-description',
			]
		);

		$this->end_controls_section();

		//Overlay Styles 
		$this->start_controls_section(
			'section_style_overlay_content',
			[
				'label' => __( 'Overlay', 'royal-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'eb_overlay_text' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'overlay_text_align',
			[
				'label' => __( 'Alignment', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::CHOOSE,
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
					'justify' => [
						'title' => __( 'Justified', 'royal-addons-for-elementor' ),
						'icon' => 'fa fa-align-justify',
					],
				],
				'default' => 'center',
				'selectors' => [
					'{{WRAPPER}} .eb-overlay-text-wrapper' => 'text-align: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'overlay_vertical_position',
			[
				'label' => __( 'Vertical Position', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => true,
				'options' => [
					'top' => [
						'title' => __( 'Top', 'royal-addons-for-elementor' ),
						'icon' => 'eicon-v-align-top',
					],
					'middle' => [
						'title' => __( 'Middle', 'royal-addons-for-elementor' ),
						'icon' => 'eicon-v-align-middle',
					],
					'bottom' => [
						'title' => __( 'Bottom', 'royal-addons-for-elementor' ),
						'icon' => 'eicon-v-align-bottom',
					],
				],
				'default' => 'middle',
				'prefix_class' => 'royalctabox-overlay-vertical-align-',
				'separator' => 'none',
			]
		);

		$this->add_control(
			'overlay_inner_wrapper',
			[
				'label' => __( 'Overlay Inner Wrapper', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'overlay_text_inner_padding',
			[
				'label' => __( 'Inner Padding', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .eb-overlay-inner-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'overlay_inner_background',
			[
				'label' => __( 'Inner Background Color', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .eb-overlay-inner-wrapper' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'overlay_outer_wrapper',
			[
				'label' => __( 'Overlay Outer Wrapper', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'overlay_text_padding',
			[
				'label' => __( 'Outer Padding', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .eb-overlay-text-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'overlay_background',
				'label' => __( 'Background Color', 'royal-addons-for-elementor' ),
				'types' => [ 'classic','gradient' ],
				'selector' => '{{WRAPPER}} .eb-overlay-text-wrapper',
			]
		);

		$this->add_control(
			'overlay_heading_title',
			[
				'label' => __( 'Overlay Title', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'overlay_title_bottom_space',
			[
				'label' => __( 'Spacing', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .eb-overlay-text-wrapper .eb-overlay-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'overlay_title_color',
			[
				'label' => __( 'Color', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .eb-overlay-text-wrapper .eb-overlay-title' => 'color: {{VALUE}};',
				],
				'global' => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_PRIMARY,
				  ],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'overlay_title_typography',
				'selector' => '{{WRAPPER}} .eb-overlay-text-wrapper .eb-overlay-title',
				'global' => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_PRIMARY,
				  ],
			]
		);

		$this->add_control(
			'overlay_heading_description',
			[
				'label' => __( 'Overlay Description', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'overlay_description_color',
			[
				'label' => __( 'Color', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .eb-overlay-text-wrapper .eb-overlay-description' => 'color: {{VALUE}};',
				],
				'global' => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_TEXT,
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'overlay_description_typography',
				'selector' => '{{WRAPPER}} .eb-overlay-text-wrapper .eb-overlay-description',
				'global' => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_TEXT,
				  ],
			]
		);

		$this->end_controls_section();

		//Button #1
		$this->start_controls_section(
			'section_style_button_one',
			[
				'label' => __( 'Button #1', 'royal-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'button_one_text!' => '',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'button_one_typography',
				'global' => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_ACCENT,
				  ],
				'selector' => '{{WRAPPER}} a.royalctabutton-one, {{WRAPPER}} .royalctabutton-one',
			]
		);

		$this->start_controls_tabs( 'tabs_button_one_style' );

		$this->start_controls_tab(
			'tab_button_one_normal',
			[
				'label' => __( 'Normal', 'royal-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'button_one_text_color',
			[
				'label' => __( 'Text Color', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} a.royalctabutton-one, {{WRAPPER}} .royalctabutton-one' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_one_background_color',
			[
				'label' => __( 'Background Color', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'global' => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_ACCENT,
				],
				'selectors' => [
					'{{WRAPPER}} a.royalctabutton-one, {{WRAPPER}} .royalctabutton-one' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_button_one_hover',
			[
				'label' => __( 'Hover', 'royal-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'button_one_hover_color',
			[
				'label' => __( 'Text Color', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} a.royalctabutton-one:hover, {{WRAPPER}} .royalctabutton-one:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_one_background_hover_color',
			[
				'label' => __( 'Background Color', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} a.royalctabutton-one:hover, {{WRAPPER}} .royalctabutton-one:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_one_hover_border_color',
			[
				'label' => __( 'Border Color', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'condition' => [
					'border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} a.royalctabutton-one:hover, {{WRAPPER}} .royalctabutton-one:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_one_hover_animation',
			[
				'label' => __( 'Hover Animation', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::HOVER_ANIMATION,
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'button_one_border',
				'placeholder' => '1px',
				'default' => '1px',
				'selector' => '{{WRAPPER}} .royalctabutton-one',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'button_one_border_radius',
			[
				'label' => __( 'Border Radius', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} a.royalctabutton-one, {{WRAPPER}} .royalctabutton-one' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'button_one_box_shadow',
				'selector' => '{{WRAPPER}} .royalctabutton-one',
			]
		);

		$this->add_responsive_control(
			'button_one_text_padding',
			[
				'label' => __( 'Padding', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} a.royalctabutton-one, {{WRAPPER}} .royalctabutton-one' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_section();

		//Seperator
		$this->start_controls_section(
			'section_style_separator',
			[
				'label' => __( 'Separator Text', 'royal-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'button_separator_text' => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'separator_typography',
				'global' => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_ACCENT,
				  ],
				'selector' => '{{WRAPPER}} .royalctabox-btn-separator',
			]
		);

		$this->add_control(
			'separator_text_color',
			[
				'label' => __( 'Text Color', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .royalctabox-btn-separator',
				],
			]
		);


		$this->end_controls_section();

		//Button #2
		$this->start_controls_section(
			'section_style_button_two',
			[
				'label' => __( 'Button #2', 'royal-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'button_two_text!' => '',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'button_two_typography',
				'global' => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_ACCENT,
				  ],
				'selector' => '{{WRAPPER}} a.royalctabutton-two, {{WRAPPER}} .royalctabutton-two',
			]
		);

		$this->start_controls_tabs( 'tabs_button_two_style' );

		$this->start_controls_tab(
			'tab_button_two_normal',
			[
				'label' => __( 'Normal', 'royal-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'button_two_text_color',
			[
				'label' => __( 'Text Color', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} a.royalctabutton-two, {{WRAPPER}} .royalctabutton-two' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_two_background_color',
			[
				'label' => __( 'Background Color', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'global' => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_ACCENT,
				],
				'selectors' => [
					'{{WRAPPER}} a.royalctabutton-two, {{WRAPPER}} .royalctabutton-two' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_button_two_hover',
			[
				'label' => __( 'Hover', 'royal-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'button_two_hover_color',
			[
				'label' => __( 'Text Color', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} a.royalctabutton-two:hover, {{WRAPPER}} .royalctabutton-two:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_two_background_hover_color',
			[
				'label' => __( 'Background Color', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} a.royalctabutton-two:hover, {{WRAPPER}} .royalctabutton-two:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_two_hover_border_color',
			[
				'label' => __( 'Border Color', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'condition' => [
					'border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} a.royalctabutton-two:hover, {{WRAPPER}} .royalctabutton-two:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_two_hover_animation',
			[
				'label' => __( 'Hover Animation', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::HOVER_ANIMATION,
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'button_two_border',
				'placeholder' => '1px',
				'default' => '1px',
				'selector' => '{{WRAPPER}} .royalctabutton-two',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'button_two_border_radius',
			[
				'label' => __( 'Border Radius', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} a.royalctabutton-two, {{WRAPPER}} .royalctabutton-two' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'button_two_box_shadow',
				'selector' => '{{WRAPPER}} .royalctabutton-two',
			]
		);

		$this->add_responsive_control(
			'button_two_text_padding',
			[
				'label' => __( 'Padding', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} a.royalctabutton-two, {{WRAPPER}} .royalctabutton-two' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);






		$this->end_controls_section();
	}

	/**
	 * Render icon box widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		$this->add_render_attribute( 'icon', 'class', [ 'elementor-icon', 'elementor-animation-' . $settings['hover_animation'] ] );

		$icon_tag = 'span';

		$has_icon = ! empty( $settings['icon'] );

		if ( ! empty( $settings['link']['url'] ) ) {
			if ( 'default' === $settings['link_to_element'] ) {
				$this->add_render_attribute( 'link', 'href', $settings['link']['url'] );
				$icon_tag = 'a';

				if ( $settings['link']['is_external'] ) {
					$this->add_render_attribute( 'link', 'target', '_blank' );
				}

				if ( $settings['link']['nofollow'] ) {
					$this->add_render_attribute( 'link', 'rel', 'nofollow' );
				}
			}
		}

		//Icon
		if ( 'icon' === $settings['box_blurb_style'] ) {
			$this->add_render_attribute( 'i', 'class', $settings['icon'] );
			$this->add_render_attribute( 'i', 'aria-hidden', 'true' );
		}

		$icon_attributes = $this->get_render_attribute_string( 'icon' );
		$link_attributes = $this->get_render_attribute_string( 'link' );

		$this->add_render_attribute( 'subtitle_text', 'class', 'royalctabox-animate-subtitle' );
		$this->add_render_attribute( 'description_text', 'class', 'royalctaiconbox-description' );
		if ( 'yes' === $settings['hover_content_sequenced_animation']) { 
			$this->add_render_attribute( 'description_text', 'class', 'royalctabox-hover-sequenced-item' );
		}

		$this->add_inline_editing_attributes( 'title_text', 'none' );

		$this->add_inline_editing_attributes( 'subtitle_text', 'none' );

		$this->add_inline_editing_attributes( 'description_text' );

		//Button #1
		$this->add_render_attribute( 'button_wrapper', 'class', 'royalctabutton-wrapper' );
		if ( 'yes' === $settings['hover_content_sequenced_animation']) { 
			$this->add_render_attribute( 'button_wrapper', 'class', 'royalctabox-hover-sequenced-item' );
		}

		if ( ! empty( $settings['button_one_link']['url'] ) ) {
			$this->add_render_attribute( 'button', 'href', $settings['button_one_link']['url'] );
			$this->add_render_attribute( 'button', 'class', 'royalctabutton-link' );

			if ( $settings['button_one_link']['is_external'] ) {
				$this->add_render_attribute( 'button', 'target', '_blank' );
			}

			if ( $settings['button_one_link']['nofollow'] ) {
				$this->add_render_attribute( 'button', 'rel', 'nofollow' );
			}
		}

		$this->add_render_attribute( 'button', 'class', 'royalctabutton royalctabutton-one royalctabutton-' . $settings['button_one_type'] );
		$this->add_render_attribute( 'button', 'role', 'button' );

		if ( ! empty( $settings['button_one_size'] ) ) {
			$this->add_render_attribute( 'button', 'class', 'elementor-size-' . $settings['button_one_size'] );
		}

		if ( $settings['button_one_hover_animation'] ) {
			$this->add_render_attribute( 'button', 'class', 'elementor-animation-' . $settings['button_one_hover_animation'] );
		}

		//Button #2
		if ( ! empty( $settings['button_two_link']['url'] ) ) {
			$this->add_render_attribute( 'button_two', 'href', $settings['button_two_link']['url'] );
			$this->add_render_attribute( 'button_two', 'class', 'royalctabutton-link' );

			if ( $settings['button_two_link']['is_external'] ) {
				$this->add_render_attribute( 'button_two', 'target', '_blank' );
			}

			if ( $settings['button_two_link']['nofollow'] ) {
				$this->add_render_attribute( 'button_two', 'rel', 'nofollow' );
			}
		}

		$this->add_render_attribute( 'button_two', 'class', 'royalctabutton royalctabutton-two royalctabutton-' . $settings['button_two_type'] );
		$this->add_render_attribute( 'button_two', 'role', 'button' );

		if ( ! empty( $settings['button_two_size'] ) ) {
			$this->add_render_attribute( 'button_two', 'class', 'elementor-size-' . $settings['button_two_size'] );
		}

		if ( $settings['button_two_hover_animation'] ) {
			$this->add_render_attribute( 'button_two', 'class', 'elementor-animation-' . $settings['button_two_hover_animation'] );
		}

		//CTA
		$this->add_render_attribute( 'hover_content_animation', 'class', 'royalctabox' );
		if ( ! empty( $settings['link']['url'] ) ) {
			if ( 'entire_div' === $settings['link_to_element'] ) {
				$this->add_render_attribute( 'main_tag_link', 'href', $settings['link']['url'] );

				if ( $settings['link']['is_external'] ) {
					$this->add_render_attribute( 'main_tag_link', 'target', '_blank' );
				}

				if ( $settings['link']['nofollow'] ) {
					$this->add_render_attribute( 'main_tag_link', 'rel', 'nofollow' );
				}
				$this->add_render_attribute( 'main_tag_link', 'class', 'royalctabox-link' );
			}
		}

		if ( '' !== $settings['hover_content_animation'] ) {
			$this->add_render_attribute( 'hover_content_animation', 'class', 'royalctabox-hover eb-cta-hover-' . $settings['hover_content_animation']);
			if ( 'yes' === $settings['eb_overlay_text']) {
				$this->add_render_attribute( 'hover_content_animation', 'class', 'eb-cta-overlay-fade-out eb-cta-overlay-' . $settings['eb_overlay_animation']);
			}
			if ( 'yes' === $settings['hover_content_sequenced_animation']) { 
				$this->add_render_attribute( 'hover_content_animation', 'class', 'royalctabox-hover-sequenced-on' );
			} else {
				$this->add_render_attribute( 'hover_content_animation', 'class', 'royalctabox-hover-sequenced-off' );
			}
		}


		?>
		<div <?php echo $this->get_render_attribute_string( 'hover_content_animation' ); ?>>
        	<?php
				if ( 'none' !== $settings['eb_effect_image_transition'] ) {
					$this->add_render_attribute( 'eb_effect_image_transition', 'class', 'royalctabox-animate-bg royalctabox-bg-' . $settings['eb_effect_image_transition']);
				}

				$this->add_render_attribute( 'eb_background_overlay_option', 'class', 'royalctabox-overlay');
				if ( 'yes' === $settings['eb_background_overlay_option'] ) {
					$this->add_render_attribute( 'eb_background_overlay_option', 'class', 'royalctabox-overlay-show-on-hover');
				}

				$imageBackground = '<div ' . $this->get_render_attribute_string( 'eb_effect_image_transition' ) . '></div>';
				
				$eb_bg_effect = '<div class="royalctabox-animate-bg-wrapper">' . $imageBackground . '<div ' . $this->get_render_attribute_string( 'eb_background_overlay_option' ) . '></div></div>';
				echo $eb_bg_effect;
        	?>
			<div class="royalctabox-content-wrapper">
		        <div class="royalctaiconbox-wrapper">
			        <?php if ( 'icon' === $settings['box_blurb_style'] ) : ?>
		            <div class="royalctaiconbox-icon<?php if ( 'yes' === $settings['hover_content_sequenced_animation']) { echo ' royalctabox-hover-sequenced-item'; }?>">
		                <<?php echo implode( ' ', [ $icon_tag, $icon_attributes, $link_attributes ] ); ?>>
		                    <i <?php echo $this->get_render_attribute_string( 'i' ); ?>></i>
		                </<?php echo $icon_tag; ?>>
		            </div>
		            <?php elseif ( 'image' === $settings['box_blurb_style'] && ! empty( $settings['image']['url'] ) ) : ?>
		            	<?php
							$this->add_render_attribute( 'image', 'src', $settings['image']['url'] );
							$this->add_render_attribute( 'image', 'alt', Control_Media::get_image_alt( $settings['image'] ) );
							$this->add_render_attribute( 'image', 'title', Control_Media::get_image_title( $settings['image'] ) );

							$this->add_render_attribute( 'image_hover_animation', 'class', 'royalctaimagebox-img elementor-animation-' . $settings['image_hover_animation'] );

							//$blurb_img = '<img ' . $this->get_render_attribute_string( 'image' ) . ' />';

							$blurb_img = Group_Control_Image_Size::get_attachment_image_html( $settings, 'thumbnail', 'image' );

							if ( ! empty( $settings['link']['url'] ) ) {
								$blurb_img = '<a ' . $this->get_render_attribute_string( 'link' ) . '>' . $blurb_img . '</a>';
							}

							$eb_image = '<figure ' . $this->get_render_attribute_string( 'image_hover_animation' ) . '>' . $blurb_img . '</figure>';
							echo $eb_image;
		            	?>
					<?php endif; ?>
		            <div class="royalctaiconbox-content">
		            	<?php if ( 'before' === $settings['subtitle_text_placement'] ) { ?>
		                <p class="royalctabox-animate-subtitle<?php if ( 'yes' === $settings['hover_content_sequenced_animation']) { echo ' royalctabox-hover-sequenced-item'; }?>" <?php echo $this->get_render_attribute_string( 'subtitle_text' ); ?>><?php echo wp_kses_post( $settings['subtitle_text'] ); ?></p>
		                <?php } ?>
		                <?php if ( 'yes' === $settings['divider'] && 'before' === $settings['divider_placement'] ) { ?>
		                <div class="elementor-divider<?php if ( 'yes' === $settings['hover_content_sequenced_animation']) { echo ' royalctabox-hover-sequenced-item'; }?>">
							<span class="elementor-divider-separator"></span>
						</div>
						<?php } ?>
		                <<?php echo wp_kses_post( $settings['title_size'] ); ?> class="royalctaiconbox-title<?php if ( 'yes' === $settings['hover_content_sequenced_animation']) { echo ' royalctabox-hover-sequenced-item'; }?>">
		                    <<?php echo implode( ' ', [ $icon_tag, $link_attributes ] ); ?> <?php echo $this->get_render_attribute_string( 'title_text' ); ?>><?php echo wp_kses_post( $settings['title_text'] ); ?></<?php echo $icon_tag; ?>>
		                </<?php echo wp_kses_post( $settings['title_size'] ); ?>>
		                <?php if ( 'yes' === $settings['divider'] && 'after' === $settings['divider_placement'] ) { ?>
		                <div class="elementor-divider<?php if ( 'yes' === $settings['hover_content_sequenced_animation']) { echo ' royalctabox-hover-sequenced-item'; }?>">
							<span class="elementor-divider-separator"></span>
						</div>
						<?php } ?>
		                <?php if ( 'after' === $settings['subtitle_text_placement'] ) { ?>
		                <p class="royalctabox-animate-subtitle<?php if ( 'yes' === $settings['hover_content_sequenced_animation']) { echo ' royalctabox-hover-sequenced-item'; }?>" <?php echo $this->get_render_attribute_string( 'subtitle_text' ); ?>><?php echo wp_kses_post( $settings['subtitle_text'] ); ?></p>
		                <?php } ?>
		                <p <?php echo $this->get_render_attribute_string( 'description_text' ); ?>><?php echo wp_kses_post( $settings['description_text'] ); ?></p>
		                <?php if ( '' !== $settings['button_one_text'] ) { ?>
		                <div <?php echo $this->get_render_attribute_string( 'button_wrapper' ); ?>>
						<a <?php echo $this->get_render_attribute_string( 'button' ); ?>>
							<?php $this->render_text(); ?>
						</a>
						<?php if ( 'yes' === $settings['button_separator'] ) { ?>
							<span class="royalctabox-btn-separator"><?php echo wp_kses_post( $settings['button_separator_text'] ); ?></span>
						<?php } ?>
						<?php if ( '' !== $settings['button_two_text'] ) { ?>
						<a <?php echo $this->get_render_attribute_string( 'button_two' ); ?>>
							<?php $this->render_text_two(); ?>
						</a>
						<?php } ?>
						</div>
						<?php } ?>
		            </div>
		        </div>
		    </div>
		    <?php if ( 'yes' == $settings['eb_overlay_text'] ) {?>
		    <div class="eb-overlay-text-wrapper">
            	<div class="eb-overlay-text-content">
            		<div class="eb-overlay-inner-wrapper">
	            		<<?php echo wp_kses_post( $settings['eb_overlay_title_size'] ); ?> class="eb-overlay-title"><?php echo wp_kses_post( $settings['eb_overlay_title_text'] ); ?></<?php echo wp_kses_post( $settings['eb_overlay_title_size'] ); ?>>
	            		<p class="eb-overlay-description"><?php echo wp_kses_post( $settings['eb_overlay_description_text'] ); ?></p>
	            	</div>
            	</div>
            </div>
            <?php } ?>
            <?php if ( 'entire_div' === $settings['link_to_element'] ) { ?>
				<a <?php echo $this->get_render_attribute_string( 'main_tag_link' ); ?>></a>
			<?php } ?>
    	</div>
		<?php
	}

	
	protected function content_template() {
		?>
        <#
        var link = settings.link.url ? 'href="' + settings.link.url + '"' : '';
        if ( 'default' === settings.link_to_element) {
        	var iconTag = 'a';
    	} else {
    		iconTag = 'span';
    	}

		view.addRenderAttribute( 'subtitle_text', 'class', 'royalctabox-animate-subtitle' );
        view.addRenderAttribute( 'description_text', 'class', 'royalctaiconbox-description' );
        if ( 'yes' === settings.hover_content_sequenced_animation) {
        	view.addRenderAttribute( 'subtitle_text', 'class', 'royalctabox-hover-sequenced-item' );
        	view.addRenderAttribute( 'description_text', 'class', 'royalctabox-hover-sequenced-item' );
    	}

        view.addInlineEditingAttributes( 'title_text', 'none' );
        view.addInlineEditingAttributes( 'subtitle_text', 'none' );
        view.addInlineEditingAttributes( 'description_text' );

        view.addRenderAttribute( 'button_one_text', 'class', 'royalctabutton-text' );
		view.addInlineEditingAttributes( 'button_one_text', 'none' );

		view.addRenderAttribute( 'button_two_text', 'class', 'royalctabutton-text' );
		view.addInlineEditingAttributes( 'button_two_text', 'none' );

		view.addInlineEditingAttributes( 'eb_overlay_title_text', 'none' );
        view.addInlineEditingAttributes( 'eb_overlay_description_text', 'none' );

        view.addRenderAttribute( 'eb_overlay_title_text', 'class', 'eb-overlay-title' );
        view.addRenderAttribute( 'eb_overlay_description_text', 'class', 'eb-overlay-description' );
			
		var ctaBoxWrapperClasses = 'royalctabox';
		if ( '' !== settings.hover_content_animation ) {
			ctaBoxWrapperClasses += ' royalctabox-hover eb-cta-hover-' + settings.hover_content_animation;
			if ( 'yes' === settings.eb_overlay_text) { 
				ctaBoxWrapperClasses += ' eb-cta-overlay-fade-out eb-cta-overlay-' + settings.eb_overlay_animation;
			}
			if ( 'yes' === settings.hover_content_sequenced_animation) { 
				ctaBoxWrapperClasses += ' royalctabox-hover-sequenced-on';
			} else {
				ctaBoxWrapperClasses += ' royalctabox-hover-sequenced-off';
			}
		}

		view.addRenderAttribute( 'hover_content_animation', 'class', ctaBoxWrapperClasses );	

		if ( 'entire_div' === settings.link_to_element) { 
			var linktoElement = settings.link.url ? 'href="' + settings.link.url + '"' : '';
			view.addRenderAttribute( 'main_tag_link', 'class', 'royalctabox-link' );	
		}

        #>
        <div {{{ view.getRenderAttributeString( 'hover_content_animation' ) }}}>
        	<#

			view.addRenderAttribute( 'eb_background_overlay_option', 'class', 'royalctabox-overlay' );

			if ( 'yes' === settings.eb_background_overlay_option ) {
				view.addRenderAttribute( 'eb_background_overlay_option', 'class', 'royalctabox-overlay-show-on-hover' );
			}

			#>
			<div class="royalctabox-animate-bg-wrapper">
				<div class="royalctabox-animate-bg royalctabox-bg-{{{ settings.eb_effect_image_transition}}}"></div>
				<div {{{ view.getRenderAttributeString( 'eb_background_overlay_option' ) }}}></div>
			</div>
			<div class="royalctabox-content-wrapper">
		        <div class="royalctaiconbox-wrapper">
		        	<# if ( 'icon' === settings.box_blurb_style ) { #>
		            <div class="royalctaiconbox-icon<# if ( 'yes' === settings.hover_content_sequenced_animation ) {#> royalctabox-hover-sequenced-item<#}#>">
		                <{{{ iconTag + ' ' + link }}} class="elementor-icon elementor-animation-{{ settings.hover_animation }}">
		                    <i class="{{ settings.icon }}" aria-hidden="true"></i>
		                </{{{ iconTag }}}>
		            </div>
					<# }
					else if ( 'image' === settings.box_blurb_style && settings.image.url ) {
						var image = {
							id: settings.image.id,
							url: settings.image.url,
							size: settings.thumbnail_size,
							dimension: settings.thumbnail_custom_dimension,
							model: view.getEditModel()
						};

						var image_url = elementor.imagesManager.getImageUrl( image );

						var imageHtml = '<img src="' + image_url + '" class="elementor-animation-' + settings.image_hover_animation + '" />';

						if ( settings.link.url ) {
							imageHtml = '<a href="' + settings.link.url + '">' + imageHtml + '</a>';
						}

						eb_html = '<figure class="royalctaimagebox-img">' + imageHtml + '</figure>';
						print( eb_html );
					} #>
		            <div class="royalctaiconbox-content">
		            	<# if ( 'before' === settings.subtitle_text_placement ) { #>
		                <p {{{ view.getRenderAttributeString( 'subtitle_text' ) }}}>{{{ settings.subtitle_text }}}</p>
		                <# } #>
		                <# if ( 'yes' === settings.divider && 'before' === settings.divider_placement ) { #>
		                <div class="elementor-divider<# if ( 'yes' === settings.hover_content_sequenced_animation ) {#> royalctabox-hover-sequenced-item<#}#>">
							<span class="elementor-divider-separator"></span>
						</div>
						<# } #>
		                <{{{ settings.title_size }}} class="royalctaiconbox-title<# if ( 'yes' === settings.hover_content_sequenced_animation ) {#> royalctabox-hover-sequenced-item<#}#>">
		                    <{{{ iconTag + ' ' + link }}} {{{ view.getRenderAttributeString( 'title_text' ) }}}>{{{ settings.title_text }}}</{{{ iconTag }}}>
		                </{{{ settings.title_size }}}>
		                 <# if ( 'yes' === settings.divider && 'after' === settings.divider_placement ) { #>
		                <div class="elementor-divider<# if ( 'yes' === settings.hover_content_sequenced_animation ) {#> royalctabox-hover-sequenced-item<#}#>">
							<span class="elementor-divider-separator"></span>
						</div>
						<# } #>
		                <# if ( 'after' === settings.subtitle_text_placement ) { #>
		                <p {{{ view.getRenderAttributeString( 'subtitle_text' ) }}}>{{{ settings.subtitle_text }}}</p>
		                <# } #>
		                <p {{{ view.getRenderAttributeString( 'description_text' ) }}}>{{{ settings.description_text }}}</p>
		                <# if ( settings.button_one_text ) { #>
		                	<div class="royalctabutton-wrapper<# if ( 'yes' === settings.hover_content_sequenced_animation ) {#> royalctabox-hover-sequenced-item<#}#>">
								<a class="royalctabutton elementor-size-{{ settings.button_one_size }} royalctabutton-{{ settings.button_one_type }} royalctabutton-one elementor-animation-{{ settings.button_one_hover_animation }}" href="{{ settings.button_one_link.url }}" role="button">
									<span class="royalctabutton-content-wrapper">
										<# if ( settings.button_one_icon ) { #>
										<span class="royalctabutton-icon elementor-align-icon-{{ settings.button_one_icon_align }}">
											<i class="{{ settings.button_one_icon }}" aria-hidden="true"></i>
										</span>
										<# } #>
										<span {{{ view.getRenderAttributeString( 'button_one_text' ) }}}>{{{ settings.button_one_text }}}</span>
									</span>
								</a>
								<# if ( settings.button_separator === 'yes' ) { #>
									<span class="royalctabox-btn-separator">{{{ settings.button_separator_text }}}</span>
								<# } #>
								<# if ( settings.button_two_text ) { #>
								<a class="royalctabutton elementor-size-{{ settings.button_two_size }} royalctabutton-{{ settings.button_two_type }} royalctabutton-two elementor-animation-{{ settings.hover_animation }}" href="{{ settings.button_two_link.url }}" role="button">
									<span class="royalctabutton-content-wrapper">
										<# if ( settings.button_two_icon ) { #>
										<span class="royalctabutton-icon elementor-align-icon-{{ settings.button_two_icon_align }}">
											<i class="{{ settings.button_two_icon }}" aria-hidden="true"></i>
										</span>
										<# } #>
										<span {{{ view.getRenderAttributeString( 'button_two_text' ) }}}>{{{ settings.button_two_text }}}</span>
									</span>
								</a>
								<# } #>
							</div>
		                <# } #>
		            </div>
		        </div>
		    </div>
		    <# if ( 'yes' === settings.eb_overlay_text ) { #>
            <div class="eb-overlay-text-wrapper">
            	<div class="eb-overlay-text-content">
            		<div class="eb-overlay-inner-wrapper">
	            		<{{{ settings.eb_overlay_title_size }}} {{{ view.getRenderAttributeString( 'eb_overlay_title_text' ) }}}>{{{ settings.eb_overlay_title_text }}}</{{{ settings.eb_overlay_title_size }}}>
	            		<# if ( '' !== settings.eb_overlay_description_text ) { #>
	            		<p {{{ view.getRenderAttributeString( 'eb_overlay_description_text' ) }}}>{{{ settings.eb_overlay_description_text }}}</p>
	            		<# } #>
	            	</div>
            	</div>
            </div>
            <# } #>
            <# if ( 'entire_div' === settings.link_to_element ) { #>
            <a {{{ view.getRenderAttributeString( 'main_tag_link' ) }}} {{{ linktoElement }}}></a>
            <# } #>
    	</div>
		<?php
	}

	

	protected function render_text() {
		$settings = $this->get_settings_for_display();

		$this->add_render_attribute( [
			'content-wrapper' => [
				'class' => 'royalctabutton-content-wrapper',
			],
			'icon-align' => [
				'class' => [
					'royalctabutton-icon',
					'elementor-align-icon-' . $settings['button_one_icon_align'],
				],
			],
			'button_one_text' => [
				'class' => 'royalctabutton-text',
			],
		] );

		$this->add_inline_editing_attributes( 'button_one_text', 'none' );
		?>
		<span <?php echo $this->get_render_attribute_string( 'content-wrapper' ); ?>>
			<?php if ( ! empty( $settings['button_one_icon'] ) ) : ?>
			<span <?php echo $this->get_render_attribute_string( 'icon-align' ); ?>>
				<i class="<?php echo esc_attr( $settings['button_one_icon'] ); ?>" aria-hidden="true"></i>
			</span>
			<?php endif; ?>
			<span <?php echo $this->get_render_attribute_string( 'button_one_text' ); ?>><?php echo wp_kses_post( $settings['button_one_text'] ); ?></span>
		</span>
		<?php
	}

	protected function render_text_two() {
		$settings = $this->get_settings_for_display();

		$this->add_render_attribute( [
			'content-wrapper' => [
				'class' => 'royalctabutton-content-wrapper',
			],
			'icon-align' => [
				'class' => [
					'royalctabutton-icon',
					'elementor-align-icon-' . $settings['button_two_icon_align'],
				],
			],
			'button_two_text' => [
				'class' => 'royalctabutton-text',
			],
		] );

		$this->add_inline_editing_attributes( 'button_two_text', 'none' );
		?>
		<span <?php echo $this->get_render_attribute_string( 'content-wrapper' ); ?>>
			<?php if ( ! empty( $settings['button_two_icon'] ) ) : ?>
			<span <?php echo $this->get_render_attribute_string( 'icon-align' ); ?>>
				<i class="<?php echo esc_attr( $settings['button_two_icon'] ); ?>" aria-hidden="true"></i>
			</span>
			<?php endif; ?>
			<span <?php echo $this->get_render_attribute_string( 'button_two_text' ); ?>><?php echo wp_kses_post( $settings['button_two_text'] ); ?></span>
		</span>
		<?php
	}




}

