"use strict";

(function ($) {
    var $window = $(window);
    
    $window.on('elementor/frontend/init', function () {
        var ModuleHandler = elementorModules.frontend.handlers.Base,
            GsapScrollTriggerHandler;

        GsapScrollTriggerHandler = ModuleHandler.extend({
            bindEvents: function bindEvents() {
                this.run();
            },

            onElementChange: function (prop) {
                if (prop.indexOf('gsap_') !== -1) {
                    this.run();
                }
            },

            /**
             * Read a setting value. Priority:
             * 1. data-attributes on the wrapper (most reliable for ALL element types)
             * 2. Elementor getElementSettings() fallback
             */
            getSetting: function(key) {
                // 1. data-attributes (injected by PHP for ALL element types)
                var dataKey = 'data-' + key.replace(/_/g, '-');
                var dataAttr = this.$element.attr(dataKey);
                if (dataAttr !== undefined && dataAttr !== null) {
                    return dataAttr;
                }

                // 2. Elementor settings API fallback (works for standard containers)
                var val = this.getElementSettings(key);
                if (val !== undefined && val !== '' && val !== null) {
                    return val;
                }

                return undefined;
            },

            /**
             * Safely parse a numeric value from getSetting().
             * Handles: plain number, string, {size: x, unit: '...'} objects
             */
            getNumericSetting: function(key, defaultVal) {
                var val = this.getSetting(key);
                if (val === undefined || val === null || val === '') return defaultVal;
                if (typeof val === 'object' && val.size !== undefined) val = val.size;
                var num = parseFloat(val);
                return isNaN(num) ? defaultVal : num;
            },

            run: function run() {
                var isEnabled = this.getSetting('gsap_scrolltrigger_enable');
                if (isEnabled !== 'enable' && isEnabled !== 'yes' && isEnabled !== true && isEnabled !== 'true') {
                    return;
                }

                if (typeof gsap === 'undefined' || typeof ScrollTrigger === 'undefined') {
                    return;
                }

                gsap.registerPlugin(ScrollTrigger);

                var $target = this.$element;
                if (this.$element.hasClass('elementor-widget') && this.$element.find('.elementor-widget-container').length) {
                    $target = this.$element.find('.elementor-widget-container').first();
                }
                var element = $target.get(0);

                if (!element) return;

                // Kill existing scroll triggers on this element (for live editor refresh)
                if (element._gsapScrollTrigger) {
                    element._gsapScrollTrigger.kill();
                }
                gsap.killTweensOf(element);

                // Read numeric settings with safe defaults
                var opacityStart = this.getNumericSetting('gsap_opacity_start', 0);
                var scaleStart = this.getNumericSetting('gsap_scale_start', 1);
                var xPosition = this.getNumericSetting('gsap_x_position', 0);
                var yPosition = this.getNumericSetting('gsap_y_position', 0);
                var rotation = this.getNumericSetting('gsap_rotation', 0);
                var duration = this.getNumericSetting('gsap_duration', 1000);
                var durationSec = duration / 1000;

                // Scrub
                var scrubValue = this.getSetting('gsap_scrolltrigger_scrub');
                var isScrubEnabled = true;
                if (scrubValue !== undefined && scrubValue !== null) {
                    isScrubEnabled = (scrubValue === 'yes' || scrubValue === 'enable' || scrubValue === true || scrubValue === 'true');
                }
                
                // Animation effect
                var animationEffect = this.getSetting('gsap_animation_effect') || 'fade';

                // Trigger start/end — hyphens in stored values map to GSAP spaces
                var triggerStart = String(this.getSetting('gsap_scrolltrigger_start') || "top-bottom").replace(/-/g, ' ');
                var triggerEnd = String(this.getSetting('gsap_scrolltrigger_end') || "top-top").replace(/-/g, ' ');

                // GSAP Timeline with ScrollTrigger
                var tl = gsap.timeline({
                    scrollTrigger: {
                        trigger: element,
                        start: triggerStart,
                        end: triggerEnd,
                        scrub: isScrubEnabled,
                    }
                });

                if (animationEffect === 'zoom') {
                    tl.fromTo(element, { scale: 0.5 }, { scale: 1, duration: durationSec });
                } else if (animationEffect === 'slide') {
                    tl.fromTo(element, { x: -100 }, { x: 0, duration: durationSec });
                } else {
                    // fade or default — use all custom values
                    tl.fromTo(element, 
                        { opacity: opacityStart, scale: scaleStart, x: xPosition, y: yPosition, rotation: rotation }, 
                        { opacity: 1, scale: 1, x: 0, y: 0, rotation: 0, duration: durationSec }
                    );
                }

                element._gsapScrollTrigger = tl.scrollTrigger;
            }
        });

        // Register for standard sections/containers and atomic div block types
        $.each(['section', 'container', 'e-container', 'e-flexbox', 'div-block', 'e-div-block', 'atomic-widget-base'], function (i, type) {
            elementorFrontend.hooks.addAction('frontend/element_ready/' + type, function ($scope) {
                elementorFrontend.elementsHandler.addHandler(GsapScrollTriggerHandler, {
                    $element: $scope
                });
            });
        });
    });
})(jQuery);
