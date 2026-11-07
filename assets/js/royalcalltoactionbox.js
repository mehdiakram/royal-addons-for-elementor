/* Royal Call To Action Box Start ---------------------------------*/
(function($) {
    var RoyalCallToActionBoxHandler = function($scope, $) {
        var deviceAgent = navigator.userAgent.toLowerCase();
		var detechMobile = deviceAgent.match(/(iphone|ipod|ipad)/);
        var hover = $scope.find('.royalctabox');
		if (detechMobile) {
            if ($(hover).hasClass('royalctabox-hover')) {
                $(hover).hover(
                    function(e) {
                        $(this).attr('onclick', 'void(0);');
                    },
                    function(e) {
                        $(this).removeAttr('onclick');
                    }
                );

            }
        }
    };

    // Make sure you run this code under Elementor..
    $(window).on('elementor/frontend/init', function() {
        elementorFrontend.hooks.addAction('frontend/element_ready/royalcalltoactionbox.default', RoyalCallToActionBoxHandler);
    });
})(jQuery);

/*Royal Call To Action Box END ---------------------------------*/