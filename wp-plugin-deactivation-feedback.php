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

  private $choices;

  public $helper;

  public function __construct( $api_url, $plugin ) {

    $this->api_url = $api_url;
    $this->plugin  = $plugin;

    // Let's run the codeless library ;)
    $this->helper = new Codeless;

    // Include autoloader.
    require __DIR__ . '/vendor/autoload.php';

  }

}
