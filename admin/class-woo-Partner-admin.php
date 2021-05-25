<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://blu.com
 * @since      1.0.0
 *
 * @package    Woo_Partner
 * @subpackage Woo_Partner/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Woo_Partner
 * @subpackage Woo_Partner/admin
 * @author     Your Name <email@example.com>
 */

class Woo_Partner_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $woo_Partner    The ID of this plugin.
	 */
	private $woo_Partner;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Other public variables
	 */


	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $woo_Partner       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $woo_Partner, $version ) {

		$this->woo_Partner = $woo_Partner;
		$this->version = $version;
		
		global $woocommerce;

		// Checks if WooCommerce is available
		if ( !$woocommerce ) {
			add_action( 'admin_menu', array( &$this, 'woo_Partner_show_admin' ) );
        } else {
			add_action( 'admin_notices', function() {
                echo '<div style="background-color:#cf0000;color:#fff;font-weight:bold;font-size:16px;margin: -1px 15px 0 5px;padding:5px 10px">';
                echo 'WooCommerce not found.';
                echo '</div>';
            } );
            return;
		}

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Woo_Partner_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Woo_Partner_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->woo_Partner, plugin_dir_url( __FILE__ ) . 'css/woo-Partner-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Woo_Partner_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Woo_Partner_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->woo_Partner, plugin_dir_url( __FILE__ ) . 'js/woo-Partner-admin.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( 'jquery' );
	}

	/**
	 * Set Admin Panel
	 */
	public function woo_Partner_show_admin() {

		add_menu_page( 

			__('WooPartner'), 
			__('WooPartner'), 
			'manage_options', 
			'wooPartner', 
			array( &$this, 'woo_Partner_admin_page' ), 
			"dashicons-cart",
			1000

		);
	}

	public function woo_Partner_admin_page() {
        
		$referral_info_table_data = $this->woo_Partner_get_ref_info();
		$username_list = json_decode(json_encode($this->woo_Partner_get_distinct_username_list()), true);
		// die($username_list[0]->user_id);
		$user_selector = $this->woo_Partner_show_selector_from_list($username_list);

		include_once("partials/woo-Partner-admin-display.php");
    }

	public function woo_Partner_get_ref_info() {

		global $wpdb;

		// $ref_info = $wpdb->get_results("SELECT * FROM `wp_referral_info`");
		$ref_info = $wpdb->get_results(
			"SELECT a.ID AS user_id, b.id AS ref_id, a.user_nicename, a.display_name, b.referral_link, b.product_link, b.used_times, b.enabled
			FROM `wp_users` AS a 
			INNER JOIN `wp_referral_info` AS b
			ON a.ID = b.user_id
			ORDER BY a.ID"
		);
		return $ref_info;
	}

	public function woo_Partner_get_distinct_username_list() {

		global $wpdb;

		$table_name = $wpdb->prefix . 'referral_info';
		$ref_info = $wpdb->get_results("SELECT DISTINCT `user_id` FROM " . $table_name . " ORDER BY `user_id`");
		// die($ref_info);
		return $ref_info;
	}

	public function woo_Partner_show_selector_from_list($list) {
		$html = '<select name="user_selector" id="user_selector">';
			foreach ($list as $iter => $val) {
				$html = $html . '<option value="' . ($iter + 1) . '">' . ($iter + 1) . '</option>';
			}
		$html = $html . '</select>';
		return $html;
	}

	public function woo_Partner_admin_form_handler() {

		add_action( 'admin_post_nopriv_custom_admin_form_action', '_handle_admin_form_action' );
		add_action( 'admin_post_custom_admin_form_action', '_handle_admin_form_action' );

		function _handle_admin_form_action() {
			global $wpdb;
			// var_dump($wpdb);
			// die('ok');
			if (isset($_POST["edit-ref"]) && $_POST["edit-ref"] + 0 > -1) {

				die("edit");
				// $sql = $wpdb->prepare( "DELETE FROM "  . $wpdb->prefix . "referral_info WHERE id = " . $_POST["edit-ref"] );
				// $wpdb->query($sql);
				// echo "edit!";

			} elseif (isset($_POST["remove-ref"]) && $_POST["remove-ref"] + 0 > -1) {
				
				
				$sql = $wpdb->prepare( "DELETE FROM "  . $wpdb->prefix . "referral_info WHERE id = " . $_POST["remove-ref"] );
				// die($sql);
				$wpdb->query($sql);

			} elseif (isset($_POST["new_link"]) && $_POST["new_link"] + 0 > -1) {

				$user_id = $_POST["user_selector"];
				$product_link = $_POST["new_link"];
				$referral_link = md5($product_link);

				$sql = $wpdb->prepare( "INSERT INTO " . $wpdb->prefix . "referral_info (user_id, referral_link, product_link, used_times, enabled) VALUES (%d, %s, %s, %d, %d)", $user_id, $referral_link, $product_link, 0, 1 );

				$wpdb->query($sql);
					
				// $wpdb->insert( $wpdb->prefix . 'referral_info', array("user_id" => $user_id, "referral_link" => $referral_link, "product_link" => $product_link, "used_times" => 0, "enabled" => 1), array("%d", "%s", "%s", "%d", "%d") );
			}

			wp_redirect( admin_url('admin.php?page=wooPartner') );
			exit;
		}
	}
}
