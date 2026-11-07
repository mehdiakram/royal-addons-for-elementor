'use strict';

( function ( $, w ) {
    
    var $window = $( w ); 

    $window.on( 'elementor/frontend/init', function() {

        var ModuleHandler = elementorModules.frontend.handlers.Base, 
        RoyalOverlay; 

        RoyalOverlay = ModuleHandler.extend( {

            onInit: function() {
                ModuleHandler.prototype.onInit.apply( this, arguments );
                if( this.isRoyalOverlay() ) {
                    this.$element.addClass( 'royal-has-background-overlay' );
                } 
            },

            isRoyalOverlay: function() {
                return ( this.getElementSettings( '_royal_overlay_use' ) === 'yes' );
            }, 

            onElementChange: function( changedProp ) {
                if( changedProp === '_royal_overlay_use' ) { 
                    if( 'yes' === this.getElementSettings( '_royal_overlay_use' ) ) this.$element.addClass( 'royal-has-background-overlay' ); 
                    else this.$element.removeClass( 'royal-has-background-overlay' );
                }
            }, 
            
        } );

        elementorFrontend.hooks.addAction( 'frontend/element_ready/widget', function( $scope ) {
            elementorFrontend.elementsHandler.addHandler( RoyalOverlay, { $element: $scope } );
        } );

    } ); 


} ( jQuery, window ) );