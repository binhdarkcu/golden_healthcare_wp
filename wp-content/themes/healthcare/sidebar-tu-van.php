<div class="col-sm-12 col-xs-12">
    <?php $queried_object = get_queried_object(); ?>

    <h4 class="column-title" style="text-transform: uppercase;">Danh mục câu hỏi</h4>
    <ul class="post-list">
        <?php
        $categories = get_categories(array(
            'taxonomy' => 'dwqa-question_category',
            'hide_empty'    => false
        ));
        foreach ($categories as $category) { ?>
            <li><i class="fa fa-angle-right" aria-hidden="true"></i><a href="<?php echo get_category_link($category->term_id); ?>">
                    <?php echo $category->name; ?>
                </a>
                <?php
                    if($category->term_id == 30) {
                        $parent_args = [
                            'taxonomy'     => 'dwqa-question_tag'
                        ];
                        $parent_terms = get_terms( $parent_args ); ?>
                        <ul class="list-unstyled" style="padding-left:  20px;">
                            <?php foreach($parent_terms as $parent_term) : ?>
                                <li><i class="fa fa-angle-right" aria-hidden="true"></i><a href="<?php echo get_category_link($parent_term->term_id); ?>">
                                    <?php echo $parent_term->name; ?>
                                </a>
                            <?php endforeach ?>
                        </ul>
                    <?php }
                ?>
            </li>
        <?php } ?>
    </ul>


    <br/>

    <h4 class="column-title" style="text-transform: uppercase;">Bài viết nhiều người đọc nhất</h4>
    <ul class="post-list">
    <?php
    $args = array(
        'posts_per_page'       => 10,
        'order'             => 'DESC',
        'orderby'           => 'meta_value_num',
        'meta_key'           => '_dwqa_views',
        'post_type'         => 'dwqa-question'
    );
    $myposts = new WP_Query( $args );
    if ($myposts->have_posts()) {
        while ($myposts->have_posts()) {
            $myposts->the_post(); ?>
            <?php if(views_count() > 5 ) : ?>
            <li><i class="fa fa-angle-right" aria-hidden="true"></i><a href="<?php the_permalink(); ?>">
                    <?php echo the_title(); ?>
                </a>
            </li><?php endif;
        }
    } ?>
    </ul>
</div>
