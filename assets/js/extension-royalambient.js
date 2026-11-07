(function ($) {
    'use strict';

    var RoyalAmbientHandler = function ($scope) {
        var $target = $scope;
        var configString = $scope.attr('data-royal-ambient') || 
                           $scope.find('.royal-background-preview-wrapper').attr('data-royal-ambient') ||
                           $scope.find('[data-royal-ambient]').attr('data-royal-ambient');

        // Check if wrapper already exists
        var $wrapper = $scope.children('.royal-background-ambient-wrapper');

        if (typeof configString === 'undefined' || !configString) {
            if ($wrapper.length) $wrapper.remove();
            return;
        }

        var config;
        try {
            config = typeof configString === 'object' ? configString : JSON.parse(configString);
        } catch (e) {
            return;
        }

        if (!config) {
            if ($wrapper.length) $wrapper.remove();
            return;
        }

        if (!$wrapper.length) {
            $wrapper = $('<div class="royal-background-ambient-wrapper"></div>');
            $scope.prepend($wrapper);
            if ($scope.css('position') === 'static') {
                $scope.css('position', 'relative');
            }
            if ($scope.css('overflow') !== 'hidden') {
                $scope.css('overflow', 'hidden');
            }
        }

        $wrapper.empty();

        // Mobile disable
        if (config.disableMobile) {
            $wrapper.addClass('disable-on-mobile');
        } else {
            $wrapper.removeClass('disable-on-mobile');
        }

        if (typeof config.zIndex !== 'undefined') {
            $wrapper.css('--royal-ambient-zindex', config.zIndex);
        }

        var style = config.style || 'corner_rings';

        // ── Helper: Render Corner Rings (All 4 Corners: TL, TR, BL, BR) ──
        function renderCornerRings() {
            var preset = config.corner_preset || 'opposite_tr_bl';

            // 1. Top-Left Ring (TL)
            var showTL = false;
            if (preset === 'all_4' || preset === 'opposite_tl_br' || preset === 'top_both') {
                showTL = true;
            } else if (preset === 'custom') {
                showTL = (config.tl_enable === 'yes' || config.tl_enable === true);
            }

            if (showTL) {
                var tlSize = (config.tl_size && config.tl_size.size) ? config.tl_size.size : (config.tl_size || 280);
                var tlTop = (config.tl_top && typeof config.tl_top.size !== 'undefined') ? config.tl_top.size : (typeof config.tl_top !== 'undefined' ? config.tl_top : -120);
                var tlLeft = (config.tl_left && typeof config.tl_left.size !== 'undefined') ? config.tl_left.size : (typeof config.tl_left !== 'undefined' ? config.tl_left : -80);
                var tlBw = (config.tl_border_width && config.tl_border_width.size) ? config.tl_border_width.size : (config.tl_border_width || 2);
                var tlSpeed = config.tl_speed || 35;
                var tlDir = config.tl_direction || 'reverse';
                var tlAnim = config.tl_anim || 'spin';

                var $tl = $('<div class="royal-ambient-ring tl"></div>').addClass(tlAnim === 'pulse' ? 'anim-spin-pulse' : 'anim-spin').css({
                    width: tlSize + 'px',
                    height: tlSize + 'px',
                    top: tlTop + 'px',
                    left: tlLeft + 'px',
                    borderColor: config.tl_color || config.r1_color || 'rgba(255, 255, 255, 0.16)',
                    borderStyle: config.tl_border_style || 'dashed',
                    borderWidth: tlBw + 'px',
                    '--spin-speed': tlSpeed + 's'
                });
                if (tlDir === 'reverse') $tl.addClass('anim-reverse');
                $wrapper.append($tl);
            }

            // 2. Top-Right Ring (TR / R1)
            var showTR = false;
            if (!config.corner_preset || preset === 'all_4' || preset === 'opposite_tr_bl' || preset === 'top_both') {
                showTR = true;
            } else if (preset === 'custom') {
                showTR = (config.tr_enable === 'yes' || config.tr_enable === true || config.r1_enable === 'yes' || config.r1_enable === true);
            }

            if (showTR) {
                var trSize = (config.tr_size && config.tr_size.size) ? config.tr_size.size : (config.r1_size && config.r1_size.size ? config.r1_size.size : (config.tr_size || config.r1_size || 320));
                var trTop = (config.tr_top && typeof config.tr_top.size !== 'undefined') ? config.tr_top.size : (config.r1_top && typeof config.r1_top.size !== 'undefined' ? config.r1_top.size : (typeof config.tr_top !== 'undefined' ? config.tr_top : (typeof config.r1_top !== 'undefined' ? config.r1_top : -140)));
                var trRight = (config.tr_right && typeof config.tr_right.size !== 'undefined') ? config.tr_right.size : (config.r1_right && typeof config.r1_right.size !== 'undefined' ? config.r1_right.size : (typeof config.tr_right !== 'undefined' ? config.tr_right : (typeof config.r1_right !== 'undefined' ? config.r1_right : -100)));
                var trBw = (config.tr_border_width && config.tr_border_width.size) ? config.tr_border_width.size : (config.r1_border_width && config.r1_border_width.size ? config.r1_border_width.size : (config.tr_border_width || config.r1_border_width || 2));
                var trSpeed = config.tr_speed || config.r1_speed || 40;
                var trDir = config.tr_direction || config.r1_direction || 'normal';
                var trAnim = config.tr_anim || 'spin';

                var $tr = $('<div class="royal-ambient-ring tr r1"></div>').addClass(trAnim === 'pulse' ? 'anim-spin-pulse' : 'anim-spin').css({
                    width: trSize + 'px',
                    height: trSize + 'px',
                    top: trTop + 'px',
                    right: trRight + 'px',
                    borderColor: config.tr_color || config.r1_color || 'rgba(255, 255, 255, 0.16)',
                    borderStyle: config.tr_border_style || config.r1_border_style || 'dashed',
                    borderWidth: trBw + 'px',
                    '--spin-speed': trSpeed + 's'
                });
                if (trDir === 'reverse') $tr.addClass('anim-reverse');
                $wrapper.append($tr);
            }

            // 3. Bottom-Left Ring (BL / R2)
            var showBL = false;
            if (!config.corner_preset || preset === 'all_4' || preset === 'opposite_tr_bl' || preset === 'bottom_both') {
                showBL = true;
            } else if (preset === 'custom') {
                showBL = (config.bl_enable === 'yes' || config.bl_enable === true || config.r2_enable === 'yes' || config.r2_enable === true);
            }

            if (showBL) {
                var blSize = (config.bl_size && config.bl_size.size) ? config.bl_size.size : (config.r2_size && config.r2_size.size ? config.r2_size.size : (config.bl_size || config.r2_size || 220));
                var blBottom = (config.bl_bottom && typeof config.bl_bottom.size !== 'undefined') ? config.bl_bottom.size : (config.r2_bottom && typeof config.r2_bottom.size !== 'undefined' ? config.r2_bottom.size : (typeof config.bl_bottom !== 'undefined' ? config.bl_bottom : (typeof config.r2_bottom !== 'undefined' ? config.r2_bottom : -100)));
                var blLeft = (config.bl_left && typeof config.bl_left.size !== 'undefined') ? config.bl_left.size : (config.r2_left && typeof config.r2_left.size !== 'undefined' ? config.r2_left.size : (typeof config.bl_left !== 'undefined' ? config.bl_left : (typeof config.r2_left !== 'undefined' ? config.r2_left : -70)));
                var blBw = (config.bl_border_width && config.bl_border_width.size) ? config.bl_border_width.size : (config.r2_border_width && config.r2_border_width.size ? config.r2_border_width.size : (config.bl_border_width || config.r2_border_width || 2));
                var blSpeed = config.bl_speed || config.r2_speed || 40;
                var blDir = config.bl_direction || config.r2_direction || 'reverse';
                var blAnim = config.bl_anim || 'spin';

                var $bl = $('<div class="royal-ambient-ring bl r2"></div>').addClass(blAnim === 'pulse' ? 'anim-spin-pulse' : 'anim-spin').css({
                    width: blSize + 'px',
                    height: blSize + 'px',
                    bottom: blBottom + 'px',
                    left: blLeft + 'px',
                    borderColor: config.bl_color || config.r2_color || 'rgba(255, 255, 255, 0.16)',
                    borderStyle: config.bl_border_style || config.r2_border_style || 'dashed',
                    borderWidth: blBw + 'px',
                    '--spin-speed': blSpeed + 's'
                });
                if (blDir === 'reverse') $bl.addClass('anim-reverse');
                $wrapper.append($bl);
            }

            // 4. Bottom-Right Ring (BR)
            var showBR = false;
            if (preset === 'all_4' || preset === 'opposite_tl_br' || preset === 'bottom_both') {
                showBR = true;
            } else if (preset === 'custom') {
                showBR = (config.br_enable === 'yes' || config.br_enable === true);
            }

            if (showBR) {
                var brSize = (config.br_size && config.br_size.size) ? config.br_size.size : (config.br_size || 300);
                var brBottom = (config.br_bottom && typeof config.br_bottom.size !== 'undefined') ? config.br_bottom.size : (typeof config.br_bottom !== 'undefined' ? config.br_bottom : -120);
                var brRight = (config.br_right && typeof config.br_right.size !== 'undefined') ? config.br_right.size : (typeof config.br_right !== 'undefined' ? config.br_right : -90);
                var brBw = (config.br_border_width && config.br_border_width.size) ? config.br_border_width.size : (config.br_border_width || 2);
                var brSpeed = config.br_speed || 32;
                var brDir = config.br_direction || 'normal';
                var brAnim = config.br_anim || 'spin';

                var $br = $('<div class="royal-ambient-ring br"></div>').addClass(brAnim === 'pulse' ? 'anim-spin-pulse' : 'anim-spin').css({
                    width: brSize + 'px',
                    height: brSize + 'px',
                    bottom: brBottom + 'px',
                    right: brRight + 'px',
                    borderColor: config.br_color || config.r2_color || 'rgba(255, 255, 255, 0.16)',
                    borderStyle: config.br_border_style || 'dashed',
                    borderWidth: brBw + 'px',
                    '--spin-speed': brSpeed + 's'
                });
                if (brDir === 'reverse') $br.addClass('anim-reverse');
                $wrapper.append($br);
            }
        }

        // ── Helper: Render Drifting Blobs ──
        function renderDriftingBlobs(isHero) {
            var driftDist = (config.drift_distance && config.drift_distance.size) ? config.drift_distance.size : (config.drift_distance || 60);

            // Blob 1
            var b1Size = (config.b1_size && config.b1_size.size) ? config.b1_size.size : (config.b1_size || (isHero ? 340 : 420));
            var b1Top = (config.b1_top && typeof config.b1_top.size !== 'undefined') ? config.b1_top.size : (typeof config.b1_top !== 'undefined' ? config.b1_top : (isHero ? -90 : -140));
            var b1Left = (config.b1_left && typeof config.b1_left.size !== 'undefined') ? config.b1_left.size : (typeof config.b1_left !== 'undefined' ? config.b1_left : (isHero ? -70 : -120));
            var b1Blur = (config.b1_blur && typeof config.b1_blur.size !== 'undefined') ? config.b1_blur.size : (typeof config.b1_blur !== 'undefined' ? config.b1_blur : (isHero ? 70 : 0));
            var b1Opacity = (config.b1_opacity && typeof config.b1_opacity.size !== 'undefined') ? config.b1_opacity.size : (typeof config.b1_opacity !== 'undefined' ? config.b1_opacity : (isHero ? 0.4 : 1));
            var b1Speed = config.b1_speed || (isHero ? 14 : 18);
            var b1Color = config.b1_color || (isHero ? '#bfe3cb' : 'rgba(25, 135, 84, 0.12)');

            var $b1 = $('<div class="royal-ambient-blob b1 anim-drift-1"></div>').css({
                width: b1Size + 'px',
                height: b1Size + 'px',
                top: b1Top + 'px',
                left: b1Left + 'px',
                background: b1Color,
                filter: b1Blur > 0 ? 'blur(' + b1Blur + 'px)' : 'none',
                opacity: b1Opacity,
                animationDuration: b1Speed + 's',
                '--drift-x': driftDist + 'px',
                '--drift-y': Math.round(driftDist * 0.67) + 'px'
            });

            // Blob 2
            var b2Size = (config.b2_size && config.b2_size.size) ? config.b2_size.size : (config.b2_size || (isHero ? 300 : 320));
            var b2Bottom = (config.b2_bottom && typeof config.b2_bottom.size !== 'undefined') ? config.b2_bottom.size : (typeof config.b2_bottom !== 'undefined' ? config.b2_bottom : (isHero ? -80 : -90));
            var b2Right = (config.b2_right && typeof config.b2_right.size !== 'undefined') ? config.b2_right.size : (typeof config.b2_right !== 'undefined' ? config.b2_right : (isHero ? -40 : -80));
            var b2Blur = (config.b2_blur && typeof config.b2_blur.size !== 'undefined') ? config.b2_blur.size : (typeof config.b2_blur !== 'undefined' ? config.b2_blur : (isHero ? 70 : 0));
            var b2Opacity = (config.b2_opacity && typeof config.b2_opacity.size !== 'undefined') ? config.b2_opacity.size : (typeof config.b2_opacity !== 'undefined' ? config.b2_opacity : (isHero ? 0.4 : 1));
            var b2Speed = config.b2_speed || (isHero ? 17 : 20);
            var b2Color = config.b2_color || (isHero ? '#f3e2b3' : 'rgba(25, 135, 84, 0.10)');

            var $b2 = $('<div class="royal-ambient-blob b2 anim-drift-2"></div>').css({
                width: b2Size + 'px',
                height: b2Size + 'px',
                bottom: b2Bottom + 'px',
                right: b2Right + 'px',
                background: b2Color,
                filter: b2Blur > 0 ? 'blur(' + b2Blur + 'px)' : 'none',
                opacity: b2Opacity,
                animationDuration: b2Speed + 's',
                '--drift-x': driftDist + 'px',
                '--drift-y': Math.round(driftDist * 0.67) + 'px'
            });

            $wrapper.append($b1).append($b2);
        }

        // ── Helper: Render Dot Grid ──
        function renderDotGrid() {
            var dotColor = config.dot_color || 'rgba(11, 77, 38, 0.12)';
            var dotSize = (config.dot_size && config.dot_size.size) ? config.dot_size.size : (config.dot_size || 1.5);
            var dotGap = (config.dot_gap && config.dot_gap.size) ? config.dot_gap.size : (config.dot_gap || 26);
            var dotOpacity = (config.dot_opacity && typeof config.dot_opacity.size !== 'undefined') ? config.dot_opacity.size : (typeof config.dot_opacity !== 'undefined' ? config.dot_opacity : 1);
            var hasVignette = config.dot_vignette !== false && config.dot_vignette !== 'no';
            var animDrift = config.dot_anim !== false && config.dot_anim !== 'no';

            var $dots = $('<div class="royal-ambient-dots"></div>').css({
                '--dot-color': dotColor,
                '--dot-size': dotSize + 'px',
                '--dot-gap': dotGap + 'px',
                '--dot-opacity': dotOpacity
            });

            if (hasVignette) $dots.addClass('has-vignette');
            if (animDrift) $dots.addClass('anim-drift');
            $wrapper.append($dots);
        }

        // ── Helper: Render Rising Bubbles ──
        function renderRisingBubbles() {
            var bubbleSpeed = (config.bubble_speed && config.bubble_speed.size) ? config.bubble_speed.size : (config.bubble_speed || 10);
            var bubbleDist = (config.bubble_dist && config.bubble_dist.size) ? config.bubble_dist.size : (config.bubble_dist || 26);
            var c1 = config.bubble_c1 || 'rgba(31, 163, 90, 0.18)';
            var c2 = config.bubble_c2 || 'rgba(255, 193, 7, 0.35)';
            var c3 = config.bubble_c3 || 'rgba(13, 110, 253, 0.15)';

            var bubblesData = [
                { width: 22, height: 22, top: '28%', right: '7%', color: c1, delay: '0s', speed: bubbleSpeed },
                { width: 14, height: 14, top: '56%', left: '5%', color: c2, delay: '1.2s', speed: (bubbleSpeed * 1.15) },
                { width: 30, height: 30, bottom: '14%', right: '12%', color: c3, delay: '2.4s', speed: (bubbleSpeed * 1.3) }
            ];

            bubblesData.forEach(function (b, idx) {
                var cssProps = {
                    width: b.width + 'px',
                    height: b.height + 'px',
                    background: b.color,
                    '--bubble-speed': b.speed + 's',
                    '--bubble-dist': '-' + bubbleDist + 'px',
                    animationDelay: b.delay
                };
                if (b.top) cssProps.top = b.top;
                if (b.bottom) cssProps.bottom = b.bottom;
                if (b.left) cssProps.left = b.left;
                if (b.right) cssProps.right = b.right;

                var $bubble = $('<div class="royal-ambient-bubble royal-ambient-bubble-' + (idx + 1) + '"></div>').css(cssProps);
                $wrapper.append($bubble);
            });
        }

        // ── Switch Styles ──
        switch (style) {
            case 'corner_rings':
                renderCornerRings();
                break;
            case 'soft_spheres':
                renderDriftingBlobs(false);
                break;
            case 'hero_blobs':
                renderDriftingBlobs(true);
                break;
            case 'dot_grid':
                renderDotGrid();
                break;
            case 'rising_bubbles':
                renderRisingBubbles();
                break;
            case 'combined':
                renderDotGrid();
                renderDriftingBlobs(false);
                renderCornerRings();
                renderRisingBubbles();
                break;
            default:
                renderCornerRings();
                break;
        }
    };

    // Initialize across Elementor hooks
    $(window).on('elementor/frontend/init', function () {
        var elements = ['section', 'container', 'column', 'div-block', 'e-div-block', 'e-flexbox'];
        elements.forEach(function (el) {
            elementorFrontend.hooks.addAction('frontend/element_ready/' + el, RoyalAmbientHandler);
        });

        // Global fallback for editor preview changes
        if (window.elementorFrontend && window.elementorFrontend.hooks) {
            window.elementorFrontend.hooks.addAction('frontend/element_ready/global', function ($el) {
                var $w = $el.find('[data-royal-ambient]');
                if ($w.length) {
                    RoyalAmbientHandler($el);
                } else if ($el.attr('data-royal-ambient')) {
                    RoyalAmbientHandler($el);
                }
            });
        }
    });

})(jQuery);
