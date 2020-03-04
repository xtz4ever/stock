<?php

/* @var $this \yii\web\View */

/* @var $content string */

use app\components\Header;
use app\components\ModalFormWidget;
use common\models\Category;
use common\models\Contacts;
use common\widgets\Alert;
use frontend\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\Url;


AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>




    <meta charset="utf-8">
    <!--<meta http-equiv="X-UA-Compatible" content="IE=edge">-->

    <!--    <link rel="shortcut icon" href="/img/favicon/favicon.ico" type="image/x-icon">-->

    <link rel="canonical" href="<?= Url::home(true).$_SERVER['REQUEST_URI'];?>"/>
    <?php $this->registerLinkTag(['rel' => 'icon', 'type' => 'image/png', 'href' => Url::to(['img/iconss/icon-f.png'])]); ?>
    <link rel="shortcut icon" href="/frontend/web/img/logo.ico"/>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>


    <!-- Bootstrap v3.3.4 Grid Styles -->
    <style>
        /*body {
            font: 400 30px "Century Gothic" !important;
            font-size: 30px !important;
            color: #575858 !important;
            letter-spacing: .1em !important;
        }*/

    </style>
    <!-- Header CSS (First Sections of Website: paste after release from header.min.css here) -->
    <style>
        html .loader {
            background: #fff;
            bottom: 0;
            height: 100%;
            left: 0;
            position: fixed;
            right: 0;
            top: 0;
            width: 100%;
            z-index: 9999
        }

        html .loader .loader_inner {
            /*background-image: url(../img/preloader.gif);*/
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center center;
            background-color: #fff;
            height: 60px;
            width: 60px;
            margin-top: -30px;
            margin-left: -30px;
            left: 50%;
            top: 50%;
            position: absolute
        }

        body > div > iframe {
            position: absolute;
            display: none;
        }
    </style>

<!--    <noscript>-->
<!--        <link rel="stylesheet" href="css/fonts.min.css">-->
<!--        <link rel="stylesheet" href="css/main.min.css">-->
<!--    </noscript>-->





    <meta property="og:title" content="<?= Html::encode($this->title); ?>">
    <meta property="og:site_name" content="<?=$_SERVER['SERVER_NAME'];?>">
    <meta property="og:url" content="<?= Url::home(true);?>">
    <meta property="og:description" content="">
    <meta property="og:image" content="/frontend/web/img/logo.png">
</head>

<body>
<?php $this->beginBody(); ?>


<!--<div class="loader">-->
<!--    <div class="loader_inner"></div>-->
<!--</div>-->


<nav canvas="" class="" style="">
    <div class="mnu_btn">
        <label id="nav-button-label">
            <div id="nav-lines">
                <i class="nav-line"></i>
                <i class="nav-line"></i>
                <i class="nav-line"></i>
                <i class="nav-line"></i>
            </div>
        </label>
    </div>
</nav>
<div data-scroll="header" class="footer-arrow-up scroll_to">
    <img src="/img/footer-arrow-up.png" alt="">
</div>

<div canvas="container">
    <div class="off-canvas-wrap"></div>
    <?= Header::widget() ?>



    <?= Alert::widget() ?>

    <?= $content ?>



    <?= \app\components\Footer::widget(); ?>


</div>

    <?=  \app\components\Mobilemenu::widget(); ?>

<div off-canvas="id-2 right push">
</div>
<div off-canvas="id-3 top overlay">
</div>
<div off-canvas="id-4 bottom shift">
</div>
<div class="hidden"></div>

<?= $this->endBody(); ?>

</body>

</html>

<?= $this->endPage(); ?>
