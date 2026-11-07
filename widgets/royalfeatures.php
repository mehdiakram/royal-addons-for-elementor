<?php
namespace RoyalAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
if (!defined('ABSPATH')) exit; // Exit if accessed directly


class RoyalFeatures extends Widget_Base {

	public function get_name() {
		return 'royalfeatures';
	}


	public function get_title() {
		return __( 'Royal Features', 'royal-addons-for-elementor' );
	}


	public function get_icon() { return 'eicon-product-categories rtbranding'; }


	public function get_keywords() {
		return [ 'Features', 'Feature', 'royal', 'tech', 'Royal Technologies', 'Mehdi', 'Mehdi Akram', 'technologies', 'akram' ];
	}

	public function get_categories() {
		return [ 'royaltech' ];
	}


	protected function register_controls() {

		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Content', 'royal-addons-for-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		// Features Style
		$this->add_control(
			'features_style',
			[
				'label' => __( 'Features Style', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'features1',
				'options' => [
					'features1'  => __( 'Feature Style 1', 'royal-addons-for-elementor' ),
					'features2' => __( 'Feature Style 2', 'royal-addons-for-elementor' ),
				],
			]
		);

        // Features Sub Title
		$this->add_control(
			'features_sub_title',
			[
				'label' => __( 'Features Sub Title', 'royal-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'label_block' => true,
                'default' => 'Features Name',
				'placeholder' => __( 'Write Features Sub Title Here', 'royal-addons-for-elementor' ),
                'separator'=> 'before',
			]
        );
        
        // Features Title
		$this->add_control(
			'features_title',
			[
				'label' => __( 'Features Title', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
                'label_block' => true,
                'default' => 'Features Title',
				'placeholder' => __( 'Write Features Title Here', 'royal-addons-for-elementor' ),
			]
        );

		$repeater = new \Elementor\Repeater();

		// Feature Box Icon
		$repeater->add_control(
			'feature_box_icon',
			[
				'label' => __( 'Feature Box Icon', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-star',
					'library' => 'solid',
				],
			]
		);

		// Feature Box Title
		$repeater->add_control(
			'feature_box_title', [
				'label' => __( 'Feature Box Title', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Feature Box Title' , 'royal-addons-for-elementor' ),
				'label_block' => true,
			]
		);

		// Feature Box Description
		$repeater->add_control(
			'feature_box_desc', [
				'label' => __( 'Feature Box Description', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => __( 'Feature Box Description' , 'royal-addons-for-elementor' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'features_list',
			[
				'label' => __( 'Features List', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'title_field' => '{{{ feature_box_title }}}',
			]
		);

		// Feature Image
		$this->add_control(
			'feature_image',
			[
				'label' => __( 'Choose Feature Image', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
                'label_block' => true,
                'separator'=> 'before',
				'placeholder' => __( 'Choose Feature Image', 'royal-addons-for-elementor' ),
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

		// Feature Area Background Options
		$this->add_control(
			'feature_area_back_heading',
			[
				'label' => __( 'Feature Background Color', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
			]
		);

		// Feature Area Background Color
        $this->add_control(
			'feature_area_back',
			[
				'label' => __( 'Background Color', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'global' => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_PRIMARY,
				],
                'default' => '#f8f9fa',
				'selectors' => [
					'{{WRAPPER}} .features' => 'background-color: {{VALUE}}',
				],
			]
        );

        // Sub Title Options
		$this->add_control(
			'feature_subtitle_heading',
			[
				'label' => __( 'Sub Title', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before'
			]
		);

        // Sub Title Color
        $this->add_control(
			'feature_subtitl_color',
			[
				'label' => __( 'Color', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'global' => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_PRIMARY,
				],
                'default' => '#777',
				'selectors' => [
					'{{WRAPPER}} .single-feature h6' => 'color: {{VALUE}}',
				],
			]
        );
        
        // Sub Title Typography 
        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'feature_subtitl_typography',
				'label' => __( 'Typography', 'royal-addons-for-elementor' ),
				'global' => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_PRIMARY,
				  ],
				'selector' => '{{WRAPPER}} .single-feature h6',
			]
        );
        
        // Title Options
		$this->add_control(
			'title_heading',
			[
				'label' => __( 'Title', 'royal-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before'
			]
		);

        // Title Color
        $this->add_control(
			'title_color',
			[
				'label' => __( 'Color', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'global' => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_PRIMARY,
				],
                'default' => 'tomato',
				'selectors' => [
					'{{WRAPPER}} .single-feature h4' => 'color: {{VALUE}}',
				],
			]
        );
        
        // Title Typography 
        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'label' => __( 'Typography', 'royal-addons-for-elementor' ),
				'global' => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_PRIMARY,
				  ],
				'selector' => '{{WRAPPER}} .single-feature h4',
			]
        );

		// Title Separator Color
        $this->add_control(
			'title_separator_color',
			[
				'label' => __( 'Separator Color', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'global' => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_PRIMARY,
				],
                'default' => 'tomato',
				'selectors' => [
					'{{WRAPPER}} .single-feature h4::before' => 'background-color: {{VALUE}}',
				],
			]
        );
        
        // Features Options
		$this->add_control(
			'features_heading',
			[
				'label' => __( 'Features', 'royal-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before'
			]
		);

        // Feature Icon Color
        $this->add_control(
			'feature_icon_color',
			[
				'label' => __( 'Icon Color', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'global' => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_PRIMARY,
				],
                'default' => '#333',
				'selectors' => [
					'{{WRAPPER}} .feature-box i' => 'color: {{VALUE}}',
				],
			]
        );

		// Feature Icon Size
		$this->add_control(
			'feature_icon_size',
			[
				'label' => __( 'Icon Size', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => 'px',
				'range' => [
					'px' => [
						'min' => 20,
						'max' => 100,
						'step' => 5,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 26,
				],
				'selectors' => [
					'{{WRAPPER}} .feature-box i' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		// Features Title Options
		$this->add_control(
			'features_title_options',
			[
				'label' => __( 'Title', 'royal-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before'
			]
		);

		// Features Title Color
        $this->add_control(
			'feature_title_color',
			[
				'label' => __( 'Title Color', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'global' => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_PRIMARY,
				],
                'default' => '#333',
				'selectors' => [
					'{{WRAPPER}} .feature-box h5' => 'color: {{VALUE}}',
				],
			]
        );
        
        // Features Title Typography 
        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'feature_title_typography',
				'label' => __( 'Typography', 'royal-addons-for-elementor' ),
				'global' => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_PRIMARY,
				  ],
				'selector' => '{{WRAPPER}} .feature-box h5',
			]
        );

		// Features Description Options
		$this->add_control(
			'features_desc',
			[
				'label' => __( 'Description', 'royal-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before'
			]
		);

		// Features Description Color
        $this->add_control(
			'feature_desc_color',
			[
				'label' => __( 'Description Color', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'global' => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_PRIMARY,
				],
                'default' => '#333',
				'selectors' => [
					'{{WRAPPER}} .single-feature p' => 'color: {{VALUE}}',
				],
			]
        );
        
        // Features Description Typography 
        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'feature_desc_typography',
				'label' => __( 'Typography', 'royal-addons-for-elementor' ),
				'global' => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_PRIMARY,
				  ],
				'selector' => '{{WRAPPER}} .single-feature p',
			]
        );

		// Image Options
		$this->add_control(
			'image_options',
			[
				'label' => __( 'Image', 'royal-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before'
			]
		);

		// Image Background Color
        $this->add_control(
			'image_background',
			[
				'label' => __( 'Background Color', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'global' => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_PRIMARY,
				],
                'default' => '#333',
				'selectors' => [
					'{{WRAPPER}} .features-1::after, .features-2::after' => 'background-color: {{VALUE}}',
				],
			]
        );

		// Image Opacity
        $this->add_control(
			'image_opacity',
			[
				'label' => __( 'Opacity', 'elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'default' => [
					'size' => 1,
				],
				'range' => [
					'px' => [
						'max' => 1,
						'min' => 0.10,
						'step' => 0.01,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-image img' => 'opacity: {{SIZE}};',
				],
			]
		);

        $this->end_controls_section();
	}

	/**
	 * Render Features widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {

        $settings = $this->get_settings_for_display();
        $features_style = $settings['features_style'];
        $features_sub_title = $settings['features_sub_title'];
        $features_title = $settings['features_title'];
        $feature_image = $settings['feature_image']['url'];

		if($features_style == 'features1'){
			$feature_class = 'features-1';
			$margin_left = '';
			
		}else{
			$feature_class = 'features-2';
			$margin_left = 'ml-auto';
		}
    ?>
	<style>
		.features-1::before, .features-2::before{
			background-image:url('<?php echo $feature_image; ?>');
		}
	</style>
    <div class="royalfeatures <?php echo $feature_class; ?>">
		<div class="royalfeaturecol <?php echo $margin_left; ?>">
			<div class="single-feature text-center">
				<h6><?php echo $features_sub_title; ?></h6>
				<h4><?php echo $features_title; ?></h4>
				<div class="row">
					<?php
						if ( $settings['features_list'] ) {
							foreach (  $settings['features_list'] as $item ) {
					?>
					<div class="col-xl-6">
						<div class="feature-box">
							<i class="<?php echo $item['feature_box_icon']['value']; ?>"></i>
							<h5><?php echo wp_kses_post( $item['feature_box_title'] ); ?></h5>
							<p><?php echo wp_kses_post( $item['feature_box_desc'] ); ?></p>
						</div>
					</div>
					<?php
							}
						}
					?>
				</div>
			</div>
		</div>
	  </div>
<?php
	}

}