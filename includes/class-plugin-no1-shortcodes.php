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
			add_action( 'wp_enqueue_scripts', array( $this, 'register_style' ) );
			add_action( 'get_footer', array( $this, 'maybe_enqueue_scripts' ) );
			// register a handler for form 'remember_form'
			add_action( 'admin_post_no1_remember_form_response', array( $this, 'no1_evaluate_remember_form' ) );
			add_action( 'admin_post_nopriv_no1_remember_form_response', array( $this, 'no1_evaluate_remember_form' ) );
		}

		public function remember_form( $atts, $content ) {
			// return 'I am a short code<br><strong>' . $content . '</strong><br>' . var_export( $atts, true );
			ob_start();

			if ( isset( $_REQUEST['info'] ) ) {
				echo '<p>Ergebnis Formularauswertung: ' . $_REQUEST['info'] . '</p>';
				echo '<p>Hallo ' . esc_html( $_REQUEST['response']['name'] ) . ', das hat geklappt.</p>';
				echo '<p>Wir werden dir zur gewünschten Zeit eine Erinnerung an ' . esc_html( $_REQUEST['response']['email'] ) . ' schicken!</p>';
			} else {
				include_once 'wp-content/plugins/plugin_no1/public/partials/partials-remember-form-view.php'; // TODO: besseres Konstruieren des Pfades (s. Rocket-Books).
			};

			return ob_get_clean();
		}

		public function no1_evaluate_remember_form() {
			status_header( 200 );
			// echo '<h2>Hier ist die Formularauswertung</h2>';
			// die();

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

			$result_email_send = no1_send_remember_mail();

			echo 'Formularauswertung: ' . $form_eva_result . '<br>';
			var_dump( $result_email_send );
			die();

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

		/**
		 * Register placeholder style
		 */
		public function register_style() {
			wp_register_style(
				$this->plugin_name . '-shortcodes',
				ROCKET_BOOKS_PLUGIN_URL . 'public/css/rocket-books-shortcodes.css', // kann "null"sein, wenn kein CSS in der Datei steht, sondern nur Inline CSS genutzt wird
			);
		}

		/**
		 * Enqueue styles and scripts only if required
		 */
		public function maybe_enqueue_scripts() {

			if ( ! empty( $this->shortcode_css ) ) {
				// Step 3: Add CSS to placeholder style.
				wp_add_inline_style(
					$this->plugin_name . '-shortcodes',
					$this->shortcode_css,
				);

				// Step 4: Enqueue style.
				wp_enqueue_style(
					$this->plugin_name . '-shortcodes',
				);
			}
		}
	}
}
