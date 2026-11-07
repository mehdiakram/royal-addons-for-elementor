<?php
namespace RoyalAddons\Extensions\Inc;

use RoyalAddons\Extensions\Conditions\Royal_Condition_Base;
use Elementor\Element_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;

if ( ! defined( 'ABSPATH' ) ) exit;

final class Royal_Display_Conditions_Manager {

    private static $_instance = null;
    private $conditions = [];

    private function __construct() {
        $this->load_conditions();
        add_action( 'elementor/element/after_section_end', [ $this, 'register_controls' ], 30, 2 );

        // Add Atomic Hooks
        add_filter( 'elementor/atomic-widgets/props-schema', [ $this, 'add_atomic_props_schema' ], 10, 1 );
        add_filter( 'elementor/atomic-widgets/controls', [ $this, 'add_atomic_controls' ], 10, 2 );

        // This is now the ONLY hook that checks conditions.
        $elements = [ 'container', 'section', 'column', 'widget' ];
        foreach ( $elements as $element ) {
            add_filter( "elementor/frontend/{$element}/should_render", [ $this, 'should_render' ], 10, 2 );
        }
    }

    public function load_conditions() {
        foreach ( get_declared_classes() as $class ) {
            if ( is_subclass_of( $class, 'RoyalAddons\Extensions\Conditions\Royal_Condition_Base' ) ) {
                $instance = new $class();
                $this->conditions[ $instance->get_name() ] = $instance;
            }
        }
    }

    private function get_atomic_val( $settings, $key, $default = '' ) {
        if ( ! isset( $settings[ $key ] ) ) {
            return $default;
        }
        $val = $settings[ $key ];
        if ( is_array( $val ) ) {
            if ( isset( $val['value'] ) ) {
                return $val['value'];
            } elseif ( isset( $val['default'] ) ) {
                return $val['default'];
            } else {
                return reset( $val );
            }
        }
        return $val;
    }

    public function should_render( $should_render, $element ) {
        $settings = (array) $element->get_settings_for_display();

        if ( method_exists( $element, 'get_atomic_settings' ) ) {
            $atomic_settings = (array) $element->get_atomic_settings();
            if ( ! empty( $atomic_settings ) ) {
                $settings = array_merge( $settings, $atomic_settings );
            }
        }

        $enable = $this->get_atomic_val( $settings, '_royal_condition_enable' );
        if ( 'yes' !== $enable && true !== $enable && 'true' !== $enable ) {
            return $should_render;
        }

        $action = $this->get_atomic_val( $settings, '_royal_condition_action', 'show' );
        $relation = $this->get_atomic_val( $settings, '_royal_condition_relation', 'and' );
        $rules = $settings['_royal_condition_list'] ?? [];

        if ( empty( $rules ) || ! is_array( $rules ) ) {
            $rules = [];
            for ( $i = 1; $i <= 3; $i++ ) {
                $suffix = $i === 1 ? '' : $i;
                $key = $this->get_atomic_val( $settings, '_royal_condition_key' . $suffix );
                if ( $key ) {
                    $operator = $this->get_atomic_val( $settings, '_royal_condition_operator' . $suffix, 'is' );
                    $rule = [
                        '_royal_condition_key' => $key,
                        '_royal_condition_operator' => $operator,
                    ];
                    
                    foreach ( $this->conditions as $condition ) {
                        $controls = $condition->get_controls();
                        foreach ( $controls as $control_name => $control_args ) {
                            $rule[$control_name] = $this->get_atomic_val( $settings, $control_name . $suffix );
                        }
                    }

                    $rules[] = $rule;
                }
            }
            if ( empty( $rules ) ) {
                return $should_render;
            }
        }

        // All rules are now checked by PHP
        $conditions_met = $this->check_rules( $rules, $relation );

        if ( ( 'show' === $action && $conditions_met ) || ( 'hide' === $action && ! $conditions_met ) ) {
            return true; // Render the element
        }
        
        return false; // Do NOT render the element
    }

    private function check_rules( $rules, $relation ) {
        $results = [];
        foreach ( (array) $rules as $rule ) {
            $key = isset( $rule['_royal_condition_key'] ) ? $this->get_atomic_val( $rule, '_royal_condition_key' ) : null;
            if ( $key && isset( $this->conditions[ $key ] ) ) {
                $operator = isset( $rule['_royal_condition_operator'] ) ? $this->get_atomic_val( $rule, '_royal_condition_operator', 'is' ) : 'is';
                $results[] = $this->conditions[ $key ]->check( (array) $rule, $operator );
            }
        }
        if ( empty( $results ) ) return true;
        if ( 'or' === $relation ) return in_array( true, $results, true );
        return ! in_array( false, $results, true );
    }

    public function register_controls( $element, $section_id ) {
        if ( ! ( $element instanceof Element_Base ) ) return;

        if ( $element->get_controls( '_royal_condition_enable' ) ) {
            return;
        }

        $el_name = $element->get_name();
        $is_atomic = in_array($el_name, ['div-block', 'e-div-block', 'e-flexbox', 'atomic-widget-base']) || (strpos($el_name, 'atomic-') === 0);

        if ( $is_atomic || in_array( $section_id, [ 'section_custom_css', 'section_custom_css_pro', 'section_custom_attributes' ] ) ) {
            $target_tab = Controls_Manager::TAB_ADVANCED;

            $element->start_controls_section('royalcontrolsection_display_conditions', ['label' => __( 'Display Conditions (Royal)', 'royal-addons-for-elementor' ), 'tab' => $target_tab,]);
            $element->add_control('_royal_condition_enable', ['label' => __( 'Enable Conditions', 'royal-addons-for-elementor' ), 'type' => Controls_Manager::SWITCHER, 'return_value' => 'yes',]);
            $element->add_control('_royal_condition_action', ['label' => __( 'Action', 'royal-addons-for-elementor' ), 'type' => Controls_Manager::SELECT, 'default' => 'show', 'options' => ['show' => __( 'Show', 'royal-addons-for-elementor' ), 'hide' => __( 'Hide', 'royal-addons-for-elementor' ),], 'condition' => ['_royal_condition_enable' => 'yes'],]);
            $element->add_control('_royal_condition_relation', ['label' => __( 'When', 'royal-addons-for-elementor' ), 'type' => Controls_Manager::SELECT, 'default' => 'and', 'options' => ['and' => __( 'All conditions met', 'royal-addons-for-elementor' ), 'or' => __( 'Any condition met', 'royal-addons-for-elementor' ),], 'condition' => ['_royal_condition_enable' => 'yes'],]);
            
            $repeater = new Repeater();
            $repeater->add_control('_royal_condition_key', ['label' => __( 'Condition', 'royal-addons-for-elementor' ), 'type' => Controls_Manager::SELECT, 'options' => $this->get_condition_options(),]);
            $repeater->add_control('_royal_condition_operator', ['label' => __( 'Is', 'royal-addons-for-elementor' ), 'type' => Controls_Manager::SELECT, 'default' => 'is', 'options' => ['is' => __( 'Is', 'royal-addons-for-elementor' ), 'is_not' => __( 'Is Not', 'royal-addons-for-elementor' ),],]);

            foreach ( $this->conditions as $condition ) {
                $controls = $condition->get_controls();
                foreach ( $controls as $control_name => $control_args ) {
                    $repeater->add_control( $control_name, array_merge($control_args, ['condition' => ['_royal_condition_key' => $condition->get_name()]]) );
                }
            }
            $element->add_control('_royal_condition_list', ['label' => __( 'Rules', 'royal-addons-for-elementor' ), 'type' => Controls_Manager::REPEATER, 'fields' => $repeater->get_controls(), 'default' => [['_royal_condition_key' => 'login_status']], 'title_field' => '{{{ _royal_condition_key.replace(/_/g, " ").replace(/\\b\\w/g, l => l.toUpperCase()) }}}', 'condition' => ['_royal_condition_enable' => 'yes'], 'frontend_available' => true,]);
            $element->end_controls_section();
        }
    }

    public function add_atomic_props_schema( $schema ) {
        $schema['_royal_condition_enable'] = \Elementor\Modules\AtomicWidgets\PropTypes\Primitives\String_Prop_Type::make()->default('');
        $schema['_royal_condition_action'] = \Elementor\Modules\AtomicWidgets\PropTypes\Primitives\String_Prop_Type::make()->default('show');
        $schema['_royal_condition_relation'] = \Elementor\Modules\AtomicWidgets\PropTypes\Primitives\String_Prop_Type::make()->default('and');
        
        for ( $i = 1; $i <= 3; $i++ ) {
            $suffix = $i === 1 ? '' : $i;
            $schema['_royal_condition_key' . $suffix] = \Elementor\Modules\AtomicWidgets\PropTypes\Primitives\String_Prop_Type::make()->default('');
            $schema['_royal_condition_operator' . $suffix] = \Elementor\Modules\AtomicWidgets\PropTypes\Primitives\String_Prop_Type::make()->default('is');
            
            foreach ( $this->conditions as $condition ) {
                $controls = $condition->get_controls();
                foreach ( $controls as $control_name => $control_args ) {
                    $schema[$control_name . $suffix] = \Elementor\Modules\AtomicWidgets\PropTypes\Primitives\String_Prop_Type::make()->default('');
                }
            }
        }
        return $schema;
    }

    public function add_atomic_controls( $controls, $element ) {
        $options = [];
        foreach ( $this->conditions as $key => $condition ) {
            $options[] = [
                'value' => $key,
                'label' => $condition->get_title(),
            ];
        }

        $items = [
            \Elementor\Modules\AtomicWidgets\Controls\Types\Switch_Control::bind_to( '_royal_condition_enable' )
                ->set_label( __( 'Enable Conditions', 'royal-addons-for-elementor' ) ),
            \Elementor\Modules\AtomicWidgets\Controls\Types\Select_Control::bind_to( '_royal_condition_action' )
                ->set_label( __( 'Action', 'royal-addons-for-elementor' ) )
                ->set_options( [
                    [ 'value' => 'show', 'label' => __( 'Show', 'royal-addons-for-elementor' ) ],
                    [ 'value' => 'hide', 'label' => __( 'Hide', 'royal-addons-for-elementor' ) ],
                ] ),
            \Elementor\Modules\AtomicWidgets\Controls\Types\Select_Control::bind_to( '_royal_condition_relation' )
                ->set_label( __( 'When', 'royal-addons-for-elementor' ) )
                ->set_options( [
                    [ 'value' => 'and', 'label' => __( 'All conditions met', 'royal-addons-for-elementor' ) ],
                    [ 'value' => 'or', 'label' => __( 'Any condition met', 'royal-addons-for-elementor' ) ],
                ] ),
        ];

        for ( $i = 1; $i <= 3; $i++ ) {
            $suffix = $i === 1 ? '' : $i;
            $items[] = \Elementor\Modules\AtomicWidgets\Controls\Types\Select_Control::bind_to( '_royal_condition_key' . $suffix )
                ->set_label( sprintf( __( 'Condition %d', 'royal-addons-for-elementor' ), $i ) )
                ->set_options( $options );
            $items[] = \Elementor\Modules\AtomicWidgets\Controls\Types\Select_Control::bind_to( '_royal_condition_operator' . $suffix )
                ->set_label( sprintf( __( 'Is %d', 'royal-addons-for-elementor' ), $i ) )
                ->set_options( [
                    [ 'value' => 'is', 'label' => __( 'Is', 'royal-addons-for-elementor' ) ],
                    [ 'value' => 'is_not', 'label' => __( 'Is Not', 'royal-addons-for-elementor' ) ],
                ] );

            foreach ( $this->conditions as $condition ) {
                $controls_list = $condition->get_controls();
                foreach ( $controls_list as $control_name => $control_args ) {
                    $type = $control_args['type'] ?? '';
                    if ( 'select' === $type && ! empty( $control_args['options'] ) ) {
                        $opt_array = [];
                        foreach ( (array) $control_args['options'] as $v => $l ) {
                            $opt_array[] = [ 'value' => $v, 'label' => $l ];
                        }
                        $items[] = \Elementor\Modules\AtomicWidgets\Controls\Types\Select_Control::bind_to( $control_name . $suffix )
                            ->set_label( $control_args['label'] ?? $control_name )
                            ->set_options( $opt_array );
                    } else {
                        $items[] = \Elementor\Modules\AtomicWidgets\Controls\Types\Text_Control::bind_to( $control_name . $suffix )
                            ->set_label( $control_args['label'] ?? $control_name );
                    }
                }
            }
        }

        $controls[] = \Elementor\Modules\AtomicWidgets\Controls\Section::make()
            ->set_id( 'royalcontrolsection_display_conditions_atomic' )
            ->set_label( __( 'Display Conditions [Royal]', 'royal-addons-for-elementor' ) )
            ->set_items( $items );

        return $controls;
    }

    private function get_condition_options() { return array_map( function ( $c ) { return $c->get_title(); }, $this->conditions ); }
    public static function instance() { if ( is_null( self::$_instance ) ) self::$_instance = new self(); return self::$_instance; }
}