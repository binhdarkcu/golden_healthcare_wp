<?php get_header() ?>
<?php
$queried_object = get_queried_object();
?>
<?php include_once('breadcrumb.php') ?>
<div ng-init="loadData()">
    <div class="container container-bd" id="container" style="padding-top: 50px">
        <div class="row">
        <div class="conten col-md-8 col-sm-12 col-xs-12" style="margin-top:0">
            <div class="row">
                <div class="col-md-8">
                    <form action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search" method="post" style="margin-bottom: 30px">
                        <input value="<?php echo get_search_query()?>" name="s" class="searchinputm ng-pristine ng-untouched ng-valid ng-empty form-control" type="text" placeholder="Tìm câu hỏi" aria-invalid="false">
                        <input type="hidden" name="page" value="<?php echo $post->post_name ?>">
                    </form>
                </div>
                <div class="col-md-4">
                    <a href="<?php echo dwqa_get_ask_link();?>" class="btn btn-success pull-right">Đặt câu hỏi</a>
                </div>
            </div>
            <h3 style="margin-top: 0;margin-bottom: 30px;">Câu hỏi hằng ngày / hỏi đáp</h3>
            <div class="question">
                <?php
                $args = array(
                    'post_type' => 'dwqa-question',
                    'posts_per_page' => 15,
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'dwqa-question_category',
                            'field'    => 'term_id',
                            'terms'    => 29,
                        ),
                    ),
                );
                $query = new WP_Query($args);
                if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post();
                    $avatar = get_field('avatar', get_the_ID());
                    $displayWeb = get_field('display_app_yes_or_no', get_the_ID());
                    $userAppId = get_field('app_user_id', get_the_ID());
                    print_r($userAppId);
                    if($displayWeb[0] != 'yes') {
                    ?>
                    <div class="advisory">
                        <i class="fa fa-chevron-right" aria-hidden="true" style="color: #000;font-size: 10px;"></i>
                        <a href="<?php echo get_the_permalink() ?>"
                            style="font-size: 16px;display: inline-block;padding-left: 6px;text-transform: capitalize;">
                            <?php echo get_the_title(); ?>
                        </a>
                        <i>
                            &nbsp;&nbsp;(Lượt xem: <?php echo (int) esc_attr( get_post_meta( get_the_ID(), '_dwqa_views', true) ) ?>)
                        </i>
                    </div>
                <?php } endwhile;
                endif;
                wp_reset_postdata(); ?>
            </div>
            <h3 style="margin-top: 50px; margin-bottom: 30px">Câu hỏi thường gặp</h3>
            <?php
                $parent_args = [
                    'taxonomy'     => 'dwqa-question_tag'
                ];
                $parent_terms = get_terms( $parent_args );
                foreach($parent_terms as $key => $parent_term) { ?>
                    <div class="question" style="margin-bottom: 30px;">
                        <h4 style="margin-bottom: 20px;"><?php echo $parent_term->name ?></h4>
                        <section class="tu-van-slider question_number_<?php echo $key ?>">
                            <div class="carousel-inner">
                                <?php
                                    $args = array(
                                        'post_type' => 'dwqa-question',
                                        'posts_per_page' => -1,
                                        'tax_query' => array(
                                            array(
                                                'taxonomy' => $parent_term->taxonomy,
                                                'field' => 'slug',
                                                'terms' => $parent_term->name
                                            )
                                        )
                                    );
                                    $query = new WP_Query( $args );
                                    if($query->have_posts()) : while($query->have_posts()) : $query->the_post();
                                        $feature_image_meta = get_field('avatar');
                                ?>
                                    <div class="item">
                                        <div class="slider-inner">
                                            <div class="carousel-content" style="margin-right: 20px;">
                                                <div class="feature-col">
                                                    <a href="<?php the_permalink(get_the_ID());?>">
                                                        <div class="ehr-title"
                                                            style="width: 100%; height: 142px; background-size: cover; background: url(<?php echo $feature_image_meta["sizes"]["medium"] ?>) no-repeat top center">
                                                            </div>
                                                        <div class="content">
                                                            <h2 style="font-size: 16px;font-weight: normal; text-transform: capitalize; margin: 10px 0 0;line-height: 1.3"><?php echo the_title() ?></h2>
                                                            <p class="limit_row" style="-webkit-line-clamp: 3; "><?php echo get_the_content() ?></p>
                                                            <i>(Lượt xem: <?php echo (int) esc_attr( get_post_meta( get_the_ID(), '_dwqa_views', true) ) ?>)</i>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endwhile;endif;
                                    wp_reset_postdata(); ?>
                            </div>
                        </section>
                    </div>
                <?php } ?>
        </div>
        <!---->
        <div class="col-md-4 col-sm-12 col-xs-12" style="position: sticky;top: 0;">
            <?php get_sidebar('tu-van'); ?>
        </div>
        </div>
    </div>

</div>
<?php get_footer(); ?>
