<?php

$this->title = 'Create';
//$this->registerJsFile('/js/createEvent.js', ['position' => \yii\web\View::POS_END]);
$this->params['breadcrumbs'][] = ['label' => 'Events', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div ng-controller="CreateEventCtrl">
    <form method="post" ng-submit="submitForm()">
        <div class="card mb-2">
            <div class="card-header bg-info text-white">
                Event
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="txtEmail"><b>Event Name</b></label>
                        <input type="text" class="form-control" ng-model="formData.event" id="txtEvent" name="event" placeholder="Type event name here..." autofocus="" aria-required="true" aria-invalid="">
                        <!-- <div class="invalid-feedback">{{errormessageevent}}</div> -->
                    </div>

                    <div class="form-group col-md-6">
                        <label for="txtDate"><b>Event Date</b></label>
                        <div class="datepicker date input-group">
                            <input type="text" placeholder="Choose Date" name="date" ng-model="formData.date" class="form-control" id="txtDate">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                            </div>
                            <!-- <div class="invalid-feedback">{{errormessagedate}}</div> -->
                        </div>                      
                    </div>
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

        <div class="card mb-3">
            <div class="card-header bg-info text-white">
                <div class="row">
                    <div class="col-md-11">
                        Certificate
                    </div>
                    <div class="col-md-1 d-flex justify-content-end">

                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="customCheck1">
                            <label class="custom-control-label" for="customCheck1"></label>
                        </div>

                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="custom-file">
                    <input type="file" class="custom-file-input" name='file' id="file" ng-file="uploadfiles" accept="image/jpeg">
                    <label class="custom-file-label" for="validatedCustomFile">Choose file...</label>
                    <div class="invalid-feedback">Example invalid custom file feedback</div>
                </div>
                <div class="form-inline mt-2">
                    <div class="form-group mb-2">
                        <label for="inputFontsize" class="sr-only">Font Size</label>
                        <input type="number" class="form-control" id="inputFontsize" ng-model="formData.fontsize" placeholder="Font size">
                    </div>
                    <div class="form-group mx-sm-3 mb-2">
                        <label for="inputYAxis" class="sr-only">Y-Axis</label>
                        <input type="number" class="form-control" id="inputYAxis" ng-model="formData.yaxis" placeholder="Y-Axis">
                    </div>
                    <button type="button" class="btn btn-primary mb-2" data-toggle="modal" ng-click="upload()" data-target="#exampleModalCenter">Preview</button>
                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header bg-info text-white">
                Email Message Editor
            </div>
            <div class="card-body">
                <div class="form-group">
                    <textarea name="mailEditor" id="txtEditor" ng-model="formData.mailText"></textarea>
                </div>
            </div>
        </div>
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

                    document.querySelector(".custom-file-input").addEventListener("change",function(e){
                        var fileName = document.getElementById("file").files[0].name;
                        var nextSibling = e.target.nextElementSibling
                        nextSibling.innerText = fileName
                      });
                });';
$this->registerJs($script, yii\web\View::POS_END, '');
?>