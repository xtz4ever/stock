<?php

use frontend\assets\AppAsset;
use \yii\helpers\Url;
use kartik\form\ActiveForm;
use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\widgets\Pjax;
use himiklab\yii2\recaptcha\ReCaptcha;

?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<?php


//$this->registerJsFile('owl-carousel/owl.carousel.js',
//    ['depends' => [AppAsset::className()],
//        'position' => \yii\web\View::POS_END
//    ]);
$this->registerCssFile('css/feedbacks.css',
    ['depends' => [AppAsset::className()],
        'position' => \yii\web\View::POS_HEAD
    ]);
$this->registerCssFile('css/stylesheet.css',
    ['depends' => [AppAsset::className()],
        'position' => \yii\web\View::POS_HEAD
    ]);

$this->registerCssFile('owl-carousel/owl.carousel.css',
    ['depends' => [AppAsset::className()],
        'position' => \yii\web\View::POS_HEAD
    ]);

$this->registerCssFile('owl-carousel/owl.theme.default.css',
    ['depends' => [AppAsset::className()],
        'position' => \yii\web\View::POS_HEAD
    ]);
?>


<style>
    .control-label {
        font-weight: 400;
        color: #fff;
    }

    h4 {
        font-size: 26px;
        font-weight: 400;
        color: #fff;
        margin-bottom: 2%;
    }

    .help-block {
        display: none;

    }

    .feedbacks-section .loader_more {
        font-size: 50px;
        padding-top: -15px !important;
    }

    .feedbacks_list {
        text-align: center;
    }

    .feedbacks-section {
        padding-top: 100px;
    }

</style>
<style>


    .fl_item, .form_opinion > .container {
        background-color: rgba(56, 63, 117, 0.5);
        border-radius: 15px;
    }

    .user_name, .feedback_data, .feedback-text > p, .col-sm-6.col-xs-12 {
        color: #fff !important;
        opacity: 1;
    }

    .feedback-text > p {
        font-size: 20px;
    }

    .logo_red_xtz {
        margin-left: 5%;
        margin-right: 5%;
        height: 50%;
    }

    .fl_body {
        width: 70%;
    }

    .feedbacks-section .loader_more a {
        color: #ff7e02;
    }

    a:hover {
        text-decoration: none !important;
    }

    .owl-next {
        float: right;
        padding-right: 20%;
        background: no-repeat;
        border: none;
        font-size: 8px;
        color: #416df2;
    }

    .owl-prev {
        padding-left: 20%;
        background: no-repeat;
        border: none;
        font-size: 8px;
        color: #416df2;
    }

    .owl-prev:hover, .owl-next:hover {
        color: #ff7e02;
    }

    .owl-nav {
        position: fixed;
        width: 150px;

        padding-top: 2%;
    }

    .before_xtz, .after_xtz {
        width: 49%;
        font-size: 24px;
        color: white;
    }
</style>


<section class="feedbacks-section">

    <div class="container">

            <div class="before_xtz" style="float: left;"> До</div>
            <div class="after_xtz" style="float: right"> После</div>

        <div class="owl-carousel">

            <?php if (isset($our_works) && !empty($our_works)) { ?>
                <?php foreach ($our_works as $our_work) { ?>
                    <img src="/img/our_works/<?= $our_work["car_before"]; ?>">
                    <img src="/img/our_works/<?= $our_work["car_after"]; ?>">
                    <!--                    <div class="feedback-text">-->
                    <!--                        <p>--><? //= \yii\helpers\Html::encode($our_work['text']); ?><!--</p>-->
                    <!--                    </div>-->
                <?php } ?>
            <?php } ?>
        </div>
    </div>
</section>
<?php
if ($pageInfo) {
    if (!empty($pageInfo["description"])) { ?>
        <section class="form_opinion">
            <div class="container">
                <div class="col-sm-6 col-xs-12">
                    <?= $pageInfo["description"]; ?>
                </div>
            </div>
        </section>
        <?php
    }
}
?>
<script>
    $(function () {
        $('.owl-carousel').owlCarousel({
            items: 2,

            autoplay: true,
            autoplayTimeout: 3000,
            loop: true,
            navigation: true,
            navigationText: ['<i class="fa fa-chevron-left fa-5x"></i>', '<i class="fa fa-chevron-right fa-5x"></i>'],
            pagination: true,
            margin: 0,
            stopOnHover: true,
            transitionStyle: "backSlide",
            dots: false

        });
        $('.owl-nav').removeClass('disabled');
        $('.owl-nav').addClass('active');
    });
</script>



