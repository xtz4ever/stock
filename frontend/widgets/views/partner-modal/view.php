<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model common\models\PartnerPaymentsList */
/* @var $form yii\widgets\ActiveForm */
?>


<style>
    #close_allert_success_index {
        position: absolute;
        margin-left: -3%;
        margin-top: -32%;
        max-width: 95%;
        background: #efaeae;
        text-align: center;
    }

    #partnerpaymentslist-amoun {
        width: 240px;
        height: 40px;
        font-size: 16px;
        padding: 0 10px;
    }

    #wallet_id {
        width: 400px;
        height: 40px;
        font-size: 16px;
        padding: 0 10px;
    }

    .help-block {
        display: none;
    }
</style>


<div class="modal_payments">
    <div class="modal_window"><i class="fa fa-times-circle-o" id="remove"></i>
        <p><?= $page_text['modal_h1']; ?></p>
        <div class="your_curr_count"><?= $page_text['modal_h2']; ?><span class="curr_payment"><?= $unpaid_amount; ?>
                $</span></div>
        <div class="form_modal">
            <?php Pjax::begin(['enablePushState' => false]); ?>

            <?php if (Yii::$app->session->hasFlash('error_amount')){ ?>

                    <?= Yii::$app->session->getFlash('error_amount'); ?>
                <script>
                    setTimeout(function () {

                        location.reload();
                    }, 3000);
                </script>


            <?php } elseif (Yii::$app->session->hasFlash('success_amount')){ ?>

                    <?= Yii::$app->session->getFlash('success_amount'); ?>

                <script>
                    setTimeout(function () {

                        location.reload();
                    }, 5000);
                </script>
            <?php } else { ?>

            <?php $form = ActiveForm::begin(
                ['options' => ['data-pjax' => true]
                    , 'method' => 'post']); ?>



            <?php
            if (Yii::$app->language == 'en-EN') {
                $wallet_name = 'wallet_name_en';
                $prompt = 'Select Wallet';
            } else {
                $wallet_name = 'wallet_name_ru';
                $prompt = 'Выберите Кошелек';
            }
            $dataCategory = ArrayHelper::map(\common\models\UserWallets::find()->where(['user_id' => Yii::$app->user->identity->getId(), 'for_partner' => 1])->asArray()->all(), 'id', $wallet_name);
            ?>

            <?= $form->field($model, 'wallet_id')->dropDownList($dataCategory, [
                'id' => 'wallet_id',
                'prompt' => $prompt,
                [
                    'disabled' => true,
                ]])->label(false); ?>


            <?= $form->field($model, 'amoun')->textInput(['placeholder' => 'СУММА ДЛЯ ВЫВОДА'])->label(false); ?>




            <?= Html::submitButton($page_text['modal_button'], ['class' => 'btn-form extended_submit']) ?>


            <?php ActiveForm::end(); ?>
            <?php } ?>
            <?php Pjax::end(); ?>
        </div>
    </div>
    <div class="overlay"></div>
</div>

