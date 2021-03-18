'use strict';

angular.module('MyApp')
    .controller("SearchController", [
    "$scope", "$location", "$route", "Params", "SearchService", "postServices",
    function ($scope, $location, $route, Params, SearchService, postServices) {

        $scope.subTitle = "Kết quả tìm kiếm";
        $scope.pager = {};
        $scope.searchText = $route.current.params.searchText;

        $scope.setPage = function (page) {
            $scope.activeValue = page;
            var para = { languageCode: 'vi', pageIndex: page, numberInPage: Params.numberPerPage, priority: 0, categoryId: 0, search: $scope.searchText };
            
            SearchService.queryPostPaging(para, function (data) {
                if (data != null) {
                    $scope.posts = data.PostListViewModels;
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
    }]);