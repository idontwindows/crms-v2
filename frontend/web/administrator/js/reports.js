app.controller('reportsCtrl', ['$scope', '$element', '$http', '$window', function ($scope, $element, $http, $window) {
    // var today = new Date();
    // var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();

    let today = new Date();
    let dd = String(today.getDate()).padStart(2, '0');
    let mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
    let yyyy = today.getFullYear();

    from = yyyy + '-' + mm + '-' + '01';
    to = yyyy + '-' + mm + '-' + dd;

    $scope.respondent = 0;
    $scope.datefrom = from;
    $scope.dateto = to;
    $scope.unit_id = 0;
    $scope.services_id = '';
    $scope.showDrivers = false;
    $scope.drivers_id = '';
    $scope.totalOutstanding = 0;
    $scope.percentOutstanding = 0;
    $scope.satisfactionRating = 0;


    $scope.Fetchdata = function (drivers_id = 0) {
        if(drivers_id == 0){
            $http({
                method: 'GET',
                url: backendURI + '/administrator/reports/reports-api?unit_id=' + $scope.unit_id + '&datefrom=' + $scope.datefrom + '&dateto=' + $scope.dateto,
            })
                .then(function (response) {
                    $scope.reports = response.data;
                    $scope.respondent = response.data.customer;
                    $scope.totalOutstanding = response.data.total_outstanding;

                    if($scope.respondent.length == 0 && $scope.totalOutstanding == 0){
                        $scope.satisfactionRating = 0;
                        $scope.percentOutstanding = 0;
                    }else{
                        let numQuetionsPerRatings = response.data.feedbacks.length * $scope.respondent.length;
                        $scope.satisfactionRating =  response.data.total_vs_outstanding / numQuetionsPerRatings * 100;
                        $scope.percentOutstanding = $scope.totalOutstanding / $scope.respondent.length * 100;
                    }   
                    //$scope.PieChart(1);
                    const isEmpty = $scope.reports.unit.length === 0;
                    //console.log(isEmpty);
                    if(!isEmpty){
                        $scope.services_id = response.data.unit[0].services_id;
                        if (response.data.unit[0].services_id == 12) {
                            $scope.showDrivers = true;
                        } else {
                            $scope.showDrivers = false;
                        }
                    }
                    
                    for (let i = 0; i < response.data.feedbacks.length; i++) {
                        let rating5 = response.data.feedbacks[i].rating5
                        let rating4 = response.data.feedbacks[i].rating4
                        let rating3 = response.data.feedbacks[i].rating3
                        let rating2 = response.data.feedbacks[i].rating2
                        let rating1 = response.data.feedbacks[i].rating1
                        $scope.PieChart(i + 1, rating5, rating4, rating3, rating2, rating1);
                    }
                }, function (response) {
                    $scope.message = response.message;
                });
        }else{
            $http({
                method: 'GET',
                url: backendURI + '/administrator/reports/reports-api?unit_id=' + $scope.unit_id + '&datefrom=' + $scope.datefrom + '&dateto=' + $scope.dateto + '&drivers_id=' + drivers_id,
            })
                .then(function (response) {
                    $scope.reports = response.data;
                    $scope.respondent = response.data.customer;
                    $scope.totalOutstanding = response.data.total_outstanding;
                    if($scope.respondent.length == 0 && $scope.totalOutstanding == 0){
                        $scope.percentOutstanding = 0;
                        $scope.satisfactionRating = 0;
                    }else{
                        let numQuetionsPerRatings = response.data.feedbacks.length * $scope.respondent.length;
                        $scope.satisfactionRating =  response.data.total_vs_outstanding / numQuetionsPerRatings * 100;
                        $scope.percentOutstanding = $scope.totalOutstanding / $scope.respondent.length * 100;
                    }  
                    //$scope.PieChart(1);
                    if(response.data.unit.length == 0){
                        $scope.services_id = response.data.unit[0].services_id;
                    }
                    if (response.data.unit[0].services_id == 12) {
                        $scope.showDrivers = true;
                    } else {
                        $scope.showDrivers = false;
                    }
                    for (let i = 0; i < response.data.feedbacks.length; i++) {
                        let rating5 = response.data.feedbacks[i].rating5
                        let rating4 = response.data.feedbacks[i].rating4
                        let rating3 = response.data.feedbacks[i].rating3
                        let rating2 = response.data.feedbacks[i].rating2
                        let rating1 = response.data.feedbacks[i].rating1
                        $scope.PieChart(i + 1, rating5, rating4, rating3, rating2, rating1);
                    }
                }, function (response) {
                    $scope.message = response.message;
                });
        }
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

    $http({
        method: 'GET',
        url: backendURI + '/administrator/reports/get-driver?region_id=' + region_id,
    })
        .then(function (response) {
            $scope.drivers = response.data;
        }, function (response) {
            $scope.message = response.message;
        });

    $scope.OnChange = function () {
        $scope.Fetchdata();
    };
    $scope.OnClick = function(drivers_id){
        //$scope.Fetchdata()
        //console.log(drivers_id);
        $scope.Fetchdata(drivers_id);

    }
    $scope.OnExport = function (unit_id, from, to) {
        var win = window.open('/administrator/reports/export?unit_id=' + unit_id + '&datefrom=' + from + '&dateto=' + to, '_blank');
        win.focus()
    };
    $scope.PieChart = function (index, rating5, rating4, rating3, rating2, rating1) {
        var ctx = document.getElementById("myPieChart-" + index).getContext('2d');
        var myPieChart1 = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ["Outstanding", "Very Satisfactory", "Satisfactory", "Unsatisfactory", "Poor"],
                datasets: [{
                    data: [rating5, rating4, rating3, rating2, rating1],
                    backgroundColor: ['#007bff', '#FFA500', '#808080', '#FFFF00', '#dc3545'],
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
                            if (ctx.dataset.data[ctx.dataIndex] > 0)
                            return percentage;
                            else
                            return "";                     
                        },
                        
                        color: '#000000',
                    }
                }
            }
        });


    };
}]);

