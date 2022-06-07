<?php

/**
 * Fired during plugin activation
 *
 * @link       https://www.ortliebweb.com
 * @since      1.0.0
 *
 * @package    Plugin_No1
 * @subpackage Plugin_No1/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Plugin_No1
 * @subpackage Plugin_No1/includes
 * @author     Christian Ortlieb <info@ortliebweb.com>
 */
class Plugin_No1_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() { //TODO: Event auch wieder un-registrieren, wenn Plugin deaktiviert wird
		if ( ! wp_next_scheduled( 'no1_check_reminders' ) ) {
			wp_schedule_event( time(), 'hourly', 'no1_check_reminders' );
		}

	}

}
