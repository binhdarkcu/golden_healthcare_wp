<?php get_header() ?>
<?php include_once('breadcrumb.php') ?>
<div ng-init="loadData()" idjhfk>
    <section>
        <div class="container container-bd" id="container" style="padding-top: 50px; padding-bottom: 50px;">
            <div class="conten col-md-8 col-sm-12 col-xs-12">
                <div class="childpages">
                    <div class="row">
                        <h4 class="column-title" style="text-transform: uppercase; margin-bottom: 40px"><?php echo the_title() ?></h4>
                    </div>
                    <?php
                    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                    $args = array(
                        'post_type'	 => 'slide_introduction',
                        'post_status'	 => 'publish',
                        'posts_per_page' => 8,
                        'paged' => $paged
                    );
                    $query = new WP_Query( $args );
                    if( $query -> have_posts()) : while ($query -> have_posts()) : $query->the_post();
                    $feature_image_id = get_post_thumbnail_id(get_the_ID());
                    $feature_image_meta = wp_get_attachment_image_src($feature_image_id, 'full');
                    ?>
                    <div class="row wow fadeInDown animated animated animated" style="visibility: visible;">
                        <div class="col-md-4 catItemImageBlock">
                            <div class="news">
                                <div class="article">
                                    <!----><a href="<?php echo get_permalink() ?>">
                                        <div class="thumb" style="background-image: url(<?php echo $feature_image_meta[0] ?>)"></div>
                                    </a><!---->
                                    <!---->
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8 post-list-right">
                            <h3>
                                <!----><a href="<?php echo get_permalink() ?>"><?php echo the_title() ?></a><!---->
                                <!---->
                            </h3>
                            <?php echo get_field('intro_description', get_the_ID()) ?>
                        </div>
                        <div class="clearfix"></div>
                        <hr>
                    </div>
                    <?php endwhile;endif; wp_reset_postdata();?>
                    <div class="clearfix"></div>
                    <div class="paging pagenavi">
                        <div class="paging-normal">
                            <?php if (function_exists('wp_pagenavi')) {
                                wp_pagenavi(array('query' => $query));
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
