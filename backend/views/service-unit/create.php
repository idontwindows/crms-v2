<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ServiceUnit */

$this->title = 'Create Service Unit';
$this->params['breadcrumbs'][] = ['label' => 'Service Units', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="service-unit-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
