// app.directive('ngFile', ['$parse', function ($parse) {
//     return {
//         restrict: 'A',
//         link: function (scope, element, attrs) {
//             element.bind('change', function () {
//                 $parse(attrs.ngFile).assign(scope, element[0].files)
//                 scope.$apply();
//             });
//         }
//     };
// }]);
app.controller('CreateUnitCtrl', ['$scope', '$element', '$http', '$window', function ($scope, $element, $http, $window) {

    var today = new Date();
    var dd = String(today.getDate()).padStart(2, '0');
    var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
    var yyyy = today.getFullYear();
    $scope.today = mm + '/' + dd + '/' + yyyy;

    $scope.success = false;
    $scope.error = false;
    $scope.selectedService;
    $scope.selectedFunctionalUnit;
    $scope.trigger = 1;
 

    $scope.formData = { question: [{ parentAttrib: "", items: [{ childAttrib: "" }] }], services_id: "",hrdc_id:null,pstc_id:null,unit_name:"" ,region: region_id,date: ""};
    $scope.addQuestion = function () {
        $scope.formData.question.push({ parentAttrib: "", items: [{ childAttrib: "" }] });
    };
    $scope.removeQuestion = function (index) {
        $scope.formData.question.splice(index, 1);
    }
    $scope.addItem = function (index) {
        $scope.formData.question[index].items.push({ childAttrib: "" });
    };
    $scope.removeItem = function (parent, index) {
        $scope.formData.question[parent].items.splice(index, 1);
    };

    $scope.Fetchregion = function() {
        $http({
            method:'GET',
            url:backendURI + '/administrator/unit/api-region',
        })
        .then(function(response) {
            $scope.regions = response.data;
        },function(response) {
            $scope.message = response.message;
        });
    };
    $scope.Fetchservices = function() {
        $http({
            method:'GET',
            url:backendURI + '/administrator/unit/functional-unit?region_id=' + region_id,
        })
        .then(function(response) {
            $scope.services = response.data;
        },function(response) {
            $scope.message = response.message;
        });
    };
    $scope.onChange = function(index){
        $scope.pstcs = typeof($scope.services[index].pstc) == undefined ? $scope.services[index].hrdc : $scope.services[index].pstc ;
        $scope.trigger = $scope.services[index].trigger;
        $scope.formData.services_id = $scope.services[index].services_id;
        if($scope.selectedService.services_id <= 7){
            $scope.formData.unit_name = $scope.services[index].services_name;
        }
    }
    $scope.onChangeFuncUnit = function(){
        if($scope.selectedService.services_id == 10){
            $scope.formData.hrdc_id = $scope.selectedFunctionalUnit.id;
            $scope.formData.pstc_id = null;
            $scope.formData.unit_name = $scope.selectedFunctionalUnit.name;
        }else if($scope.selectedService.services_id == 8 || $scope.selectedService.services_id == 9){
            $scope.formData.pstc_id = $scope.selectedFunctionalUnit.id;
            $scope.formData.hrdc_id = null;
            $scope.formData.unit_name = $scope.selectedFunctionalUnit.name;
        }
    }
    $scope.submitForm = function () {
        $scope.formData.date = $scope.today
        // if ($("#txtEditor").summernote("isEmp ty")) {
        //     $scope.formData.mailText = '';
        // } else {
        //     var note = $('.note-editable').html();
        //     $scope.formData.mailText = note;
        // }

        $http({
            method: "POST",
            url: backendURI + "/administrator/unit/create",
            data: $scope.formData
        }).then(function (response) {
            console.log(JSON.stringify(response.data))
            if (response.data != 'success') {
                if ($scope.formData.region == null) {
                    $('#select-region').addClass('is-invalid');
                    //$scope.errormessageevent = data.data.event;
                } else {
                    $('#select-region').removeClass('is-invalid');
                    $('#select-region').addClass('is-valid');
                }
                if ($scope.formData.unitname == "") {
                    $('#txtUnit').addClass('is-invalid');
                    //$scope.errormessageevent = data.data.event;
                } else {
                    $('#txtUnit').removeClass('is-invalid');
                    $('#txtUnit').addClass('is-valid');
                }
                //console.log($scope.formData.question.length);
                for (var i = 0; i < response.data.question.length; i++) {
                    if (response.data.question[i].parentAttrib == '') {
                        $('#txtParent-' + i).addClass('is-invalid');
                        //console.log(JSON.stringify(response.data.question[0].parentAttrib == ''));
                    } else {
                        $('#txtParent-' + i).removeClass('is-invalid');
                        $('#txtParent-' + i).addClass('is-valid');
                    }
                    for (var j = 0; j < response.data.question[i].items.length; j++) {
                        if (response.data.question[i].items[j].childAttrib == '') {
                            $('#txtChild-' + i + '-' + j).addClass('is-invalid');
                            //console.log(JSON.stringify(response.data.question[0].parentAttrib == ''));
                        } else {
                            $('#txtChild-' + i + '-' + j).removeClass('is-invalid');
                            $('#txtChild-' + i + '-' + j).addClass('is-valid');
                        }
                    }
                }
                // if (response.data.mailText == "") {
                //     $('.note-editor').css({ "border-color": "red" });
                //     //$scope.errormessagedate = data.data.date;
                // } else {
                //     $('.note-editor').css({ "border-color": "green" });
                // }

            } else {
                $scope.formData = { question: [{ parentAttrib: "", items: [{ childAttrib: "" }] }], event: "", date: "", fontsize: "", yaxis: "" };
                swal({
                    title: "Success!",
                    text: "Data has been saved...",
                    icon: "success",
                  })
                    .then((value) => {
                        $window.location.href = backendURI + '/administrator/unit/index';
                    });
            }
        });


        //console.log(JSON.stringify($scope.formData));
        //alert(JSON.stringify($scope.formData));
    };
}]);