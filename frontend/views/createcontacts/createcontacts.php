<?php

use frontend\assets\AppAsset;
use \yii\helpers\Url;
use kartik\form\ActiveForm;
use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\widgets\Pjax;
use himiklab\yii2\recaptcha\ReCaptcha;



$this->registerAssetBundle('frontend\assets\FeedbacksAsset');

//if (isset($meta['seo_title']) && !empty($meta['seo_title'])) {
//    $this->title = $meta['seo_title'];
//} else {
//    $this->title = "Контакты";
//}
//
//$this->registerMetaTag([
//    'name' => 'title',
//    'content' => $meta['title']
//]);
//$this->registerMetaTag([
//    'name' => 'description',
//    'content' => $meta['description']
//]);
//$this->registerMetaTag([
//    'name' => 'keywords',
//    'content' => $meta['keywords']
//]);


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
    <!-- Секция сontacts -->
    <section class="сontacts">
        <div class="container">
            <div class="row">
                <h1 class="center inner">Контакты</h1>
                <div class="сontacts_items clearfix">
                    <div class="сontacts_item_left col-lg-3 col-lg-offset-1">
                        <ul>
                            <?php if (!empty($contacts_telephone)): ?>

                                <?php foreach ($contacts_telephone as $val) { ?>
                                    <li>   <!--style="display: none"-->
                                        <div class="contact_i">
                                            <i class="fa fa-mobile-phone"></i>
                                        </div>
                                        <a href="tel:<?= str_replace(" ", "", $val['text']); ?>"><?= $val['text']; ?></a>
                                    </li>
                                <?php } ?>

                            <?php endif; ?>

                            <?php if (!empty($contacts_viber)): ?>
                                <?php foreach ($contacts_viber as $val) { ?>
                                    <li>
                                        <div class="contact_i">
                                            <i class="fab fa-viber"></i>
                                        </div>
                                        <?php
                                        $viber_number = str_replace(' ', '', $val['text']);
                                        $viber_number = str_replace('+', '%2B', $viber_number);
                                        ?>

                                        <a href="viber://chat?number=<?= $viber_number; ?>"><?= $val['text']; ?></a>
                                    </li>
                                <?php } ?>

                            <?php endif; ?>


                            <li style="padding-top: 4%">
                                <b><?= "Присоединяйтесь:" ?></b>
                            </li>

                            <?php if (!empty($contacts_faceboock)): ?>
                                <?php foreach ($contacts_faceboock as $val) { ?>

                                    <li>
                                        <!-- Load Facebook SDK for JavaScript -->
                                        <div id="fb-root">
                                            <div class="contact_i">
                                                <img style="width: 19px;margin-top: -5px;"
                                                     src="/img/facebook-square.svg"
                                                     alt="">
                                            </div>
                                            <a target="_blank"
                                               href="https://www.facebook.com/<?= $val['text']; ?>"><?= $val['text']; ?></a>
                                        </div>
                                    </li>
                                <?php } ?>

                            <?php endif; ?>
                            <?php if (!empty($contacts_instagram)): ?>
                                <?php foreach ($contacts_instagram as $val) { ?>
                                    <li>
                                        <div class="contact_i">
                                            <i class="fa fa-instagram"></i>
                                        </div>
                                        <a href="https://www.instagram.com/<?= $val['text']; ?>"
                                           target="_blank"><?= $val['text'] ?></a>
                                    </li>
                                <?php } ?>

                            <?php endif; ?>
                        </ul>
                    </div>


                    <div class="сontacts_item_form col-lg-7">
                        <h3>Отправить сообщение</h3>
                        <!--                    <form>-->
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
                        <div><label>Телефон:</label>
                            <div class="modal_form_input_wrap">
                                <div class="modal_input_error">Заполните поле
                                    <div class="modal_error_triangle"></div>
                                    <div class="modal_error_chest_img"></div>
                                </div>
                                <?= $form->field($model, 'telephone')->textInput(['class' => 'modal_form_email', 'placeholder' => "Ваш действующий телефон"])->label(false); ?>


                            </div>
                        </div>

                        <div>
                            <label>Сообщение:</label>
                            <div class="modal_form_input_wrap dis_block">
                                <div class="modal_input_error">Заполните поле
                                    <div class="modal_error_triangle"></div>
                                    <div class="modal_error_chest_img"></div>
                                </div>
                                <?= $form->field($model, 'subject')->textarea(['rows' => '6', 'class' => '', 'placeholder' => 'Введите сообщение.'])->label(false) ?>
                                <!--                                <textarea placeholder="Введите сообщение." name="name" class="modal_form_phone"></textarea>-->
                            </div>
                        </div>


                        <?= $form->field($model, 'reCaptcha', ['enableAjaxValidation' => false])->widget(ReCaptcha::className(),
                            ['siteKey' => Yii::$app->params['reCaptcha_siteKey'], 'theme' => 'white']
                        )->label('') ?>

                        <!--                        <input class="main_btn" type="submit" id="id_send_request" onclick="return false;" value="Отправить">-->
                        <?= Html::submitButton('Отправить', ['class' => 'btn-form']) ?>
                        <?php ActiveForm::end(); ?>
                        <!--                    </form>-->
                    </div>
                </div>
            </div>
        </div>
    </section>

