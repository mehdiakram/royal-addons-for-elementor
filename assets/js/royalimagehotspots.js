(function($) {
    var RoyalImageHotspotsHandler = function($scope, $) {
    // Make sure we run this code under Elementor
        var $imgHotspots = $scope.find( '.royalimage-hotspots' ),
				hotspotsOptions = $imgHotspots.data('options'),
				$hotspotItem = $imgHotspots.find('.royalhotspot-item'),
				tooltipTrigger = hotspotsOptions.tooltipTrigger;

			if ( 'click' === tooltipTrigger ) {
				$hotspotItem.on( 'click', function() {
					if ( $(this).hasClass('royaltooltip-active') ) {
						$(this).removeClass('royaltooltip-active');
					} else {
						$hotspotItem.removeClass('royaltooltip-active');
						$(this).addClass('royaltooltip-active');
					}
					 event.stopPropagation();
				});

				$(window).on( 'click', function () {
					$hotspotItem.removeClass('royaltooltip-active');
				});
		   
			} else if ( 'hover' === tooltipTrigger ) {
				$hotspotItem.on( 'mouseenter', function () {
					$(this).addClass('royaltooltip-active');
				});
				
				$hotspotItem.on( 'mouseleave', function () {
					$(this).removeClass('royaltooltip-active');
				});

			} else {
				$hotspotItem.addClass('royaltooltip-active');
			}
  
    
    // Make sure we run this code under Elementor
    };
    $(window).on('elementor/frontend/init', function() {
        elementorFrontend.hooks.addAction('frontend/element_ready/royalimagehotspots.default', RoyalImageHotspotsHandler);
    });
})(jQuery);