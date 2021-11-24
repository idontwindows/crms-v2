<link rel="stylesheet" type="text/css" href="/css/bootstrap-extended.min.css">
<div class="site-index">
    <div class="row">
    <?php foreach($regions as $region){ ?>
    <div class="col-xl-4 col-sm-12 col-12">
        <div class="card rounded-pill shadow p-2 mb-3">
            <div class="card-content">
                <div class="card-body">
                    <div class="media d-flex">
                        <div class="align-self-center">
                            <!-- <i class="icon-pie-chart warning font-large-2 float-right"></i> -->
                            <i class="fa fa-map-marker text-danger font-large-2 float-right"></i>
                        </div>
                        <div class="media-body text-right">
                            <h3 class="font-weight-bold unit-title"><?= 'DOST-'.strtoupper($region['region_code']) ?></h3>
                            <span><a class="font-weight-bold" href="<?= '/region/'  .$region['region_code'] ?>">Click Here</a></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>
    </div>
</div>