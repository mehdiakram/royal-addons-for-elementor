<?php
namespace RoyalAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Icons_Manager;

if (!defined('ABSPATH')) exit; // Exit if accessed directly



class RoyalPreloader extends Widget_Base{

  public function get_name(){
    return 'royalpreloader';
  }


  public function get_title(){
    return 'Preloder';
  }


  public function get_icon() { return 'royalpreloader rtbranding'; }


  public function get_keywords() {
    return ['preloader', 'loader', 'pre loader', 'spin', 'spiner',  'tech', 'technologies', 'royal',  'mehdi',  'akram'];
  }


  public function get_categories(){
    return ['royaltech_headerfooter'];
  }


  public function get_style_depends() {
	$styles = ['royalpreloder'];
	return $styles;
  }




  protected function register_controls(){

   $this->start_controls_section(
      'content_section',
      [
        'label' => __( 'Royal Preloder', 'royal-addons-for-elementor' ),
        'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
      ]
    );

	$this->add_control(
		'preloderstyle',
		[
			'label' => esc_html__( 'Color', 'royal-addons-for-elementor' ),
			'type' => Controls_Manager::SELECT,
			'default' => 'royalpreloderripple',
			'options' => [
				'royalpreloderclock' 			=> esc_html__( 'Clock', 'royal-addons-for-elementor' ),
				'royalpreloderripple' 			=> esc_html__( 'Ripple', 'royal-addons-for-elementor' ),
				'royalpreloderbar1' 			=> esc_html__( 'Bar 1', 'royal-addons-for-elementor' ),
				'royalprelodercircle1' 			=> esc_html__( 'Circle 1', 'royal-addons-for-elementor' ),
				'royalpreloderbook1' 			=> esc_html__( 'Book 1', 'royal-addons-for-elementor' ),
				'royalpreloderdice' 			=> esc_html__( 'Six Dice', 'royal-addons-for-elementor' ),
				'royalpreloderboxwave' 			=> esc_html__( 'Box Wave', 'royal-addons-for-elementor' ),
				'royalpreloderflip' 			=> esc_html__( 'Flip', 'royal-addons-for-elementor' ),
				'royalpreloderspinner1' 		=> esc_html__( 'Spinner 1', 'royal-addons-for-elementor' ),
				'royalpreloderspinner2' 		=> esc_html__( 'Spinner 2', 'royal-addons-for-elementor' ),
				'royalpreloderspinner3' 		=> esc_html__( 'Spinner 3', 'royal-addons-for-elementor' ),
				'royalpreloderspinner4' 		=> esc_html__( 'Spinner 4', 'royal-addons-for-elementor' ),
				'royalpreloderspinner5' 		=> esc_html__( 'Spinner 5', 'royal-addons-for-elementor' ),
				'royalpreloderdotsleft2right' 	=> esc_html__( 'Dots Left to 2 Right', 'royal-addons-for-elementor' ),
				'royalpreloderpeeek' 			=> esc_html__( 'Peeek', 'royal-addons-for-elementor' ),
				'royalpreloderBouncyclippath' 	=> esc_html__( 'Bouncy Clip Path', 'royal-addons-for-elementor' ),
				'royalpreloderdashloader' 		=> esc_html__( 'Dash Loader', 'royal-addons-for-elementor' ),
				'custom' 						=> esc_html__( 'Custom', 'royal-addons-for-elementor' ),
			],
		]
	);
	
	$this->add_control(
		'royalpreloderoverlayer_color',
		[
			'label' => esc_html__( 'Overlayer Color', 'royal-addons-for-elementor' ),
			'type' => Controls_Manager::COLOR,
			'default' => '#FFFFFFA6',
			'selectors' => [
				'{{WRAPPER}} #royalpreloderoverlayer' => 'background-color: {{VALUE}};',
			],
		]
	);

	$this->add_control(
		'royalpreloder_color1',
		[
			'label' => esc_html__( 'Color 1', 'royal-addons-for-elementor' ),
			'type' => Controls_Manager::COLOR,
			'default' => '#ff414d',
			'selectors' => [
				'{{WRAPPER}} #royalpreloderoverlayer' => '--royalpreloder_color1: {{VALUE}};',
			],
		]
	);
	
	$this->add_control(
		'royalpreloder_color2',
		[
			'label' => esc_html__( 'Color 2', 'royal-addons-for-elementor' ),
			'type' => Controls_Manager::COLOR,
			'default' => '#ff7a00',
			'condition' => [
				'preloderstyle' => [
					'royalpreloderripple',
					'royalpreloderdice',
					'royalpreloderboxwave',
					'royalpreloderflip',
					'royalpreloderspinner5',
					'royalpreloderdotsleft2right',
					'royalpreloderBouncyclippath',
					'royalpreloderdashloader',
					'blank'
				],
			],	
			'selectors' => [
				'{{WRAPPER}} #royalpreloderoverlayer' => '--royalpreloder_color2: {{VALUE}};',
			],
		]
	);

	$this->add_control(
		'royalpreloder_color3',
		[
			'label' => esc_html__( 'Color 3', 'royal-addons-for-elementor' ),
			'type' => Controls_Manager::COLOR,
			'default' => '#28df99',
			'condition' => [
				'preloderstyle' => [
					'royalpreloderripple',
					'royalpreloderdice',
					'royalpreloderboxwave',
					'royalpreloderflip',
					'royalpreloderdotsleft2right',
					'royalpreloderBouncyclippath',
					'royalpreloderdashloader',
					'blank'
				],
			],			
			'selectors' => [
				'{{WRAPPER}} #royalpreloderoverlayer' => '--royalpreloder_color3: {{VALUE}};',
			],
		]
	);	

	$this->add_control(
		'royalpreloder_color4',
		[
			'label' => esc_html__( 'Color 4', 'royal-addons-for-elementor' ),
			'type' => Controls_Manager::COLOR,
			'default' => '#81b214',
			'condition' => [
				'preloderstyle' => [
					'royalpreloderripple',
					'royalpreloderdice',
					'royalpreloderboxwave',
					'royalpreloderflip',
					'royalpreloderdotsleft2right',
					'royalpreloderBouncyclippath',
					'royalpreloderdashloader',
					'blank'
				],
			],			
			'selectors' => [
				'{{WRAPPER}} #royalpreloderoverlayer' => '--royalpreloder_color4: {{VALUE}};',
			],
		]
	);	
	
	$this->add_control(
		'royalpreloder_color5',
		[
			'label' => esc_html__( 'Color 5', 'royal-addons-for-elementor' ),
			'type' => Controls_Manager::COLOR,
			'default' => '#f09ae9',
			'condition' => [
				'preloderstyle' => [
					'royalpreloderripple',
					'royalpreloderdice',
					'royalpreloderboxwave',
					'royalpreloderflip',
					'royalpreloderdotsleft2right',
					'blank'
				],
			],			
			'selectors' => [
				'{{WRAPPER}} #royalpreloderoverlayer' => '--royalpreloder_color5: {{VALUE}};',
			],
		]
	);	
	

	$this->add_control(
		'royalpreloder_color6',
		[
			'label' => esc_html__( 'Color 6', 'royal-addons-for-elementor' ),
			'type' => Controls_Manager::COLOR,
			'default' => '#2e5ac3',
			'condition' => [
				'preloderstyle' => [
					'royalpreloderdice',
					'blank'					
				],
			],			
			'selectors' => [
				'{{WRAPPER}} #royalpreloderoverlayer' => '--royalpreloder_color6: {{VALUE}};',
			],
		]
	);	
	
	
    $this->end_controls_section();

  }
  



  protected function render() {
    $settings = $this->get_settings_for_display();
	$preloderstyle = $settings['preloderstyle'];
	?>


	<div id="royalpreloderoverlayer">
	<?php if($preloderstyle == 'royalpreloderclock'){ ?>	
		<div class="royalpreloderclock"></div>
		
	<?php } elseif( $preloderstyle == 'royalpreloderripple'){ ?>
		<div class="royalpreloderripple">
			<span></span>
			<span></span>
			<span></span>
			<span></span>
			<span></span>
		</div>	
		
	<?php } elseif( $preloderstyle == 'royalpreloderbar1'){ ?>	
		<div class="royalpreloderbar1">
		  <div class="bar bar1"></div>
		  <div class="bar bar2"></div>
		  <div class="bar bar3"></div>
		  <div class="bar bar4"></div>
		  <div class="bar bar5"></div>
		  <div class="bar bar6"></div>
		  <div class="bar bar7"></div>
		  <div class="bar bar8"></div>
		</div>

	<?php } elseif( $preloderstyle == 'royalprelodercircle1'){ ?>	
		<div class="royalprelodercircle1">
			<span class="circle"></span>
			<span class="circle"></span>
			<span class="circle"></span>
			<span class="circle"></span>
		</div>

	<?php } elseif( $preloderstyle == 'royalpreloderbook1'){ ?>	
		<div class="royalpreloderbook1">
		  <div class="royalpreloderbook1inner">
			<div class="royalpreloderbook1left"></div>
			<div class="royalpreloderbook1middle"></div>
			<div class="royalpreloderbook1right"></div>
		  </div>
		  <ul>
			<li></li>
			<li></li>
			<li></li>
			<li></li>
			<li></li>
			<li></li>
			<li></li>
			<li></li>
			<li></li>
			<li></li>
			<li></li>
			<li></li>
			<li></li>
			<li></li>
			<li></li>
			<li></li>
			<li></li>
			<li></li>
		  </ul>
		</div>

	<?php } elseif( $preloderstyle == 'royalpreloderdice'){ ?>	
		<div class="royalpreloderdice">
		  <div class="royalpreloderdiceface loderdicefirstface">
			<div class="royalpreloderdicedot"></div>  
		  </div>
		  
		  <div class="royalpreloderdiceface loderdicesecondface">
			<div class="royalpreloderdicedot"></div>  
			<div class="royalpreloderdicedot"></div>  
		  </div>
		  
		  <div class="royalpreloderdiceface loderdicesthirdface">
			<div class="royalpreloderdicedot"></div>  
			<div class="royalpreloderdicedot"></div>
			<div class="royalpreloderdicedot"></div>
		  </div>
		  
		  <div class="royalpreloderdiceface loderdicesfourthface">
			<div class="royalpreloderdicecolumn">
			  <div class="royalpreloderdicedot"></div>  
			  <div class="royalpreloderdicedot"></div>  
			</div>
			<div class="royalpreloderdicecolumn">
			  <div class="royalpreloderdicedot"></div>  
			  <div class="royalpreloderdicedot"></div>  
			</div>    
		  </div>
		  
		  <div class="royalpreloderdiceface loderdicesfifthface">
			<div class="royalpreloderdicecolumn">
			  <div class="royalpreloderdicedot"></div>  
			  <div class="royalpreloderdicedot"></div>  
			</div>
			<div class="royalpreloderdicecolumn">
			  <div class="royalpreloderdicedot"></div>
			</div>
			<div class="royalpreloderdicecolumn">
			  <div class="royalpreloderdicedot"></div>  
			  <div class="royalpreloderdicedot"></div>  
			</div>    
		  </div>
		  
		  <div class="royalpreloderdiceface loderdicessixthface">
			<div class="royalpreloderdicecolumn">
			  <div class="royalpreloderdicedot"></div>  
			  <div class="royalpreloderdicedot"></div>
			  <div class="royalpreloderdicedot"></div>
			</div>
			<div class="royalpreloderdicecolumn">
			  <div class="royalpreloderdicedot"></div>  
			  <div class="royalpreloderdicedot"></div>  
			  <div class="royalpreloderdicedot"></div>
			</div>    
		  </div>
		</div>

	<?php } elseif( $preloderstyle == 'royalpreloderboxwave'){ ?>
		<div class="royalpreloderboxwave">
			<div class="royalpreloderboxwaveitem"></div>
			<div class="royalpreloderboxwaveitem"></div>
			<div class="royalpreloderboxwaveitem"></div>
			<div class="royalpreloderboxwaveitem"></div>
			<div class="royalpreloderboxwaveitem"></div>
		</div>


	<?php } elseif( $preloderstyle == 'royalpreloderflip'){ ?>
		<div class="royalpreloderflip">
		  <div class="royalpreloderflipinner">
			<div></div>
			<div></div>
			<div></div>
			<div></div>
			<div></div>
		  </div>
		</div>	
		
	<?php } elseif( $preloderstyle == 'royalpreloderspinner1'){ ?>	
		<div class="royalpreloderspinner1"></div>
	
	<?php } elseif( $preloderstyle == 'royalpreloderspinner2'){ ?>	
		<div class="royalpreloderspinner2"></div>
		
	<?php } elseif( $preloderstyle == 'royalpreloderspinner3'){ ?>	
		<div class="royalpreloderspinner3"></div>
		
	<?php } elseif( $preloderstyle == 'royalpreloderspinner4'){ ?>	
		<div class="royalpreloderspinner4"></div>
		
	<?php } elseif( $preloderstyle == 'royalpreloderspinner5'){ ?>	
		<div class="royalpreloderspinner5"></div>

	<?php } elseif( $preloderstyle == 'royalpreloderdotsleft2right'){ ?>
		<div class="royalpreloderdotsleft2right">
			<div></div>
			<div></div>
			<div></div>
			<div></div>
			<div></div>
		</div>
	
	<?php } elseif( $preloderstyle == 'royalpreloderpeeek'){ ?>	
		<div class="royalpreloderpeeek">
		  <ul>
			<li></li>
			<li></li>
			<li></li>
			<li></li>
			<li></li>
			<li></li>
			<li></li>
			<li></li>
			<li></li>
			<li></li>
		  </ul>
		</div>

	<?php } elseif( $preloderstyle == 'royalpreloderBouncyclippath'){ ?>	
		<div class="royalpreloderBouncyclippath">
			<div class="royalpreloderBouncyclippathinner">
				<div class="royalpreloderBouncyclippathinnersq"></div>
				<div class="royalpreloderBouncyclippathinnersq"></div>
			</div>
		</div>
	
	<?php } elseif( $preloderstyle == 'royalpreloderdashloader'){ ?>	
		<div class="royalpreloderdashloader">
		  <div></div>
		  <div></div>
		  <div></div>
		  <div></div>
		</div>



	
	<?php } else{ ?>
		
	<?php } ?>	
	
	
	
	
	
	
	
		
	</div>


    <script type="text/javascript">
	jQuery.noConflict();
	(function( $ ) {
	$(document).ready(function(){
				
		$(window).load(function() {
			$(".royalpreloder").delay(2000).fadeOut("slow");
			$("#royalpreloderoverlayer").delay(2000).fadeOut("slow");
		})
		
	});
	})(jQuery);
	
    </script>    
    <?php



  }









}