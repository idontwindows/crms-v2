<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\ActionColumn;
use kartik\grid\GridView;
use common\models\Functionalunit;
use Da\QrCode\QrCode;
use common\models\UnitServices;
use backend\modules\admin\components\Helper;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\Functionalunit\FunctionalunitSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

if (
    isset($_SERVER['HTTPS']) &&
    ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) ||
    isset($_SERVER['HTTP_X_FORWARDED_PROTO']) &&
    $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https'
) {
    $protocol = 'https://';
} else {
    $protocol = 'http://';
}
$serveruri = $protocol . "$_SERVER[HTTP_HOST]";

$this->title = 'Functional Units';
$this->params['breadcrumbs'][] = $this->title;



// now we can display the qrcode in many ways
// saving the result to a file:

//$qrCode->writeFile(__DIR__ . '/../../../frontend/web/administrator/qr-code/code.png'); // writer defaults to PNG when none is specified

// display directly to the browser 
// header('Content-Type: '.$qrCode->getContentType());
// echo $qrCode->writeString();
?>


<div class="functionalunit-index">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->



    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pager' => [
                'class' => \yii\bootstrap4\LinkPager::class
        ],
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],

            //'functional_unit_id',
            //'services_id',
            'unit_name',
            //'region_id',
            // 'url:url',
            [
                'attribute'=>'Url',
                'format'=>'html',
                'value'=>function ($model, $key, $index, $widget) use ($serveruri) {
                    $services = UnitServices::find()->where(['services_id' => $model->services_id])->one();
                    if($services->with_pstc_hrdc == 1){
                        return '<a href="' . $serveruri . '/site/pstc?region_id='.$model->region_id.'&unit_id='.$model->unit_id.'" target="_blank">'. $serveruri . '/site/pstc?region_id='.$model->region_id.'&unit_id='.$model->unit_id.'</a>';
                    }
                    return '<a href="'.$serveruri . $model->unit_url.'" target="_blank">'.$serveruri . $model->unit_url.'</a>';
                },
            ],
            //'date_created',
            //'is_disabled',
            //'pstc_id',
            //'hrdc_id',
            [
                'attribute' => 'QR Code',
                'format' => 'raw',
                'contentOptions' => [
                    'class' => 'kv-align-center'
                ],
                'headerOptions' => [
                    'class' => 'kv-align-center',
                    //'style' => 'text-align:center; vertical-align: middle;'
                ],
                'value' => function ($model) use ($serveruri){
                    $services = UnitServices::find()->where(['services_id' => $model->services_id])->one();
                    if($services->with_pstc_hrdc == 1){
                        $qrCode = (new QrCode($serveruri . '/site/pstc?region_id='.$model->region_id.'&unit_id='.$model->unit_id));
                    }else{
                        $qrCode = (new QrCode($serveruri . $model->unit_url));
                    }
                    
                    $qrCode->setSize(250)
                           ->setMargin(5)
                           ->useForegroundColor(51, 153, 255);
                    $qrCode->writeFile(__DIR__ . '/../../../frontend/web/administrator/qr-code/'. $model->unit_id .'_code.png');
                    return Html::a('<img src="'. $serveruri . '/administrator/qr-code/' . $model->unit_id .'_code.png' . '" width="50" height="50">',['download-qrcode','id' => $model->unit_id],['data-toggle' => 'tooltip', 'title' => 'QR Code']);
                }
            ],
            [
                'class' => 'kartik\grid\ActionColumn',
                'template' => '{view} {update}',
                'buttons' => [
                    'view' => function ($url,$model)
                    {
                        return Html::a('<span class="fas fa-eye"></span>',['view','unit_id' => $model->unit_id],['class' => 'btn btn-primary btn-sm','data-toggle' => 'tooltip', 'title' => 'update']);
                    },
                    'update' => function ($url,$model)
                    {
                        return Html::a('<span class="fas fa-edit"></span>',['update','functional_unit_id' => $model->unit_id],['class' => 'btn btn-info btn-sm','data-toggle' => 'tooltip', 'title' => 'update']);
                    }
                ], 
                // 'urlCreator' => function ($action, Functionalunit $model, $key, $index, $column) {
                //     return Url::toRoute([$action, 'functional_unit_id' => $model->functional_unit_id]);
                //  }
            ],
        ],
        'panel' => [
            'heading'=>'',
            'type'=>'primary',
            'before'=>  Html::a('<i class="fas fa-plus"></i> Create Functional Unit', ['create'], ['class' => 'btn btn-success']),
            // 'after'=>Html::a('<i class="fas fa-redo"></i> Reset Grid', ['index'], ['class' => 'btn btn-info']),
            //'footer'=>true
        ],
    ]); ?>


</div>
