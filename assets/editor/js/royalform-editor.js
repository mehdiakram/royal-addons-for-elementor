jQuery( window ).on( 'elementor:init', function() {
	elementor.hooks.addAction( 'panel/open_editor/widget/royal-form', function( panel, model, view ) {
		
		// 1. Handle Copy Shortcode Button Click
		// Use event delegation on the panel element
		panel.$el.on( 'click', '.royal-copy-shortcode-btn', function( e ) {
			e.preventDefault();
			var $btn = jQuery( this );
			var $input = $btn.siblings( '.royal-field-shortcode-input' );
			
			if ( $input.length ) {
				$input.select();
				document.execCommand( 'copy' );
				
				// Visual feedback
				var originalIcon = $btn.html();
				$btn.html( '<i class="eicon-check"></i>' );
				setTimeout( function() {
					$btn.html( originalIcon );
				}, 2000 );
			}
		} );

		// 2. Update Available Tokens List
		// Function to generate and update the tokens list
		function updateAvailableTokens() {
			var settings = model.get( 'settings' );
			var formFields = settings.get( 'form_fields' );
			var tokensHtml = '';

			if ( formFields && formFields.length ) {
				formFields.each( function( field ) {
					var id = field.get( 'custom_id' );
					if ( id ) {
						tokensHtml += '<span class="royal-token-item" style="display:inline-block; padding:2px 6px; background:#f1f1f1; border:1px solid #ddd; border-radius:3px; font-family:monospace; margin-right:5px; margin-bottom:5px; cursor:pointer;" title="Click to copy">[' + id + ']</span>';
					}
				} );
			}

			if ( ! tokensHtml ) {
				tokensHtml = '<span style="color:#888; font-size:12px; font-style:italic;">No fields found or IDs missing.</span>';
			}

			// Update the container in the active panel
			var $container = panel.$el.find( '.royal-available-tokens-list' );
			if ( $container.length ) {
				$container.html( tokensHtml );
			}
		}

		// Initial update when panel opens (might need a slight delay for DOM to be ready if tab is active)
		setTimeout( updateAvailableTokens, 500 );

		// specific listener for tab change to Email section
		panel.$el.on( 'click', '.elementor-control-section_email', function() {
			setTimeout( updateAvailableTokens, 100 );
		} );

		// Listen for changes in the repeater fields
		model.get( 'settings' ).get( 'form_fields' ).on( 'add remove change', function() {
			// Debounce could be good here, but for now simple timeout
			setTimeout( updateAvailableTokens, 100 );
		} );
		
		// Also listen to custom_id changes specifically if not covered by 'change' above
		// The above 'change' on the collection usually covers model changes inside it too in Backbone.
		
		// delegated click for copying from the available tokens list
		panel.$el.on( 'click', '.royal-available-tokens-list .royal-token-item', function() {
			var text = jQuery( this ).text();
			var $tempInput = jQuery( '<input>' );
			jQuery( 'body' ).append( $tempInput );
			$tempInput.val( text ).select();
			document.execCommand( 'copy' );
			$tempInput.remove();
			
			// Visual feedback (optional - maybe a tooltip or flash)
			var $item = jQuery( this );
			$item.css( 'background-color', '#d4edda' );
			setTimeout( function() {
				$item.css( 'background-color', '#f1f1f1' );
			}, 300 );
		} );
		
	} );
} );
