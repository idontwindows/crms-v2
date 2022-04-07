<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Functionalunit */

$this->title = 'Update Functional Unit';
$this->params['breadcrumbs'][] = ['label' => 'Functionalunits', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->unit_id, 'url' => ['view', 'functional_unit_id' => $model->unit_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="functionalunit-update">

    <?= $this->render('_form', [
        'model' => $model,
        'items' => $servicesDataArray,
        'update' => true,
        'attributes1' => $attributes1,
        'attributes2' => $attributes2,
        'attributes3' => $attributes3,
        'attributes4' => $attributes4,
        'attributes5' => $attributes5,
        'attributes6' => $attributes6,
        'attributes7' => $attributes7,
        'attributes8' => $attributes8
        // 'attributes' => $attributes,
    ]) ?>

</div>
