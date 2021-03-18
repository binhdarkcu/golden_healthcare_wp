<?php
function bt_paginate(){
		global $wp_query, $wp_rewrite;
		$wp_query->query_vars['paged'] > 1 ? $current = $wp_query->query_vars['paged'] : $current = 1;

		$pagination = array(
	    'base'         => @add_query_arg('paged','%#%'),
	    'format'       => '',
	    'total'        => $wp_query->max_num_pages,
	    'current'      => $current,
	    'show_all'     => false,
	    'end_size'     => 1,
	    'mid_size'     => 5,
	    'prev_next'    => true,
	    'prev_text'    => __('← Previous'),
        'next_text'    => __('Next →'),
	    'type'         => 'plain',
	    'add_args'     => False,
		 'add_fragment' =>''  );

		if( $wp_rewrite->using_permalinks() )
			$pagination['base'] = user_trailingslashit( trailingslashit( remove_query_arg( 's', get_pagenum_link( 1 ) ) ) . 'page/%#%/', 'paged' );

		if( !empty($wp_query->query_vars['s']) )
			$pagination['add_args'] = array( 's' => get_query_var( 's' ) );
		echo paginate_links( $pagination );

}


/*function homeland_for_pagination() {
	$paged = $_GET['page']; // Page number
	$html = '';
	$pag = 0;
	if( filter_var( intval( $paged ), FILTER_VALIDATE_INT ) ) {
		$pag = $paged;
		$args = array(
			'paged' => $pag, // Uses the page number passed via AJAX
			'posts_per_page' => 2 // Change this as you wish
		);
		$loop = new WP_Query( $args );

		if( $loop->have_posts() ) {
			while( $loop->have_posts() ) {
				$loop->the_post();
				// Build the HTML string with your post's contents
			}

			wp_reset_query();
		}
	}

	echo $html;
	exit();

}

add_action( 'wp_ajax_homeland_for_pagination', 'homeland_for_pagination' );
add_action( 'wp_ajax_nopriv_homeland_for_pagination', 'homeland_for_pagination' );
*/

add_action( 'wp_ajax_orderbyHomeLand', 'orderbyHomeLand' );
add_action( 'wp_ajax_nopriv_orderbyHomeLand', 'orderbyHomeLand' );
function orderbyHomeLand(){
	$taxid = $_POST['taxid'];
	$taxcount = $_POST['taxcount'];
	$order = $_POST['order'];
	$taxpage = $_POST['taxpage'];

	$post_count  = wp_count_posts()->publish;
	if(!empty($taxid)){
		$arrTax = array(
	            'taxonomy' => 'homelandtax', //or tag or custom.php taxonomy
	            'field' => 'id',
	            'terms' => $taxid
	    );
		$post_count = $taxcount;
	}
	$args_homeland_ajax = array(
		'post_type' 	 => 'homeland',
		'posts_per_page' =>  4,
		'order'	=> $order,
		'paged'		=> $taxpage,
		'tax_query' => array(
	        $arrTax
	    )
	);

	$query_homelands_ajax = query_posts($args_homeland_ajax);
	$num = 0;
	if(have_posts($query_homelands_ajax->$post)): while(have_posts($query_homelands_ajax->$post)): the_post($query_homelands_ajax->$post);
		$num++;
		$price = get_post_meta(get_the_ID(),'tt_price',true);
		$bed = get_post_meta(get_the_ID(),'tt_bedrooms',true);
		$bath = get_post_meta(get_the_ID(),'tt_bathrooms',true);
		$garages = get_post_meta(get_the_ID(),'tt_garages',true);
		$bigImg = wp_get_attachment_url( get_post_thumbnail_id(get_the_ID()) );
	?>
	<div class="item" order="<?php echo $num;?>">
		<div class="pad">
			<img src="<?php echo $bigImg;?>"/>
			<div class="desc">
				<h3><?php echo get_the_title(get_the_ID());?></h3>
				<span class="pos"><?php echo get_field('position',get_the_ID());?> </span>
				<div class="text">
					**
					<?php echo wp_trim_words(get_the_content(get_the_ID()),35,$more='...');?>
					<a href="<?php echo get_the_permalink(get_the_ID())?>">View the full details </a>
				</div>
			</div>
			<div class="price">
				<div class="num">
					$<?php echo number_format($price);?>
				</div>
				<ul>
					<li class="bed">
						<label>Bedrooms</label>
						<span><i></i><span><?php echo $bed;?></span></span>
					</li>
					<li class="bath">
						<label>Bathrooms</label>
						<span><i></i><span><?php echo $bath;?></span></span>
					</li>
					<li class="car">
						<label>Car Spaces</label>
						<span><i></i><span><?php echo $garages;?></span></span>
					</li>
				</ul>
			</div>
			<div class="clear"></div>
		</div>
	</div>
	<?php endwhile; endif;
	// Reset Query
	wp_reset_query();
}
