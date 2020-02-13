<?php

use frontend\assets\AppAsset;
use \yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\widgets\Pjax;
use himiklab\yii2\recaptcha\ReCaptcha;

$this->registerJsFile('js/common.js',
    ['depends' => [AppAsset::className()],
        'position' => \yii\web\View::POS_END
    ]);
$this->registerCssFile('css/common.css',
    ['depends' => [AppAsset::className()],
        'position' => \yii\web\View::POS_HEAD
    ]);
?>


<style>
    .help-block {
        font-size: 13px;
    }

    .has-error > .help-block {
        padding-top: 4%;
    }

    .span-price {
        color: #bb0b3a;
        font-weight: 600;
    }

    .form-group.field-buyaccounts-email, .field-pay_method, .field-buyaccounts-promo_code {
        max-width: 55%;
    }

    #index-buy-btn {
        width: 170px;
        height: 50px;
    }
    .wrapper.text{
        width: 64.16%;
        padding: 25px 65px 30px 30px;
        background: #f4f5f7;
        -webkit-box-shadow: 3px 7px 5px 0 rgba(50,50,50,.5);
        box-shadow: 3px 7px 5px 0 rgba(50,50,50,.5);
    }
    .help-block-error{
        display: none;
    }
    .buyakkaynt_main{
        padding-top: 200px;
        max-width: 40%;
        margin-left: 10%;
        float: left;
        z-index: 10;
    }
    .buyakkaynt_main_text{
        padding-top: 200px;
        max-width: 46%;
        float: left;
        z-index: 10;
        font-size: 13px;
    }

    .promo-dicount{
        font-size: 15px;
    }


</style>
<section class="buyakkaynt_main" >
    <div class="container">
        <div class="wrapper">
            <div class="buyakkaynt_form">
                <h4 style="padding-bottom: 15px;"><?= $page_text['text_form_1'] ?> <?= $product_quantity . ' ' . $product_okonchanie; ?>  <?= $product_name; ?></h4>
                <div>
                    <p style="padding-bottom: 15px;font-size: 15px;"><?= $page_text['text_form_2'] ?> = <span
                                id="amount_due"
                                class="span-price"><?= round($product_price * $product_quantity * $kyrs['usd'], 2) ?>
                            RUB</span> &nbsp&nbsp&nbsp ( 1 USD = <span class="span-price"><?= round($kyrs['usd'], 2) ?>
                            RUB</span> ) &nbsp&nbsp&nbsp ( 1 EUR = <span
                                class="span-price"><?= round($kyrs['eur'], 2) ?> RUB</span> )</p>
                    <p class="promo-dicount" style="display: none;">
                    <?= $page_text['promo_success'].' ';?> <span class="span-price discount"><?= round($kyrs['eur'], 2) ?> RUB</span>
                    </p>
                </div>
                <input type="hidden" id="amount_due_input" style="display: none"
                       value="<?= round($product_price * $product_quantity * $kyrs['usd'], 2) ?>">
                <div class="payment_currency_exchange"></div>

                <?php $form = ActiveForm::begin([
                    'id' => 'form-buyakkounts-buyakkaynt-qwe',
                    'action' => 'pay',
                    'method' => 'post',
                    'enableAjaxValidation' => false,
                    'enableClientValidation' => true,

                ]); ?>

                <?= $form->field($model, 'email')->textInput(['maxlength' => true, 'placeholder' => 'email'])->label(''); ?>

                <?php

                $items = [];

                foreach ($payment_methods as $k => $v) {
                    $items[$k] = "$v";
                }

                ?>

                <?= $form->field($model, 'pay_method')->dropDownList($items, [
                    'id' => 'pay_method',
                    'prompt' => 'Способ оплаты',
                    [
                        'disabled' => true,
                    ]])->label(''); ?>

                <?= Html::a($page_text['text_form_3'], ['#'], ['id' => 'have_promo', 'style' => ['margin-left' => '15%', 'color' => 'green']]); ?>

                <div id="promo" style="display: none">
                    <?= $form->field($model, 'promo_code')->textInput(['maxlength' => true, 'placeholder' => 'Промо код'])->label(false); ?>
                </div>
                <div id="promo_error" style="display: none;color: red;font-size: 15px">
                    <?= $page_text['promo_error'] ?>
                </div>
                <div style="max-width: 100%">
                    <?= $form->field($model, 'accept_1')->checkbox([
                        'template' => '<div class="col-md-1">{input}</div><div>' . $page_text["text_form_4"] . ' <a href="conditions">' . $page_text["text_form_5"] . '</a></div><div style="text-align: left;max-width: 50%" >{error}</div>'
                    ])->label('') ?>
                </div>

                <div style="max-width: 100%">
                    <?= $form->field($model, 'accept_2')->checkbox([
                        'template' => '<div class="col-md-1">{input}</div><div>' . $page_text["text_form_6"] . '</div><div style="text-align: left;max-width: 50%" >{error}</div>'
                    ])->label('') ?>
                </div>

                <p style="font-size: 12px;color: red;padding: 10px;"><?= $page_text["text_form_7"] ?></p>


                <div class="DisplayNone" style="display: none;">
                    <?= $form->field($model, 'productId')->hiddenInput(['value' => $product_id])->label(false); ?>
                    <?= $form->field($model, 'quantity')->hiddenInput(['value' => $product_quantity])->label(false); ?>
                    <?= $form->field($model, 'productName')->hiddenInput(['value' => $product_name])->label(false); ?>
                    <?= $form->field($model, 'partner_id')->hiddenInput(['value' => $partner_id])->label(false); ?>
                </div>
                <?= Html::submitButton($page_text['text_form_8'], ['class' => 'buy_btn', 'id' => 'index-buy-btn']) ?>

                <?php ActiveForm::end(); ?>


            </div>
            <div class="sales_conditions"></div>
        </div>
    </div>
</section>
<section class="buyakkaynt_main_text">
    <div class="container">
        <div class="wrapper text">
            <div class="buyakkaynt_form">
                <?php if (isset($pageInfo)) { ?>

                    <h1><?= $pageInfo["h1"]; ?></h1>

                    <div class="QWEQWEQWE">
                        <?= $pageInfo["description"] ?>
                    </div>


                <?php } ?>
            </div>
            <div class="sales_conditions"></div>
        </div>
    </div>
</section>

<section class="ZZZZZ" style="padding-top: 60%;z-index: 1;float: none"></section>
