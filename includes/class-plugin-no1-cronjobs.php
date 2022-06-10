<?php
/**
 * Cronjob functionality for the plugin
 *
 * @package Plugin_No1
 * @subpackage Plugin_No1/includes
 * @author Christian Ortlieb <info@ortliebweb.com>
 */

if ( ! class_exists( 'Plugin_No1_Cronjobs' ) ) {
	class Plugin_No1_Cronjobs {

		/**
		 * The ID of this plugin.
		 *
		 * @since    1.0.0
		 * @access   private
		 * @var      string    $plugin_name    The ID of this plugin.
		 */
		private $plugin_name;

		/**
		 * The version of this plugin.
		 *
		 * @since    1.0.0
		 * @access   private
		 * @var      string    $version    The current version of this plugin.
		 */
		private $version;    // TODO: Name nicht konsistent mit  $plugin_name

		/**
		 * Initialize the class and set its properties.
		 *
		 * @since    1.0.0
		 * @param string $plugin_name       The name of the plugin.
		 * @param string $version    The version of this plugin.
		 */
		public function __construct( $plugin_name, $version ) {

			$this->plugin_name = $plugin_name;
			$this->version     = $version;
		}

		/**
		 *
		 */
		public function no1_check_reminders() {
			no1_send_cronjob_mail('info@cortlieb.de', 'Dieter Glawischnik', '26.07.2022'); //TODO: Rückgabewert auswerten, z.B. logfile
		}
	}

}
