angular.module('MyApp').controller("PostController", [
    "$scope", "$rootScope", "$location", "$route", "Params", "$timeout", "$q", "postServices", "CategoryService", "PagerService", "indexServices", "MetaService", "urlService", "PostService",
    function ($scope, $rootScope, $location, $route, Params, $timeout, $q, postServices, CategoryService, PagerService, indexServices, MetaService, urlService, PostService) {


        $scope.searchText = "";
        //Contact
        $rootScope.metaservice = MetaService;
        var promiseContact = indexServices.getContact();
        $q.all([promiseContact]).then(function (resp) {

            $scope.contact = resp[0].data
            $rootScope.metaservice.setMetaPage($scope.contact.SEOTitle, $scope.contact.SEODescription, $scope.contact.SEOKeyword);
            $rootScope.metaservice.setMetaFace(window.location.href, "website", $scope.contact.Name, $scope.contact.Name, window.location.href + 'favicon.ico');
        });

        //Advertise
        $scope.getAdvertise = function () {
            PostService.getAdvertise(function (data) {
                $scope.Advertises = data;
            });
        }

        //Function: SEO Title
        $scope.seoTitle = function (str) {
            return urlService.seoTitle(str);
        }

        $scope.pager = {};
        $scope.categoryId = $route.current.params.id;
    	$scope.setPage = function (page) {
    	    $scope.activeValue = page;
    	    var para = { languageCode: Params.languageCode, pageIndex: page, numberInPage: Params.numberPerPage, priority: Params.newpriority, categoryId: $scope.categoryId };
    	    var paraSearch = {
    	        languageCode: 'vi', pageIndex: page, numberInPage: Params.numberPerPage, priority: Params.newpriority
               , categoryId: $scope.categoryId, Search: $scope.searchText, FirstChar: 0
    	    };

    	    postServices.queryPostPaging(para, function (data) {
    	        if (data != null) {
    	            $scope.Posts = data.PostListViewModels;
    	            $scope.totalItems = data.TotalItem;

    	            if (page < 1 || (page > $scope.pager.totalPages && $scope.pager.totalPages != null)) {
    	                return;
    	            }
    
    	            //
    	            //$rootScope.metaservice.setMetaPage($scope.post.TitleTrans, $scope.post.TitleSEO, $scope.post.DescriptionSEO);

    	            // get pager object from service
    	            $scope.pager = PagerService.GetPager($scope.totalItems, page, Params.numberPerPage);
    	        }

    	    });
    	    postServices.queryPostPaging(paraSearch, function (data) {
    	        if (data != null) {
    	            $scope.posts = data.PostListViewModels;
    	            $scope.len = $scope.posts.length;
    	            if ($scope.posts.length > 0) {
    	                $scope.categorName = $scope.posts[0].CategoryName;
    	                $scope.categorId = $scope.posts[0].CategoryId;
    	            }
    	            $scope.totalItems = data.TotalItem;

    	            if (page < 1 || (page > $scope.pager.totalPages && $scope.pager.totalPages != null)) {
    	                return;
    	            }

    	            // get pager object from service
    	            $scope.pager = PagerService.GetPager($scope.totalItems, page, Params.numberPerPage);
    	        }

    	    });

    	    $scope.getAdvertise();
    	}

    	$scope.setPage(1);

       
        //get category
    	CategoryService.queryNewsCategory({ parentId: $scope.categoryId }, function (data) {
    	    $scope.Categories = data;
    	});

        //convert url
    	$scope.convertUrl = function (url) {
    	    return url.replace(/\\/g, '/').replace(/ /g, '%20');
    	}
    }
]);