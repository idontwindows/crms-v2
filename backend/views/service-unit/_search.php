<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\ServiceUnitSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="service-unit-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'service_unit_id') ?>

    <?= $form->field($model, 'services_id') ?>

    <?= $form->field($model, 'service_unit_name') ?>

    <?= $form->field($model, 'is_parent') ?>

    <?= $form->field($model, 'is_child') ?>

    <?php // echo $form->field($model, 'parent_id') ?>

    <?php // echo $form->field($model, 'is_with_pstc') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
