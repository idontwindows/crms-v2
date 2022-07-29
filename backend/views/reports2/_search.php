<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\SearchTmpRating */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tmp-rating-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'attribute') ?>

    <?= $form->field($model, 'vsatisfied') ?>

    <?= $form->field($model, '5') ?>

    <?= $form->field($model, 'satisfied') ?>

    <?php // echo $form->field($model, '4') ?>

    <?php // echo $form->field($model, 'neither') ?>

    <?php // echo $form->field($model, '3') ?>

    <?php // echo $form->field($model, 'dissatisfied') ?>

    <?php // echo $form->field($model, '2') ?>

    <?php // echo $form->field($model, 'vdissatisfied') ?>

    <?php // echo $form->field($model, '1') ?>

    <?php // echo $form->field($model, 'total_score') ?>

    <?php // echo $form->field($model, 'ss') ?>

    <?php // echo $form->field($model, 'gap') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
