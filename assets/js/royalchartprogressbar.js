"use strict";
;(function ($) {
  'use strict';
  var $window = $(window);
  $window.on('elementor/frontend/init', function () {

    var RoyalProgressBarHandler = function( $scope, $ ) {
    var $_this = $scope.find('.royalprogressbarwwarper');
    var $currentID      = '#'+$_this.attr('id'),
		$barclass 		= $currentID + ' .progressbar',
		$timer        	= $_this.data('timer'),

		$bars 	= $($barclass),
		total 	= $bars.length,
		index 	= -1,
		timer 	= null,
		select 	= function( i ) {
			var $bar = $bars.eq( i );
			$bar.css( "width", $bar.parent().data( "percent" ) );
			$bar.css( "width", $bar.data( "percent" ) + "%" );
			$bar.attr( "data-percent", $bar.data( "percent" ) + "%" );
			$( ".royalprogressbar" ).addClass( "completed" );		
		},
		action = function() {
			index++;
			if( index == total - 1 ) {
				clearTimeout( timer );
			}
			select( index );
			setTimeout( action, $timer);
				
		};
	timer = setTimeout( action, $timer);  
  }
  elementorFrontend.hooks.addAction('frontend/element_ready/royalchartprogressbar.default', RoyalProgressBarHandler);  
  
  });
})(jQuery);