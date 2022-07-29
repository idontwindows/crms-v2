<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\TmpRating */

$this->title = 'Create Tmp Rating';
$this->params['breadcrumbs'][] = ['label' => 'Tmp Ratings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tmp-rating-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
