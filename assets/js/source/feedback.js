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

			console.log( this.get_plugins() );

		},

		get_plugins : function() {

			return wpdf_settings.plugins;

		},

		get_plugin_deactivation_url : function( plugin ) {

			var row  = jQuery('tr[data-plugin="' + plugin + '"]');
			var link = row.find( 'span.deactivate a' );
			var href = jQuery( link ).attr('href');

			return href;

		}

	};

	WPDF_Form.init();

});
