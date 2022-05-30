<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://www.ortliebweb.com
 * @since             1.0.0
 * @package           Plugin_No1
 *
 * @wordpress-plugin
 * Plugin Name:       Plugin No 1
 * Plugin URI:        https://www.ortliebweb.com
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Christian Ortlieb
 * Author URI:        https://www.ortliebweb.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       plugin_no1
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'PLUGIN_NO1_VERSION', '1.0.0' );

/**
 * Plugin base dir path.
 * Used to locate plugin resources primarily code files
 * Start at version 1.0.0
 */
define( 'NO1_BASE_DIR', plugin_dir_path( __FILE__ ));


/**
 * Plugin URL to access its resources by the browser.
 * Use to access images/css/js files.
 * Start at version 1.0.0
 */
define( 'NO1_PLUGIN_URL', plugin_dir_url( __FILE__));


/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-plugin-no1-activator.php
 */
function activate_plugin_no1() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-plugin-no1-activator.php';
	Plugin_No1_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-plugin-no1-deactivator.php
 */
function deactivate_plugin_no1() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-plugin-no1-deactivator.php';
	Plugin_No1_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_plugin_no1' );
register_deactivation_hook( __FILE__, 'deactivate_plugin_no1' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-plugin_no1.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_plugin_no1() {

	$plugin = new Plugin_No1();
	$plugin->run();

}
run_plugin_no1();
