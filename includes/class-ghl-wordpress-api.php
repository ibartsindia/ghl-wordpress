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
        
        public static function ibs_ghl_create_contact($contact_data){
            
            $api_key = get_option('ibs_ghl_subaccount_api_key');
            var_dump($contact_data);
            if ($api_key) {
				// $endpoint = API_ENDPOINT;

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