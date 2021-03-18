<?php
// If this file is called directly, abort.
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
/**
 * WP List Table Example class
 *
 * @package   WPListTableExample
 * @author    Matt van Andel
 * @copyright 2016 Matthew van Andel
 * @license   GPL-2.0+
 */
/**
 * Example List Table Child Class
 *
 * Create a new list table package that extends the core WP_List_Table class.
 * WP_List_Table contains most of the framework for generating the table, but we
 * need to define and override some methods so that our data can be displayed
 * exactly the way we need it to be.
 *
 * To display this example on a page, you will first need to instantiate the class,
 * then call $yourInstance->prepare_items() to handle any data manipulation, then
 * finally call $yourInstance->display() to render the table to the page.
 *
 * Our topic for this list table is going to be movies.
 *
 * @package WPListTableExample
 * @author  Matt van Andel
 */
class TT_Example_List_Table extends WP_List_Table {
	
	
	 /**
     * Prepare the items for the table to process
     *
     * @return Void
     */
    public function prepare_items()
    {
        $columns = $this->get_columns();
        $hidden = $this->get_hidden_columns();
        $sortable = $this->get_sortable_columns();
        $data = $this->table_data();
        usort( $data, array( &$this, 'sort_data' ) );
        $perPage = 15;
        $currentPage = $this->get_pagenum();
        $totalItems = count($data);
        $this->set_pagination_args( array(
            'total_items' => $totalItems,
            'per_page'    => $perPage
        ) );
        $data = array_slice($data,(($currentPage-1)*$perPage),$perPage);
        $this->_column_headers = array($columns, $hidden, $sortable);
        $this->items = $data;
    }
    
    /**
     * Override the parent columns method. Defines the columns to use in your listing table
     *
     * @return Array
     */
    public function get_columns()
    {
        $columns = array(
            'id'          => 'Page/Post ID',
            'title'       => 'Page Title',
            'count' => 'Total Count',
            'share'        => 'Share',
            'report'    => 'Report'
        );
        return $columns;
    }
    
    /**
     * Define which columns are hidden
     *
     * @return Array
     */
    public function get_hidden_columns()
    {
        return array();
    }
    
    /**
     * Define the sortable columns
     *
     * @return Array
     */
    public function get_sortable_columns()
    {
        return array();
        		
//		return array(
//        		'count' 	=> array('count', false),
//        		'id' 		=> array('id', false),
//        		'title' 	=> array('title', false)
//        		);
    }
    
    /**
     * Get the table data
     *
     * @return Array
     */
    private function table_data()
    {
    	global $wpdb;
    	
    	$table_name = $wpdb->prefix."page_visit";
    	$temp = array();
						
		$postperpage = -1;

		// Get all the registered post type
		$post_types = get_post_types();
		$posts_array = array();
		if (isset($post_types) && !empty($post_types)) {
			foreach ($post_types as $cpost) {
				if($cpost != "attachment" && $cpost != "revision" && $cpost != "nav_menu_item" && $cpost != "product_variation" && $cpost != "shop_order" && $cpost != "shop_order_refund" && $cpost != "shop_coupon" && $cpost != "shop_webhook" && $cpost != "scheduled-action") {
					
					$search = ( isset( $_REQUEST['s'] ) ) ? $_REQUEST['s'] : false;
					
					if ($search == false) {
						$args = array(
							'post_type' => "$cpost",
							'post_status' => 'publish',
							'order' => 'ASC',
							'posts_per_page'   => $postperpage,
						);
					} else if ($_REQUEST['s'] == '' ) {
						$args = array(
							'post_type' => "$cpost",
							'post_status' => 'publish',
							'order' => 'ASC',
							'posts_per_page'   => $postperpage,
						);
					} else {
						$args = array(
							'post_type' => "$cpost",
							'post_status' => 'publish',
							'order' => 'ASC',
							's' => $search,
							'posts_per_page'   => $postperpage,
						);
					}
					if ($search != false) {
						$query = new WP_Query($args);
					} else {
						$query = new WP_Query($args);
					}
					$posts_array[] =  $query->get_posts();
					//$temp[] = $posts_array;
				}
			}
		}
		
		$data = array();
		$counter = 0;
		foreach ($posts_array as $result){
				
			foreach ($result as $results) {
				$counter = $counter + 1;
				
                                $pageCount_qry = $wpdb->prepare('SELECT SUM(page_visit) as total FROM ' . $table_name . ' WHERE page_id=%d', $results->ID);
				$pageCount = $wpdb->get_results($pageCount_qry);

				$total = (int) $pageCount[0]->total;
				$site_title = get_bloginfo( 'name' );
				$page_social_content = $results->post_title.' - Total Visits '.$total.' - '.$site_title;
				
				$data[] = array(
                    'id'          => $results->ID,
                    'title'       => '<a href="'.esc_url(get_admin_url().'post.php?post='.$results->ID.'&action=edit').'">'.wp_kses_post($results->post_title).'</a>',
                    'count' 	  => $total,
                    'share'       => '<a target="_blank" style="margin-right: 5px;" href="'.esc_url('https://www.facebook.com/sharer/sharer.php?u='.get_permalink($results->ID)).'"><img src="' . esc_url(plugins_url( 'images/Facebook.png', dirname(__FILE__) )) . '" /></a><a target="_blank" style="margin-right: 5px;" href="'.esc_url('https://twitter.com/intent/tweet?text='.esc_attr($page_social_content).'&url='.get_permalink($results->ID)).'"><img src="' . esc_url(plugins_url( 'images/twitter.png', dirname(__FILE__) )) . '" /></a><a target="_blank" href="'.esc_url('https://plus.google.com/share?url='.get_permalink($results->ID)).'"><img src="' . esc_url(plugins_url( 'images/Google_Plus.png', dirname(__FILE__) )) . '" /></a>',
                    'report'      => '<a href="'.esc_url(home_url('/wp-admin/admin.php?page=page_visit_counter&id='.$results->ID)).'" title="'.wp_kses_post($results->post_title).'" class="" id="'.esc_attr($results->ID).'">'.esc_html__('View Report','page-visit-counter').'</a>'
                );
			}
		}					
		
        return $data;
    }
    
    /**
     * Define what data to show on each column of the table
     *
     * @param  Array $item        Data
     * @param  String $column_name - Current column name
     *
     * @return Mixed
     */
    public function column_default( $item, $column_name )
    {
        switch( $column_name ) {
            case 'id':
            case 'title':
            case 'count':
            case 'share':
            case 'report':
            	return $item[ $column_name ];
            default:
                return print_r( $item, true ) ;
        }
    }
    
    /**
     * Allows you to sort the data by the variables set in the $_GET
     *
     * @return Mixed
     */
    private function sort_data( $a, $b )
    {
        // Set defaults
        $orderby = 'title';
        $order = 'asc';
        // If orderby is set, use this as the sort column
        if(!empty($_GET['orderby']))
        {
            $orderby = $_GET['orderby'];
        }
        // If order is set use this as the order
        if(!empty($_GET['order']))
        {
            $order = $_GET['order'];
        }
        $result = strcmp( $a[$orderby], $b[$orderby] );
        if($order === 'asc')
        {
            return $result;
        }
        return -$result;
    }
}