<?php
use yii\helpers\Html;

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

$script = "$(document).ready(function() {
    $('#btn-back').click(function() {
        window.location.replace('" . $serveruri . '/site/units?region_id=' . $region_id ."');
    });
});";
$this->registerJs($script, yii\web\View::POS_END, '');

?>
<link rel="stylesheet" type="text/css" href="/css/bootstrap-extended.min.css">
<div class="site-menu container-fluid mt-xl-5">
    <div class="row">
        <?php foreach ($model as $menu) { ?>
            <?php if (count($model) > 8) { ?>
                <div class="col-xl-4 col-sm-12 col-12">
                    <div class="card rounded-pill shadow p-2 mb-3 border">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="media d-flex">
                                    <div class="align-self-center">
                                        <!-- <i class="icon-pie-chart warning font-large-2 float-right"></i> -->
                                        <i class="fa fa-check-circle text-info font-large-2 float-right"></i>
                                    </div>
                                    <div class="media-body text-right">
                                        <h5 class="font-weight-bold unit-title"><?= $menu['services_name'].' '.$menu['pstc_name'] ?></h5>
                                        <span><?= Html::a('Click Here', [$menu['unit_url'],'pstc_id' => $menu['pstc_id']], ['class' => 'profile-link font-weight-bold']) ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } else { ?>
                <div class="col-xl-6 col-sm-12 col-12">
                    <div class="card rounded-pill shadow p-2 mb-5 border">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="media d-flex">
                                    <div class="align-self-center">
                                        <!-- <i class="icon-pie-chart warning font-large-2 float-right"></i> -->
                                        <i class="fa fa-check-circle info font-large-2 float-right"></i>
                                    </div>
                                    <div class="media-body text-right">
                                    <h5 class="font-weight-bold unit-title"><?= $menu['services_name'].' '.$menu['pstc_name'] ?></h5>
                                        <span><?= Html::a('Click Here', [$menu['unit_url'],'pstc_id' => $menu['pstc_id']], ['class' => 'profile-link font-weight-bold']) ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        <?php } ?>
    </div>
</div>
<?php
$this->registerCss('@media (min-width: 360px) {
                        h5.font-weight-bold.unit-title {
                            font-size: 12px;
                        }
                    }

                    @media (min-width:1245px) {
                        h5.font-weight-bold.unit-title {
                            font-size: 15px;
                        }
                    }');
?>