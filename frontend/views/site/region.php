<link rel="stylesheet" type="text/css" href="https://pixinvent.com/stack-responsive-bootstrap-4-admin-template/app-assets/css/bootstrap-extended.min.css">
<link rel="stylesheet" type="text/css" href="https://pixinvent.com/stack-responsive-bootstrap-4-admin-template/app-assets/fonts/simple-line-icons/style.min.css">
<link rel="stylesheet" type="text/css" href="https://pixinvent.com/stack-responsive-bootstrap-4-admin-template/app-assets/css/colors.min.css">
<link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
<div class="site-region container-fluid">
    <div class="row">
        <?php foreach ($regions as $region) { ?>
            <?php if(count($regions) > 8){ ?> 
            <div class="col-xl-4 col-sm-12 col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="media d-flex">
                                <div class="align-self-center">
                                    <i class="icon-pie-chart warning font-large-2 float-right"></i>
                                </div>
                                <div class="media-body text-right">
                                    <h3><?= $region['unit_name']; ?></h3>
                                    <span><a href="<?= $region['unit_url'] ?>">Click Here</a></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php }else{ ?> 
                <div class="col-xl-6 col-sm-12 col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="media d-flex">
                                <div class="align-self-center">
                                    <i class="icon-pie-chart warning font-large-2 float-right"></i>
                                </div>
                                <div class="media-body text-right">
                                    <h3><?= $region['unit_name']; ?></h3>
                                    <span><a href="<?= $region['unit_url'] ?>">Click Here</a></span>
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