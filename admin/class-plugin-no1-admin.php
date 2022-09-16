<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://www.ortliebweb.com
 * @since      1.0.0
 *
 * @package    Plugin_No1
 * @subpackage Plugin_No1/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Plugin_No1
 * @subpackage Plugin_No1/admin
 * @author     Christian Ortlieb <info@ortliebweb.com>
 */
class Plugin_No1_Admin {

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
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string $plugin_name       The name of this plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		* This function is provided for demonstration purposes only.
		*
		* An instance of this class should be passed to the run() function
		* defined in Plugin_No1_Loader as all of the hooks are defined
		* in that particular class.
		*
		* The Plugin_No1_Loader will then create the relationship
		* between the defined hooks and the functions defined in this
		* class.
		*/

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/plugin_no1-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		* This function is provided for demonstration purposes only.
		*
		* An instance of this class should be passed to the run() function
		* defined in Plugin_No1_Loader as all of the hooks are defined
		* in that particular class.
		*
		* The Plugin_No1_Loader will then create the relationship
		* between the defined hooks and the functions defined in this
		* class.
		*/

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/plugin_no1-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Adds a top level admin menu for the plugin to the dashboard
	 */
	public function add_admin_menu() {
		add_menu_page(
			__( 'Plugin No 1 Data Page', 'ow_plugin_no1' ), // TODO: besserer Seitentitel
			__( 'Plugin No 1', 'ow_plugin_no1' ),
			'manage_options',
			'plugin-no1',
			array( $this, 'admin_page_display' ),
			'dashicons-awards',
			60,
		);
	}

	/**
	 * Admin page display
	 */
	public function admin_page_display() {
		$this->output_reminder();
	}

	public function output_reminder() {

		$loop_args = array(
			'post_type'      => 'reminder',
			'post_status'    => array( 'draft' ),
			'posts_per_page' => -1,
		);

		// ob_start();

		// TODO: Überschriften der folgenden Tabelle übersetzbar
		// TODO: Kurzer Erklärungstext nach Seitentitel
		// TODO: muss get_admin_page_title() escaped werden?
		?>
		
		<div class="wrap">
		<h1><?php echo get_admin_page_title(); ?></h1>  
		<?php settings_errors(); ?>
		
		</div>
		
		<table class="form-table widefat striped">
		<tr>
		<th class="row-title">Eintragsdatum</th>	
		<th>ID</th>
		<th>gesendet</th>
		<th>Email</th>
		<th>Name</th>
		<th>Erinnerungsdatum</th>
		</tr>
		
		<?php

		$loop = new WP_Query( $loop_args );

		while ( $loop->have_posts() ) :
			$loop->the_post();
			include NO1_BASE_DIR . 'admin/partials/partials_reminder_list.php';

		endwhile;

		/* Restore original post */
		wp_reset_postdata();

		?>
		</table>
		<?php

		// return ob_get_clean();
	}

	/**
	* Fragment zum Löschen von Remindern
	*/

	/*
	$delete_result = wp_delete_post( get_the_ID() );
	if ( ( false == $delete_result ) || ( null == $delete_result ) ) {
		$log_entry .= ' - delete failed!';
	} else {
		$log_entry .= ' - deleted succesfully!';
	}
	*/

}
