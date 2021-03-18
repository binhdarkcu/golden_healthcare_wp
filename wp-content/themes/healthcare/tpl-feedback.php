<section class="sc-feedback" style="margin-bottom: 50px;">
    <div class="container">
        <div class="row">
            <?php 
                $layouts = get_field('schedule', 'option');
                $i = 2;
                foreach($layouts as $key => $layout) :
            ?>
                <div style="margin-bottom: 10px" 
                    class="col-md-<?php echo count($layouts) == 2 ? $i * 3 : count($layouts) == 3 ? 4 : 3 ?> col-sm-6 col-xs-12 wow fadeIn<?php echo $key == 0 ? 'Left' : $key + 1 == count($layouts) ? 'Right' : 'Down'; ?> animated">
                    <div class="item-feedback">
                        <a href="<?php the_permalink($layout['link']->ID)?>"><?php echo $layout['title'] ?></a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>