
<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://www.ibsofts.com
 * @since      1.0.0
 *
 * @package    Ghl_Wordpress
 * @subpackage Ghl_Wordpress/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<h1>Preview</h1>
<form action="" method="post" id='ibs-ghl-form'>
    <h2><?php echo $title; ?> </h2>
    <!-- <?php echo $form_meta['display_meta'];?> -->
    <!-- <div  id="build-wrap"></div>   -->
     
</form>
<script>
    jQuery(function($) {
      var container = document.getElementById('ibs-ghl-form');
      var formData = '<?php echo $form_meta['display_meta']; ?>';
    
      var formRenderOpts = {
        container,
        formData,
        dataType: 'json'
      };
    
      $(container).formRender(formRenderOpts);
    });
</script>
