<?php

use yii\helpers\Html;
use yii\helpers\Url;

$collapse = 'collapsed';
$bool = 'false';
$show = '';
$activeuser = '';
$activeassignment = '';
$activepermission = '';
$activeroute = '';
$activerole = '';

$showcp = '';
$collapsecp = 'collapsed';
$boolcp = 'false';
$activecp = '';

$showreport = '';
$collapsereport = 'collapsed';
$boolreport = 'false';
$activerolereport1 = '';
$activerolereport2 = '';

$collapselibrary = 'collapsed';
$boollibrary = 'false';
$activelibrary = '';
$showlibrary = '';

if($this->context->route == 'admin/user/index' || $this->context->route == 'admin/user/view'){
    $show = 'show';
    $collapse = '';
    $bool = 'true';
    $activeuser = 'active';
}
if($this->context->route == 'admin/assignment/index' || $this->context->route == 'admin/assignment/view'){
    $show = 'show';
    $collapse = '';
    $bool = 'true';
    $activeassignment = 'active';
}
if($this->context->route == 'admin/permission/index' || $this->context->route == 'admin/permission/view' || $this->context->route == 'admin/permission/create'){
    $show = 'show';
    $collapse = '';
    $bool = 'true';
    $activepermission = 'active';
}
if($this->context->route == 'admin/route/index'){
    $show = 'show';
    $collapse = '';
    $bool = 'true';
    $activeroute = 'active';
}
if($this->context->route == 'admin/role/index' || $this->context->route == 'admin/role/create'){
    $show = 'show';
    $collapse = '';
    $bool = 'true';
    $activerole = 'active';
}
if($this->context->route == 'admin/user/change-password'){
    $showcp = 'show';
    $collapsecp = '';
    $boolcp = 'true';
    $activecp = 'active';
}
if($this->context->route == 'reports/index'){
    $showreport = 'show';
    $collapsereport = '';
    $boolreport = 'true';
    $activerolereport2 = 'active';
}
if($this->context->route == 'reports/report1'){
    $showreport = 'show';
    $collapsereport = '';
    $boolreport = 'true';
    $activerolereport1 = 'active';
}
if($this->context->route == 'drivers/index' || $this->context->route == 'drivers/create' || $this->context->route == 'drivers/update' || $this->context->route == 'drivers/view'){
    $showlibrary = 'show';
    $collapselibrary = '';
    $boollibrary = 'true';
    $activelibrary = 'active';
}
?>
<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading">Menu</div>
                <a class="nav-link" href="/administrator/site/index">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a>
                <?= Html::a('<div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div> Functional Units', Url::to(['/unit']), ['class' => 'nav-link']) ?>
                <?php
                echo Html::a(
                    '<div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                    Reports
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>',
                    Url::to(['#']),
                    [
                        'class' => 'nav-link '.$collapsereport,
                        'data-toggle' => 'collapse',
                        'data-target' => '#collapseReport',
                        'aria-expanded' => $boolreport,
                        'aria-controls' => 'collapseReport'
                    ]
                );
                ?>
                <div class="collapse <?= $showreport; ?>" id="collapseReport" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <?= Html::a('<div class="sb-nav-link-icon"><i class="fas fa-file-excel"></i></div> Report 1', Url::to(['/reports/report1']), ['class' => 'nav-link '.$activerolereport1]) ?>
                        <?= Html::a('<div class="sb-nav-link-icon"><i class="fas fa-file-excel"></i></div> Report 2', Url::to(['/reports']), ['class' => 'nav-link '.$activerolereport2]) ?>
                    </nav>
                </div>
                <?php if (Yii::$app->user->identity->username == 'admin') { ?>
                    <?php
                    echo Html::a(
                        '<div class="sb-nav-link-icon"><i class="fas fa-cogs"></i></div>
                        RBAC
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>',
                        Url::to(['#']),
                        [
                            'class' => 'nav-link ' . $collapse,
                            'data-toggle' => 'collapse',
                            'data-target' => '#collapseSettings',
                            'aria-expanded' => $bool,
                            'aria-controls' => 'collapseSettings'
                        ]
                    );
                    ?>
                    <div class="collapse <?= $show; ?>"  id="collapseSettings" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <?= Html::a('<div class="sb-nav-link-icon"><i class="fas fa-users"></i></div> Users', Url::to(['/admin/user']), ['class' => 'nav-link '.$activeuser]) ?>
                            <?= Html::a('<div class="sb-nav-link-icon"><i class="fas fa-drum"></i></div> Assignment', Url::to(['/admin/assignment']), ['class' => 'nav-link '.$activeassignment]) ?>
                            <?= Html::a('<div class="sb-nav-link-icon"><i class="fas fa-key"></i></div> Permission', Url::to(['/admin/permission']), ['class' => 'nav-link '.$activepermission]) ?>
                            <?= Html::a('<div class="sb-nav-link-icon"><i class="fas fa-route"></i></div> Route', Url::to(['/admin/route']), ['class' => 'nav-link '.$activeroute]) ?>
                            <?= Html::a('<div class="sb-nav-link-icon"><i class="fas fa-user-tag"></i></div> Role', Url::to(['/admin/role']), ['class' => 'nav-link '.$activerole]) ?>
                            <!-- <a class="nav-link" href="layout-sidenav-light.html">Report 2</a> -->
                        </nav>
                    </div>
                <?php } ?>

                <!-- <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseAccount" aria-expanded="false" aria-controls="collapseLayouts">
                    <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                    Account Settings
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a> -->



                <?php
                echo Html::a(
                    '<div class="sb-nav-link-icon"><i class="fas fa-book"></i></div>
                    Library
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>',
                    Url::to(['#']),
                    [
                        'class' => 'nav-link '.$collapselibrary,
                        'data-toggle' => 'collapse',
                        'data-target' => '#collapseLibrary',
                        'aria-expanded' => $boollibrary,
                        'aria-controls' => 'collapseLibrary'
                    ]
                );
                ?>
                <div class="collapse <?= $showlibrary; ?>" id="collapseLibrary" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <?= Html::a('<div class="sb-nav-link-icon"><i class="fas fa-car"></i></div> Drivers', Url::to(['/drivers']), ['class' => 'nav-link '.$activelibrary]) ?>
                        <!-- <a class="nav-link" href="layout-sidenav-light.html">Report 2</a> -->
                    </nav>
                </div>

                <?php
                echo Html::a(
                    '<div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                    Account Settings
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>',
                    Url::to(['#']),
                    [
                        'class' => 'nav-link '.$collapsecp,
                        'data-toggle' => 'collapse',
                        'data-target' => '#collapseAccount',
                        'aria-expanded' => $boolcp,
                        'aria-controls' => 'collapseAccount'
                    ]
                );
                ?>
                <div class="collapse <?= $showcp; ?>" id="collapseAccount" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <?= Html::a('<div class="sb-nav-link-icon"><i class="fas fa-key"></i></div> Change Password', Url::to(['/admin/user/change-password']), ['class' => 'nav-link '.$activecp]) ?>
                        <!-- <a class="nav-link" href="layout-sidenav-light.html">Report 2</a> -->
                    </nav>
                </div>
            </div>
        </div>
        <div class="sb-sidenav-footer">
            <?= Html::a('<i class="fas fa-power-off"></i> Logout (' . Yii::$app->user->identity->username . ')', Url::to(['/site/logout']), ['data-method' => 'POST', 'class' => 'text-white']) ?>
        </div>
    </nav>
</div>