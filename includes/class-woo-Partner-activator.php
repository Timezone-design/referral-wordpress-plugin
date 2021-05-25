<?php

/**
 * Fired during plugin activation
 *
 * @link       http://blu.com
 * @since      1.0.0
 *
 * @package    Woo_Partner
 * @subpackage Woo_Partner/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Woo_Partner
 * @subpackage Woo_Partner/includes
 * @author     Your Name <email@example.com>
 */
class Woo_Partner_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		register_activation_hook( __FILE__, 'wooPartner_create_table_on_activation' );
	}

	private function wooPartner_create_table_on_activation(){
		// create the custom table
		global $wpdb;
		
		$table_name = $wpdb->prefix . 'referral_info';
		$charset_collate = $wpdb->get_charset_collate();
		
		$sql = "CREATE TABLE IF NOT EXISTS $table_name (`id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
		`user_id` INT (20) NOT NULL,
		`referral_link` VARCHAR (100) NOT NULL,
		`product_link` VARCHAR (100) NOT NULL,
		`used_times` INT (4) ZEROFILL NOT NULL,
		`enabled` BOOLEAN NOT NULL,
		PRIMARY KEY (`id`) ) $charset_collate;";
		
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
	}

}
