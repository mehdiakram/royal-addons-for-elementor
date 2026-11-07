<?php
namespace RoyalAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Icons_Manager;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use RoyalAddons\Elementor\Royal_Helpers;
use RoyalAddons\Elementor\Image_Mask_SVG_Control;

defined( 'ABSPATH' ) || die();

class RoyalImageMask extends Widget_Base {

	public function get_name() {
        return 'royalimagemask';
    }
    
	
    public function get_title() {
        return esc_html__( 'Image Mask', 'royal-addons-for-elementor' );
    }


    public function get_icon() { return 'eicon-image-box rtbranding'; }
    

	public function get_keywords() {
		return [ 'mask','image', 'tech', 'technologies', 'royal',  'mehdi',  'akram'];
	}


    public function get_categories() {
        return [ 'royaltech' ];
    }


	protected function register_controls() {
		$this->section_image_control();
		$this->section_image_control_style();

	}


	protected function section_image_control() {    
		$this->start_controls_section( 
			'section_image_control',
			[
				'label' => esc_html__('Image mask', 'royal-addons-for-elementor'),
			]
		);

		$this->add_control(
			'image_media',
			[
				'label' => esc_html__( 'Choose Image', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'dynamic' => ['active' => true],
				'default' => [
					'url' => Royal_Helpers::royalassetspath(). 'images/mehdi1.jpg',
				],
			]
		);

		$this->add_responsive_control(
			'mask_type',
			[
				'label' => esc_html__( 'Mask Type', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'shape',
				'options' => [
					'shape'         => esc_html__( 'Shape', 'royal-addons-for-elementor' ),
					'map'         	=> esc_html__( 'Map', 'royal-addons-for-elementor' ),
					'custom' 		=> esc_html__( 'Custom', 'royal-addons-for-elementor' ),
					
				],
				'selectors' => [
					'{{WRAPPER}} .royalimagemask .image-clipping-mask' => 'mask-position: {{value}}; -webkit-mask-position: {{value}};',
				]
			]
		);


		$this->add_control(
			'mask_shape',
			[
				'label' => esc_html__( 'Mask', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'condition' => [ 'mask_type' => 'shape' ],
				'default' => 'shape36',
		    	'options' => Royal_Helpers::royal_masking_shape_list( 'list' ),
				'selectors' => [
			    	'{{WRAPPER}} .royalimagemask .image-clipping-mask' => '-webkit-mask-image: url({{VALUE}}); mask-image: url({{VALUE}});',
		    	],
		    	'selectors_dictionary' => Royal_Helpers::royal_masking_shape_list( 'url' ),

			]
		);

		$this->add_control(
			'mask_map',
			[
				'label' => esc_html__( 'Mask', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'condition' => [ 'mask_type' => 'map' ],
				'default' => 'mapbangladesh',
		    	'options' => Royal_Helpers::royal_masking_map_list( 'list' ),
				'selectors' => [
			    	'{{WRAPPER}} .royalimagemask .image-clipping-mask' => '-webkit-mask-image: url({{VALUE}}); mask-image: url({{VALUE}});',
		    	],
		    	'selectors_dictionary' => Royal_Helpers::royal_masking_map_list( 'url' ),

			]
		);

		$this->add_control(
			'mask_custom',
			[
				'label' => esc_html__( 'Choose Mask', 'royal-addons-for-elementor' ),
				'description' => esc_html__( 'SVG Image Or PNG Image', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'dynamic' => ['active' => true],
				'default' => [
					'url' => Royal_Helpers::royalassetspath(). 'images/tiger.png',
				],
				'selectors' => [
					'{{WRAPPER}} .royalimagemask .image-clipping-mask' => 'mask-image: url( {{url}} ); -webkit-mask-image: url( {{url}} );',
				],
				'condition' => [ 'mask_type' => 'custom' ],
			]
		);

		$this->add_responsive_control(
			'mask_position',
			[
				'label' => esc_html__( 'Mask Position', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'center center',
				'options' => [
					'unset'         => esc_html__( 'Unset', 'royal-addons-for-elementor' ),
					'center center' => esc_html__( 'Center Center', 'royal-addons-for-elementor' ),
					'center left'   => esc_html__( 'Center Left', 'royal-addons-for-elementor' ),
					'center right'  => esc_html__( 'Center Right', 'royal-addons-for-elementor' ),
					'top center'    => esc_html__( 'Top Center', 'royal-addons-for-elementor' ),
					'top left'      => esc_html__( 'Top Left', 'royal-addons-for-elementor' ),
					'top right'     => esc_html__( 'Top Right', 'royal-addons-for-elementor' ),
					'bottom center' => esc_html__( 'Bottom Center', 'royal-addons-for-elementor' ),
					'bottom left'   => esc_html__( 'Bottom Left', 'royal-addons-for-elementor' ),
					'bottom right'  => esc_html__( 'Bottom Right', 'royal-addons-for-elementor' ),
				],
				'selectors' => [
					'{{WRAPPER}} .royalimagemask .image-clipping-mask' => 'mask-position: {{value}}; -webkit-mask-position: {{value}};',
				]
			]
		);

		$this->add_responsive_control(
			'mask_repeat',
			[
				'label' => esc_html__( 'Mask Repeat', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'no-repeat',
				'options' => [
					'no-repeat' => esc_html__( 'No-repeat', 'royal-addons-for-elementor' ),
					'repeat'    => esc_html__( 'Repeat', 'royal-addons-for-elementor' ),
					'repeat-x'  => esc_html__( 'Repeat-x', 'royal-addons-for-elementor' ),
					'repeat-y'  => esc_html__( 'Repeat-y', 'royal-addons-for-elementor' ),
				],
				'selectors' => [
					'{{WRAPPER}} .royalimagemask .image-clipping-mask' => 'mask-repeat: {{value}}; -webkit-mask-repeat: {{value}};',
				]
			]
		);

		$this->add_responsive_control(
			'mask_size',
			[
				'label' => esc_html__( 'Mask Size', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'contain',
				'options' => [
					'unset'     => esc_html__( 'Unset', 'royal-addons-for-elementor' ),
					'cover'     => esc_html__( 'Cover', 'royal-addons-for-elementor' ),
					'contain'   => esc_html__( 'Contain', 'royal-addons-for-elementor' ),
				],
				'selectors' => [
					'{{WRAPPER}} .royalimagemask .image-clipping-mask' => 'mask-size: {{value}}; -webkit-mask-size: {{value}};',
				]
			]
		);

		$this->add_control(
			'mask_rotate',
			[
				'label' => esc_html__( 'Rotate', 'royal-addons-for-elementor' ),
				'type'  => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'deg' ],
				'default' => [
					'unit' => 'deg',
					'size' => 0,
				],
				'selectors' => [
					'{{WRAPPER}} .royalimagemask .image-clipping-mask' => 'transform: rotate( {{SIZE}}{{UNIT}} );',
					'{{WRAPPER}} .royalimagemask .image-clipping-mask .image' => 'transform: rotate( calc( -1 * {{SIZE}}{{UNIT}} ) );',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'Overlay',
				'types' => [ 'classic', 'gradient'],
				'selector' => '{{WRAPPER}} .royalimagemask .image-clipping-mask .overlay-image',
			]
		);

		$this->end_controls_section();
	}
		


	protected function section_image_control_style() {     
			$this->start_controls_section( 
				'section_style_general',
	            [
	                'label' => esc_html__('General', 'royal-addons-for-elementor'),
	                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
	            ]
	        );

	        $this->add_responsive_control(
			    'margin',
			    [
				    'label' => esc_html__( 'Margin', 'royal-addons-for-elementor' ),
				    'type' => \Elementor\Controls_Manager::DIMENSIONS,
				    'size_units' => [ 'px', '%', 'em' ],
				    'selectors' => [
					    '{{WRAPPER}} .royalimagemask' => 'margin: {{top}}{{unit}} {{right}}{{unit}} {{bottom}}{{unit}} {{left}}{{unit}};',
				    ],
			    ]
		    );

		    $this->add_responsive_control(
			    'padding',
			    [
				    'label' => esc_html__( 'Padding', 'royal-addons-for-elementor' ),
				    'type' => \Elementor\Controls_Manager::DIMENSIONS,
				    'size_units' => [ 'px', '%', 'em' ],
				    'default' => [
						'top' => '10',
						'right' => '10',
						'bottom' => '10',
						'left' => '10',
						'unit' => 'px',
						'isLinked' => 'true',
					],
				    'selectors' => [
					    '{{WRAPPER}} .royalimagemask' => 'padding: {{top}}{{unit}} {{right}}{{unit}} {{bottom}}{{unit}} {{left}}{{unit}};',
				    ],
			    ]
		    );

		    $this->add_group_control(
				\Elementor\Group_Control_Box_Shadow::get_type(),
				[
					'name' => 'box_shadow',
					'label' => esc_html__( 'Box Shadow', 'royal-addons-for-elementor' ),
					'selector' => '{{WRAPPER}} .royalimagemask',
				]
			);   

			$this->add_group_control(
				\Elementor\Group_Control_Border::get_type(),
				[
					'name' => 'border',
					'label' => esc_html__( 'Border', 'royal-addons-for-elementor' ),
					'selector' => '{{WRAPPER}} .royalimagemask',
				]
			);

			$this->add_responsive_control(
			    'border_radius',
			    [
				    'label' => esc_html__( 'Border Radius', 'royal-addons-for-elementor' ),
				    'type' => \Elementor\Controls_Manager::DIMENSIONS,
				    'size_units' => [ 'px', '%', 'em' ],
				    'selectors' => [
					    '{{WRAPPER}} .royalimagemask' => 'border-radius: {{top}}{{unit}} {{right}}{{unit}} {{bottom}}{{unit}} {{left}}{{unit}};',
				    ],
				    'toggle' => true,
				    'separator' => 'after'
			    ]
		    );	           

	        $this->end_controls_section();
        

			$this->start_controls_section( 
				'section_style_image',
	            [
	                'label' => esc_html__('Image', 'royal-addons-for-elementor'),
	                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
	            ]
	        );

		    $this->add_responsive_control(
			    'image_width',
			    [
				    'label' => esc_html__( 'Width', 'royal-addons-for-elementor' ),
				    'type'  => \Elementor\Controls_Manager::SLIDER,
				    'size_units' => [ 'px', '%', 'vw' ],
				    'default' => [
					    'unit' => '%',
					    'size' => 100,
				    ],
				    'selectors' => [
					    '{{WRAPPER}} .royalimagemask .image-clipping-mask' => 'width: {{SIZE}}{{UNIT}};',
				    ],
			    ]
		    );

		    $this->add_responsive_control(
			    'image_height',
			    [
				    'label' => esc_html__( 'Height', 'royal-addons-for-elementor' ),
				    'type'  => \Elementor\Controls_Manager::SLIDER,
				    'size_units' => [ 'px', '%', 'vh' ],
				    'range' => [
					    'px' => [
						    'min' => 0,
						    'max' => 1000,
						    'step' => 1,
					    ]
				    ],
				    'default' => [
					    'unit' => '%',
					    'size' => 100,
				    ],
				    'selectors' => [
					    '{{WRAPPER}} .royalimagemask .image-clipping-mask' => 'height: {{SIZE}}{{UNIT}};',
				    ],
				    'separator' => 'after'
			    ]
		    );  

		    $this->add_control(
				'overlay_heading',
				[
					'label' => esc_html__( 'Overlay', 'royal-addons-for-elementor' ),
					'type' => \Elementor\Controls_Manager::HEADING,
					'separator' => 'before',
				]
			); 

			$this->add_control(
				'overlay_background_color',
				[
					'label' => esc_html__( 'Background color', 'royal-addons-for-elementor' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'default' => '',
					'selectors' => [
						'{{WRAPPER}} .royalimagemask .overlay-image' => 'background-color: {{VALUE}}',
					],
				]
			);

	        $this->end_controls_section();
	}

	
	protected function render() {
		$settings = $this->get_settings_for_display(); ?>
		<div class="royalimagemask"> 
                <div class="image-clipping-mask">
					<div class="image"><img src="<?php echo $settings['image_media']['url']?>" alt=""></div>
                	<div class="overlay-image"></div>
                </div>
            </div>	

	<?php


	}

}