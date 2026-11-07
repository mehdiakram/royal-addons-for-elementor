<?php
namespace RoyalAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Typography;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class RoyalFlipbox extends Widget_Base {

	public function get_name() {
		return 'royalflipbox';
	}


	public function get_title() {
		return __( 'Flip Box', 'royal-addons-for-elementor' );
	}


	public function get_icon() { return 'eicon-flip-box rtbranding'; }


	public function get_keywords() {
		return ['flip', 'box', 'flipbox', 'flip box', 'image', 'tech', 'technologies', 'royal',  'mehdi',  'akram'];
	}


	public function get_categories() {
		return [ 'royaltech' ];
	}


	public function get_style_depends() {
		$styles = ['royalflipbox'];
		return $styles;
	}

	public function get_script_depends() {
		$scripts = ['royalflipbox'];
		return $scripts;
	}

	protected function register_controls() {
		$this->content_flipboxtype_options();
		$this->content_front_options();
		$this->content_back_options();
		$this->style_front_options();
		$this->style_back_options();


	}


	private function content_flipboxtype_options() {
		$this->start_controls_section(
			'section_type',
			[
				'label' => __( 'FlipBox Type', 'royal-addons-for-elementor' ),
			]
		);

		$this->add_control(
            'royal_flipbox_style',
            [
                'label' => esc_html__('Style', 'royal-addons-for-elementor'),
                'type' => Controls_Manager::SELECT,
                'default' => 'royal-flip-effect-classic',
                'options' => [
                    'royal-flip-effect-classic' 	=> esc_html__('Flip Box Classic',  'royal-addons-for-elementor'),
                    'royal-flip-effect-3d'      	=> esc_html__('Flip Box 3D',  'royal-addons-for-elementor'),
                    'rotate-box-style'    			=> esc_html__('Rotate Style',  'royal-addons-for-elementor'),
                    'zoomin-box-style'    			=> esc_html__('Zoom In Style',  'royal-addons-for-elementor'),
                    'zoomout-box-style'   			=> esc_html__('Zoom Out Style',  'royal-addons-for-elementor'),
                    'side-right-style'    			=> esc_html__('Right Side Style',  'royal-addons-for-elementor'),
                    'side-left-style'     			=> esc_html__('Left Side Style',  'royal-addons-for-elementor'),
                    'to-top-style'        			=> esc_html__('To Top Style',  'royal-addons-for-elementor'),
                    'to-bottom-style'     			=> esc_html__('To Bottom Style',  'royal-addons-for-elementor'),
				],
			]
		);


		$this->add_control(
    		'royal_flipbox_type',
		    [
		        'label' => __( 'Filp Box Type', 'royal-addons-for-elementor' ),
		        'type' => Controls_Manager::SELECT,
					'default'     => 'royal-flip-right',
					'options' => [
						'royal-flip-right'      => esc_html__('Flip Right',  'royal-addons-for-elementor'),
						'royal-flip-left'      	=> esc_html__('Flip left',  'royal-addons-for-elementor'),
						'royal-flip-up'      	=> esc_html__('Flip Up',  'royal-addons-for-elementor'),
						'royal-flip-down'      	=> esc_html__('Flip Down',  'royal-addons-for-elementor'),
					],
				'condition' => [
					'royal_flipbox_style' => [ 'royal-flip-effect-3d', 'royal-flip-effect-classic' ],
				],
		    ]
		);

		$this->end_controls_section();
	}


	private function content_front_options() {
		$this->start_controls_section(
			'front_content',
			[
				'label' => __( 'Front Content', 'royal-addons-for-elementor' ),
			]
		);


		$this->add_control(
			'royal_flipbox_f_icon',
			[
				 'label' => __( 'Front Side Image/Icon (60px)', 'royal-addons-for-elementor' ),
				 'type' => Controls_Manager::MEDIA
			]
		);

		$this->add_control(
			'royal_flipbox_f_title',
			[
				'label' => __( 'Front Side Title', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				 ],
				'default'     => __( 'We Are So Glad You Are Here', 'royal-addons-for-elementor' ),
		 'placeholder' => __( 'Please enter the flipbox front title', 'royal-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'royal_flipbox_f_desc',
			[
				'label' => __( 'Front Side Description', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::TEXTAREA,
				'default'     => __( 'Hover Me Please, to check the back side', 'royal-addons-for-elementor' ),
				'dynamic' => [
					'active' => true,
				 ],
				'placeholder' => __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin ultricies sem lorem, non ullamcorper neque tincidunt id.', 'royal-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'royal_flipbox_f_button',
			[
				'label' => esc_html__( 'Button', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'textdomain' ),
				'label_off' => esc_html__( 'Hide', 'textdomain' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'royal_flipbox_f_link',
			[
				'label' => esc_html__( 'Button Link', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::URL,
				'options' => [ 'url', 'is_external', 'nofollow' ],
				'default' => [
					'url' => '',
					'is_external' => true,
					'nofollow' => true,
					// 'custom_attributes' => '',
				],
				'label_block' => true,
				'condition' => [
					'royal_flipbox_f_button' => 'yes',
				],				
			]
		);

		$this->add_control(
			'royal_flipbox_f_button_text',
			[
				'label' => esc_html__( 'Button Text', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Buy Now', 'royal-addons-for-elementor' ),
				'condition' => [
					'royal_flipbox_f_button' => 'yes',
				],					
			]
		);

		$this->end_controls_section();
	}


	private function content_back_options() {

		$this->start_controls_section(
			'back_content',
			[
				'label' => __( 'Back Content', 'royal-addons-for-elementor' ),
			]
		);

		$this->add_control(
		  'royal_flipbox_b_icon',
		  [
		     'label' => __( 'Back Side Image Icon', 'royal-addons-for-elementor' ),
		     'type' => Controls_Manager::MEDIA
		  ]
		);

		$this->add_control(
			'royal_flipbox_b_title',
			[
			  'label' => __( 'Back Side Title', 'royal-addons-for-elementor' ),
			  'type' => Controls_Manager::TEXT,
			  'dynamic' => [
				  'active' => true,
			   ],
			  'default'     => __( 'Contact Us', 'royal-addons-for-elementor' ),
		   'placeholder' => __( 'Please enter the flipbox back title', 'royal-addons-for-elementor' ),
			]
		  );

		  $this->add_control(
			'royal_flipbox_b_desc',
			[
			  'label' => __( 'Back Side Description', 'royal-addons-for-elementor' ),
			  'type' => Controls_Manager::TEXTAREA,
			  'dynamic' => [
				  'active' => true,
			   ],
			  'default'     => __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin ultricies sem lorem, non ullamcorper neque tincidunt id.', 'royal-addons-for-elementor' ),
			  'placeholder' => __( 'Please enter the flipbox back description', 'royal-addons-for-elementor' ),
			]
		  );


		$this->add_control(
			'royal_flipbox_b_button',
			[
				'label' => esc_html__( 'Button', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'textdomain' ),
				'label_off' => esc_html__( 'Hide', 'textdomain' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'royal_flipbox_b_link',
			[
				'label' => esc_html__( 'Button Link', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::URL,
				'options' => [ 'url', 'is_external', 'nofollow' ],
				'default' => [
					'url' => '',
					'is_external' => true,
					'nofollow' => true,
					// 'custom_attributes' => '',
				],
				'label_block' => true,
				'condition' => [
					'royal_flipbox_b_button' => 'yes',
				],				
			]
		);

		$this->add_control(
			'royal_flipbox_b_button_text',
			[
				'label' => esc_html__( 'Button Text', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Buy Now', 'royal-addons-for-elementor' ),
				'condition' => [
					'royal_flipbox_b_button' => 'yes',
				],					
			]
		);


		$this->end_controls_section();
	}

	private function style_front_options() {
		$this->start_controls_section(
			'section_style_front',
			[
				'label' => __( 'Front Style', 'royal-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'royal_flipbox_f_bg',
				'label' => __( 'Background', 'royal-addons-for-elementor' ),
				'types' => [ 'classic', 'gradient'],
				'selector' => '
					{{WRAPPER}} .royalflipboxcontainer .royal-flip-box-front',
			]
		);

		$this->add_control(
			'front_padding',
			[
				'label' => __( 'Padding', 'royal-addons-for-elementor' ),
				'type' => 'dimensions',
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .royalflipboxcontainer .royal-flip-box-front' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'front_border',
				'selector' => '{{WRAPPER}} .royalflipboxcontainer .royal-flip-box-front',
			]
		);

		$this->add_control(
			'front_border_radius',
			[
				'label' => __( 'Border Radius', 'royal-addons-for-elementor' ),
				'type' => 'dimensions',
				'size_units' => [ 'px', '%' ],
				'default' => [
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .royalflipboxcontainer .royal-flip-box-front' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'front_box_shadow',
				'label' => esc_html__( 'Box Shadow', 'textdomain' ),
				'selector' => '{{WRAPPER}} .royalflipboxcontainer .royal-flip-box-front',
			]
		);
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'royal_flipbox_f_title_typo',
				'label' => __( 'Title Typography', 'royal-addons-for-elementor' ),
				'selector' => '{{WRAPPER}} .royalflipboxcontainer .royal-flip-box-front .royal-flip-box-heading',
			]
		);

		$this->add_control(
			'royal_flipbox_f_title_color',
			[
				'label' => __( 'Front Side Title color', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .royalflipboxcontainer .royal-flip-box-front .royal-flip-box-heading' => 'color: {{VALUE}};',
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'royal_flipbox_f_desc_typo',
				'label' => __( 'Description Typography', 'royal-addons-for-elementor' ),
				'selector' => '{{WRAPPER}} .royalflipboxcontainer .royal-flip-box-front .royal-desc',
			]
		);

		$this->add_control(
			'royal_flipbox_f_desc_color',
			[
				'label' => __( 'Front Side Description color', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .royalflipboxcontainer .royal-flip-box-front .royal-desc' => 'color: {{VALUE}};',
				]
			]
		);

		$this->end_controls_section();
	}


	private function style_back_options() {
		$this->start_controls_section(
			'section_style_back',
			[
				'label' => __( 'Back Style', 'royal-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'royal_flipbox_b_bg',
				'label' => __( 'Background', 'royal-addons-for-elementor' ),
				'types' => [ 'classic', 'gradient'],
				'selector' => '
					{{WRAPPER}} .royalflipboxcontainer .royalflipboxinner .royal-flip-box-back',
			]
		);

		$this->add_control(
			'back_padding',
			[
				'label' => __( 'Padding', 'royal-addons-for-elementor' ),
				'type' => 'dimensions',
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .royalflipboxcontainer .royal-flip-box-back' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'back_border',
				'selector' => '{{WRAPPER}} .royalflipboxcontainer .royal-flip-box-back',
			]
		);

		$this->add_control(
			'back_border_radius',
			[
				'label' => __( 'Border Radius', 'royal-addons-for-elementor' ),
				'type' => 'dimensions',
				'size_units' => [ 'px', '%' ],
				'default' => [
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .royalflipboxcontainer .royal-flip-box-back' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'back_box_shadow',
				'label' => esc_html__( 'Box Shadow', 'textdomain' ),
				'selector' => '{{WRAPPER}} .royalflipboxcontainer .royal-flip-box-back',
			]
		);
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'royal_flipbox_b_title_typo',
				'label' => __( 'Title Typography', 'royal-addons-for-elementor' ),
				'selector' => '{{WRAPPER}} .royalflipboxcontainer .royal-flip-box-back .royal-flip-box-heading',
			]
		);

		$this->add_control(
			'royal_flipbox_b_title_color',
			[
				'label' => __( 'Back Side Title color', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .royalflipboxcontainer .royal-flip-box-back .royal-flip-box-heading' => 'color: {{VALUE}};',
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'royal_flipbox_b_desc_typo',
				'label' => __( 'Description Typography', 'royal-addons-for-elementor' ),
				'selector' => '{{WRAPPER}} .royalflipboxcontainer .royal-flip-box-back .royal-desc',
			]
		);

		$this->add_control(
			'royal_flipbox_b_desc_color',
			[
				'label' => __( 'Back Side Description color', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .royalflipboxcontainer .royal-flip-box-back .royal-desc' => 'color: {{VALUE}};',
				]
			]
		);
		$this->end_controls_section();






			$this->start_controls_section(
				'section_button',
				[
					'label' => __( 'Button Settings', 'royal-addons-for-elementor' ),
				]
			);


			$this->add_control(
						'royal_flipbox_show_btn',
						[
							'label' => __( 'Show Button?', 'royal-addons-for-elementor' ),
							'type' => Controls_Manager::SWITCHER,
							'label_on' => __( 'Show', 'royal-addons-for-elementor' ),
							'label_off' => __( 'Hide', 'royal-addons-for-elementor' ),
							'return_value' => 'yes',
							'default' => 'yes',
						]
					);


					$this->add_control(
					  'royal_flipbox_b_btn_text',
					  [
					    'label' => __( 'Button Text', 'royal-addons-for-elementor' ),
					    'type' => Controls_Manager::TEXT,
					    'default'     => __( 'View All', 'royal-addons-for-elementor' ),
					 'placeholder' => __( 'Please enter the flipbox button text', 'royal-addons-for-elementor' ),
					 'condition' => [
	 					'royal_flipbox_show_btn' => 'yes',
	 				],
					  ]
					);

					$this->add_control(
			  'royal_flipbox_b_btn_url',
			  [
			     'label' => __( 'Button URL', 'royal-addons-for-elementor' ),
			     'type' => Controls_Manager::URL,
			     'default' => [
			        'url' => 'http://',
			        'is_external' => '',
			     ],
			     'show_external' => true,
					 'condition' => [
	 					'royal_flipbox_show_btn' => 'yes',
	 				],
			  ]
			);


			$this->add_control(
				'royal_flipbox_b_btn_bg_color',
				[
					'label' => __( 'Button Background Color', 'royal-addons-for-elementor' ),
					'type' => Controls_Manager::COLOR,
					'default' => '#f96161',
					'condition' => [
					 'royal_flipbox_show_btn' => 'yes',
				 ],
					'selectors' => [
						'{{WRAPPER}} .royal-flipbox__action a' => 'background-color: {{VALUE}};',
					]
				]
			);


			$this->add_control(
				'royal_flipbox_b_btn_text_color',
				[
					'label' => __( 'Button Text Color', 'royal-addons-for-elementor' ),
					'type' => Controls_Manager::COLOR,
					'default' => '#ffffff',
					'condition' => [
					 'royal_flipbox_show_btn' => 'yes',
				 ],
					'selectors' => [
						'{{WRAPPER}} .royal-flipbox__action a' => 'color: {{VALUE}};',
					]
				]
			);


			$this->add_control(
				'royal_flipbox_b_btn_bg_color_hover',
				[
					'label' => __( 'Button Background Color On Hover', 'royal-addons-for-elementor' ),
					'type' => Controls_Manager::COLOR,
					'default' => '#fcb935',
					'condition' => [
					 'royal_flipbox_show_btn' => 'yes',
				 ],
					'selectors' => [
						'{{WRAPPER}} .royal-flipbox__action a:hover' => 'background-color: {{VALUE}} !important;',
					]
				]
			);


			$this->add_control(
				'royal_flipbox_b_btn_text_color_hover',
				[
					'label' => __( 'Button Text Color On Hover', 'royal-addons-for-elementor' ),
					'type' => Controls_Manager::COLOR,
					'default' => '#f7f7f7',
					'condition' => [
					 'royal_flipbox_show_btn' => 'yes',
				 ],
					'selectors' => [
						'{{WRAPPER}} .royal-flipbox__action a:hover' => 'color: {{VALUE}};',
					]
				]
			);


		$this->end_controls_section();
	}


	protected function render() {
	$settings = $this->get_settings_for_display();
	$royal_flipbox_style 	= $settings['royal_flipbox_style'];
	$royal_flipbox_type 	= $settings['royal_flipbox_type'];
	$royal_flipbox_f_title 	= $settings['royal_flipbox_f_title'];
	$royal_flipbox_f_desc 	= $settings['royal_flipbox_f_desc'];

	$royal_flipbox_b_title 	= $settings['royal_flipbox_b_title'];
	$royal_flipbox_b_desc 	= $settings['royal_flipbox_b_desc'];	
	?>	

	<div class="royalflipboxcontainer <?php echo $royal_flipbox_style;?>">
	<div class="royalflipboxinner <?php echo $royal_flipbox_type;?>">
		<div class="royalflipboxinner-wrapper">
			<div class="royal-flip-box-front">
				<div class="royal-flip-box-front-inner">
					<div class="icon-wrap">
						<?php $this->fronticon() ?>
					</div>
					<div class="royal-text">
						<h2 class="royal-flip-box-heading"><?php echo $royal_flipbox_f_title;?></h2>
						<p class="royal-desc"><?php echo $royal_flipbox_f_desc;?></p>
					</div>
					<?php $this->fronbutton() ?>
				</div>
			</div>

			<div class="royal-flip-box-back">
				<div class="royal-flip-box-back-inner">
					<div class="icon-wrap">
						<?php $this->backicon() ?>
					</div>
					<div class="royal-text">
						<h2 class="royal-flip-box-heading-back"><?php echo $royal_flipbox_b_title;?></h2>
						<p class="royal-desc"><?php echo $royal_flipbox_b_desc;?></p>
					</div>

					<?php $this->backbutton() ?>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
}

	protected function fronticon() {
		$settings 			= $this->get_settings();
		$iconfront 			= $settings['royal_flipbox_f_icon'];
		$iconfront_id 		= $iconfront["id"];
		$iconfront_alt 		= get_post_meta($iconfront, '_wp_attachment_image_alt', TRUE);
		$iconfront_title 	= get_the_title($iconfront);
		if ( $iconfront_id ) {
			echo '<div class="royal-flip-icon">';
			echo '<img alt="'.$iconfront_alt.'" title="'. $iconfront_title .'" class="attachment-full size-full"  src="'.$iconfront["url"].'"/>';
			echo '</div>';
		}
	}

	protected function fronbutton() {
		$settings 				= $this->get_settings();
		$royal_flipbox_f_button	= $settings['royal_flipbox_f_button'];
		
		if ( ! empty( $settings['royal_flipbox_f_link']['url'] ) && ($royal_flipbox_f_button =='yes')) {
			$this->add_link_attributes( 'royal_flipbox_f_link', $settings['royal_flipbox_f_link'] );
			$royal_flipbox_f_button_text 		= $settings['royal_flipbox_f_button_text'];
			echo '<div class="royal-flip-btn-container">';
			echo '<a class="royal-flip-btn" '. $this->get_render_attribute_string( 'royal_flipbox_f_link' ).' />'. $royal_flipbox_f_button_text .'</a>';
			echo '</div>';
		}
	}

	protected function backicon() {
		$settings 			= $this->get_settings();
		$iconback 			= $settings['royal_flipbox_b_icon'];
		$iconback_id 		= $iconback["id"];
		$iconback_alt 		= get_post_meta($iconback, '_wp_attachment_image_alt', TRUE);
		$iconback_title 	= get_the_title($iconback);
		if ( $iconback_id ) {
			echo '<div class="royal-flip-icon">';
			echo '<img alt="'.$iconback_alt.'" title="'. $iconback_title .'"  src="'.$iconback["url"].'"/>';
			echo '</div>';
		}
	}

	protected function backbutton() {
		$settings 				= $this->get_settings();
		$royal_flipbox_b_button	= $settings['royal_flipbox_b_button'];
		
		if ( ! empty( $settings['royal_flipbox_b_link']['url'] ) && ($royal_flipbox_b_button =='yes')) {
			$this->add_link_attributes( 'royal_flipbox_b_link', $settings['royal_flipbox_b_link'] );
			$royal_flipbox_b_button_text 		= $settings['royal_flipbox_b_button_text'];
			echo '<div class="royal-flip-btn-container">';
			echo '<a class="royal-flip-btn" '. $this->get_render_attribute_string( 'royal_flipbox_b_link' ).' />'. $royal_flipbox_b_button_text .'</a>';
			echo '</div>';
		}
	}




}
