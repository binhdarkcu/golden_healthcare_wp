
angular.module('MyApp').factory('RSSService', ['$resource', 'Params',
    function ($resource, Params) {
        return $resource(Params.rootUrl + 'Medinet', {}, {
            query: {
                method: 'GET',
                url: Params.rootUrl + 'Rss/Get',
                isArray: true
            },
            queryRss: {
                method: 'GET',
                url: Params.rootUrl + 'Medinet/GetByUrl?url=:url',
                params: {
                    url: '@url'
                },
                isArray: true,
                headers: { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' }
            },

            queryContent: {
                method: 'GET',
                url: Params.rootUrl + 'Medinet/Get?type=:type',
                params: {
                    type: '@type'
                },
                isArray: true,
                headers: { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' }
            },
        });
    }]);