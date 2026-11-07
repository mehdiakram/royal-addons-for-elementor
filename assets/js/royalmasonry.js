(function($) {
    var RoyalMasonryHandler = function($scope, $) {
    // Make sure we run this code under Elementor
        var $_this          = $scope.find('.royalinfinitescroll');
        let scrollid        = '#'+$_this.attr('id');
        let royalscroll     = document.querySelector(scrollid);

        var container_masonry = $scope.find('.royalmasonry-grid').eq(0);
        if ( container_masonry.length > 0 ){
            container_masonry.imagesLoaded(function() {
                container_masonry.masonry({
                    itemSelector: '.royalmasonry-item',
                    columnWidth: '.royalmasonry-sizer',
                });
            });
        }
    // Make sure we run this code under Elementor
    };
    $(window).on('elementor/frontend/init', function() {
        elementorFrontend.hooks.addAction('frontend/element_ready/royalimagegrid.default', RoyalMasonryHandler);
    });
})(jQuery);