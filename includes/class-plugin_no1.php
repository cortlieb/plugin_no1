<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://www.ortliebweb.com
 * @since      1.0.0
 *
 * @package    Plugin_No1
 * @subpackage Plugin_No1/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Plugin_No1
 * @subpackage Plugin_No1/includes
 * @author     Christian Ortlieb <info@ortliebweb.com>
 */
class Plugin_No1 {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Plugin_No1_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'PLUGIN_NO1_VERSION' ) ) {
			$this->version = PLUGIN_NO1_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'plugin_no1';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
		$this->define_post_type_hooks();
		$this->define_shortcode_hooks();
		$this->define_cronjob_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Plugin_No1_Loader. Orchestrates the hooks of the plugin.
	 * - Plugin_No1_i18n. Defines internationalization functionality.
	 * - Plugin_No1_Admin. Defines all hooks for the admin area.
	 * - Plugin_No1_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * Helper functions
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/helper-functions.php';

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-plugin-no1-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-plugin-no1-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-plugin-no1-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-plugin_no1-public.php';

		$this->loader = new Plugin_No1_Loader();

		/**
		 * The class responsible for registering custom post types
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-plugin-no1-post-types.php';

		/**
		 * The class responsible for defining all shortcode functions
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-plugin-no1-shortcodes.php';

		/**
		 * The class responsible for defining all cronjob functions
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-plugin-no1-cronjobs.php';
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Plugin_No1_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Plugin_No1_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Plugin_No1_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

		$this->loader->add_action( 'admin_menu', $plugin_admin, 'add_admin_menu' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Plugin_No1_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Plugin_No1_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

	/**
	 * Defining all action and filter hooks for registering custom post types
	 */
	public function define_post_type_hooks() {
		$plugin_post_types = new Plugin_No1_Post_Types( $this->get_plugin_name(), $this->get_version() );
		$this->loader->add_action( 'init', $plugin_post_types, 'init' );
	}


	/**
	 * Define all short codes for the plugin
	 */
	public function define_shortcode_hooks() {

		$plugin_shortcodes = new Plugin_No1_Shortcodes(
			$this->get_plugin_name(),
			$this->get_version()
		);

		add_shortcode(
			'remember_form',
			array( $plugin_shortcodes, 'remember_form' )
		);
	}

	/**
	 * Define all cronjob hooks for the plugin
	 */
	public function define_cronjob_hooks() {

		$plugin_cronjobs = new Plugin_No1_Cronjobs(
			$this->get_plugin_name(),
			$this->get_version()
		);

		$this->loader->add_action( 'no1_check_reminders', $plugin_cronjobs, 'no1_check_reminders' );

	}
}
