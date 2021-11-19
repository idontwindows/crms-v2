<?php
$this->title = 'View';
//$this->registerJsFile('/js/createEvent.js', ['position' => \yii\web\View::POS_END]);
$this->params['breadcrumbs'][] = ['label' => 'Events', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div ng-controller="CustomerCtrl">
  <div class="card">
    <h5 class="card-header bg-info text-white">Customer</h5>
    <div class="card-body">
      <table class="table" ng-init="fetchData(<?= $event_id?>)">
        <thead class="thead-dark">
          <tr>
            <th scope="col">#</th>
            <th scope="col">Customer Name</th>
            <th scope="col">Email</th>
            <th scope="col">Login Date</th>
            <th scope="col"></th>
          </tr>
        </thead>
        <tbody ng-repeat="data in datas">
          <tr>
            <th scope="row">{{ $index + 1 }}</th>
            <td>{{data.customer_name}}</td>
            <td>{{data.email}}</td>
            <td>{{data.date}}</td>
            <td><button type="button" id="btn-drilldown-{{$index}}" class="btn btn-primary btn-sm" ng-click="drilldown($index)"><i class="fa fa-plus"></i></button></td>
          </tr>
          <!--drill down table-->
          <tr ng-show="data.drilldown">
            <td colspan="5">
              <table class="table">
                <tbody ng-repeat="question in data.questions">
                  <tr>
                    <td scope="col" class="bg-info" colspan="2"><b>{{question.parentAttrib}}</b></td>
                  </tr>
                  <tr ng-repeat="item in question.items">
                    <td>{{item.childAttrib}}</td>
                    <th>{{item.score}}</th>
                  </tr>
                </tbody>
              </table>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>