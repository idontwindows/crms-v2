<?php

$this->title = 'Update';
//$this->registerJsFile('/js/createEvent.js', ['position' => \yii\web\View::POS_END]);
$this->params['breadcrumbs'][] = ['label' => 'Unit', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div ng-controller="UpdateUnitCtrl">
    <form method="post" ng-submit="submitForm()" ng-init="Fetchdata(<?php echo $_GET['unit_id']?>)">
        <div class="card mb-2">
            <div class="card-header bg-info text-white">
                Unit
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="txtRegion"><b>Region</b></label>
                        <div class="input-group">
                            <select id="select-region" ng-model="formData.region" class="form-control" ng-init="Fetchregion()">
                                    <option value="" disabled selected>Select region...</option>
                                    <option ng-repeat="region in regions" value="{{ region.region_id }}">{{ region.region_name }}</option>                 
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="txtEmail"><b>Unit Name</b></label>
                        <input type="text" class="form-control" ng-model="formData.unitname" id="txtUnit" name="unit" placeholder="Type unit name here..." autofocus="" aria-required="true" aria-invalid="">
                        <!-- <div class="invalid-feedback">{{errormessageevent}}</div> -->
                    </div>

                    <!-- <div class="form-group col-md-6">
                        <label for="txtDate"><b>Event Date</b></label>
                        <div class="datepicker date input-group">
                            <input type="text" placeholder="Choose Date" name="date" ng-model="formData.date" class="form-control" id="txtDate">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                            </div>
                        </div>                      
                    </div> -->
                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header bg-info text-white">
                <div class="row">
                    <div class="col-md-11">
                        Attributes
                    </div>
                    <div class="col-md-1 d-flex justify-content-end">
                        <button type="button" class="btn btn-sm btn-primary" ng-click="addQuestion()"><i class="fa fa-plus"></i></button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <fieldset ng-repeat="formData in formData.question">
                    <div class="card mb-3">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-11">
                                    Questions
                                </div>
                                <div class="col-md-1 d-flex justify-content-end">
                                    <button type="button" class="btn btn-sm btn-warning" ng-click="removeQuestion($index)"><i class="fa fa-times"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control txtParent" id="txtParent-{{$index}}" ng-model="formData.parentAttrib" placeholder="Enter parent attribute...">
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-outline-secondary btn-primary text-white" type="button" ng-click="addItem($index)"><i class="fa fa-plus"></i></button>
                                </div>
                            </div>
                            <fieldset ng-repeat="item in formData.items">
                                <div class="input-group mb-3">
                                    <input type="text" name="childattributequestion[]" id="txtChild-{{$parent.$index}}-{{$index}}" ng-model="item.childAttrib" class="form-control txtChild" placeholder="Enter child attribute...">
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-outline-secondary btn-danger text-white" name="remove" type="button" ng-click="removeItem($parent.$index, $index)"><i class="fa fa-minus"></i></button>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>

        <!-- <div class="card mb-3">
            <div class="card-header bg-info text-white">
                Email Message Editor
            </div>
            <div class="card-body">
                <div class="form-group">
                    <textarea name="mailEditor" id="txtEditor" ng-model="formData.mailText"></textarea>
                </div>
            </div>
        </div> -->
        <button class="btn btn-primary" type="submit">Submit</button>
    </form>


    <!-- Modal -->
    <div class="modal fade show" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Preview</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div style="margin: 0px; background: #0e0e0e; height: 100%">
                        <img class="img-fluid" src="{{source}}">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<?php
$script = '$(document).ready(function() {
                    $("textarea").summernote({
                        height: 250,   //set editable areas height
                        toolbar: [
                            ["style", ["style"]],
                            ["font", ["bold", "underline", "italic" ,"clear"]],
                            ["fontname", ["fontname"]],
                            ["color", ["color"]],
                            ["para", ["ul", "ol", "paragraph"]],
                            ["table", ["table"]],
                            ["view", ["fullscreen", "codeview", "help"]],
                          ],
                    });

                    // document.querySelector(".custom-file-input").addEventListener("change",function(e){
                    //     var fileName = document.getElementById("file").files[0].name;
                    //     var nextSibling = e.target.nextElementSibling
                    //     nextSibling.innerText = fileName
                    //   });
                });';
$this->registerJs($script, yii\web\View::POS_END, '');
?>