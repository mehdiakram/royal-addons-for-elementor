<?php
namespace RoyalAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Scheme_Color;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
if (!defined('ABSPATH')) exit; // Exit if accessed directly


class RoyalDomainSearch extends Widget_Base {

	public function get_name() {
		return 'royaldomainsearch';
	}


	public function get_title() {
		return __( 'Domain Search', 'royal-addons-for-elementor' );
	}


	public function get_icon() { return 'eicon-site-search rtbranding'; }


	public function get_keywords() {
		return [ 'domain', 'supersite', 'reseller club', 'resell', 'tech', 'technologies', 'royal',  'mehdi',  'akram'];
	}


	public function get_categories() {
		return [ 'royaltech' ];
	}


	public function get_style_depends() {
		$styles = ['royaldomainsearch'];
		return $styles;
	}

	
	protected function register_controls() {
		$this->start_controls_section(
			'domaincontent',
			[
				'label' => __( 'Search Seetings', 'royal-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'search_link',
			[
				'label' => esc_html__( 'Domain Search Link', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::URL,
				'options' => [ 'url', 'is_external'],
				'default' => [
					'url' => 'https://royal-addons-for-elementorbd.supersite2.srsportal.com/domain-registration/index.php',
					'is_external' => true,
				],
				'label_block' => true,
			]
		);

		$this->add_control(
			'wwwtext',
			[
			  'label' => esc_html__( 'WWW Text', 'royal-addons-for-elementor' ),
			  'type' => \Elementor\Controls_Manager::TEXT,
			  'default' => 'www.',
			]
		);

		$this->add_control(
			'show_tldlist',
			[
				'label' => esc_html__( 'Show TLD', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'royal-addons-for-elementor' ),
				'label_off' => esc_html__( 'Hide', 'royal-addons-for-elementor' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);
		$this->add_control(
			'alltext',
			[
			  'label' => esc_html__( 'All TLD Text', 'royal-addons-for-elementor' ),
			  'type' => \Elementor\Controls_Manager::TEXT,
			  'default' => esc_html__( 'All', 'royal-addons-for-elementor' ),
			  'condition' => [
				'show_tldlist' => 'yes',
			],
			]
		  );

		$repeater = new \Elementor\Repeater();
		$repeater->add_control(
		  'tld',
		  [
			'label' => esc_html__( 'TLD (without .)', 'royal-addons-for-elementor' ),
			'type' => \Elementor\Controls_Manager::TEXT,
			'placeholder' => esc_html__( 'tld', 'royal-addons-for-elementor' ),
			'default' => esc_html__( 'com', 'royal-addons-for-elementor' ),
		  ]
		);
	
		$this->add_control(
		  'tldlist',
		  [
			'label' => __( 'TLD List', 'royal-addons-for-elementor' ),
			'type' => Controls_Manager::REPEATER,
			'fields' => $repeater->get_controls(),
			'condition' => [
				'show_tldlist' => 'yes',
			],
			'default' => [
				[
					'tld' => esc_html__( 'com', 'royal-addons-for-elementor' ),
				],
				[
					'tld' => esc_html__( 'org', 'royal-addons-for-elementor' ),
				],
				[
					'tld' => esc_html__( 'net', 'royal-addons-for-elementor' ),
				],
				[
					'tld' => esc_html__( 'info', 'royal-addons-for-elementor' ),
				],
				[
					'tld' => esc_html__( 'me', 'royal-addons-for-elementor' ),
				],
			],
			'title_field' => '{{{ tld }}}',
		  ]
		);

		$this->add_control(
			'button_type',
			[
				'label' => esc_html__( 'Button Type', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'icon',
				'options' => [
					'icon' => esc_html__( 'Iocn', 'textdomain' ),
					'text' => esc_html__( 'Text', 'textdomain' ),
				],
			]
		);

		$this->add_control(
			'button_icon',
			[
				'label' => esc_html__( 'Icon', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::ICONS,
				'skin' => 'inline',
			  	'label_block' => false,  
				'condition' => [
					'button_type' => 'icon',
				],				
				'default' => [
					'value' => 'fas fa-search',
					'library' => 'fa-solid',
				],
			]
		);

		$this->add_control(
			'button_text',
			[
			  'label' => esc_html__( 'Button Text', 'royal-addons-for-elementor' ),
			  'type' => \Elementor\Controls_Manager::TEXT,
			  'default' => esc_html__( 'Search', 'royal-addons-for-elementor' ),
			  'condition' => [
				'button_type' => 'text',
				],
			]
		  );		
		$this->end_controls_section();

	
		
		$this->start_controls_section(
			'style_section_www',
			[
			  'label' => __( 'WWW Style', 'royal-addons-for-elementor' ),
			  'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'typography_www',
				'selector' => '{{WRAPPER}} .royaldomainsearch form .www',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'border',
				'selector' => '{{WRAPPER}} .royaldomainsearch form .www',
			]
		);

		$this->add_control(
            'border_radius_www',
            [
                'label' => __( 'Border Radius', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
				'default'   => [
                    'top' => '45',
                    'right' => '0',
                    'bottom' => '0',
                    'left' => '45',
                    'unit' => 'px',
                    'isLinked' => false,
                ],
                'selectors' => [
                    '{{WRAPPER}} .royaldomainsearch form .www' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

		$this->add_responsive_control(
			'width_www',
			[
				'label' => esc_html__( 'Width', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 100,
				],
				'selectors' => [
					'{{WRAPPER}} .royaldomainsearch form .www' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'height_www',
			[
				'label' => esc_html__( 'Height', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 60,
				],
				'selectors' => [
					'{{WRAPPER}} .royaldomainsearch form .www' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'color_www',
			[
				'label' => __( 'Color', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#000',
				'separator' => 'none',
				'selectors' => [
					'{{WRAPPER}} .royaldomainsearch form .www' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'background_www',
			[
				'label' => __( 'Background', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'separator' => 'none',
				'selectors' => [
					'{{WRAPPER}} .royaldomainsearch form .www' => 'background: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();


		$this->start_controls_section(
			'style_section_input',
			[
			  'label' => __( 'Input Style', 'royal-addons-for-elementor' ),
			  'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'input_border',
				'selector' => '{{WRAPPER}} .royaldomainsearch form input[type="text"]',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'typography_input',
				'selector' => '{{WRAPPER}} .royaldomainsearch form input[type="text"]',
			]
		);

		$this->add_responsive_control(
			'width_input',
			[
				'label' => esc_html__( 'Width', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 250,
				],
				'selectors' => [
					'{{WRAPPER}} .royaldomainsearch form input[type="text"]' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'height_input',
			[
				'label' => esc_html__( 'Height', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 60,
				],
				'selectors' => [
					'{{WRAPPER}} .royaldomainsearch form input[type="text"]' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'color_input',
			[
				'label' => __( 'Color', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#8b8b8b',
				'separator' => 'none',
				'selectors' => [
					'{{WRAPPER}} .royaldomainsearch input[type="text"]' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'background_input',
			[
				'label' => __( 'Background', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'separator' => 'none',
				'selectors' => [
					'{{WRAPPER}} .royaldomainsearch input[type="text"]' => 'background: {{VALUE}};',
				],
			]
		);
		$this->end_controls_section();


		$this->start_controls_section(
			'style_section_select',
			[
			  'label' => __( 'Select Style', 'royal-addons-for-elementor' ),
			  'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			  'condition' => [
				'show_tldlist' => 'yes',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'typography_select',
				'selector' => '{{WRAPPER}} .royaldomainsearch select',
			]
		);
		

		$this->add_responsive_control(
			'height_select',
			[
				'label' => esc_html__( 'Height', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 60,
				],
				'selectors' => [
					'{{WRAPPER}} .royaldomainsearch form select' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'color_select',
			[
				'label' => __( 'Color', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#000',
				'separator' => 'none',
				'selectors' => [
					'{{WRAPPER}} .royaldomainsearch select' => 'color: {{VALUE}};',
				],
			]
		);		

		$this->add_control(
			'background_select',
			[
				'label' => __( 'Background', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'separator' => 'none',
				'selectors' => [
					'{{WRAPPER}} .royaldomainsearch select' => 'background: {{VALUE}};',
				],
			]
		);		

		$this->end_controls_section();

		$this->start_controls_section(
			'style_section_button',
			[
			  'label' => __( 'Button Style', 'royal-addons-for-elementor' ),
			  'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'typography_button',
				'condition' => [
					'button_type' => 'text',
				],
				'selector' => '{{WRAPPER}} .royaldomainsearch form button',
			]
		);
		
		$this->add_responsive_control(
			'icon_size',
			[
				'label' => esc_html__( 'Icon Size', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 32,
				],				
				'condition' => [
					'button_type' => 'icon',
					'button_icon[value]!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .royaldomainsearch form button svg' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
            'border_radius_button',
            [
                'label' => __( 'Border Radius', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
				'default'   => [
                    'top' => '0',
                    'right' => '45',
                    'bottom' => '45',
                    'left' => '0',
                    'unit' => 'px',
                    'isLinked' => false,
                ],
                'selectors' => [
                    '{{WRAPPER}} .royaldomainsearch form button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

		$this->add_responsive_control(
			'width_button',
			[
				'label' => esc_html__( 'Width', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 120,
				],
				'selectors' => [
					'{{WRAPPER}} .royaldomainsearch form button' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'height_button',
			[
				'label' => esc_html__( 'Height', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 60,
				],
				'selectors' => [
					'{{WRAPPER}} .royaldomainsearch form button' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs(
			'button_style_tabs'
		);

		$this->start_controls_tab(
			'button_style_normal_tab',
			[
				'label' => esc_html__( 'Normal', 'royal-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'icon_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Icon Color', 'royal-addons-for-elementor' ),
				'default' 	=> '#ffffff',
				'condition' => [
					'button_type' => 'icon',
					'button_icon[value]!' => '',
				],			
				'selectors' => [
					'{{WRAPPER}} .royaldomainsearch form button svg' => 'fill: {{VALUE}};',
				],
			]
		);	

		$this->add_control(
			'button_background_normal',
			[
				'label' => __( 'Background', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#008bff',
				'separator' => 'none',
				'selectors' => [
					'{{WRAPPER}} .royaldomainsearch form button' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'style_hover_tab',
			[
				'label' => esc_html__( 'Hover', 'royal-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'icon_color_hover',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Icon Color', 'royal-addons-for-elementor' ),
				'default' 	=> '#ffffff',
				'condition' => [
					'button_type' => 'icon',
					'button_icon[value]!' => '',
				],			
				'selectors' => [
					'{{WRAPPER}} .royaldomainsearch form button:hover svg' => 'fill: {{VALUE}};',
				],
			]
		);	

		$this->add_control(
			'button_background_hover',
			[
				'label' => __( 'Background', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#458FCD',
				'separator' => 'none',
				'selectors' => [
					'{{WRAPPER}} .royaldomainsearch form button:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();	
	}


	protected function render() {
        $settings 		= $this->get_settings_for_display();
		$search_url 	= $settings['search_link']['url'];
		$show_tldlist 	= $settings['show_tldlist'];
		$wwwtext 		= $settings['wwwtext'];
		$alltext 		= $settings['alltext'];
		
		if ( $settings['search_link']['is_external'] == 'on') {
			$external = 'target="_blank"';
		} else {
			$external = 'target="_self"';
		}


		?>

		<div class="royaldomainsearch">
			<form <?php echo $external; ?> name=lookup method="post" action="<?php echo $search_url; ?>">
				<input type="hidden" name="action" value="check_availability">
				<span class="www"><?php echo $wwwtext; ?></span>
				<input name="txtDomainName" type="text" class="inputbox" size="22" maxlength="55" placeholder="Type your domain...">
				<?php if ($show_tldlist == 'yes'){ ?>
				<select name="tld[]">
				<option value="" selected><?php echo $alltext; ?></option>
				<?php foreach (  $settings['tldlist'] as $item ) { 
					echo '<option value="'. $item['tld'] .'">.'. $item['tld'] .'</option>';
				} ?>
				</select>
				<?php } 
				
				$this->render_icon(); ?>
			</form>
		</div>
		<?php
	}



	protected function render_icon() {
		$settings = $this->get_settings_for_display();

		if ( 'icon' === $settings['button_type'] ) {

			echo '<button type="submit" aria-label="Search domain">';

			if ( ! empty( $settings['button_icon']['value'] ) ) {
				\Elementor\Icons_Manager::render_icon(
					$settings['button_icon'],
					[
						'aria-hidden' => 'true',
					]
				);
			}

			echo '</button>';

		} elseif ( 'text' === $settings['button_type'] ) {

			echo '<button type="submit">';
			echo esc_html( $settings['button_text'] );
			echo '</button>';

		}
	}





}
