angular.module('MyApp').factory('PagerService', ['Params',
    function PagerService(Params) {
    var service = {};

    service.GetPager = GetPager;

    return service;

    // service implementation
    function GetPager(totalItems, currentPage, pageSize) {
        // default to first page
        currentPage = currentPage || 1;

        // default page size is 10
        pageSize = pageSize || 10;

        // calculate total pages
        var totalPages = Math.ceil(totalItems / pageSize);

        var startPage, endPage;
        if (totalPages <= Params.totalPagedIsShow) {
            // less than number total pages so show all
            startPage = 1;
            endPage = totalPages;
        } else {
            // more than number total pages so calculate start and end pages
            if (currentPage <= (Params.totalPagedIsShow / 2 + 1)) {
                startPage = 1;
                endPage = 10;
            } else if (currentPage + (Params.totalPagedIsShow / 2 - 1) >= totalPages) {
                startPage = totalPages - (Params.totalPagedIsShow - 1);
                endPage = totalPages;
            } else {
                startPage = currentPage - (Params.totalPagedIsShow / 2);
                endPage = currentPage + (Params.totalPagedIsShow / 2 -1);
            }
        }

        // calculate start and end item indexes
        var startIndex = (currentPage - 1) * pageSize;
        var endIndex = Math.min(startIndex + pageSize - 1, totalItems - 1);

        // create an array of pages to ng-repeat in the pager control
        var pages = _.range(startPage, endPage + 1);

        // return object with all pager properties required by the view
        return {
            totalItems: totalItems,
            currentPage: currentPage,
            pageSize: pageSize,
            totalPages: totalPages,
            startPage: startPage,
            endPage: endPage,
            startIndex: startIndex,
            endIndex: endIndex,
            pages: pages
        };
    }
}]);