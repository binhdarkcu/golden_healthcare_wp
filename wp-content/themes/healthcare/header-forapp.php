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

    <link href="<?php echo get_stylesheet_directory_uri(); ?>/assets/default.css" rel="stylesheet">
    <link href="<?php echo get_stylesheet_directory_uri(); ?>/assets/main.css" rel="stylesheet">
    <link href="<?php echo get_stylesheet_directory_uri(); ?>/assets/responsive.css" rel="stylesheet">
    <link href="<?php echo get_stylesheet_directory_uri(); ?>/assets/Site.css" rel="stylesheet">
    <link href="<?php echo get_stylesheet_directory_uri(); ?>/style.css" rel="stylesheet">
    <style>
    .article, .thumb {
        width: 100%;
    }
    </style>
</head>

<body <?php echo body_class('homepage') ?> id="home">
    <!-------------------------------------------->
    <!-----------------CONTENT-------------------->
    <!-------------------------------------------->
    <div class="view-container">
