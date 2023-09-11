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

		wp_enqueue_script( $this->plugin_name.'-form-builder-ui', plugin_dir_url( __FILE__ ) . 'js/form-builder.min.js', array( 'jquery' ), $this->version, true );

		wp_enqueue_script( $this->plugin_name.'-ajax-script-ui', plugin_dir_url( __FILE__ ) . 'js/ghl-wordpress-public-ajax.js', array('jquery'), $this->version, false );
        

        wp_localize_script(
            $this->plugin_name.'-ajax-script-ui',
            'ajax_data',
            array(
                'ajax_url' => admin_url( 'admin-ajax.php' ),
            ),
            $this->version,
            false
        );

	}
	
	//create shortcode to render the form in the frontend page
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

	// getting the form entries data entered by the user in the frontend page and send to api
	public function ibs_ghl_get_form_data_callback(){
		if($_POST['action']=='ibs_ghl_get_form_data'){

            $data=$_POST['data'];
			$id=$_POST['id'];
			
			$query = new Ghl_Wordpress_Query();
			$insert_result=$query->insert_form_entries($id,json_encode($data));
			if($insert_result){
				
				//get the mapped data
				$form_mapping_data=$query->ibs_ghl_get_form_mapping_data($id);
				$decoded_mapped_data=json_decode($form_mapping_data[0]->mapped_data);
				$mapName=array($decoded_mapped_data->name,$decoded_mapped_data->email,$decoded_mapped_data->phone);

				//helper function
				$helper= new Ghl_Wordpress_Helper();
				$get_label=$helper->get_label_name($id);
				$labelNames=$get_label[0];
				
				$contact_data=array();
				foreach ($data as $field_name => $field_value) {
					// Sanitize field name and value
					$sanitized_field_name = sanitize_text_field($field_name);
					$sanitized_field_value = sanitize_text_field($field_value);

					for ($j=0;$j<count($mapName);$j++){
						if($mapName[$j]==$sanitized_field_name){
							$contact_data[$labelNames[$j]]=$sanitized_field_value;
							break;
						}
					}
				}
				$api=new Ghl_Wordpress_API();
				$api->ibs_ghl_create_contact($contact_data);
			}
            // $page_url=get_admin_url()."admin.php?page=".FORM_ENTRIES;
			
            $response=true;
            wp_send_json($response);
            wp_die();
        }
	}

}
