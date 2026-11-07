/**
 * Royal Scroll To Top Widget - Frontend Handler
 * Modern features: Circular Progress, Smart Scroll Direction, Animations & Speed control
 */
(function ($) {
    'use strict';

    var RoyalScrollToTopHandler = function ($scope, $) {
        var $wrap = $scope.find('.royal-scroll-to-top-wrap');
        if (!$wrap.length) {
            $wrap = $('.royal-scroll-to-top-wrap');
        }
        if (!$wrap.length) {
            return;
        }

        var settings = $wrap.data('settings') || {};
        var offset = parseInt(settings.offset, 10) || 200;
        var duration = parseInt(settings.duration, 10) || 500;
        var smartDirection = settings.smart_direction === 'yes';
        var autoHide = settings.auto_hide === 'yes';
        var autoHideDelay = (parseInt(settings.auto_hide_delay, 10) || 3) * 1000;
        var clickAnim = settings.click_anim || 'none';
        var previewInEditor = settings.preview_in_editor === 'yes';

        var isEditMode = Boolean(
            (typeof elementorFrontend !== 'undefined' && elementorFrontend.isEditMode && elementorFrontend.isEditMode()) ||
            $('body').hasClass('elementor-editor-active')
        );

        if (isEditMode && previewInEditor) {
            $wrap.addClass('is-edit-mode royal-stt-visible').removeClass('royal-stt-hidden');
            // Allow clicking in editor preview without page jumping weirdly
            $wrap.find('.royal-scroll-to-top-btn').off('click.royalSttEdit').on('click.royalSttEdit', function (e) {
                e.preventDefault();
                $('html, body').animate({ scrollTop: 0 }, duration);
            });
            return;
        }

        var $btn = $wrap.find('.royal-scroll-to-top-btn');
        var $ringFill = $wrap.find('.royal-stt-ring-fill');
        var $percentText = $wrap.find('.royal-stt-percentage');

        var circumference = 0;
        if ($ringFill.length) {
            var r = parseFloat($ringFill.attr('r')) || 22;
            circumference = 2 * Math.PI * r;
            $ringFill.css({
                'stroke-dasharray': circumference,
                'stroke-dashoffset': circumference
            });
        }

        var lastScrollTop = 0;
        var autoHideTimer = null;
        var isLaunching = false;
        var ticking = false;

        function updateProgress(scrollTop, docHeight, winHeight) {
            var maxScroll = docHeight - winHeight;
            if (maxScroll <= 0) return 0;
            var progress = Math.min(Math.max(scrollTop / maxScroll, 0), 1);

            if ($ringFill.length && circumference > 0) {
                var offsetVal = circumference - (progress * circumference);
                $ringFill.css('stroke-dashoffset', offsetVal);
            }

            if ($percentText.length) {
                $percentText.text(Math.round(progress * 100) + '%');
            }

            return progress;
        }

        function onScroll() {
            var scrollTop = $(window).scrollTop();
            var docHeight = $(document).height();
            var winHeight = $(window).height();

            updateProgress(scrollTop, docHeight, winHeight);

            if (isLaunching) {
                // If rocket launched and user scrolls back down past 150px, reset
                if (scrollTop > 150) {
                    $wrap.removeClass('royal-stt-launching');
                    isLaunching = false;
                }
            }

            // Visibility decision
            if (scrollTop >= offset) {
                if (smartDirection) {
                    // Scrolling up -> show, scrolling down -> hide
                    if (scrollTop < lastScrollTop) {
                        $wrap.removeClass('royal-stt-hidden').addClass('royal-stt-visible');
                    } else if (scrollTop > lastScrollTop + 10) {
                        $wrap.removeClass('royal-stt-visible').addClass('royal-stt-hidden');
                    }
                } else {
                    $wrap.removeClass('royal-stt-hidden').addClass('royal-stt-visible');
                }

                // Auto-Hide on idle
                if (autoHide) {
                    clearTimeout(autoHideTimer);
                    autoHideTimer = setTimeout(function () {
                        if ($(window).scrollTop() >= offset) {
                            $wrap.removeClass('royal-stt-visible').addClass('royal-stt-hidden');
                        }
                    }, autoHideDelay);
                }
            } else {
                $wrap.removeClass('royal-stt-visible').addClass('royal-stt-hidden');
                clearTimeout(autoHideTimer);
            }

            lastScrollTop = scrollTop;
            ticking = false;
        }

        // Throttle with requestAnimationFrame for smooth performance
        $(window).off('scroll.royalScrollToTop_' + $wrap.attr('id')).on('scroll.royalScrollToTop_' + $wrap.attr('id'), function () {
            if (!ticking) {
                window.requestAnimationFrame(onScroll);
                ticking = true;
            }
        });

        // Click Handler
        $btn.off('click.royalScrollToTop').on('click.royalScrollToTop', function (e) {
            e.preventDefault();

            // Click Animations
            if (clickAnim === 'rocket-launch') {
                isLaunching = true;
                $wrap.addClass('royal-stt-launching');
            } else if (clickAnim === 'ripple') {
                var $ripple = $('<span class="royal-stt-click-ripple"></span>');
                var btnOffset = $btn.offset();
                var relX = e.pageX - btnOffset.left;
                var relY = e.pageY - btnOffset.top;
                $ripple.css({
                    top: relY + 'px',
                    left: relX + 'px',
                    width: '20px',
                    height: '20px'
                });
                $btn.append($ripple);
                setTimeout(function () {
                    $ripple.remove();
                }, 600);
            }

            // Perform Smooth Scroll
            $('html, body').stop().animate({ scrollTop: 0 }, duration, 'swing', function () {
                if (clickAnim === 'rocket-launch') {
                    setTimeout(function () {
                        $wrap.removeClass('royal-stt-visible').addClass('royal-stt-hidden');
                        $wrap.removeClass('royal-stt-launching');
                        isLaunching = false;
                    }, 200);
                }
            });

            return false;
        });

        // Initial check on load
        onScroll();
    };

    // Register with Elementor Frontend
    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/royalscrolltotop.default', RoyalScrollToTopHandler);
    });

    // Also run on DOM ready for standalone or direct placement
    $(document).ready(function () {
        if (typeof elementorFrontend === 'undefined' || !elementorFrontend.isEditMode()) {
            $('.royal-scroll-to-top-wrap').each(function () {
                RoyalScrollToTopHandler($(this).closest('.elementor-widget-royalscrolltotop'), $);
            });
        }
    });

})(jQuery);
