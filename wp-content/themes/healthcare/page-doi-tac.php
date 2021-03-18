<?php get_header()?>
<?php
    $queried_object = get_queried_object();
?>
<?php include_once('breadcrumb.php') ?>
<div ng-init="loadData()">
    <section>
        <div class="container container-bd" id="container" style="padding-top: 50px; padding-bottom: 50px;">
            <div class="row">
                <div class="conten col-md-8 col-sm-12 col-xs-12" style="">
                    <h2 style="margin-bottom: 15px;">Mạng lưới đối tác</h2>
                    <?php
                    $args = array(
                        'post_type'	 => 'doi_tac',
                        'post_status'	 => 'publish',
                        'posts_per_page' => -1
                    );
                        $query = new WP_Query( $args );
                        if( $query -> have_posts()) : while ($query -> have_posts()) : $query->the_post();
                        $feature_image_id = get_post_thumbnail_id(get_the_ID());
                        $feature_image_meta = wp_get_attachment_image_src($feature_image_id, 'full');
                    ?>
                    <div class="item" style="margin-bottom: 15px;">
                        <div class="image" style="float: left;padding-right: 20px;">
                            <img src="<?php echo $feature_image_meta[0] ?>">
                        </div>
                        <div class="content">
                            <h4 class="header"><?php echo get_the_title() ?> </h4>

                            <div class="description">
                                <?php echo get_the_content() ?>
                            </div>
                        </div>
                        <div style="clear: both;"></div>
                    </div>
                    <?php endwhile;endif; wp_reset_postdata();?>
                </div>
                <!---->
                <div class="col-md-4 col-sm-12 col-xs-12" style="position: sticky;top: 0;">
                    <?php get_sidebar();?>
                </div>
            </div>
    </section>

</div>
<?php get_footer();?>
