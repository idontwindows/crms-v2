app.directive('ngFile', ['$parse', function ($parse) {
    return {
        restrict: 'A',
        link: function (scope, element, attrs) {
            element.bind('change', function () {
                $parse(attrs.ngFile).assign(scope, element[0].files)
                scope.$apply();
            });
        }
    };
}]);
app.controller('CreateEventCtrl', ['$scope', '$element', '$http', '$window', function ($scope, $element, $http, $window) {
    $scope.success = false;
    $scope.error = false;
    $scope.formData = { question: [{ parentAttrib: "", items: [{ childAttrib: "" }] }], event: "", date: "", fontsize: "", yaxis: "" };
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

    $scope.submitForm = function () {
        var fd = new FormData();
        angular.forEach($scope.uploadfiles, function (file) {
            fd.append('file', file);
        });

        var filename = $('input[type=file]').val().split('\\').pop();
        $scope.formData.certificate = filename;

        if ($("#txtEditor").summernote("isEmpty")) {
            $scope.formData.mailText = '';
        } else {
            var note = $('.note-editable').html();
            $scope.formData.mailText = note;
        }

        $http({
            method: "POST",
            url: backendURI + "/events/create",
            data: $scope.formData
        }).then(function (response) {
            // if ($scope.formData.certificate != "") {
            //     $scope.upload();
            // }
            if (response.data != 'success') {
                if (response.data.event == "") {
                    $('#txtEvent').addClass('is-invalid');
                    //$scope.errormessageevent = data.data.event;
                } else {
                    $('#txtEvent').removeClass('is-invalid');
                    $('#txtEvent').addClass('is-valid');
                }
                if (response.data.date == "") {
                    $('#txtDate').addClass('is-invalid');
                    //$scope.errormessagedate = data.data.date;
                } else {
                    $('#txtDate').removeClass('is-invalid');
                    $('#txtDate').addClass('is-valid');
                }
                if ($scope.formData.certificate != "") {
                    if (response.data.fontsize == null) {
                        $('#inputFontsize').addClass('is-invalid');
                        //$scope.errormessagedate = data.data[1].date;
                    } else {
                        $('#inputFontsize').removeClass('is-invalid');
                        $('#inputFontsize').addClass('is-valid');
                    }
                    if (response.data.yaxis == null) {
                        $('#inputYAxis').addClass('is-invalid');
                        //$scope.errormessagedate = data.data[1].date;
                    } else {
                        $('#inputYAxis').removeClass('is-invalid');
                        $('#inputYAxis').addClass('is-valid');
                    }
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
                if (response.data.mailText == "") {
                    $('.note-editor').css({ "border-color": "red" });
                    //$scope.errormessagedate = data.data.date;
                } else {
                    $('.note-editor').css({ "border-color": "green" });
                }

            } else {
                $scope.formData = { question: [{ parentAttrib: "", items: [{ childAttrib: "" }] }], event: "", date: "", fontsize: "", yaxis: "" };
                swal({
                    title: "Success!",
                    text: "Data has been saved...",
                    icon: "success",
                  })
                    .then((value) => {
                        $window.location.href = backendURI + '/events/index';
                    });
            }
        });


        //console.log(JSON.stringify($scope.formData));
        //alert(JSON.stringify($scope.formData));
    };



    $scope.upload = function () {
        var fd = new FormData();
        angular.forEach($scope.uploadfiles, function (file) {
            fd.append('file', file);
        });

        $http({
            method: 'post',
            url: backendURI + "/events/upload",
            data: fd,
            headers: { 'Content-Type': undefined },
        }).then(function successCallback(response) {
            // Store response data
            $scope.response = response.data;
            $scope.preview();

        });
    };


    $scope.preview = function () {
        var filename = $('input[type=file]').val().split('\\').pop();
        $scope.source = backendURI + '/events/preview?name=JOHN%20DOE&image=' + filename + '&font_size=' + $scope.formData.fontsize + '&y_axis=' + $scope.formData.yaxis;
        console.log($scope.source);
    };

}]);