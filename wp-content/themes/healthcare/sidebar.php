<div class="sidebar_post">
    <?php 
        $queried_object = get_queried_object(); 
    ?>
    <?php
        $sideBarTitle = codession_qtranslatex_string($queried_object->post_title)[qtrans_getLanguage()];
        if(empty($sideBarTitle)) {
            $sideBarTitle = $queried_object->post_title;
        }
    ?>

    <?php
        if($queried_object->post_type !== NULL) {
            if($queried_object->post_type !== "page") {
                $post_data = get_post($queried_object->post_parent);
                $tax = get_the_terms($queried_object->ID, 'chuyen_muc_hoat_dong');
                if(empty($tax)) {
                    $parent_slug = $post_data->post_name;
                } else {
                    $parent_slug = $tax[0]->slug;
                }

                $args_lienquan = array(
                    'posts_per_page' => 5,
                    'post_type' => $queried_object->post_type,
                    'orderby' => 'rand',
                    'post_status' => 'publish',
                    'post__not_in' => array($queried_object->ID, 225, 221, 219, 223, 227, 217)
                );
                $posts_lienquan = get_posts($args_lienquan);
    ?>

    <h4 class="column-title" style="text-transform: uppercase;">CÁC BÀI VIẾT LIÊN QUAN</h4>
    <?php if($posts_lienquan[0] == NULL) {
        echo "<p>Hiện chưa có bài viết nào</p>";
    } else { ?>
    <ul class="post-list">
        <?php foreach ($posts_lienquan as $post) : setup_postdata($post);
            $bigImg = wp_get_attachment_url( get_post_thumbnail_id(get_the_ID()) );
            $bigImg = $bigImg ? $bigImg : get_template_directory_uri().'/assets/no-image.jpg';
            ?>
        <li><a href="<?php the_permalink(); ?>" class="text-white clearfix" style="width: 100%;">
                <div
                    style="background: url(<?php echo $bigImg ?>) center top no-repeat; width: 85px; height: 45px; background-size: cover; float: left">
                </div>
                <p><?php echo the_title() ?></p>
            </a>
        </li>
        <?php endforeach; }  echo '<br/>';
    }
            }
             ?>
    </ul>

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
                <div
                    style="background: url(<?php echo $feature_image_meta[0] ?>) center top no-repeat; width: 85px; height: 45px; background-size: cover; float: left">
                </div>
                <p><?php echo get_the_title($items->ID) ?></p>
            </a>
        </li>
        <?php endif;endwhile;endwhile; ?>
    </ul>
</div>