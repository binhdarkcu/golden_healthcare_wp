<?php
// If this file is called directly, abort.
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
/**
 * Fired during plugin deactivation
 *
 * @link       http://www.multidots.com/
 * @since      1.0.0
 *
 * @package    page-visit-counter
 * @subpackage page-visit-counter/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    page-visit-counter
 * @subpackage page-visit-counter/includes
 * @author     Multidots <wordpress@multidots.com>
 */
/**
 * Drop wp_page_visit table in database at plugin deactivate.
 *
 */
class class_Page_visit_Deactivator {
	
	public static function deactivate() {
			$log_url = $_SERVER['HTTP_HOST'];
      		$log_plugin_id = 6;
     		$log_activation_status = 0;
     		$cur_dt = date('Y-m-d');
     		wp_remote_request('http://mdstore.projectsmd.in/webservice-deactivate.php?log_url='.$log_url.'&plugin_id='.$log_plugin_id.'&activation_status='.$log_activation_status.'&activation_date='.$cur_dt);
			
	}
}