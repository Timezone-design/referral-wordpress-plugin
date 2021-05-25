<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://blu.com
 * @since      1.0.0
 *
 * @package    Woo_Partner
 * @subpackage Woo_Partner/admin/partials
 */
?>

<div class="wrap">
	<h2><?php _e("Woo Partner"); ?></h2>

	<br />

	<p><?php _e(""); ?></p>
	
	<div class="wc-wooP">
        <form class="wc-wooP-form" action="<?php echo esc_url( admin_url('admin-post.php') ); ?>" method="POST">
        <input type="hidden" name="action" value="custom_form_action">
        <input type="hidden" name="edit-ref" class="edit-ref" value="-1">
        <input type="hidden" name="remove-ref" class="remove-ref" value="-1">
            <div class="ref-info">
                <h2><?php _e("Here are referral links your affiliators are using now.") ?></h2>
                <table class="form-table">
                    <tbody>
                        <tr>
                            <th><label><?php _e("User Id"); ?></label></th>
                            <th><label><?php _e("Username"); ?></label></th>
                            <th><label><?php _e("Full Name"); ?></label></th>
                            <th><label><?php _e("Referral URL"); ?></label></th>
                            <th><label><?php _e("Redirect URL"); ?></label></th>
                            <th><label><?php _e("Used times"); ?></label></th>
                            <th><label><?php _e("Enabled"); ?></label></th>
                        </tr>
                        <?php foreach ($referral_info_table_data as $iter) { ?>
                            <tr>
                                <td class="inp"><?php echo $iter->user_id ?></td>
                                <td class="inp"><?php echo $iter->user_nicename ?></td>
                                <td class="inp"><?php echo $iter->display_name ?></td>
                                <td class="inp"><?php echo $iter->referral_link ?></td>
                                <td class="inp"><?php echo $iter->product_link ?></td>
                                <td class="inp"><?php echo $iter->used_times ?></td>
                                <td class="inp"><?php echo $iter->enabled ?></td>
                                <td>
                                    <span class="edit" onclick="jQuery('input.edit-ref').val('<?php echo $iter->ref_id ?>'), jQuery('.wc-wooP-form').submit();">
                                        <div class="dashicons dashicons-edit"></div>
                                    </span>
                                    &nbsp;
                                    <span class="remove" onclick="jQuery('input.remove-ref').val('<?php echo $iter->ref_id ?>'), jQuery('.wc-wooP-form').submit();">
                                        <div class="dashicons dashicons-trash"></div>
                                    </span>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

            <div class="new_link">
                <h2><?php _e("Add new referral links") ?></h2>
                <?php echo $user_selector ?>
                <input name="new_link" class="" type="text" placeholder="Input new link here.">
                <input name="save" class="button-primary" type="submit" value="Save">
            </div>
		</form>
    </div>
</div>