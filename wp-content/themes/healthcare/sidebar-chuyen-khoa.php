<div class="col-md-4 col-sm-12 col-xs-12" style="position: sticky;top: 0;">
    <div class="col-xs-12">
        <h4 class="column-title">CÁC CHUYÊN KHOA KHÁC</h4>
        <?php
            $queried_object = get_queried_object();
            $categories =  get_categories(
                array(
                    'exclude' => array($queried_object->term_id, 1),
                    'hide_empty' => false
                )
            );
        ?>
        <ul class="post-list sidebarKhoa">
            <?php foreach ( $categories as $category ) : setup_postdata( $category );
                    $imgUrl = get_field('departments_image', $category); ?>
                <li>
                    <img src="<?php echo $imgUrl ?>" alt="">
                    <a href="<?php echo get_category_link( $category->term_id );?>"><?php echo $category->name ?></a>
                </li>
            <?php endforeach; ?>
        </ul>
        <br/>

        <h4 class="column-title">BÀI VIẾT KHÁC</h4>

        <ul class="post-list sidebar_post">
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
