<?php

/* @var $this \yii\web\View */
/* @var $content string */

use common\widgets\Alert;
use frontend\assets\AppAsset;
use yii\bootstrap4\Breadcrumbs;
use yii\bootstrap4\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;
use common\models\Region;

AppAsset::register($this);


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

$region_code = '';
if (isset($_GET['id'])) {
    $con = Yii::$app->db;
    $id = base64_decode(base64_decode($_GET['id']));
    //$sql1 = 'SELECT * FROM `tbl_unit` WHERE `unit_id` =' . $id . ' AND `is_disabled` = 0';
    $sql1 = 'SELECT a.unit_id,
                a.unit_name, 
                a.region_id, 
                a.unit_url, 
                a.date_created, 
                a.is_disabled, 
                b.region_code 
        FROM tbl_unit AS a 
        INNER JOIN tbl_region AS b 
        ON b.region_id = a.region_id 
        WHERE a.unit_id = ' . $id . ' AND a.is_disabled = 0';
    $title = $con->createCommand($sql1)->queryOne();
    $region_code = $title['region_code'];
}

if(isset($_GET['region_code'])){
    $region_code = $_GET['region_code'];
}
if(isset($_GET['region_id'])){
    $region_id = $_GET['region_id'];
    $region = Region::find()->where(['region_id' => $region_id])->one();
    $region_code = $region->region_code;
}
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">

<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <style>
        @media (max-width:3840px) {
            a.brand-lg {
                display: block !important;
            }

            a.brand-sm {
                display: none !important;
            }
        }

        @media (max-width:764px) {
            a.brand-lg {
                display: none !important;
            }

            a.brand-sm {
                display: block !important;
            }
        }
    </style>
    <?php $this->registerCsrfMetaTags() ?>

    <title><?= Yii::$app->name ?></title>
    <?php $this->head() ?>
    <script type="text/javascript">
        var frontendURI = "<?= $serveruri ?>";
        var unit_id = "<?= !empty($_GET['id']) ? $_GET['id'] : '' ?>";
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
    </script>
</head>

<body class="d-flex flex-column h-100">
    <?php $this->beginBody() ?>
    <header>
        <nav id="w0" class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
            <div class="container">
                <div class="d-flex align-items-center justify-content-center">
                    <a class="navbar-brand brand-lg" href="/"><?= 'DOST '. strtoupper($region_code) .' '. Yii::$app->name ?></a>
                    <a class="navbar-brand brand-sm" href="/"><?= empty(strtoupper($region_code)) ? 'DOST CRMS' : 'RO-' . strtoupper($region_code)?></a>
                </div>
                <?php
                if ($this->context->route == 'site/region-units') {
                    echo '';
                } else 
                if ($this->context->route == 'site/error') {
                    echo '';
                } else
                if ($this->context->route == 'site/index') {
                    echo '';
                } else 
                if($this->context->route == 'site/csf'){
                    echo '<button type="button" class="btn btn-yellow text-dark rounded-pill font-weight-bold" id="btn-back">Go Back</button>';
                } else
                if($this->context->route == 'site/sub-menu'){
                    echo '<button type="button" class="btn btn-yellow text-dark rounded-pill font-weight-bold" id="btn-back">Go Back</button>';
                } else
                if($this->context->route == 'site/pstc'){
                    echo '<button type="button" class="btn btn-yellow text-dark rounded-pill font-weight-bold" id="btn-back">Go Back</button>';
                }
                ?>


            </div>
        </nav>
    </header>
    <main role="main">
        <div class="container">
            <?= $content ?>
        </div>
    </main>

    <footer class="footer mt-auto py-3 text-muted">
        <div class="container">
            <p class="float-left">&copy; <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?></p>
            <p class="float-right power">Powered by: <b>DOST-IX ICT Team</b></p>
        </div>
    </footer>
    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage(); ?>