<?php

use yii\helpers\Html;
use yii\helpers\Url;
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
                        'class' => 'nav-link collapsed',
                        'data-toggle' => 'collapse',
                        'data-target' => '#collapseReport',
                        'aria-expanded' => 'false',
                        'aria-controls' => 'collapseReport'
                    ]
                );
                ?>
                <div class="collapse" id="collapseReport" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <?= Html::a('<div class="sb-nav-link-icon"><i class="fas fa-file-excel"></i></div> Report 1', Url::to(['/reports']), ['class' => 'nav-link']) ?>
                        <?= Html::a('<div class="sb-nav-link-icon"><i class="fas fa-file-excel"></i></div> Report 2', Url::to(['#']), ['class' => 'nav-link']) ?>
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
                            'class' => 'nav-link collapsed',
                            'data-toggle' => 'collapse',
                            'data-target' => '#collapseSettings',
                            'aria-expanded' => 'false',
                            'aria-controls' => 'collapseSettings'
                        ]
                    );
                    ?>
                    <div class="collapse" id="collapseSettings" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <?= Html::a('<div class="sb-nav-link-icon"><i class="fas fa-users"></i></div> Users', Url::to(['/admin/user']), ['class' => 'nav-link']) ?>
                            <?= Html::a('<div class="sb-nav-link-icon"><i class="fas fa-drum"></i></div> Assignment', Url::to(['/admin/assignment']), ['class' => 'nav-link']) ?>
                            <?= Html::a('<div class="sb-nav-link-icon"><i class="fas fa-key"></i></div> Permission', Url::to(['/admin/permission']), ['class' => 'nav-link']) ?>
                            <?= Html::a('<div class="sb-nav-link-icon"><i class="fas fa-route"></i></div> Route', Url::to(['/admin/route']), ['class' => 'nav-link']) ?>
                            <?= Html::a('<div class="sb-nav-link-icon"><i class="fas fa-user-tag"></i></div> Role', Url::to(['/admin/role']), ['class' => 'nav-link']) ?>
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
                    '<div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                    Account Settings
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>',
                    Url::to(['#']),
                    [
                        'class' => 'nav-link collapsed',
                        'data-toggle' => 'collapse',
                        'data-target' => '#collapseAccount',
                        'aria-expanded' => 'false',
                        'aria-controls' => 'collapseAccount'
                    ]
                );
                ?>
                <div class="collapse" id="collapseAccount" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <?= Html::a('<div class="sb-nav-link-icon"><i class="fas fa-key"></i></div> Change Password', Url::to(['/admin/user/change-password']), ['class' => 'nav-link']) ?>
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