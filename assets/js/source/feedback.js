/**
 * Loads the popup box for the feedback form.
 * http://alessandrotesoro.me
 *
 * Copyright (c) 2016 Alessandro Tesoro
 * Licensed under the GPLv2+ license.
 */
jQuery(document).ready(function ($) {

	var WPDF_Form = {

		init : function() {

			this.run();

		},

		/**
		 * Get registered plugins.
		 */
		get_plugins : function() {

			return wpdf_settings.plugins;

		},

		/**
		 * Retrieve the deactivation link tag of a registered plugin.
		 */
		get_plugin_deactivation_anchor : function ( plugin ) {

			var row  = jQuery('tr[data-plugin="' + plugin + '"]');
			var link = row.find( 'span.deactivate a' );

			return link;

		},

		/**
		 * Retrieve the url assigned to a deactivation link.
		 */
		get_plugin_deactivation_url : function( a ) {

			var href = jQuery( a ).attr('href');

			return href;

		},

		/**
		 * Adjust elements of the popup form based on option's selection.
		 */
		popup_on_show : function() {

			jQuery( 'input[type=radio][name=wpdf-choice]' ).on('change', function() {

				var input_extra = jQuery( 'div.wrap-text-field input' );

				jQuery( input_extra ).removeClass( 'wpdf-hide' );

				jQuery( 'a#wpdf-submit' ).text( wpdf_settings.deactivate ).addClass( 'option-selected' );

				switch( jQuery( this ).val() ) {
					case 'did_not_work':
			    	jQuery( input_extra ).attr( 'placeholder', wpdf_settings.reason );
			    break;
					case 'another_plugin':
			    	jQuery( input_extra ).attr( 'placeholder', wpdf_settings.plugin_name );
			    break;
			    case 'other':
			    	jQuery( input_extra ).attr( 'placeholder', '' );
			    break;
			  }

			});

		},

		/**
		 * Send the feedback to the rest api.
		 */
		send_feedback : function( popup ) {

			popup.loading(true);

		},

		/**
		 * Run the popup and other stuff.
		 */
		run : function() {

			var plugins = this.get_plugins();

			jQuery.each( plugins, function( i, plugin ) {

				var anchor = WPDF_Form.get_plugin_deactivation_anchor( plugin.file );
				var link   = WPDF_Form.get_plugin_deactivation_url( anchor );

				jQuery( anchor ).on('click', function( event ) {

					// Disable redirect on click because we're gonna show a popup.
					event.preventDefault();

					var popup = null;

					// Create popup.
		      popup = codelessUi.popup()
		        .modal( true )
		        .size( 595, 320 )
		        .title( '' )
						.onshow( WPDF_Form.popup_on_show )
		        .content( '#wpdf-popup-' + plugin.slug )
		        .show();

					// Set link to deactivation button.
					popup.$().find( 'a#wpdf-submit' ).attr( 'href', link );

					// Close popup when clicking on cancel button.
					popup.$().on( 'click', '.btn-cancel', popup.destroy );

					// Send feedback to api via ajax.
					jQuery( 'a#wpdf-submit' ).on('click', function( event ) {

						// Check if an option has been selected, if not deactivate plugin.
						if( jQuery( this ).hasClass( 'option-selected' ) ) {

							event.preventDefault();

							WPDF_Form.send_feedback( popup );

						}

					});

				});

			});

		}

	};

	WPDF_Form.init();

});
