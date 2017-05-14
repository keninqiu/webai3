app.controller('photoCtrl', function ($scope,$routeParams,DataManager) {

$scope.photoErr = false;
$scope.photoBtnDiable = true;
var mediaStream = null,track = null;
 
navigator.getMedia = (navigator.getUserMedia ||
navigator.webkitGetUserMedia || navigator.mozGetUserMedia ||
navigator.msGetUserMedia);
if (navigator.getMedia) {
navigator.getMedia(
{
video: true
},
// successCallback
function (stream) {
var s = window.URL.createObjectURL(stream);
var video = document.getElementById('video');
video.src = window.URL.createObjectURL(stream);
mediaStream = stream;
track = stream.getTracks()[0];
$scope.photoBtnDiable = false; $scope.$apply();
},
// errorCallback
function (err) {
$scope.errorPhoto();
console.log("The following error occured:" + err);
});
} else {
$scope.errorPhoto();
}

$scope.snap = function () {
var canvas = document.createElement('canvas');
canvas.width = "400";
canvas.height = "304";
 
var ctx = canvas.getContext('2d');
ctx.drawImage(video, 0, 0, 400, 304);
$scope.closeCamera();
$uibModalInstance.close(canvas.toDataURL("image/png"));
};

$scope.closeCamera = function () {
if (mediaStream != null) {
if (mediaStream.stop) {
mediaStream.stop();
}
$scope.videosrc = "";
}
if (track != null) {
if (track.stop) {
track.stop();
}
}
}
});