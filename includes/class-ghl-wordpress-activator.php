<?php

/**
 * Fired during plugin activation
 *
 * @link       https://www.ibsofts.com
 * @since      1.0.0
 *
 * @package    Ghl_Wordpress
 * @subpackage Ghl_Wordpress/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Ghl_Wordpress
 * @subpackage Ghl_Wordpress/includes
 * @author     iB Softs <support@ibsofts.com>
 */
class Ghl_Wordpress_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
        self::ibs_ghl_create_form_table();
        self::ibs_ghl_create_form_meta_table();
        self::ibs_ghl_form_entries();
        self::ibs_ghl_field_mapping();
	}
	
	public static function ibs_ghl_create_form_table() {
	    // Create the table
        global $wpdb;
        
        $table_name = $wpdb->prefix . 'ibs_ghl_form';
        $charset_collate = $wpdb->get_charset_collate();
        
        //create table only if doesnot exist
        if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
            $sql = "CREATE TABLE $table_name (
                id INT(11) NOT NULL AUTO_INCREMENT,
                title VARCHAR(150) NOT NULL,
                is_active TINYINT DEFAULT 1,
                is_trash TINYINT DEFAULT 0,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY (id)
            ) $charset_collate;";
        
            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
            dbDelta($sql);
        }
        
	}
	
	public static function ibs_ghl_create_form_meta_table() {
	    // Create the table
        global $wpdb;
        
        $table_name = $wpdb->prefix . 'ibs_ghl_form_meta';
        $charset_collate = $wpdb->get_charset_collate();
        
        //create table only if doesnot exist
        if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
            $sql = "CREATE TABLE $table_name (
                id INT(11) NOT NULL AUTO_INCREMENT,
                form_id INT(11) NOT NULL,
                display_meta LONGTEXT,
                confirmations LONGTEXT,
                notifications LONGTEXT,
                PRIMARY KEY (id)
            ) $charset_collate;";
        
            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
            dbDelta($sql);
        }
        
	}

    public static function ibs_ghl_form_entries(){
        global $wpdb;
        
        $table_name = $wpdb->prefix . 'ibs_ghl_form_entries';
        $charset_collate = $wpdb->get_charset_collate();
        
        //create table only if doesnot exist
        if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
            $sql = "CREATE TABLE $table_name (
                id INT(11) NOT NULL AUTO_INCREMENT,
                form_id INT(11) NOT NULL,
                entries LONGTEXT,
                PRIMARY KEY (id)
            ) $charset_collate;";
        
            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
            dbDelta($sql);
        }
    } 
    public static function ibs_ghl_field_mapping(){
        global $wpdb;
        
        $table_name = $wpdb->prefix . 'ibs_ghl_field_mapping';
        $charset_collate = $wpdb->get_charset_collate();
        
        //create table only if doesnot exist
        if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
            $sql = "CREATE TABLE $table_name (
                id INT(11) NOT NULL AUTO_INCREMENT,
                form_id INT(11) UNIQUE,
                mapped_data LONGTEXT,
                PRIMARY KEY (id)
            ) $charset_collate;";
        
            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
            dbDelta($sql);
        }
    } 

}
