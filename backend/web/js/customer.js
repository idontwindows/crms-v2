app.controller('CustomerCtrl', ['$scope', '$element', '$http', '$window', function ($scope, $element, $http, $window) {
$scope.fetchData = function(unit_id){
    $http({
        method:'GET',
        url:backendURI + '/unit/api-customer?unit_id=' + unit_id,
    }).then(function(response){
        if(response.data.message){
            alert('Data is empty...');
            $window.location.href = backendURI + '/unit/index';
        }else{
            $scope.datas = response.data;
        }       
    });
};
//--------------drilldown button----------------
$scope.drilldown = function(index){ 
    if($scope.datas[index].drilldown == false){
        $scope.datas[index].drilldown = true;
        $('#btn-drilldown-' + index).removeClass('btn-primary');
        $('#btn-drilldown-' + index).addClass('btn-danger');
        $('#btn-drilldown-' + index + ' i').removeClass('fa-plus');
        $('#btn-drilldown-' + index + ' i').addClass('fa-minus');
    }else{
        $scope.datas[index].drilldown = false;
        $('#btn-drilldown-' + index).removeClass('btn-danger');
        $('#btn-drilldown-' + index).addClass('btn-primary');
        $('#btn-drilldown-' + index + ' i').removeClass('fa-minus');
        $('#btn-drilldown-' + index + ' i').addClass('fa-plus'); 
    }
};
}]);