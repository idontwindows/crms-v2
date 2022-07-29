<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use common\widgets\Alert;
use yii\bootstrap4\Breadcrumbs;
use yii\bootstrap4\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;
//use Yii;

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
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100" ng-app="myApp">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <!-- <link href="css/styles.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script> -->
    <?php $this->head() ?>
    <script type="text/javascript">
        var backendURI = "<?= $serveruri ?>";
        var region_id = "<?= Yii::$app->user->identity->region_id ?>";
        var event_id = "<?= !empty($_GET['id']) ? $_GET['id'] : '' ?>";
    </script>
    <!-- <style>
        .breadcrumb-item+.breadcrumb-item::before {
            color: black;
            content: ">>";
        }
    </style> -->
</head>

<body class="sb-nav-fixed">
    <?php $this->beginBody() ?>
    <?= $this->render('_top'); ?>
    <div id="layoutSidenav">
        <?= $this->render('_left'); ?>
        <div id="layoutSidenav_content">
            <main>
                <?= Breadcrumbs::widget([
                    'homeLink' => [
                        'label' => Yii::t('yii', 'Dashboard'),
                        'url' => Yii::$app->homeUrl,
                    ],
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                    'options' => [
                        'class' => 'breadcrumb-arrow'
                    ]
                ]) ?>
                <?= Alert::widget() ?>
                <div class="container-fluid">
                    <div class="mb-5">
                        <!-- <div class="card mb-3 mt-0 border-0 rounded shadow-lg"> -->
                            <h1 class="ml-3 mt-3"><?= Html::encode($this->title) ?></h1>
                            <hr>

                            <!-- <div class="card-body"> -->
                                <?= $content ?>
                            <!-- </div> -->
                        <!-- </div> -->
                    </div>
                </div>
            </main>
            <?= $this->render('_footer'); ?>
        </div>
    </div>
    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage();
