'use strict';

angular.module('MyApp')
    .controller("PostListController", ["$rootScope", "$scope", "$location", "$route", "Params", "PostListService", "CategoryService", 'LoadJsService', 'PagerService', 'LibraryService',
    function ($rootScope, $scope, $location, $route, Params, PostListService, CategoryService, LoadJsService, PagerService, LibraryService) {
        $scope.pager = {};
        $scope.Id = $route.current.params.id;
        //set banner id
        $rootScope.catId = $scope.Id
        $scope.categorId = "";
        $scope.categorName = "";
        $scope.IsStatic = $scope.Id == 143;
        $scope.charText = "0";
        $scope.searchText = "";
        $scope.checked = $scope.Id == 154;
        $scope.numberInPage = 6;
        CategoryService.get({ id: $scope.Id }, function (data) {
            if (data != null) {
                $scope.category = data;
            }
        });



        $scope.items = ['A', 'B', "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z"]


        $scope.setPage = function (page) {
            $scope.activeValue = page;
            var para = {
                languageCode: 'vi', pageIndex: page, numberInPage: Params.numberPerPage, priority: Params.allpriority
                , categoryId: $scope.Id, Search: this.searchText, FirstChar: this.charText
            };
            var paraHoatDongBv = { languageCode: 'vi', pageIndex: page, numberInPage: $scope.numberInPage, priority: Params.allpriority, categoryId: Params.thuVien, type: 1 };

            LibraryService.queryPostPaging(paraHoatDongBv, function (data) {
                if (data != null) {
                    $scope.postHoatDongBenhViens = data.PostListViewModels;
                    $scope.totalHDBVItems = data.TotalItem;

                    if (page < 1 || (page > $scope.pagerHDBV.totalPages && $scope.pagerHDBV.totalPages != null)) {
                        return;
                    }

                    // get pager object from service
                    $scope.pagerHDBV = PagerService.GetPager($scope.totalHDBVItems, page, $scope.numberInPage);
                }

            });

            PostListService.queryPostPaging(para, function (data) {
                if (data != null) {
                    $scope.posts = data.PostListViewModels;
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

        }

        $scope.setPage(1);

        $scope.loadPage = function (char) {
            $scope.charText = char;
            this.setPage(1);
        }




    }]);
