<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Functionalunit\FunctionalunitSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="functionalunit-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'functional_unit_id') ?>

    <?= $form->field($model, 'services_id') ?>

    <?= $form->field($model, 'functional_unit_name') ?>

    <?= $form->field($model, 'region_id') ?>

    <?= $form->field($model, 'url') ?>

    <?php // echo $form->field($model, 'date_created') ?>

    <?php // echo $form->field($model, 'is_disabled') ?>

    <?php // echo $form->field($model, 'pstc_id') ?>

    <?php // echo $form->field($model, 'hrdc_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
