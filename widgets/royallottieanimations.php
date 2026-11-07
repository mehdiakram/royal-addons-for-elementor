<?php
namespace RoyalAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
if (!defined('ABSPATH')) exit; // Exit if accessed directly



class RoyalLottieAnimations extends Widget_Base {

	public function get_name() {
		return 'royallottieanimations';
	}


	public function get_title() {
		return 'Lottie Animations';
	}


	public function get_icon() { return 'eicon-lottie rtbranding'; }


	public function get_keywords() {
		return [ 'lottie', 'animation', 'animated', 'image', 'tech', 'technologies', 'royal',  'mehdi',  'akram'];
	}


	public function get_categories() {
		return [ 'royaltech' ];
	}


	public function get_script_depends() {
		$scripts = ['lottie-player'];
		return $scripts;
	}		


    protected function register_controls() {
		$controls = $this;

		/*-----------------------------------------------------------------------------------*/
        /*	Content Tab
        /*-----------------------------------------------------------------------------------*/

        $controls->start_controls_section(
			'source_settings',
			[
				'label' => esc_html__( 'Source', 'royal-addons-for-elementor' )
			]
		);

		$controls->add_control(
			'lottie_source',
			[
				'label' => __( 'Lottie Source', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'external',
				'options' => [
					'external'  => __( 'External', 'royal-addons-for-elementor' ),
					'upload' 	=> __( 'Upload', 'royal-addons-for-elementor' ),
				],
			]
		);

		$controls->add_control(
			'lottie_external',
			[
				'label' => esc_html__( 'Lottie JSON URL', 'royal-addons-for-elementor' ),
				'type'  => Controls_Manager::TEXT,
				'description' => 'Get JSON code URL from <a href="https://lottiefiles.com/featured/" target="_blank">here</a>',
				'label_block' => true,
				'default' => 'https://assets8.lottiefiles.com/datafiles/MUp3wlMDGtoK5FK/data.json',
				'condition' => [
					'lottie_source' => 'external',
				]					
			]
		);

		$controls->add_control(
			'lottie_upload',
			[
				'label' => __( 'Uoload Lottie JSON file', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'description' => 'Get JSON code URL from <a href="https://lottiefiles.com/featured/" target="_blank">here</a>',
				'condition' => [
					'lottie_source' => 'upload',
				]	
			]
		);


		$controls->add_control(
			'lottie_json',
			[
				'label' => __( 'Description', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'description' => 'Get JSON code URL from <a href="https://lottiefiles.com/featured/" target="_blank">here</a>',
				'rows' => 10,
				'default' => '',
				'condition' => [
					'lottie_source' => 'json',
				]					
			]
		);

		$controls->end_controls_section();




        $controls->start_controls_section(
			'control_settings',
			[
				'label' => esc_html__( 'Control', 'royal-addons-for-elementor' )
			]
		);


		$controls->add_control(
			'lottie_autoplay',
			[
				'label' => esc_html__( 'Autoplay','royal-addons-for-elementor' ),
				'type'  => Controls_Manager::SWITCHER,
				'return_value' => 'autoplay',
				'default'      => 'autoplay'
			]
		);

		$controls->add_control(
			'lottie_loop',
			[
				'label' => esc_html__( 'Loop','royal-addons-for-elementor' ),
				'type'  => Controls_Manager::SWITCHER,
				'return_value' => 'loop',
				'default'      => 'loop'
			]
		);

		$controls->add_control(
			'lottie_reverse',
			[
				'label' => esc_html__( 'Reverse', 'royal-addons-for-elementor' ),
				'type'  => Controls_Manager::SWITCHER,
				'return_value' => 'true',
				'default' => '',
				'condition' => [
					'lottie_loop' => 'loop',
				]
			]
		);

		$controls->add_control(
			'lottie_hover',
			[
				'label' => esc_html__( 'Only Play on Hover','royal-addons-for-elementor' ),
				'type'  => Controls_Manager::SWITCHER,
				'return_value'  => 'hover',
				'default' => ''
			]
		);

		$controls->add_control(
			'lottie_speed',
			[
				'label'   => esc_html__( 'Animation Speed', 'royal-addons-for-elementor' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 1,
				'min'     => 0.1,
				'max'     => 3,
				'step'    => 0.1
			]
		);



		$controls->add_control(
			'lottie_play_mode',
			[
				'label' => __( 'Lottie Play Mode', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'normal',
				'options' => [
					'normal'  	=> __( 'Normal', 'royal-addons-for-elementor' ),
					'bounce' 	=> __( 'Bounce', 'royal-addons-for-elementor' ),
				],
			]
		);



		$controls->add_control(
			'animate_on_scroll',
			[
				'label' => esc_html__( 'Animate On Scroll', 'royal-addons-for-elementor' ),
				'type'  => Controls_Manager::SWITCHER,
				'return_value'  => 'false',
				'condition' => [
					'lottie_hover!'   => 'true',
					'lottie_reverse!' => 'true'
				]
			]
		);

		$controls->add_control(
			'animate_speed',
			[
				'label' => esc_html__( 'Speed', 'royal-addons-for-elementor' ),
				'type'  => Controls_Manager::SLIDER,
				'default' => [
					'size' => 4
				],
				'range' => [
					'px' => [
						'max' => 10,
						'step' => 0.1
					]
				],
				'condition'     => [
					'lottie_hover!' => 'true',
					'animate_on_scroll' => 'true',
					'lottie_reverse!'   => 'true'
				]
			]
		);

		$controls->add_control(
			'animate_view',
			[
				'label' => esc_html__( 'Viewport', 'royal-addons-for-elementor' ),
				'type'  => Controls_Manager::SLIDER,
				'default' => [
					'sizes' => [
						'start' => 0,
						'end' => 100
					],
					'unit' => '%'
				],
				'labels' => [
					esc_html__( 'Bottom', 'royal-addons-for-elementor' ),
					esc_html__( 'Top', 'royal-addons-for-elementor' )
				],
				'scales' => 1,
				'handles' => 'range',
				'condition' => [
					'lottie_hover!' => 'true',
					'animate_on_scroll' => 'true',
					'lottie_reverse!'   => 'true'
				]
			]
		);
			
		$controls->end_controls_section();


		

        $controls->start_controls_section(
			'style_settings',
			[
				'label' => esc_html__( 'Style', 'royal-addons-for-elementor' )
			]
		);

		$controls->add_control(
			'lottie_background',
			[
				'label' => esc_html__( 'Background Color', 'royal-addons-for-elementor' ),
				'type'  => Controls_Manager::COLOR,
			]
		);


		$controls->add_responsive_control(
			'width',
			[
				'label' => esc_html__( 'Lottie Width', 'royal-addons-for-elementor' ),
				'type'  => Controls_Manager::SLIDER,
				'size_units' => ['px', 'em', '%'],
				'default'    => [
					'unit' => 'px',
					'size' => 300
				],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 800
					],
					'em' => [
						'min' => 1,
						'max' => 30
					]
				],
			]
		);


		$controls->add_responsive_control(
			'height',
			[
				'label' => esc_html__( 'Lottie Height', 'royal-addons-for-elementor' ),
				'type'  => Controls_Manager::SLIDER,
				'size_units' => ['px', 'em', '%'],
				'default'    => [
					'unit' => 'px',
					'size' => 300
				],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 800
					],
					'em' => [
						'min' => 1,
						'max' => 30
					]
				],
			]
		);		


		$controls->add_control(
			'lottie_rotate',
			[
				'label' => esc_html__( 'Rotate (degrees)', 'royal-addons-for-elementor' ),
				'type'  => Controls_Manager::SLIDER,
				'description' => esc_html__( 'Set rotation value in degress', 'royal-addons-for-elementor' ),
				'range' => [
					'px' => [
						'min' => -180,
						'max' => 180
					]
				],
				'default' => [
					'size' => 0
				],
				'selectors'     => [
					'{{WRAPPER}} .royallottieplayer' => 'transform: rotate({{SIZE}}deg)'
				]
			]
		);

		$controls->add_control(
			'transform',
			[
				'label' => esc_html__( 'Transform 180 Degree', 'royal-addons-for-elementor' ),
				'type'  => Controls_Manager::SWITCHER,
				'return_value'  => '180deg',
				'selectors'     => [
					'{{WRAPPER}} .royallottieplayer' => 'transform: rotateY({{transform}})'
				]				
			]
		);

		$controls->add_responsive_control(
			'animation_align',
			[
				'label' => esc_html__( 'Alignment', 'royal-addons-for-elementor' ),
				'type'  => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title'=> esc_html__( 'Left', 'royal-addons-for-elementor' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title'=> esc_html__( 'Center', 'royal-addons-for-elementor' ),
						'icon' => 'eicon-text-align-center'
					],
					'right' => [
						'title'=> esc_html__( 'Right', 'royal-addons-for-elementor' ),
						'icon' => 'eicon-text-align-right'
					]
				],
				'default' => 'center',
				'toggle'  => false,
				'selectors' => [
					'{{WRAPPER}} .royallottieplayerwarper' => 'justify-content: {{VALUE}};',
				],
			]
		);





		$controls->end_controls_section();


	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$lottiesource	= $settings['lottie_source'];
		$autoplay 		= $settings['lottie_autoplay'];
		$loop 			= $settings['lottie_loop'];
		$reverse 		= $settings['lottie_reverse'];
		$speed 			= $settings['lottie_speed'];
		$hover 			= $settings['lottie_hover'];
		$mode 			= $settings['lottie_play_mode'];
		$background 	= $settings['lottie_background'];

		if($lottiesource == 'external'){
			$lottiefile = $settings['lottie_external'];
		} elseif ($lottiesource == 'upload') {
			$lottiefile = $settings['lottie_upload']['url'];
		} elseif ($lottiesource == 'json'){
			$lottiefile = $settings['lottie_json'];
		}


		if( empty( $lottiefile ) ) {
			return;
		}


		echo'<div class="royallottieplayerwarper"><lottie-player 
		class="royallottieplayer" 
		src="'.$lottiefile.'"
		mode="'.$mode.'"

		background="'.$background.'"
		speed="'.$speed.'"
		style="width: '. $settings['width']['size']. $settings['width']['unit'].'; height:'. $settings['height']['size']. $settings['height']['unit'].'"
		'.$hover.' '. $loop.' '.$autoplay.'>
		</lottie-player></div>';
	}




	protected function content_template() {	
	?>
		<#

		if ('external' === settings.lottie_source){
			var lottiefile = settings.lottie_external;
		} else if ('upload' === settings.lottie_source) {
			lottiefile = settings.lottie_upload.url;
		} else if ('json' === settings.lottie_source ){
			lottiefile = settings.lottie_json;
		}
		
		#>

		<lottie-player 
		class="royallottieplayer" 
		src="{{lottiefile}}"
		mode="{{settings.lottie_play_mode}}"
		background="{{settings.lottie_background}}"
		speed="{{settings.lottie_speed}}"
		style="width:{{settings.width.size}}{{settings.width.unit}}; height:{{settings.height.size}}{{settings.height.unit}}"
		{{settings.lottie_hover}} {{settings.lottie_loop}} {{settings.lottie_autoplay}}>
		</lottie-player>

	<?php
	}

	


}

