angular.module('MyApp').factory('PostListService', ['$resource', 'Params',
    function ($resource, Params) {
        return $resource(Params.rootUrl + 'SPAPost', {}, {
            queryTopPost: {
                method: 'GET',
                url: Params.rootUrl + "SPAPost/GetListPost?languageCode=:languageCode&priority=:priority&categoryId=:categoryId&typeMedia=:typeMedia&type=:type&numTop=:numTop",
                isArray: true,
                params: { languageCode: '@languageCode', priority: '@priority', categoryId: '@categoryId', typeMedia: '@typeMedia', type: '@type', numTop: '@numTop' }
            },
            queryPostPaging: {
                method: 'GET',
                url: Params.rootUrl + "SPAPost/GetPaging?languageCode=:languageCode&pageIndex=:pageIndex&numberInPage=:numberInPage&priority=:priority&categoryId=:categoryId&Search=:Search&FirstChar=:FirstChar",
                params: { languageCode: '@languageCode', pageIndex: '@pageIndex', numberInPage: '@numberInPage', priority: '@priority', categoryId: '@categoryId', Search: '@Search', FirstChar: '@FirstChar' }
            }



        });
    }]);