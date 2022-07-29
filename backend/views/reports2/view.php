<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\TmpRating */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Tmp Ratings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="tmp-rating-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'attribute',
            'vsatisfied',
            '5',
            'satisfied',
            '4',
            'neither',
            '3',
            'dissatisfied',
            '2',
            'vdissatisfied',
            '1',
            'total_score',
            'ss',
            'gap',
        ],
    ]) ?>

</div>
