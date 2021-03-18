<?php /* Template Name: Question */ ?>
<?php get_header() ?>
<?php include_once('breadcrumb.php') ?>
<?php
while ( have_posts() ) : the_post();
    ?>
    <div ng-init="loadData()">
        <div ng-show="isShow" ng-init="queryView()" aria-hidden="false" class="" style="">
            <div class="container container-bd" style="padding-top: 50px">
                <!---->
                <div class="row">
                    <div class="col-md-8 col-sm-12 col-xs-12 wow fadeInRight postDetail conten">
                        <!----><div ng-if="!isRequiredLogin(post.PostInternal)">
                            <h3 class="column-title"><?php echo the_title();?></h3>
                            <div class="row">
                                <div class="col-md-9">
                                    <?php echo get_template_part('tpl-social-share'); ?>
                                </div>
                                <div class="col-md-3" style="text-align: right">
                                    <span>Lượt xem: <?php echo (int) esc_attr( get_post_meta( get_the_ID(), '_dwqa_views', true) ) ?></span>
                                </div>
                            </div>
                            <div class="posts">
                                <?php echo the_content() ?>
                            </div>
                            <h3 class="column-title" style="margin-top: 20px">Câu hỏi liên quan</h3>
                            <ul class="post-list list-inline" style="display: table;width: 100%; margin-bottom: 50px;">
                                <?php
                                $category_detail=wp_get_post_terms( get_the_ID(), 'dwqa-question_category', array('fields'=>'all') );
                                $ids = wp_list_pluck( $category_detail, 'term_id' );
                                $args = array(
                                    'post_type' => 'dwqa-question',
                                    'post_status' => 'publish',
                                    'posts_per_page' => 10,
                                    'tax_query' => array(
                                        array(
                                            'taxonomy' => 'dwqa-question_category',
                                            'field'    => 'term_id',
                                            'terms'    => $ids,
                                        ),
                                    ),
                                );
                                $query = new WP_Query($args);
                                if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post();
                                ?>
                                <li style="width: 50%;"><i class="fa fa-angle-right" aria-hidden="true"></i><a href="<?php echo get_the_permalink() ?>" class="text-white"><?php echo the_title() ?></a></li>
                                <?php endwhile;
                                endif;
                                wp_reset_postdata(); ?>
                            </ul>
                        </div><!---->
                        <!---->
                    </div>
                    <div class="col-md-4 col-sm-12 col-xs-12" style="position: sticky;top: 0;">
                    <?php
                        if(is_tax()) {
                            get_sidebar('tu-van');
                        } else { 
                            get_sidebar();
                        }
                    ?>
                    </div>
                </div>
            </div>
        </div>

    </div>
<?php endwhile; ?>
<?php get_footer(); ?>
