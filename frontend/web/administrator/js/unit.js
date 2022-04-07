app.controller('unitCtrl', ['$scope', '$element', '$http', '$window', function($scope, $element, $http,$window) {
    $scope.Fetchdata = function() {
        $http({
            method:'GET',
            url:backendURI + '/administrator/unit/api-unit',
        })
        .then(function(response) {
            $scope.units = response.data;
        },function(response) {
            $scope.message = response.message;
        });
    };
    $scope.view = function(unit_id){
        $window.location.href = backendURI + '/administrator/unit/view?unit_id=' + unit_id;
    };
    $scope.goUpdate = function(unit_id){
        $window.location.href = backendURI + '/administrator/unit/update2?unit_id=' + unit_id;
    }
}]);