app.service("h5TakePhotoService", function ($q, $uibModal) {
 
this.photo = function () {
	var deferred = $q.defer();
	require([config.server + "/js/ctrl/photoCtrl.js"], function () {
		$uibModal.open({
			templateUrl: "/com/views/modal_take_photo.html",
			controller: "photoModalController",
			windowClass: "modal-photo"
		}).result.then(function (e) {
			deferred.resolve(e);
		});
	});
	return deferred.promise;
}