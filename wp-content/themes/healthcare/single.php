<?php get_header() ?>
<?php
    $queried_object = get_queried_object();
?>
<?php include_once('breadcrumb.php') ?>
<div ng-init="loadData()">
    <section>
        <div class="container container-bd" id="container" style="padding-top: 50px; padding-bottom: 50px;">
            <div class="row">
                <?php print_r($queried_object -> post_type);?>
                <div class="conten <?php echo $queried_object -> post_type == 'product' ? 'col-md-12': 'col-md-8'?> col-sm-12 col-xs-12 ">
                    <?php
                    if ( $page = get_page_by_path( $queried_object->post_name ) ){
                        echo show_childpages_shortcode($page->ID);
                    } else {
                        ?>
                        <?php
                        while ( have_posts() ) : the_post();
                            ?>
                            <h4 class="column-title" style="text-transform: uppercase"><?php echo the_title();?></h4>
                            <div class="row">
                                <div class="col-md-9">
                                    <?php echo get_template_part('tpl-social-share'); ?>
                                </div>
                                <div class="col-md-3" style="text-align: right">
                                    <span>Lượt xem: <?php echo check_number_view() ?></span>
                                </div>
                            </div>
                            <div class="posts">
                                <?php echo the_content() ;?>
                            </div>
                        <?php endwhile; ?>
                        <?php } ?>
                </div>
                <!---->
                <?php if($queried_object -> post_type != 'product') {?>
                <div class="col-md-4 col-sm-12 col-xs-12" style="position: sticky;top: 0;">
                    <?php get_sidebar();?>
                </div>
                <?php }?>
            </div>
    </section>

</div>
<?php get_footer() ?>
