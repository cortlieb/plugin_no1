<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://www.ortliebweb.com
 * @since      1.0.0
 *
 * @package    Plugin_no1
 * @subpackage Plugin_no1/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Plugin_no1
 * @subpackage Plugin_no1/includes
 * @author     Christian Ortlieb <info@ortliebweb.com>
 */
class Plugin_no1_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'plugin_no1',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
