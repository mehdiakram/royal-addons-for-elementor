var $j = jQuery.noConflict();

$j(document).ready(function () {
    "use strict";
    // Initialize Sticky Header
    sheHeader();
});

/* ==============================================
ROYAL STICKY HEADER - SMOOTH STICKY EFFECTS
============================================== */

function sheHeader() {
    // Find header element with sticky enabled - try multiple selectors
    var header = $j('.royalstickyheader-header-yes');

    // Fallback: try with elementor-element class
    if (header.length === 0) {
        header = $j('.elementor-element.royalstickyheader-header-yes');
    }

    // Fallback: try section or container
    if (header.length === 0) {
        header = $j('.elementor-section.royalstickyheader-header-yes, .e-con.royalstickyheader-header-yes');
    }

    // Exit if no header found
    if (header.length === 0) {
        return;
    }

    var container = $j('.royalstickyheader-header-yes .elementor-container, .elementor-element.royalstickyheader-header-yes.e-con'),
        header_elementor = $j('.elementor-edit-mode .royalstickyheader-header-yes'),
        header_logo = $j('.royalstickyheader-header-yes .elementor-widget-theme-site-logo img:not(.elementor-widget-n-menu img), .royalstickyheader-header-yes .elementor-widget-image img:not(.elementor-widget-n-menu img)'),
        data_settings = header.data('settings');

    // Exit if no settings found
    if (typeof data_settings == 'undefined' || data_settings === null) {
        return;
    }

    // Get responsive settings - default to all devices if not set
    var responsive_settings = data_settings["transparent_on"] || ["desktop", "tablet", "mobile"];

    var width = $j(window).width(),
        header_height = header.outerHeight() || 80,
        logo_width = header_logo.length > 0 ? header_logo.width() : 0,
        logo_height = header_logo.length > 0 ? header_logo.height() : 0;

    // Check responsive is enabled
    var enabled = "";
    if (typeof width != 'undefined' && width) {
        if (width >= 1025) {
            enabled = "desktop";
        } else if (width > 767 && width < 1025) {
            enabled = "tablet";
        } else if (width <= 767) {
            enabled = "mobile";
        }
    }

    // Check if current device is enabled
    if (Array.isArray(responsive_settings)) {
        if (responsive_settings.indexOf(enabled) === -1) {
            return;
        }
    }

    // Get settings with defaults
    var scroll_distance = data_settings["scroll_distance"] || { size: 60, unit: 'px' };
    var sticky_on_reach_top = data_settings["sticky_on_reach_top"]; // New: sticky when reaches viewport top
    var royalstickyheader_offset = data_settings["royalstickyheader_offset_top"] || { size: 0, unit: 'px' };
    var royalstickyheader_padding = data_settings["royalstickyheader_padding"] || { top: 0, bottom: 0, left: '', right: '', unit: 'px' };
    var royalstickyheader_width = data_settings["royalstickyheader_width"] || { size: 100, unit: '%' };
    var transparent_header = data_settings["transparent_header_show"];
    var background = data_settings["background"];
    var background_show = data_settings["background_show"];
    var bottom_border_color = data_settings["custom_bottom_border_color"],
        bottom_border_view = data_settings["bottom_border"],
        bottom_border_width = data_settings["custom_bottom_border_width"];

    var shrink_header = data_settings["shrink_header"],
        data_height = data_settings["custom_height_header"],
        data_height_tablet = data_settings["custom_height_header_tablet"],
        data_height_mobile = data_settings["custom_height_header_mobile"];

    var shrink_logo = data_settings["shrink_header_logo"],
        data_logo_height = data_settings["custom_height_header_logo"],
        data_logo_height_tablet = data_settings["custom_height_header_logo_tablet"],
        data_logo_height_mobile = data_settings["custom_height_header_logo_mobile"];

    var change_logo_color = data_settings["change_logo_color"];
    var blur_bg = data_settings["blur_bg"];
    var scroll_distance_hide_header = data_settings["scroll_distance_hide_header"];
    var hide_header = data_settings["hide_header"];

    // Calculate header's original position from top of page (for sticky_on_reach_top)
    var headerOriginalTop = header.offset() ? header.offset().top : 0;

    // Responsive settings for offset, padding, width
    if (width >= 1025) {
        royalstickyheader_offset = data_settings["royalstickyheader_offset_top"] || { size: 0, unit: 'px' };
        royalstickyheader_padding = data_settings["royalstickyheader_padding"] || { top: 0, bottom: 0, left: '', right: '', unit: 'px' };
        royalstickyheader_width = data_settings["royalstickyheader_width"] || { size: 100, unit: '%' };
    } else if (width > 767 && width < 1025) {
        royalstickyheader_offset = data_settings["royalstickyheader_offset_top_tablet"] || royalstickyheader_offset;
        royalstickyheader_padding = data_settings["royalstickyheader_padding_tablet"] || royalstickyheader_padding;
        royalstickyheader_width = data_settings["royalstickyheader_width_tablet"] || royalstickyheader_width;
    } else if (width <= 767) {
        royalstickyheader_offset = data_settings["royalstickyheader_offset_top_mobile"] || royalstickyheader_offset;
        royalstickyheader_padding = data_settings["royalstickyheader_padding_mobile"] || royalstickyheader_padding;
        royalstickyheader_width = data_settings["royalstickyheader_width_mobile"] || royalstickyheader_width;
    }

    // Create placeholder element to prevent content jump
    var placeholderId = 'royalstickyheader-placeholder';
    if ($j('#' + placeholderId).length === 0) {
        header.before('<div id="' + placeholderId + '" style="display:none;height:0;"></div>');
    }
    var placeholder = $j('#' + placeholderId);

    // Add transparent class if enabled
    if (transparent_header == "yes") {
        header.addClass('royalstickyheader-header-transparent-yes');
    }

    // Header height shrink calculation
    var shrink_height = 70;
    if (typeof data_height != "undefined" && data_height && data_height.size) {
        if (width >= 1025) {
            shrink_height = data_height["size"];
        } else if (width > 767 && width < 1025) {
            shrink_height = (data_height_tablet && data_height_tablet["size"]) ? data_height_tablet["size"] : data_height["size"];
        } else if (width <= 767) {
            shrink_height = (data_height_mobile && data_height_mobile["size"]) ? data_height_mobile["size"] : data_height["size"];
        }
    }

    // Logo height shrink calculation
    var width_l = 0, height_l = 0;
    if (typeof data_logo_height != "undefined" && data_logo_height && data_logo_height.size) {
        var shrink_logo_height = data_logo_height["size"];

        if (width > 767 && width < 1025 && data_logo_height_tablet && data_logo_height_tablet["size"]) {
            shrink_logo_height = data_logo_height_tablet["size"];
        } else if (width <= 767 && data_logo_height_mobile && data_logo_height_mobile["size"]) {
            shrink_logo_height = data_logo_height_mobile["size"];
        }

        if (shrink_logo_height && logo_width && logo_height) {
            width_l = (logo_width * shrink_logo_height) / 100;
            height_l = (logo_height * shrink_logo_height) / 100;
        }
    }

    // Border bottom
    var bottom_border = "";
    if (bottom_border_view == "yes" && bottom_border_width && bottom_border_width.size) {
        bottom_border = bottom_border_width["size"] + "px solid " + (bottom_border_color || '#000');
    }

    // Hide header on scroll down
    if (hide_header == "yes" && scroll_distance_hide_header && scroll_distance_hide_header.size) {
        var mywindow = $j(window),
            mypos = mywindow.scrollTop();

        mywindow.scroll(function () {
            var sd_hh = scroll_distance_hide_header["size"] || 500;

            if (width > 767 && width < 1025) {
                var sd_hh_tablet = data_settings["scroll_distance_hide_header_tablet"];
                if (sd_hh_tablet && sd_hh_tablet.size) sd_hh = sd_hh_tablet.size;
            } else if (width <= 767) {
                var sd_hh_mobile = data_settings["scroll_distance_hide_header_mobile"];
                if (sd_hh_mobile && sd_hh_mobile.size) sd_hh = sd_hh_mobile.size;
            }

            if (mypos > sd_hh) {
                if (mywindow.scrollTop() > mypos) {
                    header.addClass("headerup");
                } else {
                    header.removeClass("headerup");
                }
            }
            mypos = mywindow.scrollTop();
        });
    }

    // State tracking
    var isSticky = false;

    // Main scroll function
    $j(window).on("load scroll", function (e) {
        var scroll = $j(window).scrollTop();

        // Don't apply sticky in editor mode
        if (header_elementor.length > 0) {
            return;
        }

        // Calculate admin bar offset FIRST (needed for sticky_on_reach_top calculation)
        var adminBarOffset = 0;
        if (document.body.classList.contains('admin-bar')) {
            if (width >= 783) {
                adminBarOffset = 32;
            } else if (width >= 601) {
                adminBarOffset = 46;
            }
        }

        // Get scroll distance value
        var sd = 60; // Default

        // If "Sticky When Reaches Top" is enabled, use header's original position
        if (sticky_on_reach_top == "yes") {
            sd = headerOriginalTop - adminBarOffset;
            if (sd < 0) sd = 0;
        } else if (scroll_distance && scroll_distance.size !== undefined) {
            sd = scroll_distance.size;

            // Check for responsive values
            if (width > 767 && width < 1025) {
                var sd_tablet = data_settings["scroll_distance_tablet"];
                if (sd_tablet && sd_tablet.size !== undefined) sd = sd_tablet.size;
            } else if (width <= 767) {
                var sd_mobile = data_settings["scroll_distance_mobile"];
                if (sd_mobile && sd_mobile.size !== undefined) sd = sd_mobile.size;
            }

            // Handle vh unit
            if (scroll_distance.unit == "vh") {
                sd = window.innerHeight * (sd / 100);
            }
        }

        // ========== STICKY STATE ==========
        if (scroll >= sd) {
            if (!isSticky) {
                isSticky = true;

                // Show placeholder to prevent content jump (only if not transparent)
                if (transparent_header !== "yes") {
                    placeholder.css({
                        'display': 'block',
                        'height': header_height + 'px'
                    });
                }

                // Add sticky classes
                // If sticky_on_reach_top is enabled, don't add animation class (header is already at top)
                if (sticky_on_reach_top == "yes") {
                    header.addClass("royalstickyheader-header royalstickyheader-no-slide");
                } else {
                    header.addClass("royalstickyheader-header royalstickyheader-is-sticky");
                }
                header.removeClass('header royalstickyheader-header-transparent-yes');

                // Calculate top position
                var topOffset = adminBarOffset;
                if (royalstickyheader_offset && royalstickyheader_offset.size) {
                    topOffset += royalstickyheader_offset.size;
                }

                // Apply fixed positioning
                header.css({
                    "position": "fixed",
                    "top": topOffset + "px",
                    "left": "0",
                    "right": "0",
                    "z-index": "99999",
                    "width": "100%"
                });
            }

            // Apply background color if enabled
            if (background_show == "yes" && background) {
                header.css("background-color", background);
            }

            // Apply border bottom
            if (bottom_border) {
                header.css("border-bottom", bottom_border);
            }

            // Apply padding
            if (royalstickyheader_padding) {
                var padUnit = royalstickyheader_padding.unit || 'px';
                if (royalstickyheader_padding.top !== '' && royalstickyheader_padding.top !== undefined) {
                    header.css("padding-top", royalstickyheader_padding.top + padUnit);
                }
                if (royalstickyheader_padding.bottom !== '' && royalstickyheader_padding.bottom !== undefined) {
                    header.css("padding-bottom", royalstickyheader_padding.bottom + padUnit);
                }
                if (royalstickyheader_padding.left !== '' && royalstickyheader_padding.left !== undefined) {
                    header.css("padding-left", royalstickyheader_padding.left + padUnit);
                }
                if (royalstickyheader_padding.right !== '' && royalstickyheader_padding.right !== undefined) {
                    header.css("padding-right", royalstickyheader_padding.right + padUnit);
                }
            }

            // Apply custom width
            if (royalstickyheader_width && royalstickyheader_width.size && royalstickyheader_width.size < 100) {
                var widthUnit = royalstickyheader_width.unit || '%';
                header.css({
                    "width": royalstickyheader_width.size + widthUnit,
                    "left": "50%",
                    "right": "auto",
                    "transform": "translateX(-50%)"
                });
            }

            // Shrink header
            if (shrink_header == "yes" && shrink_height) {
                header.css({
                    "padding-top": "0",
                    "padding-bottom": "0",
                    "margin-top": "0",
                    "margin-bottom": "0"
                });
                container.css({
                    "height": shrink_height + "px",
                    "min-height": shrink_height + "px"
                });
            }

            // Change logo color
            if (change_logo_color == "yes") {
                header_logo.addClass("change-logo-color");
            }

            // Shrink logo
            if (shrink_logo == "yes" && width_l > 0) {
                header_logo.css("width", width_l + "px");
            }

            // Apply blur effect
            if (blur_bg == "yes") {
                header.addClass("royalstickyheader-blur-yes");
            }

            // Add shadow
            header.addClass("royalstickyheader-shadow-soft");

        } else {
            // ========== NORMAL STATE ==========
            if (isSticky) {
                isSticky = false;

                // Hide placeholder
                placeholder.css({
                    'display': 'none',
                    'height': '0'
                });

                // Remove all sticky classes
                header.removeClass("royalstickyheader-header royalstickyheader-is-sticky royalstickyheader-no-slide royalstickyheader-blur-yes royalstickyheader-shadow-soft royalstickyheader-shadow-medium royalstickyheader-shadow-strong");
                header.addClass('header');

                // Reset position
                header.css({
                    "position": "",
                    "top": "",
                    "left": "",
                    "right": "",
                    "transform": "",
                    "z-index": "",
                    "width": ""
                });

                // Reset styles
                header.css({
                    "background-color": "",
                    "border-bottom": "",
                    "padding-top": "",
                    "padding-bottom": "",
                    "padding-left": "",
                    "padding-right": "",
                    "margin-top": "",
                    "margin-bottom": ""
                });

                // Re-add transparent class if needed
                if (transparent_header == "yes") {
                    header.addClass('royalstickyheader-header-transparent-yes');
                }

                // Reset container
                if (shrink_header == "yes") {
                    container.css({
                        "height": "",
                        "min-height": ""
                    });
                }

                // Reset logo
                if (shrink_logo == "yes") {
                    header_logo.css({ "height": "", "width": "" });
                }

                // Reset logo color
                if (change_logo_color == "yes") {
                    header_logo.removeClass("change-logo-color");
                }
            }
        }
    });

    // Trigger initial scroll check
    $j(window).trigger('scroll');
}
