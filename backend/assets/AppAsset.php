<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        'css/font-awesome.min.css',
        'css/bootstrap-datepicker3.min.css',
        'css/summernote-bs4.min.css'
    ];
    public $js = [
        'js/angular.min.js',
        'js/ui-bootstrap-custom-tpls-2.5.0.min.js',
        'js/app.js',
        'js/event.js',
        'js/unit.js',
        'js/createEvent.js',
        'js/createUnit.js',
        'js/updateUnit.js',
        'js/customer.js',
        'js/bootstrap-datepicker.min.js',
        'js/datepicker.js',
        'js/popper.min.js',
        'js/summernote-bs4.min.js',
        'js/sweetalert.min.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap4\BootstrapAsset',
    ];
}
