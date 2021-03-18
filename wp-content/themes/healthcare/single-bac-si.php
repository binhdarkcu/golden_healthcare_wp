<?php /* Template Name: Giới thiệu Template */ ?>
<?php get_header() ?>
<?php include_once('breadcrumb.php') ?>
<?php
$idPost = get_the_ID();
while (have_posts()) : the_post();
    $meta_values = get_post_type($idPost);
    $post = get_post(get_the_ID());
    $bigImg = wp_get_attachment_url(get_post_thumbnail_id(get_the_ID()));
    ?>
    <div ng-init="loadData()">
        <div ng-show="isShow" ng-init="queryView()" aria-hidden="false" class="" style="">
            <div class="container container-bd" style="padding-top: 50px; padding-bottom: 50px;">
                <!---->
                <div class="row">
                    <div class="col-md-8 col-sm-12 col-xs-12 wow fadeInRight postDetail conten">
                        <!---->
                        <div ng-if="!isRequiredLogin(post.PostInternal)">
                            <div class="row" style="margin-bottom: 30px;">
                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <img style="width: 100%" src="<?php echo $bigImg ?>" class="img-responsive" alt="">
                                </div>
                                <div class="col-md-8 col-sm-8 col-xs-12">
                                    <?php
                                    $cats = get_the_terms($post->ID, 'category');
                                    $chuyenkhoa = [];
                                    foreach ($cats as $cat) {
                                        $chuyenkhoa[] = $cat->name;
                                    };
                                    $values = get_field('ngoai_ngu');
                                    $field = get_field_object('ngoai_ngu');
                                    $choices = $field['choices'];
                                    $ngonngu = [];
                                    foreach ($choices as $value => $label) {
                                        $ngonngu = $label;
                                    }
                                    ?>
                                    <ul class="list-unstyled">
                                        <li><h5 class="title-small"><?php echo the_title(); ?></h5></li>
                                        <li><strong>Chức vụ:</strong> <?php echo get_field('chuc_vu') ?></li>
                                        <li><strong>Chuyên Khoa:</strong> <?php echo implode(', ', $chuyenkhoa) ?></li>
                                        <li><strong>Ngoại ngữ:</strong> Tiếng
                                            Việt <?php echo get_field('ngoai_ngu') ? ', ' . $ngonngu : '' ?></li>
                                        <li><strong>Làm việc:</strong> <?php echo get_field('lam_viec') ?></li>
                                        <li><strong>Thời gian:</strong> <?php echo get_field('thoi_gian') ?></li>
                                        <li><a href="<?php echo get_page_link(217); ?>?id_doctor=<?php echo get_the_ID() ?>" class="btn btn-dathen">Đặt hẹn</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <h5 class="title-small">Bằng cấp chuyên môn</h5>
                                    <p style="margin-bottom: 30px;"><?php echo get_field('bang_cap_chuyen_mon') ?></p>
                                    <h5 class="title-small">Kinh nghiệm y khoa:</h5>
                                    <p style="margin-bottom: 30px;"><?php echo get_field('kinh_nghiem') ?></p>
                                    <h5 class="title-small">Lịch khám</h5>
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
                                                    <th></th>
                                                    <th>Thứ 2</th>
                                                    <th>Thứ 3</th>
                                                    <th>Thứ 4</th>
                                                    <th>Thứ 5</th>
                                                    <th>Thứ 6</th>
                                                    <th>Thứ 7</th>
                                                    <th>Chủ nhật</th>
                                                </tr>
                                                <tr>
                                                    <td>Sáng (7h30 - 11h30)</td>
                                                    <?php
                                                    if (have_rows('schdule_week_time_morning')):
                                                        while (have_rows('schdule_week_time_morning')): the_row();
                                                            $dayItems = get_sub_field('schedule_day_week_morning');
                                                            foreach ($dayItems as $dayItem) {
                                                                $names = $dayItem["week_doctor_morning"];
                                                                ?>
                                                                <td><?php
                                                                    foreach ($names as $name) {
                                                                        if ($name->ID == $idPost) {
                                                                            echo '<i class="fa fa-check" aria-hidden="true"></i>';
                                                                        }
                                                                    }
                                                                    ?></td>
                                                            <?php } endwhile; endif; ?>
                                                </tr>
                                                <tr>
                                                    <td>Chiều (13h00 - 17h00)</td>
                                                    <?php
                                                    if (have_rows('schdule_week_time_afternoon')):
                                                        while (have_rows('schdule_week_time_afternoon')): the_row();
                                                            $dayItems = get_sub_field('schedule_day_week_afternoon');
                                                            foreach ($dayItems as $dayItem) {
                                                                $names = $dayItem["week_doctor_afternoon"];
                                                                ?>
                                                                <td><?php
                                                                    foreach ($names as $name) {
                                                                        if ($name->ID == $idPost) {
                                                                            echo '<i class="fa fa-check" aria-hidden="true"></i>';
                                                                        }
                                                                    }
                                                                    ?></td>
                                                            <?php } endwhile; endif; ?>
                                                </tr>
                                                <tr>
                                                    <td>Tối (18h00 - 19h30)</td>
                                                    <?php
                                                    if (have_rows('schdule_week_time_night')):
                                                        while (have_rows('schdule_week_time_night')): the_row();
                                                            $dayItems = get_sub_field('schedule_day_week_night');
                                                            foreach ($dayItems as $dayItem) {
                                                                $names = $dayItem["week_doctor_night"];
                                                                ?>
                                                                <td><?php
                                                                    foreach ($names as $name) {
                                                                        if ($name->ID == $idPost) {
                                                                            echo '<i class="fa fa-check" aria-hidden="true"></i>';
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
                            </div>
                            <div class="related row" style="margin-top: 40px;">
                                <div class="col-md-12">
                                    <h3 class="column-title">Các bác sĩ cùng chuyên khoa</h3>
                                </div>
                                <div class="related_doctors">
                                    <?php
                                    $related = get_posts(array('category__in' => wp_get_post_categories($post->ID), 'numberposts' => 2, 'post__not_in' => array($post->ID)));
                                    if ($related) foreach ($related as $post) {
                                        $bigImg = wp_get_attachment_url(get_post_thumbnail_id($post->ID));
                                        $cats = get_the_terms($post->ID, 'category');
                                        $relchuyenkhoa = [];
                                        foreach ($cats as $cat) {
                                            $relchuyenkhoa[] = $cat->name;
                                        };
                                        setup_postdata($post);
                                        ?>
                                        <div class="col-md-6 col-xs-12" style="margin-bottom: 15px;">
                                            <a href="<?php echo the_permalink() ?>"><img src="<?php echo $bigImg ?>" alt=""></a>
                                            <div class="fRight">
                                                <p><h5><?php the_title(); ?></h5></p>
                                                <span class="trim_text"><?php echo the_content() ?></span>
                                                <a href="<?php echo the_permalink() ?>">View Profile</a>
                                            </div>
                                        </div>
                                    <?php }
                                    wp_reset_postdata(); ?>
                                </div>

                            </div>
                            <br/><br/>
                        </div><!---->
                        <!---->
                    </div>
                    <?php $queried_object = get_queried_object();
                    if ($queried_object->post_type == 'post') {
                        get_sidebar('chuyen-khoa');
                    } else { ?>

                        <div class="col-md-4 col-sm-12 col-xs-12" style="position: sticky;top: 0;">
                            <?php get_sidebar(); ?>
                        </div>
                        <?php
                    }
                    ?>
                    <br/><br/>
                </div>
            </div>
        </div>

    </div>
<?php endwhile; ?>
<?php get_footer(); ?>
