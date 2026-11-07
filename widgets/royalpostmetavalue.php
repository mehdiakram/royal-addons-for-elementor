<?php
namespace RoyalAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Image_Size;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use RoyalAddons\Traits\ProWidgetTrait;
use RoyalAddons\Elementor\Royal_Helpers;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


class RoyalPostMetaValue extends Widget_Base {
	use ProWidgetTrait;

	public function get_name() {
		return 'royalpostmetavalue';
	}


	public function get_title() {
		return __( 'Post Meta Value [Pro]', 'royal-addons-for-elementor' );
	}


	public function get_icon() { return 'eicon-handle rtbranding'; }


	public function get_keywords() {
		return ['post',  'value', 'meta', 'tech', 'technologies', 'royal',  'mehdi',  'akram', 'pro'];
	}


	public function get_categories() {
		return [ 'royaltech' ];
	}


	protected function register_controls() {
		$this->rt_query_options();

	}

	/* Query Options */
	private function rt_query_options() {

		$this->start_controls_section(
			'post_query_section',
			[
				'label' => esc_html__( 'Post Query', 'royal-addons-for-elementor' ),
			]
		);	
		
		$this->add_control(
            'custom_post',
            [
				'label'   => __( 'Post Type', 'royal-addons-for-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'options' => Royal_Helpers::royal_get_post_types(),
				'default' => 'post'
            ]
		);


		$this->add_control(
		  'meta_key',
		  [
			'label' => __( 'Meta Key', 'royal-addons-for-elementor' ),
			'type' => \Elementor\Controls_Manager::TEXT,
			'default' => '',
		  ]
		);

		$this->add_control(
		  'post_id',
		  [
			'label' => __( 'Post ID', 'royal-addons-for-elementor' ),
			'type' => \Elementor\Controls_Manager::NUMBER,
			'min' => 1,
			'default' => '',
			'description' => __( 'Post ID for Specific Post ID which you want to call, if blank then latest post will be call.', 'royal-addons-for-elementor' ),
		  ]
		);


		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'typography',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
				'selector' => '{{WRAPPER}} .royalpostmetavalue',
			]
		);

		$this->add_control(
			'align', [ 
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
				],
				'default' => 'center',
				'selectors' => [
					'{{WRAPPER}} .royalpostmetavalue' => 'text-align: {{VALUE}};',
				]
			]
		);


		$this->start_controls_tabs( 'grid_button_style' );
		// Normal tab.
		$this->start_controls_tab(
			'style_normal',
			[
				'label'     => __( 'Normal', 'royal-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'color_normal',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Color', 'royal-addons-for-elementor' ),
				'selectors' => [
					'{{WRAPPER}} .royalpostmetavalue' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		// Hover tab.
		$this->start_controls_tab(
			'style_hover',
			[
				'label'     => __( 'Hover', 'royal-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'color_hover',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Color', 'royal-addons-for-elementor' ),
				'selectors' => [
					'{{WRAPPER}} .royalpostmetavalue:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();

	}

	protected function render() {
		if ( $this->maybe_render_license_notice() ) {
			return;
		}

		$settings 			= $this->get_settings();
		$custom_post 		= $settings['custom_post'];
		$meta_key 			= $settings['meta_key'];
		$post_id 			= $settings['post_id'];
		$query_args 			= array(
			'post_type' 			=> $custom_post,
			'p'         			=> $post_id,
			'posts_per_page' 		=> 1,
			'no_found_rows'  		=> true,
			'post_status'         	=> 'publish',
			'ignore_sticky_posts'   => true
		);
		
		$all_posts = new \WP_Query( $query_args );
		
		echo '<div class="royalpostmetavalue">';	
		if ( $all_posts->have_posts() ) :
			while ( $all_posts->have_posts() ) :
				$all_posts->the_post();
					echo get_post_meta(get_the_ID(), $meta_key, true);					
			endwhile; 						
		endif; 
		echo '</div>';

	}



}	