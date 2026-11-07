<?php
use Elementor\Utils;
use Elementor\Repeater;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;


if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class RoyalMagicScroll {

	static $load_script = null;

	public static function init() {

		// Editor preview: always enqueue all scripts.
		add_action( 'elementor/preview/enqueue_scripts', array( __CLASS__, 'enqueue_scripts' ) );

		// Frontend: register scripts early, then conditionally enqueue by scanning
		// the Elementor document element data directly from the database.
		// This fires at the correct WordPress lifecycle point — BEFORE wp_head / wp_footer.
		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'register_and_maybe_enqueue' ), 10 );

		// Controls registration for ALL element types (section, column, widget, container, atomic, etc).
		add_action( 'elementor/element/after_section_end', [ __CLASS__, 'register_controls_atomic' ], 10, 2 );

		// Editor print_template hooks.
		add_action( 'elementor/column/print_template', array( __CLASS__, 'print_template' ), 10, 2 );
		add_action( 'elementor/widget/print_template', array( __CLASS__, 'print_template' ), 10, 2 );

		// Frontend: write data-mscroll attribute onto element wrappers (all types).
		add_action( 'elementor/frontend/before_render', array( __CLASS__, 'before_render' ), 10 );
	}

	/**
	 * Register scripts/styles early at wp_enqueue_scripts.
	 * Then scan the current page's Elementor element data (from the DB) to check
	 * whether any element has Magic Scroll enabled. If yes, enqueue everything.
	 * This is the only reliable way to enqueue conditional assets in WordPress.
	 */
	public static function register_and_maybe_enqueue() {

		// Register all scripts (not enqueue yet).
		wp_register_script( 'gsap',          ROYAL_ADDONS_DIR_URL . 'assets/vendor/gsap/gsap.min.js',          [],                                                                      '3.12.2',              true );
		wp_register_script( 'scrolltrigger', ROYAL_ADDONS_DIR_URL . 'assets/vendor/gsap/scrolltrigger.min.js', [ 'gsap' ],                                                              '3.12.2',              true );
		wp_register_script( 'motionpath',    ROYAL_ADDONS_DIR_URL . 'assets/vendor/gsap/motionpath.js',         [ 'gsap' ],                                                              '3.12.2',              true );
		wp_register_script( 'tweenmax',      ROYAL_ADDONS_DIR_URL . 'assets/vendor/gsap/tweenmax.js',           [ 'gsap' ],                                                              ROYAL_ADDONS_VERSION,  true );
		wp_register_script( 'waypoints',     ROYAL_ADDONS_DIR_URL . 'assets/vendor/gsap/waypoints.js',          [ 'jquery' ],                                                            ROYAL_ADDONS_VERSION,  true );
		wp_register_script( 'magicscroll',   ROYAL_ADDONS_DIR_URL . 'assets/vendor/gsap/magicscroll.js',        [ 'gsap', 'scrolltrigger', 'motionpath', 'tweenmax', 'waypoints', 'jquery' ], ROYAL_ADDONS_VERSION, true );
		wp_register_style(  'royalmagicscroll', ROYAL_ADDONS_DIR_URL . 'assets/css/extension-royalmagicscroll.css', [], ROYAL_ADDONS_VERSION );

		// Only proceed on Elementor-built pages.
		if ( ! class_exists( '\Elementor\Plugin' ) ) {
			return;
		}

		$post_id = get_the_ID();
		if ( ! $post_id ) {
			return;
		}

		$document = \Elementor\Plugin::$instance->documents->get( $post_id );
		if ( ! $document || ! $document->is_built_with_elementor() ) {
			return;
		}

		// Scan all element data recursively for royal_mscroll_switcher = 'yes'.
		$elements_data = $document->get_elements_data();
		if ( self::has_magic_scroll( $elements_data ) ) {
			self::enqueue_scripts();
		}
	}

	/**
	 * Recursively scan an array of Elementor element data (as stored in the DB)
	 * looking for any element that has Magic Scroll enabled.
	 *
	 * @param array $elements Elementor elements data array.
	 * @return bool True if any element has royal_mscroll_switcher = 'yes'.
	 */
	private static function has_magic_scroll( $elements ) {
		if ( empty( $elements ) || ! is_array( $elements ) ) {
			return false;
		}

		foreach ( $elements as $element ) {
			// Check this element's own settings.
			if ( isset( $element['settings']['royal_mscroll_switcher'] ) && 'yes' === $element['settings']['royal_mscroll_switcher'] ) {
				return true;
			}

			// Recurse into children (columns, inner-sections, widgets inside containers, etc).
			if ( ! empty( $element['elements'] ) ) {
				if ( self::has_magic_scroll( $element['elements'] ) ) {
					return true;
				}
			}
		}

		return false;
	}

	public static function enqueue_scripts() {
		wp_enqueue_script( 'gsap' );
		wp_enqueue_script( 'scrolltrigger' );
		wp_enqueue_script( 'motionpath' );
		wp_enqueue_script( 'tweenmax' );
		wp_enqueue_script( 'waypoints' );
		wp_enqueue_script( 'magicscroll' );
		wp_enqueue_style( 'royalmagicscroll' );
	}


	/* Atomic Elements - registered tracker for controls (per element type, not instance) */
	private static $registered_elements = [];

	public static function register_controls_atomic( $element, $section_id = '' ) {
		// Only register once per element type, on the 'section_advanced' hook
		if ( ! in_array( $section_id, [ 'section_advanced', 'section_custom_css_pro' ] ) ) return;

		$el_name = $element->get_name();
		if ( isset( self::$registered_elements[ $el_name ] ) ) {
			return;
		}
		self::$registered_elements[ $el_name ] = true;

		self::register_controls( $element );
	}

	public static function register_controls( $element ) {
		if ( ! ( $element instanceof \Elementor\Element_Base ) ) return;

		$el_name = $element->get_name();
		$is_atomic = in_array($el_name, ['div-block', 'e-div-block', 'e-flexbox', 'atomic-widget-base', 'container']) || (strpos($el_name, 'atomic-') === 0);
		
		$target_tab = Controls_Manager::TAB_ADVANCED;

		$element->start_controls_section(
			'royalcontrolsection_royalmagicscroll_atomic',
			array(
				'label' => __( 'Magic Scroll [Royal]', 'royal-addons-for-elementor' ),
				'tab'   => $target_tab,
			)
		);

		$element->add_control(
			'royal_mscroll_switcher',
			array(
				'label'        => __( 'Enable Magic Scroll', 'royal-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'prefix_class' => 'royal-mscroll-',
				'render_type'  => 'template',
			)
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'royal_mscroll_type',
			array(
				'label'       => __( 'Select Animation', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::SELECT,
				'groups'      => array(
					'position' => array(
						'label'   => __( 'Position', 'royal-addons-for-elementor' ),
						'options' => array(
							'translate' => __( 'Translate', 'royal-addons-for-elementor' ),
							'rotate'    => __( 'Rotate', 'royal-addons-for-elementor' ),
							'scale'     => __( 'Scale', 'royal-addons-for-elementor' ),
							'skew'      => __( 'Skew', 'royal-addons-for-elementor' ),
							'fadein'    => __( 'Fade In', 'royal-addons-for-elementor' ),
							'fadeout'   => __( 'Fade Out', 'royal-addons-for-elementor' ),
						),
					),

					'css'      => array(
						'label'   => __( 'CSS Properties', 'royal-addons-for-elementor' ),
						'options' => array(
							'opacity' => __( 'Opacity', 'royal-addons-for-elementor' ),
							'border'  => __( 'Border', 'royal-addons-for-elementor' ),
							'padding' => __( 'Padding', 'royal-addons-for-elementor' ),
						),
					),

					'filters'  => array(
						'label'   => __( 'CSS Filters', 'royal-addons-for-elementor' ),
						'options' => array(
							'blur'   => __( 'Blur', 'royal-addons-for-elementor' ),
							'gray'   => __( 'Grayscale', 'royal-addons-for-elementor' ),
							'bright' => __( 'Brightness', 'royal-addons-for-elementor' ),
						),
					),

					'magic'    => array(
						'label'   => __( 'More Magic', 'royal-addons-for-elementor' ),
						'options' => array(
							'color'     => __( 'Color', 'royal-addons-for-elementor' ),
							'backcolor' => __( 'Background Color', 'royal-addons-for-elementor' ),
							'font'      => __( 'Font Size', 'royal-addons-for-elementor' ),
							'spacing'   => __( 'Letter Spacing', 'royal-addons-for-elementor' ),
							'sequence'  => __( 'Images Sequence', 'royal-addons-for-elementor' ),
							'tshadow'   => __( 'Text Shadow', 'royal-addons-for-elementor' ),
							'shadow'    => __( 'Box Shadow', 'royal-addons-for-elementor' ),
							'video'     => __( 'Play Video', 'royal-addons-for-elementor' ),
							'svg'       => __( 'Draw SVG', 'royal-addons-for-elementor' ),
							'carousel'  => __( 'Carousel Scroll', 'royal-addons-for-elementor' ),
							'progress'  => __( 'Progress Bar', 'royal-addons-for-elementor' ),
							'compare'   => __( 'Image Compare', 'royal-addons-for-elementor' ),
						),
					),

					'advanced' => array(
						'label'   => __( 'Advanced', 'royal-addons-for-elementor' ),
						'options' => array(
							'custom' => __( 'Custom Path', 'royal-addons-for-elementor' ),
							'class'  => __( 'CSS Class', 'royal-addons-for-elementor' ),
						),
					),

				),
				'default'     => 'translate',
				'label_block' => true,
			)
		);

		$repeater->add_responsive_control(
			'royal_mscroll_fade_dir',
			array(
				'label'     => __( 'Fade Direction', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					'up'    => array(
						'title' => __( 'Top', 'royal-addons-for-elementor' ),
						'icon'  => 'eicon-arrow-up',
					),
					'right' => array(
						'title' => __( 'Right', 'royal-addons-for-elementor' ),
						'icon'  => 'eicon-arrow-left',
					),
					'down'  => array(
						'title' => __( 'Bottom', 'royal-addons-for-elementor' ),
						'icon'  => 'eicon-arrow-down',
					),
					'left'  => array(
						'title' => __( 'Left', 'royal-addons-for-elementor' ),
						'icon'  => 'eicon-arrow-right',
					),
				),
				'default'   => 'up',
				'condition' => array(
					'royal_mscroll_type' => array( 'fadein', 'fadeout' ),
				),
			)
		);

		$repeater->add_control(
			'royal_mscroll_apply_on',
			array(
				'label'       => __( 'Apply Animation On', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'scope'  => __( 'Element Container', 'royal-addons-for-elementor' ),
					'custom' => __( 'Custom CSS Selector', 'royal-addons-for-elementor' ),
				),
				'default'     => 'scope',
				'render_type' => 'template',
				'label_block' => true,
				'condition'   => array(
					'royal_mscroll_type!' => array( 'carousel', 'progress', 'compare', 'custom', 'video' ),
				),
			)
		);

		// TODO: Add a heading conditioned to SVG that user must add paths.
		$repeater->add_control(
			'royal_mscroll_selector',
			array(
				'label'       => __( 'CSS Selector', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'render_type' => 'template',
				'description' => __( 'Add the CSS selector to apply the effect on. By default, the effect is applied on the outer container for all effects except Play Video.', 'royal-addons-for-elementor' ),
				'conditions'  => array(
					'terms' => array(
						array(
							'relation' => 'or',
							'terms'    => array(
								array(
									'name'  => 'royal_mscroll_apply_on',
									'value' => 'custom',
								),
								array(
									'name'  => 'royal_mscroll_type',
									'value' => 'custom',
								),
								array(
									'name'  => 'royal_mscroll_type',
									'value' => 'video',
								),
							),
						),
					),
				),
			)
		);

		$repeater->add_control(
			'royal_mscroll_custompath_note',
			array(
				'raw'             => __( 'You will need to add a CSS selector for this animation. For example, img, span, or .elementor-icon, etc.', 'royal-addons-for-elementor' ),
				'type'            => Controls_Manager::RAW_HTML,
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
				'condition'       => array(
					'royal_mscroll_type' => 'custom',
				),
			)
		);

		$repeater->add_control(
			'royal_mscroll_carousel_note',
			array(
				'raw'             => __( 'Carousel effect can be used with with <b> Carousel widget</b> only.', 'royal-addons-for-elementor' ),
				'type'            => Controls_Manager::RAW_HTML,
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
				'condition'       => array(
					'royal_mscroll_type' => 'carousel',
				),
			)
		);

		$repeater->add_control(
			'royal_mscroll_compare_note',
			array(
				'raw'             => __( 'Image Compare effect can be used with with <b> Image Comparison widget</b> only.', 'royal-addons-for-elementor' ),
				'type'            => Controls_Manager::RAW_HTML,
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
				'condition'       => array(
					'royal_mscroll_type' => 'compare',
				),
			)
		);

		$repeater->add_control(
			'royal_mscroll_progress_note',
			array(
				'raw'             => __( 'Progress Bar Scroll effect can be used with with <b> Progressbar widget</b> only.', 'royal-addons-for-elementor' ),
				'type'            => Controls_Manager::RAW_HTML,
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
				'condition'       => array(
					'royal_mscroll_type' => 'progress',
				),
			)
		);

		$repeater->add_responsive_control(
			'royal_mscroll_tr_x',
			array(
				'label'       => __( 'TranslateX', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => array( 'px', '%' ),
				'description' => __( 'Set the x-axis position the element will be moved to.', 'royal-addons-for-elementor' ),
				'range'       => array(
					'px' => array(
						'min' => -400,
						'max' => 400,
					),
					'%'  => array(
						'min' => -100,
						'max' => 100,
					),
				),
				'default'     => array(
					'size' => 100,
					'unit' => 'px',
				),
				'label_block' => true,
				'condition'   => array(
					'royal_mscroll_type' => array( 'translate' ),
				),
			)
		);

		$repeater->add_responsive_control(
			'royal_mscroll_carousel_x',
			array(
				'label'       => __( 'TranslateX', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => array( 'px', '%' ),
				'range'       => array(
					'px' => array(
						'min' => -400,
						'max' => 0,
					),
					'%'  => array(
						'min' => -100,
						'max' => 0,
					),
				),
				'default'     => array(
					'size' => -200,
					'unit' => 'px',
				),
				'label_block' => true,
				'condition'   => array(
					'royal_mscroll_type' => array( 'carousel' ),
				),
			)
		);

		$repeater->add_control(
			'royal_mscroll_carousel_neg_note',
			array(
				'raw'             => __( 'Make sure to use only <b>negative</b> values for TranslateX control.', 'royal-addons-for-elementor' ),
				'type'            => Controls_Manager::RAW_HTML,
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-warning',
				'condition'       => array(
					'royal_mscroll_type' => 'carousel',
				),
			)
		);

		$repeater->add_responsive_control(
			'royal_mscroll_rot_x',
			array(
				'label'       => __( 'RotateX', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::SLIDER,
				'range'       => array(
					'px' => array(
						'min' => -360,
						'max' => 360,
					),
				),
				'default'     => array(
					'size' => 0,
					'unit' => 'px',
				),
				'label_block' => true,
				'condition'   => array(
					'royal_mscroll_type' => array( 'rotate' ),
				),
			)
		);

		$repeater->add_control(
			'royal_mscroll_sc_screen',
			array(
				'label'       => __( 'Scale to Container Width/Height', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::SWITCHER,
				'description' => __( 'Enable this to scale the element until its width/height is equal to the parent container width/height.', 'royal-addons-for-elementor' ),
				'condition'   => array(
					'royal_mscroll_type' => array( 'scale' ),
				),
			)
		);

		$repeater->add_responsive_control(
			'royal_mscroll_sc_xvalue',
			array(
				'label'       => __( 'Scale X', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::SLIDER,
				'range'       => array(
					'px' => array(
						'min'  => 0,
						'max'  => 3,
						'step' => 0.1,
					),
				),
				'default'     => array(
					'size' => 1.2,
					'unit' => 'px',
				),
				'label_block' => true,
				'condition'   => array(
					'royal_mscroll_type'       => array( 'scale' ),
					'royal_mscroll_sc_screen!' => 'yes',
				),
			)
		);

		$repeater->add_responsive_control(
			'royal_mscroll_sk_xvalue',
			array(
				'label'       => __( 'Skew X', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::SLIDER,
				'range'       => array(
					'px' => array(
						'min' => -360,
						'max' => 360,
					),
				),
				'default'     => array(
					'size' => 0,
					'unit' => 'px',
				),
				'label_block' => true,
				'condition'   => array(
					'royal_mscroll_type' => array( 'skew' ),
				),
			)
		);

		$repeater->add_responsive_control(
			'royal_mscroll_origx',
			array(
				'label'       => __( 'Transform Origin X', 'royal-addons-for-elementor' ),
				'default'     => 'center',
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'left'   => __( 'Left', 'royal-addons-for-elementor' ),
					'center' => __( 'Center', 'royal-addons-for-elementor' ),
					'right'  => __( 'Right', 'royal-addons-for-elementor' ),
					'custom' => __( 'Custom', 'royal-addons-for-elementor' ),
				),
				'label_block' => false,
				'condition'   => array(
					'royal_mscroll_type'       => array( 'rotate', 'translate', 'scale', 'skew' ),
					'royal_mscroll_sc_screen!' => 'yes',
				),
			)
		);

		$repeater->add_responsive_control(
			'royal_mscroll_origx_custom',
			array(
				'label'       => __( 'Custom Origin', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => array( 'px', '%' ),
				'range'       => array(
					'px' => array(
						'min' => -100,
						'max' => 100,
					),
					'%'  => array(
						'min' => -100,
						'max' => 100,
					),
				),
				'label_block' => true,
				'condition'   => array(
					'royal_mscroll_type'       => array( 'rotate', 'translate', 'scale', 'skew' ),
					'royal_mscroll_origx'      => 'custom',
					'royal_mscroll_sc_screen!' => 'yes',
				),
			)
		);

		$repeater->add_responsive_control(
			'royal_mscroll_tr_y',
			array(
				'label'       => __( 'TranslateY (PX)', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => array( 'px', '%' ),
				'description' => __( 'Set the y-axis position the element will be moved to.', 'royal-addons-for-elementor' ),
				'range'       => array(
					'px' => array(
						'min' => -400,
						'max' => 400,
					),
					'%'  => array(
						'min' => -100,
						'max' => 100,
					),
				),
				'separator'   => 'before',
				'default'     => array(
					'size' => 100,
					'unit' => 'px',
				),
				'label_block' => true,
				'condition'   => array(
					'royal_mscroll_type' => array( 'translate' ),
				),
			)
		);

		$repeater->add_responsive_control(
			'royal_mscroll_rot_y',
			array(
				'label'       => __( 'RotateY', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::SLIDER,
				'range'       => array(
					'px' => array(
						'min' => -360,
						'max' => 360,
					),
				),
				'separator'   => 'before',
				'default'     => array(
					'size' => 0,
					'unit' => 'px',
				),
				'label_block' => true,
				'condition'   => array(
					'royal_mscroll_type' => array( 'rotate' ),
				),
			)
		);

		$repeater->add_responsive_control(
			'royal_mscroll_sc_yvalue',
			array(
				'label'       => __( 'Scale Y', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::SLIDER,
				'range'       => array(
					'px' => array(
						'min'  => 0,
						'max'  => 3,
						'step' => 0.1,
					),
				),
				'separator'   => 'before',
				'default'     => array(
					'size' => 1.2,
					'unit' => 'px',
				),
				'label_block' => true,
				'condition'   => array(
					'royal_mscroll_type'       => array( 'scale' ),
					'royal_mscroll_sc_screen!' => 'yes',
				),
			)
		);

		$repeater->add_responsive_control(
			'royal_mscroll_sk_yvalue',
			array(
				'label'       => __( 'Skew Y', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::SLIDER,
				'range'       => array(
					'px' => array(
						'min' => -360,
						'max' => 360,
					),
				),
				'default'     => array(
					'size' => 0,
					'unit' => 'px',
				),
				'label_block' => true,
				'condition'   => array(
					'royal_mscroll_type' => array( 'skew' ),
				),
			)
		);

		$repeater->add_responsive_control(
			'royal_mscroll_origy',
			array(
				'label'       => __( 'Transform Origin Y', 'royal-addons-for-elementor' ),
				'default'     => 'center',
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'top'    => __( 'Top', 'royal-addons-for-elementor' ),
					'center' => __( 'Center', 'royal-addons-for-elementor' ),
					'bottom' => __( 'Bottom', 'royal-addons-for-elementor' ),
					'custom' => __( 'Custom', 'royal-addons-for-elementor' ),
				),
				'label_block' => false,
				'condition'   => array(
					'royal_mscroll_type'       => array( 'rotate', 'translate', 'scale', 'skew' ),
					'royal_mscroll_sc_screen!' => 'yes',
				),
			)
		);

		$repeater->add_responsive_control(
			'royal_mscroll_origy_custom',
			array(
				'label'       => __( 'Custom Origin', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => array( 'px', '%' ),
				'range'       => array(
					'px' => array(
						'min' => -100,
						'max' => 100,
					),
					'%'  => array(
						'min' => -100,
						'max' => 100,
					),
				),
				'label_block' => true,
				'condition'   => array(
					'royal_mscroll_type'       => array( 'rotate', 'translate', 'scale', 'skew' ),
					'royal_mscroll_origy'      => 'custom',
					'royal_mscroll_sc_screen!' => 'yes',
				),
			)
		);

		$repeater->add_responsive_control(
			'royal_mscroll_rot_z',
			array(
				'label'       => __( 'RotateZ', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::SLIDER,
				'range'       => array(
					'px' => array(
						'min' => -360,
						'max' => 360,
					),
				),
				'default'     => array(
					'size' => 360,
					'unit' => 'px',
				),
				'separator'   => 'before',
				'label_block' => true,
				'condition'   => array(
					'royal_mscroll_type' => array( 'rotate' ),
				),
			)
		);

		$repeater->add_responsive_control(
			'royal_mscroll_op_value',
			array(
				'label'       => __( 'Opacity', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::SLIDER,
				'range'       => array(
					'px' => array(
						'min'  => 0,
						'max'  => 1,
						'step' => 0.1,
					),
				),
				'default'     => array(
					'size' => 0.5,
					'unit' => 'px',
				),
				'label_block' => true,
				'condition'   => array(
					'royal_mscroll_type' => array( 'opacity' ),
				),
			)
		);

		$repeater->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'           => 'royal_mscroll_border',
				'selector'       => '',
				'fields_options' => array(
					'width' => array(
						'responsive' => false,
					),
				),
				'condition'      => array(
					'royal_mscroll_type' => array( 'border' ),
				),
			)
		);

		$repeater->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'           => 'royal_mscroll_sh',
				'selector'       => '',
				'condition'      => array(
					'royal_mscroll_type' => array( 'shadow' ),
				),
				'fields_options' => array(
					'box_shadow'          => array(
						'render_type' => 'template',
					),
					'box_shadow_position' => array(
						'render_type' => 'template',
					),
				),
			)
		);

		$repeater->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			array(
				'name'           => 'royal_mscroll_tsh',
				'selector'       => '',
				'condition'      => array(
					'royal_mscroll_type' => array( 'tshadow' ),
				),
				'fields_options' => array(
					'text_shadow' => array(
						'render_type' => 'template',
					),
				),
			)
		);

		$repeater->add_control(
			'royal_mscroll_border_r',
			array(
				'label'      => __( 'Border Radius', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em', '%' ),
				'condition'  => array(
					'royal_mscroll_type' => array( 'border' ),
				),
			)
		);

		$repeater->add_control(
			'royal_mscroll_border_ra',
			array(
				'label'       => __( 'Advanced Border Radius', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::SWITCHER,
				'description' => __( 'Apply custom radius values. Get the radius value from ', 'royal-addons-for-elementor' ) . '<a href="https://mehdiakram.github.io/fancy-border-radius/" target="_blank">here</a>' . __('. See ', 'royal-addons-for-elementor') . '<a href="https://www.youtube.com/watch?v=S0BJazLHV-M" target="_blank">tutorial</a>',
				'condition'   => array(
					'royal_mscroll_type' => array( 'border' ),
				),
			)
		);

		$repeater->add_control(
			'royal_mscroll_border_ra_value',
			array(
				'label'     => __( 'Border Radius', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'condition' => array(
					'royal_mscroll_border_ra' => 'yes',
					'royal_mscroll_type'      => array( 'border' ),
				),
			)
		);

		$repeater->add_responsive_control(
			'royal_mscroll_padding',
			array(
				'label'      => __( 'Padding', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'default'    => array(
					'unit'   => 'px',
					'top'    => 10,
					'right'  => 10,
					'bottom' => 10,
					'left'   => 10,
				),
				'condition'  => array(
					'royal_mscroll_type' => array( 'padding' ),
				),
			)
		);

		$repeater->add_responsive_control(
			'royal_mscroll_blur',
			array(
				'label'     => __( 'Blur Value (px)', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min'  => 0,
						'max'  => 15,
						'step' => 0.1,
					),
				),
				'default'   => array(
					'size' => 1.2,
					'unit' => 'px',
				),
				'condition' => array(
					'royal_mscroll_type' => array( 'blur' ),
				),
			)
		);

		$repeater->add_responsive_control(
			'royal_mscroll_gscale',
			array(
				'label'     => __( 'Grayscale Value', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min' => 0,
						'max' => 200,
					),
				),
				'default'   => array(
					'size' => 100,
					'unit' => 'px',
				),
				'condition' => array(
					'royal_mscroll_type' => array( 'gray' ),
				),
			)
		);

		$repeater->add_responsive_control(
			'royal_mscroll_bright',
			array(
				'label'     => __( 'Brightness Value (%)', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min' => 0,
						'max' => 200,
					),
				),
				'default'   => array(
					'size' => 100,
					'unit' => 'px',
				),
				'condition' => array(
					'royal_mscroll_type' => array( 'bright' ),
				),
			)
		);

		$repeater->add_control(
			'royal_mscroll_path_type',
			array(
				'label'       => __( 'Path Type', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'svg'    => __( 'SVG Path', 'royal-addons-for-elementor' ),
					'points' => __( 'Custom Points', 'royal-addons-for-elementor' ),
				),
				'default'     => 'svg',
				'label_block' => true,
				'condition'   => array(
					'royal_mscroll_type' => 'custom',
				),
			)
		);

		$repeater->add_responsive_control(
			'royal_mscroll_path_points',
			array(
				'label'       => __( 'Custom Points', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXTAREA,
				'description' => __( 'Add multiple points. For example, {50,20},{100,-50},{200,200}', 'royal-addons-for-elementor' ),
				'condition'   => array(
					'royal_mscroll_type'      => 'custom',
					'royal_mscroll_path_type' => 'points',
				),
			)
		);

		$repeater->add_control(
			'royal_mscroll_svg_path',
			array(
				'label'       => __( 'SVG Path', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXTAREA,
				'description' => __( 'Put the SVG path code. You can create paths from ', 'royal-addons-for-elementor' ) . '<a href="https://codepen.io/mehdiakram/full/dPPqMNo" target="_blank">here</a>',
				'condition'   => array(
					'royal_mscroll_type'      => 'custom',
					'royal_mscroll_path_type' => 'svg',
				),
			)
		);

		$repeater->add_responsive_control(
			'royal_mscroll_stroke_width',
			array(
				'label'     => __( 'Stroke Thickness', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min'  => 0,
						'max'  => 10,
						'step' => 0.1,
					),
				),
				'default'   => array(
					'size' => 2,
					'unit' => 'px',
				),
				'condition' => array(
					'royal_mscroll_type'      => 'custom',
					'royal_mscroll_path_type' => 'svg',
				),
				'selectors' => array(
					'{{CURRENT_ITEM}}.royal-mscroll-svg svg path' => 'stroke-width: {{SIZE}}',
				),
			)
		);

		$repeater->add_control(
			'royal_mscroll_stroke_color',
			array(
				'label'     => __( 'Stroke Color', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => false,
				'default'   => '#6EC1E4',
				'condition' => array(
					'royal_mscroll_type'      => 'custom',
					'royal_mscroll_path_type' => 'svg',
				),
				'selectors' => array(
					'{{CURRENT_ITEM}}.royal-mscroll-svg svg path' => 'stroke: {{VALUE}}',
				),
			)
		);

		$repeater->add_control(
			'royal_mscroll_stroke_dashes',
			array(
				'label'     => __( 'Space Between Dashes', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min'  => 0,
						'max'  => 10,
						'step' => 0.1,
					),
				),
				'default'   => array(
					'size' => 3,
					'unit' => 'px',
				),
				'condition' => array(
					'royal_mscroll_type'      => 'custom',
					'royal_mscroll_path_type' => 'svg',
				),
				'selectors' => array(
					'{{CURRENT_ITEM}}.royal-mscroll-svg svg path' => 'stroke-dasharray: {{SIZE}}',
				),
			)
		);

		$repeater->add_responsive_control(
			'royal_mscroll_st_x',
			array(
				'label'     => __( 'X Position', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min'  => -100,
						'max'  => 100,
						'step' => 1,
					),
				),
				'condition' => array(
					'royal_mscroll_type'      => 'custom',
					'royal_mscroll_path_type' => 'svg',
				),
			)
		);

		$repeater->add_responsive_control(
			'royal_mscroll_st_y',
			array(
				'label'     => __( 'Y Position', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min'  => -100,
						'max'  => 100,
						'step' => 1,
					),
				),
				'condition' => array(
					'royal_mscroll_type'      => 'custom',
					'royal_mscroll_path_type' => 'svg',
				),
			)
		);

		$repeater->add_responsive_control(
			'royal_mscroll_st_zoom',
			array(
				'label'     => __( 'Zoom', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 1,
				'condition' => array(
					'royal_mscroll_type'      => 'custom',
					'royal_mscroll_path_type' => 'svg',
				),
			)
		);

		$repeater->add_responsive_control(
			'royal_mscroll_st_height',
			array(
				'label'       => __( 'Height', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::SLIDER,
				'range'       => array(
					'px' => array(
						'min' => 0,
						'max' => 500,
					),
				),
				'render_type' => 'template',
				'condition'   => array(
					'royal_mscroll_type'      => 'custom',
					'royal_mscroll_path_type' => 'svg',
				),
				'selectors'   => array(
					'{{CURRENT_ITEM}}.royal-mscroll-svg svg' => 'height:  {{SIZE}}px',
				),
			)
		);

		$repeater->add_control(
			'royal_mscroll_gallery',
			array(
				'label'     => __( 'Select Images', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::GALLERY,
				'condition' => array(
					'royal_mscroll_type' => array( 'sequence' ),
				),
			)
		);

		$repeater->add_responsive_control(
			'royal_mscroll_color',
			array(
				'label'     => __( 'Select Color', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => false,
				'classes'   => 'editor-pa-color-control',
				'condition' => array(
					'royal_mscroll_type' => array( 'color', 'backcolor' ),
				),
			)
		);

		$repeater->add_responsive_control(
			'royal_mscroll_css_class',
			array(
				'label'       => __( 'CSS Class', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => 'test-class',
				'description' => __( 'Add a CSS class to be added to the element above. Note that the CSS class will not be removed on scroll back.', 'royal-addons-for-elementor' ),
				'condition'   => array(
					'royal_mscroll_type' => array( 'class' ),
				),
			)
		);

		$repeater->add_responsive_control(
			'royal_mscroll_font',
			array(
				'label'     => __( 'Font Size (px)', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min' => 1,
						'max' => 200,
					),
				),
				'condition' => array(
					'royal_mscroll_type' => array( 'font' ),
				),
			)
		);

		$repeater->add_responsive_control(
			'royal_mscroll_letter_spacing',
			array(
				'label'     => __( 'Letter Spacing (px)', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min'  => 0,
						'max'  => 10,
						'step' => 0.1,
					),
				),
				'condition' => array(
					'royal_mscroll_type' => array( 'spacing' ),
				),
			)
		);

		$repeater->add_control(
			'royal_mscroll_video_note',
			array(
				'raw'             => __( 'Use this option to play self-hosted videos on scroll. It can be used with  Video Box widget -> Self Hosted option.', 'royal-addons-for-elementor' ),
				'type'            => Controls_Manager::RAW_HTML,
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
				'condition'       => array(
					'royal_mscroll_type' => array( 'video' ),
				),
			)
		);

		$repeater->add_control(
			'royal_mscroll_reverse',
			array(
				'label'     => __( 'Reverse Animation', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'separator' => 'before',
				'condition' => array(
					'royal_mscroll_type!' => array( 'sequence', 'class', 'font', 'spacing', 'video', 'progress', 'compare', 'fadein', 'fadeout' ),
				),
			)
		);

		$repeater->add_control(
			'royal_mscroll_draw_start',
			array(
				'label'       => __( 'Start Point (%)', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::SLIDER,
				'description' => __( 'Set the point that the SVG should start from.', 'royal-addons-for-elementor' ),
				'default'     => array(
					'unit' => '%',
					'size' => 0,
				),
				'condition'   => array(
					'royal_mscroll_type'     => array( 'svg' ),
					'royal_mscroll_reverse!' => 'yes',
				),
			)
		);

		$repeater->add_control(
			'royal_mscroll_draw_end',
			array(
				'label'       => __( 'End Point (%)', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::SLIDER,
				'description' => __( 'Set the point that the SVG should end at.', 'royal-addons-for-elementor' ),
				'default'     => array(
					'unit' => '%',
					'size' => 0,
				),
				'condition'   => array(
					'royal_mscroll_type'    => array( 'svg' ),
					'royal_mscroll_reverse' => 'yes',
				),
			)
		);

		$repeater->add_control(
			'royal_mscroll_draw_sync',
			array(
				'label'     => __( 'Draw all SVG paths together', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'condition' => array(
					'royal_mscroll_type' => array( 'svg' ),
				),
			)
		);

		$repeater->add_control(
			'royal_mscroll_svg_fill',
			array(
				'label'     => __( 'Fill Color After Draw', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'condition' => array(
					'royal_mscroll_type' => array( 'svg' ),
				),
			)
		);

		$repeater->add_control(
			'royal_mscroll_fill_af_full',
			array(
				'label'     => __( 'Fill Color After Fully Drawn', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'condition' => array(
					'royal_mscroll_type'       => array( 'svg' ),
					'royal_mscroll_draw_sync!' => 'yes',
				),
			)
		);

		$repeater->add_control(
			'royal_mscroll_svg_color',
			array(
				'label'     => __( 'Select Color', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => false,
				'condition' => array(
					'royal_mscroll_type'     => 'svg',
					'royal_mscroll_svg_fill' => 'yes',
				),
			)
		);

		$repeater->add_control(
			'royal_mscroll_sync',
			array(
				'label'     => __( 'Sync with the Previous Animation', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'separator' => 'before',
				'condition' => array(
					'royal_mscroll_sync_lock!' => 'yes',
				),
			)
		);

		$repeater->add_responsive_control(
			'royal_mscroll_delay',
			array(
				'label'       => __( 'Delay (sec)', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::SLIDER,
				'description' => __( 'Negative values means this animation will start before the previous animation ends', 'royal-addons-for-elementor' ),
				'range'       => array(
					'px' => array(
						'min'  => -2,
						'max'  => 5,
						'step' => 0.1,
					),
				),
				'label_block' => true,
				'condition'   => array(
					'royal_mscroll_sync!'      => 'yes',
					'royal_mscroll_sync_lock!' => 'yes',
				),
			)
		);

		$repeater->add_control(
			'royal_mscroll_sync_note',
			array(
				'raw'             => __( 'Please note that this option will be overriden by Run All Effects Simultaneously option', 'royal-addons-for-elementor' ),
				'type'            => Controls_Manager::RAW_HTML,
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
				'condition'       => array(
					'royal_mscroll_sync' => 'yes',
				),
			)
		);

		$repeater->add_control(
			'royal_mscroll_sync_lock',
			array(
				'label'     => __( 'Sync with the whole scene', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'condition' => array(
					'royal_mscroll_sync!' => 'yes',
				),
			)
		);

		$repeater->add_control(
			'royal_mscroll_ease',
			array(
				'label'       => __( 'Easing', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::SELECT,
				'separator'   => 'before',
				'options'     => array(
					'linear'    => __( 'Linear', 'royal-addons-for-elementor' ),
					'easein'    => __( 'EaseIn', 'royal-addons-for-elementor' ),
					'easeout'   => __( 'EaseOut', 'royal-addons-for-elementor' ),
					'easeinout' => __( 'EaseInOut', 'royal-addons-for-elementor' ),
					'custom'    => __( 'Custom', 'royal-addons-for-elementor' ),
				),
				'default'     => 'easein',
				'label_block' => true,
			)
		);

		$repeater->add_control(
			'royal_mscroll_c_ease',
			array(
				'label'       => __( 'Easing Function', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'description' => sprintf( 'Copy and paste the <b>ease</b> value from %s . For example, Bounce.easeOut, SteppedEase.config(12), etc.', ' <a href="https://greensock.com/docs/v2/Easing" target="_blank">here</a>' ),
				'label_block' => true,
				'condition'   => array(
					'royal_mscroll_ease' => 'custom',
				),
			)
		);

		$repeater->add_control(
			'royal_mscroll_disable_anim',
			array(
				'label'       => __( 'Disable Animation On', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::SELECT2,
				'options'     => [
					'desktop' => __( 'Desktop', 'royal-addons-for-elementor' ),
					'tablet' => __( 'Tablet', 'royal-addons-for-elementor' ),
					'mobile' => __( 'Mobile', 'royal-addons-for-elementor' ),
				],
				'separator'   => 'before',
				'multiple'    => true,
				'label_block' => true,
			)
		);

		$should_apply = apply_filters( 'pa_display_conditions_values', true );

		$values = $repeater->get_controls();

		if ( $should_apply ) {
			// $values = array_values( $values );
		}

		$element->add_control(
			'royal_mscroll_repeater',
			array(
				'type'          => Controls_Manager::REPEATER,
				'fields'        => $values,
				'title_field'   => '{{{ royal_mscroll_type }}}',
				'condition'     => array(
					'royal_mscroll_switcher' => 'yes',
				),
				'prevent_empty' => false,
			)
		);

		$element->add_control(
			'royal_mscroll_perspective',
			array(
				'label'     => __( 'Perspective (PX)', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min'  => 0,
						'max'  => 1000,
						'step' => 1,
					),
				),
				'condition' => array(
					'royal_mscroll_switcher' => 'yes',
				),
			)
		);

		$element->add_control(
			'royal_mscroll_perspective_notice',
			array(
				'raw'             => __( 'Perspective value is used with Translate, Rotate, Skew effects to create 3D effects.', 'royal-addons-for-elementor' ),
				'type'            => Controls_Manager::RAW_HTML,
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
				'condition'       => array(
					'royal_mscroll_switcher'           => 'yes',
					'royal_mscroll_perspective[size]!' => '',
				),
			)
		);

		$element->add_control(
			'royal_mscroll_all_sync',
			array(
				'label'        => __( 'Run All Effects Simultaneously', 'royal-addons-for-elementor' ),
				'description'  => __( 'Enable this option to start/end all scroll effects above at the same moment.', 'royal-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'prefix_class' => 'royal-mscroll-sync-',
				'render_type'  => 'template',
				'condition'    => array(
					'royal_mscroll_switcher' => 'yes',
				),
			)
		);

		$element->add_control(
			'royal_mscroll_loop',
			array(
				'label'     => __( 'Loop Count', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 0,
				'separator' => 'after',
				'condition' => array(
					'royal_mscroll_switcher' => 'yes',
				),
			)
		);

		$element->add_control(
			'royal_mscroll_anim_trigger',
			array(
				'label'       => __( 'How this animation should work?', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'lock'      => __( 'Lock Page Scroll Until Animation Ends', 'royal-addons-for-elementor' ),
					'automatic' => __( 'Complete Animation On Viewport', 'royal-addons-for-elementor' ),
					'play'      => __( 'Play Animation Only When Visible', 'royal-addons-for-elementor' ),
					'sticky'    => __( 'Stick to another element', 'royal-addons-for-elementor' ),
				),
				'default'     => 'play',
				'render_type' => 'template',
				'label_block' => true,
				'condition'   => array(
					'royal_mscroll_switcher' => 'yes',
				),
			)
		);

		$refresh_button = ' <b> IMPORTANT: You may need to click the Refresh button after changing this option.</b>';

		$element->add_control(
			'royal_mscroll_lock_note',
			array(
				'raw'             => __( 'This means that the page scroll will stop until the animation is completed.' . $refresh_button, 'royal-addons-for-elementor' ),
				'type'            => Controls_Manager::RAW_HTML,
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
				'condition'       => array(
					'royal_mscroll_switcher'     => 'yes',
					'royal_mscroll_anim_trigger' => 'lock',
				),
			)
		);

		$element->add_control(
			'royal_mscroll_auto_note',
			array(
				'raw'             => __( 'This means that the animation will start and complete once the viewport\'s top hits the top of the container.' . $refresh_button, 'royal-addons-for-elementor' ),
				'type'            => Controls_Manager::RAW_HTML,
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
				'condition'       => array(
					'royal_mscroll_switcher'     => 'yes',
					'royal_mscroll_anim_trigger' => 'automatic',
				),
			)
		);

		$element->add_control(
			'royal_mscroll_play_note',
			array(
				'raw'             => __( 'This means that the animation will work only when the element is visible on the viewport.' . $refresh_button, 'royal-addons-for-elementor' ),
				'type'            => Controls_Manager::RAW_HTML,
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
				'condition'       => array(
					'royal_mscroll_switcher'     => 'yes',
					'royal_mscroll_anim_trigger' => 'play',
				),
			)
		);

		$element->add_control(
			'royal_mscroll_anim_dur',
			array(
				'label'     => __( 'Animation Duration (sec)', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min'  => 0.1,
						'max'  => 10,
						'step' => 0.1,
					),
				),
				'default'   => array(
					'unit' => 'px',
					'size' => 3,
				),
				'condition' => array(
					'royal_mscroll_switcher'     => 'yes',
					'royal_mscroll_anim_trigger' => 'automatic',
				),
			)
		);

		$element->add_control(
			'royal_mscroll_anim_del',
			array(
				'label'     => __( 'Animation Delay (sec)', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min'  => 0.1,
						'max'  => 10,
						'step' => 0.1,
					),
				),
				'condition' => array(
					'royal_mscroll_switcher'     => 'yes',
					'royal_mscroll_anim_trigger' => 'automatic',
				),
			)
		);

		$element->add_control(
			'royal_mscroll_auto_trigger',
			array(
				'label'       => __( 'When the animation should start?', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'top'    => __( 'Top of Viewport Hits The Container', 'royal-addons-for-elementor' ),
					'center' => __( 'Center of Viewport Hits The Container', 'royal-addons-for-elementor' ),
					'custom' => __( 'Custom Offset', 'royal-addons-for-elementor' ),
				),
				'default'     => 'top',
				'label_block' => true,
				'condition'   => array(
					'royal_mscroll_switcher'     => 'yes',
					'royal_mscroll_anim_trigger' => 'automatic',
				),
			)
		);

		$element->add_control(
			'royal_mscroll_auto_offset',
			array(
				'label'     => __( 'Offset (%)', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'condition' => array(
					'royal_mscroll_switcher'     => 'yes',
					'royal_mscroll_anim_trigger' => 'automatic',
					'royal_mscroll_auto_trigger' => 'custom',
				),
			)
		);

		$element->add_control(
			'royal_mscroll_anim_rev',
			array(
				'label'       => __( 'Reverse Animation on Scroll Up', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::SWITCHER,
				'render_type' => 'template',
				'condition'   => array(
					'royal_mscroll_switcher'     => 'yes',
					'royal_mscroll_anim_trigger' => 'automatic',
				),
			)
		);

		$element->add_responsive_control(
			'royal_mscroll_order',
			array(
				'label'       => __( 'Animation Order', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => __( 'Set the animation order. For example, 1 means first animation, 2 means second animation, and so on.', 'royal-addons-for-elementor' ),
				'default'     => 1,
				'condition'   => array(
					'royal_mscroll_switcher'     => 'yes',
					'royal_mscroll_anim_trigger' => 'lock',
				),
			)
		);

		$element->add_control(
			'royal_mscroll_lock_delay',
			array(
				'label'       => __( 'Delay (sec)', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::SLIDER,
				'description' => __( 'Negative values means this animation will start before the previous animation ends', 'royal-addons-for-elementor' ),
				'range'       => array(
					'px' => array(
						'min'  => -2,
						'max'  => 2,
						'step' => 0.1,
					),
				),
				'label_block' => true,
				'condition'   => array(
					'royal_mscroll_switcher'     => 'yes',
					'royal_mscroll_anim_trigger' => 'lock',
					'royal_mscroll_order!'       => 1,
				),
			)
		);

		$element->add_control(
			'royal_mscroll_sticky_target',
			array(
				'label'     => __( 'Apply Sticky On', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => array(
					'scope'  => __( 'Element Container', 'royal-addons-for-elementor' ),
					'custom' => __( 'Custom CSS Selector', 'royal-addons-for-elementor' ),
				),
				'default'   => 'scope',
				'condition' => array(
					'royal_mscroll_switcher'     => 'yes',
					'royal_mscroll_anim_trigger' => 'sticky',
				),
			)
		);

		$element->add_control(
			'royal_mscroll_sticky_target_css',
			array(
				'label'       => __( 'CSS Selector', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'description' => __( 'Set the CSS selector of the element to be sticky.', 'royal-addons-for-elementor' ),
				'condition'   => array(
					'royal_mscroll_switcher'      => 'yes',
					'royal_mscroll_anim_trigger'  => 'sticky',
					'royal_mscroll_sticky_target' => 'custom',
				),
			)
		);

		$element->add_control(
			'royal_mscroll_sticky_element',
			array(
				'label'       => __( 'Stick this Element to', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'description' => __( 'Set the CSS selector of the element to be sticky with.', 'royal-addons-for-elementor' ),
				'condition'   => array(
					'royal_mscroll_switcher'     => 'yes',
					'royal_mscroll_anim_trigger' => 'sticky',
				),
			)
		);

		$element->add_control(
			'royal_mscroll_sticky_note',
			array(
				'raw'             => __( 'No elements on the page has this CSS selector', 'royal-addons-for-elementor' ),
				'type'            => Controls_Manager::RAW_HTML,
				'content_classes' => 'elementor-control elementor-hidden-control elementor-panel-alert elementor-panel-alert-warning',
				'condition'       => array(
					'royal_mscroll_anim_trigger' => 'sticky',
				),
			)
		);

		$element->add_control(
			'royal_mscroll_sticky_start',
			array(
				'label'       => __( 'Start Sticky From', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'absolute' => __( 'Top of the reference element', 'royal-addons-for-elementor' ),
					'relative' => __( 'The current position', 'royal-addons-for-elementor' ),
				),
				'default'     => 'absolute',
				'render_type' => 'template',
				'label_block' => true,
				'condition'   => array(
					'royal_mscroll_switcher'     => 'yes',
					'royal_mscroll_anim_trigger' => 'sticky',
				),
			)
		);

		$element->add_control(
			'royal_mscroll_play_ref',
			array(
				'label'       => __( 'Start Animation From', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'section' => __( 'Top of the parent container', 'royal-addons-for-elementor' ),
					'element' => __( 'Top of the element', 'royal-addons-for-elementor' ),
				),
				'default'     => 'section',
				'label_block' => true,
				'condition'   => array(
					'royal_mscroll_switcher'     => 'yes',
					'royal_mscroll_anim_trigger' => 'play',
				),
			)
		);

		$element->add_control(
			'royal_mscroll_play_offset',
			array(
				'label'       => __( 'Offset (%)', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::SLIDER,
				'description' => __( 'Set offset between top of the viewport and when the animation starts.', 'royal-addons-for-elementor' ),
				'default'     => array(
					'size' => 50,
					'unit' => '%',
				),
				'label_block' => true,
				'condition'   => array(
					'royal_mscroll_switcher'     => 'yes',
					'royal_mscroll_anim_trigger' => array( 'sticky', 'play' ),
				),
			)
		);

		$element->add_responsive_control(
			'royal_mscroll_scene_speed',
			array(
				'label'       => __( 'Decrease Animation Speed By', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::SLIDER,
				'description' => __( 'The larger the value you set the slower the scene will animate', 'royal-addons-for-elementor' ),
				'range'       => array(
					'px' => array(
						'min'  => 0,
						'max'  => 10,
						'step' => 0.1,
					),
				),
				'default'     => array(
					'size' => 1,
					'unit' => 'px',
				),
				'condition'   => array(
					'royal_mscroll_switcher'     => 'yes',
					'royal_mscroll_anim_trigger' => array( 'lock', 'play' ),
				),
			)
		);

		$element->add_responsive_control(
			'royal_mscroll_scrub',
			array(
				'label'       => __( 'Scrub', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::SLIDER,
				'description' => __( 'This option controls the time delay after you scroll and before the animation happens. Leave empty if you want the animation to be synced with the page scroll.', 'royal-addons-for-elementor' ),
				'range'       => array(
					'px' => array(
						'min'  => 0.1,
						'max'  => 2,
						'step' => 0.1,
					),
				),
				'condition'   => array(
					'royal_mscroll_switcher'      => 'yes',
					'royal_mscroll_anim_trigger!' => array( 'automatic', 'sticky' ),
				),
			)
		);

		$element->add_control(
			'royal_mscroll_sticky_end',
			array(
				'label'       => __( 'Stop Sticky', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'before' => __( 'Before the reference element ends', 'royal-addons-for-elementor' ),
					'after'  => __( 'After the reference element ends', 'royal-addons-for-elementor' ),
				),
				'default'     => 'before',
				'label_block' => true,
				'condition'   => array(
					'royal_mscroll_switcher'     => 'yes',
					'royal_mscroll_anim_trigger' => 'sticky',
				),
			)
		);

		$element->add_control(
			'royal_mscroll_disable_sticky',
			array(
				'label'       => __( 'Disable Sticky On', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::SELECT2,
				'options'     => [
					'desktop' => __( 'Desktop', 'royal-addons-for-elementor' ),
					'tablet' => __( 'Tablet', 'royal-addons-for-elementor' ),
					'mobile' => __( 'Mobile', 'elementor' ),
				],
				'separator'   => 'before',
				'multiple'    => true,
				'label_block' => true,
				'condition'   => array(
					'royal_mscroll_switcher'     => 'yes',
					'royal_mscroll_anim_trigger' => 'sticky',
				),
			)
		);

		$element->add_control(
			'royal_mscroll_update',
			array(
				'label'     => '<div class="elementor-update-preview editor-pa-preview-update"><div class="elementor-update-preview-title">Found something wrong? Click Refresh</div><div class="elementor-update-preview-button-wrapper"><button class="elementor-update-preview-button elementor-button elementor-button-success">Refresh</button></div></div>',
				'type'      => Controls_Manager::RAW_HTML,
				'separator' => 'before',
			)
		);

		$element->add_control(
			'resposive_settings',
			[
				'label' => esc_html__( 'Resposive Settings', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);


		$element->start_controls_tabs( 'royal_mscroll_tabs' );

		// Desktop tab.
		$element->start_controls_tab(
			'mscroll_desktop_tab',
			array(
				'label' => __( 'Desktop', 'royal-addons-for-elementor' ),
			)
		);

		$element->add_control(
			'mscroll_desktop_action',
			array(
				'label'       => __( 'Action', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'none'    => __( 'Default', 'royal-addons-for-elementor' ),
					'disable' => __( 'Disable Magic Scroll Totally', 'royal-addons-for-elementor' ),
					'height'  => __( 'Disable Lock Page Scroll', 'royal-addons-for-elementor' ),
				),
				'default'     => 'none',
				'render_type' => 'template',
				'label_block' => true,
			)
		);

		$element->add_control(
			'mscroll_desktop_lock',
			array(
				'label'       => __( 'When to Lock Page Scroll', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'window' => __( 'Container Height Larger Than Window Height', 'royal-addons-for-elementor' ),
					'custom' => __( 'Container Height Larger Than Specfic Height', 'royal-addons-for-elementor' ),
				),
				'default'     => 'window',
				'label_block' => true,
				'condition'   => array(
					'mscroll_desktop_action' => 'height',
				),
			)
		);

		$element->add_control(
			'mscroll_desktop_lock_height',
			array(
				'label'     => __( 'Height (PX)', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 500,
				'condition' => array(
					'mscroll_desktop_action' => 'height',
					'mscroll_desktop_lock'   => 'custom',
				),
			)
		);

		$element->end_controls_tab();

		// Tablet tab.
		$element->start_controls_tab(
			'mscroll_tablet_tab',
			array(
				'label' => __( 'Tablet', 'royal-addons-for-elementor' ),
			)
		);

		$element->add_control(
			'mscroll_tablet_action',
			array(
				'label'       => __( 'Action', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'none'    => __( 'Default', 'royal-addons-for-elementor' ),
					'disable' => __( 'Disable Magic Scroll Totally', 'royal-addons-for-elementor' ),
					'height'  => __( 'Disable Lock Page Scroll', 'royal-addons-for-elementor' ),
				),
				'default'     => 'none',
				'render_type' => 'template',
				'label_block' => true,
			)
		);

		$element->add_control(
			'mscroll_tablet_lock',
			array(
				'label'       => __( 'When to Lock Page Scroll', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'window' => __( 'Container Height Larger Than Window Height', 'royal-addons-for-elementor' ),
					'custom' => __( 'Container Height Larger Than Specfic Height', 'royal-addons-for-elementor' ),
				),
				'default'     => 'window',
				'label_block' => true,
				'condition'   => array(
					'mscroll_tablet_action' => 'height',
				),
			)
		);

		$element->add_control(
			'mscroll_tablet_lock_height',
			array(
				'label'     => __( 'Height (PX)', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 500,
				'condition' => array(
					'mscroll_tablet_action' => 'height',
					'mscroll_tablet_lock'   => 'custom',
				),
			)
		);

		$element->end_controls_tab();

		// Mobile tab.
		$element->start_controls_tab(
			'mscroll_mobile_tab',
			array(
				'label' => __( 'Mobile', 'royal-addons-for-elementor' ),
			)
		);

		$element->add_control(
			'mscroll_mobile_action',
			array(
				'label'       => __( 'Action', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'none'    => __( 'Default', 'royal-addons-for-elementor' ),
					'disable' => __( 'Disable Magic Scroll Totally', 'royal-addons-for-elementor' ),
					'height'  => __( 'Disable Lock Page Scroll', 'royal-addons-for-elementor' ),
				),
				'default'     => 'none',
				'render_type' => 'template',
				'label_block' => true,
			)
		);

		$element->add_control(
			'mscroll_mobile_lock',
			array(
				'label'       => __( 'When to Lock Page Scroll', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'window' => __( 'Container Height Larger Than Window Height', 'royal-addons-for-elementor' ),
					'custom' => __( 'Container Height Larger Than Specfic Height', 'royal-addons-for-elementor' ),
				),
				'default'     => 'window',
				'label_block' => true,
				'condition'   => array(
					'mscroll_mobile_action' => 'height',
				),
			)
		);

		$element->add_control(
			'mscroll_mobile_lock_height',
			array(
				'label'     => __( 'Height (PX)', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 500,
				'condition' => array(
					'mscroll_mobile_action' => 'height',
					'mscroll_mobile_lock'   => 'custom',
				),
			)
		);

		$element->end_controls_tab();

		$element->end_controls_tabs();

		$element->end_controls_section();
	}


	
	public static function print_template( $template, $element ) {

		if ( ! $template && 'widget' === $element->get_type() ) {
			return;
		}

		$old_template = $template;
		ob_start();

		?>
		<#

			var mscrollSettings = {},
			scrollEffects = [];

			mscrollSettings.isEnabled = 'yes' === settings.royal_mscroll_switcher;

			view.addRenderAttribute( 'mscroll_data', {
				'data-mscroll-enabled': mscrollSettings.isEnabled
			});

			if ( mscrollSettings.isEnabled )  {

				_.each( settings.royal_mscroll_repeater, function( effect, index ) {
					scrollEffects.push( effect );
				});

				mscrollSettings.effects = scrollEffects;

				mscrollSettings.fullDuration = settings.royal_mscroll_scene_speed.size;
				mscrollSettings.fullDurationTablet = settings.royal_mscroll_scene_speed_tablet.size || '';
				mscrollSettings.fullDurationMobile = settings.royal_mscroll_scene_speed_mobile.size || '';


				mscrollSettings.repeat = settings.royal_mscroll_loop;
				mscrollSettings.perspective = settings.royal_mscroll_perspective.size;

				mscrollSettings.trigger = settings.royal_mscroll_anim_trigger;

				if( 'automatic' === mscrollSettings.trigger ) {

					mscrollSettings.autoTrigger = 'custom' !== settings.royal_mscroll_auto_trigger ? settings.royal_mscroll_auto_trigger : settings.royal_mscroll_auto_offset.size + "%";

					mscrollSettings.animRev = 'yes' === settings.royal_mscroll_anim_rev;

					mscrollSettings.autoDuration = settings.royal_mscroll_anim_dur.size;
					mscrollSettings.autoDel = settings.royal_mscroll_anim_del.size;

				} else {

					mscrollSettings.scrub = settings.royal_mscroll_scrub.size;
					mscrollSettings.scrubTablet = settings.royal_mscroll_scrub_tablet.size || '';
					mscrollSettings.scrubMobile = settings.royal_mscroll_scrub_mobile.size || '';

					if( 'lock' === mscrollSettings.trigger ) {
						mscrollSettings.lockDelay = settings.royal_mscroll_lock_delay.size;

						mscrollSettings.order = settings.royal_mscroll_order;
						mscrollSettings.orderTablet = settings.royal_mscroll_order_tablet ? settings.royal_mscroll_order_tablet : mscrollSettings.order;
						mscrollSettings.orderMobile = settings.royal_mscroll_order_mobile ? settings.royal_mscroll_order_mobile : mscrollSettings.order;

					} else {

						mscrollSettings.playOffset = settings.royal_mscroll_play_offset.size;

						if( 'sticky' === mscrollSettings.trigger ) {

							mscrollSettings.stickyRef = settings.royal_mscroll_sticky_element;

							mscrollSettings.stickyTarget = settings.royal_mscroll_sticky_target;
							mscrollSettings.stickyTargetSelector = settings.royal_mscroll_sticky_target_css;

							mscrollSettings.stickyStart = settings.royal_mscroll_sticky_start;
							mscrollSettings.stickyEnd = settings.royal_mscroll_sticky_end;

							mscrollSettings.stickyDisable = settings.royal_mscroll_disable_sticky;

						} else {

							mscrollSettings.playRef = settings.royal_mscroll_play_ref;

						}

					}
				}

				mscrollSettings.desktop = {
					action: settings.mscroll_desktop_action,
					lock: settings.mscroll_desktop_lock,
					height: settings.mscroll_desktop_lock_height
				};

				mscrollSettings.tablet = {
					action: settings.mscroll_tablet_action,
					lock: settings.mscroll_tablet_lock,
					height: settings.mscroll_tablet_lock_height
				};

				mscrollSettings.mobile = {
					action: settings.mscroll_mobile_action,
					lock: settings.mscroll_mobile_lock,
					height: settings.mscroll_mobile_lock_height
				};

				view.addRenderAttribute( 'mscroll_data', {
					'id': 'royal-mscroll-' + view.getID(),
					'class': 'royal-mscroll-wrapper',
					'data-mscroll': JSON.stringify( mscrollSettings )
				});

			}

		#>
		<div {{{ view.getRenderAttributeString( 'mscroll_data' ) }}}></div>
		<?php
			$slider_content = ob_get_contents();
			ob_end_clean();
			$template = $slider_content . $old_template;
			return $template;
	}


	public static function before_render( $element ) {

		$type = $element->get_type();
		$el_name = $element->get_name();

		$id = $element->get_id();

		// For containers and atomic elements, use get_settings_for_display safely
		$settings = [];
		if ( method_exists( $element, 'get_settings_for_display' ) ) {
			$settings = $element->get_settings_for_display();
		}

		if ( empty( $settings ) ) {
			return;
		}

		$mscroll_switcher = $settings['royal_mscroll_switcher'] ?? '';

		if ( 'yes' === $mscroll_switcher && isset( $settings['royal_mscroll_repeater'] ) ) {

			$full_duration     = isset( $settings['royal_mscroll_scene_speed'] ) ? $settings['royal_mscroll_scene_speed']['size'] : 1;
			$full_duration_mob = ! empty( $settings['royal_mscroll_scene_speed_mobile']['size'] ) ? $settings['royal_mscroll_scene_speed_mobile']['size'] : '';
			$full_duration_tab = ! empty( $settings['royal_mscroll_scene_speed_tablet']['size'] ) ? $settings['royal_mscroll_scene_speed_tablet']['size'] : '';

			$trigger = $settings['royal_mscroll_anim_trigger'];

			$effects = array();

			foreach ( $settings['royal_mscroll_repeater'] as $effect ) {
				array_push( $effects, $effect );
				
				if ($effect[ 'royal_mscroll_type' ] === 'border' ) {
					$element->add_render_attribute( '_wrapper', [
						'style' => 'overflow: hidden;',
					] );
				}
			}

			$mscroll_settings = array(
				'effects'            => $effects,

				'fullDuration'       => $full_duration,
				'fullDurationTablet' => $full_duration_tab,
				'fullDurationMobile' => $full_duration_mob,

				'repeat'             => $settings['royal_mscroll_loop'],
				'perspective'        => $settings['royal_mscroll_perspective']['size'],
				'trigger'            => $trigger,
			);

			if ( 'automatic' === $trigger ) {

				$mscroll_settings['autoTrigger'] = 'custom' !== $settings['royal_mscroll_auto_trigger'] ? $settings['royal_mscroll_auto_trigger'] : $settings['royal_mscroll_auto_offset']['size'] . '%';

				$mscroll_settings['autoDuration'] = $settings['royal_mscroll_anim_dur']['size'];
				$mscroll_settings['autoDel']      = $settings['royal_mscroll_anim_del']['size'];

				$mscroll_settings['animRev'] = 'yes' === $settings['royal_mscroll_anim_rev'];
			} else {

				$scrub     = ! empty( $settings['royal_mscroll_scrub']['size'] ) ? $settings['royal_mscroll_scrub']['size'] : '';
				$scrub_mob = ! empty( $settings['royal_mscroll_scrub_mobile']['size'] ) ? $settings['royal_mscroll_scrub_mobile']['size'] : '';
				$scrub_tab = ! empty( $settings['royal_mscroll_scrub_tablet']['size'] ) ? $settings['royal_mscroll_scrub_tablet']['size'] : '';

				$mscroll_settings['scrub']       = $scrub;
				$mscroll_settings['scrubTablet'] = $scrub_tab;
				$mscroll_settings['scrubMobile'] = $scrub_mob;

				if ( 'lock' === $trigger ) {
					$mscroll_settings['lockDelay'] = isset( $settings['royal_mscroll_lock_delay'] ) ? $settings['royal_mscroll_lock_delay']['size'] : 0;

					$order     = ! empty( $settings['royal_mscroll_order'] ) ? $settings['royal_mscroll_order'] : 1;
					$order_mob = ! empty( $settings['royal_mscroll_order_mobile'] ) ? $settings['royal_mscroll_order_mobile'] : $order;
					$order_tab = ! empty( $settings['royal_mscroll_order_tablet'] ) ? $settings['royal_mscroll_order_tablet'] : $order;

					$mscroll_settings['order']       = $order;
					$mscroll_settings['orderTablet'] = $order_tab;
					$mscroll_settings['orderMobile'] = $order_mob;

				} else {

					$mscroll_settings['playOffset'] = $settings['royal_mscroll_play_offset']['size'];

					if ( 'sticky' === $trigger ) {

						$mscroll_settings['stickyRef'] = $settings['royal_mscroll_sticky_element'];

						$mscroll_settings['stickyTarget']         = $settings['royal_mscroll_sticky_target'];
						$mscroll_settings['stickyTargetSelector'] = $settings['royal_mscroll_sticky_target_css'];

						$mscroll_settings['stickyStart'] = $settings['royal_mscroll_sticky_start'];
						$mscroll_settings['stickyEnd']   = $settings['royal_mscroll_sticky_end'];

						$mscroll_settings['stickyDisable'] = $settings['royal_mscroll_disable_sticky'];

					} else {

						$mscroll_settings['playRef'] = $settings['royal_mscroll_play_ref'];

					}
				}
			}

			$mscroll_settings['desktop'] = array(
				'action' => $settings['mscroll_desktop_action'],
				'lock'   => $settings['mscroll_desktop_lock'],
				'height' => $settings['mscroll_desktop_lock_height'],
			);

			$mscroll_settings['tablet'] = array(
				'action' => $settings['mscroll_tablet_action'],
				'lock'   => $settings['mscroll_tablet_lock'],
				'height' => $settings['mscroll_tablet_lock_height'],
			);

			$mscroll_settings['mobile'] = array(
				'action' => $settings['mscroll_mobile_action'],
				'lock'   => $settings['mscroll_mobile_lock'],
				'height' => $settings['mscroll_mobile_lock_height'],
			);

			$element->add_render_attribute( '_wrapper', 'data-mscroll', wp_json_encode( $mscroll_settings ) );
			
			if ( 'sticky' !== $trigger || ( 'sticky' === $trigger && 'scope' === $settings['royal_mscroll_sticky_target'] ) ) {
				$element->add_render_attribute( '_wrapper', 'class', 'pa-invisible' );
			}

			if ( 'widget' === $type && \Elementor\Plugin::instance()->editor->is_edit_mode() ) {

				$element->add_render_attribute(
					'mscroll' . $id,
					array(
						'id'           => 'royal-mscroll-' . $id,
						'data-mscroll' => wp_json_encode( $mscroll_settings ),
					)
				);
				?>
				<div <?php echo wp_kses_post( $element->get_render_attribute_string( 'mscroll' . $id ) ); ?>></div>
				<?php
			}
		}
	}


}
RoyalMagicScroll::init();
