(function($) {
    var RoyalMagnificPopupHandler = function($scope, $) {
        var $widget = $scope.find('.royalisotope');

        // ID check
        if (!$widget.length || typeof $widget.attr('id') === 'undefined') {
            return;
        }

        var magnificId = '#' + $widget.attr('id');
        var container = document.querySelector(magnificId);
        if (!container) return;

        var grid = container.querySelector(".royalpopup-gallery");
        if (!grid) return;

        $(grid).magnificPopup({
            delegate: 'a:not(.royalexternal-link)',
            type: 'image',
            tLoading: 'Loading content #%curr%...',
            mainClass: 'mfp-img-mobile',
            gallery: {
                enabled: true,
                navigateByImgClick: true,
                preload: [0, 1]
            },
            image: {
                tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
            },
            iframe: {
                patterns: {
                    youtube: {
                        index: 'youtube.com/', // Can also support youtu.be
                        id: function(url) {
                            return url; // Return full embed URL
                        },
                        src: '%id%'
                    }
                }
            },
            callbacks: {
                elementParse: function(item) {
                    if (item.el.hasClass('royalvideo-popup')) {
                        item.type = 'iframe';
                    } else {
                        item.type = 'image';
                    }
                }
            }
        });
    };

    $(window).on('elementor/frontend/init', function() {
        elementorFrontend.hooks.addAction('frontend/element_ready/royalyoutubevideo.default', RoyalMagnificPopupHandler);
    });
})(jQuery);
