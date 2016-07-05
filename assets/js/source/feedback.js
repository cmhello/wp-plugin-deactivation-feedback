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

		get_plugins : function() {

			return wpdf_settings.plugins;

		},

		get_plugin_deactivation_anchor : function ( plugin ) {

			var row  = jQuery('tr[data-plugin="' + plugin + '"]');
			var link = row.find( 'span.deactivate a' );

			return link;

		},

		get_plugin_deactivation_url : function( a ) {

			var href = jQuery( a ).attr('href');

			return href;

		},

		show_extra : function() {

			console.log( 'e' );

		},

		run : function() {

			var plugins = this.get_plugins();

			jQuery.each( plugins, function( i, plugin ) {

				var anchor = WPDF_Form.get_plugin_deactivation_anchor( plugin.file );
				var link   = WPDF_Form.get_plugin_deactivation_url( anchor );

				jQuery( anchor ).on('click', function( event ) {

					// Disable redirect on click because we're gonna show a popup.
					event.preventDefault();

					var popup = null;

		      popup = codelessUi.popup()
		        .modal( true )
		        .size( 595, 300 )
		        .title( '' )
						.onshow( WPDF_Form.show_extra )
		        .content( '#wpdf-popup-' + plugin.slug )
		        .show();

					popup.$().on( 'click', '.btn-cancel', popup.destroy );

				});

			});

		}

	};

	WPDF_Form.init();

});
