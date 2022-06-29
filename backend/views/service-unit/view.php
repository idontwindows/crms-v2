<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use Da\QrCode\QrCode;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model common\models\ServiceUnit */

$this->title = $model->service_unit_name;
$this->params['breadcrumbs'][] = ['label' => 'Service Units', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

if (
    isset($_SERVER['HTTPS']) &&
    ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) ||
    isset($_SERVER['HTTP_X_FORWARDED_PROTO']) &&
    $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https'
) {
    $protocol = 'https://';
} else {
    $protocol = 'http://';
}
$serveruri = $protocol . "$_SERVER[HTTP_HOST]";

if($model->is_with_pstc == true){
    $url = $serveruri . '/services/csf?service_unit_id=' . $model->service_unit_id . '&region_id=' . $region_id .'&pstc_id=' . $_GET['pstc_id'];
    $file_directory = __DIR__ . '/../../../frontend/web/administrator/qr-code/' . $model->service_unit_name . '_' . $region_id .'_'.$_GET['pstc_id'] . '_code.png';
    $printQr = '<div class="d-flex justify-content-center">'.Html::a('<img src="' . $serveruri . '/administrator/qr-code/' . $model->service_unit_name . '_' . $region_id .'_'. $_GET['pstc_id'] . '_code.png' . '" width="300" height="300">', ['download-qrcode', 'name' => $model->service_unit_name,'id' => $model->service_unit_id, 'region_id' => $region_id,'pstc_id' => $_GET['pstc_id']], ['data-toggle' => 'tooltip', 'title' => 'QR Code']).'</div>';
}else{
    $url = $serveruri . '/services/csf?service_unit_id=' . $model->service_unit_id . '&region_id=' . $region_id;
    $file_directory = __DIR__ . '/../../../frontend/web/administrator/qr-code/' . $model->service_unit_name . '_' . $region_id .'_code.png';
    $printQr = '<div class="d-flex justify-content-center">'.Html::a('<img src="' . $serveruri . '/administrator/qr-code/' . $model->service_unit_name . '_' . $region_id . '_code.png' . '" width="300" height="300">', ['download-qrcode', 'name' => $model->service_unit_name,'id' => $model->service_unit_id, 'region_id' => $region_id], ['data-toggle' => 'tooltip', 'title' => 'QR Code']).'</div>';
}

?>
<div class="service-unit-view">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

    <p>
        <!-- <?= Html::a('Update', ['update', 'service_unit_id' => $model->service_unit_id], ['class' => 'btn btn-primary']) ?> -->
        <!-- <?= Html::a('Delete', ['delete', 'service_unit_id' => $model->service_unit_id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => 'Are you sure you want to delete this item?',
                        'method' => 'post',
                    ],
                ]) ?> -->
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'service_unit_name',
            [
                'attribute' => 'url',
                'format' => 'html',
                'value' => function ($model) use ($serveruri, $region_id, $url) {
                    return '<a href="' . $url . '" target="_blank">' . $url . '</a>';
                    //return Html::a($url, [Url::to([$url])]);
                }
            ]


        ],
    ]) ?>

    <?php
    
    $file_logo = __DIR__ . '/../../../frontend/web/images/dostlogo.png';

    if (!file_exists($file_directory)) {
        $qrCode = (new QrCode($url));
        $qrCode->setSize(300)
            ->setMargin(5)
            ->useForegroundColor(0,0,255)
            ->useLogo($file_logo);
        $qrCode->writeFile($file_directory);
    }
    echo $printQr;
    ?>

</div>