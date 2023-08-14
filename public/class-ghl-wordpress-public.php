<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://www.ibsofts.com
 * @since      1.0.0
 *
 * @package    Ghl_Wordpress
 * @subpackage Ghl_Wordpress/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Ghl_Wordpress
 * @subpackage Ghl_Wordpress/public
 * @author     iB Softs <support@ibsofts.com>
 */
class Ghl_Wordpress_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Ghl_Wordpress_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Ghl_Wordpress_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/ghl-wordpress-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Ghl_Wordpress_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Ghl_Wordpress_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/ghl-wordpress-public.js', array( 'jquery' ), $this->version, false );
		
		wp_enqueue_script( $this->plugin_name.'-form-builder', plugin_dir_url( __FILE__ ) . 'js/form-render.min.js', array( 'jquery' ), $this->version, true );
		wp_enqueue_script( $this->plugin_name.'-jquery-ui', plugin_dir_url( __FILE__ ) . 'js/jquery-ui.min.js', array( 'jquery' ), $this->version, true );

	}
	
	public function ibs_ghl_wordpress_shortcode_callback( $atts ) {
	    
    	$default = array(
            'id' => '#',
        );
        $a = shortcode_atts($default, $atts);
        
        if(!empty($a['id'])) {
            $query = new Ghl_Wordpress_Query();
            
            $form_meta = $query->ibs_ghl_get_form_meta($a['id']);
        	
        	ob_start();
        
        	require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/partials/ghl-wordpress-display-form.php';
        
    	return ob_get_clean();
        }
    
    }

}
