<?php
    add_action('rest_api_init', function () {
        register_rest_route('healthcare/v1', '/dat-hen', array(
            'methods' => WP_REST_Server::CREATABLE,
            'callback' => 'create_booking_item',
            'args' => array(
                'id_doctor' => array(
                    'default' => 0,
                    'sanitize_callback' => 'absint',
                ),
                'dayChecked' => array(
                    'default' => '',
                    'sanitize_callback' => 'sanitize_text_field',
                ),
                'time' => array(
                    'default' => '',
                    'sanitize_callback' => 'sanitize_text_field',
                ),
                'symptom' => array(
                    'default' => '',
                    'sanitize_callback' => 'sanitize_text_field',
                ),
                'full_name' => array(
                    'default' => '',
                    'sanitize_callback' => 'sanitize_text_field',
                ),
                'birthday' => array(
                    'default' => '',
                    'sanitize_callback' => 'sanitize_text_field',
                ),
                'gender' => array(
                    'default' => '',
                    'sanitize_callback' => 'sanitize_text_field',
                ),
                'email' => array(
                    'default' => '',
                    'sanitize_callback' => 'sanitize_email',
                ),
                'phone' => array(
                    'default' => '',
                    'sanitize_callback' => 'sanitize_text_field',
                ),
                'examination' => array(
                    'default' => '',
                    'sanitize_callback' => 'sanitize_text_field',
                ),
                'client_code' => array(
                    'default' => '',
                    'sanitize_callback' => 'sanitize_text_field',
                ),
            )
        ));
    });

    add_action('rest_api_init', function () {
      register_rest_route('healthcare/v2', '/dat-cau-hoi', array(
          'methods' => WP_REST_Server::CREATABLE,
          'callback' => 'create_new_question',
          'args' => array(
              'user_id' => array(
                  'default' => 0,
                  'sanitize_callback' => 'absint'
              ),
              'author-name' =>array(
                  'default' => '',
                  'sanitize_callback' => 'sanitize_text_field'
              ),
              'author-email' =>array(
                  'default' => '',
                  'sanitize_callback' => 'sanitize_text_field'
              ),
              'question-title' => array(
                  'default' => '',
                  'sanitize_callback' => 'sanitize_text_field'
              ),
              'chuyenkhoa-category' => array(
                  'default' => '',
                  'sanitize_callback' => 'absint'
              ),
              'question-content' => array(
                  'default' => '',
                  'sanitize_callback' => 'sanitize_text_field'
              )
          )
      ));
    });

    function create_new_question(WP_REST_Request $request){
        global $wpdb;
        $params = $request->get_params();

        $postarr = array(
          'comment_status' => 'open',
          'post_author'    => $params['user_id'],
          'post_content'   => $params['question-content'],
          'post_status'    => 'pending',
          'post_title'     => $params['question-title'],
          'post_type'      => 'dwqa-question',
          'tax_input'      => array(
            'dwqa-question_category'    => array( 29 ),
            'dwqa-question_tag'         => explode( ',', '' ),
            'category'                  => array($params['chuyenkhoa-category'])
          )
        );


        $args = wp_parse_args( $postarr, array(
    			'comment_status' => 'open',
    			'post_author'    => $params['user_id'],
          'question-category' => 29,
    			'post_content'   => $params['question-content'],
    			'post_status'    => 'pending',
    			'post_title'     => $params['question-title'],
    			'post_type'      => 'dwqa-question',
    		) );
    		$args = apply_filters( 'dwqa_insert_question_args', $args );

        $new_question = wp_insert_post( $args, true );

    		if ( ! is_wp_error( $new_question ) ) {

    			if ( isset( $args['tax_input'] ) ) {
    				foreach ( $args['tax_input'] as $taxonomy => $tags ) {
    					wp_set_post_terms( $new_question, $tags, $taxonomy );
    				}
    			}
    			update_post_meta( $new_question, '_dwqa_status', 'open' );
    			update_post_meta( $new_question, '_dwqa_views', 0 );
    			update_post_meta( $new_question, '_dwqa_votes', 0 );
    			update_post_meta( $new_question, '_dwqa_answers_count', 0 );
          update_post_meta( $new_question, '_dwqa_anonymous_email', $params['author-email'] );
          update_post_meta( $new_question, '_dwqa_anonymous_name', $params['author-name'] );
          update_post_meta( $new_question, '_dwqa_is_anonymous', true );
    			add_post_meta( $new_question, '_dwqa_followers', $params['user_id'] );
          $fieldAppKeys = 'field_5e4ba79590ea0';
          $fieldAppValues = array('yes');
          update_field( $fieldAppKeys, $fieldAppValues, $new_question );

          $fieldAppUserIdKeys = 'field_5e4ce64114b9c';
          update_field( $fieldAppUserIdKeys, $params['user_id'], $new_question );
    			$date = get_post_field( 'post_date', $new_question );
    			// dwqa_log_last_activity_on_question( $new_question, 'Create question', $date );
    			//Call action when add question successfull
    			do_action( 'dwqa_add_question', $new_question, $params['user_id'] );
    		}
    		return $new_question;
    		//$new_question = wp_insert_post( $args, true );
    }

    function create_booking_item(WP_REST_Request $request){
        global $wpdb;
        $_table = $wpdb->prefix . 'dathen';
        $params = $request->get_params();

        $result = $wpdb->insert($_table, array(
            'id_doctor' => $params['id_doctor'],
            'dayChecked' => $params['dayChecked'],
            'time' => $params['time'],
            'symptom' => $params['symptom'],
            'full_name' => $params['full_name'],
            'birthday' => $params['birthday'],
            'gender' => $params['gender'],
            'email' => $params['email'],
            'phone' => $params['phone'],
            'examination' => $params['examination'],
            'client_code' => $params['client_code']
        ), array('%d', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s'));
        $data = null;
        $status = 200;
        if($result){
            $params['id'] = $wpdb->insert_id;
            $data = $params;
        }else{
            $status = 500;
        }

        $response = new WP_REST_Response($data);
        $response->set_status($status);
        return $response;
    }

    /* method GET */
    add_action( 'rest_api_init', function () {
        register_rest_route( 'dat-hen', 'v2', array(
            'methods'  => WP_REST_Server::READABLE,
            'callback' => 'get_booking_items',
            'args' => array(
                'day' => array(
                    'default' => '',
                    'sanitize_callback' => 'sanitize_text_field',
                )
            )
        ) );
    } );
    function get_booking_items(WP_REST_Request $request) {
        global $wpdb;
        $_table = $wpdb->prefix . 'dathen';
        $data = null;
        $status = 200;
        $params = $request->get_params();
        $result = $wpdb->get_results("SELECT * FROM $_table");
        // echo $params['day'];
        if($params['day'] !== '') {
            $day = $params['day'];
            $result = $wpdb->get_results("SELECT * FROM $_table WHERE dayChecked = '$day'");
        }
        return $data = $result;
        header('Content-Type: application/json');
        return json_encode(
            $wpdb->get_results($data, OBJECT)
        );
    }
    // =================================================================================

    /* method GET company */
    add_action( 'rest_api_init', function () {
        register_rest_route( 'company', 'v1', array(
            'methods'  => WP_REST_Server::READABLE,
            'callback' => 'get_booking_items_company',
            'args' => array(
                'day' => array(
                    'default' => '',
                    'sanitize_callback' => 'sanitize_text_field',
                )
            )
        ) );
    } );
    function get_booking_items_company(WP_REST_Request $request) {
        global $wpdb;
        $_table = $wpdb->prefix . 'company';
        $data = null;
        $status = 200;
        $params = $request->get_params();
        $result = $wpdb->get_results("SELECT * FROM $_table");
        // echo $params['day'];
        if($params['day'] !== '') {
            $day = $params['day'];
            $result = $wpdb->get_results("SELECT * FROM $_table WHERE day = '$day'");
        }
        return $data = $result;
        header('Content-Type: application/json');
        return json_encode(
            $wpdb->get_results($data, OBJECT)
        );
    }
    add_action('rest_api_init', function () {
        register_rest_route('dat-hen-company', '/v1', array(
            'methods' => WP_REST_Server::CREATABLE,
            'callback' => 'create_booking_item_company',
            'args' => array(
                'company_name' => array(
                    'default' => '',
                    'sanitize_callback' => 'sanitize_text_field',
                ),
                'name' => array(
                    'default' => '',
                    'sanitize_callback' => 'sanitize_text_field',
                ),
                'birthday' => array(
                    'default' => '',
                    'sanitize_callback' => 'sanitize_text_field',
                ),
                'gender' => array(
                    'default' => '',
                    'sanitize_callback' => 'sanitize_text_field',
                ),
                'email' => array(
                    'default' => '',
                    'sanitize_callback' => 'sanitize_text_field',
                ),
                'marital_status' => array(
                    'default' => '',
                    'sanitize_callback' => 'sanitize_text_field',
                ),
                'day' => array(
                    'default' => '',
                    'sanitize_callback' => 'sanitize_email',
                ),
                'sessions' => array(
                    'default' => '',
                    'sanitize_callback' => 'sanitize_text_field',
                ),
                'employee_code' => array(
                    'default' => '',
                    'sanitize_callback' => 'sanitize_text_field',
                ),
                'note' => array(
                    'default' => '',
                    'sanitize_callback' => 'sanitize_text_field',
                ),
                'phone' => array(
                    'default' => '',
                    'sanitize_callback' => 'sanitize_text_field',
                ),
            )
        ));
    });

    function create_booking_item_company(WP_REST_Request $request){
        global $wpdb;
        $_table = $wpdb->prefix . 'company';
        $params = $request->get_params();

        $result = $wpdb->insert($_table, array(
            'company_name' => $params['company_name'],
            'name' => $params['name'],
            'birthday' => $params['birthday'],
            'gender' => $params['gender'],
            'email' => $params['email'],
            'marital_status' => $params['marital_status'],
            'day' => $params['day'],
            'sessions' => $params['sessions'],
            'employee_code' => $params['employee_code'],
            'note' => $params['note'],
            'phone' => $params['phone']
        ), array('%d', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s'));
        $data = null;
        $status = 200;
        if($result){
            $params['ID'] = $wpdb->insert_id;
            $data = $params;
        }else{
            $status = 500;
        }

        $response = new WP_REST_Response($data);
        $response->set_status($status);
        return $response;
    }
	
	function get_answer_common($id) {
		$args = array(
          'post_parent' => $id,
          'post_type' => 'dwqa-answer',
          'post_status' => 'publish',
          'posts_per_page' => 15
      );
      $query = new WP_Query($args);
      $posts = $query->posts;
      return $posts;
	}
	
	function get_answer_from_question_id($data) {
      return get_answer_common($data['id']);
    }

    add_action( 'rest_api_init', function () {
      register_rest_route( 'heathcare/v1', '/get-cau-tra-loi/(?P<id>\d+)', array(
        'methods' => 'GET',
        'callback' => 'get_answer_from_question_id',
      ) );
    } );

    function get_list_tu_van($data) {
      $args = array(
          'post_type' => 'dwqa-question',
          //'author' => $data['id'],
          'posts_per_page' => 15
      );
      $query = new WP_Query($args);
      $posts = $query->posts;
      if ( empty( $posts ) ) {
        return null;
      }
      $postLists = array();
      foreach ($posts as $key => $post) {
        $appUserID = get_field('app_user_id', $post->ID);
        if($appUserID == (int)$data['id']) {
		  $getAnswer = get_answer_common($post->ID);
		  if(count($getAnswer) == 0) {
			  $post->status = 'Chưa có trả lời';
		  } else {
			  $post->status = 'Đã có trả lời';
		  }
          $postLists[] = $post;
        }
      }
      return $postLists;
    }

    add_action( 'rest_api_init', function () {
      register_rest_route( 'heathcare/v1', '/get-list-tu-van/(?P<id>\d+)', array(
        'methods' => 'GET',
        'callback' => 'get_list_tu_van',
      ) );
    } );

    function get_detail_tu_van($data) {
      $getQuestion = get_post($data['id']);
      return $getQuestion;
    }

    add_action( 'rest_api_init', function () {
      register_rest_route( 'heathcare/v1', '/get-chi-tiet-tu-van/(?P<id>\d+)', array(
        'methods' => 'GET',
        'callback' => 'get_detail_tu_van',
      ) );
    } );

    
?>
