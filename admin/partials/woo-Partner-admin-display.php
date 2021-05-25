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
        <div class="ref-info">
            <h2><?php _e("Here are referral links your affiliators are using now.") ?></h2>
            <table class="form-table">
                <tbody>
                    <tr>
                        <th><label><?php _e("User"); ?></label></th>
                        <th><label><?php _e("Referral URL"); ?></label></th>
                    </tr>
                    <?php foreach ($referral_info_table_data as $iter) { ?>
                        <tr>
                            <td class="inp"><?php echo $iter->user_id ?></td>
                            <td class="inp"><?php echo $iter->referral_link ?></td>
                            <td>
                                <a href="#add" class="clone-ele">
                                    <div class="dashicons dashicons-edit"></div>
                                </a>
                                &nbsp;
                                <a href="#remove" class="remove-ele">
                                    <div class="dashicons dashicons-trash"></div>
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

		<form class="wc-wooP-form" action="<?php echo esc_url( admin_url('admin-post.php') ); ?>" method="POST">
			<input type="hidden" name="action" value="custom_form_action">
            <h2><?php _e("Add new referral links") ?></h2>
            <?php echo $user_selector ?>
            <input name="new_link" class="" type="text" placeholder="Input new link here.">
			<input name="save" class="button-primary" type="submit" value="Save">
		</form>
    </div>
</div>