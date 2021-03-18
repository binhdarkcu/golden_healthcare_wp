<?php get_header() ?>
<?php
$queried_object = get_queried_object();
?>
<?php include_once('breadcrumb.php') ?>
<div ng-init="loadData()">
    <div class="container container-bd" style="padding-top: 50px; width: 100% !important">
        <div class="row">
        <div class="conten col-md-8 col-sm-12 col-xs-12" style="margin-top:0">
            <div class="row" style="margin-bottom: 30px">
                <div class="col-md-8">
                    <form action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search" method="post">
                        <input value="<?php echo get_search_query()?>" name="s" class="searchinputm ng-pristine ng-untouched ng-valid ng-empty form-control" 
                        type="text" placeholder="Tìm câu hỏi" aria-invalid="false">
                        <input type="hidden" name="page" value="tu-van">
                    </form>
                </div>
            </div>
            <?php
                $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                $s = get_search_query();
                $args = array(
                    'post_type' => 'dwqa-question',
                    'post_status' => 'publish',
                    'posts_per_page'   => 10,
                    'paged' => $paged,
                    's' => $s
                );
                $query = new WP_Query($args);
                if(count($query->posts) > 0) {
                if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post(); ?>
                    <li class="advisory"><a href="<?php echo get_the_permalink() ?>"><?php echo get_the_title(); ?></a></li>
                <?php endwhile;
                endif;
                wp_reset_postdata(); }
                else if(count($query->posts) == 0) {
                    echo '<p>Không tìm thấy câu hỏi nào.</p>';
                }
                ?>
        </div>
        <!---->
        <div class="col-md-4 col-sm-12 col-xs-12" style="position: sticky;top: 0;">
            <?php get_sidebar('tu-van'); ?>
        </div>
        </div>
    </div>
                </div>
</div>
<?php get_footer(); ?>
