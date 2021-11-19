<?php
/* @var $this yii\web\View */

use yii\helpers\Url;

$this->title = 'Unit';
$this->params['breadcrumbs'][] = $this->title;
?>
<div ng-controller="unitCtrl">
    <div class="card">
        <h5 class="card-header bg-info text-white">Units</h5>
        <div class="card-body">
            <a href="/unit/create" class="btn btn-primary mb-3">Create Unit</a>
            <table class="table">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Unit Name</th>
                        <th scope="col">URL</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody ng-init="Fetchdata()">
                    <tr ng-repeat="unit in units">
                        <th scope="row">{{ $index + 1 }}</th>
                        <td class="w-25 p-3">{{ unit.unit_name }}</td>
                        <td class="w-50 p-3"><a href="{{ unit.unit_url }}" target="_blank">{{ unit.unit_url }}</a></td>
                        <td>
                            <button type="button" class="btn btn-success btn-sm" ng-click="view(unit.unit_id)"><i class="fa fa-eye"></i></button>
                            <button type="button" class="btn btn-primary btn-sm ml-1 mr-1" ng-click="goUpdate(unit.unit_id)"><i class="fa fa-edit"></i></button>
                            <button type="button" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                        </td>

                    </tr>
                </tbody>
            </table>
            <!-- <ul uib-pagination total-items="totalItems" max-size=10 ng-model="currentPage" ng-change="pageChanged()"></ul> -->
        </div>
    </div>
</div>