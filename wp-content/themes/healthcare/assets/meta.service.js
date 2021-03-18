'use strict';

angular.module('MyApp').factory('MetaService', function () {
    //meta page
    var title = 'Bệnh viện Phạm Ngọc Thạch';
    var metaDescription = '';
    var metaKeywords = '';

    //meta face
    var og_url = '';
    var og_type = '';
    var og_title = '';
    var og_description = '';
    var og_image = '';

    //meta post
    var canonical = '';
    var breadcrumbsTitle = '';
    var robots = '';

    return {
        setMetaPage: function (newTitle, newMetaDescription, newKeywords) {
            metaKeywords = newKeywords;
            metaDescription = newMetaDescription;
            title = newTitle;
        },
        setMetaFace: function (newog_url, newog_type, newog_title, newog_description, newog_image) {
            og_url = newog_url;
            og_type = newog_type;
            og_title = newog_title;
            og_description = newog_description;
            og_image = newog_image;
        },
        setMetaPost: function (newCanonical, newBreadcrumbsTitle, newMetaRobots) {
            canonical = newCanonical;
            breadcrumbsTitle = newBreadcrumbsTitle;
            robots = newMetaRobots;
        },
        
        //get meta page
        metaTitle: function () { return title; },
        metaDescription: function () { return metaDescription; },
        metaKeywords: function () { return metaKeywords; },

        //get meta face
        metaog_url: function () { return og_url; },
        metaog_type: function () { return og_type; },
        metaog_title: function () { return og_title; },
        metaog_description: function () { return og_description; },
        metaog_image: function () { return og_image; },

        //get meta post
        metaCanonical: function () { return canonical; },
        metaBreadcrumbsTitle: function () { return breadcrumbsTitle; },
        metaRobots: function () { return robots; }
    }
});