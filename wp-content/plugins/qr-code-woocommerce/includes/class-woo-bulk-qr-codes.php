<?php 
    
    add_action( 'admin_menu', 'woo_bulk_qr_codes', 9999 );
    
    function woo_bulk_qr_codes() {
        add_submenu_page( 'edit.php?post_type=product', 'Bulk QR Codes', 'Bulk QR Codes', 'edit_products', 'woo_bulk_qr_codes', 'woo_bulk_qr_codes_callback', 9999 );
    }
    
    function woo_bulk_qr_codes_callback() {
     global $WooCommerceQrCodes;
        wp_enqueue_style('wcqrc-product', $WooCommerceQrCodes->plugin_url . 'assets/css/wooqr-code.css', array(), $WooCommerceQrCodes->version);
        echo '<div class="wrap"><h1 class="">Bulk QR Codes</h1>';
        $args = array(
        'post_type'      => 'product',
        'posts_per_page' => -1,
        );
        
        $loop = new WP_Query( $args );
    ?>
<div class="wooqr-search-wrap">
	<input type="text" onkeyup="search_wooqr_list()" name="find-wooqr-pro" id="search-wooqr-pro" placeholder="Search Product">
</div>
    <div class="product-grid-container">
        <?php
            while ( $loop->have_posts() ) : $loop->the_post();
            global $product;
            // echo '<div class="product-grid-item"><a href="'.get_permalink().'">' . woocommerce_get_product_thumbnail().' '.get_the_title().'</a></div>';
            
            echo '<div class="product-grid-item">';
            // echo "<pre>";
            // print_r($product->id);
            // echo "</pre>";
            echo '<div>'.woocommerce_get_product_thumbnail().'</div>';
            echo '<div>'.get_the_title(). '</div>';
            echo '<div>'. $product->get_price_html().'</div>';
            echo '<div><a href="">Generate QR</a>'. '  ' .'<a href="">Print QR code sticker</a></div>';
            echo '<div><button type="button" data-product_id="'.$product->id.'" class="button-primary simple-qr-gen o">Generate
                    QR
                </button>'. ' <br /> ' .'<a href="">Print QR code sticker</a></div>';
            
            echo '</div>';
            endwhile;
        ?>
    </div>
    <?php
        wp_reset_query();
        echo '</div>';
    }            