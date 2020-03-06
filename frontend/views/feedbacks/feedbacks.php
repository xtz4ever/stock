<?php

use frontend\assets\FeedbacksAsset;
use frontend\assets\AppAsset;
use \yii\helpers\Url;
use kartik\form\ActiveForm;
use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\widgets\Pjax;
use himiklab\yii2\recaptcha\ReCaptcha;
use yii\bootstrap\Modal;


$this->registerAssetBundle('frontend\assets\FeedbacksAsset');
?>

<?php if (Yii::$app->session->hasFlash('success')){?>

<div class="popup pop_order_form password-recovery" data-modal="modal-2" style="display: block">
    <div class="dm-table">
        <div class="dm-cell">
            <div class="dm-modal">
                <a href="#" class="close">

                </a>
                <p class="modal_title">
                    Оставить отзыв
                </p>

                <div class="inner_form">
                    <?='SUCCESS';?>

                </div>
            </div>
        </div>
    </div>
</div>


    <script>
        setTimeout(function () {
            // $('.password-recovery').css({'display':'none'});
            $('.password-recovery').fadeOut('slow');
        }, 5000);
    </script>
<?php } ?>

<section class="feedbacks-section">
    <div class="center-block col-sm-8" style="float: inherit;">
        <h1 class="center inner"><?=$pageInfo['h1'];?></h1>

    </div>
    <div class="container">

        <div class="center-block col-sm-8" style="float: inherit;">
            <?php Pjax::begin(['enablePushState' => false]); ?>

            <div class="feedbacks_list">

                <?php if (isset($fedbacks) && !empty($fedbacks)) { ?>
                    <?php foreach ($fedbacks as $fedback) { ?>

                        <div class="fl_item">
                            <div class="fl_body">
                                <div id="loading-center-absolute">
<!--                                    <img src="/img/logo.png" alt="">-->
                                </div>

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
                <?php } ?>

                <?= \frontend\components\MyPaginationFeedbacks::widget(['pagination' => $page]); ?>

            </div>

            <?php Pjax::end(); ?>
        </div>
    </div>
</section>

<div class="popup pop_order_form" data-modal="modal-1">
    <div class="dm-table">
        <div class="dm-cell">
            <div class="dm-modal">
                <a href="#" class="close">

                </a>
                <p class="modal_title">
                    Оставить отзыв
                </p>
                <p class='success_mail'>Спасибо! Ваша заявка уже обрабатывается менеджером и в ближайшее время он с
                    вами
                    свяжется.</p>
            <div class="inner_form">
                <?php
                $form = ActiveForm::begin(

                );
                ?>
                <div>
                    <label><?=$translates['form_label_name'];?></label>
                    <div class="modal_form_input_wrap">
                        <div class="modal_input_error">Заполните поле
                            <div class="modal_error_triangle"></div>
                            <div class="modal_error_chest_img"></div>
                        </div>
                        <?= $form->field($model, 'name')->textInput(['class' => 'modal_form_input', 'placeholder' => "Введите ваше имя."]); ?>

                    </div>
                </div>
                <div>
                    <label>E-mail:</label>
                    <div class="modal_form_input_wrap">
                        <div class="modal_input_error">Заполните поле
                            <div class="modal_error_triangle"></div>
                            <div class="modal_error_chest_img"></div>
                        </div>
                        <?= $form->field($model, 'email')->textInput(['class' => '', 'placeholder' => "Ваш действующий email адрес"]); ?>


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
                </div>

               <!-- --><?php /*echo $form->field($model, 'reCaptcha', ['enableAjaxValidation' => false])->widget(ReCaptcha::className(),
                    ['siteKey' => Yii::$app->params['reCaptcha_siteKey'] , 'theme' => 'white']
                )->label('') */?>


                <?= Html::submitButton('Отправить', ['class' => 'btn-form']) ?>
                <?php ActiveForm::end(); ?>
            </div>

            </div>
        </div>
    </div>
    <div class="overlay">
    </div>
</div>

<!-- Секция сontacts -->
<section class="сontacts">
    <div class="container">

        <div class="row">

<!--            <h1 class="center inner accordion accordion_title accordion_xtz"><a>Оставить отзыв</a></h1>-->
            <h1 class="center inner ">
                <a data-modal="modal-1" class="modal_xtz"  href="#">Оставить отзыв</a>
            </h1>

            <div class="сontacts_items clearfix accordion_content">
                <div class="сontacts_item_left col-lg-4 ">

<!--                    --><?php //if ($pageInfo) {
//                        if (!empty($pageInfo["description"])) {
//                            echo $pageInfo["description"];
//                        }
//                    } ?>
                </div>
            </div>
        </div>
    </div>
</section>



