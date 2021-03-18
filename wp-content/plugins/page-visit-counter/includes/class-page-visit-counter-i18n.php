<?php
// If this file is called directly, abort.
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Page_Visit_Counter
 * @subpackage Page_Visit_Counter/includes
 * @author     Multidots <wordpress@multidots.com>
 */
class Page_Visit_Counter_i18n {

	/**
	 * The domain specified for this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $domain    The domain identifier for this plugin.
	 */
	private $domain;

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {
		$locale = apply_filters( 'plugin_locale', get_locale(), $this->domain );
		$mofile = $this->domain . '-' . $locale . '.mo';
		$path = WP_PLUGIN_DIR . '/' . trim( $this->domain.'/languages', '/' );
		load_textdomain( $this->domain, $path . '/'. $mofile );
		$plugin_rel_path = apply_filters( 'woocommerce_page_visit_translation_file_rel_path', $this->domain.'/languages' );
		load_plugin_textdomain( $this->domain, false, $plugin_rel_path ); 
	}

	/**
	 * Set the domain equal to that of the specified domain.
	 *
	 * @since    1.0.0
	 * @param    string    $domain    The domain that represents the locale of this plugin.
	 */
	public function set_domain( $domain ) {
		$this->domain = $domain;
	}

}
