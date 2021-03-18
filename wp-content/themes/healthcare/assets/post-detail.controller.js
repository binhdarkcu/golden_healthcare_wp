angular.module('MyApp').controller('detailController', ['$scope', '$log', 'PostService', '$filter', '$route', "Params", '$timeout', '$rootScope', 'MetaService', 'CategoryService','authService',
    function ($scope, $log, PostService, $filter, $route, Params, $timeout, $rootScope, MetaService, CategoryService, authService) {
        $rootScope.metaservice = MetaService;
        $scope.isShow = false;

        //get Id parameter from Url
        $scope.PostId = $route.current.params.id;
        $scope.categoryId = '';

        $('a[ng-href="/index/blog"]').parent('li').addClass('active');

        $scope.getAdvertise = function () {
            PostService.getAdvertise(function (data) {
                $scope.Advertises = data;
            });
        }

        //get data of view
        $scope.queryView = function () {
           // var Id = $route.current.params.id;
            PostService.get({ Id: $scope.PostId }, function (data) {
                if (data != null) {
                    $scope.post = data;
                    $scope.categoryId = $scope.post.CategoryId;
                    //$scope.getListPost();
                    //$scope.isShow = true;
                    $timeout(function () {
                        //set meta 
                        $rootScope.metaservice.setMetaPage($scope.post.TitleTrans, $scope.post.TitleSEO, $scope.post.DescriptionSEO);
                        var robots = getMetaRobot(data);
                        $rootScope.metaservice.setMetaPost($scope.post.Canonical, $scope.post.BreadcrumbsTitle, robots);
                        $rootScope.metaservice.setMetaFace(window.location.href, "Bài viết", $scope.post.TitleTrans, $scope.post.DescriptionTrans, $scope.post.Image);

                        $scope.getAdvertise();

                        //list post
                        //$scope.Posts = data.lstPostListViewModel;
                        $scope.getListPost();
                        $scope.isShow = true;

                        //get category
                        CategoryService.queryNewsCategory({ parentId: $scope.categoryId }, function (data) {
                            $scope.Categories = data;
                        });

                    }, 500);
                }
            });
        };

        //get list post
        $scope.getListPost = function() {
            PostService.getListPost({ languageCode: Params.languageCode, categoryId: $scope.categoryId, numTop: 5 }, function (data) {
                $scope.listPosts = data;
            });
        }


        //get post detail
        $scope.viewDetail = function (Id) {
            PostService.get({ Id: Id }, function (data) {
               // $('html, body').animate({ scrollTop: $('.postDetail').offset().top - 120 }, 1000);
                $scope.post = data;
                $scope.listTag = data.Tag.split(';');
                if ($scope.listTag == "")
                    $scope.listTag = null;
            });
        }

        $scope.viewVideo = function (item) {
            $('#viewVideo').modal('toggle');
            if (item.Type > 0) {
                $scope.showVideo = true;
                $scope.thumbVideo = item.Resouce;
                $scope.TitleVideo = item.Name;
            }
            else {
                $scope.showVideo = false;
                $scope.thumbImage = item.Image;
                $scope.TitleAdvertise = item.Name;
            }
        };

        function getMetaRobot(data) {
            var robotArr = [];
            if (data.MetaRobotIndex == 1) {
                robotArr.push('index');
            }
            if (data.MetaRobotFollow) {
                robotArr.push('follow');
            }
            if (data.MetaRobotAdvanced) {
                robotArr.push('advance');
            }
            var robots = '';
            if (robotArr.length > 1) {
                for (var i = 0; i < robotArr.length - 1; ++i) {
                    robots = robots + robotArr[i] + ', ';
                }
                robots = robots + robotArr[robotArr.length - 1];
            }

            return robots;
        }

        //Check require login
        $scope.isRequiredLogin = function (isInternal) {
            if (isInternal && !$rootScope.auth.isAuth) {
                return true;
            }
            return false;
        }

        //login
        var _loginObj = {};
        _loginObj.login = function (user) {

            //flag
            _loginObj.dataLoading = true;
            _loginObj.loginFailed = false;

            authService.logout();

            authService.login(user).then(function (response) {

                //success
                loginSuccess(response);

            },
             function (err) {
                 _loginObj.dataLoading = false;
                 _loginObj.loginFailed = true;
                 if (err.data.error == 'invalid_grant') {
                     _loginObj.loginFailedMessage = "Tên đăng nhập hoặc mật khẩu không đúng. Vui lòng thử lại!";
                 }
                 else {
                     _loginObj.loginFailedMessage = err.data.error_description;
                 }

             });
        };
        $scope.loginObj = _loginObj;

        //Login Success 
        var loginSuccess = function (response) {

        }

        //logout
        $scope.logout = function () {
            authService.logout();
            location.reload();
        };
    }]);