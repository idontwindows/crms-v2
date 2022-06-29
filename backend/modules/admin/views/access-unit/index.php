<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\ActionColumn;
use kartik\grid\GridView;
use common\models\User;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\admin\models\AccessUnitSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Unit Access';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pager' => [
            'class' => \yii\bootstrap4\LinkPager::class
        ],
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],
            'username',
            //'email:email',
            //'status',
            //'created_at',
            //'updated_at',
            //'verification_token',
            //'regions:ntext',
            //'region_id',
            [
                'class' => ActionColumn::className(),
                'template' => '{view}',
                'urlCreator' => function ($action, User $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
