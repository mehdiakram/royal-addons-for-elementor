<?php
namespace RoyalAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class RoyalFlipbook extends Widget_Base {

	public function __construct($data = [], $args = null) {
		parent::__construct($data, $args);

		wp_register_style(
			'royalflipbook',
			ROYAL_ADDONS_ASSETS . 'css/royalflipbook.css',
			[],
			'1.7.0'
		);
		
		wp_register_script(
			'turn-js',
			ROYAL_ADDONS_ASSETS . 'vendor/turn/turn.min.js',
			[ 'jquery' ],
			'4.1.0',
			true
		);

		wp_register_script(
			'royalflipbook',
			ROYAL_ADDONS_ASSETS . 'js/royalflipbook.js',
			[ 'elementor-frontend', 'pdfjs-lib', 'turn-js' ],
			'1.7.0',
			true
		);

		wp_register_script(
		    'pdfjs-lib',
		    'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.min.js',
		    [],
		    '2.10.377',
		    true
        );
	}

	public function get_name() {
		return 'royalflipbook';
	}

	public function get_title() {
		return __( 'Royal Flipbook', 'royal-addons-for-elementor' );
	}

    public function get_icon() { return 'eicon-book rtbranding'; }

	public function get_categories() {
		return [ 'royaltech' ];
	}

	public function get_keywords() {
		return [ 'flipbook', 'pdf', 'corner flip', 'modern', 'tech', 'technologies', 'royal', 'mehdi', 'akram' ];
	}
	
	public function get_style_depends() {
		return [ 'royalflipbook' ];
	}

	public function get_script_depends() {
		return [ 'royalflipbook' ];
	}

	protected function register_controls() {
		// ===================================
		// Tab: Content
		// ===================================

		// --- Section: PDF Source ---
		$this->start_controls_section(
			'section_content_source',
			[
				'label' => __( 'PDF Source', 'royal-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'pdf_source',
			[
				'label' => __( 'Source', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'upload' => [ 'title' => __( 'Upload', 'royal-addons-for-elementor' ), 'icon' => 'eicon-upload' ],
					'url' => [ 'title' => __( 'URL', 'royal-addons-for-elementor' ), 'icon' => 'eicon-link' ],
				],
				'default' => 'url',
				'toggle' => false,
			]
		);

		$this->add_control(
			'pdf_upload',
			[
				'label' => __( 'Upload PDF', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::MEDIA,
				'media_types' => [ 'application/pdf' ],
				'condition' => [ 'pdf_source' => 'upload' ],
				'dynamic' => [ 'active' => true ],
			]
		);

		$this->add_control(
			'pdf_url',
			[
				'label' => __( 'PDF URL', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'placeholder' => __( 'https://example.com/document.pdf', 'royal-addons-for-elementor' ),
				'default' => 'http://www.pdf995.com/samples/pdf.pdf',
				'condition' => [ 'pdf_source' => 'url' ],
				'dynamic' => [ 'active' => true ],
			]
		);

		$this->end_controls_section();

		// --- Section: Settings ---
		$this->start_controls_section(
			'section_content_settings',
			[
				'label' => __( 'Flipbook Settings', 'royal-addons-for-elementor' ),
			]
		);
		
		$this->add_control(
			'display_mode',
			[
				'label' => __( 'Page View', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'single' => [ 'title' => __( 'One Page', 'royal-addons-for-elementor' ), 'icon' => 'eicon-document-file' ],
					'double' => [ 'title' => __( 'Two Pages', 'royal-addons-for-elementor' ), 'icon' => 'eicon-folder-o' ],
				],
				'default' => 'double',
				'toggle' => false,
			]
		);
		
		$this->add_control(
			'corner_flip_effect',
			[
				'label' => __( 'Corner Flip Effect', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_responsive_control(
			'height',
			[
				'label' => __( 'Height', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'vh' ],
				'range' => [
					'px' => [ 'min' => 200, 'max' => 1200 ],
					'vh' => [ 'min' => 30, 'max' => 100 ],
				],
				'default' => [ 'unit' => 'vh', 'size' => 70 ],
				'selectors' => [ '{{WRAPPER}} .royal-flipbook-viewport' => 'height: {{SIZE}}{{UNIT}};' ],
			]
		);

		$this->add_control(
			'direction',
			[
				'label' => __( 'Direction', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'ltr' => [ 'title' => __( 'Left to Right', 'royal-addons-for-elementor' ), 'icon' => 'eicon-h-align-left' ],
					'rtl' => [ 'title' => __( 'Right to Left', 'royal-addons-for-elementor' ), 'icon' => 'eicon-h-align-right' ],
				],
				'default' => 'ltr',
			]
		);

		$this->end_controls_section();

		// --- Section: Toolbar ---
		$this->start_controls_section(
			'section_content_toolbar',
			[
				'label' => __( 'Toolbar Features', 'royal-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'show_page_numbers',
			[ 'label' => __( 'Page Number Display', 'royal-addons-for-elementor' ), 'type' => Controls_Manager::SWITCHER, 'default' => 'yes' ]
		);
		
		$this->add_control(
			'show_zoom',
			[ 'label' => __( 'Zoom Controls', 'royal-addons-for-elementor' ), 'type' => Controls_Manager::SWITCHER, 'default' => 'yes' ]
		);

		$this->add_control(
			'show_fullscreen',
			[ 'label' => __( 'Fullscreen Button', 'royal-addons-for-elementor' ), 'type' => Controls_Manager::SWITCHER, 'default' => 'yes' ]
		);

		$this->end_controls_section();

		// ===================================
		// Tab: Style
		// ===================================
		$this->start_controls_section(
			'section_style_wrapper',
			[
				'label' => __( 'Wrapper', 'royal-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'wrapper_background',
				'label' => __( 'Background', 'royal-addons-for-elementor' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .royal-flipbook-wrapper',
                'default' => [ 'color' => '#f0f2f5' ],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$pdf_final_url = '';

		if ( 'upload' === $settings['pdf_source'] ) {
			$pdf_final_url = $settings['pdf_upload']['url'];
		} else {
			$pdf_final_url = $settings['pdf_url'];
		}

		if ( empty( $pdf_final_url ) ) {
			if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
				echo '<div class="elementor-alert elementor-alert-warning">' . esc_html__( 'Please provide a PDF file to see the flipbook.', 'royal-addons-for-elementor' ) . '</div>';
			}
			return;
		}

		$this->add_render_attribute( 'wrapper', [
			'class' => 'royal-flipbook-wrapper',
			'data-pdf-url' => esc_url( $pdf_final_url ),
			'data-direction' => $settings['direction'],
			'data-display-mode' => $settings['display_mode'],
			'data-corner-effect' => $settings['corner_flip_effect'],
		]);
		?>
		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
			<div class="royal-flipbook-loading">
				<div class="royal-flipbook-spinner"></div>
			</div>
			<div class="royal-flipbook-viewport">
				<div class="royal-flipbook-container"></div>
			</div>
			<div class="royal-flipbook-controls">
				<div class="royal-flipbook-btn royal-flipbook-prev-btn" title="Previous Page"></div>
				
				<?php if ( 'yes' === $settings['show_page_numbers'] ) : ?>
					<div class="royal-flipbook-page-display">
						<input type="text" class="royal-flipbook-page-input" title="Go to page" aria-label="Go to page">
						<span class="royal-flipbook-page-total"></span>
					</div>
				<?php endif; ?>

				<div class="royal-flipbook-btn royal-flipbook-next-btn" title="Next Page"></div>
				<div class="royal-flipbook-divider"></div>

				<?php if ( 'yes' === $settings['show_zoom'] ) : ?>
					<div class="royal-flipbook-btn royal-flipbook-zoom-out-btn" title="Zoom Out"></div>
					<div class="royal-flipbook-zoom-level">100%</div>
					<div class="royal-flipbook-btn royal-flipbook-zoom-in-btn" title="Zoom In"></div>
					<div class="royal-flipbook-btn royal-flipbook-zoom-reset-btn" title="Reset Zoom"></div>
				<?php endif; ?>
				
				<div class="royal-flipbook-divider"></div>

				<?php if ( 'yes' === $settings['show_fullscreen'] ) : ?>
					<div class="royal-flipbook-btn royal-flipbook-fullscreen-btn" title="Fullscreen"></div>
				<?php endif; ?>
			</div>
        </div>
		<?php
	}
}
