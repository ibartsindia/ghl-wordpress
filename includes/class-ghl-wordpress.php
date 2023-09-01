<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://www.ibsofts.com
 * @since      1.0.0
 *
 * @package    Ghl_Wordpress
 * @subpackage Ghl_Wordpress/includes
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
 * @package    Ghl_Wordpress
 * @subpackage Ghl_Wordpress/includes
 * @author     iB Softs <support@ibsofts.com>
 */
class Ghl_Wordpress {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Ghl_Wordpress_Loader    $loader    Maintains and registers all hooks for the plugin.
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
		if ( defined( 'GHL_WORDPRESS_VERSION' ) ) {
			$this->version = GHL_WORDPRESS_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'ghl-wordpress';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Ghl_Wordpress_Loader. Orchestrates the hooks of the plugin.
	 * - Ghl_Wordpress_i18n. Defines internationalization functionality.
	 * - Ghl_Wordpress_Admin. Defines all hooks for the admin area.
	 * - Ghl_Wordpress_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-ghl-wordpress-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-ghl-wordpress-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-ghl-wordpress-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-ghl-wordpress-public.php';

		$this->loader = new Ghl_Wordpress_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Ghl_Wordpress_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Ghl_Wordpress_i18n();

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

		$plugin_admin = new Ghl_Wordpress_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		
        //$this->loader->add_action('admin_notices', $plugin_admin, 'ibs_ghl_check_plugin_setting');
		
        $this->loader->add_action( 'admin_menu', $plugin_admin, 'ibs_ghl_admin_menu' );
        $this->loader->add_action('admin_init', $plugin_admin, 'ibs_ghl_register_settings');
        
        $this->loader->add_action( 'wp_ajax_ibs_ghl_save_form', $plugin_admin, 'ibs_ghl_save_form_callback' );
        $this->loader->add_action( 'wp_ajax_nopriv_ibs_ghl_save_form', $plugin_admin, 'ibs_ghl_save_form_callback' );

		//action hook for sending the form to the trash
		$this->loader->add_action( 'wp_ajax_ibs_ghl_trash_form', $plugin_admin, 'ibs_ghl_trash_form_callback' );
		$this->loader->add_action( 'wp_ajax_nopriv_ibs_ghl_trash_form', $plugin_admin, 'ibs_ghl_trash_form_callback' );

		//action hook for opening the edit option of the form
		$this->loader->add_action( 'wp_ajax_ibs_ghl_edit_form', $plugin_admin, 'ibs_ghl_edit_form_callback' );
		$this->loader->add_action( 'wp_ajax_nopriv_ibs_ghl_edit_form', $plugin_admin, 'ibs_ghl_edit_form_callback' );

		//action hook for opening the setting option of the form
		$this->loader->add_action( 'wp_ajax_ibs_ghl_form_settings', $plugin_admin, 'ibs_ghl_form_settings_callback' );
		$this->loader->add_action( 'wp_ajax_nopriv_ibs_ghl_form_settings', $plugin_admin, 'ibs_ghl_form_settings_callback' );

		//action hook for the all form preview
		$this->loader->add_action( 'wp_ajax_ibs_ghl_all_form', $plugin_admin, 'ibs_ghl_all_form_callback' );
		$this->loader->add_action( 'wp_ajax_nopriv_ibs_ghl_all_form', $plugin_admin, 'ibs_ghl_all_form_callback' );

		//action hook for the trash form preview
		$this->loader->add_action( 'wp_ajax_ibs_ghl_trash_form_preview', $plugin_admin, 'ibs_ghl_trash_form_preview_callback' );
		$this->loader->add_action( 'wp_ajax_nopriv_ibs_ghl_trash_form_preview', $plugin_admin, 'ibs_ghl_trash_form_preview_callback' );

		//action hook for restoring the form from the trash and send to the all form pages
		$this->loader->add_action( 'wp_ajax_ibs_ghl_restore_form', $plugin_admin, 'ibs_ghl_restore_form_callback' );
		$this->loader->add_action( 'wp_ajax_nopriv_ibs_ghl_restore_form', $plugin_admin, 'ibs_ghl_restore_form_callback');

		//action hook for deleting the form permanently from the database
		$this->loader->add_action( 'wp_ajax_ibs_ghl_delete_permanently', $plugin_admin, 'ibs_ghl_delete_permanently_callback' );
		$this->loader->add_action( 'wp_ajax_nopriv_ibs_ghl_delete_permanently', $plugin_admin, 'ibs_ghl_delete_permanently_callback');

		//action hook for searching the form 
		$this->loader->add_action( 'wp_ajax_ibs_ghl_search_form', $plugin_admin, 'ibs_ghl_search_form_callback' );
		$this->loader->add_action( 'wp_ajax_nopriv_ibs_ghl_search_form', $plugin_admin, 'ibs_ghl_search_form_callback');

		//action hook for searching the form in trash 
		$this->loader->add_action( 'wp_ajax_ibs_ghl_search_trash_form', $plugin_admin, 'ibs_ghl_search_trash_form_callback' );
		$this->loader->add_action( 'wp_ajax_nopriv_ibs_ghl_search_trash_form', $plugin_admin, 'ibs_ghl_search_trash_form_callback');

		//action hook for searching the form in trash 
		$this->loader->add_action( 'wp_ajax_ibs_ghl_form_entries', $plugin_admin, 'ibs_ghl_form_entries_callback' );
		$this->loader->add_action( 'wp_ajax_nopriv_ibs_ghl_form_entries', $plugin_admin, 'ibs_ghl_form_entries_callback');
		
	}
	
	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Ghl_Wordpress_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
		
        $this->loader->add_shortcode( 'ghl_wordpress', $plugin_public, 'ibs_ghl_wordpress_shortcode_callback' );

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
	 * @return    Ghl_Wordpress_Loader    Orchestrates the hooks of the plugin.
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

}
