<?php
// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://www.multidots.com/
 * @since      1.0.0
 *
 * @package    page-visit-counter
 * @subpackage page-visit-counter/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    page-visit-counter
 * @subpackage page-visit-counter/includes
 * @author     Multidots <wordpress@multidots.com>
 */
class page_visit_counter {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Woo_Extra_Flat_Rate_Loader $loader Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string $plugin_name The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string $version The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */

	public function __construct() {

		$this->plugin_name = 'page-visit-counter';
		$this->version     = '1.0.0';
		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-page-visit-counter-loder.php';
		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-page-visit-counter-admin.php';
		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-page-visit-counter-public.php';
		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-page-visit-counter-i18n.php';

		$this->loader = new page_visit_counter_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Woo_Extra_Cost_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Page_Visit_Counter_i18n();
		$plugin_i18n->set_domain( $this->get_plugin_name() );

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {
		global $wp, $wpdb;

		$plugin_admin = new page_visit_counter_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

		$this->loader->add_action( 'admin_menu', $plugin_admin, 'page_visit_counter_menu' );
		$this->loader->add_action( 'wp_dashboard_setup', $plugin_admin, 'my_custom_dashboard_widgets' );

		$this->loader->add_action( 'wp_ajax_get_page_visit_record_report', $plugin_admin, 'get_page_visit_record_report' );
		$this->loader->add_action( 'wp_ajax_nopriv_get_page_visit_record_report', $plugin_admin, 'get_page_visit_record_report' );

		$this->loader->add_action( 'wp_ajax_select_input_page_value', $plugin_admin, 'select_input_page_value' );
		$this->loader->add_action( 'wp_ajax_nopriv_select_input_page_value', $plugin_admin, 'select_input_page_value' );

		$this->loader->add_action( 'wp_ajax_add_plugin_user_pvcp', $plugin_admin, 'wp_add_plugin_userfn' );

		$this->loader->add_action( 'admin_init', $plugin_admin, 'add_custom_meta_box_page_visit' );

		$this->loader->add_action( 'save_post', $plugin_admin, 'save_custom_meta_box_page_visit' );

		$this->loader->add_action( 'admin_init', $plugin_admin, 'welcome_page_visit_counter_screen_do_activation_redirect' );
		//admin menu intilization hooks
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'welcome_pages_screen_page_visit_counter' );

		$this->loader->add_action( 'page_visit_counter_about', $plugin_admin, 'page_visit_counter_about' );

		$this->loader->add_action( 'admin_print_footer_scripts', $plugin_admin, 'custom_admin_pointers_footer' );

		$this->loader->add_action( 'admin_post_submit_form_pvc', $plugin_admin, 'add_page_count_option' );
		$this->loader->add_action( 'admin_post_nopriv_submit_form_pvc', $plugin_admin, 'add_page_count_option' );

		$this->loader->add_action( 'plugins_loaded', $plugin_admin, 'check_page_visit_history_table_exisit' );
		$this->loader->add_action( 'plugin_row_meta', $plugin_admin, 'check_page_visit_plugin_row_meta',10,2 );

		add_action( 'wp_loaded', function () {
			$fetchSelecetedPostTypes = json_decode( get_option( 'wfap_post_type' ) );
			if ( isset( $fetchSelecetedPostTypes ) && ! empty( $fetchSelecetedPostTypes ) ) {
				foreach ( $fetchSelecetedPostTypes as $postsingle ) {
					add_filter( "manage_edit-" . $postsingle . "_columns", "add_new_selected_post_columns" );
					add_action( "manage_" . $postsingle . "_posts_custom_column", "custom_columns_add_page_visit_count", 10, 2 );
				}
			} else {
				// Get all the registered post type
				global $wp_post_types;
				$post_types = get_post_types();

				foreach ( $post_types as $cpost ) {
					if ( $cpost != "attachment" && $cpost != "revision" && $cpost != "nav_menu_item" && $cpost != "product_variation" && $cpost != "shop_order" && $cpost != "shop_order_refund" && $cpost != "shop_coupon" && $cpost != "shop_webhook" && $cpost != "scheduled-action" && $cpost != "shop_subscription" && $cpost != "wpcf7_contact_form" && $cpost != "mc4wp-form" ) {
						add_filter( "manage_edit-" . $cpost . "_columns", "add_new_selected_post_columns" );
						add_action( "manage_" . $cpost . "_posts_custom_column", "custom_columns_add_page_visit_count", 2, 2 );
					}
				}
			}
		} );

		$this->loader->add_action( 'wp_ajax_get_visit_page_result_after_update_admin', $plugin_admin, 'get_visit_page_result_after_update_admin' );
		$this->loader->add_action( 'wp_ajax_nopriv_get_visit_page_result_after_update_admin', $plugin_admin, 'get_visit_page_result_after_update_admin' );

	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}
	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {
		global $wp, $wpdb;

		$plugin_public = new page_visit_counter_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

		$this->loader->add_action( 'wp_ajax_display_page_visit_counter_ajax', $plugin_public, 'display_page_visit_counter_ajax' );
		$this->loader->add_action( 'wp_ajax_nopriv_display_page_visit_counter_ajax', $plugin_public, 'display_page_visit_counter_ajax' );

		$this->loader->add_action( 'wp', $plugin_public, 'insert_page_visit_counter' );

		$this->loader->add_action( 'the_content', $plugin_public, 'insert_page_visit_counter_total_block', 99 );

		if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
			$this->loader->add_filter( 'woocommerce_paypal_args', $plugin_public, 'paypal_bn_code_filter', 99, 1 );
			$this->loader->add_action( 'woocommerce_after_shop_loop', $plugin_public, 'insert_page_visit_counter_total_block_shop_page', 99 );
			$this->loader->add_action( 'woocommerce_single_product_summary', $plugin_public, 'insert_page_visit_counter_total_block_shop_page', 99 );
		}

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    page_visit_counter_Loader Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}
}