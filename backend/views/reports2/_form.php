<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\TmpRating */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tmp-rating-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'attribute')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'vsatisfied')->textInput() ?>

    <?= $form->field($model, '5')->textInput() ?>

    <?= $form->field($model, 'satisfied')->textInput() ?>

    <?= $form->field($model, '4')->textInput() ?>

    <?= $form->field($model, 'neither')->textInput() ?>

    <?= $form->field($model, '3')->textInput() ?>

    <?= $form->field($model, 'dissatisfied')->textInput() ?>

    <?= $form->field($model, '2')->textInput() ?>

    <?= $form->field($model, 'vdissatisfied')->textInput() ?>

    <?= $form->field($model, '1')->textInput() ?>

    <?= $form->field($model, 'total_score')->textInput() ?>

    <?= $form->field($model, 'ss')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'gap')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
