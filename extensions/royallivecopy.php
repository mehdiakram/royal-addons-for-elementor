<?php

use Elementor\Controls_Manager;
use Elementor\Element_Base;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class RoyalLiveCopy {

	const OPTION_KEY = 'ha_global_options';
	const PREFIX = '_ha_live_copy_';
	static $should_script_enqueue = false;

	public function __construct() {
		add_action('wp_footer', [__CLASS__, 'enqueue_scripts']);
		add_action('wp_ajax_get_section_data', [__CLASS__, 'get_section_data']);
		add_action('wp_ajax_nopriv_get_section_data', [__CLASS__, 'get_section_data']);
		add_action('elementor/frontend/section/before_render', [__CLASS__, 'should_script_enqueue']);
		add_action('elementor/frontend/container/before_render', [__CLASS__, 'should_script_enqueue']);
		add_action('elementor/element/after_section_end', [$this, 'add_controls_section'], 10, 3);
	}


	protected function get_saved_settings( $id ) {
		$settings = self::get_saved_settings( $id );
		return RoyalLiveCopy::get_control_settings( $settings );
	}

	protected function save_settings_to_db( array $settings, $id ) {
		self::save_settings_to_db( $settings, $id );
		RoyalLiveCopy::save_control_settings( $settings, $id );
	}


	public static function should_script_enqueue($section) {
		if (self::$should_script_enqueue) {
			return;
		}

		if ('yes' == $section->get_settings_for_display('enable_live_copy')) {
			self::$should_script_enqueue = true;
			remove_action('elementor/frontend/section/before_render', [__CLASS__, 'should_script_enqueue']);
			remove_action('elementor/frontend/container/before_render', [__CLASS__, 'should_script_enqueue']);
		}
	}

	private static $registered_elements = [];

	public static function add_controls_section($element, $section_id, $args) {
		if ( in_array( $section_id, ['section_advanced', 'section_custom_css_pro'] ) ) {
			if ( ! ( $element instanceof \Elementor\Element_Base ) ) return;

			$element_id = $element->get_name();
			if ( isset( self::$registered_elements[ $element_id ] ) ) {
				return;
			}
			self::$registered_elements[ $element_id ] = true;
		

			$element->start_controls_section(
				'royalcontrolsection_livecopy',
				[
					'label' => __( 'Live Copy [Royal]', 'royal-addons-for-elementor' ),
					'tab' => Controls_Manager::TAB_ADVANCED,
				]
			);

			$element->add_control(
				'enable_live_copy',
				[
					'label' => __('Enable Live Copy', 'royal-addons-for-elementor'),
					'type' => Controls_Manager::SWITCHER,
					'return_value' => 'yes',
					'default' => '',
					'frontend_available' => true,
					'render_type' => 'none'
				]
			);

			$element->add_responsive_control(
				'royallivecopy_btn_padding',
				[
					'label' => __('Padding', 'royal-addons-for-elementor'),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => ['px', 'em', '%'],
					'separator' => 'before',
					'default' => [
						'top' => 10,
						'right' => 20,
						'bottom' => 10,
						'left' => 25,
						'unit' => 'px',
						'isLinked' => false,
					],
					'condition' => [
						'enable_live_copy' => 'yes',
					],
					'selectors' => [
						'{{WRAPPER}} .royallivecopy-wrap .royallivecopy-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$element->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name' => 'royallivecopy_btn_border',
					'condition' => [
						'enable_live_copy' => 'yes',
					],
					'selector' => '{{WRAPPER}} .royallivecopy-wrap .royallivecopy-btn',
				]
			);
	
			$element->add_control(
				'royallivecopy_btn_border_radius',
				[
					'label' => __('Border Radius', 'royal-addons-for-elementor'),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => ['px', '%'],
					'default' => [
						'top' => 30,
						'right' => 0,
						'bottom' => 0,
						'left' => 30,
						'unit' => 'px',
						'isLinked' => false,
					],
					'condition' => [
						'enable_live_copy' => 'yes',
					],
					'selectors' => [
						'{{WRAPPER}} .royallivecopy-wrap .royallivecopy-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
	
			$element->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name' => 'royallivecopy_btn_box_shadow',
					'condition' => [
						'enable_live_copy' => 'yes',
					],
					'selector' => '{{WRAPPER}} .royallivecopy-wrap .royallivecopy-btn',
				]
			);
	
			$element->start_controls_tabs('royallivecopy_btn_tabs');
	
			$element->start_controls_tab(
				'royallivecopy_btn_tab_normal',
				[
					'label' => __('Normal', 'royal-addons-for-elementor'),
					'condition' => [
						'enable_live_copy' => 'yes',
					],
				]
			);
	
			$element->add_control(
				'royallivecopy_btn_color',
				[
					'label' => __('Text Color', 'royal-addons-for-elementor'),
					'type' => Controls_Manager::COLOR,
					'default' => '#fff',
					'condition' => [
						'enable_live_copy' => 'yes',
					],
					'selectors' => [
						'{{WRAPPER}} .royallivecopy-wrap .royallivecopy-btn' => 'color: {{VALUE}};',
					],
				]
			);
	
			$element->add_control(
				'royallivecopy_btn_bg_color',
				[
					'label' => __('Background Color', 'royal-addons-for-elementor'),
					'type' => Controls_Manager::COLOR,
					'default' => '#6b4ff4',
					'condition' => [
						'enable_live_copy' => 'yes',
					],
					'selectors' => [
						'{{WRAPPER}} .royallivecopy-wrap .royallivecopy-btn' => 'background-color: {{VALUE}};',
					],
				]
			);
	
			$element->end_controls_tab();
	
			$element->start_controls_tab(
				'royallivecopy_btn_tab_hover',
				[
					'label' => __('Hover', 'royal-addons-for-elementor'),
					'condition' => [
						'enable_live_copy' => 'yes',
					],
				]
			);
	
			$element->add_control(
				'royallivecopy_btn_hover_color',
				[
					'label' => __('Text Color', 'royal-addons-for-elementor'),
					'type' => Controls_Manager::COLOR,
					'default' => '#fff',
					'selectors' => [
						'{{WRAPPER}} .royallivecopy-wrap .royallivecopy-btn:hover' => 'color: {{VALUE}};',
					],
				]
			);
	
			$element->add_control(
				'royallivecopy_btn_hover_bg_color',
				[
					'label' => __('Background Color', 'royal-addons-for-elementor'),
					'type' => Controls_Manager::COLOR,
					'default' => '#e2498a',
					'selectors' => [
						'{{WRAPPER}} .royallivecopy-wrap .royallivecopy-btn:hover' => 'background-color: {{VALUE}};',
					],
				]
			);
	
			$element->add_control(
				'royallivecopy_btn_hover_border_color',
				[
					'label' => __('Border Color', 'royal-addons-for-elementor'),
					'type' => Controls_Manager::COLOR,
					'condition' => [
						'royallivecopy_btn_border!' => '',
					],
					'selectors' => [
						'{{WRAPPER}} .royallivecopy-wrap .royallivecopy-btn:focus' => 'border-color: {{VALUE}};',
					],
				]
			);
	
			$element->end_controls_tab();
			$element->end_controls_tabs();			

			$element->end_controls_section();
		}
	}



	/* Enqueue Editor Script */
	public static function enqueue_scripts() {
		if (\Elementor\Plugin::$instance->preview->is_preview_mode()) {
			self::add_inline_style();
			self::add_button();
			return;
		}

		if (self::$should_script_enqueue) {
			self::add_inline_style();
			self::add_button();

			wp_enqueue_script('royallivecopy', ROYAL_ADDONS_DIR_URL. 'assets/js/extension-livecopy.js',[ 'jquery' ],'',true);
			wp_enqueue_style('royallivecopy', ROYAL_ADDONS_DIR_URL.'assets/css/extension-livecopy.css', [], rand(), 'all' );

			wp_localize_script(
				'royallivecopy',
				'livecopy',
				[
					'storagekey' => md5('LICENSE KEY'),
					'ajax_url' => admin_url('admin-ajax.php'),
					'nonce' => wp_create_nonce('get_section_data'),
				]
			);
		}
	}


	protected static function add_button() {
		?>
			<div id="royallivecopy-base" class="royallivecopy-wrap" style="display: none">
				<a class="royallivecopy-btn" href="#" class="" target="_blank"><?php echo esc_html('Live Copy', 'royal-addons-for-elementor'); ?></a>
			</div>
		<?php
		}
	
		protected static function add_inline_style() {
		?>
			<style>
				.elementor-section-wrap>.elementor-section,
				.elementor-section.elementor-top-section,
				.e-container,
				.e-con,
				.e-div-block,
				.e-flexbox {
					position: relative
				}
				.elementor-section-wrap .royallivecopy-wrap,
				.elementor-section.elementor-top-section .royallivecopy-wrap,
				.e-container > .royallivecopy-wrap,
				.e-con > .royallivecopy-wrap,
				.e-div-block > .royallivecopy-wrap,
				.e-flexbox > .royallivecopy-wrap {
					position: absolute;
					top: 50%;
					right: 0px;
					z-index: 99999;
					display: none;
					text-decoration: none;
					font-size: 15px;
					-webkit-transform: translateY(-50%);
					-ms-transform: translateY(-50%);
					transform: translateY(-50%)
				}
				.royallivecopy-wrap .royallivecopy-btn {
					display: block;
					padding: 10px 20px 10px 25px;
					border-radius: 30px 0 0 30px;
					background: #6b4ff4;
					color: #fff;
					line-height: 1;
					-webkit-transition: all 0.2s;
					transition: all 0.2s
				}
	
				.royallivecopy-wrap .royallivecopy-btn:hover {
					background: #e2498a
				}
				.elementor-section-wrap>.elementor-section.live-copy-preview .royallivecopy-wrap,
				.elementor-section.elementor-top-section.live-copy-preview .royallivecopy-wrap,
				.elementor-section-wrap>.elementor-section:not(.elementor-element-edit-mode):hover .royallivecopy-wrap,
				.elementor-section.elementor-top-section:not(.elementor-element-edit-mode):hover .royallivecopy-wrap,
				.e-container:not(.elementor-element-edit-mode):hover .royallivecopy-wrap,
				.e-con:not(.elementor-element-edit-mode):hover .royallivecopy-wrap,
				.e-div-block:not(.elementor-element-edit-mode):hover .royallivecopy-wrap,
				.e-flexbox:not(.elementor-element-edit-mode):hover .royallivecopy-wrap {
					display: block
				}
			</style>
		<?php
		}


	public static function get_section_data() {

		check_ajax_referer('get_section_data', 'nonce');

		$post_id = isset($_GET['post_id']) ? absint($_GET['post_id']) : 0;
		$section_id = isset($_GET['section_id']) ? sanitize_text_field($_GET['section_id']) : 0;
		$elType = isset($_GET['elType']) ? sanitize_text_field($_GET['elType']) : '';

		if (empty($post_id) || empty($section_id)) {
			wp_send_json_error('Incomplete request');
		}


		$is_built_with_elementor =\Elementor\Plugin::$instance->documents->get( $post_id )->is_built_with_elementor();

		if (!$is_built_with_elementor) {
			wp_send_json_error('Not built with elementor');
		}

		$document = \Elementor\Plugin::$instance->documents->get($post_id);
		$elementor_data = $document ? $document->get_elements_data() : [];
		$data = [];

		if (!empty($elementor_data)) {
			$data = wp_list_filter($elementor_data, [
				'id' => $section_id,
				'elType' => $elType,
				// 'elType' => 'section',
			]);

			$data = current($data);

			if (empty($data)) {
				wp_send_json_error('Section not found');
			}
		}

		wp_send_json_success($data);
	}

	public static function get_control_settings($settings = []) {
		$options = get_option(self::OPTION_KEY, []);

		if (!empty($options)) {
			foreach ($options as $key => $value) {
				$settings[self::PREFIX . $key] = $value;
			}
		}

		return $settings;
	}

	public static function save_control_settings($settings, $id = 0) {
		$options = [];

		foreach ($settings as $key => $value) {
			if (strpos($key, self::PREFIX) === 0) {
				$options[str_replace(self::PREFIX, '', $key)] = $value;
			}
		}

		if (!empty($options)) {
			update_option(self::OPTION_KEY, $options, 'no');
		} else {
			delete_option(self::OPTION_KEY);
		}
	}






}
new RoyalLiveCopy();