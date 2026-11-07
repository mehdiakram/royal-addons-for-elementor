(function($) {
    'use strict';

    var RoyalMagnificPopupHandler = function($scope, $) {
        var $gridContainer = $scope.find('.royal-youtube-channel');

        if (!$gridContainer.length) {
            return;
        }

        $gridContainer.magnificPopup({
            delegate: 'a.royalvideo-popup', // Target links with this class for popup
            type: 'iframe',               // Set general type to iframe for videos
            mainClass: 'mfp-fade',
            removalDelay: 160,
            preloader: false,
            fixedContentPos: true,

            iframe: {
                patterns: {
                    youtube: {
                        // This matches the base of your embed URL from PHP
                        index: 'https://www.youtube.com/embed/2',
                        id: function(url) {
                            // This simply returns the full URL from the href, as PHP has already formatted it.
                            return url;
                        },
                        // This tells Magnific Popup to use the full URL from 'id' as the iframe source.
                        src: '%id%'
                    }
                },
                markup: '<div class="mfp-iframe-scaler">' +
                            '<div class="mfp-close"></div>' +
                            '<iframe class="mfp-iframe" frameborder="0" allowfullscreen allow="autoplay"></iframe>' +
                        '</div>',
                srcAction: 'iframe_src',
            },
            // elementParse is no longer needed here if PHP correctly provides the full URL
            callbacks: {
                open: function() {
                    $('body').addClass('mfp-active');
                },
                close: function() {
                    $('body').removeClass('mfp-active');
                }
            }
        });
    };

    $(window).on('elementor/frontend/init', function() {
        // Ensure this hook name is correct for your 'RoyalYouTubeChannel' widget
        elementorFrontend.hooks.addAction('frontend/element_ready/royalyoutubechannel.default', RoyalMagnificPopupHandler);
    });

})(jQuery);