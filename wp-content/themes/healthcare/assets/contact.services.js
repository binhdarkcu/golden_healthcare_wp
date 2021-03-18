angular.module('MyApp').service('contactServices', ['$http', 'Params',
    function ($http, Params) {
        // get Contact
        this.getContact = function () {
            var response = $http.get(Params.rootUrl + "Configuration/Get");
            return response;
        };

        // post SendMail
        this.postMail = function (mail) {
            $http({
                url: Params.rootUrl + "Configuration/SendMail",
                method: "POST",
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                data: $.param(mail)
            }).then(function (data, status, headers, config) {
                $scope.status = status;
            }).error(function (data, status, headers, config) {
                $scope.status = status;
            });
        };
        }
    ]);