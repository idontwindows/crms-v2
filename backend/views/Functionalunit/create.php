<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Functionalunit */

$this->title = 'Create Functional Unit';
$this->params['breadcrumbs'][] = ['label' => 'Functionalunits', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="functionalunit-create">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

    <?= $this->render('_form', [
        'model' => $model,
        'items' => $servicesDataArray,
        'update' => false
    ]) ?>

</div>
