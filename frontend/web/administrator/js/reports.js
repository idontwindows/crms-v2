app.controller('reportsCtrl', ['$scope', '$element', '$http', '$window', function($scope, $element, $http,$window) {
    // var today = new Date();
    // var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
    $scope.respondent = '';
    $scope.datefrom = '';
    $scope.dateto = '';
    $scope.unit_id = '';
    $scope.Fetchdata = function() {
        $http({
            method:'GET',
            url:backendURI + '/administrator/reports/reports-api?unit_id='+ $scope.unit_id + '&datefrom=' + $scope.datefrom + '&dateto=' + $scope.dateto,
        })
        .then(function(response) {
            $scope.reports = response.data;
            respondent = response.data.customer;
            $scope.respondent = respondent;
        },function(response) {
            $scope.message = response.message;
        });
    };
    $scope.Fetchunit = function() {
        $http({
            method:'GET',
            url:backendURI + '/administrator/reports/unit-api',
        })
        .then(function(response) {
            $scope.units = response.data;
        },function(response) {
            $scope.message = response.message;
        });
    };
    $scope.OnChange = function(){
        $scope.Fetchdata();
    };
    $scope.OnExport = function(unit_id,from,to){
        var win = window.open('/administrator/reports/exporttoexcel?unit_id=' + unit_id + '&datefrom=' + from + '&dateto=' + to, '_blank');
        win.focus()
    }
}]);