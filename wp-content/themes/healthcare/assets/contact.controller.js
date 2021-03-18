angular.module('MyApp').controller('ContactController', ['$scope', '$q', "contactServices",
    function ($scope,$q,  contactServices) {

    	$scope.mail = new Object();
    	$scope.loadData = function () {
    		var promiseContact = contactServices.getContact();

    		$scope.combineResult = $q.all([
                promiseContact
    		]).then(function (resp) {
    			if (resp[0].data != null) {
    				$scope.contact = resp[0].data;
    			}
    		}).finally(function () {

    		});
    	}

		//Send email
    	$scope.sendmail = function (mail) {
    	    contactServices.postMail(mail);
    	}
    }]);