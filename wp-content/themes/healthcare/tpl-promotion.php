<section style="margin-bottom: 60px;">
    <div class="container">
        <!-- <div class="section-header">
            <h2 class="section-title text-center wow fadeInDown animated" style="visibility: visible; animation-name: fadeInDown;"><?php echo get_field('cam_nhan_khach_hang', 'option')['title'] ?></h2>
            <small class="short-desc"><?php echo get_field('cam_nhan_khach_hang', 'option')['description'] ?></small>
        </div> -->
        <div class="row slide-promotion">
            <div class="carousel-inner owl-theme">
                <?php
                    $args = array(
                        'post_type' => 'slide_introduction',
                        'posts_per_page' => 5,
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'promotion',
                                'field'    => 'slug',
                                'terms'    => 'uu-dai',
                            ),
                        ),
                    );
                    $query = new WP_Query( $args );
                    if($query->have_posts()) : while($query->have_posts()) : $query->the_post();
                        $page_content = get_field('intro_description', get_the_ID());
                        $feature_image_id = get_post_thumbnail_id(get_the_ID());
                        $feature_image_meta = wp_get_attachment_image_src($feature_image_id, 'full'); 
                ?>
                    <a class="col-md-12 slide-promotion-item" href="<?php echo get_the_permalink() ?>">
                        <img src="<?php echo $feature_image_meta[0] ?>" alt="">
                    </a>
                <?php endwhile;endif;wp_reset_postdata();?>
            </div>
        </div>
    </div>
</section>