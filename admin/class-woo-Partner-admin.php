<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://example.com
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
	public $wooPartner_in_db;
	public $WooBtn = "";


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

	function getAttrKey() {
		$add = $this->attrId;
		foreach ( $this->address as $k => $val ) {
			$add .= "&$k=".$val;
		}
		return $add;
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
			'wooParnter', 
			array( &$this, 'woocommerce_wooP_page' ), 
			"dashicons-cart",
			1000

		);
	}

	public function woocommerce_wooP_page() {

        global $wcps_url_plugin;
		
		$_this = $this;
		$wooP  = $this->saveDate();
		include_once("partials/woo-Partner-admin-display.php");
    }

	public function saveDate() {

        $this->wooP_in_db = get_option("wc_wooP");
		// echo $this->wooP_in_db;
		$this->downloadeBtn   = str_replace('\\',"",get_option("wc_wooP_downloadeBtn"));
		$this->WooBtn         = str_replace('\\',"",get_option("wc_wooP_WooBtn"));
		
        if(isset($_POST['wooP'])) {
			// echo "post-wooP is set.";
            $wooP = $_POST['wooP'];
			
            if(is_array($this->wooP_in_db)){
                update_option("wc_wooP",$wooP);
            }else{
                add_option("wc_wooP",$wooP);
            }

        }else{
            if(is_array($this->wooP_in_db)){
                $wooP = $this->wooP_in_db;
            }else{
                $wooP = array("produkt-ID" => array(""), "post-ID" => array(""));
                add_option("wc_wooP",$wooP);
            }
        }
		
		if(isset($_POST["downloadeBtn"])){
        	update_option("wc_wooP_downloadeBtn",$_POST["downloadeBtn"]);
			$this->WooBtn = $_POST["downloadeBtn"];
		}elseif(!isset($this->downloadeBtn)){
			$this->downloadeBtn = $this->downloadeBtnDefault;
			add_option("wc_wooP_downloadeBtn",$_POST["downloadeBtn"]);
		}
		
		if(isset($_POST["WooBtn"])){
        	update_option("wc_wooP_WooBtn",$_POST["WooBtn"]);
			$this->WooBtn = $_POST["WooBtn"];
		}elseif(!isset($this->WooBtn)){
			$this->WooBtn = $this->WooBtnDefault;
			add_option("wc_wooP_WooBtn",$_POST["WooBtn"]);
		}

        return $wooP;
    }

	public function woo_Partner_write_referral_url_into_db() {

		add_action( 'admin_post_nopriv_custom_form_action', '_handle_form_action' );
		add_action( 'admin_post_custom_form_action', '_handle_form_action' );

		function _handle_form_action() {
			die($_POST);
			wp_redirect( admin_url('admin.php?page=wooparter') );
			exit;
		}
	}
}
