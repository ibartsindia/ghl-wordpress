<?php

    /**
     * The file that defines the API functions for Go High Level
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

    class Ghl_Wordpress_API {
        
        public static function ibs_ghl_send_to_ghl($first_name,$last_name,$email,$phone){
            var_dump($first_name,$last_name,$email,$phone);
            $api_key = get_option('ibs_ghl_subaccount_api_key');

            if ($api_key) {
				$endpoint = 'https://rest.gohighlevel.com/v1/contacts/';

                $name_value = trim($first_name . ' ' . $last_name );
                $tags='Hello';	

                $contact_data = array(
                        'name' => $name_value,
                        'email' => $email,
                        'phone' => $phone,
                        'tags' => $tags,
                );
                // $response = wp_remote_post( $endpoint, array(
                //         'method'      => 'POST',
                //         'timeout'     => 45,
                //         'redirection' => 5,
                //         'httpversion' => '1.0',
                //         'blocking'    => true,
                //         'headers'     => array(
                //             'Content-Type' => 'application/json',
                //             'Accept' => 'application/json',
                //             'Authorization' => 'Bearer ' . $api_key
                //         ),
                //         'body'        => json_encode($contact_data),
                //         'cookies'     => array()
                //     ) 
                // );
		    }
        }
    }