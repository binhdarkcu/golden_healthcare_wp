<?php

/*
Plugin Name: WP_List_Table Class Example
Plugin URI: https://www.sitepoint.com/using-wp_list_table-to-create-wordpress-admin-tables/
Description: Demo on how WP_List_Table Class works
Version: 1.0
Author: Collins Agbonghama
Author URI:  https://w3guy.com
*/

if ( ! class_exists( 'WP_List_Table' ) ) {
	require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

class Customers_List extends WP_List_Table {

	/** Class constructor */
	public function __construct() {

		parent::__construct( [
			'singular' => __( 'Customer', 'sp' ), //singular name of the listed records
			'plural'   => __( 'Customers', 'sp' ), //plural name of the listed records
			'ajax'     => false //does this table support ajax?
		] );

	}


	/**
	 * Retrieve customers data from the database
	 *
	 * @param int $per_page
	 * @param int $page_number
	 *
	 * @return mixed
	 */
	public static function get_customers( $per_page = -1, $page_number = 1 ) {

		global $wpdb;

		$sql = "SELECT * FROM {$wpdb->prefix}dathen ORDER BY ID DESC";

		if ( ! empty( $_REQUEST['orderby'] ) ) {
			$sql .= ' ORDER BY ' . esc_sql( $_REQUEST['orderby'] );
			$sql .= ! empty( $_REQUEST['order'] ) ? ' ' . esc_sql( $_REQUEST['order'] ) : ' ASC';
		}

		$sql .= " LIMIT $per_page";
		$sql .= ' OFFSET ' . ( $page_number - 1 ) * $per_page;

		$result = $wpdb->get_results( $sql, 'ARRAY_A' );

		return $result;
	}

	public  static function get_search($per_page = -1, $page_number = 1) {
	    global $wpdb;
	    $key = $_GET['s'];
        $sql = "SELECT * FROM {$wpdb->prefix}dathen WHERE examination 
			LIKE '%$key%' OR full_name LIKE '%$key%' OR phone LIKE '%$key%'
			OR dayChecked LIKE '%$key%' OR status LIKE '%$key%'
			ORDER BY ID DESC";
        if ( ! empty( $_REQUEST['orderby'] ) ) {
            $sql .= ' ORDER BY ' . esc_sql( $_REQUEST['orderby'] );
            $sql .= ! empty( $_REQUEST['order'] ) ? ' ' . esc_sql( $_REQUEST['order'] ) : ' ASC';
        }

        $sql .= " LIMIT $per_page";
        $sql .= ' OFFSET ' . ( $page_number - 1 ) * $per_page;
        $result = $wpdb->get_results( $sql, 'ARRAY_A' );

        return $result;
    }


	/**
	 * Delete a customer record.
	 *
	 * @param int $id customer ID
	 */
	public static function delete_customer( $id ) {
		global $wpdb;
		$wpdb->delete(
			"{$wpdb->prefix}dathen",
			[ 'ID' => $id ],
			[ '%d' ]
		);
	}

	/**
	 * Returns the count of records in the database.
	 *
	 * @return null|string
	 */
	public static function record_count() {
		global $wpdb;

		$sql = "SELECT COUNT(*) FROM {$wpdb->prefix}dathen";

		return $wpdb->get_var( $sql );
	}


	/** Text displayed when no customer data is available */
	public function no_items() {
		_e( 'Hiện tại không có bệnh nhân nào', 'sp' );
	}


	/**
	 * Render a column when no column specific method exist.
	 *
	 * @param array $item
	 * @param string $column_name
	 *
	 * @return mixed
	 */
	public function column_default( $item, $column_name ) {
        global $wpdb;
	    $arr = $item['id_doctor'];
	    $query = $wpdb->get_row("SELECT post_title FROM wp_posts WHERE ID = $arr");
		switch ( $column_name ) {
			case 'full_name':
			case 'symptom':
			case 'birthday':
			case 'examination':
			case 'client_code':
			case 'dayChecked':
			case 'time':
			case 'gender':
			case 'email':
			case 'phone':
			case 'status':
				return $item[ $column_name ];
            case 'id_doctor':
                return $query->post_title;
			default:
				return print_r( $item, true ); //Show the whole array for troubleshooting purposes
		}
	}

	/**
	 * Render the bulk edit checkbox
	 *
	 * @param array $item
	 *
	 * @return string
	 */
	function column_cb( $item ) {
		return sprintf(
			'<input type="checkbox" name="bulk-delete[]" value="%s" />', $item['ID']
		);
	}


	/**
	 * Method for name column
	 *
	 * @param array $item an array of DB data
	 *
	 * @return string
	 */
	function column_name( $item ) {

		$delete_nonce = wp_create_nonce( 'sp_delete_customer' );
		$title = '<strong style="color: #0073aa">' . $item['full_name'] . '</strong>';

		$actions = [
			'delete' => sprintf( '<a href="?page=%s&action=%s&customer=%s&_wpnonce=%s">Delete</a>', esc_attr( $_REQUEST['page'] ), 'delete', absint( $item['ID'] ), $delete_nonce )
		];

		return $title . $this->row_actions( $actions );
	}

	function column_status($item) {
        $status2 = $item['status'] == 'Đã khám' ? 'Chưa khám' : 'Đã khám';
	    $title = '<select>
            <option value="'.$item["status"].'">'.$item["status"].'</option>
            <option value="'.$status2.'">'.$status2.'</option>
        </select>';
        $actions = [
            'edit' => sprintf( '<a id="update_status%s" style="color: #000; cursor: pointer" href="?page=%s&action=%s&id=%s&status=%s">Cập nhật</a>', $item['ID'], esc_attr( $_REQUEST['page'] ), 'edit', absint( $item['ID'] ), $status2 )
        ];
        return $title . $this->row_actions( $actions );
    }


	/**
	 *  Associative array of columns
	 *
	 * @return array
	 */
	function get_columns() {
		$columns = [
			'cb'      => '<input type="checkbox" />',
			'name'    => __( 'Tên bệnh nhân', 'sp' ),
			'birthday'    => __( 'Năm sinh', 'sp' ),
            'symptom' => __( 'Triệu chứng', 'sp' ),
            'examination' => __( 'Tình trạng', 'sp' ),
            'client_code' => __( 'Mã Khách hàng', 'sp' ),
			'dayChecked'    => __( 'Ngày Đăng ký', 'sp' ),
			'time'    => __( 'Giờ', 'sp' ),
			'phone'    => __( 'Phone', 'sp' ),
			'status'    => __( 'Trạng thái', 'sp' )
		];

		return $columns;
	}


	/**
	 * Columns to make sortable.
	 *
	 * @return array
	 */
	public function get_sortable_columns() {
		$sortable_columns = array(
			'full_name' => array( 'full_name', true )
		);

		return $sortable_columns;
	}

	/**
	 * Returns an associative array containing the bulk action
	 *
	 * @return array
	 */
	public function get_bulk_actions() {
		$actions = [
			'bulk-delete' => 'Delete',
		];

		return $actions;
	}


	/**
	 * Handles data query and filter, sorting, and pagination.
	 */
	public function prepare_items() {

		$this->_column_headers = $this->get_column_info();

		/** Process bulk action */
		$this->process_bulk_action();

		$per_page     = $this->get_items_per_page( 'customers_per_page', 10 );
		$current_page = $this->get_pagenum();
		$total_items  = self::record_count();

		$this->set_pagination_args( [
			'total_items' => $total_items, //WE have to calculate the total number of items
			'per_page'    => $per_page //WE have to determine how many items to show on a page
		] );
        if(isset($_GET['s']))  {
            $this->items = self::get_search($per_page, $current_page);
        } else {
            $this->items = self::get_customers( $per_page, $current_page );
        }
	}

	public function process_bulk_action() {

		//Detect when a bulk action is being triggered...
		if ( 'delete' === $this->current_action() ) {

			// In our file that handles the request, verify the nonce.
			$nonce = esc_attr( $_REQUEST['_wpnonce'] );

			if ( ! wp_verify_nonce( $nonce, 'sp_delete_customer' ) ) {
				die( 'Go get a life script kiddies' );
			}
			else {
				self::delete_customer( absint( $_GET['customer'] ) );
                wp_redirect(get_permalink($_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?page=wp_list_table_class'));
                $url = $_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?page=wp_list_table_class';
                $protocol = $_SERVER['HTTP_HOST'] == 'localhost' ? 'http' : 'https';
                echo '<script type="text/javascript">
                    location.replace("'.$protocol.'://'.$url.'")
                </script>';
            }
		}

		if('edit' === $this->current_action()) {
            global $wpdb;
            $id = $_GET['id'];
            $status = $_GET['status'];
            $wpdb->update(
                $wpdb->prefix .'dathen',
                array(
                    'status' => $status
                ),
                array(
                    "ID" => $id
                )
            );
            wp_redirect(get_permalink($_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?page=wp_list_table_class'));
            $url = $_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?page=wp_list_table_class';
            $protocol = $_SERVER['HTTP_HOST'] == 'localhost' ? 'http' : 'https';
            echo '<script type="text/javascript">
                    location.replace("'.$protocol.'://'.$url.'")
                </script>';
        }

		// If the delete bulk action is triggered
		if ( ( isset( $_POST['action'] ) && $_POST['action'] == 'bulk-delete' ) || ( isset( $_POST['action2'] ) && $_POST['action2'] == 'bulk-delete' ) ) {

			$delete_ids = esc_sql( $_POST['bulk-delete'] );

			// loop over the array of record IDs and delete them
			foreach ( $delete_ids as $id ) {
				self::delete_customer( $id );
			}
            wp_redirect(get_permalink($_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?page=wp_list_table_class'));
            $url = $_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?page=wp_list_table_class';
            $protocol = $_SERVER['HTTP_HOST'] == 'localhost' ? 'http' : 'https';
            echo '<script type="text/javascript">
                    location.replace("'.$protocol.'://'.$url.'")
                </script>';
		}
	}

}


class SP_Plugin {

	// class instance
	static $instance;

	// customer WP_List_Table object
	public $customers_obj;

	// class constructor
	public function __construct() {
		add_filter( 'set-screen-option', [ __CLASS__, 'set_screen' ], 10, 3 );
		add_action( 'admin_menu', [ $this, 'plugin_menu' ] );
	}


	public static function set_screen( $status, $option, $value ) {
		return $value;
	}

	public function plugin_menu() {

		$hook = add_menu_page(
			'Đặt Hẹn',
			'Đặt hẹn',
			'manage_options',
			'wp_list_table_class',
			[ $this, 'plugin_settings_page' ], '', 6
		);

		add_action( "load-$hook", [ $this, 'screen_option' ] );

	}


	/**
	 * Plugin settings page
	 */
	public function plugin_settings_page() {
		?>
		<div class="wrap">
			<h2>Đặt hẹn</h2>

			<div id="poststuff">
				<div id="post-body" class="metabox-holder">
					<div id="post-body-content">
						<div class="meta-box-sortables ui-sortable">
							<form method="get">
                                <input type="hidden" name="page" value="<?php echo $_REQUEST['page']; ?>" />
								<?php
								$this->customers_obj->prepare_items();
                                $this->customers_obj->search_box('Search', 'search');
								$this->customers_obj->display(); ?>
							</form>
						</div>
					</div>
				</div>
				<br class="clear">
			</div>
		</div>
	<?php
	}

	/**
	 * Screen options
	 */
	public function screen_option() {

		$option = 'per_page';
		$args   = [
			'label'   => 'Customers',
			'default' => 10,
			'option'  => 'customers_per_page'
		];

		add_screen_option( $option, $args );

		$this->customers_obj = new Customers_List();
	}


	/** Singleton instance */
	public static function get_instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

}


add_action( 'plugins_loaded', function () {
	SP_Plugin::get_instance();
} );
