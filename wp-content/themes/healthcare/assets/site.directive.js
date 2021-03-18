angular.module('MyApp').directive('showtab',
    function () {
        return {
            link: function (scope, element, attrs) {
                element.click(function (e) {
                    e.preventDefault();
                    $(element).tab('show');
                });
            }
        };
    });
angular.module('MyApp').directive('scrollOnClick', function () {
    return {
        restrict: 'A',
        link: function (scope, $elm, attrs) {
            var idToScroll = attrs.href;
            $elm.on('click', function (e) {
                e.preventDefault();
                $("html, body").animate({ scrollTop: ($(this.hash).offset() ? $(this.hash).offset().top : 0) - 5 }, "slow");
                $('.navbar-collapse li.scroll').removeClass('active');
                $("a[href='" + this.hash + "']").parent().addClass('active');
            });
        }
    }
});