<?php //Customize function Question ?>
<?php
    //count views questions
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
?>

