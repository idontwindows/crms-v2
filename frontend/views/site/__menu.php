<?php
use common\models\Unit;
use yii\helpers\Html;
use common\models\Hrdc;
?>
<link rel="stylesheet" type="text/css" href="/css/bootstrap-extended.min.css">
<div class="site-menu container-fluid mt-xl-5">
    <div class="row">
        <?php foreach ($model as $service) { ?>
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
                                        <?php $hrdc = Hrdc::find()->where(['region_id' => $region_id])->one(); ?>
                                        <h5 class="font-weight-bold unit-title"><?= $service->with_pstc_hrdc != 2 ? $service->services_name : $hrdc->short_name ?></h5>
                                        <?php $unit = Unit::find()->where(['region_id' => $region_id, 'services_id' => $service->services_id])->one(); ?>
                                        <?php if ($service->with_pstc_hrdc != 1) { ?>
                                            <span><?= Html::a('Click Here', $unit['unit_url'], ['class' => 'profile-link font-weight-bold']) ?></span>
                                        <?php }else{ ?>
                                            <span><?= Html::a('Click Here', ['site/pstc', 'region_id' => $region_id,'unit_id' => $unit['unit_id']], ['class' => 'profile-link font-weight-bold']) ?></span>
                                        <?php } ?>
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
                                        <h5 class="font-weight-bold unit-title"><?= $service->services_name ?></h5>
                                        <?php if ($service->with_pstc_hrdc != 1) { ?>
                                            <span><?= Html::a('Click Here', $unit['unit_url'], ['class' => 'profile-link font-weight-bold']) ?></span>
                                        <?php }else{ ?>
                                            <span><?= Html::a('Click Here', ['site/pstc', 'region_id' => $region_id,'unit_id' => $unit['unit_id']], ['class' => 'profile-link font-weight-bold']) ?></span>
                                        <?php } ?>
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