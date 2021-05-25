<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://example.com
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

			<table class="form-table">
				<tbody>
					<tr>
						<th><label><?php _e("User"); ?></label></th>
						<th><label><?php _e("Referral URL"); ?></label></th>
					</tr>
					<tr>
						<td class="inp">User selector</td>
						<td class="inp">
							https://justgo.ch/rel=username
						</td>
						<td>
							<a href="#add" class="clone-ele">
								<div class="dashicons dashicons-plus"></div>
							</a>
							<a href="#remove" class="remove-ele">
								<div class="dashicons dashicons-trash"></div>
							</a>
						</td>
					</tr>
				</tbody>
			</table>

			<input name="save" class="button-primary" type="submit" value="Save">
		</form>
    </div>
</div>