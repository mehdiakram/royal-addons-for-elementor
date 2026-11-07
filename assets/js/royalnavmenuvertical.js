(function($) {
    var RoyalNavMenuVerticalHandler = function($scope) {
        var submenuVisibility = $scope.find('.royal-nav-menu-vertical').data('submenu-visibility');

        // Handle submenu click event for desktop
        $scope.on('click', '.royal-nav-menu-vertical-item.has-submenu > a', function(e) {
            e.preventDefault();
            e.stopPropagation();

            if (submenuVisibility === 'click') {
                var parentItem = $(this).parent('.royal-nav-menu-vertical-item');

                if (parentItem.hasClass('open')) {
                    parentItem.removeClass('open');
                } else {
                    // Close other open submenus before opening the new one
                    parentItem.siblings('.open').removeClass('open');
                    parentItem.addClass('open');
                }
            }
        });
    };

    $(window).on('elementor/frontend/init', function() {
        elementorFrontend.hooks.addAction('frontend/element_ready/royalnavmenuvertical.default', RoyalNavMenuVerticalHandler);
    });
})(jQuery);