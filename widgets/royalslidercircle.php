<?php
namespace RoyalAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Icons_Manager;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use RoyalAddons\Traits\ProWidgetTrait;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class RoyalSliderCircle extends Widget_Base {
    use ProWidgetTrait;

    public function get_name() {
        return 'royalslidercircle';
    }

    public function get_title() {
        return __('Slider Circle [Pro]', 'royal-addons-for-elementor');
    }

    public function get_icon() { return 'eicon-slideshow rtbranding'; }

	public function get_keywords() {
		return [ 'circle', 'slider', 'pmage', 'service', 'tech', 'technologies', 'royal',  'mehdi',  'akram', 'pro'];
	}

    public function get_categories() {
        return ['royaltech'];
    }

    public function get_style_depends() {
        return ['royalslidercircle'];
    }

    public function get_script_depends() {
        return ['royalslidercircle'];
    }


    protected function register_controls() {
        $this->royal_section_settings();
        $this->royal_section_slider();
        $this->royal_section_style();
        $this->royal_section_content_style();
    }


    
    private function royal_section_settings() {
        $this->start_controls_section(
            'settings_section',
            [
                'label' => __('Settings', 'royal-addons-for-elementor'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_responsive_control(
			'circlesize',
			[
				'label'      => __( 'Circle Size', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [
					'px' => [
						'min'  => 100,
						'max'  => 1000,
						'step' => 1,
					],
					'%'  => [
						'min' => 5,
						'max' => 100,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => '600',
				],
				'selectors'  => [
					'{{WRAPPER}} .royalcircleslider' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

        $this->add_responsive_control(
			'roundsize',
			[
				'label'      => __( 'Round Size', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [
					'px' => [
						'min'  => 100,
						'max'  => 1000,
						'step' => 1,
					],
					'%'  => [
						'min' => 5,
						'max' => 100,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => '500',
				],
				'selectors'  => [
					'{{WRAPPER}} .royalcircleslider .round' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

        $this->add_control(
            'auto_rotate',
            [
                'label' => __('Auto Rotate', 'royal-addons-for-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'royal-addons-for-elementor'),
                'label_off' => __('No', 'royal-addons-for-elementor'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'rotate_speed',
            [
                'label' => __('Rotate Speed (ms)', 'royal-addons-for-elementor'),
                'type' => Controls_Manager::NUMBER,
                'default' => 5000,
                'min' => 1000,
                'max' => 20000,
                'step' => 500,
                'condition' => [
                    'auto_rotate' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'radius',
            [
                'label' => __('Radius (px)', 'royal-addons-for-elementor'),
                'type' => Controls_Manager::NUMBER,
                'default' => 200,
                'min' => 100,
                'max' => 500,
            ]
        );

        $this->add_control(
            'direction',
            [
                'label' => __('Rotation Direction', 'royal-addons-for-elementor'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'clockwise' => __('Clockwise', 'royal-addons-for-elementor'),
                    'counterclockwise' => __('Counter Clockwise', 'royal-addons-for-elementor'),
                ],
                'default' => 'clockwise',
            ]
        );

        $this->end_controls_section();

    }



    private function royal_section_slider() {
        $this->start_controls_section(
            'slider_section',
            [
                'label' => __('Slides', 'royal-addons-for-elementor'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'icon',
            [
                'label' => __('Icon', 'royal-addons-for-elementor'),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-star', // default icon (FontAwesome)
                    'library' => 'fa-solid',
                ],
            ]
        );
        $repeater->add_control(
            'title',
            [
                'label' => __('Title', 'royal-addons-for-elementor'),
                'type' => Controls_Manager::TEXT,
                'default' => 'Slide Title',
            ]
        );

        $repeater->add_control(
            'content',
            [
                'label' => __('Content', 'royal-addons-for-elementor'),
                'type' => Controls_Manager::TEXTAREA,
                'default' => 'Slide content goes here...',
            ]
        );

        $repeater->add_control(
            'image',
            [
                'label' => __('Image', 'royal-addons-for-elementor'),
                'type' => Controls_Manager::MEDIA,
            ]
        );

        $this->add_control(
            'slides',
            [
                'label' => __('Slides', 'royal-addons-for-elementor'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'title' => __('Automate', 'royal-addons-for-elementor'),
                        'content' => 'Description for Automate',
                    ],
                    [
                        'title' => __('Chat', 'royal-addons-for-elementor'),
                        'content' => 'Description for Chat',
                    ],
                    [
                        'title' => __('Responses', 'royal-addons-for-elementor'),
                        'content' => 'Description for Responses',
                    ],
                    [
                        'title' => __('Tags', 'royal-addons-for-elementor'),
                        'content' => 'Description for Tags',
                    ],
                    [
                        'title' => __('Sharing', 'royal-addons-for-elementor'),
                        'content' => 'Description for Sharing',
                    ],
                    [
                        'title' => __('Support', 'royal-addons-for-elementor'),
                        'content' => 'Description for Support',
                    ],
                ],
                'title_field' => '{{{ title }}}',
            ]
        );

        $this->end_controls_section();
    }


	private function royal_section_style() {

		$this->start_controls_section(
			'section_style',
			[
				'label' => __( 'Style', 'royal-addons-for-elementor'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'round_border',
                'separator' => 'before',
				'label' => esc_html__( 'Round Border', 'royal-addons-for-elementor' ),
				'selector' => '{{WRAPPER}} .royalcircleslider .round',
			]
		);

        $this->add_control(
			'foractive_color_before',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Dot Before Color', 'royal-addons-for-elementor' ),
				'default' => '#a733bb',
				'selectors' => [
					'{{WRAPPER}} .royalcircleslider .foractive::before' => 'border-color: {{VALUE}};',
				],
			]
		);
        
        $this->add_control(
			'foractive_color_after',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Dot After Color', 'royal-addons-for-elementor' ),
				'default' => '#7d4ac7',
				'selectors' => [
					'{{WRAPPER}} .royalcircleslider .foractive::after' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->start_controls_tabs( 'all_style' );

		$this->start_controls_tab(
			'style_normal',
			[
				'label'     => __( 'Normal', 'royal-addons-for-elementor' ),
			]
		);

        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'itemdot_background',
                'label' => __( 'Itemdot Background', 'royal-addons-for-elementor' ),
				'types' => [ 'classic', 'gradient'],
				'selector' => '{{WRAPPER}} .royalcircleslider .itemdot',
			]
		); 

        $this->add_control(
			'icon_color_normal',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Icon Color', 'royal-addons-for-elementor' ),
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .royalcircleslider .itemdot svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'style_hover',
			[
				'label'     => __( 'Hover', 'royal-addons-for-elementor' ),
			]
		);

        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'itemdot_active_background',
                'label' => __( 'Itemdot Active Background', 'royal-addons-for-elementor' ),
				'types' => [ 'classic', 'gradient'],
				'selector' => '{{WRAPPER}} .royalcircleslider .itemdot:hover, {{WRAPPER}} .royalcircleslider .itemdot.active',
			]
		); 

        $this->add_control(
			'icon_color_active',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Icon Color', 'royal-addons-for-elementor' ),
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .royalcircleslider .itemdot:hover svg' => 'fill: {{VALUE}};',
					'{{WRAPPER}} .royalcircleslider .itemdot.active svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();
        $this->end_controls_section();
    }




	private function royal_section_content_style() {

		$this->start_controls_section(
			'section_content_style',
			[
				'label' => __( 'Content', 'royal-addons-for-elementor'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

        $this->add_responsive_control(
			'contentsize',
			[
				'label'      => __( 'Content Size', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px'],
				'range'      => [
					'px' => [
						'min'  => 100,
						'max'  => 1000,
						'step' => 1,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => '250',
				],
				'selectors'  => [
					'{{WRAPPER}} .royalcircleslider .contentcircle' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
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

    $auto_rotate = $settings['auto_rotate'] === 'yes' ? '1' : '0';
    $speed = $settings['rotate_speed'];
    $radius = $settings['radius'];
    $direction = $settings['direction'];
    $slides = $settings['slides'];
    $slide_count = count($slides);

    // Add data attributes using add_render_attribute
    $this->add_render_attribute(
        'slider_wrapper',
        [
            'id' => 'royalcircleslider',
            'class' => 'royalcircleslider',
            'data-auto-rotate' => $auto_rotate,
            'data-speed' => $speed,
            'data-radius' => $radius,
            'data-direction' => $direction,
            'data-slide-count' => $slide_count,
        ]
    );
    ?>

    <div <?php echo $this->get_render_attribute_string('slider_wrapper'); ?>>
        <div class="holdercircle">
            <div class="round"></div>
            <div class="dotcircle">
                <?php foreach ($slides as $index => $slide):
                    $tab_index = $index + 1;
                ?>
                    <span class="itemdot itemdot<?php echo $tab_index; ?>" data-tab="<?php echo $tab_index; ?>">
                        <?php
                        if (!empty($slide['icon'])) {
                            \Elementor\Icons_Manager::render_icon($slide['icon'], ['aria-hidden' => 'true']);
                        }
                        ?>
                        <span class="foractive"></span>
                    </span>
                <?php endforeach; ?>
            </div>
            <div class="contentcircle">
                <?php foreach ($slides as $index => $slide):
                    $tab_index = $index + 1;
                ?>
                    <div class="ciritem title-box ciritem<?php echo $tab_index; ?>">
                        <h2 class="title"><span><?php echo esc_html($slide['title']); ?></span></h2>
                        <p><?php echo esc_html($slide['content']); ?></p>
                        <?php if (!empty($slide['image']['url'])): ?>
                            <img src="<?php echo esc_url($slide['image']['url']); ?>" alt="<?php echo esc_attr($slide['title']); ?>">
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

        <?php
    }
    



}
