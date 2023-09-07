<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://www.ibsofts.com
 * @since      1.0.0
 *
 * @package    Ghl_Wordpress
 * @subpackage Ghl_Wordpress/public/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<form  id="ibs-ghl-form<?php echo $a['id']; ?>" method='post' name="submitted">
    <!-- <input type="submit" value="Submit" name="submitted"/> -->
</form>

<script>
    jQuery(function($) {
      var container = document.getElementById("ibs-ghl-form<?php echo $a['id']; ?>");
      
      var formData = '<?php echo $form_meta['display_meta']; ?>';
      
      var formRenderOpts = {
        container,
        formData,
        dataType: 'json'
      };
      $(container).formRender(formRenderOpts);
      
    });
</script>

<?php
$query=new Ghl_Wordpress_Query();
if(isset($_POST['Submit'])){

  ob_start();
  var_dump($_POST);
  $dump_output = ob_get_clean();

  global $wpdb;
  $table_name = $wpdb->prefix . 'ibs_ghl_form_entries';
  
  // var_dump($_POST);
  $myArray = array(); // Initialize the array before the loop
  // var_dump($a['id']);

  $mapped_data=$query->ibs_ghl_get_form_mapping_data($a['id']);
  $user_email =$mapped_data[0]->user_email;
  $user_name =$mapped_data[0]->user_name;
  $user_phone =$mapped_data[0]->user_phone;




foreach ($_POST as $field_name => $field_value) {
    // Sanitize field name and value
    $sanitized_field_name = sanitize_text_field($field_name);
    $sanitized_field_value = sanitize_text_field($field_value);

    // Add the key-value pair to the array
    $myArray[] = array($sanitized_field_name => $sanitized_field_value);
    
    // checking the variables name
    if(strpos(($sanitized_field_name), $user_name) !== false){
      $name=$sanitized_field_value;
    }
    else if(strpos(($sanitized_field_name), $user_email) !== false){
      $email=$sanitized_field_value;
    }
    else if (strpos($sanitized_field_name, $user_phone) !== false){
      $phone=$sanitized_field_value;
    }
}
var_dump($name,$email,$phone);
// $api=new Ghl_Wordpress_API();
// $api->ibs_ghl_send_to_ghl($first_name,$last_name,$email,$phone);
$serialized_array = json_encode($myArray);
$wpdb->insert(
  $table_name,
  array(
        'form_id'=> $a['id'],
        'entries' => $serialized_array,
    ),
  array(
        '%s',
    )
  );
}
?>


