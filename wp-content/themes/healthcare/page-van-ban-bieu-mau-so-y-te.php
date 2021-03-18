<?php 
    get_header();
    $count = 1;    
?>
<?php include_once('breadcrumb.php') ?>
<div ng-init="loadData()">
    <div class="container container-bd" style="padding-top:30px;">
        <div class="row">
            <div class="post-7839 page type-page status-publish hentry clearfix" style="margin-bottom: 30px">

                <div class="col-md-12">
                    <h3 class="column-title" style="text-transform:uppercase">
                        <?php echo the_title() ?>
                    </h3>
                </div>
                <?php while($count <= 3) { 
                        $column = get_field('column_0'. $count);
                    ?>
                    <!---->
                    <div class="vc_row wpb_row vc_inner vc_row-fluid vc_custom_1496193399697">
                        <!-- Column lịch công tác-->
                        <div class="col-md-4">
                            <div class="wpb_wrapper">
                                <div class="wpb_text_column wpb_content_element">
                                    <div class="wpb_wrapper">
                                        <h2><a class="rss_title" href="<?php echo $column['link'] ?>" target="_blank"><?php echo $column['title'] ?></a></h2>
                                        <div class="feedzy-rss" ng-init="limit = limitPresent = 2; textMore=&#39;Hiển thị thêm&#39;; textLess=&#39;Hiển thị ít hơn&#39;;">
                                            <?php foreach($column['desc'] as $desc) : ?>
                                                <!---->
                                                <ul ng-repeat="it in item.contents | limitTo:limitPresent ">
                                                    <li class="rss_item">
                                                        <span class="title">
                                                            <p><?php echo $desc['description'] ?></p>
                                                        </span>
                                                        <div class="rss_content" style="color:brown">
                                                            <small><?php echo $desc['createAt'] ?></small>
                                                        </div>
                                                    </li>
                                                </ul>
                                            <?php endforeach; ?>
                                            <div class="col-md-12 text-center">
                                                <a class="btn btn-sm" href="<?php echo $column['link'] ?>" target="_blank" ng-click="limitPresent = item.contents.length" style="color:white" aria-hidden="false">Xem thêm</a>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Column văn bản-->

                    </div>
                <?php $count++; } ?>
            </div>
        </div>
    </div>
</div>
<style>
.feedzy-rss a {
color: #666;
}
</style>
<?php get_footer();?>
