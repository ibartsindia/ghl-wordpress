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
 * The plugin class for all db query.
 *
 * @since      1.0.0
 * @package    Ghl_Wordpress
 * @subpackage Ghl_Wordpress/includes
 * @author     iB Softs <support@ibsofts.com>
 */
class Ghl_Wordpress_Query {
    
    public function ibs_ghl_insert_form($data) {
        
        global $wpdb;
        // Insert the data into the custom table
        $table_name = $wpdb->prefix . 'ibs_ghl_form';
        $wpdb->insert($table_name, $data);
		
        // Check if the insertion was successful
        if ($wpdb->insert_id) {
            return $wpdb->insert_id;
        }
        
        
    }
    
    public function ibs_ghl_update_form($form_id, $data) {
        
        global $wpdb;

        $table_name = $wpdb->prefix . 'ibs_ghl_form';
        
        $where = array('id' => $form_id);
        
        $wpdb->update($table_name, $data, $where);
        
        // Check if the update was successful
        if ($wpdb->last_error === '') {
            return ['status' => 200];
        }
        
    }
    
    public function ibs_ghl_insert_form_meta($data) {
        global $wpdb;
        
        $table_name = $wpdb->prefix . 'ibs_ghl_form_meta';
        $wpdb->insert($table_name, $data);
		
        if ($wpdb->insert_id) {
            return $wpdb->insert_id;
        }
    }
    
    public function ibs_ghl_update_form_meta($form_id, $data) {
        global $wpdb;

        $table_name = $wpdb->prefix . 'ibs_ghl_form_meta';
        
        $where = array('id' => $form_id);
        
        $wpdb->update($table_name, $data, $where);
        
        // Check if the update was successful
        if ($wpdb->last_error === '') {
            return ['status' => 200];
        }
    }
    
    public function ibs_ghl_get_form_data($form_id) {
        global $wpdb;
        $data = [];
        
        $table_name = $wpdb->prefix . 'ibs_ghl_form';
        
        $query = $wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $form_id);
        
        $result = $wpdb->get_row($query);

        if ($result) {
            $data = [
                    'title' => $result->title,
                    'is_active' => $result->is_active,
                ];
            
            return $data;
        }
        
    }
    

    public function ibs_ghl_get_form_meta($form_id) {
        
        global $wpdb;
        $data = [];
        
        $table_name = $wpdb->prefix . 'ibs_ghl_form_meta';
        
        $query = $wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $form_id);
        
        $result = $wpdb->get_row($query);

        if ($result) {
            $data = [
                    'display_meta' => $result->display_meta,
                ];
            
            return $data;
        }
        
    }
    
    public function ibs_ghl_check_form_meta_exist($form_id) {
        global $wpdb;
        $data = [];
        
        $table_name = $wpdb->prefix . 'ibs_ghl_form_meta';
        
        $query = $wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $form_id);
        
        $result = $wpdb->get_row($query);

        if ($result) return true;
        
    }
    
    //sql for getting all the forms data as per is_trash attribute
    public function ibs_ghl_get_all_forms($form_name,$trash) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'ibs_ghl_form';
    
        $query = $wpdb->prepare("SELECT * FROM $table_name WHERE is_trash = %d AND title LIKE %s", $trash, '%'. $form_name .'%');
        $data = $wpdb->get_results($query);    
        
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
        }
    }

    //sql for counting the form as per the is_trash option
    public function ibs_ghl_count_form($trash){
        global $wpdb;
        $table_name = $wpdb->prefix . 'ibs_ghl_form';
        
        $count = $wpdb->get_results("SELECT COUNT(ID) FROM $table_name where is_trash=$trash");
        return $count[0]->{'COUNT(ID)'};
    }

    //changing the form is_trash from 1 to 0 using sql
    public function ibs_restore_form($id){
        global $wpdb;
        $table_name = $wpdb->prefix . 'ibs_ghl_form';
        
        $data_to_update = array(
            'is_trash' => '0'
        );
            
        $where_condition = array(
        'id' => $id 
        );
            
        $wpdb->update($table_name, $data_to_update, $where_condition);
        
        // Check if the update was successful
        if ($wpdb->last_error === '') {
            return ['status' => 200];
        }
    }

    //deleting the form permanently from the database
    public function ibs_delete_form_permanently($id){
        global $wpdb;
        $table_name = $wpdb->prefix . 'ibs_ghl_form';
       
        $wpdb->delete(
            $table_name,
            array('id' => $id),
            
        );
    }

    // changing the is_trash from 0 to 1
    public function ibs_trash($id){
        global $wpdb;
        $table_name = $wpdb->prefix . 'ibs_ghl_form';
        
        $data_to_update = array(
                'is_trash' => '1'
        );
        $where_condition = array(
           'id' => $id 
        );
            
        $wpdb->update($table_name, $data_to_update, $where_condition);
        // Check if the update was successful
        if ($wpdb->last_error === '') {
            return ['status' => 200];
        }
    }

    // getting the form name
    public function ibs_ghl_get_form_name($id){
        global $wpdb;
        $table_name = $wpdb->prefix . 'ibs_ghl_form';
        
        $form_name=$wpdb->get_results($wpdb->prepare("Select title from $table_name where id= %s",$id));
        return $form_name[0]->title;
    }

    public function ibs_ghl_get_form_entries($id){
        global $wpdb;
        $table_name = $wpdb->prefix . 'ibs_ghl_form_entries';
        
        $json=$wpdb->get_results($wpdb->prepare("Select * from $table_name where form_id= %s ",$id));
        return $json;
    }
    public function ibs_ghl_count_form_entries($id){
        global $wpdb;
        $table_name = $wpdb->prefix . 'ibs_ghl_form_entries';
        
        $count=$wpdb->get_var($wpdb->prepare("Select Count(*) from $table_name where form_id= %s ",$id));
        return $count;
    }

}