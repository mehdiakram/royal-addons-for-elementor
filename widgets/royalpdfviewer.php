<?php
namespace RoyalAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


class RoyalPdfViewer extends Widget_Base {

	public function get_name() {
		return 'royalpdfviewer';
	}


	public function get_title() {
		return __( 'PDF Viewer', 'royal-addons-for-elementor' );
	}


	public function get_icon() { return 'eicon-document-file rtbranding'; }


	public function get_keywords() {
		return [ 'pdf viewer', 'pdf', 'viewer', 'tech', 'technologies', 'royal',  'mehdi',  'akram'];
	}


	public function get_categories(){
		return [ 'royaltech' ];
	}
	
	

	protected function register_controls() {		
		$this->start_controls_section(
			'pdf_viewer_docs',
			[
				'label' => __( 'PDF Viewer', 'royal-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'pdf_type',
			[
				'label' => __( 'PDF type', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'url',
				'options' => [
					'url'  => __( 'URL', 'royal-addons-for-elementor' ),
					'file' => __( 'File', 'royal-addons-for-elementor' ),
				],
			]
		);
		
		$this->add_control(
			'pdf_url',
			[
				'label' => __( 'PDF URL', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => __( 'http://www.pdf995.com/samples/pdf.pdf', 'royal-addons-for-elementor' ),
				'show_external' => true,
				'default' => [
					'url' => 'http://www.pdf995.com/samples/pdf.pdf',
					'is_external' => true,
					'nofollow' => true,
				],
				'dynamic' => [
					'active' => true,
				],
				'condition' => [
					'pdf_type' => 'url',
				]
			]
		);

		$this->add_control(
			'pdf_file',
			[
				'label' => __( 'Choose PDF', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'media_type' => 'application/pdf',
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
				'dynamic' => [
					'active' => true,
				],
				'condition' => [
					'pdf_type' => 'file',
				],
			]
		);


		$this->add_responsive_control(
			'width',
			[
				'label' => __( 'Width', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ '%', 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1500,
						'step' => 5,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => 100,
				],
				'selectors' => [
					'{{WRAPPER}} .royalpdfviewer iframe' => 'width: {{SIZE}}{{UNIT}}!important;',
				],
			]
		);

		$this->add_responsive_control(
			'height',
			[
				'label' => __( 'Height', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ '%', 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1500,
						'step' => 5,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 600,
				],
				'selectors' => [
					'{{WRAPPER}} .royalpdfviewer iframe' => 'height: {{SIZE}}{{UNIT}}!important;',
				],
			]
		);

		$this->add_responsive_control(
			'text_align',
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
					'{{WRAPPER}} .royalpdfviewer' => 'text-align: {{VALUE}};',
				],
			]
		);
		
		
		$this->end_controls_section();


	}


	protected function render() {
		$settings = $this->get_settings_for_display();

		if (isset($settings['width'])) {
			$width = ' width: ' . $settings['width']['size'] . $settings['width']['unit'] . ';';
		}
		if (isset($settings['height'])) {
			$height = ' height: ' . $settings['height']['size'] . $settings['height']['unit'] . ';';
		}

		if ($settings['pdf_type'] == 'url' AND isset($settings['pdf_url'])) {
			$pdf_url = $settings['pdf_url']['url'];
		}

		if ($settings['pdf_type'] == 'file' AND isset($settings['pdf_file']['url'])) {
			$pdf_url = $settings['pdf_file']['url'];
		}

		echo '<div class="royalpdfviewer"><iframe src="https://docs.google.com/viewer?url=' . $pdf_url . '&amp;embedded=true" style="'  . $width . $height . '" frameborder="1" marginheight="0px" marginwidth="0px" allowfullscreen></iframe></div>';

	}

}

