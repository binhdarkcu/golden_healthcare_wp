<?php
    
    /**
        * Admin class
	*/
    class WCQRCodesAdmin
    {
        
        public function __construct()
        {
            
            add_action('add_meta_boxes', array($this, 'add_qr_metabox'), 30);
            add_action('save_post', array($this, 'save_product_qr_code'), 10, 2);
            add_action('woocommerce_product_after_variable_attributes', array($this, 'qr_vproduct_metabox_callback'), 10, 3);
            add_action('edit_post', array($this, 'save_vproduct_qr_code'), 10, 1);
            add_action('before_delete_post', array($this, 'delete_associated_qr_code'), 10, 1);
            add_action('wp_ajax_wooqr', array(&$this, 'wooqr_ajax_request'));
            add_action('wp_ajax_nopriv_wooqr', array(&$this, 'wooqr_ajax_request'));
            add_action('wp_ajax_variableqrdel', array(&$this, 'variableqrdel'));
            add_action('wp_ajax_nopriv_variableqrdel', array(&$this, 'variableqrdel'));
            add_action('wp_ajax_variableqrgen', array(&$this, 'variableqrgen'));
            add_action('wp_ajax_nopriv_variableqrgen', array(&$this, 'variableqrgen'));
            add_action('wp_ajax_simpleqrgen', array(&$this, 'simpleqrgen'));
            add_action('wp_ajax_nopriv_simpleqrgen', array(&$this, 'simpleqrgen'));
            add_action('wp_ajax_simpleqrdel', array(&$this, 'simpleqrdel'));
            add_action('wp_ajax_delcoupon', array(&$this, 'delcoupon'));
            add_action('wp_ajax_gencoupon', array(&$this, 'gencoupon'));
            add_action('qr_before_code_tab_data', array($this, 'save_product_qr_code'));
            add_action('wp_ajax_qr_code_tab_data', array(&$this, 'qr_code_tab_data'));
            add_action('wp_ajax_nopriv_qr_code_tab_data', array(&$this, 'qr_code_tab_data'));
            add_filter('woocommerce_product_data_tabs', 'qr_code_tab', 10, 1);
            add_action('woocommerce_product_data_panels', 'qr_code_tab_data');
            add_action('wp_ajax_qr_code_tab_data_variable', array(&$this, 'wp_ajax_qr_code_tab_data_variable'));
            add_action('wp_ajax_nopriv_qr_code_tab_data_variable', array(&$this, 'qr_code_tab_data_variable'));
            //  add_filter('woocommerce_product_data_tabs', 'qr_code_tab_variable', 10, 1);
            //  add_action('woocommerce_product_data_panels', 'qr_code_tab_data_variable');
            add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_script'), 10);
            
            
            add_action( 'admin_menu', 'woo_bulk_qr_codes', 9999 );
		}
        
        /**
            * Add QR Code Metabox in product page
            * @global type $WooCommerceQrCodes
		*/
        
        public function add_qr_metabox()
        {
            global $WooCommerceQrCodes, $post_id;
            $_product = wc_get_product($post_id);
            
            // if (is_object($_product) && $_product->is_type('simple')) {
            //     add_meta_box('qr-product-metabox', __('QR Code', $WooCommerceQrCodes->text_domain), array($this, 'qr_product_metabox_callback'), 'product', 'side', 'high');
            // }
            
            if (get_post_type(get_the_ID()) == "shop_coupon") {
                add_meta_box('qr-product-metabox', __('QR Code', $WooCommerceQrCodes->text_domain), array($this, 'qr_coupon_metabox_callback'), 'shop_coupon', 'side', 'high');
			}
		}
        
        public function qr_coupon_metabox_callback()
        {
            global $post;
            $is_qr_code_exist = get_post_meta($post->ID, '_is_qr_code_exist', true);
            if (!empty($is_qr_code_exist)) {
                $coupon_qr_code = get_post_meta($post->ID, '_coupon_qr_code', true);
                if (!empty($coupon_qr_code) && file_exists(WCQRC_QR_IMAGE_DIR . $coupon_qr_code)) {
                    
				?>
                <div class="product-qr-code-container">
                    <img class="product-qr-code-img" src="<?php echo WCQRC_QR_IMAGE_URL . $coupon_qr_code; ?>" alt="QR Code" />
				</div>
                <div class=""></div>
                
                <div data-product_id="<?php echo $post->ID; ?>" class="button-primary delete-coupon">Delete Coupon
				</div>
                
			</a>
            <div data-product_id="<?php echo $post->ID; ?>" class="button-primary print-qr dashicons-before dashicons-print">Print coupon QR
			</div>
            <?php
                } else {
                delete_post_meta($post->ID, '_is_qr_code_exist');
                delete_post_meta($post->ID, '_coupon_qr_code');
			}
		} else { ?>
        <div class="coupon" id="coupon_<?php echo $post->ID; ?>">
            <div data-product_id="<?php echo $post->ID; ?>" class="button-primary generate-coupon">Generate Coupon
			</div><br><br>
            <div id="coupon"><?php //echo $post->ID;
			?></div>
		</div>
        <?php
		}
	}
    
    
    // delete qr coupon
    
    public function delcoupon()
    {
        
        global $WooCommerceQrCodes, $product, $post;
        
        if (isset($_REQUEST)) {
            $couid = $_REQUEST['couid'];
            $is_qr_code_exist = get_post_meta($couid, '_is_qr_code_exist', true);
            if (!empty($is_qr_code_exist)) {
                
                unlink(WCQRC_QR_IMAGE_DIR . $image_name);
                
                delete_post_meta($couid, '_is_qr_code_exist', 1);
                delete_post_meta($couid, '_coupon_qr_code', $image_name);
                
			?>
            <button type="button" data-product_id="<?php echo $couid; ?>" class="button-primary generate-coupon ">Generate coupon
			</button>
            
            <?php
			}
            die();
		}
        die();
	}
    //generate qr coupon
    public function gencoupon()
    {
        
        global $WooCommerceQrCodes, $product, $rgb, $post;
        
        if (isset($_REQUEST)) {
            $couid = sanitize_text_field($_REQUEST['couid']);
            $is_qr_code_exist = get_post_meta($couid, '_coupon_qr_code', true);
            if (empty($coupon_qr_code)) {
                
                $add_to_cart = site_url() . "/cart/?coupon_code=" . get_the_title($couid);
                $image_name = time() . '_' . $couid . '.png';
                $fileName = time() . '_' . $couid . '.png';
                $qr_size = 2;
                $qr_frame_size = 6;
                $print_qr_image = $WooCommerceQrCodes->QRcode->png($add_to_cart, WCQRC_QR_IMAGE_DIR . $image_name, QR_ECLEVEL_M, $qr_size, $qr_frame_size, false);
                echo $print_qr_image;
			?>
            <img class="product-qr-code-img" src="<?php echo WCQRC_QR_IMAGE_URL . $image_name; ?>" alt="QR Code" />
            <?php update_post_meta($couid, '_coupon_qr_code', 1);
                
                update_post_meta($couid, '_coupon_qr_code', $image_name);
			?>
            <div class="clear"></div>
            <div data-product_id="<?php echo $couid; ?>" class="button-primary delete-coupon x">Delete Coupon
			</div>
            <div data-product_id="<?php echo $couid; ?>" class="button-primary print-qr dashicons-before dashicons-print">Print QR code sticker
			</div>
            <?php
			}
            die();
		}
	}
    //generate or delete qr code for simple product in bakend
    public function qr_product_metabox_callback($product, $loop)
    {
        global $WooCommerceQrCodes;
        $qr_param = $WooCommerceQrCodes::qr_item_param();
        $is_qr_code_exist = get_post_meta($product->ID, '_is_qr_code_exist', true);
        
        if ($is_qr_code_exist != '') {
            
            $product_qr_code = get_post_meta($product->ID, '_product_qr_code', true);
            
            if (!empty($product_qr_code) && file_exists(WCQRC_QR_IMAGE_DIR . $product_qr_code)) {
			?>
            <div class="result" id="result_<?php echo $product->ID; ?>">
                <img class="product-qr-code-img" src="<?php echo WCQRC_QR_IMAGE_URL . $product_qr_code; ?>" alt="QR Code" />
                <div class="clear"></div>
                <div class="wooqr_actions">
                    <div data-product_id="<?php echo $product->ID; ?>" class="button-primary simple-qr-del h">Delete QR
					</div>
                    <div data-product_id="<?php echo $product->ID; ?>" class="button-primary print-qr dashicons-before dashicons-print">Print QR code sticker
					</div>
				</div>
			</div>
            <?php
			}
            } else {
		?>
        <div class="result" id="result_<?php echo $product->ID; ?>">
            <div class="wooqr_actions">
                <button type="button" data-product_id="<?php echo $product->ID; ?>" class="button-primary simple-qr-gen o">Generate
                    QR
				</button>
			</div>
		</div>
        <?php
		} ?>
        
        <?php
		}
        
        // delete simple product qr code (frontend)
        public function simpleqrdel()
        {
            global $WooCommerceQrCodes, $product;
            if (isset($_REQUEST)) {
                $simid = sanitize_text_field($_REQUEST['simid']);
                $is_qr_code_exist = get_post_meta($simid, '_is_qr_code_exist', true);
                if (!empty($is_qr_code_exist)) {
                    
                    unlink(WCQRC_QR_IMAGE_DIR . $image_name);
                    
                    delete_post_meta($simid, '_is_qr_code_exist', 1);
                    delete_post_meta($simid, '_product_qr_code', $image_name);
                    
                    $_product = wc_get_product( $simid );
                    
                    
				?>
                <img class="product-qr-code-img no_single" src="<?php echo $WooCommerceQrCodes->plugin_url . 'assets/admin/images/no_qr.svg'; ?>" alt="QR Code" />
                <div class="bulk_product-qr-code-title no_single"><?php echo $_product->get_title(); ?></div>
                <div class="bulk_product-qr-code-price no_single"> <?php echo $_product->get_price_html(); ?></div>
                <div class="wooqr_actions">
                    <button type="button" data-product_id="<?php echo $simid; ?>" class="button-primary simple-qr-gen k">Generate QR
					</button>
				</div>
                
                
                <?php
				}
                die();
			}
            
            die();
		}
        
        // generate qr code for simple product (frontend)
        public function simpleqrgen()
        {
            global $WooCommerceQrCodes, $product, $rgb;
            
            if (isset($_REQUEST)) {
                $simid = sanitize_text_field($_REQUEST['simid']);
                $is_qr_code_exist = get_post_meta($simid, '_is_qr_code_exist', true);
                
                if (empty($is_qr_code_exist)) {
                    $add_to_cart = get_permalink($simid);
                    $image_name = time() . '_' . $simid . '.png';
                    $fileName = time() . '_' . $simid . '.png';
                    $qr_size = 10;
                    $qr_frame_size = 2;
                    $print_qr_image = $WooCommerceQrCodes->QRcode->png($add_to_cart, WCQRC_QR_IMAGE_DIR . $image_name, QR_ECLEVEL_M, $qr_size, $qr_frame_size, false);
                    echo $print_qr_image;
				?>
                <img class="product-qr-code-img" src="<?php echo WCQRC_QR_IMAGE_URL . $image_name; ?>" alt="QR Code" />
                <?php update_post_meta($simid, '_is_qr_code_exist', 1);
                    
                    update_post_meta($simid, '_product_qr_code', $image_name);
					$_product = wc_get_product( $simid );
				?>
                <div class="clear" id="clear_<?php echo $simid; ?>"></div>
                <div class="bulk_product-qr-code-title no_single"><?php echo $_product->get_title(); ?></div>
                <div class="bulk_product-qr-code-price no_single"> <?php echo $_product->get_price_html(); ?></div>
                <div class="wooqr_actions">
                    <div data-product_id="<?php echo $simid; ?>" class="button-primary simple-qr-del x">Delete <span>QR</span></div>
                    <div data-product_id="<?php echo $simid; ?>" class="button-primary print-qr dashicons-before dashicons-print">Print <span>QR code sticker</span></div>
				</div>
                <?php
				}
                die();
			}
		}
        
        /* QR Code metabox callback function
            * @param object $product
		*/
        
        public function save_product_qr_code($post_id, $post, $update = null)
        {
            global $WooCommerceQrCodes;
            $qr_param = $WooCommerceQrCodes::qr_item_param();
            if ($post->post_type == 'product') {
                $is_qr_code_exist = get_post_meta($post_id, '_is_qr_code_exist', true);
                if (empty($is_qr_code_exist)) {
                    $add_to_cart = site_url() . "/?qr-add-to-cart=" . $post_id . "&" . $qr_param . "=1";
                    $permalink = get_permalink($post_id);
                    $image_name = time() . '_' . $post_id . '.png';
                    $qr_size = 6;
                    $qr_frame_size = 2;
                    $WooCommerceQrCodes->QRcode->png($add_to_cart, WCQRC_QR_IMAGE_DIR . $image_name, QR_ECLEVEL_M, $qr_size, $qr_frame_size);
                    update_post_meta($post_id, '_is_qr_code_exist', 1);
                    update_post_meta($post_id, '_product_qr_code', $image_name);
				}
			}
            
            if ($post->post_type == 'shop_coupon') {
                $is_qr_code_exist = get_post_meta($post_id, '_is_qr_code_exist', true);
                if (empty($is_qr_code_exist)) {
                    
                    $add_to_cart = site_url() . "/cart/?coupon_code=" . get_the_title($post_id);
                    $permalink = get_permalink($post_id);
                    $image_name = time() . '_' . $post_id . '.png';
                    $qr_size = 6;
                    $qr_frame_size = 2;
                    $WooCommerceQrCodes->QRcode->png($add_to_cart, WCQRC_QR_IMAGE_DIR . $image_name, QR_ECLEVEL_M, $qr_size, $qr_frame_size);
                    
                    //  echo $add_to_cart;
                    update_post_meta($post_id, '_is_qr_code_exist', 1);
                    update_post_meta($post_id, '_coupon_qr_code', $image_name);
				}
			}
		}
        
        /**
            * Save generated QR code
            * @global type $WooCommerceQrCodes
            * @param type $post_id
		*/
        public function save_vproduct_qr_code($post_id)
        {
            global $WooCommerceQrCodes;
            
            $qr_param = $WooCommerceQrCodes::qr_item_param();
            // echo $qr_param; die();
            
            if (get_post_type($post_id) == 'product' || get_post_type($post_id) == 'product_variation') {
                
                $_product = wc_get_product($post_id);
                
                $is_qr_code_exist = get_post_meta($post_id, '_is_qr_code_exist', true);
                
                $aVariationId = $post_id;
                $v = new WC_Product_Variation($value);
                
                $var_name = $v->get_variation_attributes();
                foreach ($var_name as $var_key => $var_val) {
				}
                
                $var_key = key($var_name);
                
                if (empty($is_qr_code_exist)) {
                    
                    // $add_to_cart = site_url() . "/?qr-add-to-cart=" . $post_id . "&" . $qr_param . "=1";
                    $add_to_cart = site_url() . "/?qr-add-to-cart=" . $post_id . "&" . key($var_name) . "=" . $var_name[$var_key] . "&" . $qr_param . "=1";
                    $image_name = time() . '_' . $post_id . '.png';
                    $qr_size = 6;
                    $qr_frame_size = 2;
                    $WooCommerceQrCodes->QRcode->png($add_to_cart, WCQRC_QR_IMAGE_DIR . $image_name, QR_ECLEVEL_M, $qr_size, $qr_frame_size);
                    
                    update_post_meta($post_id, '_is_qr_code_exist', 1);
                    update_post_meta($post_id, '_product_qr_code', $image_name);
				}
			}
		}
        
        /**
            * Delete associated QR image
            * @param type $post_id
		*/
        public function delete_associated_qr_code($post_id)
        {
            if (get_post_type($post_id) == 'product') {
                $is_qr_code_exist = get_post_meta($post_id, '_is_qr_code_exist', true);
                if (!empty($is_qr_code_exist)) {
                    $product_qr_code = get_post_meta($post_id, '_product_qr_code', true);
                    if (!empty($product_qr_code) && file_exists(WCQRC_QR_IMAGE_DIR . $product_qr_code)) {
                        unlink(WCQRC_QR_IMAGE_DIR . $product_qr_code);
					}
				}
			}
		}
        
        /**
            * enqueue admin sctipt
            * @global type $WooCommerceQrCodes
		*/
        
        public function enqueue_admin_script()
        {
            global $WooCommerceQrCodes;
            $screen = get_current_screen();
            
            if ($screen->id == 'product' || $screen->id == 'shop_coupon' || $screen->id == 'product_page_woo_bulk_qr_codes') {
                wp_enqueue_style('wcqrc-product', $WooCommerceQrCodes->plugin_url . 'assets/admin/css/wcqrc-product.css', array(), $WooCommerceQrCodes->version);
                wp_enqueue_script('wcqrc-product', $WooCommerceQrCodes->plugin_url . 'assets/admin/js/wcqrc-product.js', array('jquery'), $WooCommerceQrCodes->version);
                wp_enqueue_script('agaf-product', $WooCommerceQrCodes->plugin_url . 'assets/admin/js/jspdf.js', array('jquery'), $WooCommerceQrCodes->version);
			}
		}
        //generate or delete button in bakend
        public function qr_vproduct_metabox_callback($loop, $variation_data, $variation)
        {
            global $WooCommerceQrCodes, $product;
            $variation_id = $product;
            $product = new WC_Product_Variable();
            $qr_param = $WooCommerceQrCodes::qr_item_param();
            $is_qr_code_exist = get_post_meta($variation->ID, '_is_qr_code_exist', true);
		?>
        <div class="output" id="output_<?php echo $variation->ID; ?>">
            <?php
                if ($is_qr_code_exist != '') {
                    
                    $product_qr_code = get_post_meta($variation->ID, '_product_qr_code', true);
                    if (!empty($product_qr_code) && file_exists(WCQRC_QR_IMAGE_DIR . $product_qr_code)) {
					?>
                    
                    <img class="product-qr-code-img" src="<?php echo WCQRC_QR_IMAGE_URL . $product_qr_code; ?>" alt="QR Code" />
                    <div class="clear"></div>
                    <div data-product_id="<?php echo $variation->ID; ?>" class="button-primary delete-btn b" id="delete-btn">Delete QR
                        Code
					</div>
                    <div data-product_id="<?php echo $variation->ID; ?>" class="button-primary print-qr dashicons-before dashicons-print">Print QR code sticker
					</div>
                    <?php
                        
					}
                    } else {
                    
				?>
                
                <button type="button" data-product_id="<?php echo $variation->ID; ?>" class="button-primary geWooCommerceQrCodesnerate-btn generate-btn d">Generate QR Code
				</button>
                
                <?php
                    
				} ?>
                </div><?php
                
		}
        //delete qr code
        public function variableqrdel()
        {
            global $WooCommerceQrCodes, $product;
            
            if (isset($_REQUEST)) {
                $varid = sanitize_text_field($_REQUEST['varid']);
                $is_qr_code_exist = get_post_meta($varid, '_is_qr_code_exist', true);
                if (!empty($is_qr_code_exist)) {
                    
                    unlink(WCQRC_QR_IMAGE_DIR . $image_name);
                    
                    delete_post_meta($varid, '_is_qr_code_exist', 1);
                    delete_post_meta($varid, '_product_qr_code', $image_name);
                    
					 $_product = wc_get_product( $varid );
					 $variationName = implode(" / ", $_product->get_variation_attributes());
				?>
				<img class="product-qr-code-img no_single" src="<?php echo $WooCommerceQrCodes->plugin_url . 'assets/admin/images/no_qr.svg'; ?>" alt="QR Code" />
                <div class="bulk_product-qr-code-title no_single"><?php echo $_product->get_title() . " - " . $variationName; ?></div>
                <div class="bulk_product-qr-code-price no_single"> <?php echo $_product->get_price_html(); ?></div>
                <div class="wooqr_actions">
                <button type="button" data-product_id="<?php echo $varid; ?>" class="button-primary geWooCommerceQrCodesnerate-btn generate-btn c">Generate QR <span>Code</span>
				</button>
                </div>
				
                <?php
				}
                die();
			}
            
            die();
		}
        public function variableqrgen()
        {
            global $WooCommerceQrCodes, $product;
            
            if (isset($_REQUEST)) {
                $varid = sanitize_text_field($_REQUEST['varid']);
                $is_qr_code_exist = get_post_meta($varid, '_is_qr_code_exist', true);
                if (empty($is_qr_code_exist)) {
                    $add_to_cart = get_permalink($varid);
                    $image_name = time() . '_' . $varid . '.png';
                    $qr_size =  6;
                    $qr_frame_size = 2;
                    $abc = $WooCommerceQrCodes->QRcode->png($add_to_cart, WCQRC_QR_IMAGE_DIR . $image_name, QR_ECLEVEL_M, $qr_size, $qr_frame_size);
                    echo $abc;
					$_product = wc_get_product( $varid );
				
				?>
                <img class="product-qr-code-img" src="<?php echo WCQRC_QR_IMAGE_URL . $image_name; ?>" alt="QR Code" />
                <?php update_post_meta($varid, '_is_qr_code_exist', 1);
                    update_post_meta($varid, '_product_qr_code', $image_name);
				?>
				<div class="bulk_product-qr-code-title no_single"><?php echo $_product->get_title(). ' - '. $product_name = implode(" / ", $_product->get_variation_attributes()); ?></div>
                <div class="bulk_product-qr-code-price no_single"> <?php echo $_product->get_price_html(); ?></div>
                <div class="clear"></div>
                <div class="wooqr_actions">
					<div data-product_id="<?php echo $varid; ?>" class="button-primary delete-btn a" id="delete-btn">Delete <span>QR Code</span>
					</div>
					<div data-product_id="<?php echo $varid; ?>" class="button-primary print-qr dashicons-before dashicons-print">Print <span> QR code sticker </span>
					</div>
				</div>
                <?php
				}
                die();
			}
		}
}


function qr_code_tab_data()
{
    echo '<div id="qr_code_tab_data" class="panel woocommerce_options_panel">';
    global $WooCommerceQrCodes, $product, $rgb;
    if (isset($_REQUEST['post']) && $_REQUEST['action'] == 'edit') {
        $simid = sanitize_text_field($_REQUEST['post']);
        $_product = wc_get_product($simid);
        
        $is_qr_code_exist = get_post_meta($simid, '_is_qr_code_exist', true);
        if (empty($is_qr_code_exist)) {
            
		?>
        <div class="result" id="result_<?php echo $simid; ?>">
            <div class="wooqr_actions">
                <button type="button" data-product_id="<?php echo $simid; ?>" class="button-primary simple-qr-gen o">Generate QR </button>
			</div>
		</div>
        <?php
            } else {
            
            $product_qr_code = get_post_meta($simid, '_product_qr_code', true);
		?>
        <div class="result" id="result_<?php echo $simid; ?>">
            <img class="product-qr-code-img" src="<?php echo WCQRC_QR_IMAGE_URL . $product_qr_code; ?>" alt="QR Code" />
            <br>
            <div class="wooqr_actions">
                <div data-product_id="<?php echo $simid; ?>" class="button-primary simple-qr-del h">Delete QR
				</div>
                <div data-product_id="<?php echo $simid; ?>" class="button-primary print-qr dashicons-before dashicons-print">Print QR code sticker
				</div>
			</div>
		</div>
        <?php
		}
	?>
    
    <?php
        
	}
    echo "</div>";
}


function qr_code_tab($default_tabs)
{
    $default_tabs['qr_code_tab'] = array(
    'label'   =>  __('QR Code', 'domain'),
    'target'  =>  'qr_code_tab_data',
    'priority' => 60,
    'class'   => array('show_if_simple', 'show_if_variable')
    );
    return $default_tabs;
}

// Not using for now
//        function qr_code_tab_variable($default_tabs)
//        {
//            $default_tabs['qr_code_tab_variable'] = array(
//                'label'   =>  __('QR Code', 'domain'),
//                'target'  =>  'qr_code_tab_data_variable',
//                'priority' => 60,
//                'class'   => array('show_if_variable')
//
//            );
//            return $default_tabs;
//        }



function woo_bulk_qr_codes() {
    add_submenu_page( 'edit.php?post_type=product', 'Bulk QR Codes', 'Bulk QR Codes', 'edit_products', 'woo_bulk_qr_codes', 'woo_bulk_qr_codes_callback', 9999 );
}

function woo_bulk_qr_codes_callback() {
    global $WooCommerceQrCodes;
	echo '<div class="wrap"><h1 class="">Bulk QR Code Generator</h1>';
?>

<div class="wooqr-bulk-generate">
    <button type="button" class="button-primary bulk-qr-g">Generate QR in Bulk</button>
    <button type="button" class="button-primary cancel-bulk">Cancel</button>
</div>

<div class="wooqr-search-wrap">
	<input type="text" onkeyup="search_wooqr_list()" name="find-wooqr-pro" id="search-wooqr-pro" placeholder="Search Product">
</div>
<div class="product-grid-container" id="wooqr_pro_grid">
	
	<?php
		$args = array(
		'post_type' => 'product',
		'numberposts' => -1,
		'orderby' => 'ID',
		'order'   => 'ASC',
		);
		$products = get_posts( $args );
		foreach($products as $product):
		// echo '<pre>';
		// print_r( $product);
		// echo '</pre>'; 
		$is_qr_code_exist = get_post_meta($product->ID, '_is_qr_code_exist', true);
		
			$product_query = new WC_Product( $product->ID );
		
		echo '<div class="product-grid-item simp_pro '.$is_qr_code_exist .' '. $product->ID.'">';
		
		if ($is_qr_code_exist != '') {
			
			$product_qr_code = get_post_meta($product->ID, '_product_qr_code', true);
			if (!empty($product_qr_code) && file_exists(WCQRC_QR_IMAGE_DIR . $product_qr_code)) {
			?>
			<div class="result" id="result_<?php echo $product->ID; ?>">
				<img class="product-qr-code-img" src="<?php echo WCQRC_QR_IMAGE_URL . $product_qr_code; ?>" alt="QR Code" />
				<div class="bulk_product-qr-code-title"><?php echo $product->post_title; ?></div>
				<div class="bulk_product-qr-code-price"> <?php echo $product_query->get_price_html(); ?></div>
				
				<div class="wooqr_actions">
					<div data-product_id="<?php echo $product->ID; ?>" class="button-primary simple-qr-del h">Delete
					</div>
					<div data-product_id="<?php echo $product->ID; ?>" class="button-primary print-qr dashicons-before dashicons-print">Print </div>
				</div>
			</div>
			<?php
			}
			} else {
		?>
		<div class="result" id="result_<?php echo $product->ID; ?>">
			
			<img class="product-qr-code-img" src="<?php echo $WooCommerceQrCodes->plugin_url . 'assets/admin/images/no_qr.svg'; ?>" alt="QR Code" />
			<div class="bulk_product-qr-code-title"><?php echo $product->post_title; ?></div>
			<div class="bulk_product-qr-code-price"> <?php echo $product_query->get_price_html(); ?></div>
			<div class="wooqr_actions">
				<button type="button" data-product_id="<?php echo $product->ID; ?>" class="button-primary simple-qr-gen o">Generate
					QR
				</button>
			</div>
		</div>
		<?php
		}
		
		echo '</div>';
		
		
		$product_s = wc_get_product( $product->ID );
		if ($product_s->product_type == 'variable') {
			$args = array(
			'post_parent' => $plan->ID,
			'post_type'   => 'product_variation',
			'numberposts' => -1,
			);
			$variations = $product_s->get_available_variations();
			foreach($variations as $variation):
			$is_qr_code_exist = get_post_meta($variation['variation_id'], '_is_qr_code_exist', true);
			$product_var_query = wc_get_product( $variation['variation_id'] );
			$variationName = implode(" / ", $product_var_query->get_variation_attributes());
			
			echo '<div class="product-grid-item has_var '.$is_qr_code_exist .' '. $variation['variation_id'].'">';
			if ($is_qr_code_exist != '') {
				
				$product_qr_code = get_post_meta($variation['variation_id'], '_product_qr_code', true);
				
				if (!empty($product_qr_code) && file_exists(WCQRC_QR_IMAGE_DIR . $product_qr_code)) {
				?>
				<div class="result" id="result_<?php echo $variation['variation_id']; ?>">
					<img class="product-qr-code-img" src="<?php echo WCQRC_QR_IMAGE_URL . $product_qr_code; ?>" alt="QR Code" />
					<div class="bulk_product-qr-code-title"><?php echo $product->post_title . " - " . $variationName; ?></div>
					<div class="bulk_product-qr-code-price"> <?php echo $product_var_query->get_price_html(); ?></div>
					
					<div class="wooqr_actions">
						<div data-product_id="<?php echo $variation['variation_id']; ?>" class="button-primary delete-btn a" id="delete-btn">Delete
						</div>
						<div data-product_id="<?php echo $variation['variation_id']; ?>" class="button-primary print-qr dashicons-before dashicons-print">Print </div>
					</div>
				</div>
				<?php
				}
				} else {
			?>
			<div class="result" id="result_<?php echo $variation['variation_id']; ?>">
				
				<img class="product-qr-code-img" src="<?php echo $WooCommerceQrCodes->plugin_url . 'assets/admin/images/no_qr.svg'; ?>" alt="QR Code" />
				<div class="bulk_product-qr-code-title"><?php echo $product->post_title . " - " . $variationName; ?></div>
				<div class="bulk_product-qr-code-price"> <?php echo $product_var_query->get_price_html(); ?></div>
				<div class="wooqr_actions">
					<button type="button" data-product_id="<?php echo $variation['variation_id']; ?>" class="button-primary geWooCommerceQrCodesnerate-btn generate-btn d">Generate
						QR
					</button>
				</div>
			</div>
			<?php
			}
			
			echo '</div>';
			
			endforeach;
		}
		endforeach;
	?>
</div>
<?php
	
}            
