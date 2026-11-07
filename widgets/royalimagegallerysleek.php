<?php
namespace RoyalAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Group_Control_Text_Shadow;

defined( 'ABSPATH' ) || die();

class RoyalImageGallerySleek extends Widget_Base {

	public function get_name() {
		return 'royalimagegallerysleek';
	}


	public function get_title() {
		return __( 'Gallery Sleek', 'royal-addons-for-elementor' );
	}


	public function get_icon() { return 'eicon-slider-album rtbranding'; }


	public function get_keywords() {
		return [ 'gallery', 'image', 'sleek', 'tech', 'technologies', 'royal',  'mehdi',  'akram'];
	}


    public function get_categories() {
        return [ 'royaltech' ];
    }

	public function get_style_depends() {
		return [
			'royalimagegallerysleek',
		];
	}

	protected function register_controls() {
		$this->gallery_content_controls();
		$this->gallery_style_controls();
	}


	protected function gallery_content_controls() {	
		$this->start_controls_section(
			'_section_gallery',
			[
				'label' => __( 'Gallery', 'royal-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();
		
        $repeater->add_control(
			'image_title',
			[
			  'label' => __( 'Image Title', 'royal-addons-for-elementor' ),
			  'type' => \Elementor\Controls_Manager::TEXT,
			  'default' => __( 'Image Title', 'royal-addons-for-elementor' ),
			  'placeholder' => __( 'Type your title here', 'royal-addons-for-elementor' ),
			]
		  );

        $repeater->add_control(
			'gallery_image',
			[
			  'label' => __( 'Gallery Image', 'royal-addons-for-elementor' ),
			  'type' => \Elementor\Controls_Manager::MEDIA,
			  'default' => [
				'url' => \Elementor\Utils::get_placeholder_image_src(),
			  ],
			]
		  );

        $this->add_control(
            'gallery',
            [
                'label' => __( 'Gallery Images', 'royal-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'title_field' => '{{{ image_title }}}',
            ]
        );
		
		$this->add_responsive_control(
			'height',
			[
				'label' => esc_html__( 'Gallery Height', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 200,
						'max' => 1000,
						'step' => 1,
					],

				],
				'default' => [
					'unit' => 'px',
					'size' => 450,
				],
				'selectors' => [
					'{{WRAPPER}} .royalimagegallerysleek' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'gap',
			[
				'label' => esc_html__( 'Image Gap', 'textdomain' ),
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
					'unit' => 'rem',
					'size' => 1,
				],
				'selectors' => [
					'{{WRAPPER}} .royalimagegallerysleek' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'hoverscale',
			[
				'label' => esc_html__( 'Hover Scale ', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px'],
				'range' => [
					'px' => [
						'min' => 1.1,
						'max' => 5,
						'step' => .1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 2.5,
				],
				'selectors' => [
					'{{WRAPPER}} .royalimagegallerysleek .galleryimage:hover' => 'flex: {{SIZE}};',
				],
			]
		);

        $this->end_controls_section();
	}


	protected function gallery_style_controls() {

        $this->start_controls_section(
            '_section_style_gallery',
            [
                'label' => __( 'Style', 'royal-addons-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'border',
				'selector' => '{{WRAPPER}} .royalimagegallerysleek .galleryimage',
			]
		);

		$this->add_responsive_control(
			'borderradius',
			[
				'label' => esc_html__( 'Border Radius', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'default' => [
					'top' 		=> 10,
					'right' 	=> 10,
					'bottom' 	=> 10,
					'left' 		=> 10,
					'unit' 		=> 'px',
					'isLinked' 	=> false,
				],
				'selectors' => [
					'{{WRAPPER}} .royalimagegallerysleek .galleryimage' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);



        $this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		echo '<div class="royalimagegallerysleek">';
		if ( $settings['gallery'] ) {
			foreach (  $settings['gallery'] as $item ) {
				$image_src = $item['gallery_image']['url'];
				$image_title = $item['image_title'];
				echo '<div class="galleryimage"><img src="'.$image_src.'" alt="'.$image_title.'"></div>';
			}
		}
		echo '</div>';






	}
}
