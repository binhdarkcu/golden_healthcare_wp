<?php get_header() ?>
<?php include_once('breadcrumb.php') ?>
<div ng-init="loadData()">
    <section>
        <div class="container container-bd" id="container" style="padding-top: 50px; padding-bottom: 50px;">
            <div class="conten col-md-8 col-sm-12 col-xs-12" style="margin-top:30px">
                <div class="childpages">
                    <div class="row">
                        <?php
                        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                        $childArgs = array(
                            'paged' => $paged,
                            'post_type' => 'page',
                            'post_parent' => get_the_ID(),
                            'posts_per_page' => 10
                        );
                        $childLists = new WP_Query($childArgs);

                        if($childLists->have_posts()) : while($childLists->have_posts()) : $childLists->the_post();
                        $page_content = get_field('intro_description', get_the_ID());
                            $feature_image_id = get_post_thumbnail_id(get_the_ID());
                            $feature_image_meta = wp_get_attachment_image_src($feature_image_id, 'full');
                        ?>
                            <div class="col-md-6 col-sm-12 wow fadeInDown animated animated animated" style="visibility: visible; margin-bottom: 40px">
                                <div class="row wow fadeInDown animated animated" style="visibility: visible; animation-name: fadeInDown;">
                                    <div class="col-md-4 catItemImageBlock">
                                        <div class="news">
                                            <div class="article">
                                                <!----><a href="<?php echo get_the_permalink(get_the_ID()) ?>">
                                                    <div class="thumb" style="background-image: url(<?php echo $feature_image_meta[0] ?>)"></div>
                                                </a><!---->
                                                <!---->
                                                <!-- <div class="catItemDateCreated">
                                                    <span class="day">Ngày <?php echo get_the_date('d') ?></span>
                                                    <span class="month">Tháng <?php echo get_the_date('m') ?></span>
                                                </div> -->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-8 post-list-right">
                                        <h3>
                                            <!----><a href="<?php echo get_the_permalink(get_the_ID()) ?>"><?php echo get_the_title() ?></a><!---->
                                            <!---->
                                        </h3>
                                        <p class="block-ellipsis-home-news-3line" style="height: 100%; -webkit-line-clamp: 5;"><?php echo $page_content ?></p>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                            <?php endwhile;endif;wp_reset_postdata();?>
                    </div>
                    <div class="clearfix"></div>
                    <div class="paging pagenavi">
                        <div class="paging-normal">
                            <?php if (function_exists('wp_pagenavi')) {
                                wp_pagenavi(array('query' => $childLists));
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <!---->
            <div class="col-md-4 col-sm-12 col-xs-12" style="position: sticky;top: 0;">
                <?php get_sidebar() ?>
            </div>
        </div></section>

</div>
<?php get_footer() ?>
