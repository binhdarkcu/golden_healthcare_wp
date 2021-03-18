<?php /* Template Name: Giới thiệu Template */ ?>
<?php get_header() ?>
<?php
    $queried_object = get_queried_object();
    $args_doctors = array(
        'category' => $queried_object->term_id,
        'category_name' => '',
        'orderby' => 'date',
        'order' => 'DESC',
        'post_type' => 'post'
    );
    $posts_doctors_array = get_posts($args_doctors);
?>
<?php include_once('breadcrumb.php') ?>
<div ng-init="loadData()">
    <div ng-show="isShow" ng-init="queryView()" aria-hidden="false" class="" style="">
        <div class="container container-bd" style="padding-top: 50px">
            <!---->
            <div class="row">
                <div class="col-md-8 col-sm-12 col-xs-12 wow fadeInRight postDetail conten">
                    <!---->
                    <div ng-if="!isRequiredLogin(post.PostInternal)">
                        <?php
                        $categories = get_categories();
                        foreach ($categories as $category) : setup_postdata($category);
                            $notification = get_field('notification', $category);
                            if ($queried_object->term_id == $category->term_id && $notification) {
                                echo '<h3 class="column-title">Thông báo</h3>
                                    <p style="margin-bottom: 30px;">' . $notification . '</p>';
                            }
                            ?>
                        <?php endforeach; ?>
                        <h3 class="column-title">Tổng quan về <?php echo $queried_object->name; ?></h3>
                        <div>
                            <?php echo category_description($queried_object->ID); ?>
                        </div>
                        <br/>

                        <h3 class="column-title">Các bác sĩ thuộc <?php echo $queried_object->name; ?></h3>
                        <!--<p style="font-weight: bold">{{post.DescriptionTrans}}</p>-->
                        <div class="posts related_doctors row">
                            <?php
                            foreach ($posts_doctors_array as $doctor) {
                                $feature_image_id = get_post_thumbnail_id($doctor->ID);
                                $feature_image_meta = wp_get_attachment_image_src($feature_image_id, 'full');
                                ?>
                                <div class="col-md-6 col-xs-12 wow fadeInUp animated" data-wow-delay="0ms"
                                     style="visibility: visible; animation-duration: 300ms; animation-delay: 0ms; animation-name: undefined; margin-bottom: 15px">
                                    <a href="<?php echo the_permalink($doctor->ID) ?>"><img
                                                src="<?php echo $feature_image_meta[0] ?>" alt=""></a>
                                    <div class="fRight">
                                        <p><h5><?php echo $doctor->post_title; ?></h5></p>
                                        <span class="trim_text"><?php echo $doctor->post_content; ?></span>
                                        <a href="<?php echo the_permalink($doctor->ID) ?>">View Profile</a>
                                    </div>
                                </div>
                            <?php } ?>
                            <div style="clear: both"></div>
                        </div>
                        <br/>
                        <h3 class="column-title">Lịch làm việc <?php echo $queried_object->name; ?></h3>
                        <div class="table-responsive">
                            <?php
                            $args = array(
                                'post_type' => 'lich_kham_benh',
                                'post_status' => 'publish',
                                'posts_per_page' => 1
                            );
                            $query = new WP_Query($args);
                            if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post();
                                ?>
                                <table class="table-bordered table-hover tb-shedule" style="width: 100%;">
                                    <tbody>
                                    <tr>
                                        <th>Thứ 2</th>
                                        <th>Thứ 3</th>
                                        <th>Thứ 4</th>
                                        <th>Thứ 5</th>
                                        <th>Thứ 6</th>
                                        <th>Thứ 7</th>
                                        <th>Chủ nhật</th>
                                    </tr>
                                    <tr class="thead-light">
                                        <th colspan="7">Sáng (7h30 - 11h30)</th>
                                    </tr>
                                    <tr>
                                        <?php
                                        if (have_rows('schdule_week_time_morning')):
                                            while (have_rows('schdule_week_time_morning')): the_row();
                                                $dayItems = get_sub_field('schedule_day_week_morning');
                                                foreach ($dayItems as $dayItem) {
                                                    $names = $dayItem["week_doctor_morning"];
                                                    ?>
                                                    <td class="show_doctors"><?php
                                                        foreach ($names as $name) {
                                                            $listCats = get_the_category($name->ID);
                                                            foreach ($listCats as $listCat) {
                                                                if ($listCat->name == $queried_object->name) {
                                                                    echo '<a href="' . get_the_permalink($name->ID) . '">' . $name->post_title . '</a><br/>';
                                                                }
                                                            }
                                                        }
                                                        ?></td>
                                                <?php } endwhile; endif; ?>
                                    </tr>
                                    <tr class="thead-light">
                                        <th colspan="7">Chiều (13h00 - 17h00)</th>
                                    </tr>
                                    <tr>
                                        <?php
                                        if (have_rows('schdule_week_time_afternoon')):
                                            while (have_rows('schdule_week_time_afternoon')): the_row();
                                                $dayItems = get_sub_field('schedule_day_week_afternoon');
                                                foreach ($dayItems as $dayItem) {
                                                    $names = $dayItem["week_doctor_afternoon"];
                                                    ?>
                                                    <td class="show_doctors"><?php
                                                        foreach ($names as $name) {
                                                            $listCats = get_the_category($name->ID);
                                                            foreach ($listCats as $listCat) {
                                                                if ($listCat->name == $queried_object->name) {
                                                                    echo '<a href="' . get_the_permalink($name->ID) . '">' . $name->post_title . '</a><br/>';
                                                                }
                                                            }
                                                        }
                                                        ?></td>
                                                <?php } endwhile; endif; ?>
                                    </tr>
                                    <tr class="thead-light">
                                        <th colspan="7">Tối (18h00 - 19h30)</th>
                                    </tr>
                                    <tr>
                                        <?php
                                        if (have_rows('schdule_week_time_night')):
                                            while (have_rows('schdule_week_time_night')): the_row();
                                                $dayItems = get_sub_field('schedule_day_week_night');
                                                foreach ($dayItems as $dayItem) {
                                                    $names = $dayItem["week_doctor_night"];
                                                    ?>
                                                    <td class="show_doctors"><?php
                                                        foreach ($names as $name) {
                                                            $listCats = get_the_category($name->ID);
                                                            foreach ($listCats as $listCat) {
                                                                if ($listCat->name == $queried_object->name) {
                                                                    echo '<a href="' . get_the_permalink($name->ID) . '">' . $name->post_title . '</a><br/>';
                                                                }
                                                            }
                                                        }
                                                        ?></td>
                                                <?php } endwhile; endif; ?>
                                    </tr>
                                    </tbody>
                                </table>
                            <?php endwhile;endif;
                            wp_reset_postdata(); ?>
                        </div>
                        <br/>
                        <h3 class="column-title">Bài viết về <?php echo $queried_object->name; ?></h3>
                        <div class="childpages row">
                            <?php
                            $args = array(
                                'post_type'	 => 'cham_soc_khach_hang',
                                'post_status'	 => 'publish',
                                'posts_per_page' => -1,
                                'tax_query' => array(
                                    array(
                                        'taxonomy' => 'category',
                                        'field'    => 'term_id',
                                        'terms'    => $queried_object->term_id,
                                    ),
                                ),
                            );
                            $query = new WP_Query( $args );
                            if( $query -> have_posts()) : while ($query -> have_posts()) : $query->the_post();
                                $feature_image_id = get_post_thumbnail_id(get_the_ID());
                                $feature_image_meta = wp_get_attachment_image_src($feature_image_id, 'full');
                                ?>
                                <div class="wow fadeInDown animated animated animated col-md-6 col-xs-12" style="visibility: visible;">
                                    <div class="col-md-4 catItemImageBlock">
                                        <div class="article">
                                            <!----><a href="<?php echo get_permalink() ?>">
                                                <div class="thumb" style="background-image: url(<?php echo $feature_image_meta[0] ?>)"></div>
                                            </a><!---->
                                            <!---->
                                        </div>
                                    </div>
                                    <div class="col-md-8 post-list-right">
                                        <h3>
                                            <!----><a href="<?php echo get_permalink() ?>"><?php echo the_title() ?></a><!---->
                                            <!---->
                                        </h3>
                                        <?php echo get_field('intro_description') ?>
                                    </div>
                                    <div class="clearfix"></div>
                                    <hr>
                                </div>
                            <?php endwhile;endif; wp_reset_postdata();?>
                        </div>
                        <br/>
                        <h3 class="column-title">Hình ảnh về <?php echo $queried_object->name; ?></h3>
                        <section class="galleries">
                            <section id="gallery-slider" style="position:relative;">
                                <div class="carousel-inner" role="listbox">
                                    <?php
                                    $categories = get_categories();
                                    foreach ($categories as $category) : setup_postdata($category);
                                        $imgUrls = get_field('departments_gallery', $category);
                                        if ($queried_object->term_id == $category->term_id) {
                                            foreach ($imgUrls as $imgUrl) {
                                                echo '<a class="example-image-link" href="' . $imgUrl['url'] . '"
                                           data-lightbox="example-set"
                                           data-title="Hình ảnh ' . $category->name . '">
                                            <div style="background: url('.$imgUrl['url'].') center no-repeat; height: 195px; background-size: cover"></div>
                                        </a>';
                                            }
                                        }
                                        ?>
                                    <?php endforeach; ?>
                                </div>
                            </section><!--/#main-slider-->
                        </section>
                        <?php

                        $args_lienquan = array(
                            'posts_per_page' => 5,
                            'post_type' => 'hoat_dong',
                            'post_status' => 'publish',
                            'tax_query' => array(
                                array(
                                    'taxonomy' => 'chuyen_muc_hoat_dong',
                                    'field' => 'slug',
                                    'terms' => array('cac-chuyen-khoa')
                                )
                            )
                        );
                        $posts_lienquan = get_posts($args_lienquan);
                        if (count($posts_lienquan) > 0) {
                            ?>
                            <h3 class="column-title">Các bài viết về khoa</h3>
                            <ul class="post-list">
                                <?php foreach ($posts_lienquan as $post) : setup_postdata($post); ?>
                                    <li><i class="fa fa-angle-right" aria-hidden="true"></i><a
                                                href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php } ?>
                        <br/>
                    </div><!---->
                    <!---->
                    <br/>
                    <br/>
                </div>
                <?php get_sidebar('chuyen-khoa'); ?>
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>
