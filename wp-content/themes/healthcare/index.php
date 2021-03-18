<?php get_header() ?>
<div>
    <?php get_template_part('tpl', 'slider') ?>

    <?php get_template_part('tpl', 'main-work')?>


    <section>
        <div class="container">
            <div class="section-header">
                <h2 class="section-title text-center wow fadeInDown animated" style="visibility: visible; animation-name: fadeInDown;">Cảm nhận khách hàng</h2>
                <small class="short-desc">Cảm nhận khách hàng về phòng khám</small>
            </div>
            <div class="row chuyenkhoa" style="display: flex;flex-flow: row wrap;justify-content: center;">
                <!-- các icon chuyên khoa, bấn vào icon link đến bài viết được thiết lập. -->
                <?php
                    $categories = get_categories(array(
                        'hide_empty' => false
                    ));
                    foreach( $categories as $category ) {
                        $imgUrl = get_field('departments_image', $category);
                        if(!empty($imgUrl)) {
                        ?>
                        <div class="col-md-2 col-sm-3 col-xs-12 item wow fadeInDown animated">
                            <a href="<?php echo get_category_link( $category->term_id );?>">
                                <img class="img-responsive center-block" style="width: 65%;" src="<?php echo $imgUrl; ?>"/>
                                <p><?php echo $category->name;?></p>
                            </a>
                        </div>
                    <?php } } ?>
                </div>
            </div>
        </section>

        <?php get_template_part('tpl', 'cac-khoa')?>

        <?php get_template_part('tpl', 'blog')?>

        <?php get_template_part('tpl', 'services')?>

    <section id="services" class="galleries">
      <div class="container">
          <div class="section-header">
              <h2 class="section-title text-center wow fadeInDown animated" style="visibility: visible; animation-name: fadeInDown;"><?php echo get_field('image_section', 'option')['title'] ?></h2>
              <small class="short-desc"><?php echo get_field('image_section', 'option')['description'] ?></small>
          </div>
          <section id="gallery-slider" style="position:relative;">
              <div class="carousel-inner" role="listbox">
                  <?php
                      $args = array(
                          'post_type'	 => 'hinh_anh',
              	          'post_status'	 => 'publish',
                          'posts_per_page' => -1
                      );
                      $query = new WP_Query( $args );
                      if( $query -> have_posts()) : while ($query -> have_posts()) : $query->the_post();
                      $feature_image_id = get_post_thumbnail_id(get_the_ID());
                      $feature_image_meta = wp_get_attachment_image_src($feature_image_id, 'full');
                      $img_lightbox = get_field('big_image_lightbox', get_the_ID());
                  ?>
                  <a class="example-image-link" href="<?php echo $img_lightbox;?>" data-lightbox="example-set" data-title="<?php echo get_the_title(get_the_ID());?>">
                      <div style="background: url(<?php echo $feature_image_meta[0] ?>) center no-repeat; height: 195px; background-size: cover"></div>
                  </a>

                  <?php endwhile;endif; wp_reset_postdata();?>

              </div>
          </section><!--/#main-slider-->

        <div class="slider_horizontal">

        </div>
      </div>
    </section>

</div>
<?php get_footer();?>
