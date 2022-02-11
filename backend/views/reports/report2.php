<?php
/* @var $this yii\web\View */

use function Matrix\identity;

$this->title = 'Reports';
//$this->registerJsFile('/js/createEvent.js', ['position' => \yii\web\View::POS_END]);
//$this->params['breadcrumbs'][] = ['label' => 'Unit', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

// echo yii::$app->user->identity->region_id != null ? yii::$app->user->identity->region_id : 'waley';

?>

<div ng-controller="reportsCtrl">
    <div class="row mb-2">
        <?php if(yii::$app->user->identity->region_id == null){?>
        <div class="form-group form-regions col-md-12">
            <div class="card mb-3 border-1">
                <div class="card-header">
                    <b>Regions</b>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="radio-region" ng-model="regionid" ng-value="1" id="check-region-1" ng-click="OnClickRegion(1)">
                            <label class="form-check-label font-weight-bold" for="check-region-1">RO I</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="radio-region" ng-model="regionid" ng-value="2" id="check-region-2" ng-click="OnClickRegion(2)">
                            <label class="form-check-label font-weight-bold" for="check-region-2">RO II</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="radio-region" ng-model="regionid" ng-value="3" id="check-region-3" ng-click="OnClickRegion(3)">
                            <label class="form-check-label font-weight-bold" for="check-region-3">RO III</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="radio-region" ng-model="regionid" ng-value="4" id="check-region-4" ng-click="OnClickRegion(4)">
                            <label class="form-check-label font-weight-bold" for="check-region-4">RO IV-A</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="radio-region" ng-model="regionid" ng-value="13" id="check-region-13" ng-click="OnClickRegion(13)">
                            <label class="form-check-label font-weight-bold" for="check-region-13">RO IV-B</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="radio-region" ng-model="regionid" ng-value="5" id="check-region-5" ng-click="OnClickRegion(5)">
                            <label class="form-check-label font-weight-bold" for="check-region-5">RO V</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="radio-region" ng-model="regionid" ng-value="6" id="check-region-6" ng-click="OnClickRegion(6)">
                            <label class="form-check-label font-weight-bold" for="check-region-6">RO VI</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="radio-region" ng-model="regionid" ng-value="7" id="check-region-7" ng-click="OnClickRegion(7)">
                            <label class="form-check-label font-weight-bold" for="check-region-7">RO VII</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="radio-region" ng-model="regionid" ng-value="8" id="check-region-8" ng-click="OnClickRegion(8)">
                            <label class="form-check-label font-weight-bold" for="check-region-8">RO VIII</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="radio-region" ng-model="regionid" ng-value="9" id="check-region-9"ng-click="OnClickRegion(9)">
                            <label class="form-check-label font-weight-bold" for="check-region-9">RO IX</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="radio-region" ng-model="regionid" ng-value="10"  id="check-region-10" ng-click="OnClickRegion(10)">
                            <label class="form-check-label font-weight-bold" for="check-region-10">RO X</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="radio-region" ng-model="region_id" ng-value="11" id="check-region-11" ng-click="OnClickRegion(11)">
                            <label class="form-check-label font-weight-bold" for="check-region-11">RO XI</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="radio-region" ng-model="regionid" ng-value="12" id="check-region-12" ng-click="OnClickRegion(12)">
                            <label class="form-check-label font-weight-bold" for="check-region-12">RO XII</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="radio-region" ng-model="regionid" ng-value="14" id="check-region-14" ng-click="OnClickRegion(14)">
                            <label class="form-check-label font-weight-bold" for="check-region-14">CARAGA</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="radio-region" ng-model="regionid" ng-value="15" id="check-region-15" ng-click="OnClickRegion(15)">
                            <label class="form-check-label font-weight-bold" for="check-region-15">CAR</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="radio-region" ng-model="region_id" ng-value="16" id="check-region-16" ng-click="OnClickRegion(16)">
                            <label class="form-check-label font-weight-bold" for="check-region-16">NCR</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="radio-region" ng-model="region_id" ng-value="17" id="check-region-17" ng-click="OnClickRegion(17)">
                            <label class="form-check-label font-weight-bold" for="check-region-17">ARMM</label>
                        </div>

                        <!-- <input class="form-check-input" type="radio" name="radio-region" id="check-region-18" ng-model="drivers_id" ng-value="driver.drivers_id" ng-click="OnClick(driver.drivers_id)">
                            <label class="form-check-label font-weight-bold" for="check-region-18">ROS</label> -->

                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
        <div class="form-group col-md-6">
            <div class="input-group">
                <select id="select-region" ng-model="unit_id" ng-change="OnChange()" class="form-control" ng-init="Fetchunit(regionid)">
                    <option value="" disabled selected>Select unit...</option>
                    <option ng-repeat="unit in units" value="{{ unit.unit_id }}">{{ unit.unit_name }}</option>
                </select>
            </div>
        </div>
        <div class="form-group form-client-type col-md-6">
            <!-- <label for="select-client-type"><b>Client type</b> (<span class="text-danger">Required</span>)</label> -->
            <select name="customer_client_type" ng-model="clienttype" id="select-client-type" class="form-control" ng-change="OnChange()">
                <option value="" disabled selected>Select Client type...</option>
                <option value="2">Internal</option>
                <option value="5">External</option>
                <option value="6">All</option>
            </select>
        </div>
        <div class="col-md-6">
            <div class="datepicker date input-group" data-date="{{ datefrom }}">
                <input type="text" placeholder="From" name="datefrom" ng-change="OnChange()" ng-model='datefrom' class="form-control" id="txtDateFrom">
                <div class="input-group-append">
                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                </div>
                <!-- <div class="invalid-feedback">{{errormessagedate}}</div> -->
            </div>
        </div>
        <div class="col-md-6">
            <div class="datepicker date input-group" data-date="{{ dateto }}">
                <input type="text" placeholder="To" name="dateto" ng-model="dateto" ng-change="OnChange()" class="form-control" id="txtDateTo">
                <div class="input-group-append">
                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                </div>
                <!-- <div class="invalid-feedback">{{errormessagedate}}</div> -->
            </div>
        </div>
        <div class="form-group form-driver col-md-12 mt-3" ng-if="showDrivers">
            <div class="card mb-3 border-1">
                <div class="card-header">
                    <b>Select Driver</b>
                </div>
                <div class="card-body">
                    <div class="form-group"  ng-init="Fetchdrivers(regionid)">
                        <div class="form-check form-check-inline" ng-repeat="driver in drivers">
                            <input class="form-check-input" type="radio" name="drivers_name" id="check-driver-{{ $index }}" ng-model="drivers_id" ng-value="driver.drivers_id" ng-click="OnClick(driver.drivers_id)">
                            <label class="form-check-label font-weight-bold" for="check-driver-{{ $index }}">{{ driver.drivers_name }}</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- <div class="row">
        <div class="col-md-6">
            <div class="btn-group mb-2">
                <div class="bg-primary rounded-left text-white d-flex justify-content-center align-items-center" style="height:38px; width:170px; font-size:17px;"><b>RESPONDENT</b></div>
                <div class="bg-warning dropdown-toggle-split rounded-right d-flex justify-content-center align-items-center" style="font-size:17px;"><b>{{ respondent.length }}</b></div>
            </div>
        </div>
        <div class="col-md-6">
            <button type="button" class="btn btn-success pull-right" ng-click="OnExport(unit_id,datefrom,dateto)">Export to Ecxel</button>
        </div>
    </div> -->

    <table class="table border">
        <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Attribute</th>
                <th scope="col" class="text-md-center">outstanding</th>
                <th scope="col" class="text-md-center">Very Satisfactory</th>
                <th scope="col" class="text-md-center">Satisfactory</th>
                <th scope="col" class="text-md-center">Unsatisfactory</th>
                <th scope="col" class="text-md-center">Poor</th>
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
    <div class="row">
        <div class="col-xl-6 col-md-6">
            <div class="card bg-primary text-white mb-4">
                <div class="card-body d-inline-block">
                    <div class="d-inline-block font-weight-bold">Total No of Customers/Respondents:</div>
                    <div class="d-inline-block font-weight-bold">{{ respondent.length }}</div>
                </div>
                <!-- <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="#">View Details</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div> -->
            </div>
        </div>
        <div class="col-xl-6 col-md-6">
            <div class="card bg-info text-white mb-4">
                <div class="card-body">
                    <div class="d-inline-block font-weight-bold">
                        Total Customers who Rated Very Satisfactory (VS) and Outstanding:
                    </div>
                    <div class="d-inline-block font-weight-bold">
                        {{ totalOutstanding }}
                    </div>
                </div>
                <!-- <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="#">View Details</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div> -->
            </div>
        </div>
        <div class="col-xl-6 col-md-6">
            <div class="card bg-danger text-white mb-4">
                <div class="card-body">
                    <div class="d-inline-block font-weight-bold">
                        % of Customer Rated Very Satisfactory (VS) and Outstanding:
                    </div>
                    <div class="d-inline-block font-weight-bold">
                        {{ percentOutstanding | number:2}} %
                    </div>
                </div>
                <!-- <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="#">View Details</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div> -->
            </div>
        </div>
        <div class="col-xl-6 col-md-6">
            <div class="card bg-success text-white mb-4">
                <div class="card-body">
                    <div class="d-inline-block font-weight-bold">
                        Overall Satisfaction Rating:
                    </div>
                    <div class="d-inline-block font-weight-bold">
                        {{ satisfactionRating | number:2 }} %
                    </div>

                </div>
                <!-- <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="#">View Details</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div> -->
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4" ng-show="reports.feedbacks.length >= 1">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-chart-pie mr-1"></i>
                    {{ reports.feedbacks[0].question }}
                </div>
                <div class="card-body"><canvas id="myPieChart-1" width="100%" height="50"></canvas></div>
                <!-- <div class="card-footer small text-muted"></div> -->
            </div>
        </div>
        <div class="col-lg-4" ng-show="reports.feedbacks.length >= 2">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-chart-pie mr-1"></i>
                    {{ reports.feedbacks[1].question }}
                </div>
                <div class="card-body"><canvas id="myPieChart-2" width="100%" height="50"></canvas></div>
                <!-- <div class="card-footer small text-muted"></div> -->
            </div>
        </div>
        <div class="col-lg-4" ng-show="reports.feedbacks.length >= 3">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-chart-pie mr-1"></i>
                    {{ reports.feedbacks[2].question }}
                </div>
                <div class="card-body"><canvas id="myPieChart-3" width="100%" height="50"></canvas></div>
                <!-- <div class="card-footer small text-muted"></div> -->
            </div>
        </div>
        <div class="col-lg-4" ng-show="reports.feedbacks.length >= 4">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-chart-pie mr-1"></i>
                    {{ reports.feedbacks[3].question }}
                </div>
                <div class="card-body"><canvas id="myPieChart-4" width="100%" height="50"></canvas></div>
                <!-- <div class="card-footer small text-muted"></div> -->
            </div>
        </div>
        <div class="col-lg-4" ng-show="reports.feedbacks.length >= 5">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-chart-pie mr-1"></i>
                    {{ reports.feedbacks[4].question }}
                </div>
                <div class="card-body"><canvas id="myPieChart-5" width="100%" height="50"></canvas></div>
                <!-- <div class="card-footer small text-muted"></div> -->
            </div>
        </div>
        <div class="col-lg-4" ng-show="reports.feedbacks.length >= 6">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-chart-pie mr-1"></i>
                    {{ reports.feedbacks[5].question }}
                </div>
                <div class="card-body"><canvas id="myPieChart-6" width="100%" height="50"></canvas></div>
                <!-- <div class="card-footer small text-muted"></div> -->
            </div>
        </div>
        <div class="col-lg-4" ng-show="reports.feedbacks.length >= 7">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-chart-pie mr-1"></i>
                    {{ reports.feedbacks[6].question }}
                </div>
                <div class="card-body"><canvas id="myPieChart-7" width="100%" height="50"></canvas></div>
                <!-- <div class="card-footer small text-muted"></div> -->
            </div>
        </div>
        <div class="col-lg-4" ng-show="reports.feedbacks.length >= 8">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-chart-pie mr-1"></i>
                    {{ reports.feedbacks[7].question }}
                </div>
                <div class="card-body"><canvas id="myPieChart-8" width="100%" height="50"></canvas></div>
                <!-- <div class="card-footer small text-muted"></div> -->
            </div>
        </div>
    </div>

    <table class="table border">
        <thead class="thead-dark">
            <tr>
                <th scope="col">Comments</th>
            </tr>
        </thead>
        <tbody ng-init="Fetchdata()">
            <tr ng-repeat="report in reports.comments">
                <td>{{ report.comments }}</td>
            </tr>
        </tbody>
    </table>
</div>
<style>
    .emoticons {
        width: 30px;
        height: 30px;
    }
</style>