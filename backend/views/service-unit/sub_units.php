<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use common\models\ServiceUnit;
use kartik\grid\GridView;
use yii\bootstrap4\Modal;

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


$this->title = $model->service_unit_name;
$this->params['breadcrumbs'][] = ['label' => 'Service Units', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;



Modal::begin([
    'title' => $this->title,
    'id' => 'modal',
    'size' => 'modal-lg',
]);

echo '<div id="modal-content"></div>';

Modal::end();
?>
<div class="sub-unit-index">

<?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'pager' => [
            'class' => \yii\bootstrap4\LinkPager::class
        ],
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],
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
            // 'after'=>Html::a('<i class="fas fa-redo"></i> Reset Grid', ['index'], ['class' => 'btn btn-info']),
            //'footer'=>true
        ],
    ]); ?>
</div>