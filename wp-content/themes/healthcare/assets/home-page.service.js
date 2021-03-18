angular.module('MyApp').service("indexServices", ["$http", 'Params',
    function ($http, Params) {
        // Get List Post
        this.getListPost = function (languageCode, priority, categoryId, numTop) {
            //var response = $http.get(Params.rootUrl + "SPAPost/GetListPost?languageCode=" + languageCode+"&priority="+ priority + "&numTop=" + numTop);
            var response = $http.get(Params.rootUrl + "SPAPost/GetListPost?languageCode=" + languageCode + "&priority=" + priority + "&categoryId=" + categoryId + "&numTop=" + numTop);
            return response;
        };

        // get About
        this.getAbout = function (categoryId, languageCode) {
            var response = $http.get(Params.rootUrl + "SPAPost/GetPostAbout?categoryId=" + categoryId + "&languageCode=" + languageCode);
            return response;
        };
        this.getAboutById = function (id) {
            var response = $http.get(Params.rootUrl + "SPAPost/Get/" + id);
            return response;
        };

        // get Slider
        this.getSlider = function () {
            var response = $http.get(Params.rootUrl + "Slider/Get");
            return response;
        };

        // get Department
        //this.getDepartment = function () {
        //    var response = $http.get(Params.rootUrl + "Department/Get");
        //    return response;
        //};
        this.getDepartments = function (parentId) {
            var response = $http.get(Params.rootUrl + "Category/GetCategoryChuyenKhoa?type=2&parentId=" + parentId);
            return response;
        };
        this.getDepartment = function (id) {
            var response = $http.get(Params.rootUrl + "Category/Get/" + id);
            return response;
        }

        // get Feature
        this.getFeature = function () {
            var response = $http.get(Params.rootUrl + "Feature/Get");
            return response;
        };

        // get Contact
        this.getContact = function () {
            var response = $http.get(Params.rootUrl + "Configuration/Get");
            return response;
        };

        //get Menu
        this.getListMenu = function () {
            var response = $http.get(Params.rootUrl + "Category/GetMenu");
            return response;
        };

        // post SendMail
        this.postSendMail = function (mail) {
            var form = $('#main-contact-form');
            var form_status = $('<div class="form_status"></div>');
            $http({
                url: Params.rootUrl + "Configuration/SendMail",
                method: "POST",
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                data: $.param(mail)
            }).then(function (response) {
                if (response.data) {
                    form_status.html('<p class="text-success">Cảm ơn bạn đã liên hệ với chúng tôi. Chúng tôi sẽ liên hệ với bạn ngay khi có thể</p>').delay(3000).fadeOut();
                }
            }, function (error) {
                var data = error.data;
                form_status.html(error.data).delay(3000).fadeOut();
            });
        };
        this.queryTop3Post = function (languageCode, priority, categoryId, numTop, typeMedia, type) {
            var response = $http.get(Params.rootUrl + "SPAPost/GetListPost?languageCode=" + languageCode + "&priority=" + priority + "&categoryId="
                + categoryId + "&typeMedia=" + typeMedia + "&type=" + type + "&numTop=" + numTop + "");
            return response;
        };

        function successCallback() {

        }

        function errorCallback() {

        }
    }
]);
    //.factory('IndexFactory', ['$resource', 'Params',
    //function ($resource, Params) {
    //    return $resource(Params.rootUrl + 'Category', {}, {
    //        query: {
    //            method: 'GET',
    //            url: Params.rootUrl + "Category/GetCategoryChuyenKhoa?handler=:handler&parentId=:parentId",
    //            params: {
    //                handler: '@handler',
    //                parentId: '@parentId'
    //            },
    //            isArray: true
    //        }
    //    });
    //}]);;