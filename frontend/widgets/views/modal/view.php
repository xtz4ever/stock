<?php
use yii\helpers\Url;
use frontend\widgets\WLang;
use kartik\form\ActiveForm;
use yii\helpers\Html;
use common\models\AccProduct;
use himiklab\yii2\recaptcha\ReCaptcha;
$lang = substr(Yii::$app->language, 0, 2);


?>


<?php //if (Yii::$app->session->hasFlash('ModalFormOpen')): ?>
<!--    --><?php //$this->registerJs( "$('.modal_index').addClass('modal_open');", yii\web\View::POS_READY ); ?>
<?php //endif; ?>



<?php //if (Yii::$app->session->hasFlash('ModalFormOpen')): ?>
<!--    <div id="close_allert_success_index asdasd" style="z-index: 999999; position: absolute;margin-top: 25%;margin-left: 36%;">-->
<!--        --><?php //var_dump('AAAAAAAAAAAAAAAAAAAA');?>
<!--    </div>-->
<?php //endif; ?>


<div class="modal_index "> <!-- что бы включалась добавить класс modal_open-->
    <?php //var_dump($product);?>
    <div class="modal_window"><i class="fa fa-times-circle-o"></i>
        <p><?= $page_text['modal_form_text_1']; ?></p>
        <div class="good_absent"><?='';?></div>
        <div class="e_mail_p">
            <p><?= $page_text['modal_form_text_2'] ?></p>
            <span><?= $page_text['modal_form_text_3'] ?></span>
        </div>



        <div class="form_modal">

            <?php $form = ActiveForm::begin([
                'id' => 'modal-form',
                'action' => ['index'],
                'method' => 'post',
            ]); ?>


            <?= $form->field($model, 'fom_name')->hiddenInput(['value' => 'модальная форма', 'style' => ['display' => 'none']])->label(false); ?>
            <?= $form->field($model, 'status')->hiddenInput(['value' => '0', 'style' => ['display' => 'none']])->label(false); ?>

            <?= $form->field($model, 'product_name')->hiddenInput(['value' => '','style' => ['display' => 'none']])->label(false); ?>

            <?= $form->field($model, 'email')->textInput(['maxlength' => true, 'placeholder' => 'E-mail'])->label(false); ?>
            <?= $form->field($model, 'quantyti')->textInput(['value' => '','style' => ['max-width' => '50%']])->label(false); ?>

            <?= $form->field($model, 'reCaptcha', ['enableAjaxValidation' => false])->widget(ReCaptcha::className(),
                ['siteKey' => '6Le0nz0UAAAAAPA7i9NW_W7SIDiBCTwaRSJ9m32f', 'theme' => 'white']
            )->label('') ?>

            <div class="form-group">
                <?= Html::submitButton($page_text['form_button'], ['class' => 'btn-form', 'style' => ['float' => 'right', 'margin-top' => '-10%']]) ?>
            </div>

            <?php ActiveForm::end(); ?>

            <!--                <form>-->
            <!--                    <input type="e-mail" name="email" placeholder="E-mail">-->
            <!--                    <div class="wrap_input_button">-->
            <!--                        <input type="text" name="name">-->
            <!--                        <input class="btn-form" type="submit">-->
            <!--                    </div>-->
            <!--                </form>-->
        </div>
    </div>
    <div class="overlay"></div>
</div>

<div class="modal_payments">
    <div class="modal_window"><i class="fa fa-times-circle-o"></i>
        <p>ВЫВОД СРЕДСТВ:</p>
        <div class="your_curr_count">Ваш счет:<span class="curr_payment"></span></div>
        <div class="form_modal">
            <form class="extended_submit">
                <input class="payments_modal_input" type="text" name="text"
                       title="Сумма вывода не может превышать сумму на Вашем счету" placeholder="Введите сумму">
                <div class="select">
                    <div class="slct_arrow"><i class="fa fa-angle-down"></i></div>
                    <a class="slct" href="#">WebMoney</a>
                    <ul class="drop">
                        <li>WebMoney</li>
                        <li>Yandex-деньги</li>
                        <li>Scrill</li>
                    </ul>
                </div>
                <input class="btn-form extended_submit" type="submit">
            </form>
        </div>
    </div>
    <div class="overlay"></div>
</div>