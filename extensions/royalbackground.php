<?php
use Elementor\Controls_Manager;
use Elementor\Element_Base;
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Modules\AtomicWidgets\Controls\Section as AtomicSection;
use Elementor\Modules\AtomicWidgets\Controls\Types\Switch_Control as AtomicSwitch;
use Elementor\Modules\AtomicWidgets\Controls\Types\Textarea_Control as AtomicTextarea;
use Elementor\Modules\AtomicWidgets\Controls\Types\Select_Control as AtomicSelect;
use Elementor\Modules\AtomicWidgets\Controls\Types\Number_Control as AtomicNumber;
use Elementor\Modules\AtomicWidgets\Controls\Types\Size_Control as AtomicSize;
use Elementor\Modules\AtomicWidgets\Controls\Types\Color_Control as AtomicColor;

if (!defined('ABSPATH')) {
    exit;
}

class Royal_Background {

    private static $assets_loaded    = [];
    private static $registered_elements = [];

    public static function init() {

        // Universal hook that fires for ALL element types including Atomic Containers, Div Blocks, etc.
        add_action( 'elementor/element/after_section_end', [ __CLASS__, 'register_controls_atomic' ], 10, 2 );

        // ── Frontend render hook (universal — fires for ALL element types including Atomic Div Block) ──
        add_action( 'elementor/frontend/before_render', [__CLASS__, 'before_render'], 10, 1 );

        // ── Editor print_template ────────────────────────────────────
        add_action( 'elementor/section/print_template',   [__CLASS__, 'print_template'], 10, 2 );
        add_action( 'elementor/container/print_template', [__CLASS__, 'print_template'], 10, 2 );
        add_action( 'elementor/column/print_template',    [__CLASS__, 'print_template'], 10, 2 );
        add_action( 'elementor/widget/print_template',    [__CLASS__, 'print_template'], 10, 2 );

        add_action( 'elementor/preview/enqueue_scripts', [__CLASS__, 'enqueue_editor_assets'] );

        // Elementor 4 Atomic API Hooks
        add_filter( 'elementor/atomic-widgets/props-schema', [ __CLASS__, 'add_atomic_props_schema' ], 10, 1 );
        add_filter( 'elementor/atomic-widgets/controls', [ __CLASS__, 'add_atomic_controls' ], 10, 2 );
    }

    public static function enqueue_editor_assets() {
        self::enqueue_assets('circle');
        self::enqueue_assets('particles');
        self::enqueue_assets('blob');
        self::enqueue_assets('canvas');
        self::enqueue_assets('ambient');
    }

    /* Universal hook duplicate prevention */
    public static function register_controls_atomic( $element, $section_id = '' ) {
        // Only register once, on the 'section_advanced' hook
        if ( ! in_array( $section_id, [ 'section_advanced', 'section_custom_css_pro' ] ) ) return;

        // Container-level backgrounds should only attach to Sections, Containers, Columns, and Atomic Div Blocks
        if ( $element instanceof \Elementor\Widget_Base ) {
            return;
        }

        self::register_controls( $element );
    }

    /* ─────────────────────────────────────────────
     *  Atomic API — Helpers
     * ───────────────────────────────────────────── */

    private static function get_dep( $path, $value = true ) {
        $manager = \Elementor\Modules\AtomicWidgets\PropDependencies\Manager::make();
        $manager->where( [ 'operator' => 'eq', 'path' => [ $path ], 'value' => $value ] );
        return $manager->get();
    }

    /* ─────────────────────────────────────────────
     *  Atomic API — Props Schema
     * ───────────────────────────────────────────── */

    public static function add_atomic_props_schema( $schema ) {
        $bool  = '\\Elementor\\Modules\\AtomicWidgets\\PropTypes\\Primitives\\Boolean_Prop_Type';
        $str   = '\\Elementor\\Modules\\AtomicWidgets\\PropTypes\\Primitives\\String_Prop_Type';
        $num   = '\\Elementor\\Modules\\AtomicWidgets\\PropTypes\\Primitives\\Number_Prop_Type';
        $size  = '\\Elementor\\Modules\\AtomicWidgets\\PropTypes\\Size_Prop_Type';

        // ── Enable switches ──
        $schema['royal_enable_circle']    = $bool::make()->default(false);
        $schema['royal_enable_particles'] = $bool::make()->default(false);
        $schema['royal_enable_blob']      = $bool::make()->default(false);
        $schema['royal_enable_canvas']    = $bool::make()->default(false);
        $schema['royal_enable_ambient']   = $bool::make()->default(false);

        // ── Circle 1 sub-settings ──
        $cirDep = self::get_dep('royal_enable_circle');
        $schema['royal_ac_size']         = $size::make()->default(['size' => 250, 'unit' => 'px'])->set_dependencies($cirDep);
        $schema['royal_ac_color']        = $str::make()->default('#87CEEB')->set_dependencies($cirDep);
        $schema['royal_ac_border_style'] = $str::make()->enum(['dotted','dashed','solid','double','none'])->default('dotted')->set_dependencies($cirDep);
        $schema['royal_ac_border_width'] = $size::make()->default(['size' => 2, 'unit' => 'px'])->set_dependencies($cirDep);
        $schema['royal_ac_animation']    = $str::make()->enum(['off','clockwise','counter-clockwise'])->default('clockwise')->set_dependencies($cirDep);
        $schema['royal_ac_speed']        = $num::make()->default(20)->set_dependencies($cirDep);
        $schema['royal_ac_h_offset']     = $size::make()->default(['size' => 50, 'unit' => '%'])->set_dependencies($cirDep);
        $schema['royal_ac_v_offset']     = $size::make()->default(['size' => 50, 'unit' => '%'])->set_dependencies($cirDep);
        $schema['royal_ac_zindex']       = $num::make()->default(0)->set_dependencies($cirDep);
        // ── Circle 2 ──
        $schema['royal_ac2_enable']       = $bool::make()->default(false)->set_dependencies($cirDep);
        $schema['royal_ac2_size']         = $size::make()->default(['size' => 180, 'unit' => 'px'])->set_dependencies($cirDep);
        $schema['royal_ac2_color']        = $str::make()->default('#FFD700')->set_dependencies($cirDep);
        $schema['royal_ac2_border_style'] = $str::make()->enum(['dotted','dashed','solid','double','none'])->default('dashed')->set_dependencies($cirDep);
        $schema['royal_ac2_animation']    = $str::make()->enum(['off','clockwise','counter-clockwise'])->default('counter-clockwise')->set_dependencies($cirDep);
        $schema['royal_ac2_speed']        = $num::make()->default(15)->set_dependencies($cirDep);
        $schema['royal_ac2_h_offset']     = $size::make()->default(['size' => 30, 'unit' => '%'])->set_dependencies($cirDep);
        $schema['royal_ac2_v_offset']     = $size::make()->default(['size' => 30, 'unit' => '%'])->set_dependencies($cirDep);
        // ── Circle 3 ──
        $schema['royal_ac3_enable']       = $bool::make()->default(false)->set_dependencies($cirDep);
        $schema['royal_ac3_size']         = $size::make()->default(['size' => 120, 'unit' => 'px'])->set_dependencies($cirDep);
        $schema['royal_ac3_color']        = $str::make()->default('#FF6B6B')->set_dependencies($cirDep);
        $schema['royal_ac3_border_style'] = $str::make()->enum(['dotted','dashed','solid','double','none'])->default('solid')->set_dependencies($cirDep);
        $schema['royal_ac3_animation']    = $str::make()->enum(['off','clockwise','counter-clockwise'])->default('clockwise')->set_dependencies($cirDep);
        $schema['royal_ac3_speed']        = $num::make()->default(25)->set_dependencies($cirDep);
        $schema['royal_ac3_h_offset']     = $size::make()->default(['size' => 70, 'unit' => '%'])->set_dependencies($cirDep);
        $schema['royal_ac3_v_offset']     = $size::make()->default(['size' => 70, 'unit' => '%'])->set_dependencies($cirDep);

        // ── Blob sub-settings ──
        $bDep = self::get_dep('royal_enable_blob');
        $schema['royal_ab_color']        = $str::make()->default('#D1BCF5')->set_dependencies($bDep);
        $schema['royal_ab_size']         = $size::make()->default(['size' => 300, 'unit' => 'px'])->set_dependencies($bDep);
        $schema['royal_ab_complexity']   = $size::make()->default(['size' => 8, 'unit' => 'px'])->set_dependencies($bDep);
        $schema['royal_ab_contrast']     = $size::make()->default(['size' => 0.4, 'unit' => 'px'])->set_dependencies($bDep);
        $schema['royal_ab_smoothness']   = $size::make()->default(['size' => 1, 'unit' => 'px'])->set_dependencies($bDep);
        $schema['royal_ab_h_offset']     = $size::make()->default(['size' => 40, 'unit' => '%'])->set_dependencies($bDep);
        $schema['royal_ab_v_offset']     = $size::make()->default(['size' => 40, 'unit' => '%'])->set_dependencies($bDep);
        $schema['royal_ab_opacity']      = $size::make()->default(['size' => 1, 'unit' => 'px'])->set_dependencies($bDep);
        $schema['royal_ab_zindex']       = $num::make()->default(0)->set_dependencies($bDep);
        $schema['royal_ab_anim_dur']     = $num::make()->default(5)->set_dependencies($bDep);

        // ── Particles sub-settings ──
        $pDep = self::get_dep('royal_enable_particles');
        $schema['royal_particles_scope']        = $str::make()->enum(['contained','fullscreen'])->default('contained')->set_dependencies($pDep);
        $schema['royal_particles_zindex']        = $num::make()->default(0)->set_dependencies($pDep);
        $schema['royal_particles_custom_style']  = $str::make()->default('{"particles":{"number":{"value":80},"color":{"value":"#ffffff"},"shape":{"type":"circle"},"move":{"enable":true,"speed":6}}}')->set_dependencies($pDep);

        // ── Canvas sub-settings ──
        $cDep = self::get_dep('royal_enable_canvas');
        $schema['royal_canvas_type']            = $str::make()->enum(['gradient','waves','snow','drops','rings','fancy-rotate'])->default('waves')->set_dependencies($cDep);
        $schema['royal_canvas_bg_color']        = $str::make()->default('')->set_dependencies($cDep);
        $schema['royal_canvas_opacity']         = $size::make()->default(['size' => 1, 'unit' => 'px'])->set_dependencies($cDep);
        $schema['royal_canvas_zindex']          = $num::make()->default(0)->set_dependencies($cDep);
        $schema['royal_canvas_disable_mobile']  = $bool::make()->default(true)->set_dependencies($cDep);
        // Gradient
        $schema['royal_canvas_grad_color1']     = $str::make()->default('#6366f1')->set_dependencies($cDep);
        $schema['royal_canvas_grad_color2']     = $str::make()->default('#ec4899')->set_dependencies($cDep);
        $schema['royal_canvas_grad_color3']     = $str::make()->default('#06b6d4')->set_dependencies($cDep);
        $schema['royal_canvas_grad_speed']      = $size::make()->default(['size' => 8, 'unit' => 'px'])->set_dependencies($cDep);
        // Waves
        $schema['royal_canvas_waves_color']     = $str::make()->default('#6366f1')->set_dependencies($cDep);
        $schema['royal_canvas_waves_color2']    = $str::make()->default('#818cf8')->set_dependencies($cDep);
        $schema['royal_canvas_waves_count']     = $size::make()->default(['size' => 3, 'unit' => 'px'])->set_dependencies($cDep);
        $schema['royal_canvas_waves_speed']     = $size::make()->default(['size' => 5, 'unit' => 'px'])->set_dependencies($cDep);
        $schema['royal_canvas_waves_height']    = $size::make()->default(['size' => 40, 'unit' => 'px'])->set_dependencies($cDep);
        // Snow
        $schema['royal_canvas_snow_color']      = $str::make()->default('#ffffff')->set_dependencies($cDep);
        $schema['royal_canvas_snow_count']      = $size::make()->default(['size' => 80, 'unit' => 'px'])->set_dependencies($cDep);
        $schema['royal_canvas_snow_speed']      = $size::make()->default(['size' => 2, 'unit' => 'px'])->set_dependencies($cDep);
        $schema['royal_canvas_snow_size']       = $size::make()->default(['size' => 4, 'unit' => 'px'])->set_dependencies($cDep);
        $schema['royal_canvas_snow_wind']       = $size::make()->default(['size' => 0.5, 'unit' => 'px'])->set_dependencies($cDep);
        // Drops
        $schema['royal_canvas_drops_color']     = $str::make()->default('#6366f1')->set_dependencies($cDep);
        $schema['royal_canvas_drops_speed']     = $size::make()->default(['size' => 5, 'unit' => 'px'])->set_dependencies($cDep);
        $schema['royal_canvas_drops_max']       = $size::make()->default(['size' => 15, 'unit' => 'px'])->set_dependencies($cDep);
        // Rings
        $schema['royal_canvas_rings_color']     = $str::make()->default('#6366f1')->set_dependencies($cDep);
        $schema['royal_canvas_rings_count']     = $size::make()->default(['size' => 5, 'unit' => 'px'])->set_dependencies($cDep);
        $schema['royal_canvas_rings_speed']     = $size::make()->default(['size' => 3, 'unit' => 'px'])->set_dependencies($cDep);
        // Fancy Rotate
        $schema['royal_canvas_rotate_color']    = $str::make()->default('#6366f1')->set_dependencies($cDep);
        $schema['royal_canvas_rotate_color2']   = $str::make()->default('#ec4899')->set_dependencies($cDep);
        $schema['royal_canvas_rotate_count']    = $size::make()->default(['size' => 8, 'unit' => 'px'])->set_dependencies($cDep);
        $schema['royal_canvas_rotate_speed']    = $size::make()->default(['size' => 3, 'unit' => 'px'])->set_dependencies($cDep);

        return $schema;
    }

    /* ─────────────────────────────────────────────
     *  Atomic API — Controls UI
     * ───────────────────────────────────────────── */

    public static function add_atomic_controls( $controls, $element ) {
        $t = 'royal-addons-for-elementor';
        $text = 'Elementor\\Modules\\AtomicWidgets\\Controls\\Types\\Text_Control';

        $items = [
            // ── Enable Switches ──
            AtomicSwitch::bind_to( 'royal_enable_circle' )->set_label( __( 'Enable Circle', $t ) ),
            AtomicSwitch::bind_to( 'royal_enable_particles' )->set_label( __( 'Enable Particles', $t ) ),
            AtomicSwitch::bind_to( 'royal_enable_blob' )->set_label( __( 'Enable Blob', $t ) ),
            AtomicSwitch::bind_to( 'royal_enable_canvas' )->set_label( __( 'Enable Canvas Animation', $t ) ),
            AtomicSwitch::bind_to( 'royal_enable_ambient' )->set_label( __( 'Enable Ambient & Deco Background', $t ) ),

            // ── Circle 1 Settings ──
            AtomicSize::bind_to( 'royal_ac_size' )->set_label( __( 'Circle 1 Size', $t ) ),
            $text::bind_to( 'royal_ac_color' )->set_label( __( 'Circle 1 Color', $t ) )->set_placeholder('#87CEEB'),
            AtomicSelect::bind_to( 'royal_ac_border_style' )->set_label( __( 'Circle 1 Border', $t ) )->set_options([
                ['value' => 'dotted', 'label' => 'Dotted'], ['value' => 'dashed', 'label' => 'Dashed'],
                ['value' => 'solid', 'label' => 'Solid'], ['value' => 'double', 'label' => 'Double'], ['value' => 'none', 'label' => 'None'],
            ]),
            AtomicSize::bind_to( 'royal_ac_border_width' )->set_label( __( 'Circle 1 Border Width', $t ) ),
            AtomicSelect::bind_to( 'royal_ac_animation' )->set_label( __( 'Circle 1 Animation', $t ) )->set_options([
                ['value' => 'off', 'label' => 'Off'], ['value' => 'clockwise', 'label' => 'Clockwise'], ['value' => 'counter-clockwise', 'label' => 'Counter-Clockwise'],
            ]),
            AtomicNumber::bind_to( 'royal_ac_speed' )->set_label( __( 'Circle 1 Speed (s)', $t ) )->set_min(1)->set_max(120)->set_step(1),
            AtomicSize::bind_to( 'royal_ac_h_offset' )->set_label( __( 'Circle 1 H-Offset', $t ) ),
            AtomicSize::bind_to( 'royal_ac_v_offset' )->set_label( __( 'Circle 1 V-Offset', $t ) ),
            AtomicNumber::bind_to( 'royal_ac_zindex' )->set_label( __( 'Circle 1 Z-Index', $t ) )->set_min(-10)->set_max(9999)->set_step(1),

            // ── Circle 2 Settings ──
            AtomicSwitch::bind_to( 'royal_ac2_enable' )->set_label( __( 'Enable Circle 2', $t ) ),
            AtomicSize::bind_to( 'royal_ac2_size' )->set_label( __( 'Circle 2 Size', $t ) ),
            $text::bind_to( 'royal_ac2_color' )->set_label( __( 'Circle 2 Color', $t ) )->set_placeholder('#FFD700'),
            AtomicSelect::bind_to( 'royal_ac2_border_style' )->set_label( __( 'Circle 2 Border', $t ) )->set_options([
                ['value' => 'dotted', 'label' => 'Dotted'], ['value' => 'dashed', 'label' => 'Dashed'],
                ['value' => 'solid', 'label' => 'Solid'], ['value' => 'double', 'label' => 'Double'], ['value' => 'none', 'label' => 'None'],
            ]),
            AtomicSelect::bind_to( 'royal_ac2_animation' )->set_label( __( 'Circle 2 Animation', $t ) )->set_options([
                ['value' => 'off', 'label' => 'Off'], ['value' => 'clockwise', 'label' => 'Clockwise'], ['value' => 'counter-clockwise', 'label' => 'Counter-Clockwise'],
            ]),
            AtomicNumber::bind_to( 'royal_ac2_speed' )->set_label( __( 'Circle 2 Speed (s)', $t ) )->set_min(1)->set_max(120)->set_step(1),
            AtomicSize::bind_to( 'royal_ac2_h_offset' )->set_label( __( 'Circle 2 H-Offset', $t ) ),
            AtomicSize::bind_to( 'royal_ac2_v_offset' )->set_label( __( 'Circle 2 V-Offset', $t ) ),

            // ── Circle 3 Settings ──
            AtomicSwitch::bind_to( 'royal_ac3_enable' )->set_label( __( 'Enable Circle 3', $t ) ),
            AtomicSize::bind_to( 'royal_ac3_size' )->set_label( __( 'Circle 3 Size', $t ) ),
            $text::bind_to( 'royal_ac3_color' )->set_label( __( 'Circle 3 Color', $t ) )->set_placeholder('#FF6B6B'),
            AtomicSelect::bind_to( 'royal_ac3_border_style' )->set_label( __( 'Circle 3 Border', $t ) )->set_options([
                ['value' => 'dotted', 'label' => 'Dotted'], ['value' => 'dashed', 'label' => 'Dashed'],
                ['value' => 'solid', 'label' => 'Solid'], ['value' => 'double', 'label' => 'Double'], ['value' => 'none', 'label' => 'None'],
            ]),
            AtomicSelect::bind_to( 'royal_ac3_animation' )->set_label( __( 'Circle 3 Animation', $t ) )->set_options([
                ['value' => 'off', 'label' => 'Off'], ['value' => 'clockwise', 'label' => 'Clockwise'], ['value' => 'counter-clockwise', 'label' => 'Counter-Clockwise'],
            ]),
            AtomicNumber::bind_to( 'royal_ac3_speed' )->set_label( __( 'Circle 3 Speed (s)', $t ) )->set_min(1)->set_max(120)->set_step(1),
            AtomicSize::bind_to( 'royal_ac3_h_offset' )->set_label( __( 'Circle 3 H-Offset', $t ) ),
            AtomicSize::bind_to( 'royal_ac3_v_offset' )->set_label( __( 'Circle 3 V-Offset', $t ) ),

            // ── Blob Settings ──
            $text::bind_to( 'royal_ab_color' )->set_label( __( 'Blob Color', $t ) )->set_placeholder('#D1BCF5'),
            AtomicSize::bind_to( 'royal_ab_size' )->set_label( __( 'Blob Size', $t ) ),
            AtomicSize::bind_to( 'royal_ab_complexity' )->set_label( __( 'Blob Complexity', $t ) ),
            AtomicSize::bind_to( 'royal_ab_contrast' )->set_label( __( 'Blob Contrast', $t ) ),
            AtomicSize::bind_to( 'royal_ab_smoothness' )->set_label( __( 'Blob Smoothness', $t ) ),
            AtomicSize::bind_to( 'royal_ab_h_offset' )->set_label( __( 'Blob H-Offset', $t ) ),
            AtomicSize::bind_to( 'royal_ab_v_offset' )->set_label( __( 'Blob V-Offset', $t ) ),
            AtomicSize::bind_to( 'royal_ab_opacity' )->set_label( __( 'Blob Opacity', $t ) ),
            AtomicNumber::bind_to( 'royal_ab_zindex' )->set_label( __( 'Blob Z-Index', $t ) )->set_min(-10)->set_max(9999)->set_step(1),
            AtomicNumber::bind_to( 'royal_ab_anim_dur' )->set_label( __( 'Blob Anim Duration (s)', $t ) )->set_min(1)->set_max(60)->set_step(1),

            // ── Particles Settings ──
            AtomicSelect::bind_to( 'royal_particles_scope' )->set_label( __( 'Particles Scope', $t ) )->set_options([
                ['value' => 'contained', 'label' => __('Inside Container', $t)],
                ['value' => 'fullscreen', 'label' => __('Full Screen', $t)],
            ]),
            AtomicNumber::bind_to( 'royal_particles_zindex' )->set_label( __( 'Particles Z-Index', $t ) )->set_min(-10)->set_max(9999)->set_step(1),
            AtomicTextarea::bind_to( 'royal_particles_custom_style' )->set_label( __( 'Particles JSON', $t ) )->set_placeholder( __( 'Paste JSON config here', $t ) ),

            // ── Canvas Settings ──
            AtomicSelect::bind_to( 'royal_canvas_type' )->set_label( __( 'Canvas Type', $t ) )->set_options([
                ['value' => 'gradient', 'label' => __('Gradient', $t)],
                ['value' => 'waves', 'label' => __('Waves', $t)],
                ['value' => 'snow', 'label' => __('Snow / Particles', $t)],
                ['value' => 'drops', 'label' => __('Rain Drops', $t)],
                ['value' => 'rings', 'label' => __('Rings', $t)],
                ['value' => 'fancy-rotate', 'label' => __('Fancy Rotate', $t)],
            ]),
            $text::bind_to( 'royal_canvas_bg_color' )->set_label( __( 'Canvas BG Color', $t ) )->set_placeholder('#000000'),
            AtomicSize::bind_to( 'royal_canvas_opacity' )->set_label( __( 'Canvas Opacity', $t ) ),
            AtomicNumber::bind_to( 'royal_canvas_zindex' )->set_label( __( 'Canvas Z-Index', $t ) )->set_min(-10)->set_max(9999)->set_step(1),
            AtomicSwitch::bind_to( 'royal_canvas_disable_mobile' )->set_label( __( 'Disable on Mobile', $t ) ),
            // Gradient colors
            $text::bind_to( 'royal_canvas_grad_color1' )->set_label( __( 'Gradient Color 1', $t ) )->set_placeholder('#6366f1'),
            $text::bind_to( 'royal_canvas_grad_color2' )->set_label( __( 'Gradient Color 2', $t ) )->set_placeholder('#ec4899'),
            $text::bind_to( 'royal_canvas_grad_color3' )->set_label( __( 'Gradient Color 3', $t ) )->set_placeholder('#06b6d4'),
            AtomicSize::bind_to( 'royal_canvas_grad_speed' )->set_label( __( 'Gradient Speed (s)', $t ) ),
            // Waves
            $text::bind_to( 'royal_canvas_waves_color' )->set_label( __( 'Wave Color', $t ) )->set_placeholder('#6366f1'),
            $text::bind_to( 'royal_canvas_waves_color2' )->set_label( __( 'Wave Color 2', $t ) )->set_placeholder('#818cf8'),
            AtomicSize::bind_to( 'royal_canvas_waves_count' )->set_label( __( 'Wave Count', $t ) ),
            AtomicSize::bind_to( 'royal_canvas_waves_speed' )->set_label( __( 'Wave Speed', $t ) ),
            AtomicSize::bind_to( 'royal_canvas_waves_height' )->set_label( __( 'Wave Height', $t ) ),
            // Snow
            $text::bind_to( 'royal_canvas_snow_color' )->set_label( __( 'Snow Color', $t ) )->set_placeholder('#ffffff'),
            AtomicSize::bind_to( 'royal_canvas_snow_count' )->set_label( __( 'Snow Count', $t ) ),
            AtomicSize::bind_to( 'royal_canvas_snow_speed' )->set_label( __( 'Snow Speed', $t ) ),
            AtomicSize::bind_to( 'royal_canvas_snow_size' )->set_label( __( 'Snow Size', $t ) ),
            AtomicSize::bind_to( 'royal_canvas_snow_wind' )->set_label( __( 'Snow Wind', $t ) ),
            // Drops
            $text::bind_to( 'royal_canvas_drops_color' )->set_label( __( 'Drop Color', $t ) )->set_placeholder('#6366f1'),
            AtomicSize::bind_to( 'royal_canvas_drops_speed' )->set_label( __( 'Drop Frequency', $t ) ),
            AtomicSize::bind_to( 'royal_canvas_drops_max' )->set_label( __( 'Max Ripples', $t ) ),
            // Rings
            $text::bind_to( 'royal_canvas_rings_color' )->set_label( __( 'Ring Color', $t ) )->set_placeholder('#6366f1'),
            AtomicSize::bind_to( 'royal_canvas_rings_count' )->set_label( __( 'Ring Count', $t ) ),
            AtomicSize::bind_to( 'royal_canvas_rings_speed' )->set_label( __( 'Rings Speed', $t ) ),
            // Fancy Rotate
            $text::bind_to( 'royal_canvas_rotate_color' )->set_label( __( 'Rotate Color', $t ) )->set_placeholder('#6366f1'),
            $text::bind_to( 'royal_canvas_rotate_color2' )->set_label( __( 'Rotate Color 2', $t ) )->set_placeholder('#ec4899'),
            AtomicSize::bind_to( 'royal_canvas_rotate_count' )->set_label( __( 'Shape Count', $t ) ),
            AtomicSize::bind_to( 'royal_canvas_rotate_speed' )->set_label( __( 'Rotation Speed', $t ) ),
        ];

        $controls[] = AtomicSection::make()
            ->set_id( 'royalcontrolsection_background_atomic' )
            ->set_label( __( 'Royal Background', 'royal-addons-for-elementor' ) )
            ->set_items( $items );

        return $controls;
    }

    public static function register_controls( $element ) {
        if ( ! ( $element instanceof \Elementor\Element_Base ) ) return;

        $element_id = $element->get_name();
        if ( isset( self::$registered_elements[ $element_id ] ) ) return;
        self::$registered_elements[ $element_id ] = true;

        if ( did_action( "royal_background_controls_registered_{$element_id}" ) ) {
            return;
        }
        do_action( "royal_background_controls_registered_{$element_id}" );

        // Determine correct tab: Atomic elements often don't have Style tabs or we want extensions in Advanced.
        // For Sections/Containers/Columns, Style tab is usually preferred for Background.
        $el_name = $element->get_name();
        $is_atomic = in_array($el_name, ['div-block', 'e-div-block', 'e-flexbox', 'atomic-widget-base']) || (strpos($el_name, 'atomic-') === 0);
        
        $target_tab = $is_atomic ? Controls_Manager::TAB_ADVANCED : Controls_Manager::TAB_STYLE;

        $element->start_controls_section(
            'royalcontrolsection_background_main',
            [
                'label' => __('Royal Background', 'royal-addons-for-elementor'),
                'tab'   => $target_tab,
            ]
        );

        $element->add_control(
            'royal_enable_circle',
            [
                'label'       => __('Enable Circle', 'royal-addons-for-elementor'),
                'type'        => Controls_Manager::SWITCHER,
                'render_type' => 'template',
            ]
        );

        $element->add_control(
            'royal_enable_particles',
            [
                'label'       => __('Enable Particles', 'royal-addons-for-elementor'),
                'type'        => Controls_Manager::SWITCHER,
                'render_type' => 'template',
            ]
        );

        $element->add_control(
            'royal_enable_blob',
            [
                'label'       => __('Enable Blob', 'royal-addons-for-elementor'),
                'type'        => Controls_Manager::SWITCHER,
                'render_type' => 'template',
            ]
        );

        $element->add_control(
            'royal_enable_canvas',
            [
                'label'       => __('Enable Canvas Animation', 'royal-addons-for-elementor'),
                'type'        => Controls_Manager::SWITCHER,
                'render_type' => 'template',
            ]
        );

        $element->add_control(
            'royal_enable_ambient',
            [
                'label'       => __('Enable Ambient & Deco Background', 'royal-addons-for-elementor'),
                'type'        => Controls_Manager::SWITCHER,
                'render_type' => 'template',
            ]
        );

        $element->end_controls_section();

        // --- Circle Controls ---
        $element->start_controls_section(
            'royalcontrolsection_circle_settings',
            [
                'label'     => __('Circle Settings', 'royal-addons-for-elementor'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => ['royal_enable_circle' => 'yes'],
            ]
        );

        $repeater_circle = new Repeater();

        $repeater_circle->add_control(
            'circle_title',
            [
                'label'   => __('Circle Title', 'royal-addons-for-elementor'),
                'type'    => Controls_Manager::TEXT,
                'default' => __('Circle', 'royal-addons-for-elementor'),
            ]
        );

        $repeater_circle->add_control(
            'circle_type',
            [
                'label'   => __('Circle Type', 'royal-addons-for-elementor'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'simple',
                'options' => [
                    'simple'       => 'Simple',
                    'segmented'    => 'Segmented (SVG)',
                    'corner-rings' => 'Corner Deco Rings (Stats Card)',
                ],
            ]
        );

        $repeater_circle->start_controls_tabs('circle_tabs');

        // --- Tab 1: Circle Settings ---
        $repeater_circle->start_controls_tab(
            'tab_circle_main_settings',
            ['label' => __('Circle', 'royal-addons-for-elementor')]
        );

        // == SIMPLE / CORNER CIRCLE CONTROLS ==
        $repeater_circle->add_control(
            'simple_circle_heading',
            [
                'label'     => __('Circle Style Settings', 'royal-addons-for-elementor'),
                'type'      => Controls_Manager::HEADING,
                'condition' => ['circle_type' => ['simple', 'corner-rings']],
            ]
        );

        $repeater_circle->add_control(
            'main_circle_border_style',
            [
                'label'     => __('Border Style', 'royal-addons-for-elementor'),
                'type'      => Controls_Manager::SELECT,
                'options'   => ['dotted' => 'Dotted', 'dashed' => 'Dashed', 'solid' => 'Solid', 'double' => 'Double', 'none' => 'None'],
                'default'   => 'dotted',
                'condition' => ['circle_type' => ['simple', 'corner-rings']],
            ]
        );

        $repeater_circle->add_responsive_control(
            'main_circle_size',
            [
                'label'     => __('Size', 'royal-addons-for-elementor'),
                'type'      => Controls_Manager::SLIDER,
                'default'   => ['size' => 250],
                'range'     => ['px' => ['min' => 50, 'max' => 1000]],
                'condition' => ['circle_type' => ['simple', 'corner-rings']],
            ]
        );

        $repeater_circle->add_control(
            'main_circle_color',
            [
                'label'     => __('Border Color', 'royal-addons-for-elementor'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#87CEEB',
                'condition' => ['circle_type' => ['simple', 'corner-rings']],
            ]
        );

        $repeater_circle->add_control(
            'main_circle_border_width',
            [
                'label'     => __('Border Width', 'royal-addons-for-elementor'),
                'type'      => Controls_Manager::SLIDER,
                'default'   => ['size' => 2],
                'range'     => ['px' => ['min' => 1, 'max' => 10]],
                'condition' => ['circle_type' => ['simple', 'corner-rings']],
            ]
        );

        // == SEGMENTED CIRCLE CONTROLS ==
        $repeater_circle->add_control(
            'segmented_circle_heading',
            [
                'label'     => __('Segmented Circle Settings', 'royal-addons-for-elementor'),
                'type'      => Controls_Manager::HEADING,
                'condition' => ['circle_type' => 'segmented'],
            ]
        );

        $repeater_circle->add_responsive_control(
            'graphic_size',
            [
                'label'     => __('Circle Size', 'royal-addons-for-elementor'),
                'type'      => Controls_Manager::SLIDER,
                'default'   => ['size' => 250],
                'range'     => ['px' => ['min' => 50, 'max' => 1000]],
                'condition' => ['circle_type' => 'segmented'],
            ]
        );

        $repeater_circle->add_control(
            'stroke_width',
            [
                'label'     => __('Line Thickness', 'royal-addons-for-elementor'),
                'type'      => Controls_Manager::SLIDER,
                'default'   => ['size' => 4],
                'range'     => ['px' => ['min' => 1, 'max' => 50]],
                'condition' => ['circle_type' => 'segmented'],
            ]
        );

        // Nested Repeater for Segments
        $segment_repeater = new Repeater();

        $segment_repeater->add_control(
            'segment_title',
            ['label' => __('Title', 'royal-addons-for-elementor'), 'type' => Controls_Manager::TEXT, 'default' => __('Segment', 'royal-addons-for-elementor')]
        );

        $segment_repeater->add_control(
            'segment_color',
            ['label' => __('Color', 'royal-addons-for-elementor'), 'type' => Controls_Manager::COLOR, 'default' => '#87CEEB']
        );

        $segment_repeater->add_control(
            'segment_length',
            [
                'label'      => __('Length', 'royal-addons-for-elementor'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['%'],
                'default'    => ['size' => 25, 'unit' => '%'],
                'range'      => ['%' => ['min' => 0, 'max' => 100, 'step' => 0.1]],
            ]
        );

        $segment_repeater->add_control(
            'segment_gap',
            [
                'label'      => __('Gap After', 'royal-addons-for-elementor'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['%'],
                'default'    => ['size' => 8.33, 'unit' => '%'],
                'range'      => ['%' => ['min' => 0, 'max' => 100, 'step' => 0.01]],
            ]
        );

        $repeater_circle->add_control(
            'circle_segments',
            [
                'label'         => __('Segments', 'royal-addons-for-elementor'),
                'type'          => Controls_Manager::REPEATER,
                'fields'        => $segment_repeater->get_controls(),
                'default'       => [
                    ['segment_title' => 'Segment 1'],
                    ['segment_title' => 'Segment 2'],
                    ['segment_title' => 'Segment 3'],
                ],
                'title_field'   => '{{{ segment_title }}}',
                'condition'     => ['circle_type' => 'segmented'],
            ]
        );

        // == COMMON CONTROLS ==
        $repeater_circle->add_control(
            'common_animation_heading',
            ['label' => __('Animation', 'royal-addons-for-elementor'), 'type' => Controls_Manager::HEADING, 'separator' => 'before']
        );

        $repeater_circle->add_control(
            'animation',
            [
                'label'   => __('Animation', 'royal-addons-for-elementor'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'clockwise',
                'options' => ['off' => 'Off', 'clockwise' => 'Clockwise', 'counter-clockwise' => 'Counter-Clockwise'],
            ]
        );

        $repeater_circle->add_control(
            'animation_speed',
            ['label' => __('Speed (s)', 'royal-addons-for-elementor'), 'type' => Controls_Manager::NUMBER, 'default' => 20, 'condition' => ['animation!' => 'off']]
        );

        $repeater_circle->end_controls_tab();

        // --- Tab 2: Dots ---
        $repeater_circle->start_controls_tab('tab_dots', ['label' => __('Orbiting Dots', 'royal-addons-for-elementor')]);

        $repeater_circle->add_control(
            'dots_z_index',
            [
                'label'       => __('Dots Z-Index', 'royal-addons-for-elementor'),
                'type'        => Controls_Manager::NUMBER,
                'default'     => 1,
                'separator'   => 'before',
                'description' => 'Set a z-index for the dots to layer them above/below the main circle or other effects.',
            ]
        );

        $repeater_circle->add_control(
            'dot1_enable',
            [
                'label'   => __('Enable Dot 1', 'royal-addons-for-elementor'),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $repeater_circle->add_responsive_control(
            'dot1_size',
            [
                'label'     => __('Size', 'royal-addons-for-elementor'),
                'type'      => Controls_Manager::SLIDER,
                'default'   => ['size' => 15],
                'range'     => ['px' => ['min' => 2, 'max' => 50]],
                'condition' => ['dot1_enable' => 'yes'],
            ]
        );

        $repeater_circle->add_control(
            'dot1_color',
            [
                'label'     => __('Color', 'royal-addons-for-elementor'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#FFFFFF',
                'condition' => ['dot1_enable' => 'yes'],
            ]
        );

        $repeater_circle->add_control(
            'dot1_animation',
            [
                'label'     => __('Orbit Animation', 'royal-addons-for-elementor'),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'clockwise',
                'options'   => ['off' => 'Off', 'clockwise' => 'Clockwise', 'counter-clockwise' => 'Counter-Clockwise'],
                'condition' => ['dot1_enable' => 'yes'],
            ]
        );

        $repeater_circle->add_control(
            'dot1_speed',
            [
                'label'     => __('Speed (s)', 'royal-addons-for-elementor'),
                'type'      => Controls_Manager::NUMBER,
                'default'   => 10,
                'condition' => ['dot1_enable' => 'yes', 'dot1_animation!' => 'off'],
            ]
        );

        $repeater_circle->add_control(
            'dot2_heading',
            [
                'label'     => __('Dot 2', 'royal-addons-for-elementor'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $repeater_circle->add_control(
            'dot2_enable',
            [
                'label'   => __('Enable Dot 2', 'royal-addons-for-elementor'),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $repeater_circle->add_responsive_control(
            'dot2_size',
            [
                'label'     => __('Size', 'royal-addons-for-elementor'),
                'type'      => Controls_Manager::SLIDER,
                'default'   => ['size' => 10],
                'range'     => ['px' => ['min' => 2, 'max' => 50]],
                'condition' => ['dot2_enable' => 'yes'],
            ]
        );

        $repeater_circle->add_control(
            'dot2_color',
            [
                'label'     => __('Color', 'royal-addons-for-elementor'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#87CEEB',
                'condition' => ['dot2_enable' => 'yes'],
            ]
        );

        $repeater_circle->add_control(
            'dot2_animation',
            [
                'label'     => __('Orbit Animation', 'royal-addons-for-elementor'),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'counter-clockwise',
                'options'   => ['off' => 'Off', 'clockwise' => 'Clockwise', 'counter-clockwise' => 'Counter-Clockwise'],
                'condition' => ['dot2_enable' => 'yes'],
            ]
        );

        $repeater_circle->add_control(
            'dot2_speed',
            [
                'label'     => __('Speed (s)', 'royal-addons-for-elementor'),
                'type'      => Controls_Manager::NUMBER,
                'default'   => 15,
                'condition' => ['dot2_enable' => 'yes', 'dot2_animation!' => 'off'],
            ]
        );

        $repeater_circle->end_controls_tab();

        // --- Tab 3: Position ---
        $repeater_circle->start_controls_tab(
            'tab_position',
            ['label' => __('Position', 'royal-addons-for-elementor')]
        );

        $repeater_circle->add_responsive_control(
            'graphic_horizontal_offset',
            [
                'label'      => __('Horizontal Offset', 'royal-addons-for-elementor'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'default'    => ['unit' => '%', 'size' => 50],
                'range'      => [
                    'px' => ['min' => -1000, 'max' => 1000],
                    '%'  => ['min' => 0, 'max' => 100],
                ],
            ]
        );

        $repeater_circle->add_responsive_control(
            'graphic_vertical_offset',
            [
                'label'      => __('Vertical Offset', 'royal-addons-for-elementor'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'default'    => ['unit' => '%', 'size' => 50],
                'range'      => [
                    'px' => ['min' => -1000, 'max' => 1000],
                    '%'  => ['min' => 0, 'max' => 100],
                ],
            ]
        );

        $repeater_circle->add_control(
            'graphic_z_index',
            [
                'label'   => __('Z-Index', 'royal-addons-for-elementor'),
                'type'    => Controls_Manager::NUMBER,
                'default' => 0,
            ]
        );

        $repeater_circle->end_controls_tab();

        $repeater_circle->end_controls_tabs();

        $element->add_control(
            'royal_circles_repeater',
            [
                'label'              => __('Circle', 'royal-addons-for-elementor'),
                'type'               => Controls_Manager::REPEATER,
                'fields'             => $repeater_circle->get_controls(),
                'default'            => [
                    [
                        'circle_title' => 'Circle 1',
                    ],
                ],
                'title_field'        => '{{{ circle_title }}}',
                'frontend_available' => true,
            ]
        );

        $element->end_controls_section();

        // --- Particles Controls ---
        $element->start_controls_section(
            'royalcontrolsection_particles_settings',
            [
                'label' => __('Particles Settings', 'royal-addons-for-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'royal_enable_particles' => 'yes',
                ],
            ]
        );

        $element->add_control(
            'royal_particles_scope',
            [
                'label' => __('Scope', 'royal-addons-for-elementor'),
                'type' => Controls_Manager::SELECT,
                'default' => 'contained',
                'options' => [
                    'contained' => __('Inside Container', 'royal-addons-for-elementor'),
                    'fullscreen' => __('Full Screen', 'royal-addons-for-elementor'),
                ],
                'frontend_available' => true,
                'render_type' => 'template',
            ]
        );

        $element->add_control(
            'royal_particles_zindex',
            [
                'label' => __('Z-index', 'royal-addons-for-elementor'),
                'type' => Controls_Manager::NUMBER,
                'default' => 0,
                'frontend_available' => true,
                'render_type' => 'template',
            ]
        );

        $element->add_control(
            'royal_particles_custom_style',
            [
                'label' => __('Particles JSON', 'royal-addons-for-elementor'),
                'description' => sprintf(
                    __( 'Enter the full clip-path property! See the copy-paste examples at %sParticles Generator%s', 'royal-addons-for-elementor' ),
                    '<a href="https://mehdiakram.github.io/Particles-Generator/" target="_blank">',
                    '</a>'
				),
                'type' => Controls_Manager::TEXTAREA,
                'rows' => 10,
                'frontend_available' => true,
                'default' => '{"particles":{"number":{"value":80},"color":{"value":"#ffffff"},"shape":{"type":"circle"},"move":{"enable":true,"speed":6}}}',
                'render_type' => 'template',
            ]
        );

        $element->end_controls_section();

        // --- Blob Controls ---
        $element->start_controls_section(
            'royalcontrolsection_blob_settings',
            [
                'label'     => __('Blob Settings', 'royal-addons-for-elementor'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'royal_enable_blob' => 'yes',
                ],
            ]
        );

        $repeater_blob = new Repeater();

        $repeater_blob->add_control(
            'blob_title',
            [
                'label'   => __('Title', 'royal-addons-for-elementor'),
                'type'    => Controls_Manager::TEXT,
                'default' => __('Blob Layer', 'royal-addons-for-elementor'),
            ]
        );

        $repeater_blob->add_control(
            'royal_blob_anim_mode',
            [
                'label'       => __('Animation Mode', 'royal-addons-for-elementor'),
                'type'        => Controls_Manager::SELECT,
                'default'     => 'morph',
                'options'     => [
                    'morph' => __('Morphing SVG (Anime.js)', 'royal-addons-for-elementor'),
                    'drift' => __('Soft Drifting Float (Pillars Style)', 'royal-addons-for-elementor'),
                ],
                'render_type' => 'template',
            ]
        );

        $repeater_blob->add_control(
            'royal_blob_blur',
            [
                'label'       => __('Blur (px)', 'royal-addons-for-elementor'),
                'type'        => Controls_Manager::SLIDER,
                'default'     => ['size' => 0],
                'range'       => ['px' => ['min' => 0, 'max' => 150, 'step' => 1]],
                'render_type' => 'template',
            ]
        );

        $repeater_blob->add_control(
            'royal_blob_color',
            [
                'label'       => __('Color', 'royal-addons-for-elementor'),
                'type'        => Controls_Manager::COLOR,
                'default'     => '#D1BCF5',
                'render_type' => 'template',
            ]
        );

        $repeater_blob->add_control(
            'royal_blob_complexity',
            [
                'label'       => __('Complexity', 'royal-addons-for-elementor'),
                'type'        => Controls_Manager::SLIDER,
                'default'     => ['size' => 8],
                'range'       => ['px' => ['min' => 3, 'max' => 20, 'step' => 1]],
                'render_type' => 'template',
            ]
        );

        $repeater_blob->add_control(
            'royal_blob_contrast',
            [
                'label'       => __('Contrast / Irregularity', 'royal-addons-for-elementor'),
                'type'        => Controls_Manager::SLIDER,
                'default'     => ['size' => 0.4],
                'range'       => ['px' => ['min' => 0, 'max' => 1, 'step' => 0.05]],
                'render_type' => 'template',
            ]
        );

        $repeater_blob->add_control(
            'royal_blob_smoothness',
            [
                'label'       => __('Smoothness', 'royal-addons-for-elementor'),
                'type'        => Controls_Manager::SLIDER,
                'default'     => ['size' => 1],
                'range'       => ['px' => ['min' => 0.2, 'max' => 1.5, 'step' => 0.1]],
                'render_type' => 'template',
            ]
        );

        $repeater_blob->add_responsive_control(
            'royal_blob_size',
            [
                'label'       => __('Size', 'royal-addons-for-elementor'),
                'type'        => Controls_Manager::SLIDER,
                'default'     => ['size' => 300],
                'range'       => ['px' => ['min' => 50, 'max' => 1000]],
                'render_type' => 'template',
            ]
        );

        $repeater_blob->add_responsive_control(
            'royal_blob_horizontal_offset',
            [
                'label'      => __('Horizontal Offset', 'royal-addons-for-elementor'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'default'    => ['unit' => '%', 'size' => 40],
                'range'      => [
                    'px' => ['min' => -1000, 'max' => 1000],
                    '%'  => ['min' => -100, 'max' => 100],
                ],
                'render_type' => 'template',
            ]
        );

        $repeater_blob->add_responsive_control(
            'royal_blob_vertical_offset',
            [
                'label'      => __('Vertical Offset', 'royal-addons-for-elementor'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'default'    => ['unit' => '%', 'size' => 40],
                'range'      => [
                    'px' => ['min' => -1000, 'max' => 1000],
                    '%'  => ['min' => -100, 'max' => 100],
                ],
                'render_type' => 'template',
            ]
        );

        $repeater_blob->add_control(
            'royal_blob_zindex',
            [
                'label'       => __('Z-Index', 'royal-addons-for-elementor'),
                'type'        => Controls_Manager::NUMBER,
                'default'     => 0,
                'render_type' => 'template',
            ]
        );

        $repeater_blob->add_control(
            'royal_blob_opacity',
            [
                'label'       => __('Opacity', 'royal-addons-for-elementor'),
                'type'        => Controls_Manager::SLIDER,
                'range'       => ['px' => ['min' => 0, 'max' => 1, 'step' => 0.01]],
                'default'     => ['size' => 1],
                'render_type' => 'template',
            ]
        );

        $repeater_blob->add_control(
            'royal_blob_animation_duration',
            [
                'label'       => __('Animation Duration (s)', 'royal-addons-for-elementor'),
                'type'        => Controls_Manager::NUMBER,
                'default'     => 5,
                'min'         => 0.1,
                'step'        => 0.1,
                'render_type' => 'template',
            ]
        );

        $element->add_control(
            'royal_blob_repeater',
            [
                'label'              => __('Blobs List', 'royal-addons-for-elementor'),
                'type'               => Controls_Manager::REPEATER,
                'fields'             => $repeater_blob->get_controls(),
                'default'            => [
                    [
                        'blob_title' => 'Blob 1',
                    ],
                ],
                'title_field'        => '{{{ blob_title }}}',
                'frontend_available' => true,
            ]
        );

        $element->end_controls_section();

        // ── Canvas Animation Controls ─────────────────────────────────
        $element->start_controls_section(
            'royalcontrolsection_canvas_settings',
            [
                'label'     => __('Canvas Animation Settings', 'royal-addons-for-elementor'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => ['royal_enable_canvas' => 'yes'],
            ]
        );

        $element->add_control(
            'royal_canvas_type',
            [
                'label'       => __('Animation Type', 'royal-addons-for-elementor'),
                'type'        => Controls_Manager::SELECT,
                'default'     => 'waves',
                'options'     => [
                    'gradient'     => __('Gradient', 'royal-addons-for-elementor'),
                    'waves'        => __('Waves', 'royal-addons-for-elementor'),
                    'snow'         => __('Snow / Particles', 'royal-addons-for-elementor'),
                    'drops'        => __('Rain Drops', 'royal-addons-for-elementor'),
                    'rings'        => __('Rings', 'royal-addons-for-elementor'),
                    'fancy-rotate' => __('Fancy Rotate', 'royal-addons-for-elementor'),
                ],
                'render_type' => 'template',
                'frontend_available' => true,
            ]
        );

        // ── Gradient ──────────────────────────────────────────────────
        $element->add_control(
            'royal_canvas_grad_heading',
            [
                'label'     => __('Gradient Colors', 'royal-addons-for-elementor'),
                'type'      => Controls_Manager::HEADING,
                'condition' => ['royal_canvas_type' => 'gradient'],
            ]
        );

        $element->add_control(
            'royal_canvas_grad_color1',
            [
                'label'              => __('Color 1', 'royal-addons-for-elementor'),
                'type'               => Controls_Manager::COLOR,
                'default'            => '#6366f1',
                'frontend_available' => true,
                'condition'          => ['royal_canvas_type' => 'gradient'],
            ]
        );

        $element->add_control(
            'royal_canvas_grad_color2',
            [
                'label'              => __('Color 2', 'royal-addons-for-elementor'),
                'type'               => Controls_Manager::COLOR,
                'default'            => '#ec4899',
                'frontend_available' => true,
                'condition'          => ['royal_canvas_type' => 'gradient'],
            ]
        );

        $element->add_control(
            'royal_canvas_grad_color3',
            [
                'label'              => __('Color 3', 'royal-addons-for-elementor'),
                'type'               => Controls_Manager::COLOR,
                'default'            => '#06b6d4',
                'frontend_available' => true,
                'condition'          => ['royal_canvas_type' => 'gradient'],
            ]
        );

        $element->add_control(
            'royal_canvas_grad_speed',
            [
                'label'              => __('Speed (seconds)', 'royal-addons-for-elementor'),
                'type'               => Controls_Manager::SLIDER,
                'default'            => ['size' => 8],
                'range'              => ['px' => ['min' => 2, 'max' => 30, 'step' => 1]],
                'frontend_available' => true,
                'condition'          => ['royal_canvas_type' => 'gradient'],
            ]
        );

        // ── Waves ─────────────────────────────────────────────────────
        $element->add_control(
            'royal_canvas_waves_color',
            [
                'label'              => __('Wave Color', 'royal-addons-for-elementor'),
                'type'               => Controls_Manager::COLOR,
                'default'            => '#6366f1',
                'frontend_available' => true,
                'condition'          => ['royal_canvas_type' => 'waves'],
            ]
        );

        $element->add_control(
            'royal_canvas_waves_color2',
            [
                'label'              => __('Wave Color 2', 'royal-addons-for-elementor'),
                'type'               => Controls_Manager::COLOR,
                'default'            => '#818cf8',
                'frontend_available' => true,
                'condition'          => ['royal_canvas_type' => 'waves'],
            ]
        );

        $element->add_control(
            'royal_canvas_waves_count',
            [
                'label'              => __('Wave Count', 'royal-addons-for-elementor'),
                'type'               => Controls_Manager::SLIDER,
                'default'            => ['size' => 3],
                'range'              => ['px' => ['min' => 1, 'max' => 6, 'step' => 1]],
                'frontend_available' => true,
                'condition'          => ['royal_canvas_type' => 'waves'],
            ]
        );

        $element->add_control(
            'royal_canvas_waves_speed',
            [
                'label'              => __('Speed', 'royal-addons-for-elementor'),
                'type'               => Controls_Manager::SLIDER,
                'default'            => ['size' => 5],
                'range'              => ['px' => ['min' => 1, 'max' => 20, 'step' => 1]],
                'frontend_available' => true,
                'condition'          => ['royal_canvas_type' => 'waves'],
            ]
        );

        $element->add_control(
            'royal_canvas_waves_height',
            [
                'label'              => __('Wave Height', 'royal-addons-for-elementor'),
                'type'               => Controls_Manager::SLIDER,
                'default'            => ['size' => 40],
                'range'              => ['px' => ['min' => 10, 'max' => 200, 'step' => 5]],
                'frontend_available' => true,
                'condition'          => ['royal_canvas_type' => 'waves'],
            ]
        );

        // ── Snow / Particles ──────────────────────────────────────────
        $element->add_control(
            'royal_canvas_snow_color',
            [
                'label'              => __('Particle Color', 'royal-addons-for-elementor'),
                'type'               => Controls_Manager::COLOR,
                'default'            => '#ffffff',
                'frontend_available' => true,
                'condition'          => ['royal_canvas_type' => 'snow'],
            ]
        );

        $element->add_control(
            'royal_canvas_snow_count',
            [
                'label'              => __('Particle Count', 'royal-addons-for-elementor'),
                'type'               => Controls_Manager::SLIDER,
                'default'            => ['size' => 80],
                'range'              => ['px' => ['min' => 10, 'max' => 300, 'step' => 10]],
                'frontend_available' => true,
                'condition'          => ['royal_canvas_type' => 'snow'],
            ]
        );

        $element->add_control(
            'royal_canvas_snow_speed',
            [
                'label'              => __('Fall Speed', 'royal-addons-for-elementor'),
                'type'               => Controls_Manager::SLIDER,
                'default'            => ['size' => 2],
                'range'              => ['px' => ['min' => 0.5, 'max' => 10, 'step' => 0.5]],
                'frontend_available' => true,
                'condition'          => ['royal_canvas_type' => 'snow'],
            ]
        );

        $element->add_control(
            'royal_canvas_snow_size',
            [
                'label'              => __('Particle Size', 'royal-addons-for-elementor'),
                'type'               => Controls_Manager::SLIDER,
                'default'            => ['size' => 4],
                'range'              => ['px' => ['min' => 1, 'max' => 20, 'step' => 1]],
                'frontend_available' => true,
                'condition'          => ['royal_canvas_type' => 'snow'],
            ]
        );

        $element->add_control(
            'royal_canvas_snow_wind',
            [
                'label'              => __('Wind Effect', 'royal-addons-for-elementor'),
                'description'        => __('Negative = left, Positive = right', 'royal-addons-for-elementor'),
                'type'               => Controls_Manager::SLIDER,
                'default'            => ['size' => 0.5],
                'range'              => ['px' => ['min' => -3, 'max' => 3, 'step' => 0.1]],
                'frontend_available' => true,
                'condition'          => ['royal_canvas_type' => 'snow'],
            ]
        );

        // ── Rain Drops ────────────────────────────────────────────────
        $element->add_control(
            'royal_canvas_drops_color',
            [
                'label'              => __('Drop Color', 'royal-addons-for-elementor'),
                'type'               => Controls_Manager::COLOR,
                'default'            => '#6366f1',
                'frontend_available' => true,
                'condition'          => ['royal_canvas_type' => 'drops'],
            ]
        );

        $element->add_control(
            'royal_canvas_drops_speed',
            [
                'label'              => __('Drop Frequency', 'royal-addons-for-elementor'),
                'type'               => Controls_Manager::SLIDER,
                'default'            => ['size' => 5],
                'range'              => ['px' => ['min' => 1, 'max' => 20, 'step' => 1]],
                'frontend_available' => true,
                'condition'          => ['royal_canvas_type' => 'drops'],
            ]
        );

        $element->add_control(
            'royal_canvas_drops_max',
            [
                'label'              => __('Max Ripples', 'royal-addons-for-elementor'),
                'type'               => Controls_Manager::SLIDER,
                'default'            => ['size' => 15],
                'range'              => ['px' => ['min' => 3, 'max' => 50, 'step' => 1]],
                'frontend_available' => true,
                'condition'          => ['royal_canvas_type' => 'drops'],
            ]
        );

        // ── Rings ─────────────────────────────────────────────────────
        $element->add_control(
            'royal_canvas_rings_color',
            [
                'label'              => __('Ring Color', 'royal-addons-for-elementor'),
                'type'               => Controls_Manager::COLOR,
                'default'            => '#6366f1',
                'frontend_available' => true,
                'condition'          => ['royal_canvas_type' => 'rings'],
            ]
        );

        $element->add_control(
            'royal_canvas_rings_count',
            [
                'label'              => __('Ring Count', 'royal-addons-for-elementor'),
                'type'               => Controls_Manager::SLIDER,
                'default'            => ['size' => 5],
                'range'              => ['px' => ['min' => 2, 'max' => 15, 'step' => 1]],
                'frontend_available' => true,
                'condition'          => ['royal_canvas_type' => 'rings'],
            ]
        );

        $element->add_control(
            'royal_canvas_rings_speed',
            [
                'label'              => __('Expand Speed', 'royal-addons-for-elementor'),
                'type'               => Controls_Manager::SLIDER,
                'default'            => ['size' => 3],
                'range'              => ['px' => ['min' => 1, 'max' => 10, 'step' => 0.5]],
                'frontend_available' => true,
                'condition'          => ['royal_canvas_type' => 'rings'],
            ]
        );

        // ── Fancy Rotate ──────────────────────────────────────────────
        $element->add_control(
            'royal_canvas_rotate_color',
            [
                'label'              => __('Shape Color', 'royal-addons-for-elementor'),
                'type'               => Controls_Manager::COLOR,
                'default'            => '#6366f1',
                'frontend_available' => true,
                'condition'          => ['royal_canvas_type' => 'fancy-rotate'],
            ]
        );

        $element->add_control(
            'royal_canvas_rotate_color2',
            [
                'label'              => __('Shape Color 2', 'royal-addons-for-elementor'),
                'type'               => Controls_Manager::COLOR,
                'default'            => '#ec4899',
                'frontend_available' => true,
                'condition'          => ['royal_canvas_type' => 'fancy-rotate'],
            ]
        );

        $element->add_control(
            'royal_canvas_rotate_count',
            [
                'label'              => __('Shape Count', 'royal-addons-for-elementor'),
                'type'               => Controls_Manager::SLIDER,
                'default'            => ['size' => 8],
                'range'              => ['px' => ['min' => 3, 'max' => 30, 'step' => 1]],
                'frontend_available' => true,
                'condition'          => ['royal_canvas_type' => 'fancy-rotate'],
            ]
        );

        $element->add_control(
            'royal_canvas_rotate_speed',
            [
                'label'              => __('Rotation Speed', 'royal-addons-for-elementor'),
                'type'               => Controls_Manager::SLIDER,
                'default'            => ['size' => 3],
                'range'              => ['px' => ['min' => 0.5, 'max' => 15, 'step' => 0.5]],
                'frontend_available' => true,
                'condition'          => ['royal_canvas_type' => 'fancy-rotate'],
            ]
        );

        // ── Common Controls ───────────────────────────────────────────
        $element->add_control(
            'royal_canvas_common_heading',
            [
                'label'     => __('Common', 'royal-addons-for-elementor'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $element->add_control(
            'royal_canvas_bg_color',
            [
                'label'              => __('Background Color', 'royal-addons-for-elementor'),
                'type'               => Controls_Manager::COLOR,
                'default'            => '',
                'frontend_available' => true,
            ]
        );

        $element->add_control(
            'royal_canvas_opacity',
            [
                'label'              => __('Opacity', 'royal-addons-for-elementor'),
                'type'               => Controls_Manager::SLIDER,
                'default'            => ['size' => 1],
                'range'              => ['px' => ['min' => 0.1, 'max' => 1, 'step' => 0.05]],
                'frontend_available' => true,
            ]
        );

        $element->add_control(
            'royal_canvas_zindex',
            [
                'label'              => __('Z-Index', 'royal-addons-for-elementor'),
                'type'               => Controls_Manager::NUMBER,
                'default'            => 0,
                'frontend_available' => true,
            ]
        );

        $element->add_control(
            'royal_canvas_disable_mobile',
            [
                'label'              => __('Disable on Mobile', 'royal-addons-for-elementor'),
                'type'               => Controls_Manager::SWITCHER,
                'default'            => 'yes',
                'frontend_available' => true,
            ]
        );

        $element->end_controls_section();

        // ── Ambient & Deco Background Controls ─────────────────────────
        $element->start_controls_section(
            'royalcontrolsection_ambient_settings',
            [
                'label'     => __('Ambient & Deco Background Settings', 'royal-addons-for-elementor'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => ['royal_enable_ambient' => 'yes'],
            ]
        );

        $element->add_control(
            'royal_ambient_style',
            [
                'label'       => __('Style Preset', 'royal-addons-for-elementor'),
                'type'        => Controls_Manager::SELECT,
                'default'     => 'corner_rings',
                'options'     => [
                    'corner_rings'    => __('Corner Rotating Dashed Rings (Stats Card)', 'royal-addons-for-elementor'),
                    'soft_spheres'    => __('Soft Drifting Ambient Blobs (Our Eight Pillars)', 'royal-addons-for-elementor'),
                    'hero_blobs'      => __('Hero Dual Blurred Drifting Blobs', 'royal-addons-for-elementor'),
                    'dot_grid'        => __('Vignette Dot Grid Matrix (Radial Dots)', 'royal-addons-for-elementor'),
                    'rising_bubbles'  => __('Floating Rising Bubbles', 'royal-addons-for-elementor'),
                    'combined'        => __('Combined Atmosphere (All Styles)', 'royal-addons-for-elementor'),
                ],
                'frontend_available' => true,
                'render_type' => 'template',
            ]
        );

        // ── Corner Rings Placement Preset ─────────────────────────────
        $element->add_control(
            'royal_ambient_corner_preset',
            [
                'label'   => __('Corner Rings Placement', 'royal-addons-for-elementor'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'opposite_tr_bl',
                'options' => [
                    'all_4'          => __('All 4 Corners (TL, TR, BL, BR)', 'royal-addons-for-elementor'),
                    'opposite_tr_bl' => __('Opposite: Top-Right & Bottom-Left (Default)', 'royal-addons-for-elementor'),
                    'opposite_tl_br' => __('Opposite: Top-Left & Bottom-Right', 'royal-addons-for-elementor'),
                    'top_both'       => __('Top 2 Corners (Top-Left & Top-Right)', 'royal-addons-for-elementor'),
                    'bottom_both'    => __('Bottom 2 Corners (Bottom-Left & Bottom-Right)', 'royal-addons-for-elementor'),
                    'custom'         => __('Custom Selection (Enable Individually)', 'royal-addons-for-elementor'),
                ],
                'frontend_available' => true,
                'render_type' => 'template',
                'condition' => ['royal_ambient_style' => ['corner_rings', 'combined']],
            ]
        );

        // ── Corner Ring: Top-Left (TL) ────────────────────────────────
        $element->add_control(
            'royal_ambient_tl_heading',
            [
                'label'     => __('Corner Ring: Top-Left (TL)', 'royal-addons-for-elementor'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'royal_ambient_style' => ['corner_rings', 'combined'],
                    'royal_ambient_corner_preset' => ['all_4', 'opposite_tl_br', 'top_both', 'custom'],
                ],
            ]
        );

        $element->add_control(
            'royal_ambient_tl_enable',
            [
                'label'              => __('Enable Top-Left Ring', 'royal-addons-for-elementor'),
                'type'               => Controls_Manager::SWITCHER,
                'default'            => 'yes',
                'frontend_available' => true,
                'condition'          => [
                    'royal_ambient_style' => ['corner_rings', 'combined'],
                    'royal_ambient_corner_preset' => 'custom',
                ],
            ]
        );

        $element->add_responsive_control(
            'royal_ambient_tl_size',
            [
                'label'              => __('Size', 'royal-addons-for-elementor'),
                'type'               => Controls_Manager::SLIDER,
                'default'            => ['size' => 280],
                'range'              => ['px' => ['min' => 100, 'max' => 900, 'step' => 10]],
                'frontend_available' => true,
                'condition'          => [
                    'royal_ambient_style' => ['corner_rings', 'combined'],
                    'royal_ambient_corner_preset' => ['all_4', 'opposite_tl_br', 'top_both', 'custom'],
                ],
            ]
        );

        $element->add_control(
            'royal_ambient_tl_color',
            [
                'label'              => __('Color', 'royal-addons-for-elementor'),
                'type'               => Controls_Manager::COLOR,
                'default'            => 'rgba(255, 255, 255, 0.16)',
                'frontend_available' => true,
                'condition'          => [
                    'royal_ambient_style' => ['corner_rings', 'combined'],
                    'royal_ambient_corner_preset' => ['all_4', 'opposite_tl_br', 'top_both', 'custom'],
                ],
            ]
        );

        $element->add_control(
            'royal_ambient_tl_border_style',
            [
                'label'              => __('Border Style', 'royal-addons-for-elementor'),
                'type'               => Controls_Manager::SELECT,
                'default'            => 'dashed',
                'options'            => [
                    'dashed' => __('Dashed', 'royal-addons-for-elementor'),
                    'dotted' => __('Dotted', 'royal-addons-for-elementor'),
                    'solid'  => __('Solid', 'royal-addons-for-elementor'),
                ],
                'frontend_available' => true,
                'condition'          => [
                    'royal_ambient_style' => ['corner_rings', 'combined'],
                    'royal_ambient_corner_preset' => ['all_4', 'opposite_tl_br', 'top_both', 'custom'],
                ],
            ]
        );

        $element->add_control(
            'royal_ambient_tl_border_width',
            [
                'label'              => __('Border Width', 'royal-addons-for-elementor'),
                'type'               => Controls_Manager::SLIDER,
                'default'            => ['size' => 2],
                'range'              => ['px' => ['min' => 1, 'max' => 10]],
                'frontend_available' => true,
                'condition'          => [
                    'royal_ambient_style' => ['corner_rings', 'combined'],
                    'royal_ambient_corner_preset' => ['all_4', 'opposite_tl_br', 'top_both', 'custom'],
                ],
            ]
        );

        $element->add_responsive_control(
            'royal_ambient_tl_top',
            [
                'label'              => __('Offset Top', 'royal-addons-for-elementor'),
                'type'               => Controls_Manager::SLIDER,
                'default'            => ['size' => -120],
                'range'              => ['px' => ['min' => -500, 'max' => 500]],
                'frontend_available' => true,
                'condition'          => [
                    'royal_ambient_style' => ['corner_rings', 'combined'],
                    'royal_ambient_corner_preset' => ['all_4', 'opposite_tl_br', 'top_both', 'custom'],
                ],
            ]
        );

        $element->add_responsive_control(
            'royal_ambient_tl_left',
            [
                'label'              => __('Offset Left', 'royal-addons-for-elementor'),
                'type'               => Controls_Manager::SLIDER,
                'default'            => ['size' => -80],
                'range'              => ['px' => ['min' => -500, 'max' => 500]],
                'frontend_available' => true,
                'condition'          => [
                    'royal_ambient_style' => ['corner_rings', 'combined'],
                    'royal_ambient_corner_preset' => ['all_4', 'opposite_tl_br', 'top_both', 'custom'],
                ],
            ]
        );

        $element->add_control(
            'royal_ambient_tl_speed',
            [
                'label'              => __('Rotation Speed (seconds)', 'royal-addons-for-elementor'),
                'type'               => Controls_Manager::NUMBER,
                'default'            => 35,
                'min'                => 1,
                'max'                => 180,
                'frontend_available' => true,
                'condition'          => [
                    'royal_ambient_style' => ['corner_rings', 'combined'],
                    'royal_ambient_corner_preset' => ['all_4', 'opposite_tl_br', 'top_both', 'custom'],
                ],
            ]
        );

        $element->add_control(
            'royal_ambient_tl_direction',
            [
                'label'              => __('Direction', 'royal-addons-for-elementor'),
                'type'               => Controls_Manager::SELECT,
                'default'            => 'reverse',
                'options'            => [
                    'normal'  => __('Clockwise', 'royal-addons-for-elementor'),
                    'reverse' => __('Counter-Clockwise', 'royal-addons-for-elementor'),
                ],
                'frontend_available' => true,
                'condition'          => [
                    'royal_ambient_style' => ['corner_rings', 'combined'],
                    'royal_ambient_corner_preset' => ['all_4', 'opposite_tl_br', 'top_both', 'custom'],
                ],
            ]
        );

        $element->add_control(
            'royal_ambient_tl_anim',
            [
                'label'              => __('Animation Mode', 'royal-addons-for-elementor'),
                'type'               => Controls_Manager::SELECT,
                'default'            => 'spin',
                'options'            => [
                    'spin'  => __('Continuous Rotation (360°)', 'royal-addons-for-elementor'),
                    'pulse' => __('Rotation + Breathing Pulse', 'royal-addons-for-elementor'),
                ],
                'frontend_available' => true,
                'condition'          => [
                    'royal_ambient_style' => ['corner_rings', 'combined'],
                    'royal_ambient_corner_preset' => ['all_4', 'opposite_tl_br', 'top_both', 'custom'],
                ],
            ]
        );

        // ── Corner Ring: Top-Right (TR / R1) ──────────────────────────
        $element->add_control(
            'royal_ambient_r1_heading',
            [
                'label'     => __('Corner Ring: Top-Right (TR)', 'royal-addons-for-elementor'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'royal_ambient_style' => ['corner_rings', 'combined'],
                    'royal_ambient_corner_preset' => ['all_4', 'opposite_tr_bl', 'top_both', 'custom'],
                ],
            ]
        );

        $element->add_control(
            'royal_ambient_r1_enable',
            [
                'label'              => __('Enable Top-Right Ring', 'royal-addons-for-elementor'),
                'type'               => Controls_Manager::SWITCHER,
                'default'            => 'yes',
                'frontend_available' => true,
                'condition'          => [
                    'royal_ambient_style' => ['corner_rings', 'combined'],
                    'royal_ambient_corner_preset' => 'custom',
                ],
            ]
        );

        $element->add_responsive_control(
            'royal_ambient_r1_size',
            [
                'label'              => __('Size', 'royal-addons-for-elementor'),
                'type'               => Controls_Manager::SLIDER,
                'default'            => ['size' => 320],
                'range'              => ['px' => ['min' => 100, 'max' => 900, 'step' => 10]],
                'frontend_available' => true,
                'condition'          => [
                    'royal_ambient_style' => ['corner_rings', 'combined'],
                    'royal_ambient_corner_preset' => ['all_4', 'opposite_tr_bl', 'top_both', 'custom'],
                ],
            ]
        );

        $element->add_control(
            'royal_ambient_r1_color',
            [
                'label'              => __('Color', 'royal-addons-for-elementor'),
                'type'               => Controls_Manager::COLOR,
                'default'            => 'rgba(255, 255, 255, 0.16)',
                'frontend_available' => true,
                'condition'          => [
                    'royal_ambient_style' => ['corner_rings', 'combined'],
                    'royal_ambient_corner_preset' => ['all_4', 'opposite_tr_bl', 'top_both', 'custom'],
                ],
            ]
        );

        $element->add_control(
            'royal_ambient_r1_border_style',
            [
                'label'              => __('Border Style', 'royal-addons-for-elementor'),
                'type'               => Controls_Manager::SELECT,
                'default'            => 'dashed',
                'options'            => [
                    'dashed' => __('Dashed', 'royal-addons-for-elementor'),
                    'dotted' => __('Dotted', 'royal-addons-for-elementor'),
                    'solid'  => __('Solid', 'royal-addons-for-elementor'),
                ],
                'frontend_available' => true,
                'condition'          => [
                    'royal_ambient_style' => ['corner_rings', 'combined'],
                    'royal_ambient_corner_preset' => ['all_4', 'opposite_tr_bl', 'top_both', 'custom'],
                ],
            ]
        );

        $element->add_control(
            'royal_ambient_r1_border_width',
            [
                'label'              => __('Border Width', 'royal-addons-for-elementor'),
                'type'               => Controls_Manager::SLIDER,
                'default'            => ['size' => 2],
                'range'              => ['px' => ['min' => 1, 'max' => 10]],
                'frontend_available' => true,
                'condition'          => [
                    'royal_ambient_style' => ['corner_rings', 'combined'],
                    'royal_ambient_corner_preset' => ['all_4', 'opposite_tr_bl', 'top_both', 'custom'],
                ],
            ]
        );

        $element->add_responsive_control(
            'royal_ambient_r1_top',
            [
                'label'              => __('Offset Top', 'royal-addons-for-elementor'),
                'type'               => Controls_Manager::SLIDER,
                'default'            => ['size' => -140],
                'range'              => ['px' => ['min' => -500, 'max' => 500]],
                'frontend_available' => true,
                'condition'          => [
                    'royal_ambient_style' => ['corner_rings', 'combined'],
                    'royal_ambient_corner_preset' => ['all_4', 'opposite_tr_bl', 'top_both', 'custom'],
                ],
            ]
        );

        $element->add_responsive_control(
            'royal_ambient_r1_right',
            [
                'label'              => __('Offset Right', 'royal-addons-for-elementor'),
                'type'               => Controls_Manager::SLIDER,
                'default'            => ['size' => -100],
                'range'              => ['px' => ['min' => -500, 'max' => 500]],
                'frontend_available' => true,
                'condition'          => [
                    'royal_ambient_style' => ['corner_rings', 'combined'],
                    'royal_ambient_corner_preset' => ['all_4', 'opposite_tr_bl', 'top_both', 'custom'],
                ],
            ]
        );

        $element->add_control(
            'royal_ambient_r1_speed',
            [
                'label'              => __('Rotation Speed (seconds)', 'royal-addons-for-elementor'),
                'type'               => Controls_Manager::NUMBER,
                'default'            => 40,
                'min'                => 1,
                'max'                => 180,
                'frontend_available' => true,
                'condition'          => [
                    'royal_ambient_style' => ['corner_rings', 'combined'],
                    'royal_ambient_corner_preset' => ['all_4', 'opposite_tr_bl', 'top_both', 'custom'],
                ],
            ]
        );

        $element->add_control(
            'royal_ambient_r1_direction',
            [
                'label'              => __('Direction', 'royal-addons-for-elementor'),
                'type'               => Controls_Manager::SELECT,
                'default'            => 'normal',
                'options'            => [
                    'normal'  => __('Clockwise', 'royal-addons-for-elementor'),
                    'reverse' => __('Counter-Clockwise', 'royal-addons-for-elementor'),
                ],
                'frontend_available' => true,
                'condition'          => [
                    'royal_ambient_style' => ['corner_rings', 'combined'],
                    'royal_ambient_corner_preset' => ['all_4', 'opposite_tr_bl', 'top_both', 'custom'],
                ],
            ]
        );

        $element->add_control(
            'royal_ambient_r1_anim',
            [
                'label'              => __('Animation Mode', 'royal-addons-for-elementor'),
                'type'               => Controls_Manager::SELECT,
                'default'            => 'spin',
                'options'            => [
                    'spin'  => __('Continuous Rotation (360°)', 'royal-addons-for-elementor'),
                    'pulse' => __('Rotation + Breathing Pulse', 'royal-addons-for-elementor'),
                ],
                'frontend_available' => true,
                'condition'          => [
                    'royal_ambient_style' => ['corner_rings', 'combined'],
                    'royal_ambient_corner_preset' => ['all_4', 'opposite_tr_bl', 'top_both', 'custom'],
                ],
            ]
        );

        // ── Corner Ring: Bottom-Left (BL / R2) ─────────────────────────
        $element->add_control(
            'royal_ambient_r2_heading',
            [
                'label'     => __('Corner Ring: Bottom-Left (BL)', 'royal-addons-for-elementor'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'royal_ambient_style' => ['corner_rings', 'combined'],
                    'royal_ambient_corner_preset' => ['all_4', 'opposite_tr_bl', 'bottom_both', 'custom'],
                ],
            ]
        );

        $element->add_control(
            'royal_ambient_r2_enable',
            [
                'label'              => __('Enable Bottom-Left Ring', 'royal-addons-for-elementor'),
                'type'               => Controls_Manager::SWITCHER,
                'default'            => 'yes',
                'frontend_available' => true,
                'condition'          => [
                    'royal_ambient_style' => ['corner_rings', 'combined'],
                    'royal_ambient_corner_preset' => 'custom',
                ],
            ]
        );

        $element->add_responsive_control(
            'royal_ambient_r2_size',
            [
                'label'              => __('Size', 'royal-addons-for-elementor'),
                'type'               => Controls_Manager::SLIDER,
                'default'            => ['size' => 220],
                'range'              => ['px' => ['min' => 100, 'max' => 900, 'step' => 10]],
                'frontend_available' => true,
                'condition'          => [
                    'royal_ambient_style' => ['corner_rings', 'combined'],
                    'royal_ambient_corner_preset' => ['all_4', 'opposite_tr_bl', 'bottom_both', 'custom'],
                ],
            ]
        );

        $element->add_control(
            'royal_ambient_r2_color',
            [
                'label'              => __('Color', 'royal-addons-for-elementor'),
                'type'               => Controls_Manager::COLOR,
                'default'            => 'rgba(255, 255, 255, 0.16)',
                'frontend_available' => true,
                'condition'          => [
                    'royal_ambient_style' => ['corner_rings', 'combined'],
                    'royal_ambient_corner_preset' => ['all_4', 'opposite_tr_bl', 'bottom_both', 'custom'],
                ],
            ]
        );

        $element->add_control(
            'royal_ambient_r2_border_style',
            [
                'label'              => __('Border Style', 'royal-addons-for-elementor'),
                'type'               => Controls_Manager::SELECT,
                'default'            => 'dashed',
                'options'            => [
                    'dashed' => __('Dashed', 'royal-addons-for-elementor'),
                    'dotted' => __('Dotted', 'royal-addons-for-elementor'),
                    'solid'  => __('Solid', 'royal-addons-for-elementor'),
                ],
                'frontend_available' => true,
                'condition'          => [
                    'royal_ambient_style' => ['corner_rings', 'combined'],
                    'royal_ambient_corner_preset' => ['all_4', 'opposite_tr_bl', 'bottom_both', 'custom'],
                ],
            ]
        );

        $element->add_control(
            'royal_ambient_r2_border_width',
            [
                'label'              => __('Border Width', 'royal-addons-for-elementor'),
                'type'               => Controls_Manager::SLIDER,
                'default'            => ['size' => 2],
                'range'              => ['px' => ['min' => 1, 'max' => 10]],
                'frontend_available' => true,
                'condition'          => [
                    'royal_ambient_style' => ['corner_rings', 'combined'],
                    'royal_ambient_corner_preset' => ['all_4', 'opposite_tr_bl', 'bottom_both', 'custom'],
                ],
            ]
        );

        $element->add_responsive_control(
            'royal_ambient_r2_bottom',
            [
                'label'              => __('Offset Bottom', 'royal-addons-for-elementor'),
                'type'               => Controls_Manager::SLIDER,
                'default'            => ['size' => -100],
                'range'              => ['px' => ['min' => -500, 'max' => 500]],
                'frontend_available' => true,
                'condition'          => [
                    'royal_ambient_style' => ['corner_rings', 'combined'],
                    'royal_ambient_corner_preset' => ['all_4', 'opposite_tr_bl', 'bottom_both', 'custom'],
                ],
            ]
        );

        $element->add_responsive_control(
            'royal_ambient_r2_left',
            [
                'label'              => __('Offset Left', 'royal-addons-for-elementor'),
                'type'               => Controls_Manager::SLIDER,
                'default'            => ['size' => -70],
                'range'              => ['px' => ['min' => -500, 'max' => 500]],
                'frontend_available' => true,
                'condition'          => [
                    'royal_ambient_style' => ['corner_rings', 'combined'],
                    'royal_ambient_corner_preset' => ['all_4', 'opposite_tr_bl', 'bottom_both', 'custom'],
                ],
            ]
        );

        $element->add_control(
            'royal_ambient_r2_speed',
            [
                'label'              => __('Rotation Speed (seconds)', 'royal-addons-for-elementor'),
                'type'               => Controls_Manager::NUMBER,
                'default'            => 40,
                'min'                => 1,
                'max'                => 180,
                'frontend_available' => true,
                'condition'          => [
                    'royal_ambient_style' => ['corner_rings', 'combined'],
                    'royal_ambient_corner_preset' => ['all_4', 'opposite_tr_bl', 'bottom_both', 'custom'],
                ],
            ]
        );

        $element->add_control(
            'royal_ambient_r2_direction',
            [
                'label'              => __('Direction', 'royal-addons-for-elementor'),
                'type'               => Controls_Manager::SELECT,
                'default'            => 'reverse',
                'options'            => [
                    'normal'  => __('Clockwise', 'royal-addons-for-elementor'),
                    'reverse' => __('Counter-Clockwise', 'royal-addons-for-elementor'),
                ],
                'frontend_available' => true,
                'condition'          => [
                    'royal_ambient_style' => ['corner_rings', 'combined'],
                    'royal_ambient_corner_preset' => ['all_4', 'opposite_tr_bl', 'bottom_both', 'custom'],
                ],
            ]
        );

        $element->add_control(
            'royal_ambient_r2_anim',
            [
                'label'              => __('Animation Mode', 'royal-addons-for-elementor'),
                'type'               => Controls_Manager::SELECT,
                'default'            => 'spin',
                'options'            => [
                    'spin'  => __('Continuous Rotation (360°)', 'royal-addons-for-elementor'),
                    'pulse' => __('Rotation + Breathing Pulse', 'royal-addons-for-elementor'),
                ],
                'frontend_available' => true,
                'condition'          => [
                    'royal_ambient_style' => ['corner_rings', 'combined'],
                    'royal_ambient_corner_preset' => ['all_4', 'opposite_tr_bl', 'bottom_both', 'custom'],
                ],
            ]
        );

        // ── Corner Ring: Bottom-Right (BR) ────────────────────────────
        $element->add_control(
            'royal_ambient_br_heading',
            [
                'label'     => __('Corner Ring: Bottom-Right (BR)', 'royal-addons-for-elementor'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'royal_ambient_style' => ['corner_rings', 'combined'],
                    'royal_ambient_corner_preset' => ['all_4', 'opposite_tl_br', 'bottom_both', 'custom'],
                ],
            ]
        );

        $element->add_control(
            'royal_ambient_br_enable',
            [
                'label'              => __('Enable Bottom-Right Ring', 'royal-addons-for-elementor'),
                'type'               => Controls_Manager::SWITCHER,
                'default'            => 'yes',
                'frontend_available' => true,
                'condition'          => [
                    'royal_ambient_style' => ['corner_rings', 'combined'],
                    'royal_ambient_corner_preset' => 'custom',
                ],
            ]
        );

        $element->add_responsive_control(
            'royal_ambient_br_size',
            [
                'label'              => __('Size', 'royal-addons-for-elementor'),
                'type'               => Controls_Manager::SLIDER,
                'default'            => ['size' => 300],
                'range'              => ['px' => ['min' => 100, 'max' => 900, 'step' => 10]],
                'frontend_available' => true,
                'condition'          => [
                    'royal_ambient_style' => ['corner_rings', 'combined'],
                    'royal_ambient_corner_preset' => ['all_4', 'opposite_tl_br', 'bottom_both', 'custom'],
                ],
            ]
        );

        $element->add_control(
            'royal_ambient_br_color',
            [
                'label'              => __('Color', 'royal-addons-for-elementor'),
                'type'               => Controls_Manager::COLOR,
                'default'            => 'rgba(255, 255, 255, 0.16)',
                'frontend_available' => true,
                'condition'          => [
                    'royal_ambient_style' => ['corner_rings', 'combined'],
                    'royal_ambient_corner_preset' => ['all_4', 'opposite_tl_br', 'bottom_both', 'custom'],
                ],
            ]
        );

        $element->add_control(
            'royal_ambient_br_border_style',
            [
                'label'              => __('Border Style', 'royal-addons-for-elementor'),
                'type'               => Controls_Manager::SELECT,
                'default'            => 'dashed',
                'options'            => [
                    'dashed' => __('Dashed', 'royal-addons-for-elementor'),
                    'dotted' => __('Dotted', 'royal-addons-for-elementor'),
                    'solid'  => __('Solid', 'royal-addons-for-elementor'),
                ],
                'frontend_available' => true,
                'condition'          => [
                    'royal_ambient_style' => ['corner_rings', 'combined'],
                    'royal_ambient_corner_preset' => ['all_4', 'opposite_tl_br', 'bottom_both', 'custom'],
                ],
            ]
        );

        $element->add_control(
            'royal_ambient_br_border_width',
            [
                'label'              => __('Border Width', 'royal-addons-for-elementor'),
                'type'               => Controls_Manager::SLIDER,
                'default'            => ['size' => 2],
                'range'              => ['px' => ['min' => 1, 'max' => 10]],
                'frontend_available' => true,
                'condition'          => [
                    'royal_ambient_style' => ['corner_rings', 'combined'],
                    'royal_ambient_corner_preset' => ['all_4', 'opposite_tl_br', 'bottom_both', 'custom'],
                ],
            ]
        );

        $element->add_responsive_control(
            'royal_ambient_br_bottom',
            [
                'label'              => __('Offset Bottom', 'royal-addons-for-elementor'),
                'type'               => Controls_Manager::SLIDER,
                'default'            => ['size' => -120],
                'range'              => ['px' => ['min' => -500, 'max' => 500]],
                'frontend_available' => true,
                'condition'          => [
                    'royal_ambient_style' => ['corner_rings', 'combined'],
                    'royal_ambient_corner_preset' => ['all_4', 'opposite_tl_br', 'bottom_both', 'custom'],
                ],
            ]
        );

        $element->add_responsive_control(
            'royal_ambient_br_right',
            [
                'label'              => __('Offset Right', 'royal-addons-for-elementor'),
                'type'               => Controls_Manager::SLIDER,
                'default'            => ['size' => -90],
                'range'              => ['px' => ['min' => -500, 'max' => 500]],
                'frontend_available' => true,
                'condition'          => [
                    'royal_ambient_style' => ['corner_rings', 'combined'],
                    'royal_ambient_corner_preset' => ['all_4', 'opposite_tl_br', 'bottom_both', 'custom'],
                ],
            ]
        );

        $element->add_control(
            'royal_ambient_br_speed',
            [
                'label'              => __('Rotation Speed (seconds)', 'royal-addons-for-elementor'),
                'type'               => Controls_Manager::NUMBER,
                'default'            => 32,
                'min'                => 1,
                'max'                => 180,
                'frontend_available' => true,
                'condition'          => [
                    'royal_ambient_style' => ['corner_rings', 'combined'],
                    'royal_ambient_corner_preset' => ['all_4', 'opposite_tl_br', 'bottom_both', 'custom'],
                ],
            ]
        );

        $element->add_control(
            'royal_ambient_br_direction',
            [
                'label'              => __('Direction', 'royal-addons-for-elementor'),
                'type'               => Controls_Manager::SELECT,
                'default'            => 'normal',
                'options'            => [
                    'normal'  => __('Clockwise', 'royal-addons-for-elementor'),
                    'reverse' => __('Counter-Clockwise', 'royal-addons-for-elementor'),
                ],
                'frontend_available' => true,
                'condition'          => [
                    'royal_ambient_style' => ['corner_rings', 'combined'],
                    'royal_ambient_corner_preset' => ['all_4', 'opposite_tl_br', 'bottom_both', 'custom'],
                ],
            ]
        );

        $element->add_control(
            'royal_ambient_br_anim',
            [
                'label'              => __('Animation Mode', 'royal-addons-for-elementor'),
                'type'               => Controls_Manager::SELECT,
                'default'            => 'spin',
                'options'            => [
                    'spin'  => __('Continuous Rotation (360°)', 'royal-addons-for-elementor'),
                    'pulse' => __('Rotation + Breathing Pulse', 'royal-addons-for-elementor'),
                ],
                'frontend_available' => true,
                'condition'          => [
                    'royal_ambient_style' => ['corner_rings', 'combined'],
                    'royal_ambient_corner_preset' => ['all_4', 'opposite_tl_br', 'bottom_both', 'custom'],
                ],
            ]
        );

        // ── Drifting Blobs Controls ───────────────────────────────────
        $element->add_control(
            'royal_ambient_b1_heading',
            [
                'label'     => __('Ambient Drifting Blob 1', 'royal-addons-for-elementor'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => ['royal_ambient_style' => ['soft_spheres', 'hero_blobs', 'combined']],
            ]
        );

        $element->add_control(
            'royal_ambient_b1_color',
            [
                'label'              => __('Blob 1 Color', 'royal-addons-for-elementor'),
                'type'               => Controls_Manager::COLOR,
                'default'            => 'rgba(25, 135, 84, 0.08)',
                'frontend_available' => true,
                'condition'          => ['royal_ambient_style' => ['soft_spheres', 'hero_blobs', 'combined']],
            ]
        );

        $element->add_responsive_control(
            'royal_ambient_b1_size',
            [
                'label'              => __('Blob 1 Size', 'royal-addons-for-elementor'),
                'type'               => Controls_Manager::SLIDER,
                'default'            => ['size' => 420],
                'range'              => ['px' => ['min' => 100, 'max' => 1000, 'step' => 10]],
                'frontend_available' => true,
                'condition'          => ['royal_ambient_style' => ['soft_spheres', 'hero_blobs', 'combined']],
            ]
        );

        $element->add_control(
            'royal_ambient_b1_blur',
            [
                'label'              => __('Blob 1 Blur (px)', 'royal-addons-for-elementor'),
                'type'               => Controls_Manager::SLIDER,
                'default'            => ['size' => 60],
                'range'              => ['px' => ['min' => 0, 'max' => 150]],
                'frontend_available' => true,
                'condition'          => ['royal_ambient_style' => ['soft_spheres', 'hero_blobs', 'combined']],
            ]
        );

        $element->add_control(
            'royal_ambient_b1_opacity',
            [
                'label'              => __('Blob 1 Opacity', 'royal-addons-for-elementor'),
                'type'               => Controls_Manager::SLIDER,
                'default'            => ['size' => 0.35],
                'range'              => ['px' => ['min' => 0.05, 'max' => 1, 'step' => 0.05]],
                'frontend_available' => true,
                'condition'          => ['royal_ambient_style' => ['soft_spheres', 'hero_blobs', 'combined']],
            ]
        );

        $element->add_responsive_control(
            'royal_ambient_b1_top',
            [
                'label'              => __('Blob 1 Top Offset', 'royal-addons-for-elementor'),
                'type'               => Controls_Manager::SLIDER,
                'default'            => ['size' => -140],
                'range'              => ['px' => ['min' => -500, 'max' => 500]],
                'frontend_available' => true,
                'condition'          => ['royal_ambient_style' => ['soft_spheres', 'hero_blobs', 'combined']],
            ]
        );

        $element->add_responsive_control(
            'royal_ambient_b1_left',
            [
                'label'              => __('Blob 1 Left Offset', 'royal-addons-for-elementor'),
                'type'               => Controls_Manager::SLIDER,
                'default'            => ['size' => -120],
                'range'              => ['px' => ['min' => -500, 'max' => 500]],
                'frontend_available' => true,
                'condition'          => ['royal_ambient_style' => ['soft_spheres', 'hero_blobs', 'combined']],
            ]
        );

        $element->add_control(
            'royal_ambient_b1_speed',
            [
                'label'              => __('Blob 1 Drift Speed (seconds)', 'royal-addons-for-elementor'),
                'type'               => Controls_Manager::NUMBER,
                'default'            => 18,
                'min'                => 3,
                'max'                => 100,
                'frontend_available' => true,
                'condition'          => ['royal_ambient_style' => ['soft_spheres', 'hero_blobs', 'combined']],
            ]
        );

        $element->add_control(
            'royal_ambient_b2_heading',
            [
                'label'     => __('Ambient Drifting Blob 2', 'royal-addons-for-elementor'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => ['royal_ambient_style' => ['soft_spheres', 'hero_blobs', 'combined']],
            ]
        );

        $element->add_control(
            'royal_ambient_b2_color',
            [
                'label'              => __('Blob 2 Color', 'royal-addons-for-elementor'),
                'type'               => Controls_Manager::COLOR,
                'default'            => 'rgba(25, 135, 84, 0.08)',
                'frontend_available' => true,
                'condition'          => ['royal_ambient_style' => ['soft_spheres', 'hero_blobs', 'combined']],
            ]
        );

        $element->add_responsive_control(
            'royal_ambient_b2_size',
            [
                'label'              => __('Blob 2 Size', 'royal-addons-for-elementor'),
                'type'               => Controls_Manager::SLIDER,
                'default'            => ['size' => 320],
                'range'              => ['px' => ['min' => 100, 'max' => 1000, 'step' => 10]],
                'frontend_available' => true,
                'condition'          => ['royal_ambient_style' => ['soft_spheres', 'hero_blobs', 'combined']],
            ]
        );

        $element->add_control(
            'royal_ambient_b2_blur',
            [
                'label'              => __('Blob 2 Blur (px)', 'royal-addons-for-elementor'),
                'type'               => Controls_Manager::SLIDER,
                'default'            => ['size' => 60],
                'range'              => ['px' => ['min' => 0, 'max' => 150]],
                'frontend_available' => true,
                'condition'          => ['royal_ambient_style' => ['soft_spheres', 'hero_blobs', 'combined']],
            ]
        );

        $element->add_control(
            'royal_ambient_b2_opacity',
            [
                'label'              => __('Blob 2 Opacity', 'royal-addons-for-elementor'),
                'type'               => Controls_Manager::SLIDER,
                'default'            => ['size' => 0.3],
                'range'              => ['px' => ['min' => 0.05, 'max' => 1, 'step' => 0.05]],
                'frontend_available' => true,
                'condition'          => ['royal_ambient_style' => ['soft_spheres', 'hero_blobs', 'combined']],
            ]
        );

        $element->add_responsive_control(
            'royal_ambient_b2_bottom',
            [
                'label'              => __('Blob 2 Bottom Offset', 'royal-addons-for-elementor'),
                'type'               => Controls_Manager::SLIDER,
                'default'            => ['size' => -90],
                'range'              => ['px' => ['min' => -500, 'max' => 500]],
                'frontend_available' => true,
                'condition'          => ['royal_ambient_style' => ['soft_spheres', 'hero_blobs', 'combined']],
            ]
        );

        $element->add_responsive_control(
            'royal_ambient_b2_right',
            [
                'label'              => __('Blob 2 Right Offset', 'royal-addons-for-elementor'),
                'type'               => Controls_Manager::SLIDER,
                'default'            => ['size' => -80],
                'range'              => ['px' => ['min' => -500, 'max' => 500]],
                'frontend_available' => true,
                'condition'          => ['royal_ambient_style' => ['soft_spheres', 'hero_blobs', 'combined']],
            ]
        );

        $element->add_control(
            'royal_ambient_b2_speed',
            [
                'label'              => __('Blob 2 Drift Speed (seconds)', 'royal-addons-for-elementor'),
                'type'               => Controls_Manager::NUMBER,
                'default'            => 20,
                'min'                => 3,
                'max'                => 100,
                'frontend_available' => true,
                'condition'          => ['royal_ambient_style' => ['soft_spheres', 'hero_blobs', 'combined']],
            ]
        );

        $element->add_control(
            'royal_ambient_drift_distance',
            [
                'label'              => __('Drift Motion Distance', 'royal-addons-for-elementor'),
                'type'               => Controls_Manager::SLIDER,
                'default'            => ['size' => 60],
                'range'              => ['px' => ['min' => 10, 'max' => 200]],
                'frontend_available' => true,
                'condition'          => ['royal_ambient_style' => ['soft_spheres', 'hero_blobs', 'combined']],
            ]
        );

        // ── Dot Grid Matrix Controls ──────────────────────────────────
        $element->add_control(
            'royal_ambient_dot_heading',
            [
                'label'     => __('Vignette Dot Grid Matrix', 'royal-addons-for-elementor'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => ['royal_ambient_style' => ['dot_grid', 'combined']],
            ]
        );

        $element->add_control(
            'royal_ambient_dot_color',
            [
                'label'              => __('Dot Color', 'royal-addons-for-elementor'),
                'type'               => Controls_Manager::COLOR,
                'default'            => 'rgba(11, 77, 38, 0.12)',
                'frontend_available' => true,
                'condition'          => ['royal_ambient_style' => ['dot_grid', 'combined']],
            ]
        );

        $element->add_control(
            'royal_ambient_dot_size',
            [
                'label'              => __('Dot Size (px)', 'royal-addons-for-elementor'),
                'type'               => Controls_Manager::SLIDER,
                'default'            => ['size' => 1.5],
                'range'              => ['px' => ['min' => 1, 'max' => 10, 'step' => 0.5]],
                'frontend_available' => true,
                'condition'          => ['royal_ambient_style' => ['dot_grid', 'combined']],
            ]
        );

        $element->add_control(
            'royal_ambient_dot_gap',
            [
                'label'              => __('Grid Spacing / Gap (px)', 'royal-addons-for-elementor'),
                'type'               => Controls_Manager::SLIDER,
                'default'            => ['size' => 26],
                'range'              => ['px' => ['min' => 10, 'max' => 80]],
                'frontend_available' => true,
                'condition'          => ['royal_ambient_style' => ['dot_grid', 'combined']],
            ]
        );

        $element->add_control(
            'royal_ambient_dot_vignette',
            [
                'label'              => __('Vignette Edge Mask', 'royal-addons-for-elementor'),
                'description'        => __('Smoothly fades out dots toward the container edges', 'royal-addons-for-elementor'),
                'type'               => Controls_Manager::SWITCHER,
                'default'            => 'yes',
                'frontend_available' => true,
                'condition'          => ['royal_ambient_style' => ['dot_grid', 'combined']],
            ]
        );

        $element->add_control(
            'royal_ambient_dot_opacity',
            [
                'label'              => __('Dots Opacity', 'royal-addons-for-elementor'),
                'type'               => Controls_Manager::SLIDER,
                'default'            => ['size' => 1],
                'range'              => ['px' => ['min' => 0.05, 'max' => 1, 'step' => 0.05]],
                'frontend_available' => true,
                'condition'          => ['royal_ambient_style' => ['dot_grid', 'combined']],
            ]
        );

        $element->add_control(
            'royal_ambient_dot_anim',
            [
                'label'              => __('Animated Shifting Drift', 'royal-addons-for-elementor'),
                'description'        => __('Subtly animates the dot pattern in a continuous drifting motion', 'royal-addons-for-elementor'),
                'type'               => Controls_Manager::SWITCHER,
                'default'            => 'yes',
                'frontend_available' => true,
                'condition'          => ['royal_ambient_style' => ['dot_grid', 'combined']],
            ]
        );

        // ── Rising Bubbles Controls ───────────────────────────────────
        $element->add_control(
            'royal_ambient_bubble_heading',
            [
                'label'     => __('Floating Rising Bubbles', 'royal-addons-for-elementor'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => ['royal_ambient_style' => ['rising_bubbles', 'combined']],
            ]
        );

        $element->add_control(
            'royal_ambient_bubble_color1',
            [
                'label'              => __('Bubble 1 Color', 'royal-addons-for-elementor'),
                'type'               => Controls_Manager::COLOR,
                'default'            => 'rgba(31, 163, 90, 0.18)',
                'frontend_available' => true,
                'condition'          => ['royal_ambient_style' => ['rising_bubbles', 'combined']],
            ]
        );

        $element->add_control(
            'royal_ambient_bubble_color2',
            [
                'label'              => __('Bubble 2 Color', 'royal-addons-for-elementor'),
                'type'               => Controls_Manager::COLOR,
                'default'            => 'rgba(255, 193, 7, 0.35)',
                'frontend_available' => true,
                'condition'          => ['royal_ambient_style' => ['rising_bubbles', 'combined']],
            ]
        );

        $element->add_control(
            'royal_ambient_bubble_color3',
            [
                'label'              => __('Bubble 3 Color', 'royal-addons-for-elementor'),
                'type'               => Controls_Manager::COLOR,
                'default'            => 'rgba(13, 110, 253, 0.15)',
                'frontend_available' => true,
                'condition'          => ['royal_ambient_style' => ['rising_bubbles', 'combined']],
            ]
        );

        $element->add_control(
            'royal_ambient_bubble_speed',
            [
                'label'              => __('Floating Speed (seconds)', 'royal-addons-for-elementor'),
                'type'               => Controls_Manager::SLIDER,
                'default'            => ['size' => 10],
                'range'              => ['px' => ['min' => 3, 'max' => 30]],
                'frontend_available' => true,
                'condition'          => ['royal_ambient_style' => ['rising_bubbles', 'combined']],
            ]
        );

        $element->add_control(
            'royal_ambient_bubble_dist',
            [
                'label'              => __('Rise Distance (px)', 'royal-addons-for-elementor'),
                'type'               => Controls_Manager::SLIDER,
                'default'            => ['size' => 26],
                'range'              => ['px' => ['min' => 10, 'max' => 100]],
                'frontend_available' => true,
                'condition'          => ['royal_ambient_style' => ['rising_bubbles', 'combined']],
            ]
        );

        // ── Common Ambient Settings ───────────────────────────────────
        $element->add_control(
            'royal_ambient_common_heading',
            [
                'label'     => __('Common Settings', 'royal-addons-for-elementor'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $element->add_control(
            'royal_ambient_zindex',
            [
                'label'              => __('Z-Index', 'royal-addons-for-elementor'),
                'type'               => Controls_Manager::NUMBER,
                'default'            => 0,
                'frontend_available' => true,
            ]
        );

        $element->add_control(
            'royal_ambient_disable_mobile',
            [
                'label'              => __('Disable on Mobile', 'royal-addons-for-elementor'),
                'type'               => Controls_Manager::SWITCHER,
                'default'            => 'no',
                'frontend_available' => true,
            ]
        );

        $element->end_controls_section();

        do_action("royal_background_controls_registered_{$element->get_id()}");
    }

    public static function before_render( $element ) {
        if ( ! ( $element instanceof \Elementor\Element_Base ) ) return;

        // Container-level backgrounds should only attach to Sections, Containers, Columns, and Atomic Div Blocks
        if ( $element instanceof \Elementor\Widget_Base ) {
            return;
        }

        // Detect Atomic Div Block elements
        $el_name = $element->get_name();
        $is_atomic = in_array($el_name, ['div-block', 'e-div-block', 'e-flexbox', 'atomic-widget-base']) || (strpos($el_name, 'atomic-') === 0);

        // Atomic elements need get_atomic_settings(); standard elements use get_settings_for_display()
        if ( $is_atomic && method_exists($element, 'get_atomic_settings') ) {
            try {
                $settings = $element->get_atomic_settings();
            } catch ( \Throwable $e ) {
                $settings = $element->get_settings_for_display();
            }
        } else {
            $settings = $element->get_settings_for_display();
        }
        $is_enabled = false;

        // Circle Data
        if (!empty($settings['royal_enable_circle']) && ('yes' === $settings['royal_enable_circle'] || true === $settings['royal_enable_circle'])) {
            if (!empty($settings['royal_circles_repeater'])) {
                $circle_data = $settings['royal_circles_repeater'];
            } else {
                // Build from Atomic sub-settings (up to 3 circles)
                $acSz = function($key, $default) use ($settings) {
                    $v = $settings[$key] ?? $default;
                    if (is_array($v) && isset($v['size'])) return $v;
                    if (is_numeric($v)) return ['size' => $v, 'unit' => 'px'];
                    return $default;
                };
                // Circle 1 (always included)
                $circle_data = [[
                    'circle_title'              => 'Circle 1',
                    'circle_type'               => 'simple',
                    'main_circle_size'          => $acSz('royal_ac_size', ['size' => 250, 'unit' => 'px']),
                    'main_circle_color'         => $settings['royal_ac_color'] ?? '#87CEEB',
                    'main_circle_border_width'  => $acSz('royal_ac_border_width', ['size' => 2, 'unit' => 'px']),
                    'main_circle_border_style'  => $settings['royal_ac_border_style'] ?? 'dotted',
                    'animation'                 => $settings['royal_ac_animation'] ?? 'clockwise',
                    'animation_speed'           => $settings['royal_ac_speed'] ?? 20,
                    'graphic_horizontal_offset' => $acSz('royal_ac_h_offset', ['size' => 50, 'unit' => '%']),
                    'graphic_vertical_offset'   => $acSz('royal_ac_v_offset', ['size' => 50, 'unit' => '%']),
                    'graphic_z_index'           => $settings['royal_ac_zindex'] ?? 0,
                    'dot1_enable'               => 'yes',
                    'dot1_size'                 => ['size' => 15, 'unit' => 'px'],
                    'dot1_color'                => '#FFFFFF',
                    'dot1_animation'            => 'clockwise',
                    'dot1_speed'                => 10,
                    'dot2_enable'               => 'yes',
                    'dot2_size'                 => ['size' => 10, 'unit' => 'px'],
                    'dot2_color'                => '#87CEEB',
                    'dot2_animation'            => 'counter-clockwise',
                    'dot2_speed'                => 15,
                ]];
                // Circle 2
                if (!empty($settings['royal_ac2_enable']) && (true === $settings['royal_ac2_enable'] || 'yes' === $settings['royal_ac2_enable'])) {
                    $circle_data[] = [
                        'circle_title' => 'Circle 2', 'circle_type' => 'simple',
                        'main_circle_size'          => $acSz('royal_ac2_size', ['size' => 180, 'unit' => 'px']),
                        'main_circle_color'         => $settings['royal_ac2_color'] ?? '#FFD700',
                        'main_circle_border_width'  => ['size' => 2, 'unit' => 'px'],
                        'main_circle_border_style'  => $settings['royal_ac2_border_style'] ?? 'dashed',
                        'animation'                 => $settings['royal_ac2_animation'] ?? 'counter-clockwise',
                        'animation_speed'           => $settings['royal_ac2_speed'] ?? 15,
                        'graphic_horizontal_offset' => $acSz('royal_ac2_h_offset', ['size' => 30, 'unit' => '%']),
                        'graphic_vertical_offset'   => $acSz('royal_ac2_v_offset', ['size' => 30, 'unit' => '%']),
                        'graphic_z_index'           => 0,
                        'dot1_enable' => 'no', 'dot2_enable' => 'no',
                    ];
                }
                // Circle 3
                if (!empty($settings['royal_ac3_enable']) && (true === $settings['royal_ac3_enable'] || 'yes' === $settings['royal_ac3_enable'])) {
                    $circle_data[] = [
                        'circle_title' => 'Circle 3', 'circle_type' => 'simple',
                        'main_circle_size'          => $acSz('royal_ac3_size', ['size' => 120, 'unit' => 'px']),
                        'main_circle_color'         => $settings['royal_ac3_color'] ?? '#FF6B6B',
                        'main_circle_border_width'  => ['size' => 2, 'unit' => 'px'],
                        'main_circle_border_style'  => $settings['royal_ac3_border_style'] ?? 'solid',
                        'animation'                 => $settings['royal_ac3_animation'] ?? 'clockwise',
                        'animation_speed'           => $settings['royal_ac3_speed'] ?? 25,
                        'graphic_horizontal_offset' => $acSz('royal_ac3_h_offset', ['size' => 70, 'unit' => '%']),
                        'graphic_vertical_offset'   => $acSz('royal_ac3_v_offset', ['size' => 70, 'unit' => '%']),
                        'graphic_z_index'           => 0,
                        'dot1_enable' => 'no', 'dot2_enable' => 'no',
                    ];
                }
            }
            $element->add_render_attribute('_wrapper', 'data-royal-circles', wp_json_encode($circle_data));
            self::enqueue_assets('circle');
            $is_enabled = true;
        }
        
        // Blob Data
        if (!empty($settings['royal_enable_blob']) && ('yes' === $settings['royal_enable_blob'] || true === $settings['royal_enable_blob'])) {
            if (!empty($settings['royal_blob_repeater'])) {
                $blob_data = $settings['royal_blob_repeater'];
            } else {
                // Build from Atomic sub-settings
                $abSz = function($key, $default) use ($settings) {
                    $v = $settings[$key] ?? $default;
                    if (is_array($v) && isset($v['size'])) return $v;
                    if (is_numeric($v)) return ['size' => $v, 'unit' => 'px'];
                    return $default;
                };
                $blob_data = [[
                    'blob_title'                    => 'Blob 1',
                    'royal_blob_color'              => $settings['royal_ab_color'] ?? '#D1BCF5',
                    'royal_blob_complexity'          => $abSz('royal_ab_complexity', ['size' => 8]),
                    'royal_blob_contrast'            => $abSz('royal_ab_contrast', ['size' => 0.4]),
                    'royal_blob_smoothness'          => $abSz('royal_ab_smoothness', ['size' => 1]),
                    'royal_blob_size'                => $abSz('royal_ab_size', ['size' => 300, 'unit' => 'px']),
                    'royal_blob_horizontal_offset'   => $abSz('royal_ab_h_offset', ['size' => 40, 'unit' => '%']),
                    'royal_blob_vertical_offset'     => $abSz('royal_ab_v_offset', ['size' => 40, 'unit' => '%']),
                    'royal_blob_zindex'              => $settings['royal_ab_zindex'] ?? 0,
                    'royal_blob_opacity'             => $abSz('royal_ab_opacity', ['size' => 1]),
                    'royal_blob_animation_duration'  => $settings['royal_ab_anim_dur'] ?? 5,
                ]];
            }
            $element->add_render_attribute('_wrapper', 'data-royal-blobs', wp_json_encode($blob_data));
            self::enqueue_assets('blob');
            $is_enabled = true;
        }

        // Particles Data
        if (!empty($settings['royal_enable_particles']) && ('yes' === $settings['royal_enable_particles'] || true === $settings['royal_enable_particles'])) {
            if (!empty($settings['royal_particles_custom_style'])) {
                $particles_style = json_decode($settings['royal_particles_custom_style'], true);
                if (json_last_error() === JSON_ERROR_NONE) {
                    $config = [
                        'zindex' => $settings['royal_particles_zindex'] ?? 0,
                        'scope'  => $settings['royal_particles_scope'] ?? 'contained',
                        'style'  => $particles_style
                    ];
                    $element->add_render_attribute('_wrapper', 'data-royal-particles-config', wp_json_encode($config));
                    self::enqueue_assets('particles');
                    $is_enabled = true;
                }
            }
        }

        // Canvas Animation Data
        if (!empty($settings['royal_enable_canvas']) && ('yes' === $settings['royal_enable_canvas'] || true === $settings['royal_enable_canvas'])) {
            // Helper: extract 'size' from slider array or plain number
            $sz = function($key, $default) use ($settings) {
                $v = $settings[$key] ?? $default;
                if (is_array($v) && isset($v['size'])) return $v['size'];
                if (is_numeric($v)) return $v;
                return $default;
            };
            $disableMobile = $settings['royal_canvas_disable_mobile'] ?? 'yes';
            if ($disableMobile === true) $disableMobile = 'yes';
            if ($disableMobile === false) $disableMobile = '';

            $canvas_config = [
                'type'          => $settings['royal_canvas_type']          ?? 'waves',
                'bgColor'       => $settings['royal_canvas_bg_color']      ?? '',
                'opacity'       => $sz('royal_canvas_opacity', 1),
                'zIndex'        => $settings['royal_canvas_zindex']         ?? 0,
                'disableMobile' => $disableMobile,
                // Gradient
                'gradColor1'    => $settings['royal_canvas_grad_color1']   ?? '#6366f1',
                'gradColor2'    => $settings['royal_canvas_grad_color2']   ?? '#ec4899',
                'gradColor3'    => $settings['royal_canvas_grad_color3']   ?? '#06b6d4',
                'gradSpeed'     => $sz('royal_canvas_grad_speed', 8),
                // Waves
                'wavesColor'    => $settings['royal_canvas_waves_color']   ?? '#6366f1',
                'wavesColor2'   => $settings['royal_canvas_waves_color2']  ?? '#818cf8',
                'wavesCount'    => $sz('royal_canvas_waves_count', 3),
                'wavesSpeed'    => $sz('royal_canvas_waves_speed', 5),
                'wavesHeight'   => $sz('royal_canvas_waves_height', 40),
                // Snow
                'snowColor'     => $settings['royal_canvas_snow_color']    ?? '#ffffff',
                'snowCount'     => $sz('royal_canvas_snow_count', 80),
                'snowSpeed'     => $sz('royal_canvas_snow_speed', 2),
                'snowSize'      => $sz('royal_canvas_snow_size', 4),
                'snowWind'      => $sz('royal_canvas_snow_wind', 0.5),
                // Drops
                'dropsColor'    => $settings['royal_canvas_drops_color']   ?? '#6366f1',
                'dropsSpeed'    => $sz('royal_canvas_drops_speed', 5),
                'dropsMax'      => $sz('royal_canvas_drops_max', 15),
                // Rings
                'ringsColor'    => $settings['royal_canvas_rings_color']   ?? '#6366f1',
                'ringsCount'    => $sz('royal_canvas_rings_count', 5),
                'ringsSpeed'    => $sz('royal_canvas_rings_speed', 3),
                // Fancy Rotate
                'rotateColor'   => $settings['royal_canvas_rotate_color']  ?? '#6366f1',
                'rotateColor2'  => $settings['royal_canvas_rotate_color2'] ?? '#ec4899',
                'rotateCount'   => $sz('royal_canvas_rotate_count', 8),
                'rotateSpeed'   => $sz('royal_canvas_rotate_speed', 3),
            ];
            $element->add_render_attribute('_wrapper', 'data-royal-canvas', wp_json_encode($canvas_config));
            self::enqueue_assets('canvas');
            $is_enabled = true;
        }

        // Ambient & Deco Background Data
        if (!empty($settings['royal_enable_ambient']) && ('yes' === $settings['royal_enable_ambient'] || true === $settings['royal_enable_ambient'])) {
            $sz = function($key, $default) use ($settings) {
                $v = $settings[$key] ?? $default;
                if (is_array($v) && isset($v['size'])) return $v['size'];
                if (is_numeric($v)) return $v;
                return $default;
            };

            $style = $settings['royal_ambient_style'] ?? 'corner_rings';
            $disableMobile = $settings['royal_ambient_disable_mobile'] ?? '';
            $isDisMobile = ($disableMobile === true || $disableMobile === 'yes');

            $ambient_config = [
                'style'          => $style,
                'zIndex'         => $settings['royal_ambient_zindex'] ?? 0,
                'disableMobile'  => $isDisMobile,

// Corner Rings (Stats Card & All 4 Corners)
                'corner_preset'  => $settings['royal_ambient_corner_preset'] ?? 'opposite_tr_bl',

                // Top-Left (TL)
                'tl_enable'      => $settings['royal_ambient_tl_enable'] ?? 'yes',
                'tl_size'        => $sz('royal_ambient_tl_size', 280),
                'tl_color'       => $settings['royal_ambient_tl_color'] ?? 'rgba(255, 255, 255, 0.16)',
                'tl_border_style'=> $settings['royal_ambient_tl_border_style'] ?? 'dashed',
                'tl_border_width'=> $sz('royal_ambient_tl_border_width', 2),
                'tl_top'         => $sz('royal_ambient_tl_top', -120),
                'tl_left'        => $sz('royal_ambient_tl_left', -80),
                'tl_speed'       => $settings['royal_ambient_tl_speed'] ?? 35,
                'tl_direction'   => $settings['royal_ambient_tl_direction'] ?? 'reverse',
                'tl_anim'        => $settings['royal_ambient_tl_anim'] ?? 'spin',

                // Top-Right (TR / R1)
                'r1_enable'      => $settings['royal_ambient_r1_enable'] ?? 'yes',
                'r1_size'        => $sz('royal_ambient_r1_size', 320),
                'r1_color'       => $settings['royal_ambient_r1_color'] ?? 'rgba(255, 255, 255, 0.16)',
                'r1_border_style'=> $settings['royal_ambient_r1_border_style'] ?? 'dashed',
                'r1_border_width'=> $sz('royal_ambient_r1_border_width', 2),
                'r1_top'         => $sz('royal_ambient_r1_top', -140),
                'r1_right'       => $sz('royal_ambient_r1_right', -100),
                'r1_speed'       => $settings['royal_ambient_r1_speed'] ?? 40,
                'r1_direction'   => $settings['royal_ambient_r1_direction'] ?? 'normal',
                'r1_anim'        => $settings['royal_ambient_r1_anim'] ?? 'spin',
                'tr_enable'      => $settings['royal_ambient_r1_enable'] ?? 'yes',
                'tr_size'        => $sz('royal_ambient_r1_size', 320),
                'tr_color'       => $settings['royal_ambient_r1_color'] ?? 'rgba(255, 255, 255, 0.16)',
                'tr_border_style'=> $settings['royal_ambient_r1_border_style'] ?? 'dashed',
                'tr_border_width'=> $sz('royal_ambient_r1_border_width', 2),
                'tr_top'         => $sz('royal_ambient_r1_top', -140),
                'tr_right'       => $sz('royal_ambient_r1_right', -100),
                'tr_speed'       => $settings['royal_ambient_r1_speed'] ?? 40,
                'tr_direction'   => $settings['royal_ambient_r1_direction'] ?? 'normal',
                'tr_anim'        => $settings['royal_ambient_r1_anim'] ?? 'spin',

                // Bottom-Left (BL / R2)
                'r2_enable'      => $settings['royal_ambient_r2_enable'] ?? 'yes',
                'r2_size'        => $sz('royal_ambient_r2_size', 220),
                'r2_color'       => $settings['royal_ambient_r2_color'] ?? 'rgba(255, 255, 255, 0.16)',
                'r2_border_style'=> $settings['royal_ambient_r2_border_style'] ?? 'dashed',
                'r2_border_width'=> $sz('royal_ambient_r2_border_width', 2),
                'r2_bottom'      => $sz('royal_ambient_r2_bottom', -100),
                'r2_left'        => $sz('royal_ambient_r2_left', -70),
                'r2_speed'       => $settings['royal_ambient_r2_speed'] ?? 40,
                'r2_direction'   => $settings['royal_ambient_r2_direction'] ?? 'reverse',
                'r2_anim'        => $settings['royal_ambient_r2_anim'] ?? 'spin',
                'bl_enable'      => $settings['royal_ambient_r2_enable'] ?? 'yes',
                'bl_size'        => $sz('royal_ambient_r2_size', 220),
                'bl_color'       => $settings['royal_ambient_r2_color'] ?? 'rgba(255, 255, 255, 0.16)',
                'bl_border_style'=> $settings['royal_ambient_r2_border_style'] ?? 'dashed',
                'bl_border_width'=> $sz('royal_ambient_r2_border_width', 2),
                'bl_bottom'      => $sz('royal_ambient_r2_bottom', -100),
                'bl_left'        => $sz('royal_ambient_r2_left', -70),
                'bl_speed'       => $settings['royal_ambient_r2_speed'] ?? 40,
                'bl_direction'   => $settings['royal_ambient_r2_direction'] ?? 'reverse',
                'bl_anim'        => $settings['royal_ambient_r2_anim'] ?? 'spin',

                // Bottom-Right (BR)
                'br_enable'      => $settings['royal_ambient_br_enable'] ?? 'yes',
                'br_size'        => $sz('royal_ambient_br_size', 300),
                'br_color'       => $settings['royal_ambient_br_color'] ?? 'rgba(255, 255, 255, 0.16)',
                'br_border_style'=> $settings['royal_ambient_br_border_style'] ?? 'dashed',
                'br_border_width'=> $sz('royal_ambient_br_border_width', 2),
                'br_bottom'      => $sz('royal_ambient_br_bottom', -120),
                'br_right'       => $sz('royal_ambient_br_right', -90),
                'br_speed'       => $settings['royal_ambient_br_speed'] ?? 32,
                'br_direction'   => $settings['royal_ambient_br_direction'] ?? 'normal',
                'br_anim'        => $settings['royal_ambient_br_anim'] ?? 'spin',

                // Soft Drifting Blobs (Eight Pillars & Hero)
                'b1_color'       => $settings['royal_ambient_b1_color'] ?? (($style === 'hero_blobs') ? '#bfe3cb' : 'rgba(25, 135, 84, 0.08)'),
                'b1_size'        => $sz('royal_ambient_b1_size', ($style === 'hero_blobs') ? 340 : 420),
                'b1_blur'        => $sz('royal_ambient_b1_blur', ($style === 'hero_blobs') ? 70 : 60),
                'b1_opacity'     => $sz('royal_ambient_b1_opacity', ($style === 'hero_blobs') ? 0.4 : 0.35),
                'b1_top'         => $sz('royal_ambient_b1_top', ($style === 'hero_blobs') ? -90 : -140),
                'b1_left'        => $sz('royal_ambient_b1_left', ($style === 'hero_blobs') ? -70 : -120),
                'b1_speed'       => $settings['royal_ambient_b1_speed'] ?? (($style === 'hero_blobs') ? 14 : 18),

                'b2_color'       => $settings['royal_ambient_b2_color'] ?? (($style === 'hero_blobs') ? '#f3e2b3' : 'rgba(25, 135, 84, 0.08)'),
                'b2_size'        => $sz('royal_ambient_b2_size', ($style === 'hero_blobs') ? 300 : 320),
                'b2_blur'        => $sz('royal_ambient_b2_blur', ($style === 'hero_blobs') ? 70 : 60),
                'b2_opacity'     => $sz('royal_ambient_b2_opacity', ($style === 'hero_blobs') ? 0.4 : 0.3),
                'b2_bottom'      => $sz('royal_ambient_b2_bottom', ($style === 'hero_blobs') ? -80 : -90),
                'b2_right'       => $sz('royal_ambient_b2_right', ($style === 'hero_blobs') ? -40 : -80),
                'b2_speed'       => $settings['royal_ambient_b2_speed'] ?? (($style === 'hero_blobs') ? 17 : 20),
                'drift_distance' => $sz('royal_ambient_drift_distance', 60),

                // Dot Grid Matrix
                'dot_color'      => $settings['royal_ambient_dot_color'] ?? 'rgba(11, 77, 38, 0.12)',
                'dot_size'       => $sz('royal_ambient_dot_size', 1.5),
                'dot_gap'        => $sz('royal_ambient_dot_gap', 26),
                'dot_vignette'   => ($settings['royal_ambient_dot_vignette'] ?? 'yes') === 'yes',
                'dot_anim'       => ($settings['royal_ambient_dot_anim'] ?? 'yes') === 'yes',
                'dot_opacity'    => $sz('royal_ambient_dot_opacity', 1),

                // Rising Bubbles
                'bubble_c1'      => $settings['royal_ambient_bubble_color1'] ?? 'rgba(31, 163, 90, 0.18)',
                'bubble_c2'      => $settings['royal_ambient_bubble_color2'] ?? 'rgba(255, 193, 7, 0.35)',
                'bubble_c3'      => $settings['royal_ambient_bubble_color3'] ?? 'rgba(13, 110, 253, 0.15)',
                'bubble_speed'   => $sz('royal_ambient_bubble_speed', 10),
                'bubble_dist'    => $sz('royal_ambient_bubble_dist', 26),
            ];

            $element->add_render_attribute('_wrapper', 'data-royal-ambient', wp_json_encode($ambient_config));
            self::enqueue_assets('ambient');
            $is_enabled = true;
        }

        // Add a common class if any feature is enabled
        if ($is_enabled) {
            $element->add_render_attribute('_wrapper', 'class', 'royal-background-effects-wrapper');
        }
    }

    public static function print_template($template, $widget) {
        if (!in_array($widget->get_name(), ['section', 'container', 'column'])) { return $template; }
        $old_template = $template;
        ob_start();
        ?>
        <#
            var is_enabled = settings.royal_enable_circle || settings.royal_enable_blob || settings.royal_enable_particles || settings.royal_enable_canvas || settings.royal_enable_ambient;

            if ( is_enabled === 'yes' ) {
                view.addRenderAttribute('wrapper_editor', 'class', 'royal-background-preview-wrapper');

                // Add Circle Data if enabled
                if ( 'yes' === settings.royal_enable_circle && settings.royal_circles_repeater.length ) {
                    view.addRenderAttribute('wrapper_editor', 'data-royal-circles', JSON.stringify(settings.royal_circles_repeater));
                }

                // Add Blob Data if enabled
                if ( 'yes' === settings.royal_enable_blob && settings.royal_blob_repeater.length ) {
                    view.addRenderAttribute('wrapper_editor', 'data-royal-blobs', JSON.stringify(settings.royal_blob_repeater));
                }

                // Add Particles Data if enabled
                if ( 'yes' === settings.royal_enable_particles && settings.royal_particles_custom_style ) {
                    try {
                        const config = { 
                            zindex: settings.royal_particles_zindex || 0, 
                            scope:  settings.royal_particles_scope || 'contained', 
                            style:  JSON.parse(settings.royal_particles_custom_style) 
                        };
                        view.addRenderAttribute('wrapper_editor', 'data-royal-particles-config', JSON.stringify(config) );
                    } catch(e) {}
                }

                // Add Ambient Data if enabled
                if ( 'yes' === settings.royal_enable_ambient ) {
                    var ambConfig = {
                        style: settings.royal_ambient_style || 'corner_rings',
                        zIndex: settings.royal_ambient_zindex || 0,
                        disableMobile: settings.royal_ambient_disable_mobile === 'yes',
                        corner_preset: settings.royal_ambient_corner_preset || 'opposite_tr_bl',
                        // TL
                        tl_enable: settings.royal_ambient_tl_enable || 'yes',
                        tl_size: (settings.royal_ambient_tl_size && settings.royal_ambient_tl_size.size) ? settings.royal_ambient_tl_size.size : 280,
                        tl_color: settings.royal_ambient_tl_color || 'rgba(255, 255, 255, 0.16)',
                        tl_border_style: settings.royal_ambient_tl_border_style || 'dashed',
                        tl_border_width: (settings.royal_ambient_tl_border_width && settings.royal_ambient_tl_border_width.size) ? settings.royal_ambient_tl_border_width.size : 2,
                        tl_top: (settings.royal_ambient_tl_top && typeof settings.royal_ambient_tl_top.size !== 'undefined') ? settings.royal_ambient_tl_top.size : -120,
                        tl_left: (settings.royal_ambient_tl_left && typeof settings.royal_ambient_tl_left.size !== 'undefined') ? settings.royal_ambient_tl_left.size : -80,
                        tl_speed: settings.royal_ambient_tl_speed || 35,
                        tl_direction: settings.royal_ambient_tl_direction || 'reverse',
                        tl_anim: settings.royal_ambient_tl_anim || 'spin',

                        // TR / R1
                        r1_enable: settings.royal_ambient_r1_enable || 'yes',
                        r1_size: (settings.royal_ambient_r1_size && settings.royal_ambient_r1_size.size) ? settings.royal_ambient_r1_size.size : 320,
                        r1_color: settings.royal_ambient_r1_color || 'rgba(255, 255, 255, 0.16)',
                        r1_border_style: settings.royal_ambient_r1_border_style || 'dashed',
                        r1_border_width: (settings.royal_ambient_r1_border_width && settings.royal_ambient_r1_border_width.size) ? settings.royal_ambient_r1_border_width.size : 2,
                        r1_top: (settings.royal_ambient_r1_top && typeof settings.royal_ambient_r1_top.size !== 'undefined') ? settings.royal_ambient_r1_top.size : -140,
                        r1_right: (settings.royal_ambient_r1_right && typeof settings.royal_ambient_r1_right.size !== 'undefined') ? settings.royal_ambient_r1_right.size : -100,
                        r1_speed: settings.royal_ambient_r1_speed || 40,
                        r1_direction: settings.royal_ambient_r1_direction || 'normal',
                        r1_anim: settings.royal_ambient_r1_anim || 'spin',
                        tr_enable: settings.royal_ambient_r1_enable || 'yes',
                        tr_size: (settings.royal_ambient_r1_size && settings.royal_ambient_r1_size.size) ? settings.royal_ambient_r1_size.size : 320,
                        tr_color: settings.royal_ambient_r1_color || 'rgba(255, 255, 255, 0.16)',
                        tr_border_style: settings.royal_ambient_r1_border_style || 'dashed',
                        tr_border_width: (settings.royal_ambient_r1_border_width && settings.royal_ambient_r1_border_width.size) ? settings.royal_ambient_r1_border_width.size : 2,
                        tr_top: (settings.royal_ambient_r1_top && typeof settings.royal_ambient_r1_top.size !== 'undefined') ? settings.royal_ambient_r1_top.size : -140,
                        tr_right: (settings.royal_ambient_r1_right && typeof settings.royal_ambient_r1_right.size !== 'undefined') ? settings.royal_ambient_r1_right.size : -100,
                        tr_speed: settings.royal_ambient_r1_speed || 40,
                        tr_direction: settings.royal_ambient_r1_direction || 'normal',
                        tr_anim: settings.royal_ambient_r1_anim || 'spin',

                        // BL / R2
                        r2_enable: settings.royal_ambient_r2_enable || 'yes',
                        r2_size: (settings.royal_ambient_r2_size && settings.royal_ambient_r2_size.size) ? settings.royal_ambient_r2_size.size : 220,
                        r2_color: settings.royal_ambient_r2_color || 'rgba(255, 255, 255, 0.16)',
                        r2_border_style: settings.royal_ambient_r2_border_style || 'dashed',
                        r2_border_width: (settings.royal_ambient_r2_border_width && settings.royal_ambient_r2_border_width.size) ? settings.royal_ambient_r2_border_width.size : 2,
                        r2_bottom: (settings.royal_ambient_r2_bottom && typeof settings.royal_ambient_r2_bottom.size !== 'undefined') ? settings.royal_ambient_r2_bottom.size : -100,
                        r2_left: (settings.royal_ambient_r2_left && typeof settings.royal_ambient_r2_left.size !== 'undefined') ? settings.royal_ambient_r2_left.size : -70,
                        r2_speed: settings.royal_ambient_r2_speed || 40,
                        r2_direction: settings.royal_ambient_r2_direction || 'reverse',
                        r2_anim: settings.royal_ambient_r2_anim || 'spin',
                        bl_enable: settings.royal_ambient_r2_enable || 'yes',
                        bl_size: (settings.royal_ambient_r2_size && settings.royal_ambient_r2_size.size) ? settings.royal_ambient_r2_size.size : 220,
                        bl_color: settings.royal_ambient_r2_color || 'rgba(255, 255, 255, 0.16)',
                        bl_border_style: settings.royal_ambient_r2_border_style || 'dashed',
                        bl_border_width: (settings.royal_ambient_r2_border_width && settings.royal_ambient_r2_border_width.size) ? settings.royal_ambient_r2_border_width.size : 2,
                        bl_bottom: (settings.royal_ambient_r2_bottom && typeof settings.royal_ambient_r2_bottom.size !== 'undefined') ? settings.royal_ambient_r2_bottom.size : -100,
                        bl_left: (settings.royal_ambient_r2_left && typeof settings.royal_ambient_r2_left.size !== 'undefined') ? settings.royal_ambient_r2_left.size : -70,
                        bl_speed: settings.royal_ambient_r2_speed || 40,
                        bl_direction: settings.royal_ambient_r2_direction || 'reverse',
                        bl_anim: settings.royal_ambient_r2_anim || 'spin',

                        // BR
                        br_enable: settings.royal_ambient_br_enable || 'yes',
                        br_size: (settings.royal_ambient_br_size && settings.royal_ambient_br_size.size) ? settings.royal_ambient_br_size.size : 300,
                        br_color: settings.royal_ambient_br_color || 'rgba(255, 255, 255, 0.16)',
                        br_border_style: settings.royal_ambient_br_border_style || 'dashed',
                        br_border_width: (settings.royal_ambient_br_border_width && settings.royal_ambient_br_border_width.size) ? settings.royal_ambient_br_border_width.size : 2,
                        br_bottom: (settings.royal_ambient_br_bottom && typeof settings.royal_ambient_br_bottom.size !== 'undefined') ? settings.royal_ambient_br_bottom.size : -120,
                        br_right: (settings.royal_ambient_br_right && typeof settings.royal_ambient_br_right.size !== 'undefined') ? settings.royal_ambient_br_right.size : -90,
                        br_speed: settings.royal_ambient_br_speed || 32,
                        br_direction: settings.royal_ambient_br_direction || 'normal',
                        br_anim: settings.royal_ambient_br_anim || 'spin',
                        b1_color: settings.royal_ambient_b1_color || ((settings.royal_ambient_style === 'hero_blobs') ? '#bfe3cb' : 'rgba(25, 135, 84, 0.08)'),
                        b1_size: (settings.royal_ambient_b1_size && settings.royal_ambient_b1_size.size) ? settings.royal_ambient_b1_size.size : ((settings.royal_ambient_style === 'hero_blobs') ? 340 : 420),
                        b1_blur: (settings.royal_ambient_b1_blur && typeof settings.royal_ambient_b1_blur.size !== 'undefined') ? settings.royal_ambient_b1_blur.size : ((settings.royal_ambient_style === 'hero_blobs') ? 70 : 60),
                        b1_opacity: (settings.royal_ambient_b1_opacity && typeof settings.royal_ambient_b1_opacity.size !== 'undefined') ? settings.royal_ambient_b1_opacity.size : ((settings.royal_ambient_style === 'hero_blobs') ? 0.4 : 0.35),
                        b1_top: (settings.royal_ambient_b1_top && typeof settings.royal_ambient_b1_top.size !== 'undefined') ? settings.royal_ambient_b1_top.size : ((settings.royal_ambient_style === 'hero_blobs') ? -90 : -140),
                        b1_left: (settings.royal_ambient_b1_left && typeof settings.royal_ambient_b1_left.size !== 'undefined') ? settings.royal_ambient_b1_left.size : ((settings.royal_ambient_style === 'hero_blobs') ? -70 : -120),
                        b1_speed: settings.royal_ambient_b1_speed || ((settings.royal_ambient_style === 'hero_blobs') ? 14 : 18),
                        b2_color: settings.royal_ambient_b2_color || ((settings.royal_ambient_style === 'hero_blobs') ? '#f3e2b3' : 'rgba(25, 135, 84, 0.08)'),
                        b2_size: (settings.royal_ambient_b2_size && settings.royal_ambient_b2_size.size) ? settings.royal_ambient_b2_size.size : ((settings.royal_ambient_style === 'hero_blobs') ? 300 : 320),
                        b2_blur: (settings.royal_ambient_b2_blur && typeof settings.royal_ambient_b2_blur.size !== 'undefined') ? settings.royal_ambient_b2_blur.size : ((settings.royal_ambient_style === 'hero_blobs') ? 70 : 60),
                        b2_opacity: (settings.royal_ambient_b2_opacity && typeof settings.royal_ambient_b2_opacity.size !== 'undefined') ? settings.royal_ambient_b2_opacity.size : ((settings.royal_ambient_style === 'hero_blobs') ? 0.4 : 0.3),
                        b2_bottom: (settings.royal_ambient_b2_bottom && typeof settings.royal_ambient_b2_bottom.size !== 'undefined') ? settings.royal_ambient_b2_bottom.size : ((settings.royal_ambient_style === 'hero_blobs') ? -80 : -90),
                        b2_right: (settings.royal_ambient_b2_right && typeof settings.royal_ambient_b2_right.size !== 'undefined') ? settings.royal_ambient_b2_right.size : ((settings.royal_ambient_style === 'hero_blobs') ? -40 : -80),
                        b2_speed: settings.royal_ambient_b2_speed || ((settings.royal_ambient_style === 'hero_blobs') ? 17 : 20),
                        drift_distance: (settings.royal_ambient_drift_distance && settings.royal_ambient_drift_distance.size) ? settings.royal_ambient_drift_distance.size : 60,
                        dot_color: settings.royal_ambient_dot_color || 'rgba(11, 77, 38, 0.12)',
                        dot_size: (settings.royal_ambient_dot_size && settings.royal_ambient_dot_size.size) ? settings.royal_ambient_dot_size.size : 1.5,
                        dot_gap: (settings.royal_ambient_dot_gap && settings.royal_ambient_dot_gap.size) ? settings.royal_ambient_dot_gap.size : 26,
                        dot_vignette: settings.royal_ambient_dot_vignette !== 'no',
                        dot_anim: settings.royal_ambient_dot_anim !== 'no',
                        dot_opacity: (settings.royal_ambient_dot_opacity && typeof settings.royal_ambient_dot_opacity.size !== 'undefined') ? settings.royal_ambient_dot_opacity.size : 1,
                        bubble_c1: settings.royal_ambient_bubble_color1 || 'rgba(31, 163, 90, 0.18)',
                        bubble_c2: settings.royal_ambient_bubble_color2 || 'rgba(255, 193, 7, 0.35)',
                        bubble_c3: settings.royal_ambient_bubble_color3 || 'rgba(13, 110, 253, 0.15)',
                        bubble_speed: (settings.royal_ambient_bubble_speed && settings.royal_ambient_bubble_speed.size) ? settings.royal_ambient_bubble_speed.size : 10,
                        bubble_dist: (settings.royal_ambient_bubble_dist && settings.royal_ambient_bubble_dist.size) ? settings.royal_ambient_bubble_dist.size : 26
                    };
                    view.addRenderAttribute('wrapper_editor', 'data-royal-ambient', JSON.stringify(ambConfig));
                }
            #>
                <div {{{ view.getRenderAttributeString('wrapper_editor') }}}></div>
            <#
            }
        #>
        <?php
        return ob_get_clean() . $old_template;
    }
    
    public static function enqueue_assets($type) {
        if (isset(self::$assets_loaded[$type])) return;
        if (!defined('ROYAL_ADDONS_DIR_PATH') || !defined('ROYAL_ADDONS_ASSETS')) return;

        $version = defined('ROYAL_ADDONS_VERSION') ? ROYAL_ADDONS_VERSION : time();

        if ($type === 'circle') {
            $css_path = ROYAL_ADDONS_DIR_PATH . 'assets/css/extension-royalcircle.css';
            $js_path = ROYAL_ADDONS_DIR_PATH . 'assets/js/extension-royalcircle.js';
            if(file_exists($css_path)) wp_enqueue_style('royal-circle', ROYAL_ADDONS_ASSETS . 'css/extension-royalcircle.css', [], filemtime($css_path));
            if(file_exists($js_path)) wp_enqueue_script('royal-circle', ROYAL_ADDONS_ASSETS . 'js/extension-royalcircle.js', ['jquery'], filemtime($js_path), true);
        }

        if ($type === 'particles') {
            $css_path = ROYAL_ADDONS_DIR_PATH . 'assets/css/extension-royalparticles.css';
            $js_path = ROYAL_ADDONS_DIR_PATH . 'assets/js/extension-royalparticles.js';
            if(file_exists($css_path)) wp_enqueue_style('royal-particles', ROYAL_ADDONS_ASSETS . 'css/extension-royalparticles.css', [], filemtime($css_path));
            if(file_exists($js_path)) {
                wp_enqueue_script('tsparticles', ROYAL_ADDONS_ASSETS . 'vendor/tsparticles/tsparticles.bundle.min.js', [], '3.4.0', true);
                wp_enqueue_script('royal-particles', ROYAL_ADDONS_ASSETS . 'js/extension-royalparticles.js', ['jquery', 'tsparticles'], filemtime($js_path), true);
            }
        }

        if ($type === 'blob') {
            $css_path = ROYAL_ADDONS_DIR_PATH . 'assets/css/extension-royalblob.css';
            $js_path = ROYAL_ADDONS_DIR_PATH . 'assets/js/extension-royalblob.js';
            if(file_exists($css_path)) wp_enqueue_style('royal-blob', ROYAL_ADDONS_ASSETS . 'css/extension-royalblob.css', [], filemtime($css_path));
            if(file_exists($js_path)) {
                wp_enqueue_script('anime-js', ROYAL_ADDONS_ASSETS . 'vendor/anime/lib/anime.min.js', [], '3.2.1', true);
                wp_enqueue_script('royal-blob', ROYAL_ADDONS_ASSETS . 'js/extension-royalblob.js', ['jquery', 'anime-js'], filemtime($js_path), true);
            }
        }
        
        if ($type === 'canvas') {
            $css_path = ROYAL_ADDONS_DIR_PATH . 'assets/css/extension-royalcanvas.css';
            $js_path  = ROYAL_ADDONS_DIR_PATH . 'assets/js/extension-royalcanvas.js';
            if (file_exists($css_path)) wp_enqueue_style('royal-canvas', ROYAL_ADDONS_ASSETS . 'css/extension-royalcanvas.css', [], filemtime($css_path));
            if (file_exists($js_path))  wp_enqueue_script('royal-canvas', ROYAL_ADDONS_ASSETS . 'js/extension-royalcanvas.js', [], filemtime($js_path), true);
        }

        if ($type === 'ambient') {
            $css_path = ROYAL_ADDONS_DIR_PATH . 'assets/css/extension-royalambient.css';
            $js_path  = ROYAL_ADDONS_DIR_PATH . 'assets/js/extension-royalambient.js';
            if (file_exists($css_path)) wp_enqueue_style('royal-ambient', ROYAL_ADDONS_ASSETS . 'css/extension-royalambient.css', [], filemtime($css_path));
            if (file_exists($js_path))  wp_enqueue_script('royal-ambient', ROYAL_ADDONS_ASSETS . 'js/extension-royalambient.js', ['jquery'], filemtime($js_path), true);
        }

        self::$assets_loaded[$type] = true;
    }
}
Royal_Background::init();