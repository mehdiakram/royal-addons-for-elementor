(function($) {
    var RoyalIsotopelHandler = function($scope, $) {
        var $_this          = $scope.find('.royalisotope');
        let isotopeid       = '#'+$_this.attr('id');
        
        let filter          = isotopeid +' .filter-button-group';
        let filterli        = isotopeid +' .filter-button-group li';
        let grid            = isotopeid +' .royalisotopegrid';
        let itemSelector    = isotopeid +' .royalisotopegrid .royalisotopeitem';

        var $grid = $(grid).isotope({
            itemSelector: itemSelector,
            percentPosition: true,
            masonry: {
                columnWidth: itemSelector
            }
        });

        if (typeof $.fn.imagesLoaded === 'function') {
            $(grid).imagesLoaded().progress(function() {
                $grid.isotope('layout');
            });
        }

        $(filter).off('click', 'li').on( 'click', 'li', function(e) {
            e.preventDefault();
            var filterValue = $(this).attr('data-filter');
            $grid.isotope({
                filter: filterValue
            });
            $(filterli).removeClass('active');
            $(this).addClass('active');
        });
    };

    $(window).on('elementor/frontend/init', function() {
        elementorFrontend.hooks.addAction('frontend/element_ready/royalimagegrid.default', RoyalIsotopelHandler);
        elementorFrontend.hooks.addAction('frontend/element_ready/royalpostfilterable.default', RoyalIsotopelHandler);
    });
})(jQuery);
