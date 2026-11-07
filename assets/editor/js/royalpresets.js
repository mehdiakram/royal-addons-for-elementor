jQuery(document).ready(function ($) {
    $(document).on("change", '[data-setting="preset"]', function () {
        let selectedPreset = $(this).val();
        let widgetWrapper = $(this).closest(".elementor-widget");
        let widgetID = widgetWrapper.attr("data-id"); // Get the widget's unique ID
        let widgetType = widgetWrapper.data("widget_type"); // Get widget type

        // Preset values
        let presets = {
            "royalheadingscrolltrigger": {
                "preset_random": {
                    "staggeramount": { "size": 1, "unit": "px" },
                    "from_opacity": { "size": 0.25 }, // No unit
                    "duration": { "size": 0.1, "unit": "px" },
                    "staggerfrom": "random"
                },
                "preset_slanted_rotate": {
                    "from_rotatex": { "size": 360, "unit": "px" },
                    "from_opacity": { "size": 0 }, // No unit
                    "duration": { "size": 0.1, "unit": "px" },
                    "from_xposition": { "size": 100, "unit": "px" },
                    "staggerfrom": "start"
                },
                "preset_blurry": {
                    "staggeramount": { "size": 0.07, "unit": "px" },
                    "from_filter_blur": { "size": 15, "unit": "px" },
                    "from_opacity": { "size": 0.1 }, // No unit
                    "from_scaley": { "size": 0.1, "unit": "px" },
                    "duration": { "size": 0.1, "unit": "px" },
                    "staggerfrom": "start",
                    "scrolltriggerease": "power4.out"
                }
            },
            "my_widget_2": {
                "preset_1": { "heading_color": "#ff5733", "background_color": "#e0e0e0", "padding": "15px" },
                "preset_2": { "heading_color": "#222222", "background_color": "#dddddd", "padding": "30px" }
            }
        };

        // Ensure the preset exists
        if (widgetType in presets && selectedPreset in presets[widgetType]) {
            let presetData = presets[widgetType][selectedPreset];

            // Loop over all controls in the preset
            for (let controlName in presetData) {
                let controlValue = presetData[controlName];
                let controlView = elementor.getPanelView().getCurrentPageView().getControlView(controlName);

                if (controlView) {
                    // For Slider controls (with size and unit)
                    if (controlValue.size !== undefined) {
                        controlView.model.set('value', {
                            size: controlValue.size,
                            unit: controlValue.unit || 'px' // Default to 'px' if unit is not provided
                        });
                    } else {
                        controlView.model.set('value', controlValue);
                    }

                    // Trigger input and change events to reflect the change in UI (for sliders, selects, etc.)
                    controlView.$el.find('input, select, textarea').trigger('input').trigger('change');

                    // Ensure the control's UI updates (required for sliders, color pickers, etc.)
                    controlView.render();
                }
            }

            // Force Elementor to refresh the widget UI (if necessary)
            elementor.reloadPreview(); // Refresh widget preview in Elementor panel
        }
    });
});
