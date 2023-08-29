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
<div class="wrap" id="ibs-ghl-forms">
    <h1 class="wp-heading-inline" style="font-family:inherit;font-weight:500;">Add Form</h1>
    <hr class="wp-header-end">
    <form id="ibs-ghl-add-form" method="post">
        <div class="row ibs_ghl_form">
            <div class="ibs_ghl_form_title">
                <input type="text" name="title" value="<?php echo $title; ?>" />
                <input type="hidden" name="form_id" value="<?php echo $id; ?>" />
            </div>
            <div class="ibs_ghl_form_action">
                <input type="submit" class="button button-primary" value="Save Form" style="margin-left:10px;margin-bottom:7px;"/>
                <br/>
                <input style="margin-left:10px;" type="checkbox" name="status" <?php if($is_active == 1) echo 'checked'; ?> /> Save as Draft
            </div>
        </div>
    </form>
    <div id="build-wrap"></div>
</div>

<script>
    setTimeout(function(){
        formBuilder.actions.setData('<?php echo $form_meta['display_meta']; ?>');
    }, 1000);
</script>
    