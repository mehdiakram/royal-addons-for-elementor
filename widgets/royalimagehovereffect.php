<?php
namespace RoyalAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Typography;
use Elementor\Utils;
use RoyalAddons\Elementor\Royal_Helpers;

defined('ABSPATH') || die();

class RoyalImageHoverEffect extends Widget_Base {

    public function get_name() {
        return 'royalimagehovereffect';
    }

	public function get_title() {
		return __('Image Hover Effect', 'royal-addons-for-elementor');
	}

	public function get_icon() { return 'eicon-image-rollover rtbranding'; }

	public function get_keywords() {
		return ['hover', 'image', 'effect', 'tech', 'technologies', 'royal',  'mehdi',  'akram'];
	}

    public function get_categories() {
        return array( 'royaltech' );
    }

    public function get_style_depends() {
		$styles = ['royalimagehovereffect'];
		return $styles;
	}

	protected function register_controls() {
		$this->section_image_content(); 
		$this->common_style_controls(); 
		$this->overlay_style_controls();
	}


	private function section_image_content() {

		$this->start_controls_section(
			'section_image_content',
			[
				'label' => __('Image Content', 'royal-addons-for-elementor'),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'hover_image',
			[
				'label' => __('Image', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'dynamic' => [
					'active' => true
				],
			]
		);

		$this->add_control(
			'hover_image_alt_tag',
			[
				'label' => __('Image ALT Tag', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::TEXT,
				'default' => __('Image hover effect image', 'royal-addons-for-elementor'),
				'placeholder' => __('Type here image alt tag value', 'royal-addons-for-elementor'),
				'dynamic' => ['active' => true,],
			]
		);

		$this->add_control(
			'hover_effect',
			[
				'label' => __('Hover Effect', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::SELECT2,
				'options' => [
					'royaleffect-apollo'  => __('Apollo', 'royal-addons-for-elementor'),
					'royaleffect-bubba'  => __('Bubba', 'royal-addons-for-elementor'),
					'royaleffect-chico'  => __('Chico', 'royal-addons-for-elementor'),
					'royaleffect-dexter'  => __('Dexter', 'royal-addons-for-elementor'),
					'royaleffect-duke'  => __('Duke', 'royal-addons-for-elementor'),
					'royaleffect-goliath'  => __('Goliath', 'royal-addons-for-elementor'),
					'royaleffect-honey'  => __('Honey', 'royal-addons-for-elementor'),
					'royaleffect-jazz'  => __('Jazz', 'royal-addons-for-elementor'),
					'royaleffect-layla'  => __('Layla', 'royal-addons-for-elementor'),
					'royaleffect-lexi'  => __('Lexi', 'royal-addons-for-elementor'),
					'royaleffect-lily'  => __('Lily', 'royal-addons-for-elementor'),
					'royaleffect-marley'  => __('Marley', 'royal-addons-for-elementor'),
					'royaleffect-milo'  => __('Milo', 'royal-addons-for-elementor'),
					'royaleffect-ming'  => __('Ming', 'royal-addons-for-elementor'),
					'royaleffect-moses'  => __('Moses', 'royal-addons-for-elementor'),
					'royaleffect-oscar'  => __('Oscar', 'royal-addons-for-elementor'),
					'royaleffect-romeo'  => __('Romeo', 'royal-addons-for-elementor'),
					'royaleffect-roxy'  => __('Roxy', 'royal-addons-for-elementor'),
					'royaleffect-ruby'  => __('Ruby', 'royal-addons-for-elementor'),
					'royaleffect-sadie'  => __('Sadie', 'royal-addons-for-elementor'),
					'royaleffect-sarah'  => __('Sarah', 'royal-addons-for-elementor'),
				],
				'default' => 'royaleffect-apollo',
			]
		);

		$this->add_control(
			'hover_title',
			[
				'label' => __('Title', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::TEXTAREA,
				'rows' => 3,
				'default' => __('Royal <span>Technologies</span>', 'royal-addons-for-elementor'),
				'placeholder' => __('Type your title here', 'royal-addons-for-elementor'),
				'dynamic' => ['active' => true],
			]
		);

		$this->add_control(
			'title_tag',
			[
				'label' => __( 'Title HTML Tag', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SELECT,
				'options'   => Royal_Helpers::royal_title_tags(),
				'default' => 'h2',
			]
		);

		$this->add_control(
			'hover_description',
			[
				'label' => __('Description', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::TEXTAREA,
				'rows' => 10,
				'default' => __('Best Elementor Addons', 'royal-addons-for-elementor'),
				'placeholder' => __('Type your description here', 'royal-addons-for-elementor'),
				'condition' => [
					'hover_effect!' => 'royaleffect-honey',
				],
				'dynamic' => ['active' => true],
			]
		);

		$this->add_control(
			'hover_link',
			[
				'label' => __('Link URL', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::URL,
				'placeholder' => __('https://your-link.com', 'royal-addons-for-elementor'),
				'show_external' => true,
				'default' => [
					'url' => '',
					'is_external' => true,
					'nofollow' => true,
				],
				'dynamic' => ['active' => true],
			]
		);

		$this->end_controls_section();
	}


	private function common_style_controls() {

		$this->start_controls_section(
			'_section_common_style',
			[
				'label' => __('Common', 'royal-addons-for-elementor'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'hover_container_height_width_control',
			[
				'label' => __('Container Max Width?', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'royal-addons-for-elementor'),
				'label_off' => __('No', 'royal-addons-for-elementor'),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_responsive_control(
			'hover_width',
			[
				'label' => __('Width', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1200,
						'step' => 5,
					],
				],
				'devices' => ['desktop', 'tablet', 'mobile'],
				'desktop_default' => [
					'size' => 480,
					'unit' => 'px',
				],
				'tablet_default' => [
					'size' => 480,
					'unit' => 'px',
				],
				'mobile_default' => [
					'size' => 300,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .royalimagehoverwrapper' => 'width: {{SIZE}}{{UNIT}}; height: calc({{SIZE}}{{UNIT}}/1.34);',
				],
				'condition' => [
					'hover_container_height_width_control' => 'yes'
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'hover_border',
				'label' => __('Border', 'royal-addons-for-elementor'),
				'selector' => '{{WRAPPER}} .royalimagehoverwrapper .royalimagehoverfig',
			]
		);

		$this->add_control(
			'hover_border_radius',
			[
				'label' => __('Border Radius', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'selectors' => [
					'{{WRAPPER}} .royalimagehoverwrapper .royalimagehoverfig' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typo',
				'label' => __('Title Typography', 'royal-addons-for-elementor'),
				'selector' => '{{WRAPPER}} .royalimagehoverwrapper .royalimagehoverfig .royalimagehovertitle',
				'fields_options' => [
					'typography' => ['default' => 'yes'],
					'font_family' => [
						'default' => 'Roboto',
					],
				],
			]
		);


		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'description_typo',
				'label' => __('Description Typography', 'royal-addons-for-elementor'),
				'selector' => '{{WRAPPER}} .royalimagehoverwrapper .royalimagehoverfig .royalimagehoverdesc',
				'fields_options' => [
					'typography' => ['default' => 'yes'],
					'font_family' => [
						'default' => 'Roboto',
					],
				],
			]
		);

		$this->start_controls_tabs('_tabs_style');

		$this->start_controls_tab(
			'_tab_normal',
			[
				'label' => __('Normal', 'royal-addons-for-elementor'),
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => __('Title Color', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .royalimagehoverwrapper .royalimagehoverfig .royalimagehovertitle' => 'color: {{VALUE}}; border-color: {{VALUE}};',
					'{{WRAPPER}} .royalimagehoverwrapper .royalimagehoverfig .royalimagehovertitle::before' => '--royalimagehovertitle-before-color: {{VALUE}};',
					'{{WRAPPER}} .royalimagehoverwrapper .royalimagehoverfig .royalimagehovertitle::after' => '--royalimagehovertitle-after-color: {{VALUE}};',
					'{{WRAPPER}} .royalimagehoverwrapper .royalimagehoverfig .royalimagehovercaption::before' => '--royalimagehoverfig-before-color: {{VALUE}};',
					'{{WRAPPER}} .royalimagehoverwrapper .royalimagehoverfig .royalimagehovercaption::after' => '--royalimagehoverfig-after-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'description_color',
			[
				'label' => __('Description Color', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .royalimagehoverwrapper .royalimagehoverfig .royalimagehoverdesc' => 'color: {{VALUE}}; --royalimagehoverdesc-border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'_tab_hover',
			[
				'label' => __('Hover', 'royal-addons-for-elementor'),
			]
		);

		$this->add_control(
			'title_hover_color',
			[
				'label' => __('Title Color', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .royalimagehoverwrapper .royalimagehoverfig:hover .royalimagehovertitle' => 'color: {{VALUE}}; border-color: {{VALUE}};',
					'{{WRAPPER}} .royalimagehoverwrapper .royalimagehoverfig:hover .royalimagehovertitle::before' => '--royalimagehovertitle-before-color: {{VALUE}};',
					'{{WRAPPER}} .royalimagehoverwrapper .royalimagehoverfig:hover .royalimagehovertitle::after' => '-royalimagehovertitle-after-color: {{VALUE}};',
					'{{WRAPPER}} .royalimagehoverwrapper .royalimagehoverfig:hover .royalimagehovercaption::before' => '--royalimagehoverfig-before-color: {{VALUE}};',
					'{{WRAPPER}} .royalimagehoverwrapper .royalimagehoverfig:hover .royalimagehovercaption::after' => '--royalimagehoverfig-after-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'description_hover_color',
			[
				'label' => __('Description Color', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .royalimagehoverwrapper .royalimagehoverfig:hover .royalimagehoverdesc' => 'color: {{VALUE}}; --royalimagehoverdesc-border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	private function overlay_style_controls() {

		$this->start_controls_section(
			'_section_overlay_style',
			[
				'label' => __('Background Overlay', 'royal-addons-for-elementor'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs('_tabs_overlay_style');
		$this->start_controls_tab(
			'_tab_overlay_normal',
			[
				'label' => __('Normal', 'royal-addons-for-elementor'),
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'hover_overlay_normal',
				'label' => __('Background', 'royal-addons-for-elementor'),
				'show_label' => true,
				'types' => ['classic', 'gradient'],
				'exclude' => [
					'classic' => 'image'
				],
				'selector' => '{{WRAPPER}} .royalimagehoverwrapper .royalimagehoverfig, {{WRAPPER}} .royalimagehoverwrapper .royalimagehoverfig.royaleffect-sadie .royalimagehovercaption::before',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'_tab_overlay_hover',
			[
				'label' => __('Hover', 'royal-addons-for-elementor'),
			]
		);


		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'hover_overlay_hover',
				'label' => __('Background', 'royal-addons-for-elementor'),
				'show_label' => true,
				'types' => ['classic', 'gradient'],
				'exclude' => [
					'classic' => 'image'
				],
				'selector' => '{{WRAPPER}} .royalimagehoverwrapper .royalimagehoverfig:hover, {{WRAPPER}} .royalimagehoverwrapper .royalimagehoverfig.royaleffect-sadie:hover .royalimagehovercaption::before',
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$url_target = $settings['hover_link']['is_external'] ? ' target="_blank"' : '';
		$url_nofollow = $settings['hover_link']['nofollow'] ? ' rel="nofollow"' : '';
?>
		<div class="royalimagehoverwrapper grid">
			<figure class="royalimagehoverfig <?php echo esc_attr($settings['hover_effect']); ?>">
				<img class="royalimagehoverimg" src="<?php echo esc_url($settings['hover_image']['url']); ?>" alt="<?php echo esc_attr($settings['hover_image_alt_tag']); ?>" />
				<figcaption class="royalimagehovercaption">
					<?php if ($settings['hover_effect'] == 'royaleffect-lily') : ?>
						<div>
						<?php endif; ?>
						<?php
						printf( '<%1$s class="royalimagehovertitle">%2$s</%1$s>',
							$settings['title_tag'],
							$settings['hover_title']
						);
						?>
						<?php if ($settings['hover_effect'] != 'royaleffect-honey') : ?>
							<p class="royalimagehoverdesc"><?php echo wp_kses_post( $settings['hover_description'] ); ?></p>
						<?php endif; ?>
						<?php if ($settings['hover_effect'] == 'royaleffect-lily') : ?>
						</div>
					<?php endif; ?>
					<?php if ($settings['hover_link']['url'] != '') : ?>
						<a href="<?php echo esc_url($settings['hover_link']['url']); ?>" <?php echo esc_attr($url_target . $url_nofollow); ?>></a>
					<?php endif; ?>
				</figcaption>
			</figure>
		</div>
<?php
	}
}
