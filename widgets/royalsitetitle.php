<?php
namespace RoyalAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Group_Control_Text_Shadow;

defined( 'ABSPATH' ) || die();

class RoyalSiteTitle extends Widget_Base {

	public function get_name() {
		return 'royalsitetitle';
	}


	public function get_title() {
		return __( 'Site Title', 'royal-addons-for-elementor' );
	}


	public function get_icon() { return 'eicon-site-title rtbranding'; }


	public function get_keywords() {
		return ['site', 'title', 'text', 'tech', 'technologies', 'royal',  'mehdi',  'akram'];
	}


    public function get_categories() {
        return [ 'royaltech_headerfooter' ];
    }


	protected function register_controls() {
		$this->title_content_controls();
		$this->title_style_controls();
	}


	protected function title_content_controls() {	
		$this->start_controls_section(
			'_section_site_title',
			[
				'label' => __( 'Site Title', 'royal-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'site_title_tag',
			[
				'label' => __( 'Title HTML Tag', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'h1'  => [
						'title' => __( 'H1', 'royal-addons-for-elementor' ),
						'icon' => 'eicon-editor-h1'
					],
					'h2'  => [
						'title' => __( 'H2', 'royal-addons-for-elementor' ),
						'icon' => 'eicon-editor-h2'
					],
					'h3'  => [
						'title' => __( 'H3', 'royal-addons-for-elementor' ),
						'icon' => 'eicon-editor-h3'
					],
					'h4'  => [
						'title' => __( 'H4', 'royal-addons-for-elementor' ),
						'icon' => 'eicon-editor-h4'
					],
					'h5'  => [
						'title' => __( 'H5', 'royal-addons-for-elementor' ),
						'icon' => 'eicon-editor-h5'
					],
					'h6'  => [
						'title' => __( 'H6', 'royal-addons-for-elementor' ),
						'icon' => 'eicon-editor-h6'
					]
				],
				'default' => 'h2',
				'toggle' => false,
			]
		);

        $this->add_responsive_control(
			'align',
			[
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
					'justify' => [
						'title' => __( 'Justify', 'royal-addons-for-elementor' ),
						'icon' => 'eicon-text-align-justify',
					],
				],
				'toggle' => true,
				'selectors' => [
					'{{WRAPPER}} .elementor-widget-container' => 'text-align: {{VALUE}};'
				]
			]
		);

        $this->end_controls_section();
	}


	protected function title_style_controls() {

        $this->start_controls_section(
            '_section_style_site_title',
            [
                'label' => __( 'Site Title', 'royal-addons-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
			'st_color',
			[
				'label' => esc_html__( 'Color', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .royalsitetitle a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'site_title_typography',
				'label' => __( 'Typography', 'royal-addons-for-elementor' ),
				'selector' => '{{WRAPPER}} .royalsitetitle',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
				],
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'site_text_shadow',
				'selector' => '{{WRAPPER}} .royalsitetitle',
			]
		);


        $this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		echo'<div class=royalsitetitle>';
			echo '<a href="' . esc_url(home_url('/')) . '">';
			printf('<%1$s %2$s>%3$s</%1$s>', $settings['site_title_tag'], $this->get_render_attribute_string('title'), get_bloginfo('name') );
			echo '</a>';
		echo'</div>';
	}
}
