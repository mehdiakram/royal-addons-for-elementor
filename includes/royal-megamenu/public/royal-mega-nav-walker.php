<?php
// wp-content/plugins/royal-addons-for-elementor/includes/royal-megamenu/public/royal-mega-nav-walker.php
if ( ! defined( 'ABSPATH' ) ) exit;

use Elementor\Plugin as Elementor;

class Royal_Mega_Nav_Walker extends Walker_Nav_Menu {

  public $Royal_megamenu_bg_color = '';
  private $top_level_item_count = 0;

  public function __construct() {
      $this->top_level_item_count = 0;
  }

  function start_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = ( $depth > 0  ? str_repeat( "\t", $depth ) : '' );
        $display_depth = ( $depth + 1 );
        $submenu_inline_styles = '';
        if (isset($this->Royal_megamenu_bg_color) && !empty($this->Royal_megamenu_bg_color)) {
            $submenu_inline_styles .= 'background-color:' . esc_attr($this->Royal_megamenu_bg_color) . ';';
        }
        $classes = array(
            'sub-menu default',
            'menu-depth-' . $display_depth
        );
        $class_names = implode( ' ', $classes );
        $output .= "\n$indent<ul class='" . $class_names . "' style='" . $submenu_inline_styles . "' >\n";
  }


  function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
    if ( null === $args || ! is_object( $args ) ) {
        $args = (object) [];
    }

    if ( $depth === 0 ) {
        $this->top_level_item_count++;
    }

    $royal_menu_item_settings = get_post_meta( $item->ID, 'royal_mega_menu_settings', true );
    $is_mega_menu_item = ! empty( $royal_menu_item_settings['enable_mega_menu'] ) && $royal_menu_item_settings['enable_mega_menu'] == 'on';

    // Initialize variables
    $this->Royal_megamenu_bg_color = '';
    $submenu_icon_visibility_class = 'submenuicon-hide';
    $mega_menu_width_class = 'actual-width-mega-menu';
    $custom_width = ''; // Variable to hold the custom width
    $builder_content = '';
    $dropdown_icon_html = '';
    $dropdown_icon_span = '';
    $data_hover_attr = '';
    $pointer_hover_effect_span = '';
    $menu_description_span = '';

    if ( $is_mega_menu_item && ! empty( $royal_menu_item_settings['template_id'] ) ) {
        $builder_content = $this->getItembuilder_content( $royal_menu_item_settings['template_id'] );
    }

    if (isset($royal_menu_item_settings['css']) && $item->ID) {
        $css = $royal_menu_item_settings['css'];
        $this->Royal_megamenu_bg_color = $css['background_color'] ?? '';
        $submenu_icon_setting = $css['hide_submenu_icon'] ?? 'off';
        $submenu_icon_visibility_class = ($submenu_icon_setting === 'on') ? 'submenuicon-show' : 'submenuicon-hide';
        
        $full_width_setting = $css['full_width'] ?? 'off';
        if ($full_width_setting === 'on') {
            $mega_menu_width_class = 'full-width-mega-menu';
        } else {
            $mega_menu_width_class = 'actual-width-mega-menu';
            $custom_width = $css['width'] ?? ''; // Get custom width if not full width
        }
    }

    $indent = ( $depth > 0 ? str_repeat( "\t", $depth ) : '' );
    $classes = empty( $item->classes ) ? array() : (array) $item->classes;

    if( $is_mega_menu_item ){
        $classes[] = 'menu-item-has-children royal_mega_menu_item';
    }

    if ( isset( $args->menu_style ) && $args->menu_style === 'multiple_colors' ) {
        $menu_colors_list = property_exists( $args, 'menu_colors_list' ) ? (array) $args->menu_colors_list : [];
        $repeater_id_prefix = property_exists( $args, 'repeater_id_prefix' ) ? (string)$args->repeater_id_prefix : 'elementor-repeater-item-';
        $num_repeater_items = count( $menu_colors_list );
        if ( $depth === 0 && $num_repeater_items > 0 ) {
            $repeater_map_index = ( $this->top_level_item_count - 1 ) % $num_repeater_items;
            if ( isset( $menu_colors_list[ $repeater_map_index ]['_id'] ) ) {
                $classes[] = $repeater_id_prefix . (string)$menu_colors_list[ $repeater_map_index ]['_id'];
            } else {
                $classes[] = $repeater_id_prefix . ( $repeater_map_index + 1 );
            }
        }
    }

    $class_names = esc_attr( implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) ) );

    if ( property_exists( $args, 'enable_data_hover' ) && $args->enable_data_hover === 'yes' ) {
        $data_hover_attr = ' data-hover="' . esc_attr( (string)$item->title ) . '"';
    }
    
    $output .= $indent . '<li' . $data_hover_attr . ' id="nav-menu-item-'. $item->ID . '" class="' . $class_names . '">';

    $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( (string)$item->attr_title ) .'"' : '';
    $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( (string)$item->target     ) .'"' : '';
    $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( (string)$item->xfn        ) .'"' : '';
    $attributes .= ! empty( $item->url )        ? ' href="'   . esc_url( (string)$item->url        ) .'"' : '';
    $attributes .= ' class="menu-link ' . ( $depth > 0 ? 'sub-menu-link' : 'main-menu-link' ) . '"';

    $has_real_children = ( !empty( $item->classes ) && is_array( $item->classes ) && in_array( 'menu-item-has-children', $item->classes ) );
    if ( $has_real_children || $is_mega_menu_item ) {
        $dropdown_icon_html = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" style="width:10px;"><path d="M201.4 406.6c12.5 12.5 32.8 12.5 45.3 0l192-192c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L224 338.7 54.6 169.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l192 192z"/></svg>';
    }

    if (!empty($dropdown_icon_html)) {
        $dropdown_icon_span = '<span class="submenu-parent-icon ' . esc_attr($submenu_icon_visibility_class) . '">'. $dropdown_icon_html .'</span>';
    }

    $pointer_hover_effect = property_exists($args, 'pointer_hover_effect') ? $args->pointer_hover_effect : 'none';
    if (!empty($pointer_hover_effect) && $pointer_hover_effect !== 'none') {
        $pointer_hover_effect_span = '<span class="pointer-'.esc_attr($pointer_hover_effect).'"></span>';
    }

    if(!empty($item->description)){
        $menu_description_span = '<span class="menu-desc">' . (string) $item->description . '</span>';
    }

    $title = apply_filters( 'the_title', $item->title, $item->ID );
    $content_inner = '<div class="menu-text"><span>'. $title .'</span>'. $menu_description_span . $pointer_hover_effect_span . $dropdown_icon_span .'</div>';

    $item_output = sprintf( '<a%1$s>%2$s</a>', $attributes, $content_inner );

    if( !empty( $builder_content ) ){
        // *** START: FINAL CORRECTED LOGIC FOR ALL STYLES ***
        $styles_array = [];
        if (!empty($this->Royal_megamenu_bg_color)) {
            $styles_array[] = 'background-color:' . esc_attr($this->Royal_megamenu_bg_color);
        }
        if (!empty($custom_width)) {
            $styles_array[] = 'width:' . esc_attr($custom_width);
        }
        
        $mega_menu_inline_styles = '';
        if (!empty($styles_array)) {
            $mega_menu_inline_styles = 'style="' . implode(';', $styles_array) . ';"';
        }

        $item_output .= sprintf('<ul class="royal-megamenu-contents sub-menu submenu %1$s" %2$s>%3$s</ul>', esc_attr($mega_menu_width_class), $mega_menu_inline_styles, $builder_content );
        // *** END: FINAL CORRECTED LOGIC ***
    }

    $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
  }

  public function display_element( $element, &$children_elements, $max_depth, $depth, $args, &$output ) {
    $id_field = $this->db_fields['id'];
    if ( is_object( $args[0] ) ){
       $args[0]->has_children =  !empty ( $children_elements[ $element->$id_field ] ) ;
    }
    parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
  }

  private function getItembuilder_content( $template_id ){
    if ( empty($template_id) ) return '';
    if ( did_action( 'elementor/loaded' ) && class_exists('\Elementor\Plugin') ) {
        try {
            return Elementor::instance()->frontend->get_builder_content_for_display( $template_id );
        } catch (Exception $e) {
            error_log('Royal Mega Menu: Error fetching Elementor content: ' . $e->getMessage());
            return '';
        }
    }
    return '';
  }




}