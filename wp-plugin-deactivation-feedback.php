<?php
/**
 * WP Plugin Deactivation Feedback.
 * Provides an optional feedback form when users disable or delete your plugin from their WordPress site.
 *
 * Copyright (c) 2016 Alessandro Tesoro
 *
 * WP Plugin Deactivation Feedback is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 *
 * WP Plugin Deactivation Feedback is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * @author     Alessandro Tesoro
 * @version    1.0.0
 * @copyright  (c) 2016 Alessandro Tesoro
 * @license    http://www.gnu.org/licenses/gpl-2.0.txt GNU LESSER GENERAL PUBLIC LICENSE
 * @package    wp-plugin-deactivation-feedback
*/

namespace TDP;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * WP Plugin Deactivation Feedback Class
 */
class WP_Plugin_Deactivation_Feedback {

	private $api_url;

	private $plugin;

	private $choices = array();

	public $helper;

	public $elements;

	public function __construct( $api_url, $plugin ) {

		$this->api_url = $api_url;
		$this->plugin  = $plugin;
		$this->choices = $this->get_choices();

		// Include autoloader.
		require __DIR__ . '/vendor/autoload.php';

		// Let's run the codeless library ;)
		$this->helper = new Codeless;

		// Let's run the html helper library.
		$this->elements = new HTML_Elements;

	}

	public function init() {

		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
		add_filter( 'wpdf_registered_plugins', array( $this, 'register_plugin'), 10, 1 );
		add_action( 'admin_footer', array( $this, 'add_popups' ) );

	}

	public function register_plugin( $plugins ) {

		$plugins[] = array(
			'file' => $this->plugin,
			'api'  => $this->api_url,
			'slug' => $this->get_plugin_slug( $this->plugin )
		);

		return $plugins;

	}

	private function get_plugin_slug( $plugin ) {

		return sanitize_title( strstr( $plugin, '/', true ) );

	}

	public function get_choices() {

		$choices = array(
			'did_not_work'   => 'The plugin didn\'t work.',
			'another_plugin' => 'I found a better plugin.',
			'other'          => 'Other'
		);

		return $choices;

	}

	public function add_popups() {

		$screen  = get_current_screen();

		if( $screen->base !== 'plugins' )
			return;

		$plugins = apply_filters( 'wpdf_registered_plugins', array() );

		foreach ( $plugins as $plugin ) {
			include 'views/popup.php';
		}

	}

	public function admin_enqueue_scripts() {

		$suffix  = ( $this->helper->is_script_debug() ) ? '': '.min';
		$css_dir = untrailingslashit( plugin_dir_url( __FILE__ ) ) . '/assets/css/';
		$js_dir  = ( $this->helper->is_script_debug() ) ? untrailingslashit( plugin_dir_url( __FILE__ ) ) . '/assets/js/source/' : untrailingslashit( plugin_dir_url( __FILE__ ) ) . '/assets/js/';
		$screen  = get_current_screen();

		wp_register_script( 'wp-plugin-deactivation-feedback', $js_dir . 'feedback' . $suffix . '.js', 'jQuery', '1.0.0', true );
		wp_register_style( 'wp-plugin-deactivation-feedback', $css_dir . 'wpdf' . $suffix . '.css', '1.0.0' );

		// Enqueue scripts only where needed.
		if( $screen->base == 'plugins' ) {

			// Loads the popup files from the Codeless library.
			$this->helper->add_ui_helper_files();

			wp_enqueue_script( 'wp-plugin-deactivation-feedback' );
			wp_enqueue_style( 'wp-plugin-deactivation-feedback' );

			$this->localize_js_strings();

		}

	}

	public function localize_js_strings() {

		wp_localize_script( 'wp-plugin-deactivation-feedback', 'wpdf_settings', array(
			'ajax'        => admin_url( 'admin-ajax.php' ),
			'plugins'     => apply_filters( 'wpdf_registered_plugins', array() ),
			'plugin_name' => 'What\'s the plugin\'s name?',
			'reason'      => 'Could you share some more details ? (optional)',
		) );

	}

}
