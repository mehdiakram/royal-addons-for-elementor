(function ($) {
    'use strict';

    var RoyalCircleHandler = function ($scope) {
        var configString = $scope.attr('data-royal-circles') || $scope.find('.royal-background-preview-wrapper').attr('data-royal-circles');
        var $wrapper = $scope.find('.royal-background-circles-wrapper');
        if (!$wrapper.length) {
            $wrapper = $('<div class="royal-background-circles-wrapper"></div>');
            $scope.prepend($wrapper);
            if ($scope.css('position') === 'static') $scope.css('position', 'relative');
        }
        $wrapper.empty();

        if (typeof configString === 'undefined' || !configString) return;
        var circles;
        try { circles = JSON.parse(configString); } catch (e) { return; }
        if (!circles || circles.length === 0) return;

        circles.forEach(function (config) {
            var circleType = config.circle_type || 'simple';
            var size = (circleType === 'simple' || circleType === 'corner-rings') ? (config.main_circle_size?.size || 250) : (config.graphic_size?.size || 250);
            
            var $graphic = $('<div class="royal-circle-graphic"></div>').css({
                'width': size + 'px',
                'height': size + 'px',
                'top': `${config.graphic_vertical_offset?.size || 50}${config.graphic_vertical_offset?.unit || '%'}`,
                'left': `${config.graphic_horizontal_offset?.size || 50}${config.graphic_horizontal_offset?.unit || '%'}`,
                'z-index': config.graphic_z_index || 0
            });

            if (circleType === 'segmented') {
                // --- SVG Circle Generation ---
                var strokeWidth = config.stroke_width?.size || 4;
                var radius = (size / 2) - (strokeWidth / 2);
                var circumference = 2 * Math.PI * radius;
                var svgNS = "http://www.w3.org/2000/svg";
                var $svg = $(document.createElementNS(svgNS, 'svg')).attr({'class': 'royal-circle-svg', 'viewBox': `0 0 ${size} ${size}`});
                var totalOffset = 0;
                if (config.circle_segments?.length) {
                    config.circle_segments.forEach(function(segment) {
                        var segmentLength = ((segment.segment_length?.size || 0) / 100) * circumference;
                        var gapLength = ((segment.segment_gap?.size || 0) / 100) * circumference;
                        var $circle = $(document.createElementNS(svgNS, 'circle')).attr({'cx':size/2, 'cy':size/2, 'r':radius, 'fill':'transparent', 'stroke':segment.segment_color||'#FFF', 'stroke-width':strokeWidth, 'stroke-dasharray':`${segmentLength} ${circumference}`, 'stroke-dashoffset':-totalOffset, 'transform':`rotate(-90 ${size/2} ${size/2})`});
                        $svg.append($circle);
                        totalOffset += segmentLength + gapLength;
                    });
                }
                $graphic.append($svg);
                if (config.animation && config.animation !== 'off') {
                    $graphic.addClass('anim-' + config.animation).css('--speed', (config.animation_speed || 20) + 's');
                }
            } else if (circleType === 'corner-rings') {
                // --- Corner Deco Rings (Stats Card Style) ---
                $graphic.addClass('royal-corner-rings-wrap').css({
                    'top': 0, 'left': 0, 'width': '100%', 'height': '100%', 'transform': 'none'
                });
                var r1Size = size;
                var r2Size = Math.round(size * 0.7);
                var borderStyle = config.main_circle_border_style || 'dashed';
                var borderWidth = (config.main_circle_border_width?.size || 2) + 'px';
                var color = config.main_circle_color || 'rgba(255, 255, 255, 0.16)';
                var speed = (config.animation_speed || 40) + 's';

                var $r1 = $('<div class="royal-corner-ring r1"></div>').css({
                    width: r1Size + 'px', height: r1Size + 'px',
                    borderColor: color, borderStyle: borderStyle, borderWidth: borderWidth,
                    '--speed': speed
                });
                var $r2 = $('<div class="royal-corner-ring r2"></div>').css({
                    width: r2Size + 'px', height: r2Size + 'px',
                    borderColor: color, borderStyle: borderStyle, borderWidth: borderWidth,
                    '--speed': speed
                });
                $graphic.append($r1).append($r2);
            } else {
                // --- Simple Circle Generation ---
                var $dottedCircle = $('<div class="rcg-dotted-circle"></div>').css({
                    '--main-color': config.main_circle_color || '#87CEEB',
                    '--border-width': (config.main_circle_border_width?.size || 2) + 'px',
                    '--border-style': config.main_circle_border_style || 'dotted'
                });
                if (config.animation && config.animation !== 'off') {
                    $dottedCircle.addClass('anim-' + config.animation).css('--speed', (config.animation_speed || 20) + 's');
                }
                $graphic.append($dottedCircle);
            }

            // --- Dots Generation (Works for simple & segmented) ---
            if (circleType !== 'corner-rings') {
                var dotOrbitDiameter = size;
                if (circleType === 'segmented') {
                    var strokeWidthForOrbit = config.stroke_width?.size || 4;
                    dotOrbitDiameter = size - strokeWidthForOrbit;
                } else {
                    var borderWidthForOrbit = config.main_circle_border_width?.size || 2;
                    dotOrbitDiameter = size - borderWidthForOrbit;
                }
                
                var dotsZIndex = config.dots_z_index || 1;

                if (config.dot1_enable === 'yes') {
                    var $dot1Arm = $('<div class="rcg-dot-arm"></div>').css({
                        'width': dotOrbitDiameter + 'px',
                        'height': dotOrbitDiameter + 'px',
                        'z-index': dotsZIndex
                    });
                    var $dot1 = $('<div class="rcg-dot"></div>').css('--dot-size', `${config.dot1_size?.size || 15}px`).css('--dot-color', config.dot1_color || '#FFF');
                    if (config.dot1_animation && config.dot1_animation !== 'off') $dot1Arm.addClass('anim-' + config.dot1_animation).css('--speed', `${config.dot1_speed || 10}s`);
                    $dot1Arm.append($dot1);
                    $graphic.append($dot1Arm);
                }
                if (config.dot2_enable === 'yes') {
                    var $dot2Arm = $('<div class="rcg-dot-arm rcg-dot-arm2"></div>').css({
                        'width': dotOrbitDiameter + 'px',
                        'height': dotOrbitDiameter + 'px',
                        'z-index': dotsZIndex
                    });
                    var $dot2 = $('<div class="rcg-dot"></div>').css('--dot-size', `${config.dot2_size?.size || 10}px`).css('--dot-color', config.dot2_color || '#87CEEB');
                    if (config.dot2_animation && config.dot2_animation !== 'off') $dot2Arm.addClass('anim-' + config.dot2_animation).css('--speed', `${config.dot2_speed || 15}s`);
                    $dot2Arm.append($dot2);
                    $graphic.append($dot2Arm);
                }
            }

            $wrapper.append($graphic);
        });
    };

    $(window).on('elementor/frontend/init', function () {
        ['section', 'container', 'column', 'div-block', 'e-div-block', 'e-flexbox'].forEach(el => elementorFrontend.hooks.addAction('frontend/element_ready/' + el, RoyalCircleHandler));
    });

})(jQuery);
