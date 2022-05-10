<link rel="stylesheet" type="text/css" href="/css/bootstrap-extended.min.css">
<div class="site-index">
    <div class="row">
    <div class="col-12">
        <div class="card rounded-pill shadow mb-3 border bg-blue">
            <div class="card-content">
                <div class="card-body">
                    <div class="media d-flex">
                        <div class="media-body text-center text-white">
                            <h5 class="font-weight-bold unit-title">REGIONAL OFFICES</h5>
                            <!-- <span><a class="font-weight-bold" href="">Click Here</a></span> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php foreach($regions as $region){ ?>
    <div class="col-xl-4 col-sm-12 col-12">
        <div class="card rounded-pill shadow p-2 mb-3 border">
            <div class="card-content">
                <div class="card-body">
                    <div class="media d-flex">
                        <div class="align-self-center">
                            <!-- <i class="icon-pie-chart warning font-large-2 float-right"></i> -->
                            <i class="fa fa-map-marker text-danger font-large-2 float-right"></i>
                        </div>
                        <div class="media-body text-right">
                            <h3 class="font-weight-bold unit-title"><?= 'DOST-'.strtoupper($region['region_code']) ?></h3>
                            <span><a class="font-weight-bold" href="<?= '/services?region_id='  .$region['region_id'] ?>">Click Here</a></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>
    </div>
</div>