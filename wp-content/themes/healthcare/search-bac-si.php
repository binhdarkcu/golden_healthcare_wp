<div class="content-bg">
  <?php get_search_form();?>
  <div class="doctors-grid col-md-12">
    <div class="find-doctors">
      <div class="conten col-md-8 col-sm-12 col-xs-12" style="margin-top:30px">
        <div class="row wow fadeInDown animated" style="visibility: visible; animation-name: fadeInDown;">
          <?php
                              $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                              $s = get_search_query();

                              $args_doctors = array(
                                'category_name'    => $_GET['khoa'],
                              	'orderby'          => 'date',
                              	'order'            => 'DESC',
                              	'post_type'        => 'post',
                                'posts_per_page'   => 8,
                                'paged' => $paged,
                                's' => get_search_query()
                              );
                              $relatedPosts = new WP_Query( $args_doctors );
                              if ( $relatedPosts->have_posts() ) :
                                    while ( $relatedPosts->have_posts() ) : $relatedPosts->the_post();
                                        $feature_image_id = get_post_thumbnail_id(get_the_ID());
                                        $feature_image_meta = wp_get_attachment_image_src($feature_image_id, 'full');
                          ?>
          <div class="col-md-6 col-sm-12 col-xs-12" style="margin-bottom: 5px">
            <div class="col-md-4 catItemImageBlock">
              <div class="news">
                <div class="article">
                  <a href="<?php echo get_the_permalink(get_the_ID()); ?>">
                    <div class="thumb"
                      style="background: url(<?php echo $feature_image_meta[0];?>) top center no-repeat; background-size: cover;">
                    </div>
                  </a>
                </div>
              </div>
            </div>
            <div class="col-md-8 post-list-right">
              <h4>
                <a href="<?php echo get_the_permalink(get_the_ID()); ?>"><?php echo get_the_title(get_the_ID());?></a>
              </h4>
              <p class="block-ellipsis-home-news-3line" style="height: 100%; -webkit-line-clamp: 5;">
                <?php echo wp_trim_words( get_the_content(get_the_ID()), 10, '...' );?>
              </p>
              <a href="<?php echo get_the_permalink(get_the_ID()); ?>" style="">Xem profile</a>
            </div>
          </div>
          <?php endwhile;  endif;?>
          <div class="clearfix"></div>
          <div class="paging pagenavi">
            <div class="paging-normal">
              <?php if(function_exists('wp_pagenavi'))
                            		{
                            			wp_pagenavi( array( 'query' => $relatedPosts ) );
                            		}
                                ?>
            </div>
          </div>
          <div class="clearfix"></div>
        </div>
      </div>
      <div class="col-md-4 col-sm-12 col-xs-12" style="position: sticky;top: 0;">
        <?php get_sidebar('bac-si-lich-lam-viec');?>
      </div>
    </div>
  </div>
</div>
<style>
    .searchbuttonm {
        background: none;
        border: 0;
    }
    .searchinputm {
        border-radius: 12px;
        background: #d8e8d8;
        border: none;
        padding-left: 10px;
        outline: none;
        height: 30px;
        width: 100%;
        margin-bottom: 30px;
    }
    h1{
        text-align:center;
        color:#2698d6;
        margin-bottom:50px;
        border-bottom: 1px solid black;
        padding-bottom:15px;
    }
    table tr th{
        text-align: center;
        background-color: #0060af;
        color: white;
    }
</style>