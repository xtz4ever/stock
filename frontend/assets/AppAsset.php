<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/header.min.css',
        'css/main.min.css',
        'css/fonts.min.css',
        'css/site.css',


    ];
    public $js = [
        'js/jquery-1.12.4.min.js',
//        'js/jquery.magnific-popup.js',

        'js/libs.js',
//        'js/main.js',
//        'js/footer.js',
        'js/my_script.js',

//        'https://www.google.com/recaptcha/api/js/recaptcha_ajax.js',


    ];
    public $jsOptions = ['position' => \yii\web\View::POS_HEAD];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}