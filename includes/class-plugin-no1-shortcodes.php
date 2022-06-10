<?php
/**
 * Shortcode functionality for the plugin
 *
 * @package Plugin_No1
 * @subpackage Plugin_No1/includes
 * @author Christian Ortlieb <info@ortliebweb.com>
 */

if ( ! class_exists( 'Plugin_No1_Shortcodes' ) ) {
	class Plugin_No1_Shortcodes {

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
		 * @var all CSS for all shortcodes
		 */
		protected $shortcode_css;

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

			$this->setup_hooks();
		}

		/**
		 * Setup action / filter hooks
		 */
		public function setup_hooks() {
			// register a handler for form 'remember_form'
			add_action( 'admin_post_no1_remember_form_response', array( $this, 'no1_evaluate_remember_form' ) );
			add_action( 'admin_post_nopriv_no1_remember_form_response', array( $this, 'no1_evaluate_remember_form' ) );
		}

		public function remember_form( $atts, $content ) {
			ob_start();

			if ( isset( $_REQUEST['info'] ) ) { //müssen noch weitere Dinge geprüft werden?
				echo '<p>Hallo ' . esc_html( $_REQUEST['response']['name'] ) . ', das hat geklappt.</p>';
				echo '<p>Wir werden dir zur gewünschten Zeit eine Erinnerung an ' . esc_html( $_REQUEST['response']['email'] ) . ' schicken!</p>';
			} else {
				include_once NO1_BASE_DIR . '/public/partials/partials-remember-form-view.php';
			};

			return ob_get_clean();
		}

		public function no1_evaluate_remember_form() {
			status_header( 200 );   // TODO: wird das Benötigt? Relikt aus irgendeinem Beispiel.

			// Check if nonce is correct.
			if ( isset( $_POST['no1_remember_form_nonce'] ) && wp_verify_nonce( $_POST['no1_remember_form_nonce'], 'no1_submit_remember_form' ) ) {
				// processing of form data.

				$plugin_post_types = new Plugin_No1_Post_Types( $this->plugin_name, $this->version );
				$plugin_post_types->save_reminder_cpt( $_POST );

				// server response.
				$form_eva_result = 'success';
			} else {
				$form_eva_result = 'failed_nonce';
			}

			wp_redirect(
				esc_url_raw(
					add_query_arg(
						array(
							'info'     => $form_eva_result,
							'response' => $_POST,
						),
						home_url( 'index.php/test-shortcode-no1/' )  // muss noch verallgemeinert werden.
					)
				)
			);
			exit;

			// exit - ja: wp_redirect muss von exit gefolgt werden?
		}
	}
}
