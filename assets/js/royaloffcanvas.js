(function ($) {
    "use strict";

    var RoyalOffCanvasHandler = function ($scope, $) {
        var $btn = $scope.find('.royal-offcanvas-btn');
        var panelId = $btn.data('target');
        var $panel = $('#' + panelId);
        var $overlay = $('#overlay-' + panelId);
        var $closeBtn = $panel.find('.royal-offcanvas-close');

        if (!$panel.length) {
            return;
        }

        // Open Panel
        $btn.on('click', function (e) {
            e.preventDefault();
            $panel.addClass('royal-open');
            $overlay.addClass('royal-open');
            $('body').addClass('royal-offcanvas-active');
        });

        // Close Panel
        var closePanel = function () {
            $panel.removeClass('royal-open');
            $overlay.removeClass('royal-open');
            $('body').removeClass('royal-offcanvas-active');
        };

        $closeBtn.on('click', function (e) {
            e.preventDefault();
            closePanel();
        });

        $overlay.on('click', function () {
            closePanel();
        });

        // Close on Escape key
        $(document).keyup(function(e) {
            if (e.key === "Escape" && $panel.hasClass('royal-open')) {
                closePanel();
            }
        });
    };

    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/royaloffcanvas.default', RoyalOffCanvasHandler);
    });

})(jQuery);
