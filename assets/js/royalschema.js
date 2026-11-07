( function( $ ) {
    class RoyalSchemaHandler extends elementorModules.frontend.handlers.Base {
        getDefaultSettings() {
            return {
                selectors: {
                    royalSchemaWidget: '.royal-schema-widget',
                },
            };
        }

        getDefaultElements() {
            const selectors = this.getDefaultSettings().selectors; // Corrected line
            return {
                $royalSchemaWidget: this.$element.find(selectors.royalSchemaWidget),
            };
        }

        bindEvents() {
            this.elements.$royalSchemaWidget.on('click', '.royal-schema-faq-question', function() {
                $(this).next('.royal-schema-faq-answer').slideToggle();
                $(this).toggleClass('active');
            });
        }

        onInit() {
            super.onInit();
            this.bindEvents();
            this.elements.$royalSchemaWidget.trigger('royalschema/widget/initialized');
        }
    }

    $( window ).on( 'elementor/frontend/init', () => {
        elementorFrontend.elementsHandler.attachHandler( 'royalschema', RoyalSchemaHandler );
    } );
}( jQuery ) );