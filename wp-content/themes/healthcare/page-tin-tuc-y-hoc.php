<?php get_header() ?>
<?php
    $queried_object = get_queried_object();
?>
<?php include_once('breadcrumb.php') ?>
<div ng-init="loadData()">
    <section>
        <div class="container container-bd" id="container" style="padding-top: 50px; padding-bottom: 50px;">
            <div class="row">
            <div class="conten col-md-8 col-sm-12 col-xs-12">
            
            <?php
                $parent_args = [
                    'taxonomy'     => 'customers_care',
                    'parent'        => 0,
                    'hide_empty'    => true
                ];
                $parent_terms = get_terms( $parent_args );
                foreach($parent_terms as $parent_term) {
                    if($parent_term->slug == $queried_object->post_name) {
                        $args = array(
                            'parent' => $parent_term->term_taxonomy_id,
                            'orderby' => 'slug',
                            'hide_empty' => true
                        );
                        $child_terms = get_terms( $parent_term->taxonomy, $args );
                        foreach($child_terms as $child_term) { ?>
                            <h4 class="column-title" style="text-transform: uppercase"><?php echo $child_term->name ?></h4>
                            <?php
                                $args = array(
                                    'post_type' => 'cham_soc_khach_hang',
                                    'paged' => $paged,
                                    'posts_per_page' => 5,
                                    'tax_query' => array(
                                        array(
                                            'taxonomy' => $child_term->taxonomy,
                                            'field' => 'slug',
                                            'terms' => $child_term->name
                                        )
                                    )
                                );
                                $query = new WP_Query( $args );
                                if($query->have_posts()) : while($query->have_posts()) : $query->the_post();
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
                                <?php endwhile;endif;
                                        wp_reset_postdata(); ?>
                            <div class="clearfix"></div>
                        <?php }
                    }
                }
            ?>
            <div class="clearfix"></div>
        </div>
        <!---->
        <div class="col-md-4 col-sm-12 col-xs-12" style="position: sticky;top: 0;">
            <?php get_sidebar('cskh'); ?>
        </div>
            </div>
    </section>
</div>
<?php get_footer(); ?>
