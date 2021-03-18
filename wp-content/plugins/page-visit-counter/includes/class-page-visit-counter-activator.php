<?php
// If this file is called directly, abort.
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
/**
 * Fired during plugin activation
 *
 * @link       http://www.multidots.com/
 * @since      1.0.0
 *
 * @package    page-visit-counter
 * @subpackage page-visit-counter/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    page-visit-counter
 * @subpackage page-visit-counter/includes
 * @author     Multidots <wordpress@multidots.com>
 */
/**
 * create wp_page_visit table in database at plugin activate.
 *
 */
class class_Page_Visit_Activator {

	public static function activate() {
	
		global $wpdb;
		$table_name = $wpdb->prefix . "page_visit";
		if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
			$sql = "CREATE TABLE $table_name (
				id int(11) unsigned NOT NULL AUTO_INCREMENT,
				page_id int(5) NOT NULL,
				page_visit  int(5) NOT NULL,
				date  date NOT NULL,
				lastdate  date NOT NULL,
				ipaddress varchar(255) NOT NULL,
				PRIMARY KEY  (id)
				);";	
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
		//add_option( 'contact_db_version', $contact_db_version );
		}
		
		update_option('counter_hide_show_front_vew','');
		update_option("text_color_page_visit","#000000");
		
		//Set Transist once pluign activated
		set_transient( '_welcome_screen_page_visitor_activation_redirect_data', true, 30 );
		
		if( in_array( 'woocommerce/woocommerce.php',apply_filters('active_plugins',get_option('active_plugins'))) && !is_plugin_active_for_network( 'woocommerce/woocommerce.php' )   ) { 
			$flag = '1';
		} else {
			$flag = '0';
		}
		
		$post_types = get_post_types();
		$postArr = array();
		if (isset($post_types) && !empty($post_types)) {
			foreach ($post_types as $cpost) {
				if($cpost != "attachment" && $cpost != "revision" && $cpost != "nav_menu_item" && $cpost != "product_variation" && $cpost != "shop_order" && $cpost != "shop_order_refund" && $cpost != "shop_coupon" && $cpost != "shop_webhook" && $cpost != "scheduled-action" && $cpost != "shop_subscription"&& $cpost != "wpcf7_contact_form"&& $cpost != "mc4wp-form") {
					$postArr[] = $cpost;
				}
			}
		}
		
		delete_option('wfap_post_type');
		if (isset($postArr) && $postArr != null) {
			update_option('wfap_post_type',json_encode(array_values($postArr)));
		}
			
		/*global $current_user;
		wp_get_current_user();
				
		$useremail = $current_user->user_email;
		
		$log_url = $_SERVER['HTTP_HOST'];
		$log_plugin_id = 6;
		$log_activation_status = 1;
		$cur_dt = date('Y-m-d');
		
		wp_remote_request('http://mdstore.projectsmd.in/webservice.php?log_url='.$log_url.'&plugin_id='.$log_plugin_id.'&activation_status='.$log_activation_status.'&activation_date='.$cur_dt.'&user_email='.$useremail.'&flag='.$flag);*/
			
	}
}	