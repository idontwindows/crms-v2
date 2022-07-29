<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use common\models\ServiceUnit;
use common\models\Pstc;
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

$serviceunit = $model;
$parent = ServiceUnit::findOne($serviceunit->parent_id);

$this->title = $model->service_unit_name;
$this->params['breadcrumbs'][] = ['label' => 'Service Units', 'url' => ['index']];
if(!is_null($serviceunit->parent_id)) $this->params['breadcrumbs'][] = ['label' => $parent->service_unit_name, 'url' => ['sub-unit','service_unit_id' => $serviceunit->parent_id]];
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
            [
                'attribute' => 'pstc_name',
                'label' => 'PSTC/CSTC'
            ],
            [
                'class' => 'kartik\grid\ActionColumn',
                'template' => '{view} {rating}',
                'buttons' => [
                    'view' => function ($url, $model) use ($serviceunit) {
                        return Html::button('<span class="fas fa-eye"></span> View', ['value' => Url::to(['service-unit/view', 'service_unit_id' => $serviceunit->service_unit_id,'pstc_id' => $model->pstc_id]), 'class' => 'btn btn-primary btn-sm button-view', 'id' => 'button-view']);
                    },
                    'rating' => function ($url, $model) use ($region_id,$serviceunit) {
                            return Html::a('<span class="fas fa-file"></span> Rating', ['/reports2', 'service_unit_id' => $serviceunit->service_unit_id, 'region_id' => $region_id, 'pstc_id' => $model->pstc_id], ['class' => 'btn btn-warning btn-sm', 'data-toggle' => 'tooltip', 'title' => 'rating']);
                    },

                ],
            ],
        ],
        'panel' => [
            'heading' => '',
            'type' => 'primary',
        ],
    ]); ?>
</div>