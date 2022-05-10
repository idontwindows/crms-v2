<?php

use common\models\ServiceUnit;

$serviceunit2 = ServiceUnit::findOne($serviceunit->parent_id);

$count = count($model);
$mod = $count % 2;
?>
<link rel="stylesheet" type="text/css" href="/css/bootstrap-extended.min.css">
<div class="serviceunit-default-index mt-0">
    <div class="row">
        <div class="col-12">
            <div class="card rounded-pill shadow mb-3 border bg-blue">
                <div class="card-content">
                    <div class="card-body">
                        <div class="media d-flex">
                            <div class="media-body text-center text-white">
                                <h5 class="font-weight-bold unit-title"><?= $serviceunit->is_child == 1 ? $serviceunit2->service_unit_name . ' / ' . $serviceunit->service_unit_name : $serviceunit->service_unit_name ?></h5>
                                <!-- <span><a class="font-weight-bold" href="">Click Here</a></span> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php $index = 1; ?>
        <?php foreach ($model as $pstc) { ?>
            <?php if ($mod != 0) { ?>
                <?php if ($count == $index) { ?>
                    <div class="col-xl-3 col-sm-12 col-12"></div>
                    <div class="col-xl-6 col-sm-12 col-12">
                        <div class="card rounded-pill shadow p-2 mb-3 border">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="media d-flex">
                                        <div class="align-self-center">
                                            <!-- <i class="icon-pie-chart warning font-large-2 float-right"></i> -->
                                            <i class="fa fa-check-circle text-primary font-large-2 float-right"></i>
                                        </div>
                                        <div class="media-body text-right">
                                            <h6 class="font-weight-bold unit-title"><?= $pstc->pstc_name ?></h6>
                                            <span><a class="font-weight-bold" href="<?= '/services/csf?service_unit_id=' . $serviceunit->service_unit_id . '&region_id=' . $region_id . '&pstc_id=' . $pstc->pstc_id ?>">Click Here</a></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-12 col-12"></div>
                <?php } else { ?>
                    <div class="col-xl-6 col-sm-12 col-12">
                        <div class="card rounded-pill shadow p-2 mb-3 border">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="media d-flex">
                                        <div class="align-self-center">
                                            <!-- <i class="icon-pie-chart warning font-large-2 float-right"></i> -->
                                            <i class="fa fa-check-circle text-primary font-large-2 float-right"></i>
                                        </div>
                                        <div class="media-body text-right">
                                            <h6 class="font-weight-bold unit-title"><?= $pstc->pstc_name ?></h6>
                                            <span><a class="font-weight-bold" href="<?= '/services/csf?service_unit_id=' . $serviceunit->service_unit_id . '&region_id=' . $region_id . '&pstc_id=' . $pstc->pstc_id ?>">Click Here</a></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            <?php } else { ?>
                <div class="col-xl-6 col-sm-12 col-12">
                    <div class="card rounded-pill shadow p-2 mb-3 border">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="media d-flex">
                                    <div class="align-self-center">
                                        <!-- <i class="icon-pie-chart warning font-large-2 float-right"></i> -->
                                        <i class="fa fa-check-circle text-primary font-large-2 float-right"></i>
                                    </div>
                                    <div class="media-body text-right">
                                        <h6 class="font-weight-bold unit-title"><?= $pstc->pstc_name ?></h6>
                                        <span><a class="font-weight-bold" href="<?= '/services/csf?service_unit_id=' . $serviceunit->service_unit_id . '&region_id=' . $region_id . '&pstc_id=' . $pstc->pstc_id ?>">Click Here</a></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <?php $index++ ?>
        <?php } ?>
    </div>
</div>