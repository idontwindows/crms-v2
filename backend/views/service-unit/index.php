<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use common\models\ServiceUnit;
use kartik\grid\GridView;
use yii\bootstrap4\Modal;
use backend\modules\admin\components\Helper;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ServiceUnitSearch */
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

$this->title = 'Service Units';
$this->params['breadcrumbs'][] = $this->title;



Modal::begin([
    'title' => $this->title,
    'id' => 'modal',
    'size' => 'modal-lg',
]);

echo '<div id="modal-content"></div>';

Modal::end();
?>

<style>
    .kv-grouped-row {
        background-color: #c3f0f6 !important;
        font-size: 1.3em;
        padding-top: 10px !important;
        padding-bottom: 10px !important;
    }
</style>

<div class="service-unit-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pager' => [
            'class' => \yii\bootstrap4\LinkPager::class
        ],
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],

            // 'service_unit_id',
            // 'services_id',
            [
                'attribute' => 'services_id',
                'width' => '310px',
                'value' => function ($model, $key, $index, $widget) {
                    return $model->services->services_name;
                },
                // 'filterType' => GridView::FILTER_SELECT2,
                // 'filter' => ArrayHelper::map(Suppliers::find()->orderBy('company_name')->asArray()->all(), 'id', 'company_name'), 
                // 'filterWidgetOptions' => [
                //     'pluginOptions' => ['allowClear' => true],
                // ],
                // 'filterInputOptions' => ['placeholder' => 'Any supplier'],
                'group' => true,  // enable grouping,
                'groupedRow' => true,                    // move grouped column to a single grouped row
                'groupOddCssClass' => 'kv-grouped-row',  // configure odd group cell css class
                'groupEvenCssClass' => 'kv-grouped-row', // configure even group cell css class
            ],
            'service_unit_name',
            // 'is_parent',
            // 'is_child',
            //'parent_id',
            //'is_with_pstc',
            [
                'class' => 'kartik\grid\ActionColumn',
                'template' => '{view}',
                'buttons' => [
                    'view' => function ($url, $model) {
                        if ($model->is_parent == true) {
                            return Html::a('<span class="fas fa-eye"></span> View', ['sub-unit', 'service_unit_id' => $model->service_unit_id], ['class' => 'btn btn-primary btn-sm', 'data-toggle' => 'tooltip', 'title' => 'view']);
                        }
                        if ($model->is_with_pstc == true) {
                            return Html::a('<span class="fas fa-eye"></span> View', ['pstc', 'service_unit_id' => $model->service_unit_id], ['class' => 'btn btn-primary btn-sm', 'data-toggle' => 'tooltip', 'title' => 'view']);
                        }
                        return Html::button('<span class="fas fa-eye"></span> View', ['value' => Url::to(['service-unit/view', 'service_unit_id' => $model->service_unit_id]), 'class' => 'btn btn-primary btn-sm button-view', 'id' => 'button-view']);
                    },
                    // 'update' => function ($url,$model)
                    // {
                    //     return Html::a('<span class="fas fa-edit"></span>',['update','functional_unit_id' => $model->unit_id],['class' => 'btn btn-info btn-sm','data-toggle' => 'tooltip', 'title' => 'update']);
                    // }
                ],
                // 
                // 'urlCreator' => function ($action, ServiceUnit $model, $key, $index, $column) {
                //     return Url::toRoute([$action, 'service_unit_id' => $model->service_unit_id]);
                //  }
            ],
        ],
        'panel' => [
            'heading' => '',
            'type' => 'primary',
            'before' => Helper::checkRoute('/functionalunit/create') ? Html::a('Create Service Unit', ['create'], ['class' => 'btn btn-success']) : '',
            // 'after'=>Html::a('<i class="fas fa-redo"></i> Reset Grid', ['index'], ['class' => 'btn btn-info']),
            //'footer'=>true
        ],
    ]); ?>


</div>