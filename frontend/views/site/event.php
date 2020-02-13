<?php

use frontend\assets\AppAsset;
use \yii\helpers\Url;
use kartik\form\ActiveForm;
use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\widgets\Pjax;
use himiklab\yii2\recaptcha\ReCaptcha;
?>
<script src="js/jquery-1.12.4.min.js"></script>
<script src="js/jquery.magnific-popup.js"></script>

<style>
    .proxy_ipv6_item_inner > a > img {
        opacity: 1;
    }
    .countries_and_prices_wrap.center-block.col-sm-12{
        padding-top: 10%;
        font-size: 15px;
    }


    .control-label {
        font-weight: 400;
        color: #575858;
        font-size: 20px;
        display: none!important;
    }

    h4 {
        font-size: 26px;
        font-weight: 400;
        color: #575858;
        margin-bottom: 2%;
    }

    .help-block {
        display: none;

    }

    .feedbacks-section .loader_more {
        font-size: 50px;

        position: absolute;
        width: 100%;
    }

    .feedbacks_list {
        text-align: center;
        position: relative;
    }



    .fl_item, .form_opinion > .container {
        background-color: #e5e5e5;
        border-radius: 15px;
    }

    .user_name, .feedback_data, .feedback-text > p, .col-sm-6.col-xs-12 {
        color: #575858;
    !important;
        opacity: 1;
    }

    .feedback-text > p {
        font-size: 20px;
    }

    .feedback-text {
        text-align: left;
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
        color: #575858;
    }

    a:hover {
        text-decoration: none !important;
    }
    .btn-form{
        font-size: 20px;
    }
    .сontacts {
        min-height: 758px;
        padding-bottom: 5%;
    }
    .сontacts_item_left {
        font-size: 20px;
    }
    .container > .row{
        padding-bottom: 20px;
    }
    .feedbacks-section{
        padding-top: 50px;
    }


    .proxy_ipv6_item_inner:hover {
        transition: 1s;
        -webkit-transform: scale(1.2);
        -ms-transform: scale(1.2);
        transform: scale(1.2);
    }
    .alert-success{
        display: none!important;
    }
    .password-recovery{
        display: block;
    }
</style>
<?php

$this->registerCssFile('css/magnific.css',
    ['depends' => [AppAsset::className()],
        'position' => \yii\web\View::POS_HEAD
    ]);

$this->registerCssFile('css/feedbacks.css',
    ['depends' => [AppAsset::className()],
        'position' => \yii\web\View::POS_END
    ]);

?>
<?php
if (Yii::$app->session->hasFlash('success')){?>
    <!-- Модальное окно unsuccessful-payment -->
    <div class="popup password-recovery" data-modal="password-recovery">
        <div class="dm-table">
            <div class="dm-cell">
                <div class="dm-modal">
                    <a href="#" class="close">
                        <i class="fa fa-close"></i>
                    </a>
                    <div class="password-recovery__top-level">

                        <p><?=$page_text['success_message'];?></p>

                    </div>
                </div>
            </div>
        </div>
        <div class="overlay">
        </div>
    </div>

    <script>
        setTimeout(function () {
            $('.password-recovery').css({'display':'none'});
        }, 5000);
    </script>
<?php } ?>

<section class="proxy_ipv6">
    <div class="container">
        <div class="row">
            <div class="proxy_ipv6_title">
                <h1 class="inner"><?= $pageInfo['h1']; ?></h1>


            </div>
            <div class="proxy_ipv6_items ani">
                <div class="popup-gallery">
                    <?php
                    if (isset($images)) {
                        foreach ($images as $val) {
                            if ($val == '') {
                                continue;
                            }
                            ?>

                            <div class="margin_b col-lg-4 col-md-4 col-sm-4 col-xs-6">
                                <div class="proxy_ipv6_item">

                                    <div class="proxy_ipv6_item_inner">
                                        <a href="<?= 'img/' . $val; ?>" rel="alternate">
                                            <?= \yii\helpers\Html::img('img/' . $val); ?>
                                        </a>
                                    </div>
                                </div>
                            </div>


                            <?php
                        }
                    }
                    ?>
                </div>
            </div>

            
        </div>
    </div>
</section>

<script>
    $('.popup-gallery').magnificPopup({
        delegate: 'a',
        type: 'image',
        tLoading: 'Загрузка изображения #%curr%...',
        gallery: {
            enabled: true,
            navigateByImgClick: true,
            preload: [0, 1] // Will preload 0 - before current, and 1 after the current image
        }

    });
</script>

<?php if (isset($fedbacks) && !empty($fedbacks)) { ?>
<section class="proxy_ipv6">
    <div class="container" style="text-align: center">
        <h2 class="inner"> Отзывы </h2>
    </div>
</section>

<section class="feedbacks-section">

    <div class="container">


        <div class="center-block col-sm-12" style="float: inherit;">
            <?php Pjax::begin(['enablePushState' => false]); ?>

            <div class="feedbacks_list">


                    <?php foreach ($fedbacks as $fedback) { ?>

                        <div class="fl_item">
                            <div class="logo_red_xtz">

                                <div id="loading-center-absolute">
                                    <img src="img/logo.png" alt="">
                                </div>
                            </div>
                            <div class="fl_body">
                                <div class="user_data_dots">
                                    <div class="wrap_user_data">
                                        <div class="user_name">

                                            <?= \yii\helpers\Html::encode($fedback["name"]); ?></div>

                                        <div class="feedback_data"><?= date("d/m/Y", (strtotime($fedback['date']))); ?></div>
                                    </div>

                                </div>
                                <div class="feedback-text">
                                    <p><?= \yii\helpers\Html::encode($fedback['message']); ?></p>
                                </div>
                            </div>
                        </div>


                    <?php } ?>


                <?= \frontend\components\MyPaginationFeedbacks::widget(['pagination' => $page]); ?>

            </div>

            <?php Pjax::end(); ?>
        </div>
    </div>
</section>
<?php } ?>


<!-- Секция сontacts -->
<section class="сontacts">
    <div class="container">
        <div class="row">
            <h1 class="center inner">Оставить отзыв</h1>
            <div class="сontacts_items clearfix">
                <div class="сontacts_item_left col-lg-4 ">

                    <!--                    --><?php //if ($pageInfo) {
                    //                        if (!empty($pageInfo["description"])) {
                    //                            echo $pageInfo["description"];
                    //                        }
                    //                    } ?>

                </div>


                <div class="сontacts_item_form col-lg-6">

                    <?php
                    $form = ActiveForm::begin(

                    );
                    ?>
                    <div>
                        <label>Имя:</label>
                        <div class="modal_form_input_wrap">
                            <div class="modal_input_error">Заполните поле
                                <div class="modal_error_triangle"></div>
                                <div class="modal_error_chest_img"></div>
                            </div>
                            <?= $form->field($model, 'name')->textInput(['class' => 'modal_form_input', 'placeholder' => "Введите ваше имя."])->label(false); ?>

                        </div>
                    </div>
                    <div>
                        <label>E-mail:</label>
                        <div class="modal_form_input_wrap">
                            <div class="modal_input_error">Заполните поле
                                <div class="modal_error_triangle"></div>
                                <div class="modal_error_chest_img"></div>
                            </div>
                            <?= $form->field($model, 'email')->textInput(['class' => 'modal_form_email', 'placeholder' => "Ваш действующий email адрес"])->label(false); ?>


                        </div>
                    </div>


                    <div>
                        <label>Сообщение:</label>
                        <div class="modal_form_input_wrap dis_block">
                            <div class="modal_input_error">Заполните поле
                                <div class="modal_error_triangle"></div>
                                <div class="modal_error_chest_img"></div>
                            </div>
                            <?= $form->field($model, 'message')->textarea(['rows' => '6', 'class' => '', 'placeholder' => 'Введите сообщение.']) ?>


                        </div>
                    </div>
                    <div style="display: none">
                        <?= $form->field($model, 'date')->hiddenInput()->label(''); ?>

                        <?= $form->field($model, 'status')->hiddenInput(['value' => 0])->label(''); ?>
                        <?= $form->field($model, 'work_id')->hiddenInput(['value' => $parent_id])->label(''); ?>
                    </div>

                    <?= $form->field($model, 'reCaptcha', ['enableAjaxValidation' => false])->widget(ReCaptcha::className(),
                        ['siteKey' => Yii::$app->params['reCaptcha_siteKey'] , 'theme' => 'white']
                    )->label('') ?>


                    <?= Html::submitButton('Отправить', ['class' => 'btn-form']) ?>
                    <?php ActiveForm::end(); ?>

                </div>
            </div>
            
        </div>
        <div class="countries_and_prices_wrap center-block col-sm-12">
            <?= $pageInfo['description']; ?>
        </div>
    </div>
</section>