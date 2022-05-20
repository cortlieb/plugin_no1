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

class Plugin_No1_Post_Types {    //TODO: Abfragen, ob es Klasse schon gibt?

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

		$this->plugin_name     = $plugin_name;
		$this->version         = $version;
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
					'name_admin_bar'     => _x( 'Reminder', 'add new book on admin bar', 'plugin_no1' ),
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
				'register_meta_box_cb' => array( $this, 'register_metabox_book' ),
				'taxonomies'           => array( 'genre' ),
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

	public function save_reminder_cpt ($form_data) {
		echo '<h2>Hier ist "save_reminer_cpt"</h2>'
		var_dump($form_data);
		die();

	}



	/**
	 * Register meta-box for CPT: book
	 */
	public function register_metabox_book( $post ) {

		$is_gutenberg_active = (
			function_exists( 'use_block_editor_for_post_type' ) &&
			use_block_editor_for_post_type( get_post_type() )
		);

		add_meta_box(
			'book-details',
			( $is_gutenberg_active ) ? __( 'Book Details - Gutenberg', 'rocket-books' ) : __( 'Book Details - classic', 'rocket-books' ),
			array( $this, 'book_metabox_display_cb' ),
			'book',
			// die naechsten beiden Parameter scheinen keine Auswirkung zu haben.
			// Evtl. hängt das mit den neuen (ab WP 5.5) Pfeilen zum Verschieben von
			// Metaboxen zusammen.
			( $is_gutenberg_active ) ? 'side' : 'normal',
			'high'
		);

	}



	/**
	 * Saving custom fields for CPT: books
	 */
	public function metabox_save_book( $post_id, $post, $update ) {

		/**
		 * Test, in dem dem aktuellen user die Möglchkeit entzogen wird, posts zu ändern.
		 * --> funktioniert nicht - Grund unklar
		 */
		// $current_user = wp_get_current_user();
		// $current_user->remove_cap( 'edit_posts' );

		/**
		 * Aber so funktioniert es, Hinweis aus Kursfragen
		 */
		// global $wp_roles;
		// $wp_roles->add_cap( 'administrator', 'edit_posts' );

		// $current_user = wp_get_current_user();
		// echo '<pre>';
		// var_dump( $current_user );
		// echo '</pre>';
		// die();

		/**
		 * Prevent saving if its triggered for:
		 *  1. Auto save
		 *  2. User does not have permission to edit
		 *  3. invalid nonce
		 */

		// if this is an autosave, our form has not been submitted, so do nothing.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		// check user permission
		if ( ! current_user_can( 'edit_posts', 'post_id' ) ) {
			print __( 'Sorry, you do not have access to edit post', 'rocket-books' );
			exit;
		}

		// Verify nonce.
		if (
			! isset( $_POST['rbr_meta_box_nonce'] )
			||
			! wp_verify_nonce( $_POST['rbr_meta_box_nonce'], 'rbr_meta_box_nonce_action' )
		) {
			return null;
			/**
			 * War zu Testzwecken integriert, gibt aber ein Problem beim Neuanlegen von Büchern,
			 * da dann der nonce noch nicht erzeugt wurde.
			 * Daher wird jetzt nur returned.
			 */
			// print __( 'Sorry, your nonce did not verify.', 'rocket_books' );
			// exit;
		}

		if ( array_key_exists( 'rbr-books-pages', $_POST ) ) {
					// update_post_meta( get_the_ID(), 'rbr_book_page', $_POST['rbr-books-pages'] );
			update_post_meta( $post_id, 'rbr_book_pages', absint( $_POST['rbr-books-pages'] ) );
		}

		if ( array_key_exists( 'rbr-is-featured', $_POST ) ) {
			update_post_meta(
				$post_id,
				'rbr_is_featured',
				( 'yes' === $_POST['rbr-is-featured'] ? 'yes' : 'no' )
			);
		}

		if ( array_key_exists( 'rbr-book-format', $_POST ) ) {
			$book_format = (
			in_array(
				$_POST['rbr-book-format'],
				array( 'hardcover', 'audio', 'pdf' )
			) ? sanitize_key( $_POST['rbr-book-format'] ) : 'pdf' );

			update_post_meta(
				$post_id,
				'rbr_book_format',
				$book_format
			);
		}
	}
}
