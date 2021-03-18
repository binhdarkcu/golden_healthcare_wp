<?php
$queried_object = get_queried_object();
?>
<div class="posts custom-responsive-table" style="padding-top: 20px; padding-bottom: 20px;">
<?php
        $args = array(
            'post_type' => 'lich_kham_benh',
            'post_status' => 'publish',
            'posts_per_page' => 1
        );
        $query = new WP_Query($args);
        if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post(); ?>
            <table class="table-bordered table-hover tb-shedule" style="width: 100%;margin-top: 0;">
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
                                        echo '<a href="' . get_the_permalink($name->ID) . '">' . $name->post_title . '</a><br/>';
                                    }
                                } ?>
                                    </td>
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
                                        echo '<a href="' . get_the_permalink($name->ID) . '">' . $name->post_title . '</a><br/>';
                                    }
                                } ?>
                                    </td>
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
                                        echo '<a href="' . get_the_permalink($name->ID) . '">' . $name->post_title . '</a><br/>';
                                    }
                                } ?>
                                    </td>
                            <?php } endwhile; endif; ?>
                </tr>
            </table>
        <?php endwhile;endif; wp_reset_postdata(); ?>
</div>
