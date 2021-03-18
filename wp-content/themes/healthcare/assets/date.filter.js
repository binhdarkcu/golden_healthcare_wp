angular.module('MyApp').filter('jsonDate', ['$filter', function ($filter) {
    return function (input, format) {
        return (input) ? $filter('date')(parseInt(input.substr(6)), format) : '';
    };
}]).filter("trustUrl", ['$sce', function ($sce) {//url video angular
    return function (recordingUrl) {
        return $sce.trustAsResourceUrl(recordingUrl);
    };
}]).filter("dateFilter", function () {//2017-05-04T08:30:00 -> 04-05-2017
    return function (item) {
        if (item != null) {
            return new Date(item.split('T')[0]);
        }
        return "";
    }
});