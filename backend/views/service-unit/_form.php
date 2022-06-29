<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ServiceUnit */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="service-unit-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'services_id')->textInput() ?>

    <?= $form->field($model, 'service_unit_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'is_child')->textInput() ?>

    <?= $form->field($model, 'parent_id')->textInput() ?>

    <?= $form->field($model, 'is_with_pstc')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
