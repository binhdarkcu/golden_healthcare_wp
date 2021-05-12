<?php
/* Template Name: Các dịch vụ */
get_header()?>
<?php
    $queried_object = get_queried_object();
?>
<div ng-init="loadData()">
    <section>
        <div class=" container-bd" id="container" style="padding-top: 50px; padding-bottom: 50px; padding-left: 15px; padding-right: 15px;">
            <div class="row">

                <div class="content col-md-7 col-sm-12 col-xs-12">
                    <h3  style="margin-bottom: 25px;border-bottom:  1px solid #d9d9d9; padding-bottom: 5px;">Đăng ký dịch vụ</h3>
                    <div class="sub-title">
                        <h4>Nhóm bệnh</h4>
                    </div>

                    <?php
                    $categories = get_term_by( 'slug', 'nhom-benh', 'product_cat' );
                    $args = array(
                        'hide_empty' => 0,
                        'parent' => $categories->term_id,
                    );
                    $product_categories = get_terms('product_cat', $args);
                    ?>
                    <ul class="list-nhom-benh">
                        <?php
                        foreach ($product_categories as $product_category) {
                            $product_cat_id = $product_category->term_id;
                            $cat_link = get_category_link($product_cat_id);
                        ?>
                        <li><a href="<?php echo $cat_link;?>"><?php echo esc_html($product_category->name); ?></a></li>
                        <?php } ?>
                    </ul>

                    <div class="sub-title" style="margin-top: 25px;">
                        <h4>Nhóm Dịch vụ</h4>
                    </div>

                    <ul class="list-nhom-dich-vu">
                    <?php

                    $args = array(
                        'post_type'      => 'product',
                        'posts_per_page' => -1,
                        'product_cat'    => 'nhom-benh'
                    );

                    $loop = new WP_Query( $args );

                    while ( $loop->have_posts() ) : $loop->the_post();
                        global $woocommerce, $product, $post;
                    ?>
                        <li>
                            <h5><?php echo $product->name;?></h5>
                            <div class="price-product">
                                <?php print_r($product->get_price_html());?>
                            </div>
                            <a class="btn-dat-kham single_add_to_cart_button" data-id="<?php echo $product->id;?>" href="javascript:void(0)">Chọn khám</a>
                        </li>
                    <?php
                    endwhile;

                    wp_reset_query();
                    ?>
                    </ul>

                </div>
                <!---->
                <div class="col-md-5 col-sm-12 col-xs-12" style="position: sticky;top: 0;">
                    <form class="woocommerce-cart-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
                    	<?php do_action( 'woocommerce_before_cart_table' ); ?>

                    	<table class="shop_table shop_table_responsive cart woocommerce-cart-form__contents" cellspacing="0">
                    		<thead>
                    			<tr>
                    				<th class="product-remove">&nbsp;</th>
                    				<th class="product-name"><?php esc_html_e( 'Tên gói khám', 'woocommerce' ); ?></th>
                    				<th class="product-quantity"><?php esc_html_e( 'Số lượng', 'woocommerce' ); ?></th>
                    				<th class="product-subtotal"><?php esc_html_e( 'Tổng tiền', 'woocommerce' ); ?></th>
                    			</tr>
                    		</thead>
                    		<tbody>
                    			<?php do_action( 'woocommerce_before_cart_contents' ); ?>

                    			<?php
                    			foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
                    				$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
                    				$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

                    				if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
                    					$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
                    					?>
                    					<tr class="woocommerce-cart-form__cart-item <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">

                    						<td class="product-remove">
                    							<?php
                    								echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                    									'woocommerce_cart_item_remove_link',
                    									sprintf(
                    										'<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s">&times;</a>',
                    										esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
                    										esc_html__( 'Remove this item', 'woocommerce' ),
                    										esc_attr( $product_id ),
                    										esc_attr( $_product->get_sku() )
                    									),
                    									$cart_item_key
                    								);
                    							?>
                    						</td>

                    						<td class="product-name" data-title="<?php esc_attr_e( 'Tên gói khám', 'woocommerce' ); ?>">
                    						<?php
                    						if ( ! $product_permalink ) {
                    							echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) . '&nbsp;' );
                    						} else {
                    							echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_name() ), $cart_item, $cart_item_key ) );
                    						}

                    						do_action( 'woocommerce_after_cart_item_name', $cart_item, $cart_item_key );

                    						// Meta data.
                    						echo wc_get_formatted_cart_item_data( $cart_item ); // PHPCS: XSS ok.

                    						// Backorder notification.
                    						if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
                    							echo wp_kses_post( apply_filters( 'woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'woocommerce' ) . '</p>', $product_id ) );
                    						}
                    						?>
                    						</td>
                    						<td class="product-quantity" data-title="<?php esc_attr_e( 'Quantity', 'woocommerce' ); ?>">
                    						<?php
                    						if ( $_product->is_sold_individually() ) {
                    							$product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
                    						} else {
                    							$product_quantity = woocommerce_quantity_input(
                    								array(
                    									'input_name'   => "cart[{$cart_item_key}][qty]",
                    									'input_value'  => $cart_item['quantity'],
                    									'max_value'    => $_product->get_max_purchase_quantity(),
                    									'min_value'    => '0',
                    									'product_name' => $_product->get_name(),
                    								),
                    								$_product,
                    								false
                    							);
                    						}

                    						echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item ); // PHPCS: XSS ok.
                    						?>
                    						</td>

                    						<td class="product-subtotal" data-title="<?php esc_attr_e( 'Subtotal', 'woocommerce' ); ?>">
                    							<?php
                    								echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); // PHPCS: XSS ok.
                    							?>
                    						</td>
                    					</tr>
                    					<?php
                    				}
                    			}
                    			?>

                    			<?php do_action( 'woocommerce_cart_contents' ); ?>

                    			<tr>
                    				<td colspan="6" class="actions">

                    					<?php if ( wc_coupons_enabled() ) { ?>
                    						<div class="coupon">
                    							<label for="coupon_code"><?php esc_html_e( 'Coupon:', 'woocommerce' ); ?></label> <input style="width: 110px;" type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="<?php esc_attr_e( 'Mã giảm giá', 'woocommerce' ); ?>" /> <button type="submit" class="button" name="apply_coupon" value="<?php esc_attr_e( 'Apply coupon', 'woocommerce' ); ?>"><?php esc_attr_e( 'Sử dụng', 'woocommerce' ); ?></button>
                    							<?php do_action( 'woocommerce_cart_coupon' ); ?>
                    						</div>
                    					<?php } ?>

                    					<button type="submit" class="button" name="update_cart" value="<?php esc_attr_e( 'Update cart', 'woocommerce' ); ?>"><?php esc_html_e( 'Cập nhật', 'woocommerce' ); ?></button>

                                        <br/>

                                        <a class="btn-dat-kham" href="<?php echo home_url()?>/checkout">Tiến hành thanh toán</a>
                    					<?php do_action( 'woocommerce_cart_actions' ); ?>

                    					<?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>
                    				</td>
                    			</tr>

                    			<?php do_action( 'woocommerce_after_cart_contents' ); ?>
                    		</tbody>
                    	</table>
                    	<?php do_action( 'woocommerce_after_cart_table' ); ?>
                    </form>
                </div>
            </div>
    </section>

</div>
<?php get_footer();?>
