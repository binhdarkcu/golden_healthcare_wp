angular.module('MyApp')
    .controller("DoctorListController", ["$scope", "$location", "$route", "Params", "doctorListService",
    function ($scope, $location, $route, Params, doctorListService) {

        $scope.subTitle = "Danh sách bác sĩ";
        $scope.doctors = [];

        //var id = $route.current.params.id;
        $scope.numberInPage = 10;
        $scope.pageIndex = 1;
        $scope.toTalPage = 0;
        $scope.toTalItem = 0;
        $scope.isLoadData = true;

        $(window).scroll(function () {
            if ($(window).scrollTop() ==
               $(document).height() - $(window).height()) {
                if ($scope.pageIndex < $scope.toTalPage && $scope.isLoadData) {
                    $scope.loadMore();
                    $scope.pageIndex++;
                }
            }
        });
        $scope.searchData = function () {
            if ($scope.searchDoctor == undefined) {
                $scope.searchDoctor = '';
            }
            doctorListService.getByDepartment({
                pageIndex: $scope.pageIndex,
                numberInPage: $scope.numberInPage,
                departmentId: 0,
                searchText: $scope.searchDoctor
            },
                function (data) {
                    if (data != null) {
                        if (data.lstDoctorProfileViewModel.length > 0) {
                            $scope.profiles = data.lstDoctorProfileViewModel;
                            $scope.toTalItem = data.TotalItem;
                            $scope.toTalPage = Math.ceil($scope.toTalItem / $scope.numberInPage);
                            $scope.doctors = $scope.profiles
                        }
                        else {
                            $scope.doctors = [];
                        }
                    }
                    else { $scope.isLoadData = false }
                });
        }
        $scope.loadMore = function () {
            if ($scope.searchDoctor == undefined) {
                $scope.searchDoctor = '';
            }
            doctorListService.getByDepartment({
                pageIndex: $scope.pageIndex,
                numberInPage: $scope.numberInPage,
                departmentId: 0,
                searchText: $scope.searchDoctor
            },
                function (data) {
                if (data != null) {
                    if (data.lstDoctorProfileViewModel.length > 0) {
                        $scope.profiles = data.lstDoctorProfileViewModel;
                        $scope.toTalItem = data.TotalItem;
                        $scope.toTalPage = Math.ceil($scope.toTalItem / $scope.numberInPage);

                        for (var i = 0; i < $scope.profiles.length; i++) {
                            $scope.doctors.push($scope.profiles[i]);
                        }
                       
                    }
                    else {
                        $scope.doctors = [];
                    }
                }
                else { $scope.isLoadData = false }
                });
        }

        $scope.loadMore();
    }]);
