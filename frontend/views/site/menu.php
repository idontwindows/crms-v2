<link rel="stylesheet" type="text/css" href="/css/bootstrap-extended.min.css">
<div class="site-menu container-fluid mt-xl-5">
    <div class="row">
        <?php foreach ($regions as $region) { ?>
            <?php if (count($regions) > 8) { ?>
                <div class="col-xl-4 col-sm-12 col-12">
                    <div class="card rounded-pill shadow p-2 mb-3">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="media d-flex">
                                    <div class="align-self-center">
                                        <!-- <i class="icon-pie-chart warning font-large-2 float-right"></i> -->
                                        <i class="fa fa-check-circle text-info font-large-2 float-right"></i>
                                    </div>
                                    <div class="media-body text-right">
                                        <h5 class="font-weight-bold unit-title"><?= $region['unit_name']; ?></h5>
                                        <span><a class="font-weight-bold" href="<?= $region['unit_url'] ?>">Click Here</a></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } else { ?>
                <div class="col-xl-6 col-sm-12 col-12">
                    <div class="card rounded-pill shadow p-2 mb-5">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="media d-flex">
                                    <div class="align-self-center">
                                        <!-- <i class="icon-pie-chart warning font-large-2 float-right"></i> -->
                                        <i class="fa fa-check-circle info font-large-2 float-right"></i>
                                    </div>
                                    <div class="media-body text-right">
                                        <h5 class="font-weight-bold unit-title"><?= $region['unit_name']; ?></h5>
                                        <span><a class="font-weight-bold" href="<?= $region['unit_url'] ?>">Click Here</a></span>
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