<?php

/* @var $this \yii\web\View */
/* @var $content string */

use common\widgets\Alert;
use frontend\assets\AppAsset;
use yii\bootstrap4\Breadcrumbs;
use yii\bootstrap4\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;

AppAsset::register($this);


if (isset($_SERVER['HTTPS']) &&
    ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) ||
    isset($_SERVER['HTTP_X_FORWARDED_PROTO']) &&
    $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') {
  $protocol = 'https://';
}
else {
  $protocol = 'http://';
}
$serveruri = $protocol . "$_SERVER[HTTP_HOST]";

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">

<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <style>
        @media (max-width:1600px) {
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

    <title>DOST-IX Customer Satifation Feedback Managent System</title>
    <?php $this->head() ?>
    <script type="text/javascript">
        var frontendURI = "<?= $serveruri ?>";
        var event_id = "<?= !empty($_GET['id']) ? $_GET['id'] : '' ?>";
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
    </script>
</head>

<body class="d-flex flex-column h-100 bg-info">
    <?php $this->beginBody() ?>
    <header>
        <nav id="w0" class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
            <div class="container">
                <div class="d-flex align-items-center justify-content-center">
                    <a class="navbar-brand brand-lg" href="#">DOST-IX Customer Satifation Feedback Managent System</a>
                    <a class="navbar-brand brand-sm" href="#">DOST-IX CSFMS</a>
                </div>
                <?php
                if($this->context->route == 'site/region-units'){
                    echo '';
                }else 
                if($this->context->route == 'site/error'){
                    echo '';
                } 
                else{
                    echo '<button type="button" class="btn btn-yellow text-dark rounded-pill font-weight-bold" id="btn-back">Back</button>';
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