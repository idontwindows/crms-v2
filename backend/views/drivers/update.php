<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Drivers */

$this->title = 'Update Drivers: ' . $model->drivers_id;
$this->params['breadcrumbs'][] = ['label' => 'Drivers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->drivers_id, 'url' => ['view', 'drivers_id' => $model->drivers_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="drivers-update">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
