<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ServiceUnit */

$this->title = 'Update Service Unit: ' . $model->service_unit_id;
$this->params['breadcrumbs'][] = ['label' => 'Service Units', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->service_unit_id, 'url' => ['view', 'service_unit_id' => $model->service_unit_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="service-unit-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
