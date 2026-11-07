<?php
namespace RoyalAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Image_Size;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


class RoyalImageGallery extends Widget_Base {

	public function get_name() {
		return 'royalimagegallery';
	}


	public function get_title() {
		return __( 'Image Gallery', 'royal-addons-for-elementor' );
	}


	public function get_icon() { return 'eicon-gallery-masonry rtbranding'; }


	public function get_keywords() {
		return [ 'image', 'gallery', 'infinite', 'scroll', 'tech', 'technologies', 'royal',  'mehdi',  'akram'];
	}


	public function get_categories() {
		return [ 'royaltech' ];
	}


	public function get_style_depends() {
		return ['royalimagegallery'];
	}


	public function get_script_depends() {
        return ['magnific-popup', 'royalmagnificpopup'];
    }	

	protected function register_controls() {
		$this->source_gallery_options();
		$this->style_column_options();
	}


	private function source_gallery_options() {
		$this->start_controls_section(
			'section_source_gallery',
			[
				'label' => esc_html__( 'Gallery', 'royal-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'image_gallery',
			[
				'label' => esc_html__( 'Add Images', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::GALLERY,
				'default' => [],
				'show_label' => false,
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$this->add_control(
			'gallery_style',
			[
				'label' => esc_html__( 'Gallery Style', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'column',
				'options' => [
					'column' => esc_html__( 'Column', 'royal-addons-for-elementor' ),
				],
			]
		);		
		
		$this->add_control(
			'gallery_lightbox',
			[
				'label' => esc_html__( 'Lightbox', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'textdomain' ),
				'label_off' => esc_html__( 'Hide', 'textdomain' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->end_controls_section();
	}	


	private function style_column_options() {
		$this->start_controls_section(
			'style_section_general',
			[
				'label' => __( 'Column Style', 'royal-addons-for-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => [
					'gallery_style' => 'column',
				],	
			]
		);

		$this->add_responsive_control(
			'column_width',
			[
				'label' => esc_html__( 'Column Width', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1600,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 200,
				],
				'selectors' => [
					'{{WRAPPER}} .royalimagegallerycolumn' => 'column-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'column_count',
			[
				'label' => esc_html__( 'Column Count', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => '4',
				'options' => [
					'1' => esc_html__( '1', 'royal-addons-for-elementor' ),
					'2' => esc_html__( '2', 'royal-addons-for-elementor' ),
					'3'  => esc_html__( '3', 'royal-addons-for-elementor' ),
					'4' => esc_html__( '4', 'royal-addons-for-elementor' ),
					'5' => esc_html__( '5', 'royal-addons-for-elementor' ),
					'6' => esc_html__( '6', 'royal-addons-for-elementor' ),
				],
				'selectors' => [
					'{{WRAPPER}} .royalimagegallerycolumn' => 'column-count: {{VALUE}};',
				],
			]
		);		

		$this->add_responsive_control(
			'margin',
			[
				'label' => esc_html__( 'Column Margin', 'royal-addons-for-elementor' ),
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
					'unit' => 'em',
					'size' => '1.5',
				],
				'selectors' => [
					'{{WRAPPER}} .royalimagegallerycolumn' => 'margin: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'gap',
			[
				'label' => esc_html__( 'Column Gap', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem', 'custom' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'em',
					'size' => '1',
				],
				'selectors' => [
					'{{WRAPPER}} .royalimagegallerycolumn' => 'column-gap: {{SIZE}}{{UNIT}};',
				],
			]
		);


		$this->add_control(
			'column_item_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .royalimagegallerycolumn .item' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'column_item_margin',
			[
				'label' => esc_html__( 'Item Margin', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'default' => [
					'top' => 0,
					'right' => 0,
					'bottom' => 1.2,
					'left' => 0,
					'unit' => 'em',
					'isLinked' => false,
				],
				'selectors' => [
					'{{WRAPPER}} .royalimagegallerycolumn .item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'column_item_padding',
			[
				'label' => esc_html__( 'Item Padding', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'default' => [
					'top' => 0,
					'right' => 0,
					'bottom' => 0,
					'left' => 0,
					'unit' => 'px',
					'isLinked' => false,
				],
				'selectors' => [
					'{{WRAPPER}} .royalimagegallerycolumn .item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'column_item_border_radius',
			[
				'label' => esc_html__( 'Item Border Radius', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'default' => [
					'top' => 8,
					'right' => 8,
					'bottom' => 8,
					'left' => 8,
					'unit' => 'px',
					'isLinked' => false,
				],
				'selectors' => [
					'{{WRAPPER}} .royalimagegallerycolumn .item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .royalimagegallerycolumn .item img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'column_item_box_shadow',
			[
				'label' => esc_html__( 'Item Box Shadow', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::BOX_SHADOW,
				'selectors' => [
					'{{WRAPPER}} .royalimagegallerycolumn .item' => 'box-shadow: {{HORIZONTAL}}px {{VERTICAL}}px {{BLUR}}px {{SPREAD}}px {{COLOR}};',
				],
			]
		);


		$this->end_controls_section();
	}



	protected function render() {
		$settings 				= $this->get_settings();
		$gallery_style 			= $settings['gallery_style'];

		if ($gallery_style =='column' ) {
			echo '<div class="royalimagegallerycolumn">';
			foreach ( $settings['image_gallery'] as $image ) {
				$imageid 	= $image['id'];
				$imageurl 	= $image['url'];
				$alt 		= get_post_meta($imageid, '_wp_attachment_image_alt', true);
				echo '<div class="item">';
				
				if ( 'yes' === $settings['gallery_lightbox'] ) {
					echo '<a href="' . esc_url( $imageurl ) .'">';
					echo wp_get_attachment_image($imageid, true, array( "alt" => $alt ) );
					echo '</a>';
				} else{
					echo wp_get_attachment_image($imageid, true, array( "alt" => $alt ) );
				}
				
				echo '</div>';
			}
			echo'</div>';
		}

	}



	

}