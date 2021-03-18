<?php get_header()?>
<?php
    $queried_object = get_queried_object();
?>
<?php include_once('breadcrumb.php') ?>
<div ng-init="loadData()">
    <section>
        <div class="container container-bd" id="container" style="padding-top: 50px">
            <div class="row">
                <div class="conten col-md-8 col-sm-12 col-xs-12" style="margin-top:0">
                    <h3>Các bác sĩ theo khoa</h3>
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
                                                <tr>
                                                    <?php
                                                    if (have_rows('schdule_week_time_afternoon')):
                                                        while (have_rows('schdule_week_time_afternoon')): the_row();
                                                            $dayItems = get_sub_field('schedule_day_week_afternoon');
                                                            foreach ($dayItems as $dayItem) {
                                                                $names = $dayItem["week_doctor_afternoon"];
                                                                ?>
                                                                <td class="show_doctors"><?php
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
                                                <tr>
                                                    <?php
                                                    if (have_rows('schdule_week_time_night')):
                                                        while (have_rows('schdule_week_time_night')): the_row();
                                                            $dayItems = get_sub_field('schedule_day_week_night');
                                                            foreach ($dayItems as $dayItem) {
                                                                $names = $dayItem["week_doctor_night"];
                                                                ?>
                                                                <td class="show_doctors"><?php
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
                </div>
                <!---->
                <?php get_sidebar('chuyen-khoa');?>
            </div>
    </section>

</div>
<?php get_footer();?>
<script src="<?php echo get_stylesheet_directory_uri(); ?>/assets/questions.js"></script>
