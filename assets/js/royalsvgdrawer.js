(function ($) {
    "use strict";

    var RoyalSVGDrawer = function ($scope, $) {

        var $svgWrapper = $scope.find('.royal-svg-draw');
        var settings = $svgWrapper.data('settings') || {}; // Retrieve settings from data attribute

        // Check if GSAP and ScrollTrigger are loaded. This is crucial!
        if (typeof gsap === 'undefined' || typeof ScrollTrigger === 'undefined') {
            console.warn('Royal SVG Drawer: GSAP or ScrollTrigger not loaded. Animation will not work.');
            $svgWrapper.removeClass('elementor-invisible'); // Ensure visibility even without animation
            return;
        }

        var isAnimated = settings.animate_icon === 'yes'; // Use settings directly for animation check

        // If animation is explicitly disabled, just show the SVG and return
        if (!isAnimated) {
            $svgWrapper.removeClass('elementor-invisible');
            return;
        }

        var svg = $svgWrapper.find('svg')[0];
        // Ensure we target valid drawable SVG elements
        var $paths = $svgWrapper.find('path, circle, rect, ellipse, line, polyline');

        // If no SVG or no drawable paths are found, make it visible and stop
        if (!svg || !$paths.length) {
            console.warn('Royal SVG Drawer: No SVG element or drawable paths found. Animation will not work.');
            $svgWrapper.removeClass('elementor-invisible');
            return;
        }

        var scrollAction = settings.scroll_action || 'viewport';
        var timeline = gsap.timeline({
            paused: true,
            // Ensure yoyo and repeat are set here for consistency, especially with ScrollTrigger
            repeat: (settings.loop === 'true' && scrollAction !== 'viewport') ? -1 : 0, // Loop only for automatic/hover, not viewport scrub
            yoyo: (settings.yoyo === 'yes' && scrollAction !== 'viewport') ? true : false // Yoyo only for automatic/hover, not viewport scrub
        });

        $paths.each(function () {
            var path = this;
            var length = path.getTotalLength();

            // Sanity check for length
            if (isNaN(length) || length === 0) {
                console.warn('Royal SVG Drawer: Path has an invalid or zero length. Skipping animation for this path.', path);
                return; // Skip this path if its length is invalid
            }

            path.style.strokeDasharray = length + 'px'; // Add 'px' for clarity, though not always strictly needed by browsers
            path.style.strokeDashoffset = length + 'px';

            timeline.to(path, {
                strokeDashoffset: 0,
                // Default duration to 5 if not set, or parseFloat for size if it's a slider control
                duration: parseFloat(settings.frames && settings.frames.size ? settings.frames.size : 5),
                ease: "power1.inOut"
            }, $scope.hasClass('royal-svg-sync-yes') ? "<" : "-=0.05"); // Adjusted relative position slightly for potential smoother staggered effect
        });

        if (settings.svg_fill === 'yes') {
            timeline.to($paths, {
                fill: settings.svg_color || '#000', // Default fill color
                stroke: settings.svg_stroke || $paths.css('stroke'), // Use existing stroke as default
                duration: parseFloat(settings.svg_fill_speed && settings.svg_fill_speed.size ? settings.svg_fill_speed.size : 1), // Default fill speed to 1
                ease: "power1.inOut"
            }, '-=0.2'); // Adjusted relative position
        }

        // Trigger Logic
        if (scrollAction === 'viewport') {
            ScrollTrigger.create({
                trigger: $svgWrapper[0],
                start: `top ${settings.animate_offset && settings.animate_offset.size !== undefined ? settings.animate_offset.size : 50}%`, // Use custom offset for start if available
                end: "bottom 20%", // End point remains consistent
                scrub: parseFloat(settings.draw_speed && settings.draw_speed.size ? settings.draw_speed.size : 0.3), // Default scrub speed to 0.3
                animation: timeline,
                // Make sure it becomes visible as soon as ScrollTrigger takes over
                onEnter: () => $svgWrapper.removeClass('elementor-invisible'),
                onLeaveBack: () => { // If scrolling back up, reset visibility if animation reverses
                    if (settings.anim_rev === 'yes') {
                        $svgWrapper.removeClass('elementor-invisible');
                    }
                }
            });
        } else if (scrollAction === 'automatic') {
            // Loop and Yoyo are set in the timeline creation itself for automatic
            ScrollTrigger.create({
                trigger: $svgWrapper[0],
                start: `top ${settings.animate_offset && settings.animate_offset.size !== undefined ? settings.animate_offset.size : 50}%`, // Use custom offset
                toggleActions: settings.anim_rev === 'yes' ? "play none none reverse" : "play none none none",
                onEnter: () => {
                    $svgWrapper.removeClass('elementor-invisible');
                    timeline.play();
                },
                onLeaveBack: () => { // Ensure it becomes visible when reversing and entering again
                    if (settings.anim_rev === 'yes') {
                        $svgWrapper.removeClass('elementor-invisible');
                    }
                }
            });
        } else if (scrollAction === 'hover') {
            $svgWrapper.removeClass('elementor-invisible'); // Always visible on hover
            $svgWrapper.on('mouseenter', function() {
                timeline.play();
            });
            $svgWrapper.on('mouseleave', function() {
                if (settings.yoyo === 'yes') {
                    timeline.reverse();
                } else if (settings.loop !== 'true') {
                    timeline.progress(0).pause(); // Reset to start and pause
                }
            });
        } else {
            // Default case if no specific scroll action is set or recognized
            $svgWrapper.removeClass('elementor-invisible');
        }

        // For cases where animation might not be triggered by ScrollTrigger initially
        // or for very fast scrolls, ensuring it eventually becomes visible.
        // This line makes sure the SVG is shown immediately if it's not animated
        // or if the animation trigger is not scroll based (e.g., hover).
        // For scroll-based animations, the 'onEnter' in ScrollTrigger handles visibility.
        if (scrollAction !== 'viewport' && scrollAction !== 'automatic') {
             $svgWrapper.removeClass('elementor-invisible');
        }
    };

    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/royalsvgdrawer.default', RoyalSVGDrawer);
    });

})(jQuery);