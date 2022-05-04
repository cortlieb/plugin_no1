<?php
/**
 * Ausgabe der verschiedenen Bestandteile des Befehl in der letzten Zeile.
 */
echo '<p>__FILE__:<br>';
var_dump( __FILE__ );
echo '</p>';
echo '<p>dirname( __FILE__ ):<br>';
var_dump( dirname( __FILE__ ) );
echo '</p>';
echo '<p>dirname( __FILE__ ) ) . admin/class-plugin_no1-admin.php:<br>';
$debug = ( dirname( __FILE__ ) ) . 'includes/class-plugin_no1-shortcodes.php';
var_dump( $debug );
echo '</p>';
echo '<p>plugin_dir_path( dirname( __FILE__ ) ) . includes/class-plugin_no1-shortcodes.php:<br>';
$debug = plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-plugin_no1-shortcodes.php';
var_dump( $debug );
echo '</p>';
die();

require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-plugin_no1-shortcodes.php';
