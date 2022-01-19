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
app.controller('UpdateUnitCtrl', ['$scope', '$element', '$http', '$window', function ($scope, $element, $http, $window) {

    var today = new Date();
    var dd = String(today.getDate()).padStart(2, '0');
    var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
    var yyyy = today.getFullYear();
    $scope.today = mm + '/' + dd + '/' + yyyy;

    $scope.success = false;
    $scope.error = false;
    $scope.formData = { question: [{ parentAttrib: "", items: [{ childAttrib: "" }] }], unitname: "", region: region_id,servicename:"",date: "",};
    $scope.addQuestion = function () {
        $scope.formData.question.push({ parentAttrib: "", items: [{ childAttrib: "" }] });
    };
    $scope.removeQuestion = function (index) {
        $scope.formData.question.splice(index, 1);
    }
    $scope.addItem = function (index,unit_id) {
        $scope.formData.question[index].items.push({ childAttrib: "" });
        var group_id = $scope.formData.question[index].question_group_unit_id;
        $http({
            method: "POST",
            url: backendURI + "/administrator/unit/add-update?unit_id=" + unit_id,
            data: {group_id:group_id}
        }).then(function (response) {
            $scope.Fetchdata(unit_id);
            console.log($scope.formData);
        });
        //console.log($scope.formData);
    };
    $scope.removeItem = function (parent, index, unit_id) {
        var question_id = $scope.formData.question[parent].items[index].question_unit_id;
        $scope.formData.question[parent].items.splice(index, 1);

        $http({
            method: "POST",
            url: backendURI + "/administrator/unit/remove-update?unit_id=" + unit_id,
            data: {question_id:question_id}
        }).then(function (response) {
            $scope.Fetchdata(unit_id);
            console.log($scope.formData);
        });
    };

    $scope.Fetchdata= function(unit_id) {
        $http({
            method:'GET',
            url:backendURI + '/administrator/unit/questions-api?unit_id=' + unit_id,
        })
        .then(function(response) {
            $scope.formData = response.data;
        },function(response) {
            $scope.message = response.message;
        });
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
    $scope.submitForm = function (unit_id) {
        $scope.formData.date = $scope.today
        // if ($("#txtEditor").summernote("isEmpty")) {
        //     $scope.formData.mailText = '';
        // } else {
        //     var note = $('.note-editable').html();
        //     $scope.formData.mailText = note;
        // }
        $http({
            method: "POST",
            url: backendURI + "/administrator/unit/update?unit_id=" + unit_id,
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
                    text: "Data has been update...",
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