(function($) {
    'use strict';

    var RoyalInfiniteScrollHandler = function($scope, $) {
        var $scroller = $scope.find('.royalinfinitescroll');
        if (!$scroller.length) {
            return;
        }

        var duration = parseFloat($scroller.data('duration')) || 28;

        // Dynamic container width calculation for responsive items_to_show
        var updateContainerWidth = function() {
            if ($scroller[0]) {
                var width = $scroller[0].offsetWidth;
                if (width > 0) {
                    $scroller[0].style.setProperty('--royal-container-width', width + 'px');
                }
            }
        };
        updateContainerWidth();

        if (window.ResizeObserver) {
            var ro = new ResizeObserver(function() {
                updateContainerWidth();
            });
            ro.observe($scroller[0]);
        } else {
            $(window).on('resize.royalScroll' + $scroller.attr('id'), updateContainerWidth);
        }

        $scroller.find('.scrollerinner').each(function() {
            var scrollerInner = this;

            // Update duration dynamically
            scrollerInner.style.setProperty('--animation-duration', duration + 's');

            // Prevent duplicate cloning when Elementor re-runs handlers on edit
            if (scrollerInner.dataset && scrollerInner.dataset.royalCloned === 'true') {
                return;
            }

            // Accessibility: Respect reduced motion preference
            if (window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
                return;
            }

            var originalChildren = Array.from(scrollerInner.children);
            if (!originalChildren.length) {
                return;
            }

            // Seamless infinite loop math:
            // - 1 clone set = 2 sets total. Moving -50% moves exactly 1 full set (1/2 = 50%).
            // - 3 clone sets = 4 sets total. Moving -50% moves exactly 2 full sets (2/4 = 50%).
            // Both are mathematically seamless with zero glitch or jump.
            var cloneMultiplier = (originalChildren.length < 6) ? 3 : 1;

            for (var c = 0; c < cloneMultiplier; c++) {
                originalChildren.forEach(function(item) {
                    var clone = item.cloneNode(true);
                    clone.setAttribute('aria-hidden', 'true');
                    scrollerInner.appendChild(clone);
                });
            }

            if (scrollerInner.dataset) {
                scrollerInner.dataset.royalCloned = 'true';
            }
        });
    };

    $(window).on('elementor/frontend/init', function() {
        elementorFrontend.hooks.addAction('frontend/element_ready/royalinfinitescroll.default', RoyalInfiniteScrollHandler);
    });
})(jQuery);
