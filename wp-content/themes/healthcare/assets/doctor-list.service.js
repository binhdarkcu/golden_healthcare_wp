angular.module('MyApp').factory('doctorListService', ['$resource', 'Params',
    function ($resource, Params) {
        return $resource(Params.rootUrl + 'DoctorProfile', {}, {
            get: {
                method: 'GET',
                url: Params.rootUrl + "DoctorProfile/Get",
                params: { id: '@id' },
                isArray: true
            },
            getProfile: {
                method: 'GET',
                url: Params.rootUrl + "DoctorProfile/Get/:id",
                params: { id: '@id' }
            },
            getByDepartment: {
                method: 'GET',
                url: Params.rootUrl + "DoctorProfile/GetPaging?pageIndex=:pageIndex&numberInPage=:numberInPage&departmentId=:departmentId&searchText=:searchText",
                params: { pageIndex: '@pageIndex', numberInPage: '@numberInPage', departmentId: '@departmentId', searchText: '@searchText' }
            }
        });
    }]);