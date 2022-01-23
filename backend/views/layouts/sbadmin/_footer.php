<?php

use yii\helpers\Html;
use yii\helpers\Url;
?>
<footer class="py-4 bg-light mt-auto">
    <div class="container-fluid">
        <div class="d-flex align-items-center justify-content-between small">
            <div class="text-muted">Copyright &copy; <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?></div>
            <div>
            Powered by: <b>DOST-IX ICT Team</b>
            </div>
        </div>
    </div>
</footer>