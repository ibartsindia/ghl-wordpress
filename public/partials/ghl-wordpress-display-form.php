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

<form action="#" id="ibs-ghl-form">
    <input type="submit" value="Submit" />
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