(function ($) {
    var RoyalFilterableHandler = function( $scope, $ ) {
        if ( typeof $.fn.isotope !== 'function' ) {
            return;
        }

        var $container = $scope.find( '.royalisotopegrid' );
        var $filter    = $scope.find( '.filter-button-group' );

        if ( !$container.length ) {
            return;
        }

        var $grid = $container.isotope({
            itemSelector: '.royalisotopeitem',
            percentPosition: true,
            layoutMode: 'masonry',
            animationOptions: {
                duration: 400,
                easing: 'linear',
                queue: false
            }
        });

        if ( typeof $.fn.imagesLoaded === 'function' ) {
            $container.imagesLoaded().progress( function() {
                $grid.isotope('layout');
            });
        }

        $filter.off('click', 'li').on( 'click', 'li', function(e) {
            e.preventDefault();
            $filter.find('li').removeClass( 'active current' );
            $( this ).addClass( 'active current' );
            var selector = $( this ).attr( 'data-filter' );
            $grid.isotope({
                filter: selector
            });
            return false;
        });
    };

    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/royalpostfilterable.default', RoyalFilterableHandler);
    });
})(jQuery);
