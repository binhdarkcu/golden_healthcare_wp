<?php
/**
 * The template for displaying answer submit form
 *
 * @package DW Question & Answer
 * @since DW Question & Answer 1.4.3
 */
?>
<?php if(is_user_logged_in()) : ?>
    <div class="dwqa-answer-form">
        <?php do_action( 'dwqa_before_answer_submit_form' ); ?>
        <div class="dwqa-answer-form-title"><?php _e( 'Your Answer', 'dw-question-answer' ) ?></div>
        <form name="dwqa-answer-form" id="dwqa-answer-form" method="post" enctype="multipart/form-data">
            <?php dwqa_print_notices(); ?>
            <?php $content = isset( $_POST['answer-content'] ) ? sanitize_text_field( $_POST['answer-content'] ) : ''; ?>
            <?php dwqa_init_tinymce_editor( array( 'content' => $content, 'textarea_name' => 'answer-content', 'id' => 'dwqa-answer-content' ) ) ?>
            <?php dwqa_load_template( 'captcha', 'form' ); ?>

            <?php if ( dwqa_current_user_can( 'post_answer' ) && !is_user_logged_in() ) : ?>
                <div class="form-group row">
                    <?php $name = isset( $_POST['user-name'] ) ? esc_html( $_POST['user-name'] ) : ''; ?>
                    <div class="col-md-4 col-sm-9 col-xs-8 text-left">
                        <label for="user-name"><?php _e( 'Your Name', 'dw-question-answer' ) ?></label>
                        <input type="text" placeholder="<?php _e( 'Your Name', 'dw-question-answer' ) ?>"
                            name="user-name" value="<?php echo $name ?>" class="form-control ng-pristine ng-untouched" />
                    </div>
                    <div class="col-md-4 col-sm-9 col-xs-8 text-left">
                        <label for="user-email"><?php _e( 'Your Email', 'dw-question-answer' ) ?></label>
                        <?php $email = isset( $_POST['user-email'] ) ? sanitize_email( $_POST['user-email'] ) : ''; ?>
                        <input type="email" class="form-control ng-pristine ng-untouched"
                            name="user-email" placeholder="<?php _e( 'Your Email', 'dw-question-answer' ) ?>" value="<?php echo $email ?>" >
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-4 col-sm-9 col-xs-8 text-left">
                        <label for="user-phone"><?php _e( 'Your Phone', 'dw-question-answer' ) ?></label>
                        <?php $phone = isset( $_POST['user-phone'] ) ? esc_html( $_POST['user-phone'] ) : ''; ?>
                        <input type="text" class="form-control ng-pristine ng-untouched"
                            name="user-phone" placeholder="<?php _e( 'Your Phone', 'dw-question-answer' ) ?>" value="<?php echo $phone ?>" >
                    </div>
                    <div class="col-md-4 col-sm-9 col-xs-8 text-left">
                        <label for="user-science"><?php _e( 'Chuyên khoa', 'dw-question-answer' ) ?></label>
                        <select class="form-control" name="user-specialist">
                            <?php
                            $categories = get_categories(array(
                                'hide_empty' => false
                            ));
                            foreach( $categories as $category ) {
                                $imgUrl = get_field('departments_image', $category);
                                if(!empty($imgUrl)) {
                                    ?>
                                    <option value="<?php echo $category->slug ?>"><?php echo $category->name ?></option>
                                <?php } } ?>
                        </select>
                    </div>
                </div>
            <?php endif; ?>
            <div class="row form-group">
                <div class="col-md-6">
                    <select class="dwqa-select form-control " name="dwqa-status">
                        <optgroup label="<?php _e( 'Who can see this?', 'dw-question-answer' ) ?>">
                            <option value="publish"><?php _e( 'Public', 'dw-question-answer' ) ?></option>
                            <option value="private"><?php _e( 'Only Me &amp; Admin', 'dw-question-answer' ) ?></option>
                        </optgroup>
                    </select>
                    <input type="submit" name="submit-answer" style="float: left; margin-left: 15px;"
                        class="dwqa-btn dwqa-btn-primary btn btn-success" value="<?php _e( 'Send', 'dw-question-answer' ) ?>">
                </div>
            </div>
            <?php do_action('dwqa_before_answer_submit_button'); ?>
            <input type="hidden" name="question_id" value="<?php the_ID(); ?>">
            <input type="hidden" name="dwqa-action" value="add-answer">
            <?php wp_nonce_field( '_dwqa_add_new_answer' ) ?>
        </form>
        <?php do_action( 'dwqa_after_answer_submit_form' ); ?>
    </div>
<?php endif; ?>
