app.service("h5TakePhotoService", function ($q, $uibModal) {
 
this.photo = function () {
	var deferred = $q.defer();
	require([config.server + "/com/controllers/photo.js"], function () {
		$uibModal.open({
			templateUrl: config.server + "/com/views/modal_take_photo.html",
			controller: "photoModalController",
			windowClass: "modal-photo"
		}).result.then(function (e) {
			deferred.resolve(e);
		});
	});
	return deferred.promise;
}