(function($) {
    "use strict";

    var RoyalFeedViewerHandler = function($scope, $) {
        var feedContainer = $scope.find('.rt-feed-container');
        if (!feedContainer.length) {
            return;
        }
    };

    $(window).on('elementor/frontend/init', function() {
        elementorFrontend.hooks.addAction('frontend/element_ready/royalfeedviewer.default', RoyalFeedViewerHandler);
    });

}(jQuery));