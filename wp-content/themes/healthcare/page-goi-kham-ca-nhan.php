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
                    if ($page = get_page_by_path($queried_object->post_name)) {
                        echo show_childpages_shortcode($page->ID);
                    } else { ?>
                        <h3 class="column-title"><?php echo the_title(); ?></h3>
                        <?php echo get_template_part('tpl-social-share'); ?>
                        <div class="posts">
                            <?php
                            $page = get_post( '565' );
                            echo codession_qtranslatex_string($page->post_content)[qtrans_getLanguage()];
                            ?>
                        </div>
                        <ul class="cd-faq-group" style="margin: 20px 0">
                            <?php
                            $args = array(
                                'post_type' => 'personal_package',
                                'post_status' => 'publish',
                                'posts_per_page'   => -1
                            );
                            $query = new WP_Query($args);
                            while ($query->have_posts()) : $query->the_post();
                                $feature_image_id = get_post_thumbnail_id(get_the_ID());
                                $feature_image_meta = wp_get_attachment_image_src($feature_image_id, 'full');
                                $link = get_field('add_pdf_file');
                                ?>
                                <li>
                                    <a class="cd-faq-trigger"
                                    href="#0"><?php echo the_title() ?> <?php if (!empty($time)) echo '(' . $time . ')'; ?>
                                        <span style="text-decoration: underline; float: right; color: #065fd4">Xem thêm</span></a>
                                    <div class="cd-faq-content row related_doctors">
                                        <?php if ($link) : ?>
                                            <object data="<?php echo $link ?>" type="application/pdf" style="width: 100%; height: 700px">
                                                <embed style="width: 100%; height: 700px" src="https://docs.google.com/viewer?url=<?php echo $link ?>&embedded=true" />
                                            </object>
                                        <?php else : ?>
                                            <?php echo get_the_content() ?>
                                        <?php endif; ?>
                                        <div style="clear: both;"></div>
                                    </div>
                                </li>
                                
                            <?php endwhile; ?>
                        </ul>
                    <?php } ?>
                    <div class="clearfix"></div>
                </div>
                <!---->
                <div class="col-md-4 col-sm-12 col-xs-12" style="position: sticky;top: 0;">
                    <?php get_sidebar(); ?>
                </div>
            </div>
    </section>
</div>
<?php get_footer(); ?>
<script src="<?php echo get_stylesheet_directory_uri(); ?>/assets/questions.js"></script>
