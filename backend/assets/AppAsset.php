<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle {

    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        "css/font-awesome.css",
        'css/ionicons.css',
        'css/perfect-scrollbar.css',
        'css/jquery.switchButton.css',
        'css/select2.min.css',
        'css/chosen.css',
        'css/rickshaw.min.css',
        'css/morris.css',
        'css/bracket.css',
    ];
    public $js = [
//        'js/jquery.js',
        'js/popper.js',
        'js/bootstrap.js',
        'js/perfect-scrollbar.jquery.js',
        'js/moment.js',
        'js/jquery-ui.js',
        'js/jquery.switchButton.js',
        'js/jquery.peity.js',
        'js/bootbox.js',
        'js/plot.js',
        'js/sparkline.js',
        'js/raphael.js',
        'js/morris.js',
        'js/chosen.js',
        'js/bracket.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
            //      'yii\bootstrap\BootstrapAsset',
    ];

}
