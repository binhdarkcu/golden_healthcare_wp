<style>
    video::-internal-media-controls-download-button {
        display: none;
    }

    video::-webkit-media-controls-enclosure {
        overflow: hidden;
    }

    video::-webkit-media-controls-panel {
        width: calc(100% + 30px); /* Adjust as needed */
    }

    .catItemImageBlock {
        margin: 0;
        padding: 0;
        position: relative;
    }

    .catItemImageBlock .catItemDateCreated {
        bottom: 9px;
        margin-left: 15px;
        position: absolute;
    }

    .catItemImageBlock .catItemDateCreated span {
        color: #ffffff;
        display: inline-block;
        margin-right: -4px;
        text-transform: uppercase;
        height: 20px;
        padding-right: 5px;
    }

    .catItemImageBlock .catItemDateCreated .day {
        background: #0ba2eb none repeat scroll 0 0;
    }

    .catItemImageBlock .catItemDateCreated .month {
        background: #5c58bb none repeat scroll 0 0;
        border-radius: 0px 20px 20px 0px;
    }

    .readMore {
        display: block;
        /*font-weight: 600;*/
        padding: 5px 10px;
        /*text-transform: uppercase;*/
        border: 1px solid #0ba2eb;
        color: #0ba2eb;
        margin-left: 15px;
    }

    .readMore:hover {
        color: #fff;
        background: #0ba2eb none repeat scroll 0 0;
    }

    .catItemImageBlock .catItemDateCreated {
        bottom: -4px;
        left: -15px;
        position: absolute;
    }

    .article, .thumb {
        width: 100%;
    }

    .input-group-btn {
        position: absolute !important;
        padding-left: 300px;
    }
</style>
</ng-view>
<!--<ui-view></ui-view>-->
</div>
<!-------------------------------------------->
<!-----------------FOOTER--------------------->
<!-------------------------------------------->
<!---->
<footer id="footer" ng-if="!isLoading" class="" style="">
    <div class="container" style="padding-bottom: 20px; border-bottom: 1px solid #fff">
        <div class="row">
            <div class="col-md-12">
                <h5 class="footer_title"><?php echo get_field('name_of_clinic', 'option'); ?></h5>
                <div class="row">
                    <div class="col-md-3 column_info" style="margin-bottom: 20px">
                        <h5>head office</h5>
                        <span> <i class="fa fa-map-marker" aria-hidden="true"></i> <?php echo get_field('footer_address', 'option'); ?></span><br/>
                        <span><i class="fa fa-phone" aria-hidden="true"></i> <?php echo get_field('footer_phone', 'option'); ?></span><br/>
                        <span><i class="fa fa-envelope" aria-hidden="true"></i> <?php echo get_field('footer_email', 'option'); ?></span><br/>
                        <?php if (get_field('footer_socials', 'option')): ?>
                            <ul class="social_icons">
                                <?php while (has_sub_field('footer_socials', 'option')): ?>
                                    <li>
                                        <a href="<?php echo get_sub_field('social_link'); ?>"><i class="fa fa-<?php echo get_sub_field('social_name'); ?>" aria-hidden="true"></i></a>
                                    </li>
                                <?php endwhile; ?>
                            </ul>
                        <?php endif; ?>
                        <div class="counter_visitor">

                            <?php
                                echo do_shortcode('[page_visit_counter_md backgroundcolor="transparent"]');
                                // include("counter.php");
                                // $counter_name = "counter.txt";
                                // if (!file_exists($counter_name)) {
                                //     $f = fopen($counter_name, "w");
                                //     fwrite($f,"0");
                                //     fclose($f);
                                // }
                                // $f = fopen($counter_name,"r");
                                // print_r(filesize($counter_name));
                                // if(filesize($counter_name) > 0) {
                                //     $counterVal = fread($f, filesize($counter_name));
                                //     fclose($f);
                                //     if(!isset($_SESSION['hasVisited'])){
                                //         $_SESSION['hasVisited']="yes";
                                //         $counterVal++;
                                //         $f = fopen($counter_name, "w");
                                //         fwrite($f, $counterVal);
                                //         fclose($f);
                                //     }
                                // } else {
                                //     $counterVal = 1;
                                // }
                            ?>
                        </div>
                    </div>
                    <div class="col-md-3" style="margin-bottom: 20px">
                        <iframe style="width: 100%;"
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d823.9013118313533!2d106.64648384710628!3d10.799268884097291!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3175299465a6aa4d%3A0x736056bf971601aa!2zUEjDkk5HIEtIw4FNIMSQQSBLSE9BIFFV4buQQyBU4bq-IEdPTERFTiBIRUFMVEhDQVJF!5e0!3m2!1sen!2s!4v1552061025538"
                                width="100%" height="200" frameborder="0" style="border:0"
                                allowfullscreen></iframe>
						<div style="width: 240px; margin-top: 20px;">
							<a href="http://online.gov.vn/Home/WebDetails/78034"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/logoSaleNoti.png"/></a>
						</div>
                    </div>
                    <div class="col-md-6 column_info column-menu">
                        <div class="row">
                            <div class="col-md-4 col-sm-6 col-xs-12">
                                <h5>Dịch vụ</h5>
                                <?php
                                    wp_nav_menu(
                                        array(
                                            'theme_location' => 'services',
                                            'menu_class'     => 'list-unstyled'
                                        )
                                    );
                                ?>
                            </div>
                            <div class="col-md-4 col-sm-6 col-xs-12">
                                <h5>Chuyên khoa</h5>
                                <?php
                                    wp_nav_menu(
                                        array(
                                            'theme_location' => 'specialist',
                                            'menu_class'     => 'list-unstyled'
                                        )
                                    );
                                ?>
                            </div>
                            <div class="col-md-4 col-sm-12 col-xs-12">
                                <h5>LIÊN KẾT NHANH</h5>
                                <?php
                                    wp_nav_menu(
                                        array(
                                            'theme_location' => 'link',
                                            'menu_class'     => 'list-unstyled'
                                        )
                                    );
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="text-center" style="padding-top: 20px; padding-bottom: 20px;"><span style="font-style:italic">Copyright © 2017</span></div>
    <!-- live support -->
    <div class="live_support">
        <?php while (have_rows('live_support', 'option')): the_row(); ?>
            <a href="<?php echo get_sub_field('link_live') ?>">
                <i class="fa fa-<?php echo get_sub_field('icon') ?>" aria-hidden="true"></i>
                <span><?php echo get_sub_field('title_live') ?></span>
            </a>
        <?php endwhile; ?>
    </div>
    <?php wp_footer() ?>
</footer><!----><!--/#footer-->

<!---------------------------------->
<!------------LOADING--------------->
<!---------------------------------->
<!---->
<!-------------------------------------------->
<!-----------------SCRIPT--------------------->
<!-------------------------------------------->
<?php
        if(is_page(94)) :?>
<script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit"
        async defer>
</script>
    <?php endif; ?>

    
<!-- Start -->
<!-- <script type="text/javascript">
    document.write(
        '<style type="text/css">body{padding-bottom:20px}</style><img style="position:fixed;z-index:9;bottom:20px;left:20px;max-width: 320px !important;" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/decor_tet.png"/>'
        );
</script>  -->
<!-- End -->




<script src="<?php echo get_stylesheet_directory_uri(); ?>/assets/owl.carousel.js"></script>
<script src="<?php echo get_stylesheet_directory_uri(); ?>/assets/mousescroll.js"></script>
<script src="<?php echo get_stylesheet_directory_uri(); ?>/assets/smoothscroll.js"></script>
<script src="<?php echo get_stylesheet_directory_uri(); ?>/assets/jquery.prettyPhoto.js"></script>
<script src="<?php echo get_stylesheet_directory_uri(); ?>/assets/jquery.isotope.min.js"></script>
<script src="<?php echo get_stylesheet_directory_uri(); ?>/assets/jquery.inview.min.js"></script>
<script src="<?php echo get_stylesheet_directory_uri(); ?>/assets/wow.min.js"></script>
<script src="<?php echo get_stylesheet_directory_uri(); ?>/assets/underscore-min.js"></script>
<script src="<?php echo get_stylesheet_directory_uri(); ?>/assets/jquery.mCustomScrollbar.concat.min.js"></script>
<script src="<?php echo get_stylesheet_directory_uri(); ?>/assets/lightbox.js"></script>
<script src="<?php echo get_stylesheet_directory_uri(); ?>/assets/droplinemenu.js"></script>
<script src="<?php echo get_stylesheet_directory_uri(); ?>/assets/jquery.da-share.js"></script>
<script src="<?php echo get_stylesheet_directory_uri(); ?>/assets/select2.min.js"></script>
<script>
    $(document).ready(function () {
        $('#nav .menu-item-has-children').hover(
            function () {
                $(this).children('.sub-menu').slideDown(200);
            },
            function () {
                $(this).children('.sub-menu').slideUp(200);
            }
        );
    }); // end ready
</script>
<!-- <script type="text/javascript">

    //build menu with DIV ID="myslidemenu" on page:
    droplinemenu.buildmenu("droplinetabs1")

</script> -->
<script>
    $("#text-search").bind('keydown', function (e) {
        if (e.which == 13) {
            e.preventDefault();
            $("#btnSearch").click();
        }
    });
</script>

<div id="eJOY__extension_root" style="all: unset;"></div></body></html>
