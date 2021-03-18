<!DOCTYPE html>
<html lang="en" ng-app="MyApp" class="csstransforms csstransforms3d csstransitions">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <style type="text/css">
        [uib-typeahead-popup].dropdown-menu {
            display: block;
        }
    </style>
    <style type="text/css">
        .uib-time input {
            width: 50px;
        }
    </style>
    <style type="text/css">
        [uib-tooltip-popup].tooltip.top-left>.tooltip-arrow,
        [uib-tooltip-popup].tooltip.top-right>.tooltip-arrow,
        [uib-tooltip-popup].tooltip.bottom-left>.tooltip-arrow,
        [uib-tooltip-popup].tooltip.bottom-right>.tooltip-arrow,
        [uib-tooltip-popup].tooltip.left-top>.tooltip-arrow,
        [uib-tooltip-popup].tooltip.left-bottom>.tooltip-arrow,
        [uib-tooltip-popup].tooltip.right-top>.tooltip-arrow,
        [uib-tooltip-popup].tooltip.right-bottom>.tooltip-arrow,
        [uib-tooltip-html-popup].tooltip.top-left>.tooltip-arrow,
        [uib-tooltip-html-popup].tooltip.top-right>.tooltip-arrow,
        [uib-tooltip-html-popup].tooltip.bottom-left>.tooltip-arrow,
        [uib-tooltip-html-popup].tooltip.bottom-right>.tooltip-arrow,
        [uib-tooltip-html-popup].tooltip.left-top>.tooltip-arrow,
        [uib-tooltip-html-popup].tooltip.left-bottom>.tooltip-arrow,
        [uib-tooltip-html-popup].tooltip.right-top>.tooltip-arrow,
        [uib-tooltip-html-popup].tooltip.right-bottom>.tooltip-arrow,
        [uib-tooltip-template-popup].tooltip.top-left>.tooltip-arrow,
        [uib-tooltip-template-popup].tooltip.top-right>.tooltip-arrow,
        [uib-tooltip-template-popup].tooltip.bottom-left>.tooltip-arrow,
        [uib-tooltip-template-popup].tooltip.bottom-right>.tooltip-arrow,
        [uib-tooltip-template-popup].tooltip.left-top>.tooltip-arrow,
        [uib-tooltip-template-popup].tooltip.left-bottom>.tooltip-arrow,
        [uib-tooltip-template-popup].tooltip.right-top>.tooltip-arrow,
        [uib-tooltip-template-popup].tooltip.right-bottom>.tooltip-arrow,
        [uib-popover-popup].popover.top-left>.arrow,
        [uib-popover-popup].popover.top-right>.arrow,
        [uib-popover-popup].popover.bottom-left>.arrow,
        [uib-popover-popup].popover.bottom-right>.arrow,
        [uib-popover-popup].popover.left-top>.arrow,
        [uib-popover-popup].popover.left-bottom>.arrow,
        [uib-popover-popup].popover.right-top>.arrow,
        [uib-popover-popup].popover.right-bottom>.arrow,
        [uib-popover-html-popup].popover.top-left>.arrow,
        [uib-popover-html-popup].popover.top-right>.arrow,
        [uib-popover-html-popup].popover.bottom-left>.arrow,
        [uib-popover-html-popup].popover.bottom-right>.arrow,
        [uib-popover-html-popup].popover.left-top>.arrow,
        [uib-popover-html-popup].popover.left-bottom>.arrow,
        [uib-popover-html-popup].popover.right-top>.arrow,
        [uib-popover-html-popup].popover.right-bottom>.arrow,
        [uib-popover-template-popup].popover.top-left>.arrow,
        [uib-popover-template-popup].popover.top-right>.arrow,
        [uib-popover-template-popup].popover.bottom-left>.arrow,
        [uib-popover-template-popup].popover.bottom-right>.arrow,
        [uib-popover-template-popup].popover.left-top>.arrow,
        [uib-popover-template-popup].popover.left-bottom>.arrow,
        [uib-popover-template-popup].popover.right-top>.arrow,
        [uib-popover-template-popup].popover.right-bottom>.arrow {
            top: auto;
            bottom: auto;
            left: auto;
            right: auto;
            margin: 0;
        }

        [uib-popover-popup].popover,
        [uib-popover-html-popup].popover,
        [uib-popover-template-popup].popover {
            display: block !important;
        }
    </style>
    <style type="text/css">
        .uib-datepicker-popup.dropdown-menu {
            display: block;
            float: none;
            margin: 0;
        }

        .uib-button-bar {
            padding: 10px 9px 2px;
        }
    </style>
    <style type="text/css">
        .uib-position-measure {
            display: block !important;
            visibility: hidden !important;
            position: absolute !important;
            top: -9999px !important;
            left: -9999px !important;
        }

        .uib-position-scrollbar-measure {
            position: absolute !important;
            top: -9999px !important;
            width: 50px !important;
            height: 50px !important;
            overflow: scroll !important;
        }

        .uib-position-body-scrollbar-measure {
            overflow: scroll !important;
        }
    </style>
    <style type="text/css">
        .uib-datepicker .uib-title {
            width: 100%;
        }

        .uib-day button,
        .uib-month button,
        .uib-year button {
            min-width: 100%;
        }

        .uib-left,
        .uib-right {
            width: 100%
        }
    </style>
    <style type="text/css">
        .ng-animate.item:not(.left):not(.right) {
            -webkit-transition: 0s ease-in-out left;
            transition: 0s ease-in-out left
        }
    </style>
    <style type="text/css">
        @charset "UTF-8";

        [ng\:cloak],
        [ng-cloak],
        [data-ng-cloak],
        [x-ng-cloak],
        .ng-cloak,
        .x-ng-cloak,
        .ng-hide:not(.ng-hide-animate) {
            display: none !important;
        }

        ng\:form {
            display: block;
        }

        .ng-animate-shim {
            visibility: hidden;
        }

        .ng-anchor {
            position: absolute;
        }
    </style>

    <!--<base href="/">-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <?php 
        global $posts;
        $title = '';
        if(has_term('', 'category')) {
            $terms = get_the_terms( $posts[0]->ID, 'category' );
            $title = $terms[0]->name;
        } else {
            $title = $posts[0]->post_title;
        }
    ?>
    <title><?php echo $title ?> - <?php echo get_field('name_of_clinic', 'option'); ?></title>
    <?php
        $logoUrl = get_field('header_logo', 'option');
    ?>

    <link rel="apple-touch-icon" sizes="57x57"
        href="<?php echo get_stylesheet_directory_uri(); ?>/assets/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60"
        href="<?php echo get_stylesheet_directory_uri(); ?>/assets/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72"
        href="<?php echo get_stylesheet_directory_uri(); ?>/assets/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76"
        href="<?php echo get_stylesheet_directory_uri(); ?>/assets/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114"
        href="<?php echo get_stylesheet_directory_uri(); ?>/assets/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120"
        href="<?php echo get_stylesheet_directory_uri(); ?>/assets/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144"
        href="<?php echo get_stylesheet_directory_uri(); ?>/assets/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152"
        href="<?php echo get_stylesheet_directory_uri(); ?>/assets/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180"
        href="<?php echo get_stylesheet_directory_uri(); ?>/assets/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"
        href="<?php echo get_stylesheet_directory_uri(); ?>/assets/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32"
        href="<?php echo get_stylesheet_directory_uri(); ?>/assets/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96"
        href="<?php echo get_stylesheet_directory_uri(); ?>/assets/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16"
        href="<?php echo get_stylesheet_directory_uri(); ?>/assets/favicon-16x16.png">
    <link href="https://fonts.googleapis.com/css?family=Nunito&amp;subset=latin-ext,vietnamese" rel="stylesheet">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage"
        content="<?php echo get_stylesheet_directory_uri(); ?>/assets/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <link href="<?php echo get_stylesheet_directory_uri(); ?>/assets/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo get_stylesheet_directory_uri(); ?>/assets/animate.css" rel="stylesheet">
    <link href="<?php echo get_stylesheet_directory_uri(); ?>/assets/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo get_stylesheet_directory_uri(); ?>/assets/bootstrap-datepicker.css" rel="stylesheet">
    <link href="<?php echo get_stylesheet_directory_uri(); ?>/assets/owl.carousel.css" rel="stylesheet">
    <link href="<?php echo get_stylesheet_directory_uri(); ?>/assets/owl.theme.css" rel="stylesheet">
    <link href="<?php echo get_stylesheet_directory_uri(); ?>/assets/owl.transitions.css" rel="stylesheet">
    <link href="<?php echo get_stylesheet_directory_uri(); ?>/assets/prettyPhoto.css" rel="stylesheet">
    <link href="<?php echo get_stylesheet_directory_uri(); ?>/assets/main.css" rel="stylesheet">
    <link href="<?php echo get_stylesheet_directory_uri(); ?>/assets/responsive.css" rel="stylesheet">
    <link href="<?php echo get_stylesheet_directory_uri(); ?>/assets/Site.css" rel="stylesheet">
    <link href="<?php echo get_stylesheet_directory_uri(); ?>/assets/default.css" rel="stylesheet">
    <link href="<?php echo get_stylesheet_directory_uri(); ?>/assets/loading-screen.css" rel="stylesheet">
    <link href="<?php echo get_stylesheet_directory_uri(); ?>/style.css" rel="stylesheet">
    <link href="<?php echo get_stylesheet_directory_uri(); ?>/assets/jquery.mCustomScrollbar.min.css" rel="stylesheet">
    <link href="<?php echo get_stylesheet_directory_uri(); ?>/assets/lightbox.css" rel="stylesheet">
    <link href="<?php echo get_stylesheet_directory_uri(); ?>/assets/droplinetabs.css" rel="stylesheet">
    <link href="<?php echo get_stylesheet_directory_uri(); ?>/assets/select2.min.css" rel="stylesheet">
    <link href="<?php echo get_stylesheet_directory_uri(); ?>/assets/video-js.css" rel="stylesheet">
    <?php
        if(is_page(94)) :?>
    <script type="text/javascript">
        var onloadCallback = function () {
            grecaptcha.render('example1', {
                'sitekey': '6LdaBI8UAAAAAC_IYbbefBkIQ33GRb8K5Xb4GbUL'
            });
        };
    </script>
    <?php endif; ?>
    <?php wp_head() ?>
</head>

<body <?php echo body_class('homepage') ?> id="home">
    <!-------------------------------------------->
    <!-----------------CONTENT-------------------->
    <!-------------------------------------------->
    <div class="view-container">
        <header id="header">
            <nav class="navbar navbar-default" role="banner">
                <div class="container">
                    <div class="row" style="display: flex;align-items: center;">
                        <div class="col-md-3 col-xs-6">
                            <div class="navbar-header">
                                <a class="navbar-brand" href="<?php echo get_site_url(); ?>">
                                    <img src="<?php echo $logoUrl; ?>"
                                        alt="<?php echo get_field('name_of_clinic', 'option'); ?>">
                                </a>
                            </div>
                        </div>
                        <div class="col-md-9 col-xs-6">
                            <div style="float: left;margin-top: 0;font-size: 18px; font-size: 18px; width: 40%;"
                                class="hidden_md">
                                <h3 style="margin-top: 17px; font-size: 18px; text-transform: uppercase">
                                    <?php echo get_field('name_of_clinic', 'option'); ?></h3>
                                <small style="display: table;line-height: 1;">Email:
                                    <?php echo get_field('footer_email', 'option'); ?></small>
                                <small>Hotline: <?php echo get_field('footer_phone', 'option'); ?></small>
                            </div>
                            <div class="text-right language" style="margin-bottom: 10px;">
                                <?php
                                    wp_nav_menu(
                                        array(
                                            'theme_location' => 'top_nav',
                                            'menu_class'     => 'nav_small list-inline'
                                        )
                                    );
                                ?>
                                <div class="hidden_md">
                                    <?php  //qtranxf_generateLanguageSelectCode(array( 'type'   => 'image'));?>
                                </div>
                            </div>
                            <button type="button" class="navbar-toggle collapsed show_md">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                            <div class="text-right hidden_md"
                                style="float: right; margin-right: 32px;margin-bottom: 10px">
                                <form id="yw0" ng-submit="setPage(1)" class="ng-pristine ng-valid ng-valid-maxlength">
                                    <div class="input-group" style="margin:auto;">
                                        <input
                                            class="form-control ng-pristine ng-untouched ng-valid ng-empty ng-valid-maxlength"
                                            type="text" maxlength="100" placeholder="Tìm kiếm bài viết"
                                            ng-model="searchText" style="width:300px; border-radius: 10px;"
                                            aria-invalid="false">
                                        <div class="input-group-btn">
                                            <div class="btn-group" role="group">
                                                <div>
                                                    <button name="submit" class="btn btn-primary pull-right"
                                                        style="width: 34px;height:34px; background-color: rgba(15, 9, 206, 0.13);border-color: #cccccc;border-radius: 10px; padding: 0px 10px 0px; margin-right: 0">
                                                        <i class="fa fa-search"
                                                            style="font-size: 15px;color:black;"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-nav">
                    <div class="container" id="navMain">
                        <div class="navbar-right">
                            <div class="nav-mobile">
                                <div class="title_nav">
                                    <h3 style="margin-top: 17px; font-size: 18px;">PHÒNG KHÁM ĐA KHOA QUỐC TẾ GOLDEN
                                        HEALTHCARE</h3>
                                    Email: <?php echo get_field('footer_email', 'option'); ?> <br />
                                    Hotline: <?php echo get_field('footer_phone', 'option'); ?>
                                </div>
                                <div class="text-right search_nav">
                                    <form id="yw0" ng-submit="setPage(1)" class="ng-pristine ng-valid ng-valid-maxlength">
                                        <div class="input-group">
                                            <input
                                                class="form-control ng-pristine ng-untouched ng-valid ng-empty ng-valid-maxlength"
                                                type="text" maxlength="100" placeholder="Tìm kiếm bài viết"
                                                ng-model="searchText" style="width:300px; border-radius: 10px;"
                                                aria-invalid="false">
                                            <div class="input-group-btn">
                                                <div class="btn-group" role="group">
                                                    <div>
                                                        <button name="submit" class="btn btn-primary pull-right"
                                                            style="width: 34px;height:34px; background-color: rgba(15, 9, 206, 0.13);border-color: #cccccc;border-radius: 10px; padding: 0px 10px 0px; margin-right: 0">
                                                            <i class="fa fa-search"
                                                                style="font-size: 15px;color:black;"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="nav-menu">
                                <div id="menu_main">
                                    <ul class="list-unstyled list-inline hidden_md">
                                        <li><a href="<?php echo get_site_url(); ?>">Trang chủ</a></li>
                                    </ul>
                                    <?php
                                        wp_nav_menu(
                                            array(
                                                'theme_location' => 'primary_menus',
                                                'menu_class'     => 'list-unstyled list-inline',
                                                'menu_id'        => 'nav'
                                            )
                                        );
                                    ?>
                                </div>
                            </div>
                            <div class="show_md" style="padding-bottom: 15px;">
                                <?php  qtranxf_generateLanguageSelectCode(array(
                                    'type'   => 'image'
                                ));
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
        </header>
        <!---->
        <ng-view class="" style="">
            <!------------------------------>
            <!------------TEMPLATE---------->
            <!------------------------------>
