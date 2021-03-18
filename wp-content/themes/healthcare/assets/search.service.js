angular.module('MyApp').factory('SearchService', ['$resource', 'Params',
    function ($resource, Params) {
        return $resource(Params.rootUrl + 'SPAPost', {}, {
             queryPostPaging: {
                method: 'GET',
                url: Params.rootUrl + "SPAPost/GetPaging?languageCode=:languageCode&pageIndex=:pageIndex&numberInPage=:numberInPage&priority=:priority&categoryId=:categoryId",
                params: { languageCode: '@languageCode', pageIndex: '@pageIndex', numberInPage: '@numberInPage', priority: '@priority', categoryId: '@categoryId' }
            }
        });
    }]);