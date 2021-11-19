app.controller('eventCtrl', ['$scope', '$element', '$http', '$window', function($scope, $element, $http,$window) {
    $scope.Fetchdata = function() {
        $http({
            method:'GET',
            url:backendURI + '/events/api-event',
        })
        .then(function(response) {
            $scope.events = response.data;
        },function(response) {
            $scope.message = response.message;
        });
    };
    $scope.view = function(event_id){
        $window.location.href = backendURI + '/events/view?event_id=' + event_id;
    };
}]);