<?php
/* Template Name: Lịch làm việc */
    get_header();
    $queried_object = get_queried_object();
?>
<?php include_once('breadcrumb.php') ?>
<div ng-init="loadData()">
    <section>
        <div class="container container-bd" id="container" style="padding-top: 50px; padding-bottom: 50px;">
            <div class="row">
                <div class="conten col-md-8 col-sm-12 col-xs-12">
                    <?php if (is_null(get_page_by_path($queried_object->post_name))) { ?>
                        <div class="wow fadeInDown animated"
                             style="visibility: visible; animation-name: fadeInDown; margin-bottom: 30px;">
                            <h3 class="column-title">Thông báo</h3>
                            <?php
                            while (have_posts()) : the_post();
                                ?>
                                <?php echo get_field('intro_description') ?>
                            <?php endwhile; ?>
                            <table class="table table-hover table-bordered table-condensed">
                                <tbody>
                                    <?php
                                        $args = array(
                                            'post_type' => 'lich_kham_benh',
                                            'post_status' => 'publish',
                                            'posts_per_page' => 1
                                        );
                                        $query = new WP_Query($args);
                                        if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post();
                                            $notes = get_field('note');
                                            if($notes) :
                                                foreach($notes as $key => $note) :
                                           ?>
                                                    <tr>
                                                        <td><b>* <?php echo $notes[$key]['add_note'] ?></b></td>
                                                    </tr>
                                            <?php endforeach;endif ?>
                                    <?php endwhile;endif; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php } ?>
                    <div class="wow fadeInDown animated" style="visibility: visible; animation-name: fadeInDown;">
                        <?php
                        if ($page = get_page_by_path($queried_object->post_name)) { ?>
                            <h3 class="column-title">Các chuyên khoa</h3>
                            <div class="row" style="display: flex; flex-flow: wrap row">
                                <?php
                                while (have_posts()) : the_post();
                                    $categories = get_categories(array(
                                        'hide_empty' => false
                                    ));
                                    foreach ($categories as $category) :
                                        setup_postdata( $category );
                                        $imgUrl = get_field('departments_image', $category);
                                        ?>
                                        <div class="col-md-3 col-sm-4 col-xs-12" style="text-align: center; margin-bottom: 15px;">
                                        <a href="<?php echo get_category_link( $category->term_id );?>"><img style="display: table; margin: auto;" src="<?php echo $imgUrl ?>" alt=""></a>
                                            <a href="<?php echo get_category_link( $category->term_id );?>"><?php echo $category->name ?></a>
                                        </div>
                                    <?php endforeach; endwhile; ?>
                            </div>
                            <div class="clearfix"></div>
                            <h3 class="column-title" style="margin-top: 20px;">Kết nối trực tuyến</h3>
                            <div class="icon-social" style="margin-bottom: 30px;">
                                <?php if( get_field('footer_socials', 'option') ): ?>
                                    <?php while(has_sub_field('footer_socials', 'option')): ?>
                                        <a style="display: inline-block;" class="<?php echo ucfirst(get_sub_field('social_name')); ?> icon-footer" href="<?php echo get_sub_field('social_link'); ?>"><?php echo ucfirst(get_sub_field('social_name')); ?></a>
                                    <?php endwhile; ?>
                                <?php endif; ?>
                            </div>
                            <h3 class="column-title"><?php echo the_title(); ?></h3>
                            <ul id="basics" class="cd-faq-group">
                                <?php
                                $categories = get_categories(array(
                                    'hide_empty' => false
                                ));
                                foreach( $categories as $category ) {

                                    $imgUrl = get_field('departments_image', $category);
                                    $time = get_field('departments_time', $category);
                                    ?>
                                    <li>
                                        <a class="cd-faq-trigger" href="#0"><?php echo $category->name ?> <?php if(!empty($time)) echo '('.$time.')' ; ?><span style="text-decoration: underline;     float: right; color: #065fd4">Xem</span></a>
                                        <div class="cd-faq-content row related_doctors">
                                            <?php
                                                $args_doctors = array(
                                                    'category'         => $category->term_id,
                                                    'category_name'    => '',
                                                    'orderby'          => 'date',
                                                    'order'            => 'DESC',
                                                    'post_type'        => 'post'
                                                );
                                                $posts_doctors_array = get_posts( $args_doctors );
                                            ?>
                                            <?php
                                            foreach ( $posts_doctors_array as $doctor ) {
                                                $feature_image_id = get_post_thumbnail_id($doctor -> ID);
                                                $feature_image_meta = wp_get_attachment_image_src($feature_image_id, 'full');
                                            ?>
                                                <div class="col-md-6 col-xs-12">
                                                    <a href="<?php echo the_permalink($doctor -> ID) ?>"><img src="<?php echo $feature_image_meta[0] ?>" alt=""></a>
                                                    <div class="fRight">
                                                        <p><h5><?php echo $doctor->post_title;?></h5></p>
                                                        <span class="trim_text"><?php echo $doctor->post_content;?></span>
                                                        <a href="<?php echo the_permalink($doctor -> ID) ?>">View Profile</a>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            <div style="clear: both;"></div>
                                            <div class="posts custom-responsive-table">
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
                                                        <tr class="hidden-xs">
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
                                                        <tr class="row_data">
                                                            <?php
                                                            if (have_rows('schdule_week_time_morning')):
                                                                while (have_rows('schdule_week_time_morning')): the_row();
                                                                    $dayItems = get_sub_field('schedule_day_week_morning');
                                                                    foreach ($dayItems as $dayItem) {
                                                                        $names = $dayItem["week_doctor_morning"];
                                                                        $days = $dayItem["week_day_morning"];
                                                                        ?>
                                                                        <td class="show_doctors"><?php
                                                                            echo '<span class="visible-xs">'.$days.'</span>';
                                                                            if(!empty($names)) {
                                                                                foreach ($names as $name) {
                                                                                    $listCats = get_the_category($name->ID);
                                                                                    foreach ($listCats as $listCat) {
                                                                                        if($listCat->name == $category->name) {
                                                                                            echo '<a href="'.get_the_permalink($name->ID).'">'.$name->post_title.'</a>';
                                                                                        }
                                                                                    }
                                                                                }
                                                                            }
                                                                            ?></td>
                                                                    <?php } endwhile; endif; ?>
                                                        </tr>
                                                        <tr class="thead-light">
                                                            <th colspan="7">Chiều (13h00 - 17h00)</th>
                                                        </tr>
                                                        <tr class="row_data">
                                                            <?php
                                                            if (have_rows('schdule_week_time_afternoon')):
                                                                while (have_rows('schdule_week_time_afternoon')): the_row();
                                                                    $dayItems = get_sub_field('schedule_day_week_afternoon');
                                                                    foreach ($dayItems as $dayItem) {
                                                                        $names = $dayItem["week_doctor_afternoon"];
                                                                        $days = $dayItem["week_day_afternoon"];
                                                                        ?>
                                                                        <td class="show_doctors"><?php
                                                                            echo '<span class="visible-xs">'.$days.'</span>';
                                                                            if(!empty($names)) {
                                                                                foreach ($names as $name) {
                                                                                    $listCats = get_the_category($name->ID);
                                                                                    foreach ($listCats as $listCat) {
                                                                                        if($listCat->name == $category->name) {
                                                                                            echo '<a href="'.get_the_permalink($name->ID).'">'.$name->post_title.'</a>';
                                                                                        }
                                                                                    }
                                                                                }
                                                                            }
                                                                            ?></td>
                                                                    <?php } endwhile; endif; ?>
                                                        </tr>
                                                        <tr class="thead-light">
                                                            <th colspan="7">Tối (18h00 - 19h30)</th>
                                                        </tr>
                                                        <tr class="row_data">
                                                            <?php
                                                            if (have_rows('schdule_week_time_night')):
                                                                while (have_rows('schdule_week_time_night')): the_row();
                                                                    $dayItems = get_sub_field('schedule_day_week_night');
                                                                    foreach ($dayItems as $dayItem) {
                                                                        $names = $dayItem["week_doctor_night"];
                                                                        $days = $dayItem["week_day_night"];
                                                                        ?>
                                                                        <td class="show_doctors"><?php
                                                                            echo '<span class="visible-xs">'.$days.'</span>';
                                                                            if(!empty($names)) {
                                                                                foreach ($names as $name) {
                                                                                    $listCats = get_the_category($name->ID);
                                                                                    foreach ($listCats as $listCat) {
                                                                                        if($listCat->name == $category->name) {
                                                                                            echo '<a href="'.get_the_permalink($name->ID).'">'.$name->post_title.'</a>';
                                                                                        }
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
                                        </div>
                                    </li>
                                <?php }  ?>
                            </ul>
                        <?php } else {
                            ?>
                            <?php
                            while (have_posts()) : the_post();
                                ?>
                                <h3 class="column-title"><?php echo the_title(); ?></h3>
                                <ul id="basics" class="cd-faq-group">
                                    <?php
                                    $categories = get_categories(array(
                                        'hide_empty' => false
                                    ));
                                    foreach( $categories as $category ) {

                                        $imgUrl = get_field('departments_image', $category);
                                        $time = get_field('departments_time', $category);
                                        ?>
                                        <li>
                                            <a class="cd-faq-trigger"><?php echo $category->name ?> <?php if(!empty($time)) echo '('.$time.')' ; ?><span style="text-decoration: underline;     float: right; color: #065fd4">Xem</span></a>
                                            <div class="cd-faq-content row related_doctors">
                                                <?php
                                                    $args_doctors = array(
                                                        'category'         => $category->term_id,
                                                        'category_name'    => '',
                                                        'orderby'          => 'date',
                                                        'order'            => 'DESC',
                                                        'post_type'        => 'post'
                                                    );
                                                    $posts_doctors_array = get_posts( $args_doctors );
                                                ?>
                                                <?php
                                                foreach ( $posts_doctors_array as $doctor ) {
                                                    $feature_image_id = get_post_thumbnail_id($doctor -> ID);
                                                    $feature_image_meta = wp_get_attachment_image_src($feature_image_id, 'full');
                                                ?>
                                                    <div class="col-md-6 col-xs-12">
                                                        <a href="<?php echo the_permalink($doctor -> ID) ?>"><img src="<?php echo $feature_image_meta[0] ?>" alt=""></a>
                                                        <div class="fRight">
                                                            <p><h5><?php echo $doctor->post_title;?></h5></p>
                                                            <span class="trim_text"><?php echo $doctor->post_content;?></span>
                                                            <a href="<?php echo the_permalink($doctor -> ID) ?>">View Profile</a>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                                <div style="clear: both;"></div>
                                                <div class="posts custom-responsive-table">
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
                                                            <tr class="hidden-xs">
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
                                                            <tr class="row_data">
                                                                <?php
                                                                if (have_rows('schdule_week_time_morning')):
                                                                    while (have_rows('schdule_week_time_morning')): the_row();
                                                                        $dayItems = get_sub_field('schedule_day_week_morning');
                                                                        foreach ($dayItems as $dayItem) {
                                                                            $names = $dayItem["week_doctor_morning"];
                                                                            $days = $dayItem["week_day_morning"];
                                                                            ?>
                                                                            <td class="show_doctors"><?php
                                                                                echo '<span class="visible-xs">'.$days.'</span>';
                                                                                if(!empty($names)) {
                                                                                    foreach ($names as $name) {
                                                                                        $listCats = get_the_category($name->ID);
                                                                                        foreach ($listCats as $listCat) {
                                                                                            if($listCat->name == $category->name) {
                                                                                                echo '<a href="'.get_the_permalink($name->ID).'">'.$name->post_title.'</a>';
                                                                                            }
                                                                                        }
                                                                                    }
                                                                                }
                                                                                ?></td>
                                                                        <?php } endwhile; endif; ?>
                                                            </tr>
                                                            <tr class="thead-light">
                                                                <th colspan="7">Chiều (13h00 - 17h00)</th>
                                                            </tr>
                                                            <tr class="row_data">
                                                                <?php
                                                                if (have_rows('schdule_week_time_afternoon')):
                                                                    while (have_rows('schdule_week_time_afternoon')): the_row();
                                                                        $dayItems = get_sub_field('schedule_day_week_afternoon');
                                                                        foreach ($dayItems as $dayItem) {
                                                                            $names = $dayItem["week_doctor_afternoon"];
                                                                            $days = $dayItem["week_day_afternoon"];
                                                                            ?>
                                                                            <td class="show_doctors"><?php
                                                                                echo '<span class="visible-xs">'.$days.'</span>';
                                                                                if(!empty($names)) {
                                                                                    foreach ($names as $name) {
                                                                                        $listCats = get_the_category($name->ID);
                                                                                        foreach ($listCats as $listCat) {
                                                                                            if($listCat->name == $category->name) {
                                                                                                echo '<a href="'.get_the_permalink($name->ID).'">'.$name->post_title.'</a>';
                                                                                            }
                                                                                        }
                                                                                    }
                                                                                }
                                                                                ?></td>
                                                                        <?php } endwhile; endif; ?>
                                                            </tr>
                                                            <tr class="thead-light">
                                                                <th colspan="7">Tối (18h00 - 19h30)</th>
                                                            </tr>
                                                            <tr class="row_data">
                                                                <?php
                                                                if (have_rows('schdule_week_time_night')):
                                                                    while (have_rows('schdule_week_time_night')): the_row();
                                                                        $dayItems = get_sub_field('schedule_day_week_night');
                                                                        foreach ($dayItems as $dayItem) {
                                                                            $names = $dayItem["week_doctor_night"];
                                                                            $days = $dayItem["week_day_night"];
                                                                            ?>
                                                                            <td class="show_doctors"><?php
                                                                                echo '<span class="visible-xs">'.$days.'</span>';
                                                                                if(!empty($names)) {
                                                                                    foreach ($names as $name) {
                                                                                        $listCats = get_the_category($name->ID);
                                                                                        foreach ($listCats as $listCat) {
                                                                                            if($listCat->name == $category->name) {
                                                                                                echo '<a href="'.get_the_permalink($name->ID).'">'.$name->post_title.'</a>';
                                                                                            }
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
                                            </div>
                                        </li>
                                    <?php }  ?>
                                </ul>
                            <?php endwhile; ?>
                            <?php
                        }
                        ?>
                        <div class="clearfix"></div>
                        <!-- <hr> -->
                    </div>
                </div>
                <!---->
                <div class="col-md-4 col-sm-12 col-xs-12" style="position: sticky;top: 0;">
                    <?php get_sidebar('bac-si-lich-lam-viec'); ?>
                </div>
            </div>
    </section>

</div>
<script src="<?php echo get_stylesheet_directory_uri(); ?>/assets/questions.js"></script>
<?php get_footer(); ?>
