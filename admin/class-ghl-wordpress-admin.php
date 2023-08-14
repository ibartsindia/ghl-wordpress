<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://www.ibsofts.com
 * @since      1.0.0
 *
 * @package    Ghl_Wordpress
 * @subpackage Ghl_Wordpress/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Ghl_Wordpress
 * @subpackage Ghl_Wordpress/admin
 * @author     iB Softs <support@ibsofts.com>
 */
class Ghl_Wordpress_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

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
		 * defined in Ghl_Wordpress_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Ghl_Wordpress_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/ghl-wordpress-admin.css', array(), $this->version, 'all' );

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
		 * defined in Ghl_Wordpress_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Ghl_Wordpress_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/ghl-wordpress-admin.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name.'-form-builder', plugin_dir_url( __FILE__ ) . 'js/form-builder.min.js', array( 'jquery' ), $this->version, true );
		wp_enqueue_script( $this->plugin_name.'-jquery-ui', plugin_dir_url( __FILE__ ) . 'js/jquery-ui.min.js', array( 'jquery' ), $this->version, false );
		
		wp_enqueue_script( $this->plugin_name.'-ajax-script', plugin_dir_url( __FILE__ ) . 'js/ghl-wordpress-ajax.js', array('jquery'), $this->version, false );
        
        wp_localize_script(
            $this->plugin_name.'-ajax-script',
            'ajax_data',
            array(
                'ajax_url' => admin_url( 'admin-ajax.php' ),
            ),
            $this->version,
            false
        );

	}
	
	/**
	 * Checking if setting is done
	 * 
	 */
	public function ibs_ghl_check_plugin_setting() {
	    
        $api_key = get_option('ibs_ghl_subaccount_api_key');
        
	    if ( empty( $api_key ) ) {
             ?>
            <div class="notice notice-error">
                <p>
                    <strong>Setting Error:</strong> Ensure you have added sub-account API key in <?php echo ucfirst($this->plugin_name); ?> plugin setting. <?php echo ucfirst($this->plugin_name); ?> plugin won't be functional until you add api key.
                </p>
            </div>
            <?php
        }
    }
	
	/**
	 * Creating admin menu
	 * 
	 * @since   1.0.0
	 */
	public function ibs_ghl_admin_menu() {
		add_menu_page(
			__( 'Go High Level for WordPress', 'ghl-wordpress' ),
			__( 'GHL for WP', 'ghl-wordpress' ),
			'manage_options',
			'ghl-wordpress-settings',
			array($this, 'ibs_ghl_settings_page'),
			'dashicons-schedule',
			3
		);
		
		add_submenu_page(
		    'ghl-wordpress-settings',
		    __( 'Forms - Go High Level for WordPress', 'ghl-wordpress' ),
			__( 'All Forms', 'ghl-wordpress' ),
		    'manage_options',
		    'ghl-wordpress-form',
			array($this, 'ibs_ghl_form_page')
	    );
	    
	    add_submenu_page(
            'independent-page',
            __( 'Add Form', 'ghl-wordpress' ),
            'Independent Page',
            'manage_options',
            'ghl-wordpress-add-form',
			array($this, 'ibs_ghl_add_form_page')
        );
	}
	
	/**
	 * Displaying plugin setting page
	 * 
	 * @since   1.0.0
	 */
	public function ibs_ghl_settings_page() {
		?>
        <div class="wrap">
            <h1>Go High Level for WordPress</h1>
            
            <form method="post" action="options.php" enctype="multipart/form-data">
                <?php
                    settings_fields('ibs_ghl_settings'); // Add nonce and option page name
                    do_settings_sections('ibs-ghl-settings'); // Render settings sections
                    submit_button(); // Add submit button
                ?>
            </form>
        </div>
        <?php
	}
	
	/**
	 * Displaying GHL forms page
	 * 
	 * @since   1.0.0
	 */
	public function ibs_ghl_form_page() {
	    
	    // Check if the bulk action form is submitted
        if (isset($_POST['submit_bulk_action'])) {
            $action = $_POST['action'];
            $selected_items = isset($_POST['bulk_action']) ? $_POST['bulk_action'] : array();
            
            // Handle the bulk action based on the selected option
            if ($action === 'delete') {
                // Add your logic to delete the selected items from the database
                // For example:
                foreach ($selected_items as $item_id) {
                    // Delete the item with ID $item_id
                }
            }
        }
	    
		?>
        <div class="wrap" id="ibs-ghl-forms">
            <h1 class="wp-heading-inline">All Forms</h1>
            <a href="?page=<?php echo ADD_FORM_PAGE; ?>" class="page-title-action">Add New</a>
            <?php
                self::ibs_ghl_form_table_content();
            ?>
        </div>
        <?php
	}
	
	/**
	 * Displaying GHL add forms page
	 * 
	 * @since   1.0.0
	 */
	public function ibs_ghl_add_form_page() {
	    
	    $title = '';
        $is_active = 1;
        $id = '';
            
	    if (isset($_GET['page']) && $_GET['page'] === ADD_FORM_PAGE && isset($_GET['id'])) {
	        
	        $id = $_GET['id'];
	        
	        $query = new Ghl_Wordpress_Query();
            $form = $query->ibs_ghl_get_form_data($id);
            
            $form_meta = $query->ibs_ghl_get_form_meta($id);
            
            $title = $form['title'];
            $is_active = $form['is_active'];
	        
	    }
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/ghl-wordpress-add-form.php';
	}
	
	/**
	 * Register and initialize the settings
	 * 
	 * @since   1.0.0
	 */
    public function ibs_ghl_register_settings() {
        // Register the settings fields
        add_settings_section(
            'ibs_ghl_settings',                    // Section ID
            'Go High Level Setting',                             // Section title
            array($this, 'ibs_ghl_settings_cb'),   // Callback function to render the section
            'ibs-ghl-settings'                         // Menu slug of the options page
        );
        
        // Register the Sub account API Key field
        add_settings_field(
            'ibs_ghl_subaccount_api_key',                // Field ID
            'Sub-account API Key',                                  // Field label
            array($this, 'ibs_ghl_subaccount_api_key_cb'),        // Callback function to render the field
            'ibs-ghl-settings',                        // Menu slug of the options page
            'ibs_ghl_settings'                     // Section ID where the field should be displayed
        );
        
        // Register the settings
        register_setting(
            'ibs_ghl_settings',                 // Option group name (should match the settings_fields() call in the options page)
            'ibs_ghl_settings'                   // Option name for the API URL field
        );
        
        register_setting(
            'ibs_ghl_settings',                 // Option group name (should match the settings_fields() call in the options page)
            'ibs_ghl_subaccount_api_key'                   // Option name for the API Key field
        );
    }
    
    /**
	 * Render the Plugin Setting section
	 * 
	 * @since   1.0.0
	 */
    public function ibs_ghl_settings_cb() {
        echo '<p>Enter settings below:</p>';
    }
    
    /**
	 * Render the API Key field
	 * 
	 * @since   1.0.0
	 */
    public function ibs_ghl_subaccount_api_key_cb() {
        $api_key = get_option('ibs_ghl_subaccount_api_key');
        echo "<input type='password' class='regular-text' name='ibs_ghl_subaccount_api_key' value='" . esc_attr($api_key) . "' placeholder='Enter Sub-account API Key'/>";
        echo "<p class='description'>Place the Go High Level sub-account API Key.</p>";
    }
    
    /**
	 * Define a function to generate the content of the form table
	 * 
	 * @since   1.0.0
	 */
    public function ibs_ghl_form_table_content() {
        
        $query = new Ghl_Wordpress_Query();
        $data = $query->ibs_ghl_get_all_forms();
        
        if(!empty($data)) {
    
            // Filter and search logic
            $search = isset($_POST['s']) ? sanitize_text_field($_POST['s']) : '';
            $filter_age = isset($_POST['filter_age']) ? intval($_POST['filter_age']) : 0;
        
            // Filter data based on search and filter
            $filtered_data = array_filter($data, function($row) use ($search, $filter_age) {
                $matches_search = empty($search) || strpos(strtolower($row['Name']), strtolower($search)) !== false;
                $matches_filter = $filter_age === 0 || $row['Age'] === $filter_age;
                return $matches_search && $matches_filter;
            });
        
            // Display the table
            echo '<form method="post">';
            echo '<p class="search-box">';
            echo '<label class="screen-reader-text" for="post-search-input">Search:</label>';
            echo '<input type="search" id="post-search-input" name="s" value="' . esc_attr($search) . '">';
            echo '<input type="submit" value="Search" class="button" id="search-submit" name="">';
            echo '</p>';
        
            echo '<table class="wp-list-table widefat striped">';
            echo '<thead>';
            echo '<tr>';
            echo '<th class="check-column"><input type="checkbox" /></th>'; // Checkbox for bulk select
            echo '<th>Title</th>';
            echo '<th>ID</th>';
            echo '<th>Status</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';
            
            // Loop through the filtered data and generate rows
            foreach ($filtered_data as $row) {
                echo '<tr>';
                echo '<td class="check-column"><input type="checkbox" name="bulk_action[]" value="' . esc_attr($row['id']) . '" /></td>'; // Checkbox for individual row
                echo '<td>' . esc_html(ucfirst($row['title'])) . '</td>';
                echo '<td>' . esc_html($row['id']) . '</td>';
                echo '<td>' . esc_html($row['is_active']) . '</td>';
                echo '</tr>';
            }
            
            echo '</tbody>';
            echo '<tfoot>';
            echo '<tr>';
            echo '<th class="check-column"><input type="checkbox" /></th>'; // Checkbox for bulk select
            echo '<th>Title</th>';
            echo '<th>ID</th>';
            echo '<th>Status</th>';
            echo '</tr>';
            echo '</tfoot>';
            echo '</table>';
            
            // Add bulk action options
            echo '<div class="tablenav bottom">';
            echo '<div class="alignleft actions bulkactions">';
            echo '<label for="bulk-action-selector-bottom" class="screen-reader-text">Select bulk action</label>';
            echo '<select name="action" id="bulk-action-selector-bottom">';
            echo '<option value="-1">Bulk Actions</option>';
            echo '<option value="delete">Delete</option>'; // Add more options as needed
            echo '</select>';
            echo '<input type="submit" name="submit_bulk_action" id="doaction" class="button action" value="Apply">';
            echo '</div>';
            echo '<br class="clear">';
            echo '</div>';
            
            echo '</form>';
        } else {
            echo '<table class="wp-list-table widefat striped">';
            echo '<thead>';
            echo '<tr>';
            echo '<th>Title</th>';
            echo '<th>ID</th>';
            echo '<th>Status</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody><tr><td>No data Found</td></tr></tbody>';
            echo '</table>';
        }
    }
    
    /**
	 * saving form data
	 * 
	 * @since   1.0.0
	 */
    public function ibs_ghl_save_form_callback() {
        
        if($_POST['action'] == 'ibs_ghl_save_form') {
            
            $form_data = $_POST['data'];
            $status = 0;
            
            if(isset($form_data['status']) && !empty($form_data['status']) && $form_data['status'] == 'on') {
                $status = 1;
            }
            
            $form_data_args = array(
                'title' => $form_data['title'],
                'is_active' => $status,
            );
            
            $query = new Ghl_Wordpress_Query();
            
            if (isset($form_data['form_id']) && !empty($form_data['form_id'])) {
                $updated = $query->ibs_ghl_update_form($form_data['form_id'], $form_data_args);
                
                if($updated['status'] == 200) {
                    $form_id = $form_data['form_id'];
                }
                
            } else {
                $inserted = $query->ibs_ghl_insert_form($form_data_args);
                $form_id = $inserted;
            }
            
            
            if($form_id) {
                $form_meta_args = array(
                    'form_id' => $form_id,
                    'display_meta' => $form_data['form_fields'],
                );
                
                if($query->ibs_ghl_check_form_meta_exist($form_id)) {
                    $query->ibs_ghl_update_form_meta($form_id, $form_meta_args);
                } else {
                    $query->ibs_ghl_insert_form_meta($form_meta_args);
                }
                
                echo json_encode(['status' => 201, 'url' => get_admin_url()."admin.php?page=".ADD_FORM_PAGE."&id=$form_id"]);
            } else {
                echo json_encode(['status' => 500, 'url' => get_admin_url()."admin.php?page=".ADD_FORM_PAGE]);
            }
        }
        
        wp_die();
    }
    
    /**
	 * Fetch all forms
	 * 
	 * @since   1.0.0
	 */
    public function ibs_ghl_get_all_forms() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'ibs_ghl_form';
        
        // Fetch data from the table
        $data = $wpdb->get_results("SELECT * FROM $table_name");
        $forms = [];
        
        // Check if there are any records
        if ($wpdb->num_rows > 0) {
            foreach($data as $d) {
                array_push(
                    $forms,
                    [
                        'id' => $d->id,
                        'title' => $d->title,
                        'is_active' => $d->is_active,
                        'is_trash' => $d->is_trash
                    ]
                );
            }
            return $forms;
        } else {
            return "no data";
        }
        
    }

}
