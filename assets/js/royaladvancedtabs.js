(function ($) {
    "use strict";

    var RoyalAdvancedTabsHandler = function ($scope, $) {
        var $tabsWrapper = $scope.find('.royal-advanced-tabs-wrapper');
        if (!$tabsWrapper.length) {
            return;
        }

        var $navItems = $tabsWrapper.find('.royal-advanced-tabs-nav-item');
        var $contentPanes = $tabsWrapper.find('.royal-advanced-tabs-content-pane');
        var openEvent = $tabsWrapper.data('open-event') || 'click';

        function activateTab($tab) {
            if ($tab.hasClass('active')) {
                return;
            }

            var index = $tab.data('tab-index');

            // Remove active classes
            $navItems.removeClass('active').attr('aria-selected', 'false');
            $contentPanes.removeClass('active');

            // Set active tab
            $tab.addClass('active').attr('aria-selected', 'true');
            var $activePane = $tabsWrapper.find('.royal-advanced-tabs-content-pane[data-tab-index="' + index + '"]');
            $activePane.addClass('active');

            // Trigger Elementor JS for newly visible widgets (e.g. carousels, maps, sliders)
            if (typeof elementorFrontend !== 'undefined') {
                $activePane.find('.elementor-element').each(function () {
                    elementorFrontend.elementsHandler.runReadyTrigger($(this));
                });

                // Trigger resize so slick or swiper adapts to dimensions
                setTimeout(function() {
                    $(window).trigger('resize');
                }, 50);
            }
        }

        // Click trigger
        $navItems.on('click', function (e) {
            e.preventDefault();
            activateTab($(this));
        });

        // Hover trigger (if configured)
        if (openEvent === 'hover') {
            $navItems.on('mouseenter', function () {
                activateTab($(this));
            });
        }

        // Accessibility: Keyboard trigger (Enter or Space)
        $navItems.on('keydown', function (e) {
            if (e.which === 13 || e.which === 32) {
                e.preventDefault();
                activateTab($(this));
            }
        });
    };

    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/royaladvancedtabs.default', RoyalAdvancedTabsHandler);
    });

})(jQuery);
