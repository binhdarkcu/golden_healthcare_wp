angular.module('MyApp').controller("HomePageController", [
    "$scope", "$rootScope", "$location", "$route", "$http", "Params", "$timeout", "$q", "indexServices", 'MetaService',
    function ($scope, $rootScope, $location, $route, $http, Params, $timeout, $q, indexServices, MetaService) {

        $rootScope.metaservice = MetaService;
       
        $rootScope.title = "Trang chủ";
        $scope.Post = new Object();
        $scope.firstPost = [];
        $scope.Posts = [];
        $scope.about = [];
        $scope.depImages = [];
        $scope.mail = new Object();
        $scope.isSlider = false;
        $rootScope.isLoading = true;

        //Sample load summary data - (call APIs from eHos later)
        //$http.get('/assets/data/index-summary.json').then(function(res){
        //    $scope.promiseSumary = res.data;                
        //});

        $scope.loadData = function () {
            var promiseSlider = indexServices.getSlider();
            var promiseMenu = indexServices.getListMenu();
            //var promiseAbout = indexServices.getAbout(Params.categoryId_About, Params.languageCode);
            var promiseAbout = indexServices.getAboutById(Params.postAboutId);
            var promiseFeature = indexServices.getFeature();
            var promistContact = indexServices.getContact();
            var promisePosts = indexServices.getListPost(
                Params.languageCode,
                Params.newpriority,
                Params.postParentCategoryId,
                Params.numTopPost
            );
          //  var promiseSumary = $http.get('todos.json');

            $scope.combineResult = $q.all([
                promiseSlider,
                promiseMenu,
                promiseAbout,
                promiseFeature,
                promistContact,
                promisePosts
            ]).then(function (resp) {
                // Slider
                if (resp[0].data != null) {
                    $scope.sliders = resp[0].data;
                    $timeout(function () {
                        $("#main-slider").find('.owl-carousel').owlCarousel({
                            slideSpeed: 2000,
                            paginationSpeed: 2000,
                            singleItem: true,
                            navigation: true,
                            navigationText: [
                            "<i class='fa fa-angle-left'></i>",
                            "<i class='fa fa-angle-right'></i>"
                            ],
                            afterInit: progressBar,
                            afterMove: moved,
                            startDragging: pauseOnDragging,
                            transitionStyle: "fadeUp"
                        });
                        $rootScope.isLoading = false;
                    }, 0);
                }
               

                // About
                if (resp[2].data != null) {
                    $scope.about = resp[2].data;
                }

                // Feature
                if (resp[3].data != null) {
                    $scope.features = resp[3].data;
                }

                // Contact
                if (resp[4].data != null) {
                    $scope.contact = resp[4].data;

                    //set meta
                    $rootScope.metaservice.setMetaPage($scope.contact.SEOTitle, $scope.contact.SEODescription, $scope.contact.SEOKeyword);
                    $rootScope.metaservice.setMetaFace(window.location.href, "website", $scope.contact.Name, $scope.contact.Name, window.location.href + 'favicon.ico');
                }

                // Post
                if (resp[5].data != null) {
                    $scope.Posts = resp[5].data;
                    $scope.allNews = Params.postParentCategoryId;
                }
				//Menu
                if (resp[1].data != null) {
                    //$scope.menus = resp[0].data;
                    //$scope.menus = nested(resp[1].data);
                }
            }).finally(function () {

                //$timeout(function () {
                //    $("#main-slider").find('.owl-carousel').owlCarousel({
                //        slideSpeed: 2000,
                //        paginationSpeed: 2000,
                //        singleItem: true,
                //        navigation: true,
                //        navigationText: [
                //        "<i class='fa fa-angle-left'></i>",
                //        "<i class='fa fa-angle-right'></i>"
                //        ],
                //        afterInit: progressBar,
                //        afterMove: moved,
                //        startDragging: pauseOnDragging,
                //        transitionStyle: "fadeUp"
                //    });
                //}, 1000);
            });
        }

        //convert url
        $scope.convertUrl = function (url) {
            return url.replace(/\\/g, '/');
        }

        $scope.sendmail = function (mail) {
            indexServices.postSendMail(mail);
            $scope.mail = null;
        }

        function progressBar(elem) {
            $elem = elem;
            //build progress bar elements
            buildProgressBar();
            //start counting
            start();
            //
        }

        function moved() {
            //clear interval
            clearTimeout(tick);
            //start again
            start();
        }

        //pause while dragging 
        function pauseOnDragging() {
            isPause = true;
        }

        //create div#progressBar and div#bar then append to $(".owl-carousel")
        function buildProgressBar() {
            $progressBar = $("<div>", {
                id: "progressBar"
            });
            $bar = $("<div>", {
                id: "bar"
            });
            $progressBar.append($bar).appendTo($elem);
        }

        function start() {
            //reset timer
            percentTime = 0;
            isPause = false;
            //run interval every 0.01 second
            tick = setInterval(interval, 10);
        };

        $scope.getDepartmentDetail = function (id) {
            indexServices.getDepartment(id).then(function (d) {
                $scope.depImages = d.data; // Success
            }, function () {
                alert('Error Occurred !!!'); // Failed
            });
        };

        function interval() {
            if (isPause === false) {
                percentTime += 1 / 13;
                $bar.css({
                    width: percentTime + "%"
                });
                //if percentTime is equal or greater than 100
                if (percentTime >= 100) {
                    //slide to next item 
                    $elem.trigger('owl.next');
                }
            }
        }

        //$scope.scrollMenu = function () {
        //    var menu = $route.current.params.menu;
        //    if (menu == 'services') {
        //        $('html, body').animate({ scrollTop: $('#services').offset().top + 450 }, 1000);
        //    }
        //    if (menu == 'portfolio') {
        //        $('html, body').animate({ scrollTop: $('#portfolio').offset().top + 450 }, 1000);
        //    }
        //    if (menu == 'about') {
        //        $('html, body').animate({ scrollTop: $('#about').offset().top + 450 }, 1000);
        //    }
        //    if (menu == 'blog') {
        //        $('html, body').animate({ scrollTop: $('#blog').offset().top + 450 }, 1000);
        //    }
        //    if (menu == 'get-in-touch') {
        //        $('html, body').animate({ scrollTop: $('#get-in-touch').offset().top + 450 }, 1000);
        //    }
        //};
    }
]);