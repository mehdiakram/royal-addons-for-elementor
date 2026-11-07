<?php
namespace RoyalAddons\Widgets;

use  Elementor\Widget_Base ;
use  Elementor\Controls_Manager ;
use  Elementor\Group_Control_Typography ;
use  Elementor\Group_Control_Image_Size ;
use  Elementor\Group_Control_Css_Filter ;
use  Elementor\Group_Control_Text_Stroke ;
use  Elementor\Repeater ;
if ( !defined( 'ABSPATH' ) ) {exit;}// Exit if accessed directly

class RoyalImageCarousel3D extends Widget_Base{

    public function get_name(){
        return 'royalimagecarousel3d';
    }
    
    public function get_title(){
        return __( '3D Image Carousel', 'royal-addons-for-elementor' );
    }
    
    public function get_icon() { return 'royalimagecarousel3d rtbranding'; }
    
    public function get_categories(){
        return [ 'royaltech' ];
    }
    
    public function get_keywords(){
		return [ '3d', 'slider', 'carousel', 'tech', 'technologies', 'royal',  'mehdi',  'akram'];
    }
    
	public function get_style_depends() {
		$styles = ['royalimagecarousel3d'];
		return $styles;
	}
	
	public function get_script_depends() {
		$scripts = ['royalimagecarousel3d'];
		return $scripts;
	}	
	
    protected function register_controls(){
        $this->start_controls_section( 'section_content_layout', [
            'label' => esc_html__( 'Layout', 'royal-addons-for-elementor' ),
        ] );
		

        $this->add_control(
            'carousel',
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

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'thumbnail',
                'exclude' => [ 'custom' ],
                'default' => 'large',
            ]
        );   

        $this->add_control(
			'text',
			[
				'label' => esc_html__( 'Text', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Royal Technologies 3D Carousel', 'royal-addons-for-elementor' ),
			]
		);

        $this->end_controls_section();


        
        $this->start_controls_section( 'section_content_animation', [
            'label' => esc_html__( 'Slider Settings', 'royal-addons-for-elementor' ),
        ] );

        $this->add_control(
			'radius',
			[
				'label' => esc_html__( 'Radius, how big? [100 - 500]', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::NUMBER,
				'min' => 100,
				'max' => 500,
				'step' => 1,
				'default' => 240,
			]
		);

        $this->add_control(
			'rotatespeed',
			[
				'label' => esc_html__( 'Rotate Speed, (unit: seconds/360 degrees) [-100 - 100]', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::NUMBER,
				'min' => -100,
				'max' => 100,
				'step' => 1,
				'default' => -60,
			]
		);

        $this->add_control(
			'imgwidth',
			[
				'label' => esc_html__( 'Image Width (unit: px)', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::NUMBER,
				'min' => 100,
				'max' => 1000,
				'step' => 1,
				'default' => 120,
			]
		);

        $this->add_control(
			'imgheight',
			[
				'label' => esc_html__( 'Image Height (unit: px)', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::NUMBER,
				'min' => 100,
				'max' => 1000,
				'step' => 1,
				'default' => 170,
			]
		);

        $this->add_control(
			'timeout',
			[
				'label' => esc_html__( 'Timeout (unit: milliseconds)', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::NUMBER,
				'min' => 100,
				'max' => 10000,
				'step' => 1,
				'default' => 1000,
			]
		);
        
        $this->end_controls_section();
        
        

        //Style Start
        $this->start_controls_section( 'general_style', [
            'label'     => esc_html__( 'Style', 'royal-addons-for-elementor' ),
            'tab'       => Controls_Manager::TAB_STYLE,
        ] );

        $this->add_group_control( Group_Control_Typography::get_type(), [
            'name'      => 'text_typography',
            'label'     => esc_html__( 'Text Typography', 'royal-addons-for-elementor' ),
            'selector'  => '{{WRAPPER}} .royalimagecarousel3d p',
        ] );



        $this->add_control( 'text__color', [
            'label'     => esc_html__( 'Text Color', 'royal-addons-for-elementor' ) ,
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .royalimagecarousel3d p' => 'color: {{VALUE}};',
            ],
        ] );

        $this->end_controls_section();
	}


    public function render(){
    $settings       = $this->get_settings_for_display();
    $id             = $this->get_id();
    $sliderid       = 'royalimagecarousel3d'.$id;
    $spinid         = 'spincontainer'.$id;
    $groundid       = 'ground'.$id;
    $text           = $settings['text'];
    $radius         = $settings['radius'];
    $rotatespeed    = $settings['rotatespeed'];
    $imgwidth       = $settings['imgwidth'];
    $imgheight      = $settings['imgheight'];
    $timeout        = $settings['timeout'];
    
    $this->add_render_attribute(
        'options',
        [
            'id'             	=> $sliderid,
            'data-spinid'		=> $spinid,
            'data-groundid'		=> $groundid,
            'data-radius'		=> $radius,
            'data-rotatespeed'	=> $rotatespeed,
            'data-imgwidth'	    => $imgwidth,
            'data-imgheight'	=> $imgheight,
            'data-timeout'	    => $timeout,
        ]
    );

    ?>
    <div class="royalimagecarousel3d" <?php echo $this->get_render_attribute_string( 'options' ) ?>>
        <div id="<?php echo $spinid ?>" class="spincontainer">
            <?php 
            foreach ( $settings['carousel'] as $index => $attachment ) {
                $image_url = Group_Control_Image_Size::get_attachment_image_src( $attachment['id'], 'thumbnail', $settings );
                if ( ! $image_url && isset( $attachment['url'] ) ) {
                    $image_url = $attachment['url'];
                }
                        
                echo '<img src="' . esc_attr($image_url) . '" alt="" />';
            } 
            ?>
            <p><?php echo $text ?></p>
        </div>
        <div id="<?php echo $groundid ?>" class="ground"></div>

    </div>
    <?php    
    }


}