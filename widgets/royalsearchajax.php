<?php
namespace RoyalAddons\Widgets;

// Elementor Classes
use Elementor\Controls_Manager;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Widget_Base;
use RoyalAddons\Traits\ProWidgetTrait;

if(! defined('ABSPATH')) exit; // Exit if accessed directly

class RoyalSearchAjax extends Widget_Base {
	use ProWidgetTrait;

    public function get_name() {
		return 'royalsearchajax';
	}

	public function get_title() {
		return __('Ajax Search [Pro]', 'royal-addons-for-elementor');
	}

	public function get_icon() { return 'eicon-search rtbranding'; }
	
	public function get_keywords() {
		return ['find', 'ajax', 'search', 'tech', 'technologies', 'royal',  'mehdi',  'akram', 'pro'];
	}
	
	public function get_categories() {
		return [ 'royaltech' ];
	}

	public function get_script_depends() {
		return [ 'royalsearchajax' ];
	}

	public function get_style_depends() {
		return [ 'royalsearchajax' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_search',
			[
				'label' 		=> __('Search', 'royal-addons-for-elementor'),
			]
		);
		
		$this->add_control(
			'source',
			[
				'label' => __( 'Source', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'any',
				'options' => \RoyalAddons\Elementor\RoyalClass::royal_post_types(),
				'prefix_class' => 'royal-search-pro--source-',
				'frontend_available' => true,
			]
		);
		
		$this->add_control(
			'search_style',
			[
				'label' => __( 'Search Style', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'searchiconinside',
				'options' => [
					'searchiconinside'		=> __( 'Default', 'royal-addons-for-elementor' ),
					'searchiconoutside' 	=> __( 'Outside Icon', 'royal-addons-for-elementor' ),
				],
			]
		);

		$this->add_responsive_control(
			'width',
			[
				'label' 		=> __('Width', 'royal-addons-for-elementor'),
				'type' 			=> Controls_Manager::SLIDER,
				'size_units' 	=> [ 'px', '%' ],
				'default' => [
					'unit' => '%',
					'size' => 100,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .royal-search-wrap' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'height',
			[
				'label' 		=> __('Height', 'royal-addons-for-elementor'),
				'type' 			=> Controls_Manager::SLIDER,
				'size_units' 	=> [ 'px', '%' ],
				'default' => [
					'unit' => 'px',
					'size' => 40,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .royal-searchform, {{WRAPPER}} .royal-searchform input.field' => 'min-height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'placeholder',
			[
				'label' 		=> __('Placeholder', 'royal-addons-for-elementor'),
				'type' 			=> Controls_Manager::TEXT,
				'default' 		=> __('Search', 'royal-addons-for-elementor'),
				'placeholder' 	=> __('Search', 'royal-addons-for-elementor'),
				'dynamic' 		=> [ 'active' => true ],
			]
		);

		$this->add_control(
			'enable_ajax',
			[
				'label' 		=> __('Enable Ajax', 'royal-addons-for-elementor'),
				'type' 			=> Controls_Manager::SWITCHER,
				'label_on' 		=> __('Show', 'royal-addons-for-elementor'),
				'label_off' 	=> __('Hide', 'royal-addons-for-elementor'),
				'return_value' 	=> 'yes',
				'default' 		=> 'yes',
			]
		);

		$this->add_responsive_control(
			'align',
			[
				'label' 		=> __('Alignment', 'royal-addons-for-elementor'),
				'type' 			=> Controls_Manager::CHOOSE,
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
				'default' 		=> '',
				'prefix_class' => 'royal-align-',
			]
		);

		$this->add_control(
			  'royalsearchicon',
			  [
				'label' => __( 'Search Icon', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::ICONS,
				'separator' => 'before',
				'default' => [
				  'value' => 'fas fa-search',
				  'library' => 'fa-solid',
				],
				'recommended' => [
				  'fa-solid' => [
					'search',
					'search-plus',
					'search-minus',
					'search-location',
					'search-dollar',
				  ],
				  'fa-brands' => [
					'searchengin',
				  ],
				],
				'skin' => 'inline',
				'label_block' => false,        
			  ]
			);


		$this->end_controls_section();

		$this->start_controls_section(
			'section_input',
			[
				'label' 		=> __('Input', 'royal-addons-for-elementor'),
				'tab' 			=> Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs('tabs_input_style');

		$this->start_controls_tab(
			'tab_input_normal',
			[
				'label' => __('Normal', 'royal-addons-for-elementor'),
			]
		);

		$this->add_control(
			'input_bg',
			[
				'label' 		=> __('Background', 'royal-addons-for-elementor'),
				'type' 			=> Controls_Manager::COLOR,
				'selectors' 	=> [
					'{{WRAPPER}} .royal-searchform input.field' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'input_color',
			[
				'label' 		=> __('Color', 'royal-addons-for-elementor'),
				'type' 			=> Controls_Manager::COLOR,
				'selectors' 	=> [
					'{{WRAPPER}} .royal-searchform input.field' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_input_hover',
			[
				'label' => __('Hover', 'royal-addons-for-elementor'),
			]
		);

		$this->add_control(
			'input_bg_hover',
			[
				'label' 		=> __('Background', 'royal-addons-for-elementor'),
				'type' 			=> Controls_Manager::COLOR,
				'selectors' 	=> [
					'{{WRAPPER}} .royal-searchform input.field:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'input_color_hover',
			[
				'label' 		=> __('Color', 'royal-addons-for-elementor'),
				'type' 			=> Controls_Manager::COLOR,
				'selectors' 	=> [
					'{{WRAPPER}} .royal-searchform input.field:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'input_border_color_hover',
			[
				'label' 		=> __('Border Color', 'royal-addons-for-elementor'),
				'type' 			=> Controls_Manager::COLOR,
				'selectors' 	=> [
					'{{WRAPPER}} .royal-searchform input.field:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_input_focus',
			[
				'label' => __('Focus', 'royal-addons-for-elementor'),
			]
		);

		$this->add_control(
			'input_bg_focus',
			[
				'label' 		=> __('Background', 'royal-addons-for-elementor'),
				'type' 			=> Controls_Manager::COLOR,
				'selectors' 	=> [
					'{{WRAPPER}} .royal-searchform input.field:focus' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'input_color_focus',
			[
				'label' 		=> __('Color', 'royal-addons-for-elementor'),
				'type' 			=> Controls_Manager::COLOR,
				'selectors' 	=> [
					'{{WRAPPER}} .royal-searchform input.field:focus' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'input_border_color_focus',
			[
				'label' 		=> __('Border Color', 'royal-addons-for-elementor'),
				'type' 			=> Controls_Manager::COLOR,
				'selectors' 	=> [
					'{{WRAPPER}} .royal-searchform input.field:focus' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' 			=> 'input_focus_box_shadow',
				'selector' 		=> '{{WRAPPER}} .royal-searchform input.field:focus',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' 			=> 'input_border',
				'label' 		=> __('Border', 'royal-addons-for-elementor'),
				'placeholder' 	=> '1px',
				'default' 		=> '1px',
				'selector' 		=> '{{WRAPPER}} .royal-searchform input.field',
				'separator' 	=> 'before',
			]
		);

		$this->add_control(
			'input_border_radius',
			[
				'label' 		=> __('Border Radius', 'royal-addons-for-elementor'),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%' ],
				'selectors' 	=> [
					'{{WRAPPER}} .royal-searchform input.field' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'input_padding',
			[
				'label' 		=> __('Padding', 'royal-addons-for-elementor'),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', 'em', '%' ],
				'selectors' 	=> [
					'{{WRAPPER}} .royal-searchform input.field' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 			=> 'newsletter_input',
				'selector' 		=> '{{WRAPPER}} .royal-searchform input.field',

			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_icon',
			[
				'label' 		=> __('Search Button', 'royal-addons-for-elementor'),
				'type' 			=> Controls_Manager::SECTION,
				'tab' 			=> Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'search_button_size',
			[
				'label' 		=> __('Search Button Size', 'royal-addons-for-elementor'),
				'type' 			=> Controls_Manager::SLIDER,
				'default' => [
					'size' => 40,
				],
				'range' => [
					'min' => 10,
				],
				'selectors' => [
					'{{WRAPPER}} .royal-searchform button' => 'width: {{SIZE}}px; height: {{SIZE}}px; flex: 0 0 {{SIZE}}px;',
				],
			]
		);

		$this->add_control(
			'search_button_border_radius',
			[
				'label' 		=> __('Border Radius', 'royal-addons-for-elementor'),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%' ],
				'selectors' 	=> [
					'{{WRAPPER}} .royal-searchform button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'icon_size',
			[
				'label' 		=> __('Search Icon Size', 'royal-addons-for-elementor'),
				'type' 			=> Controls_Manager::SLIDER,
				'default' => [
					'size' => 20,
				],
				'range' => [
					'min' => 0,
				],
				'selectors' => [
					'{{WRAPPER}} .royal-searchform button svg' => 'width: {{SIZE}}px;',
				],
			]
		);

		$this->add_responsive_control(
			'icon_position',
			[
				'label' 		=> __('Position', 'royal-addons-for-elementor'),
				'type' 			=> Controls_Manager::SLIDER,
				'default' => [
					'size' => 0,
				],
				'range' => [
					'min' => 0,
				],
				'selectors' => [
					'{{WRAPPER}} .royal-searchform button' => is_rtl() ? 'left: {{SIZE}}px;' : 'right: {{SIZE}}px;',
				],
			]
		);

		$this->add_control(
			'btn_bg_color',
			[
				'label' 		=> __('Background Color', 'royal-addons-for-elementor'),
				'type' 			=> Controls_Manager::COLOR,
				'default'		=>'#f68e13',
				'selectors' 	=> [
					'{{WRAPPER}} .royal-search-wrap .search-submit' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->start_controls_tabs('tabs_icon_style');

		$this->start_controls_tab(
			'tab_button_normal',
			[
				'label' => __('Normal', 'royal-addons-for-elementor'),
			]
		);

		$this->add_control(
			'btn_color',
			[
				'label' 		=> __('Color', 'royal-addons-for-elementor'),
				'type' 			=> Controls_Manager::COLOR,
				'selectors' 	=> [
					'{{WRAPPER}} .royal-searchform button svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_button_hover',
			[
				'label' => __('Hover', 'royal-addons-for-elementor'),
			]
		);

		$this->add_control(
			'btn_color_hover',
			[
				'label' 		=> __('Color', 'royal-addons-for-elementor'),
				'type' 			=> Controls_Manager::COLOR,
				'selectors' 	=> [
					'{{WRAPPER}} .royal-searchform button:hover svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_search_results',
			[
				'label' 		=> __('Search Results', 'royal-addons-for-elementor'),
				'type' 			=> Controls_Manager::SECTION,
				'tab' 			=> Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'results_bg',
			[
				'label' 		=> __('Background Color', 'royal-addons-for-elementor'),
				'type' 			=> Controls_Manager::COLOR,
				'selectors' 	=> [
					'{{WRAPPER}} .royal-search-wrap .royal-search-results' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'results_border_radius',
			[
				'label' 		=> __('Border Radius', 'royal-addons-for-elementor'),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%' ],
				'selectors' 	=> [
					'{{WRAPPER}} .royal-search-wrap .royal-search-results' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' 	=> 'after',
			]
		);

		$this->start_controls_tabs('tabs_results_links_style');

		$this->start_controls_tab(
			'tab_results_links_normal',
			[
				'label' => __('Normal', 'royal-addons-for-elementor'),
			]
		);

		$this->add_control(
			'results_links_bg',
			[
				'label' 		=> __('Links Background', 'royal-addons-for-elementor'),
				'type' 			=> Controls_Manager::COLOR,
				'selectors' 	=> [
					'{{WRAPPER}} .royal-search-wrap .royal-search-results ul li a.search-result-link' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'results_links_color',
			[
				'label' 		=> __('Links Color', 'royal-addons-for-elementor'),
				'type' 			=> Controls_Manager::COLOR,
				'selectors' 	=> [
					'{{WRAPPER}} .royal-search-wrap .royal-search-results ul li a.search-result-link' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'results_links_border_color',
			[
				'label' 		=> __('Links Border Color', 'royal-addons-for-elementor'),
				'type' 			=> Controls_Manager::COLOR,
				'selectors' 	=> [
					'{{WRAPPER}} .royal-search-wrap .royal-search-results ul li a' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'results_icons_color',
			[
				'label' 		=> __('Icons Color', 'royal-addons-for-elementor'),
				'type' 			=> Controls_Manager::COLOR,
				'selectors' 	=> [
					'{{WRAPPER}} .royal-search-wrap .royal-search-results ul li a i.icon' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'results_all_links_color',
			[
				'label' 		=> __('All Results Color', 'royal-addons-for-elementor'),
				'type' 			=> Controls_Manager::COLOR,
				'selectors' 	=> [
					'{{WRAPPER}} .royal-search-wrap .royal-search-results ul li a.all-results' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'results_links_hover',
			[
				'label' => __('Hover', 'royal-addons-for-elementor'),
			]
		);

		$this->add_control(
			'results_links_hover_bg',
			[
				'label' 		=> __('Links Background', 'royal-addons-for-elementor'),
				'type' 			=> Controls_Manager::COLOR,
				'selectors' 	=> [
					'{{WRAPPER}} .royal-search-wrap .royal-search-results ul li a.search-result-link:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'results_links_hover_color',
			[
				'label' 		=> __('Links Color', 'royal-addons-for-elementor'),
				'type' 			=> Controls_Manager::COLOR,
				'selectors' 	=> [
					'{{WRAPPER}} .royal-search-wrap .royal-search-results ul li a.search-result-link:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'results_links_hover_border_color',
			[
				'label' 		=> __('Links Border Color', 'royal-addons-for-elementor'),
				'type' 			=> Controls_Manager::COLOR,
				'selectors' 	=> [
					'{{WRAPPER}} .royal-search-wrap .royal-search-results ul li a:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'results_icons_hover_color',
			[
				'label' 		=> __('Icons Color', 'royal-addons-for-elementor'),
				'type' 			=> Controls_Manager::COLOR,
				'selectors' 	=> [
					'{{WRAPPER}} .royal-search-wrap .royal-search-results ul li a:hover i.icon' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'results_all_links_hover_color',
			[
				'label' 		=> __('All Results Color', 'royal-addons-for-elementor'),
				'type' 			=> Controls_Manager::COLOR,
				'selectors' 	=> [
					'{{WRAPPER}} .royal-search-wrap .royal-search-results ul li a.all-results:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'results_links_padding',
			[
				'label' => __('Links Padding', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .royal-search-wrap .royal-search-results ul li a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 			=> 'results_search_typo',
				'selector' 		=> '{{WRAPPER}} .royal-search-wrap .royal-search-results ul li a',

			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_no_search_results',
			[
				'label' 		=> __('No Results Found', 'royal-addons-for-elementor'),
				'type' 			=> Controls_Manager::SECTION,
				'tab' 			=> Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'no_results_heading_color',
			[
				'label' 		=> __('Heading Color', 'royal-addons-for-elementor'),
				'type' 			=> Controls_Manager::COLOR,
				'selectors' 	=> [
					'{{WRAPPER}} .royal-search-wrap .royal-no-search-results h6' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 			=> 'no_results_heading_typo',
				'selector' 		=> '{{WRAPPER}} .royal-search-wrap .royal-no-search-results h6',

			]
		);

		$this->add_control(
			'no_results_text_color',
			[
				'label' 		=> __('Text Color', 'royal-addons-for-elementor'),
				'type' 			=> Controls_Manager::COLOR,
				'selectors' 	=> [
					'{{WRAPPER}} .royal-search-wrap .royal-no-search-results p' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 			=> 'no_results_text_typo',
				'selector' 		=> '{{WRAPPER}} .royal-search-wrap .royal-no-search-results p',

			]
		);

	}

	private static function get_post_types($args = []) {
		$post_type_args = [
			'show_in_nav_menus' => true,
		];

		if(! empty($args['post_type'])) {
			$post_type_args['name'] = $args['post_type'];
		}

		$_post_types = get_post_types($post_type_args , 'objects');

		$post_types  = [];
		$post_types[ 'any' ]  = esc_html__('Any', 'royal-addons-for-elementor');

		foreach($_post_types as $post_type => $object) {
			$post_types[ $post_type ] = $object->label;
		}

		return $post_types;
	}

	protected function render() {
		if ( $this->maybe_render_license_notice() ) {
			return;
		}

		$settings = $this->get_settings_for_display();

		// Admin ajax, put it in data so that it works in the edit mode of Elementor
		$ajax = admin_url('admin-ajax.php');

		// Wrapper classes
		$warperclasses = 'royal-search-wrap';
		if ( ! empty( $settings['search_style'] ) ) {
			$warperclasses .= ' ' . $settings['search_style'];
		}
		

		// If ajax
		$classes = 'royal-searchform';
		if('yes' == $settings['enable_ajax']) {
			$classes .= ' royal-ajax-search';
		}

		// Placeholder
		$placeholder = '';
		if(! empty($settings['placeholder'])) {
			$placeholder = ' placeholder="'. $settings['placeholder'] .'"';
		} ?>

		<div class="<?php echo esc_attr($warperclasses); ?>" data-ajaxurl="<?php echo esc_url($ajax); ?>">
			<form method="get" class="<?php echo esc_attr($classes); ?>" id="searchform" action="<?php echo esc_url(home_url('/')); ?>">
				<input type="text" aria-label="Search form" class="field" name="s" id="s"<?php echo $placeholder; ?>>
				<button type="submit" aria-label="Submit search" class="search-submit" value=""><?php \Elementor\Icons_Manager::render_icon( $settings['royalsearchicon'], [ 'aria-hidden' => 'true' ] ); ?></button>
				<input type="hidden" class="post-type" name="post_type" value="<?php echo esc_attr($settings['source']); ?>">
			</form>
			<?php
			if('yes' == $settings['enable_ajax']) { ?>
				<div class="royal-ajax-loading"></div>
				<div class="royal-search-results"></div>
			<?php
			} ?>
		</div>

	<?php
	}

}