<?php 
    get_header();
?>
<?php include_once('breadcrumb.php') ?>
<div ng-init="loadData()" idjhfk>
    <section>
        <div class="container container-bd" id="container" style="padding-top: 50px; padding-bottom: 50px;">
            <div class="conten col-md-8 col-sm-12 col-xs-12">
                <div class="childpages pageCNKH">
                    <div class="row">
                        <h4 class="column-title" style="text-transform: uppercase; margin-bottom: 40px"><?php echo the_title() ?></h4>
                    </div>
                    <div class="row wow fadeInDown animated animated animated" style="visibility: visible;">
                        <?php
                            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                            $args = array(
                                'post_type' => 'cam_nhan_khach_hang',
                                'posts_per_page' => 10,
                                'paged' => $paged,
                            );
                            $query = new WP_Query( $args );
                            if($query->have_posts()) : while($query->have_posts()) : $query->the_post();
                                $page_content = get_field('intro_description', get_the_ID());
                                $feature_image_id = get_post_thumbnail_id(get_the_ID());
                                $feature_image_meta = wp_get_attachment_image_src($feature_image_id, 'full'); 
                        ?>
                            <div class="styleRow">
                                <h5 style="color: #f7931d; font-weight: bold; text-align: center; font-size: 25px; margin-bottom: 20px"><?php echo the_title() ?></h5>
                                <?php echo $page_content ?>
                                <a href="<?php echo get_the_permalink() ?>"><i>Xem thêm→</i></a>
                            </div>
                        <?php endwhile;endif;wp_reset_postdata();?>
                        <div class="paging pagenavi" style="margin-bottom: 30px">
                            <div class="paging-normal">
                                <?php if (function_exists('wp_pagenavi')) {
                                    wp_pagenavi(array('query' => $query));
                                }
                                wp_reset_query();
                                ?>
                            </div>
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
