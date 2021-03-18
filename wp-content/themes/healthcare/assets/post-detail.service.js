
angular.module('MyApp').factory('PostService', ['$resource', 'Params',
    function ($resource, Params) {
        return $resource(Params.rootUrl + 'SPAPost', {}, {
            query: {
                method: 'GET',
                url: Params.rootUrl + 'SPAPost/GetPosts/:Id?languageCode=:languageCode',
                params: {
                    Id: '@Id', languageCode: '@languageCode'
                }
            },
            get: {
                method: "GET",
                url: Params.rootUrl + 'SPAPost/Get/:Id',
                params: { Id: '@Id' }
            },
            getAdvertise: {
                method: "GET",
                url: Params.rootUrl + 'Advertise/Get', isArray: true
            },
            getPostByCate: {
                method: "GET",
                url: Params.rootUrl + 'SPAPost/GetListPost?languageCode=:languageCode&priority=:priority&categoryId=:categoryId&type=:type&numTop=:numTop',
                params: {
                    languageCode: '@languageCode',
                    priority: '@priority',
                    categoryId: '@categoryId',
                    type: '@type',
                    numTop: 'numTop'
                },
                isArray: true
            },
            getListPost: {
                method: 'GET',
                url: Params.rootUrl + 'SPAPost/GetListPost?languageCode=:languageCode&categoryId=:categoryId&numTop=:numTop',
                isArray: true,
                params: {
                    languageCode: '@languageCode',
                    categoryId: '@categoryId',
                    numTop: '@numTop'
                }//,
                //complete(data) {
                //    console.log(data);
                //},
                //success(data){
                //    console.log(data);
                //    return data;
                //},
                //error(data) {
                //    console.log(data);
                //}
            }
        });
    }]);