<?php
/**
 * Single Product Meta
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/meta.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post, $product;

$cat_count = sizeof( get_the_terms( $post->ID, 'product_cat' ) );
$tag_count = sizeof( get_the_terms( $post->ID, 'product_tag' ) );

?>
<div class="product_meta">

	<?php do_action( 'woocommerce_product_meta_start' ); ?>

	<?php if ( wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type( 'variable' ) ) ) : ?>

		<span class="sku_wrapper"><?php _e( 'SKU:', MTS_THEME_TEXTDOMAIN ); ?> <span class="sku" itemprop="sku"><?php echo ( $sku = $product->get_sku() ) ? $sku : __( 'N/A', MTS_THEME_TEXTDOMAIN ); ?></span>.</span>

	<?php endif; ?>

	<?php if ( version_compare( WC()->version, '3.0.0', ">=" ) ) { ?>

		<?php echo wc_get_product_category_list( $product->get_id(), ', ', '<span class="posted_in">' . _n( 'Category:', 'Categories:', $cat_count, MTS_THEME_TEXTDOMAIN ) . ' ', '.</span>' ); ?>

		<?php if ( get_option( 'woocommerce_enable_review_rating' ) === 'no' ) echo wc_get_product_tag_list( $product->get_id(), ', ', '<span class="tagged_as">' . _n( 'Tag:', 'Tags:', $tag_count, MTS_THEME_TEXTDOMAIN ) . ' ', '.</span>' ); ?>

	<?php } else { ?>

		<?php echo $product->get_categories( ', ', '<span class="posted_in">' . _n( 'Category:', 'Categories:', $cat_count, MTS_THEME_TEXTDOMAIN ) . ' ', '.</span>' ); ?>

		<?php if ( get_option( 'woocommerce_enable_review_rating' ) === 'no' ) echo $product->get_tags( ', ', '<span class="tagged_as">' . _n( 'Tag:', 'Tags:', $tag_count, MTS_THEME_TEXTDOMAIN ) . ' ', '.</span>' ); ?>

	<?php } ?>

	<?php do_action( 'woocommerce_product_meta_end' ); ?>

</div>