<?php
/* @var $this yii\web\View */

use yii\helpers\Url;

$this->title = 'Events';
$this->params['breadcrumbs'][] = $this->title;
?>
<div ng-controller="eventCtrl">
    <div class="card">
        <h5 class="card-header bg-info text-white">Event</h5>
        <div class="card-body">
            <a href="/events/create" class="btn btn-primary mb-3">Create Event</a>
            <table class="table">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Event Name</th>
                        <th scope="col">URL</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody ng-init="Fetchdata()">
                    <tr ng-repeat="event in events">
                        <th scope="row">{{ $index + 1 }}</th>
                        <td class="w-25 p-3">{{ event.event_name }}</td>
                        <td class="w-50 p-3"><a href="{{ event.event_url }}" target="_blank">{{ event.event_url }}</a></td>
                        <td>
                            <button type="button" class="btn btn-success btn-sm" ng-click="view(event.event_id)"><i class="fa fa-eye"></i></button>
                            <button type="button" class="btn btn-primary btn-sm ml-1 mr-1"><i class="fa fa-edit"></i></button>
                            <button type="button" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                        </td>

                    </tr>
                </tbody>
            </table>
            <!-- <ul uib-pagination total-items="totalItems" max-size=10 ng-model="currentPage" ng-change="pageChanged()"></ul> -->
        </div>
    </div>
</div>