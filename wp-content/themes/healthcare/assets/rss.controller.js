angular.module('MyApp').controller('RSSController', ['$scope', "RSSService",
    function ($scope, RSSService) {

        $scope.rss = [];
        $scope.get = [];
        $scope.getdata = [];
        $scope.rssVB = RSSService.query(function (data) {
            if (data != null) {
                var content = {};

                for (i = 0; i < data.length; i++) {
                    getRssContent(data[i]);

                }

            }
        });

        var getRssContent = function (rss) {
            var content = {};
            content.Title = rss.Title;
            var param = { url: rss.Handler };


            RSSService.queryRss(param, function (data) {
                content.contents = data;
                $scope.rss.push(content)
            });

        }



    }]);