<?php get_header() ?>
<?php
    $queried_object = get_queried_object();
    global $wp_taxonomies;
    $tax = $queried_object->taxonomy;
    $post_type = $wp_taxonomies[$tax]->object_type;
    $short_desc = $post_type[0] == 'dich_vu' ? 'field_5c872fa18db6c' : 'intro_description';
?>
<?php include_once('breadcrumb.php') ?>
<div ng-init="loadData()">
    <section>
        <div class="container container-bd" id="container" style="padding-top: 50px; padding-bottom: 50px;">
            <div class="row">
            <div class="conten col-md-8 col-sm-12 col-xs-12">
                <h4 class="column-title" style="text-transform: uppercase;"><?php echo $queried_object->name ?></h4>
                <?php
                    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                    $args = array(
                        'post_type' => $post_type,
                        'paged' => $paged,
                        'posts_per_page' => 10,
                        'tax_query' => array(
                            array(
                                'taxonomy' => $queried_object->taxonomy,
                                'field' => 'slug',
                                'terms' => $queried_object->slug
                            )
                        )
                    );
                    $query = new WP_Query( $args );
                    if($query->have_posts()) : while($query->have_posts()) : $query->the_post();
                    $page_content = get_field($short_desc);
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
                <?php endwhile;endif;wp_reset_postdata();  ?>
                <div class="clearfix"></div>
                <div class="paging pagenavi">
                    <div class="paging-normal">
                        <?php if (function_exists('wp_pagenavi')) {
                            wp_pagenavi(array('query' => $query));
                        }
                        wp_reset_query();
                        ?>
                    </div>
                </div>
            </div>
            <!---->
            <div class="col-md-4 col-sm-12 col-xs-12" style="position: sticky;top: 0;">
            <div class="sidebar_post">
                <?php
                    $taxName = 'customers_care';
                    $terms = get_terms('tab_services');
                ?>
                <?php
                    $sideBarTitle = codession_qtranslatex_string($queried_object->post_title)[qtrans_getLanguage()];
                    if(empty($sideBarTitle)) {
                        $sideBarTitle = $queried_object->post_title;
                    }
                ?>
                <h4 class="column-title" style="text-transform: uppercase;">Nhóm bài viết</h4>
                <ul class="post-list" style="margin-bottom: 0">
                    <?php
                        $termchildrens = get_term_children( $queried_object->parent, $taxName );
                        foreach($termchildrens as $termchildren) { 
                            $current_term = get_term_by('id', $termchildren, $taxName);
                        ?>
                            <li class="clearfix"><i class="fa fa-angle-right pull-left" aria-hidden="true"></i>
                                <a class="pull-left" style="padding-bottom: 0;border: 0;margin-top: -4px;"
                                href="<?php echo get_category_link($current_term->term_id); ?>">
                                    <?php echo $current_term->name; ?>
                                </a>
                            </li>
                        <?php }
                    ?>
                </ul>
                <br/>
                <h4 class="column-title" style="line-height: 1.1">CÁC BÀI VIẾT KHÁC</h4>
                <ul class="post-list">
                <?php
                    while( have_rows('related_posts', 'option') ): the_row();
                    while( have_rows('post_difference', 'option') ): the_row();
                    $items = get_sub_field('name_of_post');
                    if($items):
                    $feature_image_id = get_post_thumbnail_id($items->ID);
                    $feature_image_meta = wp_get_attachment_image_src($feature_image_id, 'full');
                ?>
                        <li><a href="<?php the_permalink($items->ID); ?>" class="text-white clearfix" style="width: 100%;">
                            <div style="background: url(<?php echo $feature_image_meta[0] ?>) center top no-repeat; width: 85px; height: 45px; background-size: cover; float: left"></div>
                            <p><?php echo get_the_title($items->ID) ?></p>
                            </a>
                        </li>
                <?php endif;endwhile;endwhile; ?>
                </ul>
            </div>
            </div>
            </div>
    </section>
</div>
<?php get_footer(); ?>
