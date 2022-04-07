<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model common\models\Functionalunit */

$this->title = $model->unit_name;
$this->params['breadcrumbs'][] = ['label' => 'Functionalunits', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="functionalunit-view">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

    <p>
        <?= Html::a('Update', ['update', 'functional_unit_id' => $model->unit_id], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'unit_id',
            'unit_name',
        ],
    ]) ?>

<?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        // 'pager' => [
        //         'class' => \yii\bootstrap4\LinkPager::class
        // ],
        'summary' => false,
        'columns' => [
            // ['class' => 'yii\grid\SerialColumn'],  
            ['attribute' => 'question',
            'label' => false,]
        ],
        'panel' => [
            'heading'=>'Attributes',
            'type'=>'primary',
            'footer' => false
        ],
        'export' => false,
        'hover' => false,
        'toolbar' => false,
        'pager' => false
    ]); ?>

</div>
