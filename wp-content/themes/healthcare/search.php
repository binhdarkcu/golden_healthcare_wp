<?php 
    get_header();
    $currentPage = $_GET['page'];
?>
<?php include_once('breadcrumb.php') ?>
<div ng-init="loadData()">
    <div class="content container">
        <div class="row">
            <?php
                if($currentPage == 'tim-bac-si') {
                    get_template_part('search-bac-si');
                } else {
                    get_template_part('search-question');
                }
            ?>
        </div>
    </div>
</div>
<?php get_footer();?>
