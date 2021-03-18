<?php
/**
 * The template for displaying single answers
 *
 * @package DW Question & Answer
 * @since DW Question & Answer 1.4.3
 */
?>
<div>
	<div class="row">
		<div class="col-md-12">
			<h4 class="column-title" style="text-transform: uppercase">Đặt câu hỏi</h4>
			<?php if ( dwqa_current_user_can( 'post_question' ) ) : ?>
				<?php do_action( 'dwqa_before_question_submit_form' ); ?>
				<form method="post" class="dwqa-content-edit-form" enctype="multipart/form-data" style="margin-bottom: 30px">
					<div class="dwqa-search form-group clearfix">
						<label for="question_title"><?php _e( 'Tiêu đề*', 'dw-question-answer' ) ?></label>
						<?php $title = isset( $_POST['question-title'] ) ? sanitize_title( $_POST['question-title'] ) : ''; ?>
						<input type="text" class="form-control" data-nonce="<?php echo wp_create_nonce( '_dwqa_filter_nonce' ) ?>" name="question-title" value="<?php echo $title ?>" tabindex="1">
					</div>
					<div class="form-group clearfix">
						<label for="chuyenkhoa-category"><?php _e( 'Chuyên khoa*', 'dw-question-answer' ) ?></label>
						<select name="chuyenkhoa-category" class="form-control" id="chuyenkhoa-category">
							<option value="" selected="selected">Chọn Chuyên Khoa</option>
							<?php
							$categories = get_categories(array(
								'hide_empty' => false
							));
							foreach( $categories as $category ) {
							?>
								<option <?php if($_POST['chuyenkhoa-category'] == $category->term_id) echo 'selected';?> value="<?php echo $category->term_id;?>"><?php echo $category->name;?></option>
							<?php } ?>

						</select>
					</div>
					<?php if ( dwqa_current_user_can( 'post_question' ) && !is_user_logged_in() ) : ?>
						<div class="form-group clearfix">
							<label for="_dwqa_anonymous_name"><?php _e( 'Họ tên*', 'dw-question-answer' ) ?></label>
							<?php $name = isset( $_POST['_dwqa_anonymous_name'] ) ? sanitize_text_field( $_POST['_dwqa_anonymous_name'] ) : ''; ?>
							<input type="text" class="form-control" name="_dwqa_anonymous_name" value="<?php echo $name ?>" >
						</div>
						<label for="_dwqa_anonymous_birthday"><?php _e( 'Ngày sinh*', 'dw-question-answer' ) ?></label>
						<div class="form-group clearfix input-group date" data-provide="datepicker"
                                                    data-date-autoclose="true" data-date-format="dd/mm/yyyy"
                                                    data-date-days-of-week-highlighted="0,6">
							<?php $birthday = isset( $_POST['_dwqa_anonymous_birthday'] ) ? sanitize_text_field( $_POST['_dwqa_anonymous_birthday'] ) : ''; ?>
							<input type="text" id="ngaysinh" name="_dwqa_anonymous_birthday" class="form-control ng-pristine ng-untouched ng-valid ng-not-empty ng-valid-required" value="<?php echo $birthday ?>" />
							<div class="input-group-addon">
								<span class="fa fa-calendar"></span>
							</div>
						</div>
						<div class="form-group clearfix">
							<label for="_dwqa_anonymous_gender"><?php _e( 'Giới tính*', 'dw-question-answer' ) ?></label>
							<?php $gender = isset( $_POST['_dwqa_anonymous_gender'] ) ? sanitize_text_field( $_POST['_dwqa_anonymous_gender'] ) : ''; ?>
							<select name="_dwqa_anonymous_gender" class="form-control" value="<?php echo $gender ?>">
								<option selected value="">Chọn giới tính</option>
								<option <?php if($_POST['_dwqa_anonymous_gender'] == 'nam') echo 'selected';?> value="nam">Nam</option>
								<option <?php if($_POST['_dwqa_anonymous_gender'] == 'nữ') echo 'selected';?> value="nữ">Nữ</option>
							</select>
						</div>
						<div class="form-group clearfix">
							<label for="_dwqa_anonymous_email"><?php _e( 'Email*', 'dw-question-answer' ) ?></label>
							<?php $email = isset( $_POST['_dwqa_anonymous_email'] ) ? sanitize_email( $_POST['_dwqa_anonymous_email'] ) : ''; ?>
							<input type="email" name="_dwqa_anonymous_email" class="form-control" value="<?php echo $email ?>" >
						</div>
						<div class="form-group clearfix">
							<label for="_dwqa_anonymous_phone_number"><?php _e( 'Số điện thoại', 'dw-question-answer' ) ?></label>
							<?php $phone_number = isset( $_POST['_dwqa_anonymous_phone_number'] ) ? sanitize_text_field( $_POST['_dwqa_anonymous_phone_number'] ) : ''; ?>
							<input type="text" class="form-control" name="_dwqa_anonymous_phone_number" value="<?php echo $phone_number ?>" >
						</div>
								
					<?php endif; ?>
					<div class="form-group clearfix" style="margin-bottom: 0">
						<label for="question-content"><?php _e( 'Nội dung câu hỏi*', 'dw-question-answer' ) ?></label>
						<?php $content = isset( $_POST['question-content'] ) ? sanitize_text_field( $_POST['question-content'] ) : ''; ?>
						<?php dwqa_init_tinymce_editor( array( 'content' => $content, 'textarea_name' => 'question-content', 'id' => 'question-content', 'class' => 'form-control' ) ) ?>
					</div>
					<?php global $dwqa_general_settings; ?>
					<?php if ( isset( $dwqa_general_settings['enable-private-question'] ) && $dwqa_general_settings['enable-private-question'] ) : ?>
					<div class="form-group clearfix">
						<input type="hidden" name="question-status" value="publish"/>
						<input id="question-status" type="checkbox" name="question-status" value="private"/>
						<label for="question-status" style="display: inline-block; padding-left: 10px">Bảo mật</label>
					</div>
					<?php endif; ?>
					<div style="display: none">
						<label for="question-category"><?php _e( 'Category', 'dw-question-answer' ) ?></label>
						<?php
							wp_dropdown_categories( array(
								'name'          => 'question-category',
								'id'            => 'question-category',
								'taxonomy'      => 'dwqa-question_category',
								'hide_empty'    => 0,
								'value_field'	=> 'term_id',
								'quicktags'     => array( 'buttons' => 'strong,em,link,block,del,ins,img,ul,ol,li,code,spell,close' ),
								'selected'      => 29,
							) );
						?>
					</div>
					<?php wp_nonce_field( '_dwqa_submit_question' ) ?>
					<?php dwqa_load_template( 'captcha', 'form' ); ?>
					<?php do_action('dwqa_before_question_submit_button'); ?>
					<button type="submit" name="dwqa-question-submit" class="btn btn-success"><?php _e( 'Gửi', 'dw-question-answer' ) ?></button>
				</form>
				<?php do_action( 'dwqa_after_question_submit_form' ); ?>
			<?php else : ?>
				<div class="alert"><?php _e( 'You do not have permission to submit a question','dw-question-answer' ) ?></div>
			<?php endif; ?>
		</div>
	</div>
</div>
