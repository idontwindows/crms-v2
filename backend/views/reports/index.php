<?php
/* @var $this yii\web\View */
$this->title = 'Reports';
//$this->registerJsFile('/js/createEvent.js', ['position' => \yii\web\View::POS_END]);
//$this->params['breadcrumbs'][] = ['label' => 'Unit', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div ng-controller="reportsCtrl">
    <div class="row mb-2">
        <div class="form-group col-md-4">
            <div class="input-group">
                <select id="select-region" ng-model="unit_id" ng-change="OnChange()" class="form-control" ng-init="Fetchunit()">
                    <option value="" disabled selected>Select unit...</option>
                    <option ng-repeat="unit in units" value="{{ unit.unit_id }}">{{ unit.unit_name }}</option>
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="datepicker date input-group" data-date="{{ datefrom }}">
                <input type="text" placeholder="From" name="datefrom" ng-change="OnChange()" ng-model='datefrom' class="form-control" id="txtDateFrom">
                <div class="input-group-append">
                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                </div>
                <!-- <div class="invalid-feedback">{{errormessagedate}}</div> -->
            </div>
        </div>
        <div class="col-md-4">
            <div class="datepicker date input-group" data-date="{{ dateto }}">
                <input type="text" placeholder="To" name="dateto" ng-model="dateto" ng-change="OnChange()" class="form-control" id="txtDateTo">
                <div class="input-group-append">
                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                </div>
                <!-- <div class="invalid-feedback">{{errormessagedate}}</div> -->
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class='font-weight-bold mt-2'>
                <h4><span class='text-primary'>RESPONDENT:</span> {{ respondent.length }}</h4>
            </div>
        </div>
        <div class="col-md-6">
            <button type="button" class="btn btn-success pull-right" ng-click="OnExport(unit_id,datefrom,dateto)">Export to Ecxel</button>
        </div>
    </div>

    <table class="table ">
        <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Attribute</th>
                <th scope="col" class="text-md-center"><img class="emoticons" src="/images/grinning.svg" alt="5"></th>
                <th scope="col" class="text-md-center"><img class="emoticons" src="/images/smile.svg" alt="4"></th>
                <th scope="col" class="text-md-center"><img class="emoticons" src="/images/neutral.svg" alt="3"></th>
                <th scope="col" class="text-md-center"><img class="emoticons" src="/images/sad.svg" alt="2"></th>
                <th scope="col" class="text-md-center"><img class="emoticons" src="/images/angry.svg" alt="1"></th>
            </tr>
        </thead>
        <tbody ng-init="Fetchdata()">
            <tr ng-repeat="report in reports.feedbacks">
                <th scope="row">{{ $index + 1 }}</th>
                <td class="w-50 p-3">{{ report.question }}</td>
                <td class="text-md-center">{{ report.rating5 }}</td>
                <td class="text-md-center">{{ report.rating4 }}</td>
                <td class="text-md-center">{{ report.rating3 }}</td>
                <td class="text-md-center">{{ report.rating2 }}</td>
                <td class="text-md-center">{{ report.rating1 }}</td>
            </tr>
        </tbody>
    </table>

    <table class="table ">
        <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Importance of Attribute</th>
                <th scope="col" class="text-md-center"><img class="emoticons" src="/images/grinning.svg" alt="5"></th>
                <th scope="col" class="text-md-center"><img class="emoticons" src="/images/smile.svg" alt="4"></th>
                <th scope="col" class="text-md-center"><img class="emoticons" src="/images/neutral.svg" alt="3"></th>
                <th scope="col" class="text-md-center"><img class="emoticons" src="/images/sad.svg" alt="2"></th>
                <th scope="col" class="text-md-center"><img class="emoticons" src="/images/angry.svg" alt="1"></th>
            </tr>
        </thead>
        <tbody ng-init="Fetchdata()">
            <tr ng-repeat="report in reports.importance">
                <th scope="row">{{ $index + 1 }}</th>
                <td class="w-50 p-3">{{ report.question }}</td>
                <td class="text-md-center">{{ report.rating5 }}</td>
                <td class="text-md-center">{{ report.rating4 }}</td>
                <td class="text-md-center">{{ report.rating3 }}</td>
                <td class="text-md-center">{{ report.rating2 }}</td>
                <td class="text-md-center">{{ report.rating1 }}</td>
            </tr>
        </tbody>
    </table>
    <div class="card">
        <div class="card-header bg-primary text-white font-weight-bold">
            Net Promoters
        </div>
        <table class="table ">
            <thead class="thead-dark">
                <tr>
                    <!-- <th scope="col">#</th>
                <th scope="col">Importance of Attribute</th> -->
                    <th scope="col" class="text-md-center">1</th>
                    <th scope="col" class="text-md-center">2</th>
                    <th scope="col" class="text-md-center">3</th>
                    <th scope="col" class="text-md-center">4</th>
                    <th scope="col" class="text-md-center">5</th>
                    <th scope="col" class="text-md-center">6</th>
                    <th scope="col" class="text-md-center">7</th>
                    <th scope="col" class="text-md-center">8</th>
                    <th scope="col" class="text-md-center">9</th>
                    <th scope="col" class="text-md-center">10</th>
                </tr>
            </thead>
            <tbody ng-init="Fetchdata()">
                <tr ng-repeat="report in reports.nps">
                    <!-- <th scope="row">{{ $index + 1 }}</th> -->
                    <!-- <td class="w-50 p-3">{{ report.question }}</td> -->
                    <td class="text-md-center">{{ report.score1 }}</td>
                    <td class="text-md-center">{{ report.score2 }}</td>
                    <td class="text-md-center">{{ report.score3 }}</td>
                    <td class="text-md-center">{{ report.score4 }}</td>
                    <td class="text-md-center">{{ report.score5 }}</td>
                    <td class="text-md-center">{{ report.score6 }}</td>
                    <td class="text-md-center">{{ report.score7 }}</td>
                    <td class="text-md-center">{{ report.score8 }}</td>
                    <td class="text-md-center">{{ report.score9 }}</td>
                    <td class="text-md-center">{{ report.score10 }}</td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-end" ng-init="Fetchdata()">
        <div class="bg-info" ng-repeat="report in reports.nps">
            <h4 class="ml-1 mr-1 text-white font-weight-bold">NPS: {{report.nps|number:0}}</h4>
        </div>
    </div>
    
    
    
    <table class="table mt-5">
        <thead class="thead-dark">
            <tr>
                <!-- <th scope="col">#</th> -->
                <th scope="col">Comments</th>
            </tr>
        </thead>
        <tbody ng-init="Fetchdata()">
            <tr ng-repeat="report in reports.comments">
                <!-- <th scope="row">{{ $index + 1 }}</th> -->
                <td>{{ report.comments }}</td>
            </tr>
        </tbody>
    </table>
    <div>

    </div>
</div>
<style>
    .emoticons {
        width: 30px;
        height: 30px;
    }
</style>