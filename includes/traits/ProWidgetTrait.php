<?php
// RoyalAddons/Traits/ProWidgetTrait.php
namespace RoyalAddons\Traits;

use RoyalAddons\Elementor\Royal_Helpers;

trait ProWidgetTrait {

   protected function is_pro_widget() {
        $pro_widgets = Royal_Helpers::royal_get_pro_widgets();

        $current_class = (new \ReflectionClass($this))->getShortName();

        if (is_array($pro_widgets) && in_array($current_class, $pro_widgets)) {
            return true;
        }

        return false;
    }

    protected function maybe_render_license_notice() {
        $is_valid = function_exists('royaladdons_is_license_valid') ? royaladdons_is_license_valid() : false;

        if ( $this->is_pro_widget() && ! $is_valid ) {
            $message = sprintf(
                __('This Pro widget is disabled because your license is invalid. Please <a href="%s" target="_blank">activate your license</a>.', 'royal-addons-for-elementor'),
                esc_url('https://www.royaltechbd.com/product/royal-addons-for-elementor/') 
            );

            
            echo '<div class="royal-license-error">' . wp_kses_post($message) . '</div>';
            return true; 
        }

        return false;
    }

}

