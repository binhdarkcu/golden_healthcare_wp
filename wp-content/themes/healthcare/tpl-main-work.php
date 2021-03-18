<section>
    <div class="container">
        <div class="row">
            <div class="col-md-6" style="margin-bottom: 40px">
                <div class="section-header">
                    <h2 class="section-title text-center wow fadeInDown animated"
                        style="visibility: visible; animation-name: fadeInDown;"><?php echo get_field('featured_gadgets', 'option')['title'] ?></h2>
                    <small class="short-desc"><?php echo get_field('featured_gadgets', 'option')['description'] ?></small>
                </div>
                <div class="row">
                    <div class="features customCol" ng-repeat="feature in features" style="">
                        <div class="childpages 2">
                            <?php
                                $columns = get_field('utilities', 'option');
                                foreach($columns as $column) :
                                    $feature_image_id = get_post_thumbnail_id($column['utilities_small']->ID);
                                    $feature_image_meta = wp_get_attachment_image_src($feature_image_id, 'full'); 
                            ?>
                                <div class="col-md-4 col-sm-6 wow fadeInUp service-box animated animated" data-wow-duration="300ms" data-wow-delay="0ms" style="visibility: visible; animation-duration: 300ms; animation-delay: 0ms; animation-name: undefined;">
                                    <div class="service-box-pad">
                                        <div class="media service-box">
                                            <div class="pull-left" style="width: 100%;text-align: center;">
                                                <a href="<?php echo get_the_permalink($column['utilities_small']->ID) ?>">
                                                <i class="fa" style="background: url(<?php echo $feature_image_meta[0] ?>); background-size: cover;"></i>
                                                    <h4 class="media-heading block-ellipsis-home-news-2line" style="line-height:1.5 !important;font-size: 15px;"><?php echo $column['utilities_small']->post_title ?></h4>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div><!--/.col-md-4-->
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div><!--/.row-->
            </div>
            <div class="col-md-6" style="margin-bottom: 50px">
                <div class="section-header">
                    <h2 class="section-title text-center wow fadeInDown animated"
                        style="visibility: visible; animation-name: fadeInDown;"><?php echo get_field('video_intro', 'option')['video_title'] ?></h2>
                    <small class="short-desc"><?php echo get_field('video_intro', 'option')['video_description'] ?></small>
                </div>
                <div class="row">
                    <div class="col-md-12" id="video_intro">
                        <?php while (have_rows('video_intro', 'option')): the_row(); ?>
                            <div class="carousel-inner" role="listbox">
                                <?php if(have_rows('video_link')) : 
                                    $i = 0;
                                    while (have_rows('video_link')): the_row();
                                    $items = get_sub_field('links');
                                    ?>
                                    <div srccur="<?php echo $items['url'] ?>" class="embed-responsive embed-responsive-16by9" style="width: 100%;" id="playerId-<?php echo $i ?>">
                                        <video
                                            id="vid-<?php echo $i ?>"
                                            class="video-js vjs-default-skin vjs-16-9 vjs-big-play-centered"
                                        >
                                        </video>
                                    </div>
                                    
                                <?php $i++; endwhile; endif; ?>
                            </div>
                        <?php endwhile; ?>
                    </div>
                </div>
            </div>
        </div>
    </div><!--/.container-->
</section><!--/#services-->
