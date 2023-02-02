<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use kartik\grid\GridView;
use kartik\date\DatePicker;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

// use kartik\icons\FontAwesomeAsset;
// FontAwesomeAsset::register($this);

/* @var $this yii\web\View */
/* @var $searchModel backend\models\SearchTmpRating */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Customer Satisfaction Index';
$this->params['breadcrumbs'][] = $this->title;

$countComments = 0;
$countComplaints = 0;
foreach ($comments as $comment) {
    if ($comment['is_complaint'] != 1) {
        $countComments++;
    } else {
        $countComplaints++;
    }
}

?>
<div class="tmp-rating-index">
    <div>
        <h3 class="text-center">CUSTOMER SATISFACTION FEEDBACK</h3>
    </div>
    <div>
        <h5 class="text-center">SUMMARY REPORT FOR JULY 2022</h5>
    </div>

    <div class="card mb-3 mt-0 border-0 rounded">
        <ul class="list-group list-group-flush">
            <li class="list-group-item"><b>SERVICES:&emsp;&emsp;&emsp;&emsp;<?= $service_unit->services->services_name ?></b></li>
            <li class="list-group-item"><b>SERVICE UNIT:&emsp;&ensp;&nbsp;<?= $service_unit->service_unit_name ?></b> </li>
            <?php
            if (isset($_GET['pstc_id'])) {
                echo '<li class="list-group-item"><b>PSTC:</b> </li>';
            }
            ?>
        </ul>
    </div>

    <?php $form = ActiveForm::begin([
        'method' => 'post',
        'action' => isset($_GET['pstc_id']) ?
            ['index', 'service_unit_id' => $_GET['service_unit_id'], 'region_id' => $_GET['region_id'], 'pstc_id' => $_GET['pstc_id']] : (isset($_GET['driver_id']) ?
                ['index', 'service_unit_id' => $_GET['service_unit_id'], 'region_id' => $_GET['region_id'], 'driver_id' => $_GET['driver_id']] :
                ['index', 'service_unit_id' => $_GET['service_unit_id'], 'region_id' => $_GET['region_id']]),
    ]); ?>
    <div class="card mb-3 mt-0 border-0 rounded">
        <div class="mb-3 mt-3 mr-3 ml-3">
            <?php // echo $this->render('_search', ['model' => $searchModel]); 
            ?>
            <div>

                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    // 'filterModel' => $searchModel,
                    'options' => ['style' => 'width: 100%;'],
                    'summary' => '',
                    'columns' => [
                        'attribute',
                        'vsatisfied',
                        'five',
                        'satisfied',
                        'four',
                        'neither',
                        'three',
                        'dissatisfied',
                        'two',
                        'vdissatisfied',
                        'one',
                        'total_score',
                        'ss',
                        'gap',
                    ],
                    'panel' => [
                        'heading' => 'PART I: CUSTOMER RATING OF SERVICE QUALITY ',
                        'type' => 'secondary',
                        // 'after'=>Html::a('<i class="fas fa-redo"></i> Reset Grid', ['index'], ['class' => 'btn btn-info']),
                        //'footer'=>true
                    ],
                    'toolbar' => false
                ]); ?>
            </div>

            <div class="mt-3">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider2,
                    'options' => ['style' => 'width: 100%;'],
                    // 'filterModel' => $searchModel,
                    'summary' => '',
                    'columns' => [
                        'attribute',
                        'vimportant',
                        'five',
                        'important',
                        'four',
                        'moderately',
                        'three',
                        'slightly',
                        'two',
                        'notall',
                        'one',
                        'total_score',
                        'is',
                        'wf',
                        'ss',
                        'ws'
                    ],
                    'panel' => [
                        'heading' => 'PART II: IMPORTANT OF THIS ATTRIBUTE',
                        'type' => 'secondary',
                        // 'after'=>Html::a('<i class="fas fa-redo"></i> Reset Grid', ['index'], ['class' => 'btn btn-info']),
                        //'footer'=>true
                    ],
                    'toolbar' => false
                ]); ?>
            </div>
            <!-- <div class="row mt-3">
                <div class="col-sm-6">
                    <div class="card bg-primary text-white mb-4">
                        <div class="card-body d-inline-block">
                            <div class="d-inline-block font-weight-bold">Total No of Customers/Respondents:&nbsp;</div>
                            <div class="d-inline-block font-weight-bold"><span class="badge badge-light"><b><?= $satIndex['respondent_number'] ?></b></span></div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="card bg-info text-white mb-4">
                        <div class="card-body d-inline-block">
                            <div class="d-inline-block font-weight-bold">% of Promotters:&nbsp;</div>
                            <div class="d-inline-block font-weight-bold"><span class="badge badge-light"><b><?= $satIndex['promoters'] ?>%</b></span></div>
                            <div class="d-inline-block font-weight-bold">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;% of Detractors:&nbsp;</div>
                            <div class="d-inline-block font-weight-bold"><span class="badge badge-light"><b><?= $satIndex['detractors'] ?>%</b></span></div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="card bg-danger text-white mb-4">
                        <div class="card-body d-inline-block">
                            <div class="d-inline-block font-weight-bold">Total Number of Satisfied Responses (VS & S):&nbsp;</div>
                            <div class="d-inline-block font-weight-bold"><span class="badge badge-light"><b><?= $satIndex['vss'] ?></b></span></div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="card bg-danger text-white mb-4">
                        <div class="card-body d-inline-block">
                            <div class="d-inline-block font-weight-bold">Net Promoters Score:&nbsp;</div>
                            <div class="d-inline-block font-weight-bold"><span class="badge badge-light"><b><?= $satIndex['promoters'] - $satIndex['detractors'] ?>%</b></span></div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="card bg-success text-white mb-4">
                        <div class="card-body d-inline-block">
                            <div class="d-inline-block font-weight-bold">CSAT Score:&nbsp;</div>
                            <div class="d-inline-block font-weight-bold"><span class="badge badge-light"><b><?= $satIndex['csat_score'] ?>%</b></span></div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="card bg-success text-white mb-4">
                        <div class="card-body d-inline-block">
                            <div class="d-inline-block font-weight-bold">Customer Satisfaction Index:&nbsp;</div>
                            <div class="d-inline-block font-weight-bold"><span class="badge badge-light"><b><?= $satIndex['satisfaction_index'] <= 100 ?  $satIndex['satisfaction_index'] : 100 ?>%</b></span></div>
                        </div>
                    </div>
                </div>
            </div> -->

            <table style="width:100%; border-collapse:collapse;" class="mt-5">
                <tr>
                    <td style="width:38%; border:1px solid black; padding:8px; background-color:powderblue;"><b>Total No of Customers/Respondents:</b></td>
                    <td style="width:10%; border:1px solid black; padding:8px; text-align:center"><b><?= $satIndex['respondent_number'] ?></b></td>
                    <td style="width:4%;">&nbsp;</td>
                    <td style="width:14%; border:1px solid black; padding:8px; background-color:powderblue;"><b>% of Promoters:</b></td>
                    <td style="width:10%; border:1px solid black; padding:8px; text-align:center"><b><?= $satIndex['promoters'] ?>%</b></td>
                    <td style="width:14%; border:1px solid black; padding:8px; background-color:powderblue;"><b>% of Detrators:</b></td>
                    <td style="width:10%; border:1px solid black; padding:8px; text-align:center"><b><?= $satIndex['detractors'] ?>%</b></td>
                </tr>
            </table>

            <table style="width:100%; border-collapse:collapse;" class="mt-3">
                <tr>
                    <td style="width:38%; border:1px solid black; padding:8px; background-color:powderblue;"><b>Total Score of Satisfied Response (VS & S):</b></td>
                    <td style="width:10%; border:1px solid black; padding:8px; text-align:center"><b><?= $satIndex['vss_score'] ?></b></td>
                    <td style="width:4%;">&nbsp;</td>
                    <td style="width:38%; border:1px solid black; padding:8px; background-color:powderblue;"><b>Net Promoter Score:</b></td>
                    <td style="width:10%; border:1px solid black; padding:8px; text-align:center"><b><?= $satIndex['promoters'] - $satIndex['detractors'] ?>%</b></td>
                </tr>
            </table>

            <table style="width:100%; border-collapse:collapse;" class="mt-3 mb-5">
                <tr>
                    <td style="width:38%; border:1px solid black; padding:8px; background-color:powderblue;"><b>Customer Satisfation Score (CSAT) Rating:</b></td>
                    <td style="width:10%; border:1px solid black; padding:8px; text-align:center"><b><?= $satIndex['csat_score'] ?>%</b></td>
                    <td style="width:4%;">&nbsp;</td>
                    <td style="width:38%; border:1px solid black; padding:8px; background-color:powderblue;"><b>Customer Satisfation Index:</b></td>
                    <td style="width:10%; border:1px solid black; padding:8px; text-align:center"><b><?= $satIndex['satisfaction_index'] <= 100 ?  $satIndex['satisfaction_index'] : 100 ?>%</b></td>
                </tr>
            </table>




            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Comments and Complaints</h5>
                    <h6 class="card-subtitle mb-2 text-muted">Comments <span class="badge badge-primary"><?= $countComments ?></span> Complaints <span class="badge badge-danger"><?= $countComplaints ?></span></h6>
                    <?php foreach ($comments as $comment) { ?>
                        <?php if ($comment['is_complaint'] != 1) { ?>
                            <div class="alert alert-primary" role="alert">
                                <?= $comment['comment'] ?>
                            </div>
                        <?php } else { ?>
                            <div class="alert alert-danger" role="alert">
                                <?= $comment['comment'] ?>
                            </div>
                        <?php } ?>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>