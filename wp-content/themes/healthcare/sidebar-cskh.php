<div class="sidebar_post">
    <?php 
        $queried_object = get_queried_object();
        $taxName = 'customers_care';
    ?>
    <?php
        $sideBarTitle = codession_qtranslatex_string($queried_object->post_title)[qtrans_getLanguage()];
        if(empty($sideBarTitle)) {
            $sideBarTitle = $queried_object->post_title;
        }
    ?>
    <h4 class="column-title" style="text-transform: uppercase;">Nhóm bài viết</h4>
    <ul class="post-list" style="margin-bottom: 0">
        <?php 
            $terms = get_terms('tab_services');
        ?>
        <?php
            $parent_args = [
                'taxonomy'     => $taxName,
                'parent'        => 0,
                'hide_empty'    => true
            ];
            $parent_terms = get_terms( $parent_args );
            foreach($parent_terms as $key => $parent_term) {
                if($parent_term->slug == $queried_object->post_name) {
                    $termchildrens = get_terms( $taxName, array( 
                        'parent' => $parent_term->term_id, 
                        'orderby' => 'slug', 
                        'hide_empty' => false ) 
                    );
                    foreach($termchildrens as $termchildren) { ?>
                        <li class="clearfix"><i class="fa fa-angle-right pull-left" aria-hidden="true"></i>
                            <a class="pull-left" style="padding-bottom: 0;border: 0;margin-top: -4px;"
                            href="<?php echo get_category_link($termchildren->term_id); ?>">
                                <?php echo $termchildren->name; ?>
                            </a>
                        </li>
                    <?php }
                }
            }
        ?>
    </ul>
     <br/>
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
                <div style="background: url(<?php echo $feature_image_meta[0] ?>) center top no-repeat; width: 85px; height: 45px; background-size: cover; float: left"></div>
                <p><?php echo get_the_title($items->ID) ?></p>
                </a>
            </li>
    <?php endif;endwhile;endwhile; ?>
    </ul>
</div>
