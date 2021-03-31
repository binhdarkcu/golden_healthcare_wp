<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * 
 */
class WCQRCodes
{

    public $admin;
    public $frontend;
    function __construct()
    {
        add_action('init', array($this, 'bootstrap_woocommerce_qr_codes'));
		add_shortcode('wooqr', array($this,'wooqr'));
        add_action('wp_enqueue_scripts', array($this, 'enqueue_frontend_script'), 10);

    }

    public function enqueue_frontend_script()
    {
        global $WooCommerceQrCodes;
        wp_enqueue_style('wcqrc-product', $WooCommerceQrCodes->plugin_url . 'assets/css/wooqr-code.css', array(), $WooCommerceQrCodes->version);
    }

    public function bootstrap_woocommerce_qr_codes()
    {
        global $WooCommerceQrCodes;
        if (is_admin()) {
            require_once('class-woo-qr-codes-admin.php');
            $this->admin = new WCQRCodesAdmin();
        }
    }
	
//global $WooCommerceQrCodes, $product;
public function wooqr($atts)
{
    global $post;

    if(is_product()){
        $id = $post->ID;
    }
    extract(
        shortcode_atts(
            array(
                'id' =>  $id,
                'title' => '',
                'price' => '',
                'type' => 'product'
            ),
            $atts
        )
    );
    $output = "";
    if($type == "coupon") {

       // $is_wooqr_exist = get_post_meta($id, '_is_qr_code_exist', true);
    }

    else {
        $is_wooqr_exist = get_post_meta($id, '_is_qr_code_exist', true);
        if (isset($is_wooqr_exist)) {
            $image = get_post_meta($id, '_product_qr_code', true);
            $output .= apply_filters('before_wooqrc_box', '', $id);
            $output .= '<div class="wooqr_code">';
            $output .= apply_filters('before_wooqrc_content', '', $id);

            if (!empty($image)) {


                $output .= '<img class="product-qr-code-img" src="' . WCQRC_QR_IMAGE_URL . $image . '" alt="' . get_the_title($id) . '" />';
                $output .= '<div class="wooqr_product_details">';
                if ($title == '1') {

                    $output .= '<h3 class="wooqr_product_title">';
                    $output .= get_the_title($id);
                    $output .= '</h3>';
                }
                if ($price == '1') {
                    $_product = wc_get_product($id);
                    $output .= '<span class="wooqr_product_price">';
                    $output .= $_product->get_price_html();
                    $output .= '</span>';
                }
                $output .= '</div>';
            } else {
                $output .= "No QR code image found.";
            }

            $output .= apply_filters('after_wooqrc_content', '', $id);
            $output .= '</div>';
            $output .= apply_filters('after_wooqrc_box', '', $id);

        }

     else {

    $output .= "No QR code image found.";
   }
    }

    return $output;
}

}

