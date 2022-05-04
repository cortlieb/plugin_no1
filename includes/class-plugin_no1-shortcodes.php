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
		private $version;
		
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
		}
		
		public function remember_form( $atts, $content ) {
			// return 'I am a short code<br><strong>' . $content . '</strong><br>' . var_export( $atts, true );
			ob_start();
			?>
			<!-- <input 
			type="text"
			name="Testname"
			value="Testvalue"
			class="form_text_input"
			/> -->
			
			<h2>Kontaktieren Sie uns:</h2>
			<form id="my-form" >
			<input type="text" id="name" name="name" placeholder="Name" required>
			<input type="email" id="email" name="email" placeholder="E-Mail Adresse" required>
			<input type="text" id="subject" name="subject" placeholder="Betreff" required>
			<textarea name="message" type="text" id="message" placeholder="Nachricht" required>
			</textarea>
			<input type="submit" value="Senden" id="submit">
			<div id="wait">
			</div>
			<div id="response">
			</div>
			</form>
		
			<?php
			return ob_get_clean();
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
