<?php

use Elementor\Controls_Manager;
use Elementor\Element_Base;
use Elementor\Core\Files\CSS\Post;
use Elementor\Core\DynamicTags\Dynamic_CSS;

if (!defined('ABSPATH')) exit; // Exit if accessed directly
if (defined('ELEMENTOR_PRO_VERSION')){ return;} // If Elementor Pro Installed return 

if (function_exists( 'pro_elements_plugin_load_plugin' ) ) { return; }


class Royal_Custom_CSS {

	private static $registered_elements = [];

	/* Add Action hook */
	public function __construct() {
		// Universal hook that fires for ALL element types including Atomic Containers, Div Blocks, etc.
		add_action( 'elementor/element/after_section_end', [ $this, 'add_controls_section_atomic' ], 40, 2 );

		// Elementor 4 Atomic API Hooks
		add_filter( 'elementor/atomic-widgets/props-schema', [ $this, 'add_atomic_props_schema' ], 10, 1 );
		add_filter( 'elementor/atomic-widgets/controls', [ $this, 'add_atomic_controls' ], 10, 2 );

		add_action( 'elementor/element/parse_css', [$this, 'add_post_css'], 10, 2);
		add_action( 'elementor/css-file/post/parse', [ $this, 'add_page_settings_css' ] );
		add_action( 'elementor/editor/after_enqueue_scripts', [$this, 'enqueue_editor_scripts']);
		add_action( 'elementor/frontend/before_render', [ $this, 'print_atomic_custom_css' ], 10, 1 );
	}


	public function add_atomic_props_schema( $schema ) {
		$schema['custom_css'] = \Elementor\Modules\AtomicWidgets\PropTypes\Primitives\String_Prop_Type::make()->default('');
		return $schema;
	}

	public function add_atomic_controls( $controls, $element ) {
		$controls[] = \Elementor\Modules\AtomicWidgets\Controls\Section::make()
			->set_id( 'royalcontrolsection_customcss_atomic' )
			->set_label( __( 'Custom CSS [Royal]', 'royal-addons-for-elementor' ) )
			->set_items( [
				\Elementor\Modules\AtomicWidgets\Controls\Types\Textarea_Control::bind_to( 'custom_css' )
					->set_label( __( 'Custom CSS', 'royal-addons-for-elementor' ) )
					->set_description( __( 'Use "selector" to target wrapper element. Examples:<br>selector {color: red;} // For main element<br>selector .child-element {margin: 10px;} // For child element<br>.my-class {text-align: center;} // Or use any custom selector', 'royal-addons-for-elementor' ) )
			] );

		return $controls;
	}

	public function add_controls_section_atomic( $element, $section_id = '' ) {
		$el_name = $element->get_name();
		$is_atomic = in_array($el_name, ['div-block', 'e-div-block', 'e-flexbox', 'atomic-widget-base']) || (strpos($el_name, 'atomic-') === 0);

		if ( ! $is_atomic && ! in_array( $section_id, [ 'section_custom_css', 'section_custom_css_pro', 'section_custom_attributes' ] ) ) {
			return;
		}
		
		self::add_controls_section( $element, $section_id, [] );
	}


	public static function add_controls_section($element, $section_id, $args) {
		if ( ! ( $element instanceof \Elementor\Element_Base ) ) return;

		$element_id = $element->get_name();
		if ( isset( self::$registered_elements[ $element_id ] ) ) return;
		self::$registered_elements[ $element_id ] = true;

		$el_name = $element->get_name();
			$is_atomic = in_array($el_name, ['div-block', 'e-div-block', 'e-flexbox', 'atomic-widget-base']) || (strpos($el_name, 'atomic-') === 0);
			
			$target_tab = $is_atomic ? Controls_Manager::TAB_STYLE : Controls_Manager::TAB_ADVANCED;

			$element->start_controls_section(
				'royalcontrolsection_customcss',
				[
					'label' => __( 'Custom CSS [Royal]', 'royal-addons-for-elementor' ),
					'tab' => $target_tab,
				]
			);

			$element->add_control(
				'custom_css_title',
				[
					'raw' => __( 'Add your own custom CSS here', 'royal-addons-for-elementor' ),
					'type' => Controls_Manager::RAW_HTML,
				]
			);

			$element->add_control(
				'custom_css',
				[
					'type' => Controls_Manager::CODE,
					'label' => __( 'Custom CSS', 'royal-addons-for-elementor' ),
					'language' => 'css',
					'render_type' => 'ui',
					'show_label' => false,
					'separator' => 'none',
				]
			);

			$element->add_control(
				'custom_css_description',
				[
					'raw' => __( 'Use "selector" to target wrapper element. Examples:<br>selector {color: red;} // For main element<br>selector .child-element {margin: 10px;} // For child element<br>.my-class {text-align: center;} // Or use any custom selector', 'pawshop_toolkit' ),
					'type' => Controls_Manager::RAW_HTML,
					'content_classes' => 'Theme_pawshop elementor-descriptor',
				]
			);

			$element->end_controls_section();
	}


	public function add_post_css($post_css, $element) {
		if ($post_css instanceof Dynamic_CSS) {
			return;
		}

		$el_name = $element->get_name();
		$is_atomic = in_array($el_name, ['div-block', 'e-div-block', 'e-flexbox', 'atomic-widget-base']) || (strpos($el_name, 'atomic-') === 0);
		$element_settings = $is_atomic && method_exists($element, 'get_atomic_settings') ? $element->get_atomic_settings() : $element->get_settings();

		$css = isset($element_settings['custom_css']) ? $element_settings['custom_css'] : '';
		
		if (is_array($css)) {
			if (isset($css['value'])) {
				$css = $css['value'];
			} elseif (isset($css['default'])) {
				$css = $css['default'];
			} else {
				$css = reset($css);
			}
		}

		if (is_object($css) && method_exists($css, '__toString')) {
			$css = (string) $css;
		}

		if (!is_string($css)) {
			$css = '';
		}

		$css = trim($css);

		if (empty($css)) {
			return;
		}
		$id = $element->get_id();
		$selector = '.elementor-element.elementor-element-' . $id . ', [data-id="' . $id . '"]';
		$css = str_replace('selector', $selector, $css);

		// Add a css comment
		$css = sprintf('/* Start custom CSS for %s, class: %s */', $element->get_name(), $element->get_unique_selector()) . $css . '/* End custom CSS */';

		$post_css->get_stylesheet()->add_raw_css($css);
	}


	public function add_page_settings_css( $post_css ) {
		$document = \Elementor\Plugin::$instance->documents->get( $post_css->get_post_id() );
		$custom_css = $document->get_settings( 'custom_css' );
		if (is_null ($custom_css)) {
			$custom_css = '';
		}
		$custom_css = trim( $custom_css);

		if ( empty( $custom_css ) ) {
			return;
		}

		$custom_css = str_replace( 'selector', $document->get_css_wrapper_selector(), $custom_css );

		// Add a css comment
		$custom_css = '/* Start custom CSS for page-settings */' . $custom_css . '/* End custom CSS */';

		$post_css->get_stylesheet()->add_raw_css( $custom_css );
	}

	/* Enqueue Editor Script */
	public function enqueue_editor_scripts() {
		wp_enqueue_code_editor( array( 'type' => 'text/css' ) );
        wp_enqueue_script('royal-custom-css', ROYAL_ADDONS_DIR_URL.'assets/js/customcss.js', array('jquery', 'code-editor'), '', true);
	}

	public function print_atomic_custom_css( $element ) {
		$el_name = $element->get_name();
		$is_atomic = in_array($el_name, ['div-block', 'e-div-block', 'e-flexbox', 'atomic-widget-base']) || (strpos($el_name, 'atomic-') === 0);
		if ( ! $is_atomic ) {
			return;
		}

		$element_settings = method_exists($element, 'get_atomic_settings') ? $element->get_atomic_settings() : $element->get_settings();
		$css = isset($element_settings['custom_css']) ? $element_settings['custom_css'] : '';

		if (is_array($css)) {
			if (isset($css['value'])) {
				$css = $css['value'];
			} elseif (isset($css['default'])) {
				$css = $css['default'];
			} else {
				$css = reset($css);
			}
		}

		if (is_object($css) && method_exists($css, '__toString')) {
			$css = (string) $css;
		}

		if (!is_string($css)) {
			$css = '';
		}

		$css = trim($css);

		if (empty($css)) {
			return;
		}

		$selector = '.elementor-element.elementor-element-' . $element->get_id();
		$css = str_replace('selector', $selector, $css);

		echo '<style>' . $css . '</style>';
	}

}
new Royal_Custom_CSS();