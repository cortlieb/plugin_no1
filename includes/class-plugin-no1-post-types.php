<?php

/**
 * Functionality for Custom Post Types
 *
 * @link       https://www.ortliebweb.com
 * @since      1.0.0
 *
 * @package    Plugin_No1
 * @subpackage Plugin_No1/includes
 */

class Plugin_No1_Post_Types {
	// TODO: Abfragen, ob es Klasse schon gibt?

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
	 * @param string $plugin_name       The name of the plugin.
	 * @param string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;
	}

	/**
	 * Hooked into 'init' action hook
	 */
	public function init() {
		$this->register_cpt_reminder();
	}

	/**
	 * Registering Custom Post Type: Reminder
	 */
	public function register_cpt_reminder() {

		register_post_type(
			'reminder',
			array(
				'description'          => __( 'Reminder', 'plugin_no1' ),
				'labels'               => array(
					'name'               => _x( 'Reminder', 'post type general name', 'plugin_no1' ),
					'singular_name'      => _x( 'Reminder', 'post type singular name', 'plugin_no1' ),
					'menu_name'          => _x( 'Reminder', 'admin menu', 'plugin_no1' ),
					'name_admin_bar'     => _x( 'Reminder', 'add new reminder on admin bar', 'plugin_no1' ),
					'add_new'            => _x( 'Neuer Reminder', 'post_type', 'plugin_no1' ),
					'add_new_item'       => __( 'Neuen reminder hinzufügen', 'plugin_no1' ),
					'edit_item'          => __( 'Reminder bearbeiten', 'plugin_no1' ),
					'new_item'           => __( 'Neuer Reminder', 'plugin_no1' ),
					'view_item'          => __( 'Reminder ansehen', 'plugin_no1' ),
					'search_items'       => __( 'Reminder suchen', 'plugin_no1' ),
					'not_found'          => __( 'Kein Reminder gefunden.', 'plugin_no1' ),
					'not_found_in_trash' => __( 'Kein reminder im Papierkorb gefunden.', 'plugin_no1' ),
					'parent_item_colon'  => __( 'Eltern Reminder:', 'plugin_no1' ),
					'all_items'          => __( 'Alle Reminder', 'plugin_no1' ),
				),
				'public'               => true,
				'hierarchical'         => false,
				'exclude_from_search'  => false,
				'publicly_queryable'   => true,
				'show_ui'              => true,
				'show_in_menu'         => true,
				'show_in_nav_menus'    => true,
				'show_in_admin_bar'    => true,
				'menu_position'        => 20,
				'menu_icon'            => 'dashicons-flag',
				'capability_type'      => 'post',
				'capabilities'         => array(),
				'map_meta_cap'         => null,
				'supports'             => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' ),
				'has_archive'          => true,
				'rewrite'              => array(
					'slug'       => 'reminder',
					'with_front' => true,
					'feeds'      => true,
					'pages'      => true,
				),
				'query_var'            => true,
				'can_export'           => true,
				'show_in_rest'         => true,
			)
		);
	}

	// TODO: Kommentar einfügen
	// TODO: alle Daten mit prefix versehen
	// TODO: Doppeleinträge vermeiden (eine Emailadresse nur einmal eintragen), dann nur Meta-Daten ändern --> Hinweis ausgeben
	/**
	 *
	 */

	public function save_reminder_cpt( $form_data ) {
		$post_array         = array(
			'post_title' => $form_data['email'],
			'post_type'  => 'reminder',
		);
		$insert_post_result = wp_insert_post( $post_array, true );
		// TODO: Abfragen: insert_post erfolgreich?
		// TODO: Sind jeweilige array-Einträge verfügbar?
		// TODO: Namenseintrag sanitizen.
		update_post_meta( $insert_post_result, 'no1_reminder_name', $_POST['name'] );
		update_post_meta( $insert_post_result, 'no1_reminder_date', $_POST['remember_date'] );
	}
}
