<?php
namespace RoyalAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Icons_Manager;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Utils;
use Elementor\Control_Media;
use Elementor\Repeater;

defined('ABSPATH') || die();

class RoyalTimeline extends Widget_Base {
	
	public function get_name(){
		return 'royaltimeline';
	}


	public function get_title() {
		return __('Timeline', 'royal-addons-for-elementor');
	}


	public function get_icon() { return 'eicon-time-line rtbranding'; }


	public function get_keywords() {
		return [ 'timeline', 'time', 'schedule', 'year', 'tech', 'technologies', 'royal',  'mehdi',  'akram'];
	}

    public function get_categories() {
        return [ 'royaltech' ];
    }

	public function get_style_depends() {
		$styles = [ 'royaltimeline'];
		return $styles;
	}

	public function get_script_depends() {
		$scripts = ['royaltimeline'];
		return $scripts;
	}	


	protected function register_controls() {
		$this->timeline_content_controls();
		$this->settings_content_controls();

		$this->__content_box_style_controls();
		$this->__icon_box_style_controls();
		$this->__milestone_badge_style_controls();
		$this->__step_number_style_controls();
		$this->__title_style_controls();
		$this->__time_date_style_controls();
		$this->__button_style_controls();
		$this->__end_marker_style_controls();
	}


	protected function timeline_content_controls() {

		$this->start_controls_section(
			'_section_timeline',
			[
				'label' => __('Timeline', 'royal-addons-for-elementor'),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();

		$repeater->start_controls_tabs('tabs_timeline_item');
		$repeater->start_controls_tab(
			'tab_timeline_content_item',
			[
				'label' => __('Content', 'royal-addons-for-elementor'),
			]
		);
		$repeater->add_control(
			'icon_type',
			[
				'label' => __('Icon Type', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'icon' => __('Icon', 'royal-addons-for-elementor'),
					'image' => __('Image', 'royal-addons-for-elementor'),
				],
				'default' => 'icon',
				'style_transfer' => true,
			]
		);

		$repeater->add_control(
			'icon',
			[
				'label' => __('Icon', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-calendar-alt',
					'library' => 'solid',
				],
				'condition' => [
					'icon_type' => 'icon'
				],
			]
		);

		$repeater->add_control(
			'image',
			[
				'label' => __('Image Icon', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'condition' => [
					'icon_type' => 'image'
				],
                'dynamic' => [
                    'active' => true,
                ]
			]
		);

		$repeater->add_control(
			'time_style',
			[
				'label' => __('Time', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'calender' => __('Calender', 'royal-addons-for-elementor'),
					'text' => __('Text', 'royal-addons-for-elementor'),
				],
				'default' => 'calender',
				'style_transfer' => true,
			]
		);


		$repeater->add_control(
			'time',
			[
				'label' => __('Calender Time', 'royal-addons-for-elementor'),
				'show_label' => false,
				'type' => Controls_Manager::DATE_TIME,
				'default' => date('M d Y g:i a'),
				'condition' => [
					'time_style' => 'calender'
				],
			]
		);

		$repeater->add_control(
			'time_text',
			[
				'label' => __('Text Time', 'royal-addons-for-elementor'),
				'show_label' => false,
				'label_block' => true,
				'type' => Controls_Manager::TEXT,
				'default' => __('2016 - 2018', 'royal-addons-for-elementor'),
				'placeholder' => __('Text Time', 'royal-addons-for-elementor'),
				'condition' => [
					'time_style' => 'text'
				],
                'dynamic' => [
                    'active' => true,
                ]
			]
		);

		$repeater->add_control(
			'badge_text',
			[
				'label' => __('Milestone Badge / Chip', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'placeholder' => __('e.g. Beginning, Registration, Growth', 'royal-addons-for-elementor'),
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$repeater->add_control(
			'step_number',
			[
				'label' => __('Custom Step Number', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'placeholder' => __('Auto (e.g. 01, 02)', 'royal-addons-for-elementor'),
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$repeater->add_control(
			'title',
			[
				'label' => __('Title', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'default' => __('This Is Happy Title', 'royal-addons-for-elementor'),
				'placeholder' => __('Title', 'royal-addons-for-elementor'),
				'dynamic' => [
					'active' => true,
				]
			]
		);

		$repeater->add_control(
			'gallery',
			[
				'type' => Controls_Manager::GALLERY
			]
		);

		$repeater->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'thumbnail',
				'exclude' => ['custom'],
				'default' => 'thumbnail',
			]
		);

		$repeater->add_control(
			'image_position',
			[
				'label' => __('Image Position', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'before' => __('Before Title', 'royal-addons-for-elementor'),
					'after' => __('After Content', 'royal-addons-for-elementor'),
				],
				'default' => 'before',
				'style_transfer' => true,
			]
		);

		$repeater->add_control(
			'content',
			[
				'label' => __('Content', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::WYSIWYG,
				'default' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iusto, optio, dolorum provident rerum aut hic quasi placeat iure tempora laudantium ipsa ad debitis unde? Iste voluptatibus minus veritatis qui ut',
				'placeholder' => __('Type your content here', 'royal-addons-for-elementor'),
			]
		);

		$repeater->add_control(
			'button_text',
			[
				'label' => __('Button Text', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::TEXT,
				'default' => __('Read More', 'royal-addons-for-elementor'),
				'placeholder' => __('Button Text', 'royal-addons-for-elementor'),
				'dynamic' => [
					'active' => true,
				]
			]
		);

		$repeater->add_control(
			'button_link',
			[
				'label' => __('Button Link', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::URL,
				'placeholder' => 'https://happyaddons.com/',
				'default' => [
					'url' => '#',
					'is_external' => true,
					'nofollow' => true,
				],
				'dynamic' => [
					'active' => true,
				],
				'condition' => [
					'button_text!' => '',
				]
			]
		);
		$repeater->end_controls_tab();//Timeline Content Tab END

		//Timeline Style Tab
		$repeater->start_controls_tab(
			'tab_timeline_style_item',
			[
				'label' => __('Style', 'royal-addons-for-elementor'),
			]
		);

		$repeater->add_control(
			'single_icon_color',
			[
				'label' => __('Icon Color', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .royal-timeline-icon i' => 'color: {{VALUE}}',
					'{{WRAPPER}} {{CURRENT_ITEM}} .royal-timeline-icon svg' => 'fill: {{VALUE}}',
				],
				'condition' => [
					'icon_type' => 'icon'
				],
				'style_transfer' => true,
			]
		);

		$repeater->add_control(
			'single_icon_box_bg',
			[
				'label' => __('Icon box Background', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .royal-timeline-icon' => 'background: {{VALUE}}',
				],
				'style_transfer' => true,
			]
		);

		$repeater->add_control(
			'single_icon_box_border_bg',
			[
				'label' => __('Icon box border color', 'royal-addons-for-elementor'),
				'description' => __('Color will apply after set the border from style.', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .royal-timeline-icon' => 'border-color: {{VALUE}}',
				],
				'style_transfer' => true,
			]
		);

		$repeater->add_control(
			'single_icon_box_tree_color',
			[
				'label' => __('Icon box tree color', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .royal-timeline-tree' => 'background: {{VALUE}}',
				],
				'style_transfer' => true,
			]
		);

		$repeater->add_control(
			'single_accent_color',
			[
				'label' => __('Card Accent Color', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .royal-timeline-content::before' => 'background: {{VALUE}} !important;',
					'{{WRAPPER}} {{CURRENT_ITEM}} .royal-timeline-year' => 'color: {{VALUE}} !important;',
					'{{WRAPPER}} {{CURRENT_ITEM}} .royal-timeline-icon' => 'background: {{VALUE}} !important; border-color: #fff !important;',
					'{{WRAPPER}} {{CURRENT_ITEM}} .royal-timeline-node-ring' => 'background: {{VALUE}} !important;',
				],
				'style_transfer' => true,
			]
		);

		$repeater->add_responsive_control(
			'single_content_align',
			[
				'label' => __('Alignment', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __('Left', 'royal-addons-for-elementor'),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __('Center', 'royal-addons-for-elementor'),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => __('Right', 'royal-addons-for-elementor'),
						'icon' => 'eicon-text-align-right',
					],
					'justify' => [
						'title' => __('Justify', 'royal-addons-for-elementor'),
						'icon' => 'eicon-text-align-justify',
					],
				],
				'toggle' => true,
				'selectors' => [
					'{{WRAPPER}} .royal-timeline-wrap > {{CURRENT_ITEM}} .royal-timeline-content' => 'text-align: {{VALUE}}'
				],
				'style_transfer' => true,
			]
		);
		$repeater->end_controls_tab();//Timeline Style Tab END
		$repeater->end_controls_tabs();

		$this->add_control(
			'timeline_item',
			[
				'label' => __('Content List', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'icon_type' => 'icon',
						'icon' => [
							'value' => 'fas fa-flag',
							'library' => 'solid',
						],
						'image' => [
							'url' => Utils::get_placeholder_image_src(),
						],
						'time_style' => 'text',
						'time_text' => '1996',
						'badge_text' => __('Beginning', 'royal-addons-for-elementor'),
						'step_number' => '01',
						'title' => __('Foundation Laid', 'royal-addons-for-elementor'),
						'image_position' => 'before',
						'content' => '<p>' . __('Foundation laid in Tala, Satkhira by dedicated local youths with a mission for socio-economic empowerment.', 'royal-addons-for-elementor') . '</p>',
						'button_text' => '',
					],
					[
						'icon_type' => 'icon',
						'icon' => [
							'value' => 'fas fa-award',
							'library' => 'solid',
						],
						'image' => [
							'url' => Utils::get_placeholder_image_src(),
						],
						'time_style' => 'text',
						'time_text' => '1996',
						'badge_text' => __('Registration', 'royal-addons-for-elementor'),
						'step_number' => '02',
						'title' => __('Bureau Registration', 'royal-addons-for-elementor'),
						'image_position' => 'before',
						'content' => '<p>' . __('Attained official registration and recognition to initiate community welfare interventions.', 'royal-addons-for-elementor') . '</p>',
						'button_text' => '',
					],
					[
						'icon_type' => 'icon',
						'icon' => [
							'value' => 'fas fa-coins',
							'library' => 'solid',
						],
						'image' => [
							'url' => Utils::get_placeholder_image_src(),
						],
						'time_style' => 'text',
						'time_text' => '1999',
						'badge_text' => __('Microfinance', 'royal-addons-for-elementor'),
						'step_number' => '03',
						'title' => __('PKSF Funding & Growth', 'royal-addons-for-elementor'),
						'image_position' => 'before',
						'content' => '<p>' . __('Received initial microfinance funding to support credit interventions and sustainable livelihoods.', 'royal-addons-for-elementor') . '</p>',
						'button_text' => '',
					],
					[
						'icon_type' => 'icon',
						'icon' => [
							'value' => 'fas fa-globe',
							'library' => 'solid',
						],
						'image' => [
							'url' => Utils::get_placeholder_image_src(),
						],
						'time_style' => 'text',
						'time_text' => 'Present',
						'badge_text' => __('Today', 'royal-addons-for-elementor'),
						'step_number' => '04',
						'title' => __('Continuous Empowerment', 'royal-addons-for-elementor'),
						'image_position' => 'before',
						'content' => '<p>' . __('Continuously striving for the socio-economic empowerment of marginalized communities.', 'royal-addons-for-elementor') . '</p>',
						'button_text' => '',
					],
				],
				'title_field' => '{{{ title }}}',
			]
		);

		$this->end_controls_section();
	}

	protected function settings_content_controls() {

		$this->start_controls_section(
			'_section_timeline_settings',
			[
				'label' => __('Settings', 'royal-addons-for-elementor'),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'timeline_style',
			[
				'label' => __('Timeline Style', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::SELECT,
				'default' => 'style-1',
				'options' => [
					'style-1' => __('Style 1 - Classic Bubble', 'royal-addons-for-elementor'),
					'style-2' => __('Style 2 - Journey & Milestones (Unnayan Style)', 'royal-addons-for-elementor'),
					'style-3' => __('Style 3 - Modern Clean Card', 'royal-addons-for-elementor'),
					'style-4' => __('Style 4 - Glassmorphism & Gradient', 'royal-addons-for-elementor'),
					'style-5' => __('Style 5 - Minimalist Numbered Badge', 'royal-addons-for-elementor'),
				],
				'prefix_class' => 'royal-timeline-',
			]
		);

		$this->add_control(
			'show_date',
			[
				'label' => __('Show Date?', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __('Show', 'royal-addons-for-elementor'),
				'label_off' => __('Hide', 'royal-addons-for-elementor'),
				'return_value' => 'yes',
				'default' => 'yes',
				'style_transfer' => true,
			]
		);

		$this->add_control(
			'show_time',
			[
				'label' => __('Show Time?', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __('Show', 'royal-addons-for-elementor'),
				'label_off' => __('Hide', 'royal-addons-for-elementor'),
				'return_value' => 'yes',
				'default' => '',
				'style_transfer' => true,
			]
		);

		$this->add_control(
			'show_content_arrow',
			[
				'label' => __('Show Content Arrow?', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __('Show', 'royal-addons-for-elementor'),
				'label_off' => __('Hide', 'royal-addons-for-elementor'),
				'return_value' => 'yes',
				'default' => 'yes',
				'style_transfer' => true,
				'condition' => [
					'timeline_style' => 'style-1',
				],
			]
		);

		$this->add_control(
			'enable_scroll_reveal',
			[
				'label' => __('Scroll Reveal Animation', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'royal-addons-for-elementor'),
				'label_off' => __('No', 'royal-addons-for-elementor'),
				'return_value' => 'yes',
				'default' => '',
				'description' => __('Smoothly reveal items as you scroll down.', 'royal-addons-for-elementor'),
				'condition' => [
					'timeline_style!' => 'style-1',
				],
			]
		);

		$this->add_control(
			'show_step_number',
			[
				'label' => __('Show Step Number', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __('Show', 'royal-addons-for-elementor'),
				'label_off' => __('Hide', 'royal-addons-for-elementor'),
				'return_value' => 'yes',
				'default' => 'yes',
				'condition' => [
					'timeline_style!' => 'style-1',
				],
			]
		);

		$this->add_control(
			'show_end_marker',
			[
				'label' => __('Show End Marker', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __('Show', 'royal-addons-for-elementor'),
				'label_off' => __('Hide', 'royal-addons-for-elementor'),
				'return_value' => 'yes',
				'default' => 'yes',
				'condition' => [
					'timeline_style!' => 'style-1',
				],
			]
		);

		$this->add_control(
			'end_marker_icon',
			[
				'label' => __('End Marker Icon', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-heart',
					'library' => 'solid',
				],
				'condition' => [
					'timeline_style!' => 'style-1',
					'show_end_marker' => 'yes',
				],
			]
		);

		$this->add_control(
			'end_marker_text',
			[
				'label' => __('End Marker Text', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::TEXT,
				'default' => __('The journey continues...', 'royal-addons-for-elementor'),
				'condition' => [
					'timeline_style!' => 'style-1',
					'show_end_marker' => 'yes',
				],
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$this->add_control(
			'end_marker_pulse',
			[
				'label' => __('End Icon Pulse Animation', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'royal-addons-for-elementor'),
				'label_off' => __('No', 'royal-addons-for-elementor'),
				'return_value' => 'yes',
				'default' => 'yes',
				'condition' => [
					'timeline_style!' => 'style-1',
					'show_end_marker' => 'yes',
				],
			]
		);

		$this->add_control(
			'title_tag',
			[
				'label' => __('Title Tag', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::CHOOSE,
				'default' => 'h2',
				'options' => [
					'h1' => [
						'title' => __('H1', 'royal-addons-for-elementor'),
						'icon' => 'eicon-editor-h1'
					],
					'h2' => [
						'title' => __('H2', 'royal-addons-for-elementor'),
						'icon' => 'eicon-editor-h2'
					],
					'h3' => [
						'title' => __('H3', 'royal-addons-for-elementor'),
						'icon' => 'eicon-editor-h3'
					],
					'h4' => [
						'title' => __('H4', 'royal-addons-for-elementor'),
						'icon' => 'eicon-editor-h4'
					],
					'h5' => [
						'title' => __('H5', 'royal-addons-for-elementor'),
						'icon' => 'eicon-editor-h5'
					],
					'h6' => [
						'title' => __('H6', 'royal-addons-for-elementor'),
						'icon' => 'eicon-editor-h6'
					]
				],
				'toggle' => false,
			]
		);

		$this->add_control(
			'icon_box_align',
			[
				'label' => __('Icon Box Alignment', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'top' => [
						'title' => __('Top', 'royal-addons-for-elementor'),
						'icon' => 'eicon-v-align-top',
					],
					'center' => [
						'title' => __('Center', 'royal-addons-for-elementor'),
						'icon' => 'eicon-v-align-middle',
					],
					'bottom' => [
						'title' => __('Bottom', 'royal-addons-for-elementor'),
						'icon' => 'eicon-v-align-bottom',
					],
				],
				'toggle' => false,
				'default' => 'top',
				'prefix_class' => 'royal-timeline-icon-box-vertical-align-',
				'style_transfer' => true,
			]
		);

		$this->add_control(
			'tree_align',
			[
				'label' => __('Tree Alignment', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __('Left', 'royal-addons-for-elementor'),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __('Center', 'royal-addons-for-elementor'),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => __('Right', 'royal-addons-for-elementor'),
						'icon' => 'eicon-text-align-right',
					],
				],
				'default' => 'center',
				'toggle' => false,
				'prefix_class' => 'royal-timeline-align-',
				'style_transfer' => true,
			]
		);

		$this->add_control(
			'show_scroll_tree',
			[
				'label' => __('Show Scroll Tree?', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __('Show', 'royal-addons-for-elementor'),
				'label_off' => __('Hide', 'royal-addons-for-elementor'),
				'return_value' => 'yes',
				'default' => '',
				'style_transfer' => true,
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'scroll_tree_background',
				'label' => __('Background', 'royal-addons-for-elementor'),
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .royal-timeline-scroll-tree .royal-timeline-icon, {{WRAPPER}} .royal-timeline-tree-inner',
				'exclude' => [
					'image'
				],
				'condition' => [
					'show_scroll_tree' => 'yes'
				],
				'style_transfer' => true,
			]
		);

		$this->end_controls_section();
	}


	protected function __content_box_style_controls() {

		$this->start_controls_section(
			'_section_timeline_content_box_style',
			[
				'label' => __('Content Box', 'royal-addons-for-elementor'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'content_box_typography',
				'label' => __('Typography', 'royal-addons-for-elementor'),
				'global' => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_TEXT,
				  ],
		  
				'selector' => '{{WRAPPER}} .royal-timeline-content',
			]
		);

		$this->add_control(
			'content_box_color',
			[
				'label' => __('Color', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .royal-timeline-content' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'content_box_arrow_color',
			[
				'label' => __('Arrow Color', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					//Align center
					'(desktop){{WRAPPER}}.royal-timeline-align-center .royal-timeline-content.arrow::before' => 'border-left-color: {{VALUE}}',
					'(desktop){{WRAPPER}}.royal-timeline-align-center .royal-timeline-block:nth-child(even) .royal-timeline-content.arrow::before' => 'border-right-color: {{VALUE}}; border-left-color: transparent;',
					'(tablet){{WRAPPER}}.royal-timeline-align-center .royal-timeline-content.arrow::before' => 'border-right-color: {{VALUE}};border-left-color: transparent',
					'(tablet){{WRAPPER}}.royal-timeline-align-center .royal-timeline-block:nth-child(even) .royal-timeline-content.arrow::before' => 'border-right-color: {{VALUE}}; border-left-color: transparent;',
					'(mobile){{WRAPPER}}.royal-timeline-align-center .royal-timeline-content.arrow::before' => 'border-right-color: {{VALUE}};border-left-color: transparent',
					'(mobile){{WRAPPER}}.royal-timeline-align-center .royal-timeline-block:nth-child(even) .royal-timeline-content.arrow::before' => 'border-right-color: {{VALUE}}; border-left-color: transparent;',
					//Align Left
					'{{WRAPPER}}.royal-timeline-align-left .royal-timeline-content.arrow::before' => 'border-right-color: {{VALUE}}',
					//Align Right
					'(desktop){{WRAPPER}}.royal-timeline-align-right .royal-timeline-content.arrow::before' => 'border-left-color: {{VALUE}};border-right-color: transparent',
					'(tablet){{WRAPPER}}.royal-timeline-align-right .royal-timeline-content.arrow::before' => 'border-right-color: {{VALUE}};border-left-color: transparent',
					'(mobile){{WRAPPER}}.royal-timeline-align-right .royal-timeline-content.arrow::before' => 'border-right-color: {{VALUE}};border-left-color: transparent',
				],
				'condition' => [
					'show_content_arrow' => 'yes'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'background',
				'label' => __('Background', 'royal-addons-for-elementor'),
				'types' => ['classic', 'gradient', 'video'],
				'selector' => '{{WRAPPER}} .royal-timeline-content',
			]
		);

		$this->add_control(
			'content_bg_after', ['type' => Controls_Manager::DIVIDER,]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'content_box_border',
				'label' => __('Border', 'royal-addons-for-elementor'),
				'selector' => '{{WRAPPER}} .royal-timeline-content',
			]
		);

		$this->add_control(
			'content_border_after', ['type' => Controls_Manager::DIVIDER,]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'content_box_shadow',
				'label' => __('Box Shadow', 'royal-addons-for-elementor'),
				'selector' => '{{WRAPPER}} .royal-timeline-content',
			]
		);

		$this->add_responsive_control(
			'content_box_border_radius',
			[
				'label' => __('Border Radius', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .royal-timeline-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'content_box_padding',
			[
				'label' => __('Padding', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .royal-timeline-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'content_box_margin_bottom',
			[
				'label' => __('Margin Bottom', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 500,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .royal-timeline-content' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .royal-timeline-block:last-child .royal-timeline-content' => 'margin-bottom: 0;',
					'{{WRAPPER}}.royal-timeline-icon-box-vertical-align-center .royal-timeline-icon' => 'margin-top: calc(-{{SIZE}}{{UNIT}} / 2);',
					'{{WRAPPER}}.royal-timeline-icon-box-vertical-align-center .royal-timeline-block:last-child .royal-timeline-icon' => 'margin-top: 0;',
					'{{WRAPPER}}.royal-timeline-icon-box-vertical-align-bottom .royal-timeline-icon' => 'margin-top: -{{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.royal-timeline-icon-box-vertical-align-bottom .royal-timeline-block:last-child .royal-timeline-icon' => 'margin-top: 0;',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function __icon_box_style_controls() {

		$this->start_controls_section(
			'_section_timeline_icon_box_style',
			[
				'label' => __('Icon Box', 'royal-addons-for-elementor'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'icon_box_width',
			[
				'label' => __('Width', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 500,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .royal-timeline-icon' => 'width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .royal-timeline-block:nth-child(even) .royal-timeline-icon' => 'width: {{SIZE}}{{UNIT}};',
					//timeline align center -> content box width
					'(desktop){{WRAPPER}}.royal-timeline-align-center .royal-timeline-content' => 'width: calc(50% - (({{icon_box_width.SIZE || 48}}{{UNIT}}/2) + {{icon_box_space.SIZE || 30}}{{UNIT}}));',
					'(tablet){{WRAPPER}}.royal-timeline-align-center .royal-timeline-content' => 'width: calc(100% - (({{icon_box_width_tablet.SIZE || 40}}{{UNIT}}/2) + {{icon_box_space_tablet.SIZE || 35}}{{UNIT}}));',
					'(mobile){{WRAPPER}}.royal-timeline-align-center .royal-timeline-content' => 'width: calc(100% - (({{icon_box_width_mobile.SIZE || 40}}{{UNIT}}/2) + {{icon_box_space_mobile.SIZE || 35}}{{UNIT}}));',

					//timeline align left -> content box width
					'(desktop){{WRAPPER}}.royal-timeline-align-left .royal-timeline-content' => 'width: calc(100% - ({{icon_box_width.SIZE || 48}}{{UNIT}} + {{icon_box_space.SIZE || 30}}{{UNIT}} + {{icon_box_tree_space.SIZE || 110}}{{UNIT}}));',
					'(tablet){{WRAPPER}}.royal-timeline-align-left .royal-timeline-content' => 'width: calc(100% - ({{icon_box_width_tablet.SIZE || 40}}{{UNIT}} + {{icon_box_space_tablet.SIZE || 30}}{{UNIT}} + {{icon_box_tree_space_tablet.SIZE || 0}}{{UNIT}}));',
					'(mobile){{WRAPPER}}.royal-timeline-align-left .royal-timeline-content' => 'width: calc(100% - ({{icon_box_width_mobile.SIZE || 40}}{{UNIT}} + {{icon_box_space_mobile.SIZE || 30}}{{UNIT}} + {{icon_box_tree_space_mobile.SIZE || 0}}{{UNIT}}));',

					//timeline align right -> content box width
					'(desktop){{WRAPPER}}.royal-timeline-align-right .royal-timeline-content' => 'width: calc(100% - ({{icon_box_width.SIZE || 48}}{{UNIT}} + {{icon_box_space.SIZE || 30}}{{UNIT}} + {{icon_box_tree_space.SIZE || 110}}{{UNIT}}));',
					'(tablet){{WRAPPER}}.royal-timeline-align-right .royal-timeline-content' => 'width: calc(100% - ({{icon_box_width_tablet.SIZE || 40}}{{UNIT}} + {{icon_box_space_tablet.SIZE || 30}}{{UNIT}} + {{icon_box_tree_space_tablet.SIZE || 0}}{{UNIT}}));',
					'(mobile){{WRAPPER}}.royal-timeline-align-right .royal-timeline-content' => 'width: calc(100% - ({{icon_box_width_mobile.SIZE || 40}}{{UNIT}} + {{icon_box_space_mobile.SIZE || 30}}{{UNIT}} + {{icon_box_tree_space_mobile.SIZE || 0}}{{UNIT}}));',

				],
			]
		);

		$this->add_responsive_control(
			'icon_box_height',
			[
				'label' => __('Height', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 500,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .royal-timeline-icon' => 'height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .royal-timeline-block:nth-child(even) .royal-timeline-icon' => 'height: {{SIZE}}{{UNIT}};',
					//timeline content box arrow position
					'(desktop){{WRAPPER}}.royal-timeline-icon-box-vertical-align-top .royal-timeline-content.arrow::before' => 'top: calc(({{icon_box_height.SIZE}}{{UNIT}}/2) - 8px)',
					'(desktop){{WRAPPER}}.royal-timeline-icon-box-vertical-align-bottom .royal-timeline-content.arrow::before' => 'bottom: calc(({{icon_box_height.SIZE}}{{UNIT}}/2) - 8px)',
				],
			]
		);
		//Box Space
		$this->add_responsive_control(
			'icon_box_space',
			[
				'label' => __('Box Space', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
				],
				'selectors' => [
					//timeline align center -> box margin
					'(desktop){{WRAPPER}}.royal-timeline-align-center .royal-timeline-block .royal-timeline-icon-box' => 'margin-left: {{icon_box_space.SIZE || 30}}{{UNIT}};margin-right: 0;',
					'(desktop){{WRAPPER}}.royal-timeline-align-center .royal-timeline-block:nth-child(even) .royal-timeline-icon-box' => 'margin-left: 0;margin-right: {{icon_box_space.SIZE || 30}}{{UNIT}};',

					'(tablet){{WRAPPER}}.royal-timeline-align-center .royal-timeline-block .royal-timeline-icon-box' => 'margin-right: {{icon_box_space_tablet.SIZE || 35}}{{UNIT}};margin-left: 0;',
					'(tablet){{WRAPPER}}.royal-timeline-align-center .royal-timeline-block:nth-child(even) .royal-timeline-icon-box' => 'margin-left: 0;margin-right: {{icon_box_space_tablet.SIZE || 35}}{{UNIT}};',

					'(mobile){{WRAPPER}}.royal-timeline-align-center .royal-timeline-block .royal-timeline-icon-box' => 'margin-right: {{icon_box_space_mobile.SIZE || 35}}{{UNIT}};margin-left: 0;',
					'(mobile){{WRAPPER}}.royal-timeline-align-center .royal-timeline-block:nth-child(even) .royal-timeline-icon-box' => 'margin-left: 0;margin-right: {{icon_box_space_mobile.SIZE || 35}}{{UNIT}};',
				],
			]
		);
		//Box Tree Space
		$this->add_responsive_control(
			'icon_box_tree_space',
			[
				'label' => __('Tree Space', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
				],
				'condition' => ['tree_align!' => 'center'],
				'selectors' => [
					//timeline align left -> box margin
					'(desktop){{WRAPPER}}.royal-timeline-align-left .royal-timeline-block .royal-timeline-icon-box' => 'margin-right: {{icon_box_space.SIZE || 30}}{{UNIT}};margin-left: {{icon_box_tree_space.SIZE || 110}}{{UNIT}};',
					'(tablet){{WRAPPER}}.royal-timeline-align-left .royal-timeline-block .royal-timeline-icon-box' => 'margin-right: {{icon_box_space_tablet.SIZE || 30}}{{UNIT}};margin-left: {{icon_box_tree_space_tablet.SIZE || 0}}{{UNIT}};',
					'(mobile){{WRAPPER}}.royal-timeline-align-left .royal-timeline-block .royal-timeline-icon-box' => 'margin-right: {{icon_box_space_mobile.SIZE || 30}}{{UNIT}};margin-left: {{icon_box_tree_space_mobile.SIZE || 0}}{{UNIT}};',

					//timeline align right -> box margin
					'(desktop){{WRAPPER}}.royal-timeline-align-right .royal-timeline-block .royal-timeline-icon-box' => 'margin-left: {{icon_box_space.SIZE || 30}}{{UNIT}};margin-right: {{icon_box_tree_space.SIZE || 110}}{{UNIT}};',
					'(tablet){{WRAPPER}}.royal-timeline-align-right .royal-timeline-block .royal-timeline-icon-box' => 'margin-right: {{icon_box_space_tablet.SIZE || 30}}{{UNIT}};margin-left: {{icon_box_tree_space_tablet.SIZE || 0}}{{UNIT}};',
					'(mobile){{WRAPPER}}.royal-timeline-align-right .royal-timeline-block .royal-timeline-icon-box' => 'margin-right: {{icon_box_space_mobile.SIZE || 30}}{{UNIT}};margin-left: {{icon_box_tree_space_mobile.SIZE || 0}}{{UNIT}};',

				],
			]
		);

		$this->add_control(
			'icon_box_bg',
			[
				'label' => __('Background', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .royal-timeline-icon' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'icon_box_border_radius',
			[
				'label' => __('Border Radius', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .royal-timeline-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'icon_box_border',
				'label' => __('Icon box border', 'royal-addons-for-elementor'),
				'selector' => '{{WRAPPER}} .royal-timeline-icon',
			]
		);


		$this->add_control(
			'icon_color',
			[
				'label' => __('Icon Color', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .royal-timeline-icon i' => 'color: {{VALUE}}',
					'{{WRAPPER}} .royal-timeline-icon svg' => 'fill: {{VALUE}}',
				],
				'separator' => 'before'
			]
		);

		$this->add_responsive_control(
			'icon_box_tree_width',
			[
				'label' => __('Tree Width', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 20,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .royal-timeline-tree' => 'width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .royal-timeline-tree-inner' => 'width: {{SIZE}}{{UNIT}};',

				],
			]
		);

		$this->add_control(
			'icon_box_tree_color',
			[
				'label' => __('Tree color', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .royal-timeline-tree' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'icon_alt_bg',
			[
				'label' => __('Alt / Even Icon Background', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .royal-timeline-block.is-alt .royal-timeline-icon' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'node_ring_color',
			[
				'label' => __('Node Pulse Ring Color', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .royal-timeline-node-ring' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'node_ring_alt_color',
			[
				'label' => __('Alt Pulse Ring Color', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .royal-timeline-block.is-alt .royal-timeline-node-ring' => 'background: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function __title_style_controls() {

		$this->start_controls_section(
			'_section_timeline_title_style',
			[
				'label' => __('Title', 'royal-addons-for-elementor'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'label' => __('Typography', 'royal-addons-for-elementor'),
				'global' => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_PRIMARY,
				  ],
				'selector' => '{{WRAPPER}} .royal-timeline-title',
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => __('Color', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .royal-timeline-title' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'title_margin',
			[
				'label' => __('Margin', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .royal-timeline-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function __time_date_style_controls() {

		$this->start_controls_section(
			'_section_timeline_time_date_style',
			[
				'label' => __('Time & Date', 'royal-addons-for-elementor'),
				'tab' => Controls_Manager::TAB_STYLE,
				'conditions' => [
					'terms' => [
						[
							'relation' => 'or',
							'terms' => [
								[
									'name' => 'show_date',
									'operator' => '==',
									'value' => 'yes',
								],
								[
									'name' => 'show_time',
									'operator' => '==',
									'value' => 'yes',
								]
							],
						],
					],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'date_typography',
				'label' => __('Date Typography', 'royal-addons-for-elementor'),
				'global' => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_TEXT,
				],		  
				'selector' => '{{WRAPPER}} .royal-timeline-date .date, {{WRAPPER}} .royal-timeline-year',
				'condition' => [
					'show_date' => 'yes'
				]
			]
		);

		$this->add_responsive_control(
			'date_color',
			[
				'label' => __('Date Color', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::COLOR,
				'devices' => ['desktop', 'tablet', 'mobile'],
				'selectors' => [
					'{{WRAPPER}} .royal-timeline-date .date, {{WRAPPER}} .royal-timeline-year' => 'color: {{VALUE}}',
				],
				'condition' => [
					'show_date' => 'yes'
				]
			]
		);

		// $this->add_responsive_control(
		// 	'date_color',
		// 	[
		// 		'label' => __('Date Color', 'royal-addons-for-elementor'),
		// 		'type' => Controls_Manager::COLOR,
		// 		'devices' => ['tablet'],
		// 		'selectors' => [
		// 			'{{WRAPPER}} .royal-timeline-date .date' => 'color: {{VALUE}}',
		// 		],
		// 		'condition' => [
		// 			'show_date' => 'yes'
		// 		]
		// 	]
		// );

		// $this->add_responsive_control(
		// 	'date_color',
		// 	[
		// 		'label' => __('Date Color', 'royal-addons-for-elementor'),
		// 		'type' => Controls_Manager::COLOR,
		// 		'devices' => ['mobile'],
		// 		'selectors' => [
		// 			'{{WRAPPER}} .royal-timeline-date .date' => 'color: {{VALUE}}',
		// 		],
		// 		'condition' => [
		// 			'show_date' => 'yes'
		// 		]
		// 	]
		// );

		$this->add_responsive_control(
			'date_margin',
			[
				'label' => __('Date Margin', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .royal-timeline-date .date' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'show_date' => 'yes'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'time_typography',
				'label' => __('Time Typography', 'royal-addons-for-elementor'),
				'global' => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_TEXT,
				],	
				'selector' => '{{WRAPPER}} .royal-timeline-date .time, {{WRAPPER}} .royal-timeline-card-time',
				'condition' => [
					'show_time' => 'yes'
				]
			]
		);

		$this->add_responsive_control(
			'time_color',
			[
				'label' => __('Time Color', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::COLOR,
				'devices' => ['desktop', 'tablet', 'mobile'],
				'selectors' => [
					'{{WRAPPER}} .royal-timeline-date .time, {{WRAPPER}} .royal-timeline-card-time' => 'color: {{VALUE}}',
				],
				'condition' => [
					'show_time' => 'yes'
				]
			]
		);

		// $this->add_responsive_control(
		// 	'time_color',
		// 	[
		// 		'label' => __('Time Color', 'royal-addons-for-elementor'),
		// 		'type' => Controls_Manager::COLOR,
		// 		'devices' => ['tablet'],
		// 		'selectors' => [
		// 			'{{WRAPPER}} .royal-timeline-date .time' => 'color: {{VALUE}}',
		// 		],
		// 		'condition' => [
		// 			'show_time' => 'yes'
		// 		]
		// 	]
		// );

		// $this->add_responsive_control(
		// 	'time_color',
		// 	[
		// 		'label' => __('Time Color', 'royal-addons-for-elementor'),
		// 		'type' => Controls_Manager::COLOR,
		// 		'devices' => ['mobile'],
		// 		'selectors' => [
		// 			'{{WRAPPER}} .royal-timeline-date .time' => 'color: {{VALUE}}',
		// 		],
		// 		'condition' => [
		// 			'show_time' => 'yes'
		// 		]
		// 	]
		// );

		$this->add_responsive_control(
			'time_margin',
			[
				'label' => __('Time Margin', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .royal-timeline-date .time' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'show_time' => 'yes'
				]
			]
		);

		$this->end_controls_section();
	}

	protected function __button_style_controls() {

		$this->start_controls_section(
			'_section_timeline_button_style',
			[
				'label' => __('Button', 'royal-addons-for-elementor'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'button_typography',
				'label' => __('Typography', 'royal-addons-for-elementor'),
				'global' => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_ACCENT,
				],
				'selector' => '{{WRAPPER}} .royal-timeline-button',
			]
		);

		$this->start_controls_tabs(
			'button_tabs'
		);
		$this->start_controls_tab(
			'button_normal_tab',
			[
				'label' => __('Normal', 'royal-addons-for-elementor'),
			]
		);
		$this->add_control(
			'button_color',
			[
				'label' => __('Color', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .royal-timeline-button' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'button_background',
				'label' => __('Background', 'royal-addons-for-elementor'),
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .royal-timeline-button',
			]
		);
		$this->end_controls_tab();//Button Normal Tab END

		$this->start_controls_tab(
			'button_hover_tab',
			[
				'label' => __('Hover', 'royal-addons-for-elementor'),
			]
		);
		$this->add_control(
			'button_hover_color',
			[
				'label' => __('Color', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .royal-timeline-button:hover' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'button_hover_background',
				'label' => __('Background', 'royal-addons-for-elementor'),
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .royal-timeline-button:hover',
			]
		);
		$this->end_controls_tab(); //Button Hover Tab END
		$this->end_controls_tabs();

		$this->add_responsive_control(
			'button_border_radius',
			[
				'label' => __('Border Radius', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .royal-timeline-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'button_padding',
			[
				'label' => __('Padding', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .royal-timeline-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'button_margin',
			[
				'label' => __('Margin', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .royal-timeline-button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function __milestone_badge_style_controls() {
		$this->start_controls_section(
			'_section_milestone_badge_style',
			[
				'label' => __('Milestone Badge / Chip', 'royal-addons-for-elementor'),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'timeline_style!' => 'style-1',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'badge_typography',
				'label' => __('Typography', 'royal-addons-for-elementor'),
				'selector' => '{{WRAPPER}} .royal-timeline-chip',
			]
		);

		$this->add_control(
			'badge_color',
			[
				'label' => __('Badge Color', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .royal-timeline-chip' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'badge_bg',
			[
				'label' => __('Badge Background', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .royal-timeline-chip' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'badge_alt_heading',
			[
				'label' => __('Alternate / Even Badge', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'badge_alt_color',
			[
				'label' => __('Alt Badge Color', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .royal-timeline-block.is-alt .royal-timeline-chip' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'badge_alt_bg',
			[
				'label' => __('Alt Badge Background', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .royal-timeline-block.is-alt .royal-timeline-chip' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'badge_border_radius',
			[
				'label' => __('Border Radius', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .royal-timeline-chip' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'badge_padding',
			[
				'label' => __('Padding', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .royal-timeline-chip' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function __step_number_style_controls() {
		$this->start_controls_section(
			'_section_step_number_style',
			[
				'label' => __('Step Number / Watermark', 'royal-addons-for-elementor'),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'timeline_style!' => 'style-1',
					'show_step_number' => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'step_number_typography',
				'label' => __('Typography', 'royal-addons-for-elementor'),
				'selector' => '{{WRAPPER}} .royal-timeline-step-no',
			]
		);

		$this->add_control(
			'step_number_color',
			[
				'label' => __('Color', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .royal-timeline-step-no' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'step_number_alt_color',
			[
				'label' => __('Alt / Even Step Color', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .royal-timeline-block.is-alt .royal-timeline-step-no' => 'color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function __end_marker_style_controls() {
		$this->start_controls_section(
			'_section_end_marker_style',
			[
				'label' => __('End Marker', 'royal-addons-for-elementor'),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'timeline_style!' => 'style-1',
					'show_end_marker' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'end_marker_icon_size',
			[
				'label' => __('Icon Size', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 12,
						'max' => 60,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .royal-timeline-end-icon' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .royal-timeline-end-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'end_marker_icon_color',
			[
				'label' => __('Icon Color', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .royal-timeline-end-icon' => 'color: {{VALUE}};',
					'{{WRAPPER}} .royal-timeline-end-icon svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'end_marker_icon_bg',
			[
				'label' => __('Icon Background', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .royal-timeline-end-icon' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'end_marker_text_color',
			[
				'label' => __('Text Color', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .royal-timeline-end-text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'end_marker_text_typography',
				'label' => __('Text Typography', 'royal-addons-for-elementor'),
				'selector' => '{{WRAPPER}} .royal-timeline-end-text',
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$timeline_style = !empty($settings['timeline_style']) ? $settings['timeline_style'] : 'style-1';

		$this->add_render_attribute('timeline-wrap', 'class', [
			'royal-timeline-wrap',
			'royal-timeline-' . $timeline_style,
		]);

		if ('yes' === $settings['show_scroll_tree'] || ('style-1' !== $timeline_style)) {
			$this->add_render_attribute('timeline-wrap', 'data-scroll', 'yes');
		}

		if ('style-1' !== $timeline_style && 'yes' === $settings['enable_scroll_reveal']) {
			$this->add_render_attribute('timeline-wrap', 'data-reveal', 'yes');
		}
		?>
		<div <?php echo $this->get_render_attribute_string('timeline-wrap'); ?>>
		<?php if ('style-1' !== $timeline_style): ?>
			<div class="royal-timeline-central-rail">
				<span class="royal-timeline-central-fill"></span>
			</div>
		<?php endif; ?>
		<?php if (!empty($settings['timeline_item'])):
			$total_items = count($settings['timeline_item']);
			foreach ($settings['timeline_item'] as $key => $item):
				$is_even = ($key % 2 !== 0);
				$is_last = ($key === $total_items - 1);

				$block_classes = [
					'royal-timeline-block',
					'elementor-repeater-item-' . esc_attr($item['_id']),
				];
				if ($is_even) {
					$block_classes[] = 'royal-timeline-block-even is-alt';
				} else {
					$block_classes[] = 'royal-timeline-block-odd';
				}
				if ($is_last) {
					$block_classes[] = 'is-last';
				}
				if ('style-1' !== $timeline_style && 'yes' === $settings['enable_scroll_reveal']) {
					$block_classes[] = 'royal-timeline-reveal';
				}

				$block_key = 'timeline-block-' . $key;
				$this->set_render_attribute($block_key, 'class', $block_classes);
				$this->set_render_attribute($block_key, 'data-step', esc_attr($key + 1));

				// Date & Time
				$date = '';
				if ('calender' === $item['time_style'] && !empty($item['time'])) {
					$date = date("d M Y", strtotime($item['time']));
				} elseif ('text' === $item['time_style'] && !empty($item['time_text'])) {
					$date = $item['time_text'];
				}
				$time = ('calender' === $item['time_style'] && !empty($item['time'])) ? date("g:i a", strtotime($item['time'])) : '';

				// Step Number
				$step_no = !empty($item['step_number']) ? $item['step_number'] : sprintf('%02d', $key + 1);

				// Badge / Chip
				$badge_text = !empty($item['badge_text']) ? $item['badge_text'] : '';

				// Title
				$title_key = $this->get_repeater_setting_key('title', 'timeline_item', $key);
				$this->add_inline_editing_attributes($title_key, 'none');
				$this->add_render_attribute($title_key, 'class', 'royal-timeline-title');

				// Content Box
				$content_box_key = 'content-box-' . $key;
				$content_box_classes = ['royal-timeline-content'];
				if ('style-1' === $timeline_style && 'yes' === $settings['show_content_arrow']) {
					$content_box_classes[] = 'arrow';
				}
				$this->set_render_attribute($content_box_key, 'class', $content_box_classes);

				// Content text
				$content_key = $this->get_repeater_setting_key('content', 'timeline_item', $key);
				$this->add_inline_editing_attributes($content_key, 'advanced');
				$this->add_render_attribute($content_key, 'class', 'royal-timeline-content-text');

				// Button
				$button_key = $this->get_repeater_setting_key('button_text', 'timeline_item', $key);
				if (!empty($item['button_text'])) {
					$this->add_inline_editing_attributes($button_key, 'none');
					$this->add_render_attribute($button_key, 'class', 'royal-timeline-button');
					$this->add_link_attributes($button_key, $item['button_link']);
				}
				?>
				<div <?php echo $this->get_render_attribute_string($block_key); ?>>
					<div class="royal-timeline-icon-box align-center">
						<div class="royal-timeline-icon">
							<?php if ('style-1' !== $timeline_style): ?>
								<span class="royal-timeline-node-ring"></span>
							<?php endif; ?>
							<?php
							if ('icon' == $item['icon_type'] && !empty($item['icon'])) {
								\Elementor\Icons_Manager::render_icon( $item['icon'], [ 'aria-hidden' => 'true' ] );
							} elseif ('image' == $item['icon_type'] && !empty($item['image'])) {
								echo Group_Control_Image_Size::get_attachment_image_html($item, 'thumbnail', 'image');
							}
							?>
							<?php if ('style-1' === $timeline_style && ($date || $time) && ($settings['show_date'] || $settings['show_time'])): ?>
								<span class="royal-timeline-date royal-timeline-date-desktop">
									<?php
									if ($date && $settings['show_date']) {
										printf('<span class="date">%s</span>', esc_html($date));
									}
									if ($time && $settings['show_time']) {
										printf('<span class="time">%s</span>', esc_html($time));
									}
									?>
								</span>
							<?php endif; ?>
						</div>
						<div class="royal-timeline-tree">
							<?php if ('style-1' === $timeline_style && 'yes' === $settings['show_scroll_tree']): ?>
								<div class="royal-timeline-tree-inner"></div>
							<?php endif; ?>
						</div>
					</div>

					<div <?php echo $this->get_render_attribute_string($content_box_key); ?>>
						<?php if ('style-1' === $timeline_style && ($date || $time) && ($settings['show_date'] || $settings['show_time'])): ?>
							<span class="royal-timeline-date royal-timeline-date-tablet">
								<?php
								if ($date && $settings['show_date']) {
									printf('<span class="date">%s</span>', esc_html($date));
								}
								if ($time && $settings['show_time']) {
									printf('<span class="time">%s</span>', esc_html($time));
								}
								?>
							</span>
						<?php endif; ?>

						<?php if ('style-1' !== $timeline_style): ?>
							<div class="royal-timeline-card-top">
								<?php if ($date && $settings['show_date']): ?>
									<span class="royal-timeline-year"><?php echo esc_html($date); ?></span>
								<?php endif; ?>
								<?php if ($time && $settings['show_time']): ?>
									<span class="royal-timeline-card-time"><?php echo esc_html($time); ?></span>
								<?php endif; ?>
								<?php if (!empty($badge_text)): ?>
									<span class="royal-timeline-chip"><?php echo esc_html($badge_text); ?></span>
								<?php endif; ?>
							</div>
						<?php endif; ?>

						<?php
						if (!empty($item['gallery']) && 'before' == $item['image_position']) {
							echo '<figure class="royal-timeline-images before">';
							foreach ($item['gallery'] as $id => $single) {
								echo wp_get_attachment_image(
									$single['id'],
									$item['thumbnail_size'],
									false,
									[
										'alt' => wp_get_attachment_caption($single['id'])
									]
								);
							}
							echo '</figure>';
						}

						if (!empty($item['title'])) {
							$title_tag = !empty($settings['title_tag']) ? $settings['title_tag'] : 'h2';
							printf('<%1$s %2$s>%3$s</%1$s>', esc_attr($title_tag), $this->get_render_attribute_string($title_key), wp_kses_post($item['title']));
						}

						if (!empty($item['content'])) {
							printf('<div %s>%s</div>', $this->get_render_attribute_string($content_key), $this->parse_text_editor($item['content']));
						}

						if (!empty($item['gallery']) && 'after' == $item['image_position']) {
							echo '<figure class="royal-timeline-images after">';
							foreach ($item['gallery'] as $id => $single) {
								echo wp_get_attachment_image(
									$single['id'],
									$item['thumbnail_size'],
									false,
									[
										'alt' => wp_get_attachment_caption($single['id'])
									]
								);
							}
							echo '</figure>';
						}

						if (!empty($item['button_text'])) {
							printf('<a %s>%s</a>', $this->get_render_attribute_string($button_key), esc_html($item['button_text']));
						}

						if ('style-1' !== $timeline_style && 'yes' === $settings['show_step_number']) {
							printf('<span class="royal-timeline-step-no">%s</span>', esc_html($step_no));
						}
						?>
					</div>
				</div>
			<?php endforeach;
		endif; ?>

		<?php if ('style-1' !== $timeline_style && 'yes' === $settings['show_end_marker']): ?>
			<div class="royal-timeline-end royal-timeline-reveal">
				<span class="royal-timeline-end-icon <?php echo ('yes' === $settings['end_marker_pulse']) ? 'has-pulse' : ''; ?>">
					<?php
					if (!empty($settings['end_marker_icon']['value'])) {
						\Elementor\Icons_Manager::render_icon($settings['end_marker_icon'], ['aria-hidden' => 'true']);
					} else {
						echo '<i class="fas fa-heart" aria-hidden="true"></i>';
					}
					?>
				</span>
				<?php if (!empty($settings['end_marker_text'])): ?>
					<p class="royal-timeline-end-text"><?php echo esc_html($settings['end_marker_text']); ?></p>
				<?php endif; ?>
			</div>
		<?php endif; ?>
		</div>
		<?php
	}
}
