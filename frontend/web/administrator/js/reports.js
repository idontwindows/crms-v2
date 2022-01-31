app.controller('reportsCtrl', ['$scope', '$element', '$http', '$window', function ($scope, $element, $http, $window) {
    // var today = new Date();
    // var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
    $scope.respondent = '';
    $scope.datefrom = '';
    $scope.dateto = '';
    $scope.unit_id = '';
    $scope.Fetchdata = function () {
        $http({
            method: 'GET',
            url: backendURI + '/administrator/reports/reports-api?unit_id=' + $scope.unit_id + '&datefrom=' + $scope.datefrom + '&dateto=' + $scope.dateto,
        })
            .then(function (response) {
                $scope.reports = response.data;
                respondent = response.data.customer;
                $scope.respondent = respondent;
                //$scope.PieChart(1);
                
                for(let i=0;i<response.data.feedbacks.length;i++){
                    let rating5 = response.data.feedbacks[i].rating5
                    let rating4 = response.data.feedbacks[i].rating4
                    let rating3 = response.data.feedbacks[i].rating3
                    let rating2 = response.data.feedbacks[i].rating2
                    let rating1 = response.data.feedbacks[i].rating1
                    $scope.PieChart(i+1,rating5,rating4,rating3,rating2,rating1);
                }
            }, function (response) {
                $scope.message = response.message;
            });
    };
    $scope.Fetchunit = function () {
        $http({
            method: 'GET',
            url: backendURI + '/administrator/reports/unit-api',
        })
            .then(function (response) {
                $scope.units = response.data;
            }, function (response) {
                $scope.message = response.message;
            });
    };
    $scope.OnChange = function () {
        $scope.Fetchdata();
    };
    $scope.OnExport = function (unit_id, from, to) {
        var win = window.open('/administrator/reports/export?unit_id=' + unit_id + '&datefrom=' + from + '&dateto=' + to, '_blank');
        win.focus()
    };
    $scope.PieChart = function (index,rating5,rating4,rating3,rating2,rating1) {
        var ctx = document.getElementById("myPieChart-" + index).getContext('2d');
        var myPieChart1 = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ["Outstanding", "Very Satisfactory", "Satisfactory", "Unsatisfactory", "Poor"],
                datasets: [{
                    data: [rating5,rating4,rating3,rating2,rating1],
                    backgroundColor: ['#007bff', '#FFA500', '#808080', '#FFFF00', '#FF0000'],
                }],
            },
            options: {
                tooltips: {
                    enabled: false
                },
                legend: {
                    position: 'left'
                },
                plugins: {
                    datalabels: {
                        formatter: (value, ctx) => {
                            let sum = parseInt(rating5) + parseInt(rating4) + parseInt(rating3) + parseInt(rating2) + parseInt(rating1);
                            let percentage = (value * 100 / sum).toFixed(2) + "%";
                            return percentage;
                        },
                        color: '#000000',
                    }
                }
            }
        });

    };
}]);

