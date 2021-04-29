<?php
    function register_my_session()
    {
        if( !session_id() )
        {
            session_start();
        }
    }

    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );


    add_action('init', 'register_my_session');
    require_once('inc/api.php'); //Customize functions of plugins Dw-question
    require_once('inc/handle_create_acf.php');
    add_theme_support('post-thumbnails');

    //register menu
    function register_menu() {
        register_nav_menus(array(
            'primary_menus' => 'Primary menus',
            'top_nav' => 'Top Navigation',
            'services' => 'Dịch vụ',
            'specialist' => 'Chuyên khoa',
            'link' => 'Liên kết'
        ));
    }


    // $product_id = $_GET['add-to-cart'];
    // if(!empty($product_id)) {
    //     $product_cart_id = WC()->cart->generate_cart_id( $product_id );
    
    //     if( ! WC()->cart->find_product_in_cart( $product_cart_id ) ){
        
    //         // Yep, the product with ID 55 is NOT in the cart, let's add it then!
    //         WC()->cart->add_to_cart( $product_id );
        
    //     }
        
    // }
    
    add_action('wp_enqueue_scripts', 'custom_select_dropdown');
    function custom_select_dropdown() {
        wp_enqueue_style( 'select2');
        wp_enqueue_script( 'selectinit', get_stylesheet_directory_uri() . '/js/select2-init.js', array( 'selectWoo' ), true );      
    }

    add_action('init', 'register_menu');

    add_filter('wp_nav_menu_objects', 'my_wp_nav_menu_objects', 10, 2);

    function my_wp_nav_menu_objects($items, $args) {

        // loop
        foreach ($items as &$item) {

            // vars
            $icon = get_field('menu_header', $item);


            // append icon
            if ($icon) {

                $item->title .= ' <i class="fa" data-src="' . $icon . '"></i>';

            }

        }


        // return
        return $items;

    }

    /**
     * Grab latest post title by an author!
     *
     * @param array $data Options for the function.
     * @return string|null Post title for the latest, * or null if none.
     */
    function my_get_categories( ) {
      $categories = get_categories(array(
          'hide_empty' => false
      ));

      if ( empty( $categories ) ) {
        return null;
      }

      return $categories;
    }

    add_action( 'rest_api_init', function () {
      register_rest_route( 'goldenheathcare/api_v1', '/get-categories', array(
        'methods' => 'GET',
        'callback' => 'my_get_categories',
      ) );
    } );

    function new_submenu_class($menu) {
        $menu = preg_replace('/ class="sub-menu"/', '/ class="submenu_changed" /', $menu);
        return $menu;
    }

    add_filter('wp_nav_menu', 'new_submenu_class');
    function show_childpages_departments($page_id) {

        // a shortcode should just return the content not echo html
        // so we start to create an object, and on the end we return it
        // if we dont do this the shortcode will be displayed in the top of the content
        ob_start();
        // only start if we are on a single page
        if (is_page()) {

            // get the ID of the current (parent) page
            $current_page_id = get_the_ID();

            // get all the children of the current page
            $child_pages = get_pages(array(
                'child_of' => $page_id,
                'post_status' => 'publish',
            ));

            // start only if we have some childpages
            if ($child_pages) {

                // if we have some children, display a list wrapper
                echo '<div class="childpages 3">';

                // loop trough each childpage
                foreach ($child_pages as $child_page) {

                    $page_id = $child_page->ID; // get the ID of the childpage
                    $page_link = get_permalink($page_id); // returns the link to childpage
                    $page_content = get_field('intro_description', $page_id);
                    $page_img = get_the_post_thumbnail_url($page_id, 'medium'); // returns the featured image <img> element
                    $page_title = $child_page->post_title; // returns the title of the child page
                    $external_link = get_field('external_link', $child_page->ID);
                    // var_dump($external_link);
                    $page_link = $external_link == null ? get_permalink($page_id) : $external_link; // returns the link to childpage
                    ?>
                    <div class="col-md-4" style="margin-bottom: 20px;">
                        <div class="col-md-4 catItemImageBlock">
                            <div class="news">
                                <div class="article">
                                    <!----><a href="<?php echo $page_link; ?>">
                                        <div class="thumb" style="background-image: url(<?php echo $page_img; ?>)"></div>
                                    </a><!---->
                                    <!---->
                                    <!-- <div class="catItemDateCreated">
                                        <?php
                                        //$currentLang = qtrans_getLanguage();
                                        ?>
                                    </div> -->
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8 post-list-right">
                            <h4>
                                <!----><a href="<?php echo $page_link; ?>"><?php echo $page_title; ?></a><!---->
                                <!---->
                            </h4>
                            <p class="block-ellipsis-home-news-3line" style="height: 100%; -webkit-line-clamp: 5;">
                                <?php echo wp_trim_words($page_content, 10, '...'); ?>
                            </p>
                            <a href="#" style="">Chi tiết</a>
                        </div>
                    </div>
                    <?php

                }//END foreach ($child_pages as $child_page)
                ?>
                <div class="social col-md-5">
                    <h4><a href="">Kết nối trực tuyến</a></h4>
                    <div class="icon-social">
                        <?php if (get_field('footer_socials', 'option')): ?>
                            <?php while (has_sub_field('footer_socials', 'option')): ?>
                                <a style="display: inline-block;"
                                   class="<?php echo get_sub_field('social_name'); ?> icon-footer"
                                   href="<?php echo get_sub_field('social_link'); ?>"><?php echo get_sub_field('social_name'); ?></a>
                            <?php endwhile; ?>
                        <?php endif; ?>
                    </div>
                </div>
                </div>
                <?php

            }//END if ($child_pages)

        }//END if (is_page())

        // return the object
        return ob_get_clean();

    }

    add_shortcode('show_childpages', 'show_childpages_departments');

    function show_childpages_shortcode($page_id) {

        // a shortcode should just return the content not echo html
        // so we start to create an object, and on the end we return it
        // if we dont do this the shortcode will be displayed in the top of the content
        ob_start();
        // only start if we are on a single page
        if (is_page()) {

            // get the ID of the current (parent) page
            $current_page_id = get_the_ID();

            // get all the children of the current page
            $child_pages = get_pages(array(
                'child_of' => $page_id,
                'post_status'  => 'publish',
            ));

            // start only if we have some childpages
            if ($child_pages) {

                // if we have some children, display a list wrapper
                echo '<div class="childpages 1">';

                // loop trough each childpage
                foreach ($child_pages as $child_page) {

                    $page_id = $child_page->ID; // get the ID of the childpage
                    $page_link = get_permalink($page_id); // returns the link to childpage
                    $page_content = get_field('intro_description', $page_id);
                    $page_img = get_the_post_thumbnail_url($page_id, 'medium'); // returns the featured image <img> element
                    $page_title = $child_page->post_title; // returns the title of the child page
                    $external_link = get_field('external_link', $child_page->ID);
                    $page_link = $external_link == null ? get_permalink($page_id) : $external_link; // returns the link to childpage
                    ?>
                    <div class="row wow fadeInDown animated" style="visibility: visible; animation-name: fadeInDown;">
                        <div class="col-md-4 catItemImageBlock">
                            <div class="news">
                                <div class="article">
                                    <!----><a href="<?php echo $page_link; ?>">
                                        <div class="thumb" style="background-image: url(<?php echo $page_img; ?>)"></div>
                                    </a><!---->
                                    <!---->
                                    <!-- <div class="catItemDateCreated">
                                        <?php
                                        //$currentLang = qtrans_getLanguage();
                                        ?>
                                        <span class="day"><?php echo $currentLang == 'en' ? 'Day' : 'Ngày'; ?><?php echo get_the_date('d', $page_id); ?></span>
                                        <span class="month"><?php echo $currentLang == 'en' ? 'Month' : 'Tháng'; ?><?php echo get_the_date('m', $page_id); ?></span>
                                    </div> -->
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8 post-list-right">
                            <h3>
                                <!----><a href="<?php echo $page_link; ?>"><?php echo $page_title; ?></a><!---->
                                <!---->
                            </h3>
                            <p class="block-ellipsis-home-news-3line" style="height: 100%; -webkit-line-clamp: 5;">
                                <?php echo $page_content; ?>
                            </p>
                        </div>
                        <div class="clearfix"></div>
                        <hr>
                    </div>
                    <?php

                }//END foreach ($child_pages as $child_page)

                echo '</div>';

            }//END if ($child_pages)
            else{
                echo apply_filters( 'the_content', get_post_field('post_content', $page_id) );
            }
        }//END if (is_page())

        // return the object
        return ob_get_clean();

    }

    add_shortcode('show_childpages', 'show_childpages_shortcode');

    function show_childpages_of_mainwork($page_id) {

        // a shortcode should just return the content not echo html
        // so we start to create an object, and on the end we return it
        // if we dont do this the shortcode will be displayed in the top of the content
        ob_start();
        // only start if we are on a single page
        if (is_page() || is_home()) {
            // get the ID of the current (parent) page
            $current_page_id = get_the_ID();
            // get all the children of the current page
            $child_pages = get_pages(array(
                'child_of' => $page_id,
                'post_status' => 'publish',
            ));

            // start only if we have some childpages
            if ($child_pages) {

                // if we have some children, display a list wrapper
                echo '<div class="childpages 2">';

                // loop trough each childpage
                foreach ($child_pages as $child_page) {

                    $page_id = $child_page->ID; // get the ID of the childpage
                    $page_content = get_field('intro_description', $page_id);
                    $page_img = get_the_post_thumbnail_url($page_id, 'medium'); // returns the featured image <img> element
                    $page_title = $child_page->post_title; // returns the title of the child page
                    $external_link = get_field('external_link', $child_page->ID);
                    $page_link = $external_link == null ? get_permalink($page_id) : $external_link; // returns the link to childpage
                    ?>
                    <div class="col-md-4 col-sm-6 wow fadeInUp service-box animated" data-wow-duration="300ms"
                         data-wow-delay="0ms"
                         style="visibility: visible; animation-duration: 300ms; animation-delay: 0ms; animation-name: undefined;">
                        <div class="service-box-pad">
                            <div class="media service-box">
                                <div class="pull-left" style="width: 100%;text-align: center;">
                                    <a href="<?php echo $page_link; ?>">
                                    <i class="fa"
                                       style="background: url(<?php echo $page_img; ?>); background-size: cover;"></i>
                                        <h4 class="media-heading block-ellipsis-home-news-2line"
                                            style="line-height:1.5 !important;font-size: 15px;"><?php echo $page_title; ?></h4>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div><!--/.col-md-4-->
                    <?php

                }//END foreach ($child_pages as $child_page)

                echo '</div>';

            }//END if ($child_pages)

        }//END if (is_page())

        // return the object
        return ob_get_clean();

    }

    add_shortcode('show_childpages_of', 'show_childpages_of_mainwork');

    function codession_qtranslatex_string($content) {
        $total_lang = substr_count($content, '[:');
        $lang = array();
        $start_index = 0;

        if ($total_lang > 0) {
            while ($total_lang--) {
                // last language
                if ($total_lang == 0) {
                    $lang_code = substr($content, $start_index + 2, 2);
                    $lang[$lang_code] = substr($content, $start_index + 5);
                    break;
                }
                // find the occurance of "[" from start
                $end_index = strpos($content, '[:', $start_index + 5);
                $lang_code = substr($content, $start_index + 2, 2);
                if ($end_index) {
                    $lang[$lang_code] = substr($content, $start_index + 5, $end_index - $start_index - 5);
                    $start_index = $end_index;
                } else {
                    return false;
                }
            }
            return $lang;
        } else {
            return false;
        }
    }

    if (function_exists('acf_add_options_page')) {
        acf_add_options_page(array(
            'page_title' => 'Theme Options',
            'menu_title' => 'Theme Options',
            'menu_slug' => 'theme-general-settings'
        ));
        acf_add_options_sub_page(array(
            'page_title' => 'Header',
            'menu_title' => 'Header',
            'parent_slug' => 'theme-general-settings',
        ));
        acf_add_options_sub_page(array(
            'page_title' => 'Footer',
            'menu_title' => 'Footer',
            'parent_slug' => 'theme-general-settings',
        ));
        acf_add_options_sub_page(array(
            'page_title' => 'Dịch vụ',
            'menu_title' => 'Dịch vụ',
            'parent_slug' => 'theme-general-settings',
        ));
        acf_add_options_sub_page(array(
            'page_title' => 'Tiêu đề',
            'menu_title' => 'Tiêu đề',
            'parent_slug' => 'theme-general-settings',
        ));
        acf_add_options_sub_page(array(
            'page_title' => 'Danh sách công ty',
            'menu_title' => 'Danh sách công ty',
            'parent_slug' => 'theme-general-settings'
        ));
    }

    function revcon_change_post_label()  {
        global $menu;
        global $submenu;
        $menu[5][0] = 'Bác sĩ';
        $submenu['edit.php'][5][0] = 'Bác sĩ';
        $submenu['edit.php'][15][0] = 'Các Khoa';
        $submenu['edit.php'][10][0] = 'Thêm Bác sĩ';
        $submenu['edit.php'][16][0] = 'Thêm Tags';
    }

    function revcon_change_post_object() {
        global $wp_post_types;
        $labels = &$wp_post_types['post']->labels;
        $labels->name = 'Bác sĩ';
        $labels->singular_name = 'Bác sĩ';
        $labels->add_new = 'Thêm Bác sĩ';
        $labels->add_new_item = 'Thêm Bác sĩ';
        $labels->edit_item = 'Sửa Bác sĩ';
        $labels->new_item = 'Bác sĩ';
        $labels->view_item = 'Xem Bác sĩ';
        $labels->search_items = 'Tìm Kiếm';
        $labels->not_found = 'No News found';
        $labels->not_found_in_trash = 'No News found in Trash';
        $labels->all_items = 'Tất cả Bác sĩ';
        // $labels->menu_name = 'Profiles';
        $labels->name_admin_bar = 'Bác sĩ';
    }

    add_action('admin_menu', 'revcon_change_post_label');
    add_action('init', 'revcon_change_post_object');

    function customize_acf() {
        echo '<style>
                .d-none {
                    display: none !important;
                }
                #toplevel_page_wp_list_table_class, #toplevel_page_wp_list_table_company, #toplevel_page_acf-options-header .wp-submenu-wrap li:last-child {
                    display: none !important;
                }
          </style>';
    }

    add_action('admin_head', 'customize_acf');

    function views_count( $question_id = null ) {
        if ( ! $question_id ) {
            global $post;
            $question_id = $post->ID;
            if ( isset( $post->view_count ) ) {
                return $post->view_count;
            }
        }
        $views = get_post_meta( $question_id, '_dwqa_views', true );
        if ( ! $views ) {
            return 0;
        } else {
            return ( int ) $views;
        }
    }

    /* The AJAX handler function */
    function localize_my_scripts() {
        wp_enqueue_style( 'slick', get_template_directory_uri(). '/assets/slick.css', array(), '0.1.0', 'all');
        wp_enqueue_style( 'slick-theme', get_template_directory_uri(). '/assets/slick-theme.css', array(), '0.1.0', 'all');
        wp_enqueue_script('jquery-script', get_template_directory_uri() . '/assets/jquery.js', array('jquery'));
        // wp_enqueue_script('noel-script', get_template_directory_uri() . '/assets/noel.js', array('jquery'));
        wp_enqueue_script('moment-script', get_template_directory_uri() . '/assets/moment.js', array('jquery'));
        wp_enqueue_script('bootstrap-script', get_template_directory_uri() . '/assets/bootstrap.min.js', array('jquery'));
        wp_enqueue_script('moment-locales-script', get_template_directory_uri() . '/assets/moment-with-locales.js', array('jquery'));
        wp_enqueue_script('bootstrap-datepicker', get_template_directory_uri() . '/assets/bootstrap-datepicker.js', array('jquery'));
        wp_enqueue_script('bootstrap-datepicker-vi', get_template_directory_uri() . '/assets/bootstrap-datepicker.vi.js', array('jquery'));
        wp_enqueue_script('main-script', get_template_directory_uri() . '/assets/main.js', array('jquery'));
        wp_enqueue_script('jquery-validation', get_template_directory_uri() . '/assets/jquery.validate.min.js', array('jquery'));
        wp_enqueue_script('video-js', get_template_directory_uri() . '/assets/video.js', array('jquery'));
        wp_enqueue_script('video-youtube', get_template_directory_uri() . '/assets/Youtube.js', array('jquery'));
        wp_enqueue_script('ajax-script', get_template_directory_uri() . '/assets/ajaxCall.js', array('jquery'));
        wp_enqueue_script('slick-script', get_template_directory_uri() . '/assets/slick.js', array('jquery'));
        wp_localize_script('ajax-script', 'my_ajax_insert_db', ['ajax_url' => admin_url('admin-ajax.php')]);
    }

    add_action('wp_enqueue_scripts', 'localize_my_scripts');

    /**
     * đặt hẹn bác sĩ
     */
    function insert_db() {
        // Do your processing here (save to database etc.)
        // All WP API functions are available for you here
        global $wpdb;
        $id_doctor = (isset($_POST['id_doctor'])) ? $_POST['id_doctor'] : '';
        $day_booked = (isset($_POST['day_booked'])) ? $_POST["day_booked"] : '';
        $time_booked = (isset($_POST['time_booked'])) ? $_POST['time_booked'] : '';
        $symptom = (isset($_POST['symptom'])) ? $_POST['symptom'] : '';
        $full_name = (isset($_POST['full_name'])) ? $_POST['full_name'] : '';
        $birthday = (isset($_POST['birthday'])) ? $_POST['birthday'] : '';
        $gender = (isset($_POST['gender'])) ? $_POST['gender'] : '';
        $email = (isset($_POST['email'])) ? $_POST['email'] : '';
        $phone = (isset($_POST['phone'])) ? $_POST['phone'] : '';
        $examination = (isset($_POST['examination'])) ? $_POST['examination'] : '';
        $client_code = (isset($_POST['client_code'])) ? $_POST['client_code'] : '';
        $doctorName = (isset($_POST['doctorName'])) ? $_POST['doctorName'] : '';
        $wpdb->insert('wp_dathen', array(
            'id_doctor' => $id_doctor,
            'dayChecked' => $day_booked,
            'time' => $time_booked,
            'symptom' => $symptom,
            'full_name' => $full_name,
            'birthday' => $birthday,
            'gender' => $gender,
            'email' => $email,
            'phone' => $phone,
            'examination' => $examination,
            'client_code' => $client_code
        ));

        /**
         * call function send mail template
         */
        $headers = array('Content-Type: text/html; charset=UTF-8');

        //send email to client
        $subject = 'Lịch hẹn Phòng khám đa khoa quốc tế Golden Healthcare';
        $content = 'Cám ơn bạn đã đặt hẹn online ở PHÒNG KHÁM ĐA KHOA QUỐC TẾ GOLDEN HEALTHCARE<br/><br/>
                    Lịch hẹn của bạn: '. $time_booked . ' ngày ' . $day_booked . '. Bác sĩ: '. $doctorName . '<br/><br/>
                    Hy vọng anh/chị đến trước 15 phút để làm thủ tục. Thân chào.';
        wp_mail($email, $subject, $content, $headers);

        //send email to admin
        $subjectAdmin = 'Lịch đặt hẹn bác sĩ';
        $emailAdmin = get_field('mail_dat_hen', 'option');
        $content1 = 'Xin chào Admin,<br/><br/>
                    Vừa có 1 lịch hẹn mới: <br/><br/>
                    Bác sĩ: .' .$doctorName. '<br/>
                    Ngày: ' . $day_booked . '<br/>
                    Thời gian: ' . $time_booked. '<br/>
                    Triệu chứng lâm sàng: ' .$symptom .'<br/>
                    Tái khám hoặc khám mới: '. $examination . '<br/>
                    Mã khách hàng: ' .$client_code . '<br/>
                    Tên bệnh nhân: ' . $full_name.'<br/>
                    Ngày sinh: '. $birthday . '<br/>
                    Giới tính: '.$gender.'<br/>
                    Email: '.$email.'<br/>
                    Số điện thoại: '. $phone.'<br/><br/>';
        wp_mail($emailAdmin, $subjectAdmin, $content1, $headers);
        wp_die(); // this is required to terminate immediately and return a proper response
    }

    // This will allow not logged in users to use the functionality
    add_action('wp_ajax_nopriv_action_insert_db', 'insert_db');
    // This will allow only logged in users to use the functionality
    add_action('wp_ajax_action_insert_db', 'insert_db');

    function insert_db_schedule_company() {
        // Do your processing here (save to database etc.)
        // All WP API functions are available for you here
        global $wpdb;
        $company_name = (isset($_POST['company_name'])) ? $_POST['company_name'] : '';
        $name = (isset($_POST['name'])) ? $_POST['name'] : '';
        $phone = (isset($_POST['phone'])) ? $_POST['phone'] : '';
        $birthday = (isset($_POST['birthday'])) ? $_POST['birthday'] : '';
        $gender = (isset($_POST['gender'])) ? $_POST['gender'] : '';
        $email = (isset($_POST['email'])) ? $_POST['email'] : '';
        $marital_status = (isset($_POST['marital_status'])) ? $_POST['marital_status'] : '';
        $day = (isset($_POST['day'])) ? $_POST['day'] : '';
        $sessions = (isset($_POST['sessions'])) ? $_POST['sessions'] : '';
        $employee_code = (isset($_POST['employee_code'])) ? $_POST['employee_code'] : '';
        $note = (isset($_POST['note'])) ? $_POST['note'] : '';
        $wpdb->insert('wp_company', array(
            'company_name' => $company_name,
            'name' => $name,
            'birthday' => $birthday,
            'gender' => $gender,
            'email' => $email,
            'phone' => $phone,
            'marital_status' => $marital_status,
            'day' => $day,
            'sessions' => $sessions,
            'employee_code' => $employee_code,
            'note' => $note
        ));
        //send email to admin
        $headers = array('Content-Type: text/html; charset=UTF-8');
        $subjectAdmin = 'Lịch đặt hẹn công ty theo lịch';
        $subject = 'Lịch hẹn Phòng khám đa khoa quốc tế Golden Healthcare';
        $content = 'Cám ơn bạn đã đặt hẹn online ở PHÒNG KHÁM ĐA KHOA QUỐC TẾ GOLDEN HEALTHCARE<br/><br/>
                    Lịch hẹn của bạn là: '. $company_name . ' ngày ' . $day . '. Buổi: '. $sessions . '<br/><br/>
                    Hy vọng anh/chị đến trước 15 phút để làm thủ tục. Thân chào.';
        $emailAdmin = get_field('mail_dat_hen', 'option');
        $content1 = 'Xin chào Admin,<br/><br/>
                    Vừa có 1 lịch hẹn của công ty theo lịch: <br/><br/>
                    Tên công ty: ' . $company_name . '<br/>
                    Tên bệnh nhân: ' . $name.'<br/>
                    Ngày sinh: '. $birthday . '<br/>
                    Giới tính: '.$gender.'<br/>
                    Email: '.$email.'<br/>
                    Số điện thoại: '. $phone.'<br/>
                    Ngày: '. $day . '<br/>
                    Buổi: ' . $sessions . '<br/>
                    Mã công ty: '. $employee_code . '<br/>
                    Ghi chú: ' . $note;
        wp_mail($emailAdmin, $subjectAdmin, $content1, $headers);
        wp_mail($email, $subject, $content, $headers);
        wp_die(); // this is required to terminate immediately and return a proper response
    }

    // This will allow not logged in users to use the functionality
    add_action('wp_ajax_nopriv_action_insert_db_schedule_company', 'insert_db_schedule_company');
    // This will allow only logged in users to use the functionality
    add_action('wp_ajax_action_insert_db_schedule_company', 'insert_db_schedule_company');

    //check time
    function checkTimeBoooked() {
        global $wpdb;
        $id_doctor = (isset($_GET['id_doctor'])) ? $_GET['id_doctor'] : '';
        $day_booked = (isset($_GET['day_booked'])) ? $_GET['day_booked'] : '';
        $time = (isset($_GET['time'])) ? $_GET['time'] : '';
        $result = "SELECT * FROM wp_dathen WHERE id_doctor = $id_doctor AND dayChecked = '$day_booked' AND time = '$time'";
        header('Content-Type: application/json');
        echo json_encode(
            $wpdb->get_results($result, OBJECT)
        );
        wp_die(); // this is required to terminate immediately and return a proper response
    }

    // This will allow not logged in users to use the functionality
    add_action('wp_ajax_nopriv_action_check_time_booked', 'checkTimeBoooked');
    // This will allow only logged in users to use the functionality
    add_action('wp_ajax_action_check_time_booked', 'checkTimeBoooked');

    //get page children
    function my_get_page_children() {
        $childArgs = array(
            'sort_order' => 'ASC',
            'sort_column' => 'menu_order',
            'child_of' => 88
        );
        $childList = get_pages($childArgs);

        return $childList;
    }

    add_filter('single_template', 'define_single_page', 11);
    function define_single_page() {
        global $post;
        if ($post->post_type == 'post') {
            return dirname(__FILE__) . '/single-bac-si.php';
        } else if($post->post_type == 'cam_nhan_khach_hang') {
            return dirname(__FILE__) . '/single-cam_nhan_khach_hang.php';
        } else {
            return dirname(__FILE__) . '/single.php';
        }
    }

    function array_value_recursive($key, array $arr){
        $val = array();
        array_walk_recursive($arr, function($v, $k) use($key, &$val){
            if($k == $key) array_push($val, $v);
        });
        return count($val) > 1 ? $val : array_pop($val);
    }

    // if theme option has row => append to db
    function check_company_list() {
        global $wpdb;
        $company_name_added = "SELECT * FROM wp_list_company";
        $company_name_added = $wpdb->get_var($company_name_added);
        $wpdb->query("TRUNCATE TABLE wp_company_day");
        while (have_rows('schedule_company', 'option')): the_row();
        $wpdb->query("TRUNCATE TABLE wp_list_company");
            if (have_rows('cong_ty')) :
                while (have_rows('cong_ty')): the_row();
                    $name = get_sub_field('name_of_company')['company_name'];
                    $list_days = get_sub_field('name_of_company')['all_day'];
                    $nameOfCompanyLength = get_sub_field('name_of_company')['show_on_site'];
                    if ($nameOfCompanyLength) {
                        $implodeNameOfCompany = 'show';
                    } else {
                        $implodeNameOfCompany = '';
                    }

                    $arrayDb = array(
                        'company_name'  => $name,
                        'company_code'  => get_sub_field('name_of_company')['company_code'],
                        'status_company'   => 'company_schedule',
                        'show_on_site'  => $implodeNameOfCompany
                    );
                    if($company_name_added !== $name) {
                        $wpdb->insert('wp_list_company', $arrayDb);
                    }

                    /*
                    * insert date and session into wp_company_day
                    */
                    if(!$list_days && $company_name_added !== $name) {
                        $wpdb->insert('wp_company_day', array(
                            'company_name'   => $name,
                            'date'  => '',
                            'sessions'  => ''
                        ));
                    }
                    foreach($list_days as $list_day) {
                        $arr = array(
                            'company_name'   => $name,
                            'date'  => $list_day['day'],
                            'morning'  => array_value_recursive('text_morning', $list_day['session_morning']),
                            'amount_morning'  => array_value_recursive('amount_morning', $list_day['session_morning'])[1],
                            'afternoon'  => array_value_recursive('text_afternoon', $list_day['session_afternoon']),
                            'amount_afternoon'  => array_value_recursive('amount_afternoon', $list_day['session_afternoon'])[1]
                        );
                        $wpdb->insert('wp_company_day', $arr);
                    }
                endwhile;
            endif;
            if (have_rows('company_not_schedule')) :
                while (have_rows('company_not_schedule')): the_row();
                    $name = get_sub_field('company_name');
                    $company_name_added = "SELECT company_name FROM wp_list_company WHERE company_name = '$name'";
                    $company_name_added = $wpdb->get_var($company_name_added);
                    $arrayDb = array(
                        'company_name'  => get_sub_field('company_name'),
                        'total_members'  => get_sub_field('total_members'),
                        'status_company'  => 'company_not_schedule'
                    );
                    if($company_name_added !== $name) {
                        $wpdb->insert('wp_list_company', $arrayDb);
                    }
                endwhile;
            endif;
        endwhile;
    }
    //add_action('admin_init', 'check_company_list');

    //check totals number of company
    function checkTotalnumber() {
        global $wpdb;
        $company_name = (isset($_GET['companyName'])) ? $_GET['companyName'] : '';
        $day = (isset($_GET['date'])) ? $_GET['date'] : '';
        $result = "SELECT amount FROM wp_company WHERE company_name = '$company_name' AND day = '$day'";
        $result_list = "SELECT total_members
        FROM wp_list_company
        WHERE company_name = '$company_name'
        AND status_company = 'company_not_schedule'";
        header('Content-Type: application/json');
        echo json_encode(
            array(
                'list_company' => $wpdb->get_results($result_list, OBJECT),
                'company' => $wpdb->get_results($result, OBJECT)
            )
        );
        wp_die(); // this is required to terminate immediately and return a proper response
    }
    // This will allow not logged in users to use the functionality
    add_action('wp_ajax_nopriv_action_check_total_number', 'checkTotalnumber');
    // This will allow only logged in users to use the functionality
    add_action('wp_ajax_action_check_total_number', 'checkTotalnumber');

    //get request insert data into table wp_company with company doesn't schedule
    function insert_db_compant_not_schedule() {
        global $wpdb;
        $company_name = (isset($_POST['company_name'])) ? $_POST['company_name'] : '';
        $amount = (isset($_POST['amount'])) ? $_POST['amount'] : '';
        $name = (isset($_POST['name'])) ? $_POST['name'] : '';
        $birthday = (isset($_POST['birthday'])) ? $_POST['birthday'] : '';
        $gender = (isset($_POST['gender'])) ? $_POST['gender'] : '';
        $email = (isset($_POST['email'])) ? $_POST['email'] : '';
        $phone = (isset($_POST['phone'])) ? $_POST['phone'] : '';
        $statusYourself = (isset($_POST['statusYourself'])) ? $_POST['statusYourself'] : '';
        $date = (isset($_POST['date'])) ? $_POST['date'] : '';
        $session = (isset($_POST['session'])) ? $_POST['session'] : '';
        $codeCompany = (isset($_POST['codeCompany'])) ? $_POST['codeCompany'] : '';
        $noteCompany = (isset($_POST['noteCompany'])) ? $_POST['noteCompany'] : '';
        $wpdb->insert('wp_company', array(
            'company_name'  => $company_name,
            'amount'    => $amount,
            'name'  => $name,
            'birthday'  => $birthday,
            'gender'    => $gender,
            'email' => $email,
            'marital_status'    => $statusYourself,
            'phone' => $phone,
            'day'   => $date,
            'sessions'  => $session,
            'employee_code' => $codeCompany,
            'note'  => $noteCompany
        ));
        //send email to admin
        $headers = array('Content-Type: text/html; charset=UTF-8');
        $subjectAdmin = 'Lịch đặt hẹn công ty không theo lịch';
        $subject = 'Lịch hẹn Phòng khám đa khoa quốc tế Golden Healthcare';
        $content = 'Cám ơn bạn đã đặt hẹn online ở PHÒNG KHÁM ĐA KHOA QUỐC TẾ GOLDEN HEALTHCARE<br/><br/>
                    Lịch hẹn của bạn là: '. $company_name . ' ngày ' . $date . '. Buổi: '. $session . '<br/><br/>
                    Hy vọng anh/chị đến trước 15 phút để làm thủ tục. Thân chào.';
        $emailAdmin = get_field('mail_dat_hen', 'option');
        $content1 = 'Xin chào Admin,<br/><br/>
                    Vừa có 1 lịch hẹn của công ty không theo lịch: <br/><br/>
                    Tên công ty: ' . $company_name . '<br/>
                    Tên bệnh nhân: ' . $name.'<br/>
                    Ngày sinh: '. $birthday . '<br/>
                    Giới tính: '.$gender.'<br/>
                    Email: '.$email.'<br/>
                    Số điện thoại: '. $phone.'<br/>
                    Ngày: '. $date . '<br/>
                    Buổi: ' . $session . '<br/>
                    Mã công ty: '. $codeCompany . '<br/>
                    Ghi chú: ' . $noteCompany;
        wp_mail($emailAdmin, $subjectAdmin, $content1, $headers);
        wp_mail($email, $subject, $content, $headers);
        wp_die(); // this is required to terminate immediately and return a proper response
    }

    // This will allow not logged in users to use the functionality
    add_action('wp_ajax_nopriv_action_insert_db_compant_not_schedule', 'insert_db_compant_not_schedule');
    // This will allow only logged in users to use the functionality
    add_action('wp_ajax_action_insert_db_compant_not_schedule', 'insert_db_compant_not_schedule');

    //Handle get date company
    function handle_check_date() {
        global $wpdb;
        $company_name = (isset($_GET['companyName'])) ? $_GET['companyName'] : '';
        $result = "SELECT date FROM wp_company_day WHERE company_name = '$company_name'";
        header('Content-Type: application/json');
        echo json_encode(
            $wpdb->get_results($result, OBJECT)
        );
        wp_die(); // this is required to terminate immediately and return a proper response
    }
    // This will allow not logged in users to use the functionality
    add_action('wp_ajax_nopriv_action_handle_check_date', 'handle_check_date');
    // This will allow only logged in users to use the functionality
    add_action('wp_ajax_action_handle_check_date', 'handle_check_date');

    //Handle get session company
    function handle_check_session() {
        global $wpdb;
        $company_name = (isset($_GET['companyName'])) ? $_GET['companyName'] : '';
        $day = (isset($_GET['day'])) ? $_GET['day'] : '';
        $result = "SELECT morning, afternoon FROM wp_company_day WHERE company_name = '$company_name' AND date = '$day'";
        header('Content-Type: application/json');
        echo json_encode(
            $wpdb->get_results($result, OBJECT)
        );
        wp_die(); // this is required to terminate immediately and return a proper response
    }
    // This will allow not logged in users to use the functionality
    add_action('wp_ajax_nopriv_action_handle_check_session', 'handle_check_session');
    // This will allow only logged in users to use the functionality
    add_action('wp_ajax_action_handle_check_session', 'handle_check_session');

    //Handle check code company
    function handle_check_code() {
        global $wpdb;
        $company_name = (isset($_GET['company_name'])) ? $_GET['company_name'] : '';
        $company_code = (isset($_GET['companyCode'])) ? $_GET['companyCode'] : '';
        $result = "SELECT * FROM wp_list_company WHERE company_name ='$company_name' AND company_code ='$company_code'";
        header('Content-Type: application/json');
        echo json_encode(
            $wpdb->get_results($result, OBJECT)
        );
        wp_die(); // this is required to terminate immediately and return a proper response
    }
    // This will allow not logged in users to use the functionality
    add_action('wp_ajax_nopriv_action_handle_check_code', 'handle_check_code');
    // This will allow only logged in users to use the functionality
    add_action('wp_ajax_action_handle_check_code', 'handle_check_code');

    //Handle check numbers register on sessions
    function check_number() {
        global $wpdb;
        $company_name = (isset($_GET['company_name'])) ? $_GET['company_name'] : '';
        $company_date = (isset($_GET['date'])) ? $_GET['date'] : '';
        $company_session = (isset($_GET['session'])) ? $_GET['session'] : '';
        $result = "SELECT amount FROM wp_company WHERE company_name = '$company_name' AND day = '$company_date' AND sessions = '$company_session'";
        header('Content-Type: application/json');
        echo json_encode(
            $wpdb->get_results($result, OBJECT)
        );
        wp_die(); // this is required to terminate immediately and return a proper response
    }
    // This will allow not logged in users to use the functionality
    add_action('wp_ajax_nopriv_action_check_number', 'check_number');
    // This will allow only logged in users to use the functionality
    add_action('wp_ajax_action_check_number', 'check_number');

    //Handle check maximun amount register
    function check_amount_register() {
        global $wpdb;
        $company_name = (isset($_GET['company_name'])) ? $_GET['company_name'] : '';
        $company_date = (isset($_GET['day'])) ? $_GET['day'] : '';
        $result = "SELECT * FROM wp_company_day WHERE company_name = '$company_name' AND date = '$company_date'";
        header('Content-Type: application/json');
        echo json_encode(
            $wpdb->get_results($result, OBJECT)
        );
        wp_die(); // this is required to terminate immediately and return a proper response
    }
    // This will allow not logged in users to use the functionality
    add_action('wp_ajax_nopriv_action_check_amount_register', 'check_amount_register');
    // This will allow only logged in users to use the functionality
    add_action('wp_ajax_action_check_amount_register', 'check_amount_register');

    function check_number_view() {
        global $post;
        $count_post = esc_attr( get_post_meta( $post->ID, '_post_views_count', true) );
        if( $count_post == ''){
            $count_post = 1;
            add_post_meta( $post->ID, '_post_views_count', $count_post);
        }else{
            $count_post = (int)$count_post + 1;
            update_post_meta( $post->ID, '_post_views_count', $count_post);
        }
        $visitor_count = get_post_meta( $post->ID, '_post_views_count', true);
        if( $visitor_count == '' ){ $visitor_count = 0; }
        if( $visitor_count >= 1000 ){
            $visitor_count = round( ($visitor_count/1000), 2 );
            $visitor_count = $visitor_count.'k';
        }
        return $visitor_count;
    }
    // send mail contact
    function send_mail_contact() {
        global $wpdb;
        $name = (isset($_POST['name'])) ? $_POST['name'] : '';
        $email = (isset($_POST['email'])) ? $_POST['email'] : '';
        $subject = (isset($_POST['subject'])) ? 'Góp ý về: '.$_POST['subject'] : '';
        $phongban = (isset($_POST['phongban'])) ? $_POST['phongban'] : '';
        $message = (isset($_POST['message'])) ? $_POST['message'] : '';

        /**
         * call function send mail template
         */
        $headers = array('Content-Type: text/html; charset=UTF-8');
        $content = 'Tên: ' . $name. "<br/><br/>
                    Email: " . $email . "<br/><br/>
                    Nội dung: ".$message;
        wp_mail($email, $subject, $content, $headers);

        wp_die(); // this is required to terminate immediately and return a proper response
    }

    // This will allow not logged in users to use the functionality
    add_action('wp_ajax_nopriv_action_send_mail_contact', 'send_mail_contact');
    // This will allow only logged in users to use the functionality
    add_action('wp_ajax_action_send_mail_contact', 'send_mail_contact');

    add_action('admin_menu', 'custom_menu');
    function custom_menu() {
        add_menu_page( 'Đặt hẹn', 'Đặt hẹn', 'edit_posts', 'menu', 'callback_khachle', 'dashicons-admin-site', 5);
        add_submenu_page( 'menu', 'Đặt hẹn công ty', 'Đặt hẹn công ty', 'edit_posts', 'callback_congty', 'callback_congty' );
        add_submenu_page( 'menu', 'Danh sách công ty', 'Danh sách công ty', 'edit_posts', 'callback_list_company', 'callback_list_company' );
    }

    function callback_khachle() {
        $url = admin_url('admin.php?page=wp_list_table_class');
        echo '<script type="text/javascript">window.location.href = "'.$url.'"</script>';
    }

    function callback_congty() {
        $url = admin_url('admin.php?page=wp_list_table_company');
        echo '<script type="text/javascript">window.location.href = "'.$url.'"</script>';
    }
    function callback_list_company() {
        $url = admin_url('admin.php?page=acf-options-danh-sach-cong-ty');
        echo '<script type="text/javascript">window.location.href = "'.$url.'"</script>';
    }

    add_filter('next_posts_link_attributes', 'posts_link_attributes');
    add_filter('previous_posts_link_attributes', 'posts_link_attributes');

    function posts_link_attributes() {
        $code = 'class="styled-button"';
    return str_replace('<a href=', '<a '.$code.' href=', $output);
    }
?>
