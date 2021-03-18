<?php
// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://www.multidots.com/
 * @since      1.0.0
 *
 * @package    page-visit-counter
 * @subpackage page-visit-counter/public
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    page-visit-counter
 * @subpackage page-visit-counter/public
 * @author     Multidots <wordpress@multidots.com>
 */
class page_visit_counter_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $plugin_name The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $version The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 *
	 * @param      string $plugin_name The name of this plugin.
	 * @param      string $version The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		global $wp;

		wp_enqueue_style( 'counter-style', plugin_dir_url( __FILE__ ) . 'css/counter-style.css' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		global $wp;
		wp_enqueue_script( 'one', plugin_dir_url( __FILE__ ) . 'js/custom.js', array( 'jquery' ), $this->version, false );
		$current_url = home_url( $wp->request );
		wp_localize_script( 'one', 'pagevisit', array(
			'ajaxurl' => admin_url( 'admin-ajax.php' ),
			'pageurl' => $current_url,
		) );

	}

	/**
	 * action use in call header
	 * Insert_page_visit_counter function use insert the page data
	 * pageid,Currentdate,Ipaddress,pagecount add in database.
	 */

	public function insert_page_visit_counter() {
		global $wpdb, $wp, $post, $wp_query;

		$flag = 0;
		// Check the site running on HTTPS. If the site running on HTTPS then we are removing S from HTTPS
		if ( is_ssl() ) {
			$actual_link = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			if ( strpos( $actual_link, 'wp-admin' ) !== false ) {
				$page = 0;
				$flag = 1;
			} else {
				$page = url_to_postid( preg_replace( '/^https(?=:\/\/)/i', 'http', esc_url( $actual_link ) ) );
			}
		} else {
			$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			if ( strpos( $actual_link, 'wp-admin' ) !== false ) {
				$page = 0;
				$flag = 1;
			} else {
				$page = url_to_postid( esc_url( $actual_link ) );
			}
		}
		$pageID = $page;
		if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
			if ( is_shop() ) {
				$page = (int) get_option( 'woocommerce_shop_page_id' );
			}
			if ( is_cart() ) {
				$page = (int) get_option( 'woocommerce_cart_page_id' );
			}
			if ( is_checkout() ) {
				$page = (int) get_option( 'woocommerce_checkout_page_id' );

			}
		}


		if ( $flag == 0 ) {

			if ( $page == 0 ) {
				$page = get_the_ID();
				if ( $page == 0 ) {
					$current_url = home_url( $wp->request );
					if ( is_ssl() ) {
						$page = url_to_postid( preg_replace( '/^https(?=:\/\/)/i', 'http', $current_url ) );
					} else {
						$page = url_to_postid( $current_url );
					}
					if ( $page == 0 ) {
						$queried_object = get_queried_object();

						if ( $queried_object ) {
							$post_id = $queried_object->ID;
							$page    = $post_id;
						}
					}
				}
			}
		}

                if ( $page != 0 ) {


			$table_name         = $wpdb->prefix . "page_visit";
			$table_name_history = $wpdb->prefix . "page_visit_history";
			$last_date          = '';
			$page_contet        = get_post( $page );

			$currentdate = date( "Y-m-d" );
			$ipaddress   = $_SERVER['REMOTE_ADDR'];

			$fetchSelecetedPostTypes = get_option( 'wfap_post_type' );
			if ( $fetchSelecetedPostTypes == '' || $fetchSelecetedPostTypes == null ) {
				$post_types = get_post_types();
				$postArr    = array();
				if ( isset( $post_types ) && ! empty( $post_types ) ) {
					foreach ( $post_types as $cpost ) {
						if ( $cpost != "attachment" && $cpost != "revision" && $cpost != "nav_menu_item" && $cpost != "product_variation" && $cpost != "shop_order" && $cpost != "shop_order_refund" && $cpost != "shop_coupon" && $cpost != "shop_webhook" && $cpost != "scheduled-action" && $cpost != "shop_subscription" && $cpost != "wpcf7_contact_form" && $cpost != "mc4wp-form" ) {
							$postArr[] = $cpost;
						}
					}
				}

				delete_option( 'wfap_post_type' );
				if ( isset( $postArr ) && $postArr != null ) {
					update_option( 'wfap_post_type', json_encode( array_values( $postArr ) ) );
				}
				$fetchSelecetedPostTypes = get_option( 'wfap_post_type' );
			}

			$postTypeSelectedDecodeArr = ! empty( $fetchSelecetedPostTypes ) ? $fetchSelecetedPostTypes : json_encode( array() );


			$fetchSelecetedIpAddress    = get_option( 'ipaddress_visit' );
			$optionsIpAddressDecodedArr = ! empty( $fetchSelecetedIpAddress ) ? $fetchSelecetedIpAddress : json_encode( array() );


			$fetchSelecetedUserId    = get_option( 'userlist_visit' );
			$optionsUserIdDecodedArr = ! empty( $fetchSelecetedUserId ) ? $fetchSelecetedUserId : json_encode( array() );

			$pageCount_limit = intval( 1 );
			$pageCount_qry   = $wpdb->prepare( 'SELECT * FROM ' . $table_name . ' WHERE page_id=%d AND ipaddress=%s AND date=%s LIMIT %d', $page, $ipaddress, $currentdate, $pageCount_limit );
			$pageCount       = $wpdb->get_results( $pageCount_qry );

			$getPageSetting = get_post_meta( $page, 'enable_page_count', true );

			$u_agent = $_SERVER['HTTP_USER_AGENT'];

			$bname    = 'Unknown';
			$platform = 'Unknown';
			$version  = "";
			$ub       = "";

			//First get the platform?
			if ( preg_match( '/linux/i', $u_agent ) ) {
				$platform = 'linux';
			} elseif ( preg_match( '/macintosh|mac os x/i', $u_agent ) ) {
				$platform = 'mac';
			} elseif ( preg_match( '/windows|win32/i', $u_agent ) ) {
				$platform = 'windows';
			}

			// Next get the name of the useragent yes seperately and for good reason
			if ( preg_match( '/MSIE/i', $u_agent ) && ! preg_match( '/Opera/i', $u_agent ) ) {
				$bname = 'Internet Explorer';
				$ub    = "MSIE";
			} elseif ( preg_match( '/Firefox/i', $u_agent ) ) {
				$bname = 'Mozilla Firefox';
				$ub    = "Firefox";
			} elseif ( preg_match( '/Chrome/i', $u_agent ) ) {
				$bname = 'Google Chrome';
				$ub    = "Chrome";
			} elseif ( preg_match( '/Safari/i', $u_agent ) ) {
				$bname = 'Apple Safari';
				$ub    = "Safari";
			} elseif ( preg_match( '/Opera/i', $u_agent ) ) {
				$bname = 'Opera';
				$ub    = "Opera";
			} elseif ( preg_match( '/Netscape/i', $u_agent ) ) {
				$bname = 'Netscape';
				$ub    = "Netscape";
			}


			// finally get the correct version number
			$known   = array( 'Version', $ub, 'other' );
			$pattern = '#(?<browser>' . join( '|', $known ) .
			           ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
			if ( ! preg_match_all( $pattern, $u_agent, $matches ) ) {
				// we have no matching number just continue
			}

			// see how many we have
			$i = count( $matches['browser'] );
			if ( $i != 1 ) {
				//we will have two since we are not using 'other' argument yet
				//see if version is before or after the name
				if ( strripos( $u_agent, "Version" ) < strripos( $u_agent, $ub ) ) {
					$version = $matches['version'][0];
				} else {
					$version = isset( $matches['version'][1] ) ? $matches['version'][1] : null;;
				}
			} else {
				$version = isset( $matches['version'][0] ) ? $matches['version'][0] : null;;
			}

			// check if we have a number
			if ( $version == null || $version == "" ) {
				$version = "?";
			}

			//$http_referer = ('on' === $_SERVER['HTTPS'])?'https://':'http://';
			if (array_key_exists('HTTPS', $_SERVER) && $_SERVER["HTTPS"] == "on"){
				$http_referer = 'https://';
			}else{
				$http_referer = 'http://';
			}
	        $http_referer .= $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
			//$http_referer = isset( $_SERVER['HTTP_REFERER'] ) ? $_SERVER['HTTP_REFERER'] : 'http://unknownhost.com/';

			// old version plugin
			if ( $fetchSelecetedPostTypes != '' ) {

				$postTypeSelectedEncodeArr = json_decode( $postTypeSelectedDecodeArr );
				$getPageSetting            = get_post_meta( $page, 'enable_page_count', true );

				if(!isset($_SESSION['hasVisited'])){
				    $_SESSION['hasVisited']="yes";
					// Check current page/post type exist in settings page array
					  if ( in_array( $page_contet->post_type, $postTypeSelectedEncodeArr ) ) {

						  // Check current page/post metabox settings is blank OR selected value is yes
						  if ( $getPageSetting == '' || $getPageSetting == 'yes' ) {

							  // Check IP Address set in settings page if yes
							  if ( isset( $fetchSelecetedIpAddress ) && ! empty( $fetchSelecetedIpAddress ) ) {

								  $optionsIpAddressEncodeArr = json_decode( $optionsIpAddressDecodedArr );
								  // Check IP Address not listed in settings page then go ahed
								  if ( ! in_array( $ipaddress, $optionsIpAddressEncodeArr ) ) {

									  // Check users set in settings page if yes
									  if ( isset( $fetchSelecetedUserId ) && ! empty( $fetchSelecetedUserId ) ) {

										  $optionsUserIdEncodeArr = json_decode( $optionsUserIdDecodedArr );
										  $user_id                = get_current_user_id();

										  // Check user not listed in settings page then go ahed
										  if ( ! in_array( $user_id, $optionsUserIdEncodeArr ) ) {

											  if ( isset( $pageCount ) && ! empty( $pageCount ) ) {
												  $existingtotal        = (int) $pageCount[0]->page_visit;
												  $totalFinal           = $existingtotal + 1;
												  $update_Query         = $wpdb->query( "UPDATE $table_name SET page_visit = 5119 WHERE page_id='" . $page . "' AND ipaddress='$ipaddress' AND date = '$currentdate'" );
												  $insert_Query_history = $wpdb->query( "INSERT into $table_name_history (`page_id`, `date`, `lastdate`, `ipaddress`, `browser_full_name`, `browser_short_name`, `browser_version`, `os`, `http_referer`) VALUES($page,NOW(),NOW(),'$ipaddress','$bname','$ub','$version','$platform','$http_referer')" );
											  } else {
												  $insert_Query         = $wpdb->query( "INSERT into $table_name (`page_id`,`page_visit`,`date`,`lastdate`,`ipaddress`) VALUES($page,1,NOW(),NOW(),'$ipaddress')" );
												  $insert_Query_history = $wpdb->query( "INSERT into $table_name_history (`page_id`, `date`, `lastdate`, `ipaddress`, `browser_full_name`, `browser_short_name`, `browser_version`, `os`, `http_referer`) VALUES($page,NOW(),NOW(),'$ipaddress','$bname','$ub','$version','$platform','$http_referer')" );
											  }
										  }
									  } else {
										  if ( isset( $pageCount ) && ! empty( $pageCount ) ) {
											  $existingtotal        = (int) $pageCount[0]->page_visit;
											  $totalFinal           = $existingtotal + 1;
											  $update_Query         = $wpdb->query( "UPDATE $table_name SET page_visit = $totalFinal WHERE page_id='" . $page . "' AND ipaddress='$ipaddress' AND date = '$currentdate'" );
											  $insert_Query_history = $wpdb->query( "INSERT into $table_name_history (`page_id`, `date`, `lastdate`, `ipaddress`, `browser_full_name`, `browser_short_name`, `browser_version`, `os`, `http_referer`) VALUES($page,NOW(),NOW(),'$ipaddress','$bname','$ub','$version','$platform','$http_referer')" );
										  } else {
											  $insert_Query         = $wpdb->query( "INSERT into $table_name (`page_id`,`page_visit`,`date`,`lastdate`,`ipaddress`) VALUES($page,1,NOW(),NOW(),'$ipaddress')" );
											  $insert_Query_history = $wpdb->query( "INSERT into $table_name_history (`page_id`, `date`, `lastdate`, `ipaddress`, `browser_full_name`, `browser_short_name`, `browser_version`, `os`, `http_referer`) VALUES($page,NOW(),NOW(),'$ipaddress','$bname','$ub','$version','$platform','$http_referer')" );
										  }
									  }
								  }
							  } else {
								  // Check users set in settings page if yes
								  if ( isset( $fetchSelecetedUserId ) && ! empty( $fetchSelecetedUserId ) ) {

									  $optionsUserIdEncodeArr = json_decode( $optionsUserIdDecodedArr );
									  $user_id                = get_current_user_id();

									  // Check user not listed in settings page then go ahed
									  if ( ! in_array( $user_id, $optionsUserIdEncodeArr ) ) {

										  if ( isset( $pageCount ) && ! empty( $pageCount ) ) {
											  $existingtotal        = (int) $pageCount[0]->page_visit;
											  $totalFinal           = $existingtotal + 1;
											  $update_Query         = $wpdb->query( "UPDATE $table_name SET page_visit = $totalFinal WHERE page_id='" . $page . "' AND ipaddress='$ipaddress' AND date = '$currentdate'" );
											  $insert_Query_history = $wpdb->query( "INSERT into $table_name_history (`page_id`, `date`, `lastdate`, `ipaddress`, `browser_full_name`, `browser_short_name`, `browser_version`, `os`, `http_referer`) VALUES($page,NOW(),NOW(),'$ipaddress','$bname','$ub','$version','$platform','$http_referer')" );
										  } else {
											  $insert_Query         = $wpdb->query( "INSERT into $table_name (`page_id`,`page_visit`,`date`,`lastdate`,`ipaddress`) VALUES($page,1,NOW(),NOW(),'$ipaddress')" );
											  $insert_Query_history = $wpdb->query( "INSERT into $table_name_history (`page_id`, `date`, `lastdate`, `ipaddress`, `browser_full_name`, `browser_short_name`, `browser_version`, `os`, `http_referer`) VALUES($page,NOW(),NOW(),'$ipaddress','$bname','$ub','$version','$platform','$http_referer')" );
										  }
									  }
								  } else {
									  if ( isset( $pageCount ) && ! empty( $pageCount ) ) {
										  $existingtotal        = (int) $pageCount[0]->page_visit;
										  $totalFinal           = $existingtotal + 1;
										  $update_Query         = $wpdb->query( "UPDATE $table_name SET page_visit = $totalFinal WHERE page_id='" . $page . "' AND ipaddress='$ipaddress' AND date = '$currentdate'" );
										  $insert_Query_history = $wpdb->query( "INSERT into $table_name_history (`page_id`, `date`, `lastdate`, `ipaddress`, `browser_full_name`, `browser_short_name`, `browser_version`, `os`, `http_referer`) VALUES($page,NOW(),NOW(),'$ipaddress','$bname','$ub','$version','$platform','$http_referer')" );
									  } else {
										  $insert_Query         = $wpdb->query( "INSERT into $table_name (`page_id`,`page_visit`,`date`,`lastdate`,`ipaddress`) VALUES($page,1,NOW(),NOW(),'$ipaddress')" );
										  $insert_Query_history = $wpdb->query( "INSERT into $table_name_history (`page_id`, `date`, `lastdate`, `ipaddress`, `browser_full_name`, `browser_short_name`, `browser_version`, `os`, `http_referer`) VALUES($page,NOW(),NOW(),'$ipaddress','$bname','$ub','$version','$platform','$http_referer')" );
									  }
								  }
							  }
						  }
					  }
				}

			}
		}

	}

	public function display_page_visit_counter_ajax() {
		global $wpdb, $wp, $post;

		$pageurl = sanitize_text_field( wp_unslash( $_POST['pageurl'] ) );

		if ( is_ssl() ) {
			$pageID = url_to_postid( preg_replace( '/^https(?=:\/\/)/i', 'http', $pageurl ) );
		} else {
			$pageID = url_to_postid( $pageurl );
		}

		if ( strpos( $pageurl, '/shop' ) !== false && $pageID == 0 ) {
			$pageID = (int) get_option( 'woocommerce_shop_page_id' );
		}

		$post = get_post( $pageID );

		$fetchSelecetedPostTypes = get_option( 'wfap_post_type' );

		$table_name = $wpdb->prefix . "page_visit";

		$pageCount_qry = $wpdb->prepare( 'SELECT SUM(page_visit) as total FROM ' . $table_name . ' WHERE page_id=%d', $pageID );
		$pageCount     = $wpdb->get_results( $pageCount_qry );

		$table_name_history = $wpdb->prefix . "page_visit_history";

		$pageCountToday_qry = $wpdb->prepare( 'SELECT COUNT(page_id) as total FROM ' . $table_name_history . ' WHERE page_id=%d AND DATE(`date`) = CURDATE()', $pageID );
		$pageCountToday     = $wpdb->get_results( $pageCountToday_qry );

		$total = (int) $pageCount[0]->total;

		$totalToday = (int) $pageCountToday[0]->total;

		$temp = array();

		$temp['today'] = $totalToday;
		$temp['total'] = $total;

		echo json_encode( $temp );

		die();

	}

	public function insert_page_visit_counter_total_block_shop_page( $content ) {
		global $wpdb, $wp, $post;

		if ( is_ssl() ) {
			$actual_link = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			$pageID      = url_to_postid( preg_replace( '/^https(?=:\/\/)/i', 'http', $actual_link ) );
		} else {
			$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			$pageID      = url_to_postid( $actual_link );
		}

		if ( ( $_SERVER['REQUEST_URI'] == '/shop/' || strpos( $_SERVER['REQUEST_URI'], '/shop/' ) !== false ) && $pageID == 0 ) {
			$pageID = (int) get_option( 'woocommerce_shop_page_id' );
		}

		if ( $pageID != 0 ) {
			$post = get_post( $pageID );

			$fetchSelecetedPostTypes = get_option( 'wfap_post_type' );

			$text_color_page_visit = get_option( 'text_color_page_visit' );

			if ( isset( $text_color_page_visit ) && $text_color_page_visit != null ) {
				$text_color_page_visit = 'style="color: ' . $text_color_page_visit . ';"';
			} else {
				$text_color_page_visit = 'style="color: #000000;"';
			}

			$enableToday = '';
			$enableToday = get_post_meta( $pageID, 'enable_page_count_day_wise', true );

			$table_name         = $wpdb->prefix . "page_visit";
			$table_name_history = $wpdb->prefix . "page_visit_history";

			$pageCount_qry = $wpdb->prepare( 'SELECT SUM(page_visit) as total FROM ' . $table_name . ' WHERE page_id=%d', $pageID );
			$pageCount     = $wpdb->get_results( $pageCount_qry );

			$pageCountToday_qry = $wpdb->prepare( 'SELECT COUNT(page_id) as total FROM ' . $table_name_history . ' WHERE page_id=%d AND DATE(`date`) = CURDATE()', $pageID );
			$pageCountToday     = $wpdb->get_results( $pageCountToday_qry );

			$total      = (int) $pageCount[0]->total;
			$totalToday = (int) $pageCountToday[0]->total;


			$html             = '';
			$hide_show_option = get_option( 'counter_hide_show_front_vew' );
			if ( $hide_show_option == 'on' ) {
				if ( ! is_feed() && ! is_home() ) {
					if ( $fetchSelecetedPostTypes == '' || $fetchSelecetedPostTypes == null ) {
						if ( 'yes' === $enableToday || '' === $enableToday ) {
							$html .= '<p id="default-loop-page-visit-counter" class="page-visit-counter-block" ' . $text_color_page_visit . '><img src="' . esc_url( plugins_url( 'images/1456175371_vector_65_14.png', dirname( __FILE__ ) ) ) . '" /><span style="margin-left: 5px;margin-right: 5px;" class="page_amount_visitor">' . esc_attr( $total ) . '</span>' . __( 'total visits,', 'page-visit-counter' ) . '<span style="margin-left: 5px;margin-right: 5px;" class="page_amount_visitor_today">' . esc_attr( $totalToday ) . '</span>' . __( 'visits today', 'page-visit-counter' ) . '</p>';
						} else {
							$html .= '<p id="default-loop-page-visit-counter" class="page-visit-counter-block" ' . $text_color_page_visit . '><img src="' . esc_url( plugins_url( 'images/1456175371_vector_65_14.png', dirname( __FILE__ ) ) ) . '" /><span style="margin-left: 5px;margin-right: 5px;" class="page_amount_visitor">' . esc_attr( $total ) . '</span>' . __( 'total visits.', 'page-visit-counter' ) . '</p>';
						}
					} else {
						$postTypeSelectedEncodeArr = json_decode( $fetchSelecetedPostTypes );
						if ( in_array( $post->post_type, $postTypeSelectedEncodeArr ) ) {
							$innerSettings = get_post_meta( $pageID, 'enable_page_count', true );
							if ( $innerSettings == '' || $innerSettings == 'yes' ) {
								if ( 'yes' === $enableToday || '' === $enableToday ) {
									$html .= '<p id="default-loop-page-visit-counter" class="page-visit-counter-block" ' . $text_color_page_visit . '><img src="' . esc_url( plugins_url( 'images/1456175371_vector_65_14.png', dirname( __FILE__ ) ) ) . '" /><span style="margin-left: 5px;margin-right: 5px;" class="page_amount_visitor">' . esc_attr( $total ) . '</span>' . __( 'total visits,', 'page-visit-counter' ) . '<span style="margin-left: 5px;margin-right: 5px;" class="page_amount_visitor_today">' . esc_attr( $totalToday ) . '</span>' . __( 'visits today', 'page-visit-counter' ) . '</p>';
								} else {
									$html .= '<p id="default-loop-page-visit-counter" class="page-visit-counter-block" ' . $text_color_page_visit . '><img src="' . esc_url( plugins_url( 'images/1456175371_vector_65_14.png', dirname( __FILE__ ) ) ) . '" /><span style="margin-left: 5px;margin-right: 5px;" class="page_amount_visitor">' . esc_attr( $total ) . '</span>' . __( 'total visits.', 'page-visit-counter' ) . '</p>';
								}
							}
						}
					}
				}
			}

			echo $content . ' ' . $html; // WPCS: XSS OK.
		} else {
			echo $content; // WPCS: XSS OK.
		}

	}

	public function insert_page_visit_counter_total_block( $content ) {
		global $wpdb, $wp, $post;

		if ( is_ssl() ) {
			$actual_link = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			$pageID      = url_to_postid( preg_replace( '/^https(?=:\/\/)/i', 'http', esc_url( $actual_link ) ) );

		} else {
			$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			$pageID      = url_to_postid( esc_url( $actual_link ) );
		}

		if ( ( $_SERVER['REQUEST_URI'] == '/shop/' || strpos( $_SERVER['REQUEST_URI'], '/shop/' ) !== false ) && $pageID == 0 ) {
			$pageID = (int) get_option( 'woocommerce_shop_page_id' );
		}

		if ( $pageID != 0 ) {
//			$post = get_post( $pageID );
			global $post;
//
			$fetchSelecetedPostTypes = get_option( 'wfap_post_type' );

			$text_color_page_visit = get_option( 'text_color_page_visit' );

			if ( isset( $text_color_page_visit ) && $text_color_page_visit != null ) {
				$text_color_page_visit1 = 'style="color: ' . esc_attr( $text_color_page_visit ) . ';"';

//                echo esc_attr($text_color_page_visit1);
//                sanitize_text_field(wp_unslash($text_color_page_visit));
			} else {
				$text_color_page_visit1 = 'style="color: #000000;"';
//                sanitize_text_field(wp_unslash($text_color_page_visit));
			}

			$enableToday = '';
			$enableToday = get_post_meta( $pageID, 'enable_page_count_day_wise', true );

			$table_name         = $wpdb->prefix . "page_visit";
			$table_name_history = $wpdb->prefix . "page_visit_history";

			$pageCount_qry = $wpdb->prepare( 'SELECT SUM(page_visit) as total FROM ' . $table_name . ' WHERE page_id=%d', $pageID );
			$pageCount     = $wpdb->get_results( $pageCount_qry );

			$pageCountToday_qry = $wpdb->prepare( 'SELECT COUNT(page_id) as total FROM ' . $table_name_history . ' WHERE page_id=%d AND DATE(`date`) = CURDATE()', $pageID );
			$pageCountToday     = $wpdb->get_results( $pageCountToday_qry );

			$total      = (int) $pageCount[0]->total;
			$totalToday = (int) $pageCountToday[0]->total;

			$html             = '';
			$hide_show_option = get_option( 'counter_hide_show_front_vew' );
			if ( $hide_show_option == 'on' ) {
				if ( ! is_feed() && ! is_home() ) {
					if ( $fetchSelecetedPostTypes == '' || $fetchSelecetedPostTypes == null ) {
						if ( 'yes' === $enableToday || '' === $enableToday ) {
							$html .= '<p id="default-loop-page-visit-counter" class="page-visit-counter-block" ' . $text_color_page_visit1 . '><img src="' . esc_url( plugins_url( 'images/1456175371_vector_65_14.png', dirname( __FILE__ ) ) ) . '" /><span style="margin-left: 5px;margin-right: 5px;" class="page_amount_visitor">' . esc_attr( $total ) . '</span>' . __( 'total visits,', 'page-visit-counter' ) . '<span style="margin-left: 5px;margin-right: 5px;" class="page_amount_visitor_today">' . esc_attr( $totalToday ) . '</span>' . __( 'visits today', 'page-visit-counter' ) . '</p>';
						} else {
							$html .= '<p id="default-loop-page-visit-counter" class="page-visit-counter-block" ' . $text_color_page_visit1 . '><img src="' . esc_url( plugins_url( 'images/1456175371_vector_65_14.png', dirname( __FILE__ ) ) ) . '" /><span style="margin-left: 5px;margin-right: 5px;" class="page_amount_visitor">' . esc_attr( $total ) . '</span>' . __( 'total visits.', 'page-visit-counter' ) . '</p>';
						}
					} else {
						$postTypeSelectedEncodeArr = json_decode( $fetchSelecetedPostTypes );
						if ( in_array( $post->post_type, $postTypeSelectedEncodeArr ) ) {
							$innerSettings = get_post_meta( $pageID, 'enable_page_count', true );
							if ( $innerSettings == '' || $innerSettings == 'yes' ) {
								if ( 'yes' === $enableToday || '' === $enableToday ) {
									$html .= '<p id="default-loop-page-visit-counter" class="page-visit-counter-block" ' . $text_color_page_visit1 . '><img src="' . esc_url( plugins_url( 'images/1456175371_vector_65_14.png', dirname( __FILE__ ) ) ) . '" /><span style="margin-left: 5px;margin-right: 5px;" class="page_amount_visitor">' . esc_attr( $total ) . '</span>' . __( 'total visits,', 'page-visit-counter' ) . '<span style="margin-left: 5px;margin-right: 5px;" class="page_amount_visitor_today">' . esc_attr( $totalToday ) . '</span>' . __( 'visits today', 'page-visit-counter' ) . '</p>';
								} else {
									$html .= '<p id="default-loop-page-visit-counter" class="page-visit-counter-block" ' . $text_color_page_visit1 . '><img src="' . esc_url( plugins_url( 'images/1456175371_vector_65_14.png', dirname( __FILE__ ) ) ) . '" /><span style="margin-left: 5px;margin-right: 5px;" class="page_amount_visitor">' . esc_attr( $total ) . '</span>' . __( 'total visits.', 'page-visit-counter' ) . '</p>';
								}
							}
						}
					}
				}
			}
			$get_no_of_days = get_option( 'no_of_days_to_display' );
			if ( $get_no_of_days == '' ) {
				$get_no_of_days = 6;
			} else {
				$get_no_of_days = (int) $get_no_of_days + 1;
			}
			$query = "SELECT `page_id`, COUNT(`page_id`) as count,`date` FROM wp_page_visit_history Where DATE(`lastdate`) > DATE_SUB(CURDATE(), INTERVAL $get_no_of_days DAY) AND DATE(`lastdate`) < CURDATE() AND `page_id` = $pageID GROUP BY `lastdate`";

			return $content . ' ' . $html;
		} else {
			return $content;
		}

	}


	/**
	 * BN code added
	 */

	function paypal_bn_code_filter( $paypal_args ) {
		$paypal_args['bn'] = 'Multidots_SP';

		return $paypal_args;
	}
}
