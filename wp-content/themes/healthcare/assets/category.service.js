angular.module('MyApp').factory('CategoryService', ['$resource', 'Params',
    function ($resource, Params) {
        return $resource(Params.rootUrl + 'Category', {}, {
            queryNewsCategory: {
                method: 'GET',
                url: Params.rootUrl + 'Category/GetPostCategory?parentId=:parentId',
                params: { parentId: '@parentId' },
                isArray: true
            },
            query: {
                method: 'GET',
                url: Params.rootUrl + 'Category/GetMenu',
                isArray: true
            },
            queryPosition: {
                method: 'GET',
                url: Params.rootUrl + 'Category/GetMenu?position:=position',
                params: {position: '@position'},
                isArray: true
            },
            getCategory: {
                method: 'GET',
                url: Params.rootUrl + 'Category/GetCategory?:=id',
                params: { id: '@id' }
            }
        });
    }]);