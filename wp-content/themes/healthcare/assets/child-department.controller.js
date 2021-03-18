angular.module('MyApp').controller('ChildDepartmentController', ['$scope', 'PostService', '$filter',
    '$route', '$timeout', "indexServices", "$q", 'Params', '$location',
    function ($scope, PostService, $filter, $route, $timeout, indexServices, $q, Params, $location) {
        $scope.isShow = false;
        $scope.selectedTab = 1;
        //get parentId parameter from Url
        var parentId = $route.current.params.id;
        var handler = 'CK';
        $('a[ng-href="/index/portfolio"]').parent('li').addClass('active');
        $scope.depts = [];

        $scope.focusTab = function (id) {
            $('div[id*=sppb-tab1-]').removeClass('sppb-tab-pane sppb-fade active in');
            $('div[id*=sppb-tab1-]').addClass('sppb-tab-pane sppb-fade');
            $('div[id*=sppb-tab1-' + id + ']').addClass('sppb-tab-pane sppb-fade active in');
            PostService.getPostByCate({ languageCode: "vi", priority: Params.newpriority, categoryId: id, type: 1, numTop: 1 }, function (data) {
                if (data != null) {
                    $scope.post = data[0];
                }
            });
        }

        $scope.getChildDept = function () {
            var promiseDepartments = indexServices.getDepartments(parentId);
            var promiseDepartment = indexServices.getDepartment(parentId);
            $scope.combineResult = $q.all([
                promiseDepartment,
                promiseDepartments
            ]).then(function (resp) {
                if (resp[0].data != null) {
                    $scope.depts.push(resp[0].data)
                }
                if (resp[1].data != null) {
                    var data = resp[1].data;
                    for (var i = 0; i < data.length; i++) {
                        if (data[i].Id != Params.departmentParentCategoryId) {
                            $scope.depts.push(data[i]);
                        }
                    }
                }

                if ($scope.depts.length > 0) {
                    $scope.focusTab($scope.depts[0].Id);
                }
            });
        }
    }]);