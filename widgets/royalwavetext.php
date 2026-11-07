<?php
namespace RoyalAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
if (!defined('ABSPATH')) exit; // Exit if accessed directly


class RoyalWaveText extends Widget_Base {

	public function get_name() {
		return 'royalwavetext';
	}


	public function get_title() {
		return __( 'Wave Text', 'royal-addons-for-elementor' );
	}


	public function get_icon() { return 'eicon-heading rtbranding'; }


	public function get_keywords() {
		return [ 'wave', 'text', 'animation', 'tech', 'technologies', 'royal',  'mehdi',  'akram'];
	}


	public function get_categories() {
		return [ 'royaltech' ];
	}


	public function get_style_depends() {
		$styles = ['royalwavetext'];
		return $styles;
	}

	
	protected function register_controls() {

		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Content', 'royal-addons-for-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

        // Sub Heading
		$this->add_control(
			'wavetext',
			[
				'label' => __( 'Wave Text', 'royal-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'label_block' => true,
                'default' => 'ROYAL',
			]
        );
        


		$this->add_control(
			'wavetext_align',
			[
				'label' => __( 'Alignment', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
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
					'{{WRAPPER}} section.royalwavetext' => 'justify-content: {{VALUE}};',
				],
			]
		);
       
        $this->end_controls_section();

        // Style Tab
        $this->start_controls_section(
			'style_section',
			[
				'label' => __( 'Styles', 'royal-addons-for-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
        );


        $this->add_control(
			'wavetext_color',
			[
				'label' => __( 'Main Color', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'global' => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_PRIMARY,
				],
                'default' => '#61CE70',
				'selectors' => [
					'{{WRAPPER}} .royalwavetextcontent h2:nth-child(1)' => 'color: {{VALUE}}',
				],
			]
        );
        
        $this->add_control(
			'wavetext_stroke_color',
			[
				'label' => __( 'Stroke Color', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'global' => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_SECONDARY,
				  ],
                'default' => '#049FFF00',
				'selectors' => [
					'{{WRAPPER}} .royalwavetextcontent h2:nth-child(1)' => '-webkit-text-stroke: 3px {{VALUE}}',
				],
			]
        );

        $this->add_control(
			'wavetext_2nd_color',
			[
				'label' => __( 'Color', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'global' => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_TEXT,
				],
                'default' => '#59A6D6',
				'selectors' => [
					'{{WRAPPER}} .royalwavetextcontent h2:nth-child(2)' => 'color: {{VALUE}}',
				],
			]
        );

        // Wavetext Typography 
        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'wavetext_typography',
				'label' => __( 'Typography', 'royal-addons-for-elementor' ),
				'global' => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_TEXT,
				],	
				'selector' => '{{WRAPPER}} .royalwavetextcontent h2',
			]
        );
 
        $this->end_controls_section();
	}


	protected function render() {

        $settings = $this->get_settings_for_display();
        $wavetext = $settings['wavetext'];
    ?>
	<section class="royalwavetext">
		<div class="royalwavetextcontent">
			<h2><?php echo $wavetext; ?></h2>
			<h2><?php echo $wavetext; ?></h2>
		</div>
	</section>			
<?php
	}

}