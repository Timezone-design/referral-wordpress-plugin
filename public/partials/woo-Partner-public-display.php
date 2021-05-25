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
?>

<div class="ref-access">
    <?php if ( is_user_logged_in() ) {
        
        $current_user = wp_get_current_user();
        $ref_data = get_referral_link_by_user_id($current_user->ID);

        if (count($ref_data) == 0) {
            
            echo "<h1>Oops, it seems you don't have any referral links yet.<h1>";

        } else { ?>

            <form class="user-ref-input" action="<?php echo esc_url( admin_url('admin-post.php') ); ?>" method="POST">]
                
            <table class="ref-data">
                    <tr>
                        <th>Your referral link ID</th>
                        <th>Your product link(s)</th>
                        <th>Your referral link(s)</th>
                        <th>Used times</th>
                        <th>Allowed?</th>
                    </tr>
                    <?php foreach ($ref_data as $data) { ?>
                        <tr>
                            <td><?php echo $data->id ?></td>
                            <td><?php echo $data->referral_link ?></td>
                            <td><?php echo $data->product_link ?></td>
                            <td><?php echo $data->used_times ?></td>
                            <td><?php echo $data->enabled ?></td>
                            <td>
                                <!-- <span class="edit" onclick="jQuery('input.edit-ref').val('<?php echo $iter->ref_id ?>'), jQuery('.wc-wooP-form').submit();">
                                    <div class="dashicons dashicons-edit"></div>
                                </span>
                                &nbsp; -->
                                <span class="remove" onclick="jQuery('input.remove-ref').val('<?php echo $iter->ref_id ?>'), jQuery('.wc-wooP-form').submit();">
                                    <div class="dashicons dashicons-trash"></div>
                                </span>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
                
                <div class="new-ref">
                    <h2><?php _e("Ask for a new referral link:") ?></h2>
                    <button name="save" class="button-primary" type="button">Ask for a new link!</button>
                </div>
            </form>
            
        <?php }
        
    } else {

        echo "<h1>Please log in to manage your referral links.<h1>";

    }
    ?>
</div>