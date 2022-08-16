<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use kartik\grid\GridView;
use kartik\date\DatePicker;
use yii\widgets\ActiveForm;

// use kartik\icons\FontAwesomeAsset;
// FontAwesomeAsset::register($this);

/* @var $this yii\web\View */
/* @var $searchModel backend\models\SearchTmpRating */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Customer Satisfaction Index';
$this->params['breadcrumbs'][] = $this->title;

$date1 = empty($datefrom) ? '' : date_format($datefrom, 'd-M-Y');
$date2 = empty($dateto) ? '' : date_format($dateto, 'd-M-Y');

//echo $satIndex["satisfaction_index"];

$this->registerJs("$('#date').val('" . $date1 . "');
$('#date-2').val('" . $date2 . "');");

$layout = <<< HTML
<div class="input-group-prepend">
    <span class="input-group-text">Date From</span>
</div>
{input1}
<!-- <div class="input-group-prepend">
    <span class="input-group-text">aft</span>
</div>
{separator} -->
<div class="input-group-prepend">
    <span class="input-group-text">Date To</span>
</div>
{input2}
<div class="input-group-prepend">
        <button class="btn btn-outline-secondary btn-success text-white" type="submit">Generate</button>
</div>
HTML;


?>
<div class="tmp-rating-index">
    <div class="card mb-3 mt-0 border-0 rounded shadow-lg">
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
        ['index', 'service_unit_id' => $_GET['service_unit_id'], 'region_id' => $_GET['region_id'], 'pstc_id' => $_GET['pstc_id']] :
        (isset($_GET['driver_id']) ? 
        ['index', 'service_unit_id' => $_GET['service_unit_id'], 'region_id' => $_GET['region_id'], 'driver_id' => $_GET['driver_id']] : 
        ['index', 'service_unit_id' => $_GET['service_unit_id'], 'region_id' => $_GET['region_id']]),
    ]); ?>
    <div class="card mb-3 mt-0 border-0 rounded shadow-lg">
        <div class="mb-3 mt-3 mr-3 ml-3">
            <div class="row">
                <div class="col-xl-6 col-md-6">
                    <div class="mb-2">
                        <?php
                        echo DatePicker::widget([
                            'type' => DatePicker::TYPE_RANGE,
                            'name' => 'datefrom',
                            'id' => 'date',
                            'value' => '',
                            'name2' => 'dateto',
                            'value2' => '',
                            'separator' => '<i class="fas fa-arrows-alt-h"></i>',
                            'layout' => $layout,
                            'pluginOptions' => [
                                'autoclose' => true,
                                'format' => 'dd-M-yyyy'
                            ]
                        ]);
                        ?>
                    </div>
                </div>
                <div class="col-xl-6 col-md-6 text-right">
                    <div class="form-group">
                        <?= Html::button('<i class="fas fa-print"></i> Print', ['class' => 'btn btn-warning']) ?>
                    </div>
                </div>
            </div>


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
            <div class="row mt-3">
                <div class="col-xl-6 col-md-6">
                    <div class="card bg-primary text-white mb-4">
                        <div class="card-body d-inline-block">
                            <div class="d-inline-block font-weight-bold">Total No of Customers/Respondents:&nbsp;</div>
                            <div class="d-inline-block font-weight-bold"><span class="badge badge-light"><b><?= $satIndex['respondent_number'] ?></b></span></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-md-6">
                    <div class="card bg-success text-white mb-4">
                        <div class="card-body d-inline-block">
                            <div class="d-inline-block font-weight-bold">Customer Satisfaction Index:&nbsp;</div>
                            <div class="d-inline-block font-weight-bold"><span class="badge badge-light"><b><?= $satIndex['satisfaction_index'] <= 100 ?  $satIndex['satisfaction_index'] : 100 ?>%</b></span></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-md-6">
                    <div class="card bg-info text-white mb-4">
                        <div class="card-body d-inline-block">
                            <div class="d-inline-block font-weight-bold">% of Promotters:&nbsp;</div>
                            <div class="d-inline-block font-weight-bold"><span class="badge badge-light"><b><?= $satIndex['promoters'] ?>%</b></span></div>
                            <div class="d-inline-block font-weight-bold">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;% of Detractors:&nbsp;</div>
                            <div class="d-inline-block font-weight-bold"><span class="badge badge-light"><b><?= $satIndex['detractors'] ?>%</b></span></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-md-6">
                    <div class="card bg-danger text-white mb-4">
                        <div class="card-body d-inline-block">
                            <div class="d-inline-block font-weight-bold">Net Promoters Score:&nbsp;</div>
                            <div class="d-inline-block font-weight-bold"><span class="badge badge-light"><b><?= $satIndex['promoters'] - $satIndex['detractors'] ?>%</b></span></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-md-6">
                    <div class="card bg-danger text-white mb-4">
                        <div class="card-body d-inline-block">
                            <div class="d-inline-block font-weight-bold">CSAT Score:&nbsp;</div>
                            <div class="d-inline-block font-weight-bold"><span class="badge badge-light"><b><?= $satIndex['csat_score']?>%</b></span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>