<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       http://blu.com
 * @since      1.0.0
 *
 * @package    Woo_Partner
 * @subpackage Woo_Partner/public/partials
 */

function get_referral_link_by_user_id($id)
{
    global $wpdb;

    $table_name = $wpdb->prefix . 'referral_info';
    $ref_info = $wpdb->get_results("SELECT * FROM " . $table_name . " WHERE user_id = " . $id);

    return $ref_info;
    
}

?>

<div class="ref-access">
    <?php if ( is_user_logged_in() ) {
        
        $current_user = wp_get_current_user();
        $ref_data = get_referral_link_by_user_id($current_user->ID);

        if (count($ref_data) == 0) {
            
            echo "<h1>Oops, it seems you don't have any referral links yet.<h1>";

        } else { ?>

            <form class="user-ref-input" action="<?php echo esc_url( admin_url('admin-post.php') ); ?>" method="POST">
                <input type="hidden" name="action" value="custom_user_form_action">
                <input type="hidden" name="remove-ref" class="remove-ref" value="-1">
                <input type="hidden" name="current-url" class="current-url" value="-1">
                
                <table class="ref-data">
                    <tr>
                        <th><?php _e("Your referral link ID") ?></th>
                        <th><?php _e("Your product link(s)") ?></th>
                        <th><?php _e("Your referral link(s)") ?></th>
                        <th><?php _e("Used times") ?></th>
                        <th><?php _e("Allowed?") ?></th>
                        <th><?php _e("Actions") ?></th>
                    </tr>
                    <?php foreach ($ref_data as $data) { ?>
                        <tr>
                            <td><?php echo $data->id ?></td>
                            <td><?php echo get_site_url() . "/" . $data->referral_link ?></td>
                            <td><?php echo get_site_url() . "/" . $data->product_link ?></td>
                            <td><?php echo $data->used_times ?></td>
                            <td><?php echo $data->enabled ?></td>
                            <td>
                                <span class="remove" onclick="jQuery('input.remove-ref').val('<?php echo $data->id ?>'), jQuery('input.current-url').val('<?php echo get_current_blog_id() ?>'), jQuery('.user-ref-input').submit();">
                                    <div class="dashicons dashicons-trash"></div>
                                </span>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            </form>
            
        <?php } ?>
        <div class="new-ref">
            <p><?php _e("Ask for a new referral link:") ?></p>
            <button name="save" class="button-primary" type="button">Ask for a new link!</button>
        </div> 
    <?php 
    } else {

        echo "<h1>Please log in to manage your referral links.<h1>";

    }
    ?>
</div>