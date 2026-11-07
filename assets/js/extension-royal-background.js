(function ($) {
    'use strict';

    // --- 1. Circle Handler Logic ---
    var handleCircles = function($scope, $dataSource) {
        var configString = $dataSource.attr('data-royal-circles');
        var $wrapper = $scope.find('.royal-background-circles-wrapper');
        if (!$wrapper.length && (typeof configString !== 'undefined' && configString)) {
            $wrapper = $('<div class="royal-background-circles-wrapper"></div>');
            $scope.prepend($wrapper);
        }
        if (typeof configString === 'undefined' || configString === '') {
            if ($wrapper.length) $wrapper.remove();
            return;
        }
        $wrapper.empty();

        var graphics;
        try { graphics = JSON.parse(configString); } catch (e) { return; }
        if (!graphics || graphics.length === 0) return;

        graphics.forEach(function (config) {
            var size = (config.main_circle_size && config.main_circle_size.size) || 250;
            var h_offset = config.graphic_horizontal_offset, v_offset = config.graphic_vertical_offset;
            var $graphic = $('<div class="royal-circle-graphic"></div>').css({
                '--graphic-size': size + 'px',
                'top': ((v_offset && v_offset.size !== '') ? v_offset.size : '0') + (v_offset ? v_offset.unit || 'px' : 'px'),
                'left': ((h_offset && h_offset.size !== '') ? h_offset.size : '0') + (h_offset ? h_offset.unit || 'px' : 'px'),
                'z-index': config.graphic_z_index || 0
            });

            var mainAnimation = config.graphic_main_animation || 'clockwise';
            if (mainAnimation !== 'off') {
                $graphic.addClass('anim-' + mainAnimation).css('--speed', (config.graphic_main_speed || 20) + 's');
            }

            var $base = $('<div class="rcg-base"></div>').css({
                'border-color': config.base_border_color || '#333',
                'border-width': (config.base_border_width && config.base_border_width.size ? config.base_border_width.size : 2) + 'px',
                'border-style': config.base_border_style || 'dotted'
            });
            $graphic.append($base);

            if (config.dot1_enable === 'yes') {
                var $dot1Arm = $('<div class="rcg-dot-arm dot-arm1"></div>');
                var $dot1 = $('<div class="rcg-dot"></div>').css({'width':(config.dot1_size.size||15)+'px','height':(config.dot1_size.size||15)+'px','background-color':config.dot1_color||'#FFFFFF'});
                var dot1Anim = config.dot1_animation || 'clockwise';
                if(dot1Anim!=='off') $dot1Arm.addClass('anim-'+dot1Anim).css('--speed',(config.dot1_speed||10)+'s');
                $dot1Arm.append($dot1);
                $graphic.append($dot1Arm);
            }
            if (config.dot2_enable === 'yes') {
                var $dot2Arm = $('<div class="rcg-dot-arm dot-arm2"></div>');
                var $dot2 = $('<div class="rcg-dot"></div>').css({'width':(config.dot2_size.size||10)+'px','height':(config.dot2_size.size||10)+'px','background-color':config.dot2_color||'#87CEEB'});
                var dot2Anim = config.dot2_animation || 'counter-clockwise';
                if(dot2Anim!=='off') $dot2Arm.addClass('anim-'+dot2Anim).css('--speed',(config.dot2_speed||15)+'s');
                $dot2Arm.append($dot2);
                $graphic.append($dot2Arm);
            }
            if(config.arcs_repeater && config.arcs_repeater.length > 0) {
                config.arcs_repeater.forEach(function(arc) {
                    var arcSize=size+((arc.arc_size_offset.size||0)*2),arcWidth=(arc.arc_width.size||5),startAngle=arc.arc_start.size||0,endAngle=arc.arc_end.size||25;
                    var gradient=`conic-gradient(from 0deg, transparent ${startAngle}%, ${arc.arc_color} ${startAngle}% ${endAngle}%, transparent ${endAngle}% 100%)`;
                    var $arc=$('<div class="rcg-arc"></div>').css({'width':arcSize+'px','height':arcSize+'px','top':(size-arcSize)/2+'px','left':(size-arcSize)/2+'px','background':gradient,'-webkit-mask-image':`radial-gradient(circle, transparent calc(50% - ${arcWidth}px), black 50%)`,'mask-image':`radial-gradient(circle, transparent calc(50% - ${arcWidth}px), black 50%)`});
                    $graphic.append($arc);
                });
            }
            $wrapper.append($graphic);
        });
    };

    // --- 2. Blob Handler Logic ---
    var handleBlobs = function($scope, $dataSource) {
        var configString = $dataSource.attr('data-royal-blobs');
        var $wrapper = $scope.find('.royal-blob-wrapper');
        if(typeof configString === 'undefined' || configString === '') { if($wrapper.length) $wrapper.remove(); return; }
        if (!$wrapper.length) {
            $wrapper = $('<div class="royal-blob-wrapper"></div>');
            $scope.prepend($wrapper);
        }
        $wrapper.empty();
        var blobs;
        try { blobs = JSON.parse(configString); } catch (e) { return; }
        if (!blobs || blobs.length === 0) return;
        blobs.forEach(function (blobConfig) {
            var $blob = $('<div />').addClass('royal-blob-item elementor-repeater-item-' + blobConfig._id);
            var size = (blobConfig.royal_blob_size && blobConfig.royal_blob_size.size) ? blobConfig.royal_blob_size.size : 300, h_offset = blobConfig.royal_blob_horizontal_offset, v_offset = blobConfig.royal_blob_vertical_offset;
            var top_val = (v_offset && v_offset.size !== '' && v_offset.size !== null) ? v_offset.size : 0, left_val = (h_offset && h_offset.size !== '' && h_offset.size !== null) ? h_offset.size : 0;
            $blob.css({ width: size + 'px', height: size + 'px', top: top_val + (v_offset ? v_offset.unit || 'px' : 'px'), left: left_val + (h_offset ? h_offset.unit || 'px' : 'px'), zIndex: blobConfig.royal_blob_zindex || 0, opacity: (blobConfig.royal_blob_opacity && blobConfig.royal_blob_opacity.size !== undefined) ? blobConfig.royal_blob_opacity.size : 1 });
            var svg = document.createElementNS("http://www.w3.org/2000/svg", "svg");
            svg.setAttribute('viewBox', '0 0 500 500');
            var path = document.createElementNS("http://www.w3.org/2000/svg", "path");
            path.setAttribute('fill', blobConfig.royal_blob_color || '#D1BCF5');
            function generateBlobPath(config) {
                var contrast = (config.royal_blob_contrast && config.royal_blob_contrast.size !== undefined) ? config.royal_blob_contrast.size : 0.4;
                if (contrast < 0.01) { var r = 250, c = 250; return `M ${c}, ${c-r} A ${r},${r} 0 1,1 ${c}, ${c+r} A ${r},${r} 0 1,1 ${c}, ${c-r} Z`; }
                var complexity = (config.royal_blob_complexity && config.royal_blob_complexity.size) ? config.royal_blob_complexity.size : 8, smoothness = (config.royal_blob_smoothness && config.royal_blob_smoothness.size !== undefined) ? config.royal_blob_smoothness.size : 1;
                var numPoints = complexity, baseRadius = 220, center = { x: 250, y: 250 }, randomSeed = Math.random() * 1000, points = [];
                for (var i = 0; i < numPoints; i++) {
                    var angle = (i / numPoints) * Math.PI * 2, distortion = 1 + (Math.sin(angle * (complexity / 2) + randomSeed) * 0.5 + Math.cos(angle * (complexity / 3) + randomSeed) * 0.5) * contrast, currentRadius = baseRadius * distortion;
                    points.push({ x: center.x + Math.cos(angle) * currentRadius, y: center.y + Math.sin(angle) * currentRadius });
                }
                var pathData = "M" + points[0].x + "," + points[0].y;
                for (var i = 0; i < numPoints; i++) {
                    const p0=points[(i - 1 + numPoints)%numPoints], p1=points[i], p2=points[(i + 1)%numPoints], p3=points[(i + 2)%numPoints];
                    const cp1x=p1.x+(p2.x-p0.x)/6*smoothness, cp1y=p1.y+(p2.y-p0.y)/6*smoothness, cp2x=p2.x-(p3.x-p1.x)/6*smoothness, cp2y=p2.y-(p3.y-p1.y)/6*smoothness;
                    pathData += "C" + cp1x + "," + cp1y + " " + cp2x + "," + cp2y + " " + p2.x + "," + p2.y;
                }
                pathData += "Z"; return pathData;
            }
            path.setAttribute('d', generateBlobPath(blobConfig));
            svg.appendChild(path); $blob.append(svg); $wrapper.append($blob);
            var contrastValue = (blobConfig.royal_blob_contrast && blobConfig.royal_blob_contrast.size !== undefined) ? blobConfig.royal_blob_contrast.size : 0.4;
            if (contrastValue > 0 && typeof anime !== 'undefined') {
                var animDuration = (blobConfig.royal_blob_animation_duration || 5) * 1000;
                function animatePath() { anime({ targets: path, d: { value: generateBlobPath(blobConfig), duration: animDuration, easing: 'easeInOutQuad' }, complete: animatePath }); }
                animatePath();
            }
        });
    };

    // --- 3. Particles Handler Logic ---
    var handleParticles = function($scope, $dataSource) {
        var configString = $dataSource.attr('data-royal-particles-config');
        const libraryContainerId = '#royal-library-container-' + $scope.data('id'), controlledContainerId = '#royal-controlled-container-' + $scope.data('id');
        const oldTsContainer = window.tsParticles ? tsParticles.dom().find(c => c.id === libraryContainerId.substring(1)) : null;
        if(oldTsContainer) { oldTsContainer.destroy(); }
        $(libraryContainerId).remove(); $(controlledContainerId).remove(); $scope.find(controlledContainerId).remove();
        if (typeof configString === 'undefined' || !configString) return;
        var configData;
        try { configData = JSON.parse(configString); } catch(e) { return; }
        if (!configData) { return; }
        const scope = configData.scope || 'contained', particlesOptions = configData.style || {};
        const libraryId = 'royal-library-container-' + $scope.data('id'), controlledId = 'royal-controlled-container-' + $scope.data('id');
        const libraryContainer = $('<div />').attr('id', libraryId).css({ position: 'fixed', top: '-9999px', left: '-9999px', pointerEvents: 'none' });
        const controlledContainer = $('<div />').attr('id', controlledId).addClass('royal-particles-wrapper');
        const controlledCanvas = $('<canvas />').addClass('royal-controlled-canvas');
        controlledContainer.append(controlledCanvas).css('z-index', configData.zindex || 0);
        if (scope === 'fullscreen') { controlledContainer.addClass('royal-particles-fullscreen'); $('body').prepend(controlledContainer); } 
        else { $scope.css('position', 'relative').prepend(controlledContainer); }
        $('body').append(libraryContainer);
        if (window.tsParticles && typeof window.tsParticles.load === 'function') {
            tsParticles.load({ id: libraryId, options: particlesOptions }).then(container => {
                if (!container || !container.canvas || !container.canvas.element) return;
                const libraryCanvas = container.canvas.element, controlledCtx = controlledCanvas[0].getContext('2d');
                function animate() {
                    if (!document.body.contains(controlledCanvas[0]) && !$scope[0].contains(controlledCanvas[0])) return;
                    try {
                        controlledCanvas[0].width = libraryCanvas.width; controlledCanvas[0].height = libraryCanvas.height;
                        controlledCtx.clearRect(0, 0, controlledCanvas[0].width, controlledCanvas[0].height);
                        controlledCtx.drawImage(libraryCanvas, 0, 0);
                        requestAnimationFrame(animate);
                    } catch (e) {}
                }
                requestAnimationFrame(animate);
            });
        }
    };

    // --- Main Unified Handler ---
    var RoyalBackgroundHandler = function ($scope) {
        var $dataSource = $scope.find('.royal-background-preview-wrapper').first();
        if (!$dataSource.length) {
            $dataSource = $scope;
        }
        
        handleCircles($scope, $dataSource);
        handleBlobs($scope, $dataSource);
        handleParticles($scope, $dataSource);
    };

    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/section', RoyalBackgroundHandler);
        elementorFrontend.hooks.addAction('frontend/element_ready/container', RoyalBackgroundHandler);
        elementorFrontend.hooks.addAction('frontend/element_ready/column', RoyalBackgroundHandler);
    });

})(jQuery);