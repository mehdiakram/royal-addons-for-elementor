<?php
use Elementor\Controls_Manager;
use Elementor\Element_Base;
use Elementor\Shapes;

defined( 'ABSPATH' ) || die();

class RoyalShapeDivider {

	public static function init() {
		add_filter( 'elementor/shapes/additional_shapes', [__CLASS__, 'royal_additional_shape_divider'] );
		add_action( 'elementor/element/section/section_shape_divider/before_section_end', [__CLASS__, 'royal_update_shape_list'] );
		add_action( 'elementor/element/container/section_shape_divider/before_section_end', [__CLASS__, 'royal_update_shape_list'] );
	}

	public static function royal_update_shape_list( $element ) {
		if ( ! ( $element instanceof \Elementor\Element_Base ) ) return;
		$royal_default_shapes = [];
		$royal_shapes_top = [];
		$royal_shapes_bottom = [];

		foreach ( Shapes::get_shapes() as $shape_name => $shape_props ) {
			if ( ! isset( $shape_props['royal_shape'] ) ) {
				$royal_default_shapes[ $shape_name ] = $shape_props['title'];
			} elseif ( ! isset( $shape_props['royal_shape_bottom'] ) ){
				$royal_shapes_top[ $shape_name ] = $shape_props['title'];
			} else {
				$royal_shapes_bottom[ $shape_name ] = $shape_props['title'];
			}
		}

		$element->update_control(
			'shape_divider_top',
			[
				'type' => Controls_Manager::SELECT,
				'groups' => [
					[
						'label' => __( 'Disable', 'royal-addons-for-elementor' ),
						'options' => [
							'' => __( 'None', 'royal-addons-for-elementor' ),
						],
					],
					[
						'label' => __( 'Default Shapes', 'royal-addons-for-elementor' ),
						'options' => $royal_default_shapes,
					],
					[
						'label' => __( 'Royal Shapes', 'royal-addons-for-elementor' ),
						'options' => $royal_shapes_top,
					],
				],
			]
		);

		$element->update_control(
			'shape_divider_bottom',
			[
				'type' => Controls_Manager::SELECT,
				'groups' => [
					[
						'label' => __( 'Disable', 'royal-addons-for-elementor' ),
						'options' => [
							'' => __( 'None', 'royal-addons-for-elementor' ),
						],
					],
					[
						'label' => __( 'Default Shapes', 'royal-addons-for-elementor' ),
						'options' => $royal_default_shapes,
					],
					[
						'label' => __( 'Royal Shapes', 'royal-addons-for-elementor' ),
						'options' => array_merge( $royal_shapes_top, $royal_shapes_bottom ),
					],
				],
			]
		);
	}


	public static function royal_additional_shape_divider( $royal_shape_list ) {
		$royal_shapes = [
			'royal-brush-001' => [
				'title' => _x( 'Brush 1', 'Shapes', 'royal-addons-for-elementor' ),
				'path' => ROYAL_ADDONS_DIR_PATH . 'assets/shape-divider/royal-brush-001.svg',
				'url' => ROYAL_ADDONS_DIR_URL . 'assets/shape-divider/royal-brush-001.svg',
				'has_flip' => true,
				'has_negative' => false,
				'royal_shape' => true,
			],
			'royal-brush-002' => [
				'title' => _x( 'Brush 2', 'Shapes', 'royal-addons-for-elementor' ),
				'path' => ROYAL_ADDONS_DIR_PATH . 'assets/shape-divider/royal-brush-002.svg',
				'url' => ROYAL_ADDONS_DIR_URL . 'assets/shape-divider/royal-brush-002.svg',
				'has_flip' => true,
				'has_negative' => false,
				'royal_shape' => true,
			],			
			'royal-ink-stripe-001' => [
				'title' => _x( 'Ink Stripe', 'Shapes', 'royal-addons-for-elementor' ),
				'path' => ROYAL_ADDONS_DIR_PATH . 'assets/shape-divider/royal-ink-stripe-001.svg',
				'url' => ROYAL_ADDONS_DIR_URL . 'assets/shape-divider/royal-ink-stripe-001.svg',
				'has_flip' => true,
				'has_negative' => false,
				'royal_shape' => true,
			],
			'royal-brush-001' => [
				'title' => _x( 'Brush 1', 'Shapes', 'royal-addons-for-elementor' ),
				'path' => ROYAL_ADDONS_DIR_PATH . 'assets/shape-divider/royal-brush-001.svg',
				'url' => ROYAL_ADDONS_DIR_URL . 'assets/shape-divider/royal-brush-001.svg',
				'has_flip' => true,
				'has_negative' => false,
				'royal_shape' => true,
			],
			'royal-splatter-paint-001' => [
				'title' => _x( 'Splatter Paint 1', 'Shapes', 'royal-addons-for-elementor' ),
				'path' => ROYAL_ADDONS_DIR_PATH . 'assets/shape-divider/royal-splatter-paint-001.svg',
				'url' => ROYAL_ADDONS_DIR_URL . 'assets/shape-divider/royal-splatter-paint-001.svg',
				'has_flip' => true,
				'has_negative' => false,
				'royal_shape' => true,
			],		
			'royal-splatter-paint-002' => [
				'title' => _x( 'Splatter Paint 2', 'Shapes', 'royal-addons-for-elementor' ),
				'path' => ROYAL_ADDONS_DIR_PATH . 'assets/shape-divider/royal-splatter-paint-002.svg',
				'url' => ROYAL_ADDONS_DIR_URL . 'assets/shape-divider/royal-splatter-paint-002.svg',
				'has_flip' => true,
				'has_negative' => false,
				'royal_shape' => true,
			],
			'royal-melting-lines-001' => [
				'title' => _x( 'Melting Lines', 'Shapes', 'royal-addons-for-elementor' ),
				'path' => ROYAL_ADDONS_DIR_PATH . 'assets/shape-divider/royal-melting-lines-001.svg',
				'url' => ROYAL_ADDONS_DIR_URL . 'assets/shape-divider/royal-melting-lines-001.svg',
				'has_flip' => true,
				'has_negative' => false,
				'royal_shape' => true,
			],
			'royal-geometric-001' => [
				'title' => _x( 'Geometric Chevrons 1', 'Shapes', 'royal-addons-for-elementor' ),
				'path' => ROYAL_ADDONS_DIR_PATH . 'assets/shape-divider/royal-geometric-001.svg',
				'url' => ROYAL_ADDONS_DIR_URL . 'assets/shape-divider/royal-geometric-001.svg',
				'has_flip' => true,
				'has_negative' => false,
				'royal_shape' => true,
			],
			'royal-geometric-002' => [
				'title' => _x( 'Geometric Polygons', 'Shapes', 'royal-addons-for-elementor' ),
				'path' => ROYAL_ADDONS_DIR_PATH . 'assets/shape-divider/royal-geometric-002.svg',
				'url' => ROYAL_ADDONS_DIR_URL . 'assets/shape-divider/royal-geometric-002.svg',
				'has_flip' => true,
				'has_negative' => false,
				'royal_shape' => true,
			],
			'royal-halftone-001' => [
				'title' => _x( 'Halft One', 'Shapes', 'royal-addons-for-elementor' ),
				'path' => ROYAL_ADDONS_DIR_PATH . 'assets/shape-divider/royal-halftone-001.svg',
				'url' => ROYAL_ADDONS_DIR_URL . 'assets/shape-divider/royal-halftone-001.svg',
				'has_flip' => true,
				'has_negative' => false,
				'royal_shape' => true,
			],
			'royal-grass-001' => [
				'title' => _x( 'Grass', 'Shapes', 'royal-addons-for-elementor' ),
				'path' => ROYAL_ADDONS_DIR_PATH . 'assets/shape-divider/royal-grass-001.svg',
				'url' => ROYAL_ADDONS_DIR_URL . 'assets/shape-divider/royal-grass-001.svg',
				'has_flip' => true,
				'has_negative' => false,
				'royal_shape' => true,
			],
			'royal-holiday-lights-001' => [
				'title' => _x( 'Holiday Lights', 'Shapes', 'royal-addons-for-elementor' ),
				'path' => ROYAL_ADDONS_DIR_PATH . 'assets/shape-divider/royal-holiday-lights-001.svg',
				'url' => ROYAL_ADDONS_DIR_URL . 'assets/shape-divider/royal-holiday-lights-001.svg',
				'has_flip' => true,
				'has_negative' => false,
				'royal_shape' => true,
			],
			'royal-jagged-edge-001' => [
				'title' => _x( 'Jagged Edge', 'Shapes', 'royal-addons-for-elementor' ),
				'path' => ROYAL_ADDONS_DIR_PATH . 'assets/shape-divider/royal-jagged-edge-001.svg',
				'url' => ROYAL_ADDONS_DIR_URL . 'assets/shape-divider/royal-jagged-edge-001.svg',
				'has_flip' => true,
				'has_negative' => false,
				'royal_shape' => true,
			],
			'royal-offroad-tread-001' => [
				'title' => _x( 'Offroad Tire Tread', 'Shapes', 'royal-addons-for-elementor' ),
				'path' => ROYAL_ADDONS_DIR_PATH . 'assets/shape-divider/royal-offroad-tread-001.svg',
				'url' => ROYAL_ADDONS_DIR_URL . 'assets/shape-divider/royal-offroad-tread-001.svg',
				'has_flip' => true,
				'has_negative' => false,
				'royal_shape' => true,
			],
			'royal-sprinkles-001' => [
				'title' => _x( 'Sprinkles', 'Shapes', 'royal-addons-for-elementor' ),
				'path' => ROYAL_ADDONS_DIR_PATH . 'assets/shape-divider/royal-sprinkles-001.svg',
				'url' => ROYAL_ADDONS_DIR_URL . 'assets/shape-divider/royal-sprinkles-001.svg',
				'has_flip' => true,
				'has_negative' => false,
				'royal_shape' => true,
			],
			'royal-tire-tread-001' => [
				'title' => _x( 'Tire Tread', 'Shapes', 'royal-addons-for-elementor' ),
				'path' => ROYAL_ADDONS_DIR_PATH . 'assets/shape-divider/royal-tire-tread-001.svg',
				'url' => ROYAL_ADDONS_DIR_URL . 'assets/shape-divider/royal-tire-tread-001.svg',
				'has_flip' => true,
				'has_negative' => false,
				'royal_shape' => true,
			],
			'royal-tape-measure-001' => [
				'title' => _x( 'Tape Measure', 'Shapes', 'royal-addons-for-elementor' ),
				'path' => ROYAL_ADDONS_DIR_PATH . 'assets/shape-divider/royal-tape-measure-001.svg',
				'url' => ROYAL_ADDONS_DIR_URL . 'assets/shape-divider/royal-tape-measure-001.svg',
				'has_flip' => true,
				'has_negative' => false,
				'royal_shape' => true,
			],
			'royal-papertear-001' => [
				'title' => _x( 'Paper Tear 1', 'Shapes', 'royal-addons-for-elementor' ),
				'path' => ROYAL_ADDONS_DIR_PATH . 'assets/shape-divider/royal-papertear-001.svg',
				'url' => ROYAL_ADDONS_DIR_URL . 'assets/shape-divider/royal-papertear-001.svg',
				'has_flip' => true,
				'has_negative' => false,
				'royal_shape' => true,
			],	
			'royal-papertear-002' => [
				'title' => _x( 'Paper Tear 2', 'Shapes', 'royal-addons-for-elementor' ),
				'path' => ROYAL_ADDONS_DIR_PATH . 'assets/shape-divider/royal-papertear-002.svg',
				'url' => ROYAL_ADDONS_DIR_URL . 'assets/shape-divider/royal-papertear-002.svg',
				'has_flip' => true,
				'has_negative' => false,
				'royal_shape' => true,
			],	
			'royal-papertear-003' => [
				'title' => _x( 'Paper Tear 3', 'Shapes', 'royal-addons-for-elementor' ),
				'path' => ROYAL_ADDONS_DIR_PATH . 'assets/shape-divider/royal-papertear-003.svg',
				'url' => ROYAL_ADDONS_DIR_URL . 'assets/shape-divider/royal-papertear-003.svg',
				'has_flip' => true,
				'has_negative' => false,
				'royal_shape' => true,
			],
			'royal-abstract-web' => [
				'title' => _x( 'Abstract Web', 'Shapes', 'royal-addons-for-elementor' ),
				'path' => ROYAL_ADDONS_DIR_PATH . 'assets/shape-divider/abstract-web.svg',
				'url' => ROYAL_ADDONS_DIR_URL . 'assets/shape-divider/abstract-web.svg',
				'has_flip' => true,
				'has_negative' => false,
				'royal_shape' => true,
			],			
			'royal-crossline' => [
				'title' => _x( 'Crossline', 'Shapes', 'royal-addons-for-elementor' ),
				'path' => ROYAL_ADDONS_DIR_PATH . 'assets/shape-divider/crossline.svg',
				'url' => ROYAL_ADDONS_DIR_URL . 'assets/shape-divider/crossline.svg',
				'has_flip' => true,
				'has_negative' => false,
				'royal_shape' => true,
			],
			'royal-droplet' => [
				'title' => _x( 'Droplet', 'Shapes', 'royal-addons-for-elementor' ),
				'path' => ROYAL_ADDONS_DIR_PATH . 'assets/shape-divider/droplet.svg',
				'url' => ROYAL_ADDONS_DIR_URL . 'assets/shape-divider/droplet.svg',
				'has_flip' => true,
				'has_negative' => true,
				'royal_shape' => true,
			],
			'royal-flame' => [
				'title' => _x( 'Flame', 'Shapes', 'royal-addons-for-elementor' ),
				'path' => ROYAL_ADDONS_DIR_PATH . 'assets/shape-divider/flame.svg',
				'url' => ROYAL_ADDONS_DIR_URL . 'assets/shape-divider/flame.svg',
				'has_flip' => true,
				'has_negative' => false,
				'royal_shape' => true,
			],

			'royal-half-circle' => [
				'title' => _x( 'Half Circle', 'Shapes', 'royal-addons-for-elementor' ),
				'path' => ROYAL_ADDONS_DIR_PATH . 'assets/shape-divider/half-circle.svg',
				'url' => ROYAL_ADDONS_DIR_URL . 'assets/shape-divider/half-circle.svg',
				'has_flip' => true,
				'has_negative' => true,
				'royal_shape' => true,
			],
			'royal-multi-cloud' => [
				'title' => _x( 'Multi Cloud', 'Shapes', 'royal-addons-for-elementor' ),
				'path' => ROYAL_ADDONS_DIR_PATH . 'assets/shape-divider/multi-cloud.svg',
				'url' => ROYAL_ADDONS_DIR_URL . 'assets/shape-divider/multi-cloud.svg',
				'has_flip' => true,
				'has_negative' => false,
				'royal_shape' => true,
			],
			'royal-multi-wave' => [
				'title' => _x( 'Multi Wave', 'Shapes', 'royal-addons-for-elementor' ),
				'path' => ROYAL_ADDONS_DIR_PATH . 'assets/shape-divider/multi-wave.svg',
				'url' => ROYAL_ADDONS_DIR_URL . 'assets/shape-divider/multi-wave.svg',
				'has_flip' => true,
				'has_negative' => false,
				'royal_shape' => true,
			],
			'royal-smooth-zigzag' => [
				'title' => _x( 'Smooth Zigzag', 'Shapes', 'royal-addons-for-elementor' ),
				'path' => ROYAL_ADDONS_DIR_PATH . 'assets/shape-divider/smooth-zigzag.svg',
				'url' => ROYAL_ADDONS_DIR_URL . 'assets/shape-divider/smooth-zigzag.svg',
				'has_flip' => true,
				'has_negative' => false,
				'royal_shape' => true,
			],
			'royal-splash' => [
				'title' => _x( 'Splash', 'Shapes', 'royal-addons-for-elementor' ),
				'path' => ROYAL_ADDONS_DIR_PATH . 'assets/shape-divider/splash.svg',
				'url' => ROYAL_ADDONS_DIR_URL . 'assets/shape-divider/splash.svg',
				'has_flip' => true,
				'has_negative' => true,
				'royal_shape' => true,
			],
			'royal-splash2' => [
				'title' => _x( 'Splash 2', 'Shapes', 'royal-addons-for-elementor' ),
				'path' => ROYAL_ADDONS_DIR_PATH . 'assets/shape-divider/splash2.svg',
				'url' => ROYAL_ADDONS_DIR_URL . 'assets/shape-divider/splash2.svg',
				'has_flip' => true,
				'has_negative' => true,
				'royal_shape' => true,
			],
			'royal-torn-paper' => [
				'title' => _x( 'Torn Paper', 'Shapes', 'royal-addons-for-elementor' ),
				'path' => ROYAL_ADDONS_DIR_PATH . 'assets/shape-divider/torn-paper.svg',
				'url' => ROYAL_ADDONS_DIR_URL . 'assets/shape-divider/torn-paper.svg',
				'has_flip' => true,
				'has_negative' => false,
				'royal_shape' => true,
			],
			'royal-brush' => [
				'title' => _x( 'Brush', 'Shapes', 'royal-addons-for-elementor' ),
				'path' => ROYAL_ADDONS_DIR_PATH . 'assets/shape-divider/brush.svg',
				'url' => ROYAL_ADDONS_DIR_URL . 'assets/shape-divider/brush.svg',
				'has_flip' => true,
				'has_negative' => true,
				'royal_shape' => true,
			],
			'royal-sports' => [
				'title' => _x( 'Sports', 'Shapes', 'royal-addons-for-elementor' ),
				'path' => ROYAL_ADDONS_DIR_PATH . 'assets/shape-divider/sports.svg',
				'url' => ROYAL_ADDONS_DIR_URL . 'assets/shape-divider/sports.svg',
				'has_flip' => true,
				'has_negative' => false,
				'royal_shape' => true,
				'royal_shape_bottom' => true,
			],
			'royal-landscape' => [
				'title' => _x( 'Landscape', 'Shapes', 'royal-addons-for-elementor' ),
				'path' => ROYAL_ADDONS_DIR_PATH . 'assets/shape-divider/landscape.svg',
				'url' => ROYAL_ADDONS_DIR_URL . 'assets/shape-divider/landscape.svg',
				'has_flip' => true,
				'has_negative' => false,
				'royal_shape' => true,
				'royal_shape_bottom' => true,
			],
			'royal-nature' => [
				'title' => _x( 'Nature', 'Shapes', 'royal-addons-for-elementor' ),
				'path' => ROYAL_ADDONS_DIR_PATH . 'assets/shape-divider/nature.svg',
				'url' => ROYAL_ADDONS_DIR_URL . 'assets/shape-divider/nature.svg',
				'has_flip' => true,
				'has_negative' => false,
				'royal_shape' => true,
				'royal_shape_bottom' => true,
			],
			'royal-desert' => [
				'title' => _x( 'Desert', 'Shapes', 'royal-addons-for-elementor' ),
				'path' => ROYAL_ADDONS_DIR_PATH . 'assets/shape-divider/desert.svg',
				'url' => ROYAL_ADDONS_DIR_URL . 'assets/shape-divider/desert.svg',
				'has_flip' => true,
				'has_negative' => false,
				'royal_shape' => true,
				'royal_shape_bottom' => true,
			],
			'royal-under-water' => [
				'title' => _x( 'Under Water', 'Shapes', 'royal-addons-for-elementor' ),
				'path' => ROYAL_ADDONS_DIR_PATH . 'assets/shape-divider/under-water.svg',
				'url' => ROYAL_ADDONS_DIR_URL . 'assets/shape-divider/under-water.svg',
				'has_flip' => true,
				'has_negative' => false,
				'royal_shape' => true,
				'royal_shape_bottom' => true,
			],
			'royal-cityscape-layer' => [
				'title' => _x( 'Cityscape Layer', 'Shapes', 'royal-addons-for-elementor' ),
				'path' => ROYAL_ADDONS_DIR_PATH . 'assets/shape-divider/cityscape-layer.svg',
				'url' => ROYAL_ADDONS_DIR_URL . 'assets/shape-divider/cityscape-layer.svg',
				'has_flip' => true,
				'has_negative' => false,
				'royal_shape' => true,
				'royal_shape_bottom' => true,
			],
			'royal-drop' => [
				'title' => _x( 'Drop', 'Shapes', 'royal-addons-for-elementor' ),
				'path' => ROYAL_ADDONS_DIR_PATH . 'assets/shape-divider/drop.svg',
				'url' => ROYAL_ADDONS_DIR_URL . 'assets/shape-divider/drop.svg',
				'has_flip' => true,
				'has_negative' => false,
				'royal_shape' => true,
			],
			'royal-mosque' => [
				'title' => _x( 'Mosque', 'Shapes', 'royal-addons-for-elementor' ),
				'path' => ROYAL_ADDONS_DIR_PATH . 'assets/shape-divider/mosque.svg',
				'url' => ROYAL_ADDONS_DIR_URL . 'assets/shape-divider/mosque.svg',
				'has_flip' => true,
				'has_negative' => false,
				'royal_shape' => true,
			]
		];

		return array_merge( $royal_shapes, $royal_shape_list );
	}
}

RoyalShapeDivider::init();
