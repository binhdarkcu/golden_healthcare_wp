<?php global $post?>
<section id="main-slider" style="position:relative; margin-bottom: 40px" class="">
    <div class="carousel-inner" role="listbox">
        <?php
        $args = array(
            'post_type'	 => 'slide_introduction',
	        'post_status'	 => 'publish',
            'posts_per_page' => -1,
            'tax_query' => array(
                array(
                    'taxonomy' => 'promotion',
                    'field'    => 'slug',
                    'terms'    => 'uu-dai',
                    'operator' => 'NOT IN'
                ),
            ),
        );
            $query = new WP_Query( $args );
            if( $query -> have_posts()) : while ($query -> have_posts()) : $query->the_post();
            $feature_image_id = get_post_thumbnail_id(get_the_ID());
            $feature_image_meta = wp_get_attachment_image_src($feature_image_id, 'full');
        ?>
                <div class="owl-item" style="width: 1588px;">
                    <a href="<?php echo the_permalink() ?>" style="width: 100%; height: 100%;">
                        <div class="item" style="background-image: url('<?php echo $feature_image_meta[0] ?>');" data-content="<?php echo get_the_title() ?>">
                            <div class="slider-inner">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="carousel-content"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
        <?php endwhile;endif; wp_reset_postdata();?>
    </div>
</section><!--/#main-slider-->
