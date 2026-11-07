'use strict';

( function ( $, w ) {
    
    var $window = $( w ); 

    $window.on( 'elementor/frontend/init', function() {

        var ModuleHandler = elementorModules.frontend.handlers.Base, 
        RoyalTextUpset; 

        RoyalTextUpset = ModuleHandler.extend( {

            onInit: function() {
                ModuleHandler.prototype.onInit.apply( this, arguments );
                if( this.isEnabled() ) {
                    this.$element.addClass( 'royal-textupset' );
                    this.applyAtomicStyles();
                    if( 'clip' === this.getElementSettings( '_royaltextupset_text_clip' ) ) {
                        this.updateCSS( 'add' );
                    }
                } 
            },

            isEnabled: function() {
                return ( this.getElementSettings( '_ob_use_harakiri' ) === 'yes' );
            }, 

            onElementChange: function( changedProp ) {
                if( changedProp === '_ob_use_harakiri' ) {
                    if( this.isEnabled() ) {
                        this.$element.addClass( 'royal-textupset' );
                        this.applyAtomicStyles();
                    } else {
                        this.$element.removeClass( 'royal-textupset' );
                        this.removeAtomicStyles();
                    }
                }
                
                if( changedProp.indexOf('_ob_harakiri_') === 0 ) {
                    if( this.isEnabled() ) {
                        this.applyAtomicStyles();
                    }
                }

                if( changedProp === '_royaltextupset_text_clip' ) { 
                    if( 'clip' === this.getElementSettings( '_royaltextupset_text_clip' ) ) {
                        this.updateCSS( 'add' );
                    } else {
                        this.updateCSS( 'remove' );
                    }
                }
            }, 
            
            applyAtomicStyles: function() {
                var isAtomic = this.$element.hasClass('e-con') || this.$element.hasClass('e-container') || this.$element[0].tagName.toLowerCase().startsWith('e-');
                
                // For atomic widgets, we manually apply the CSS because Elementor's CSS generator
                // may not process classic controls hooked to atomic widgets in the same way.
                // We also apply it for classic widgets to ensure consistency in editor.
                var $target = this.$element;
                var $inner = this.$element.find('.elementor-widget-container');
                if ($inner.length) {
                    $target = $inner;
                }
                
                var writingMode = this.getElementSettings('_ob_harakiri_writing_mode');
                var flip = this.getElementSettings('_ob_harakiri_make_inline');
                var mixBlend = this.getElementSettings('_ob_harakiri_mix_blend');
                
                if (writingMode && writingMode !== 'inherit') {
                    $target.css('writing-mode', writingMode);
                } else {
                    $target.css('writing-mode', '');
                }
                
                if (flip === 'yes') {
                    $target.css('transform', 'rotate(180deg)');
                } else {
                    $target.css('transform', '');
                }
                
                if (mixBlend && mixBlend !== 'inherit') {
                    $target.css('mix-blend-mode', mixBlend);
                } else {
                    $target.css('mix-blend-mode', '');
                }
            },
            
            removeAtomicStyles: function() {
                var $target = this.$element;
                var $inner = this.$element.find('.elementor-widget-container');
                if ($inner.length) {
                    $target = $inner;
                }
                $target.css('writing-mode', '');
                $target.css('transform', '');
                $target.css('mix-blend-mode', '');
            },

            updateCSS: function( action ) {
                var $target = this.$element.find( '.elementor-heading-title' );
                if ( ! $target.length ) {
                    $target = this.$element;
                }

                if( 'add' === action ) {
                    $target.css( 'background-clip', 'text' ).css( '-webkit-text-fill-color', 'transparent' );
                } 
                if( 'remove' === action ) {
                    $target.css( 'background-clip', 'unset' ).css( '-webkit-text-fill-color', 'unset' );
                }
            }, 
            
        } );

        var handlersList = {
            'heading.default': RoyalTextUpset, 
            'text-editor.default': RoyalTextUpset
        };

        $.each( handlersList, function( widgetName, handlerClass ) {
            elementorFrontend.hooks.addAction( 'frontend/element_ready/' + widgetName, function( $scope ) {
                elementorFrontend.elementsHandler.addHandler( handlerClass, { $element: $scope } );
            } );
        } );

    } ); 

} ( jQuery, window ) );