<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Drivers */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="drivers-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'drivers_name')->textInput(['maxlength' => true]) ?>

    <!-- <?= $form->field($model, 'region_id')->textInput() ?> -->

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
