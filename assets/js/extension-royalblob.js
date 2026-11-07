(function ($) {
    'use strict';

    var RoyalBlobHandler = function ($scope) {
        var configString = $scope.attr('data-royal-blobs') || $scope.find('.royal-background-preview-wrapper').attr('data-royal-blobs');
        
        if (typeof configString === 'undefined' || configString === '') {
            $scope.find('.royal-blob-wrapper').remove();
            return;
        }

        var blobs;
        try { blobs = JSON.parse(configString); } catch (e) { return; }
        if (!blobs || blobs.length === 0) { $scope.find('.royal-blob-wrapper').remove(); return; }

        var $wrapper = $scope.find('.royal-blob-wrapper');
        if (!$wrapper.length) {
            $wrapper = $('<div class="royal-blob-wrapper"></div>');
            $scope.prepend($wrapper);
            $scope.css('position', 'relative');
        }
        
        $wrapper.empty();

        blobs.forEach(function (blobConfig) {
            var $blob = $('<div />').addClass('royal-blob-item elementor-repeater-item-' + blobConfig._id);
            
            var size = (blobConfig.royal_blob_size && blobConfig.royal_blob_size.size) ? blobConfig.royal_blob_size.size : 300;
            var h_offset = blobConfig.royal_blob_horizontal_offset;
            var v_offset = blobConfig.royal_blob_vertical_offset;
            var top_val = (v_offset && v_offset.size !== '' && v_offset.size !== null) ? v_offset.size : 0;
            var left_val = (h_offset && h_offset.size !== '' && h_offset.size !== null) ? h_offset.size : 0;
            var blurVal = (blobConfig.royal_blob_blur && blobConfig.royal_blob_blur.size !== undefined) ? blobConfig.royal_blob_blur.size : 0;

            $blob.css({
                width: size + 'px', height: size + 'px',
                top: top_val + (v_offset ? v_offset.unit || 'px' : 'px'),
                left: left_val + (h_offset ? h_offset.unit || 'px' : 'px'),
                zIndex: blobConfig.royal_blob_zindex || 0,
                opacity: (blobConfig.royal_blob_opacity && blobConfig.royal_blob_opacity.size !== undefined) ? blobConfig.royal_blob_opacity.size : 1,
                filter: blurVal > 0 ? 'blur(' + blurVal + 'px)' : 'none'
            });

            if (blobConfig.royal_blob_anim_mode === 'drift') {
                $blob.addClass('anim-drift').css('--drift-speed', (blobConfig.royal_blob_animation_duration || 18) + 's');
            }
            
            var svg = document.createElementNS("http://www.w3.org/2000/svg", "svg");
            svg.setAttribute('viewBox', '0 0 500 500');
            var path = document.createElementNS("http://www.w3.org/2000/svg", "path");
            path.setAttribute('fill', blobConfig.royal_blob_color || '#D1BCF5');

            function generateBlobPath(config) {
                var complexity = (config.royal_blob_complexity && config.royal_blob_complexity.size) ? config.royal_blob_complexity.size : 8;
                var contrast = (config.royal_blob_contrast && config.royal_blob_contrast.size !== undefined) ? config.royal_blob_contrast.size : 0.4;
                var smoothness = (config.royal_blob_smoothness && config.royal_blob_smoothness.size !== undefined) ? config.royal_blob_smoothness.size : 1;
                
                if (contrast < 0.01) {
                    var radius = 250; var center = 250;
                    return `M ${center}, ${center - radius} A ${radius},${radius} 0 1,1 ${center}, ${center + radius} A ${radius},${radius} 0 1,1 ${center}, ${center - radius} Z`;
                }

                var numPoints = complexity;
                var baseRadius = 220;
                var center = { x: 250, y: 250 };
                var randomSeed = Math.random() * 1000;

                var points = [];
                for (var i = 0; i < numPoints; i++) {
                    var angle = (i / numPoints) * Math.PI * 2;
                    var distortion = 1 + (Math.sin(angle * (complexity / 2) + randomSeed) * 0.5 + Math.cos(angle * (complexity / 3) + randomSeed) * 0.5) * contrast;
                    var currentRadius = baseRadius * distortion;
                    points.push({ x: center.x + Math.cos(angle) * currentRadius, y: center.y + Math.sin(angle) * currentRadius });
                }

                var pathData = "M" + points[0].x + "," + points[0].y;
                for (var i = 0; i < numPoints; i++) {
                    const p0 = points[(i - 1 + numPoints) % numPoints], p1 = points[i], p2 = points[(i + 1) % numPoints], p3 = points[(i + 2) % numPoints];
                    const cp1x = p1.x + (p2.x - p0.x) / 6 * smoothness, cp1y = p1.y + (p2.y - p0.y) / 6 * smoothness;
                    const cp2x = p2.x - (p3.x - p1.x) / 6 * smoothness, cp2y = p2.y - (p3.y - p1.y) / 6 * smoothness;
                    pathData += "C" + cp1x + "," + cp1y + " " + cp2x + "," + cp2y + " " + p2.x + "," + p2.y;
                }
                pathData += "Z"; return pathData;
            }
            
            path.setAttribute('d', generateBlobPath(blobConfig));
            svg.appendChild(path);
            $blob.append(svg);
            $wrapper.append($blob);

            var contrastValue = (blobConfig.royal_blob_contrast && blobConfig.royal_blob_contrast.size !== undefined) ? blobConfig.royal_blob_contrast.size : 0.4;
            if (blobConfig.royal_blob_anim_mode !== 'drift' && contrastValue > 0 && typeof anime !== 'undefined') {
                var animDuration = (blobConfig.royal_blob_animation_duration || 5) * 1000;
                function animatePath() {
                    anime({
                        targets: path,
                        d: { value: generateBlobPath(blobConfig), duration: animDuration, easing: 'easeInOutQuad', },
                        complete: animatePath
                    });
                }
                animatePath();
            }
        });
    };

    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/section', RoyalBlobHandler);
        elementorFrontend.hooks.addAction('frontend/element_ready/container', RoyalBlobHandler);
        elementorFrontend.hooks.addAction('frontend/element_ready/column', RoyalBlobHandler);
        elementorFrontend.hooks.addAction('frontend/element_ready/div-block', RoyalBlobHandler);
        elementorFrontend.hooks.addAction('frontend/element_ready/e-div-block', RoyalBlobHandler);
        elementorFrontend.hooks.addAction('frontend/element_ready/e-flexbox', RoyalBlobHandler);
    });

})(jQuery);
