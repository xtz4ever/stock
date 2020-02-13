<?php
use frontend\assets\AppAsset;

use kartik\form\ActiveForm;
use yii\helpers\Html;

$this->registerJsFile('js/index.js',
    ['depends' => [AppAsset::className()],
        'position' => \yii\web\View::POS_END
    ]);

$this->registerCssFile('css/index.css',
    ['depends' => [AppAsset::className()],
        'position' => \yii\web\View::POS_HEAD
    ]);
?>

<style>
    input#loginform-password {
        width: 100%;
        margin-left: 3%;

    }
    input#resetpasswordform-password{
        margin-bottom: 5%;
    }


</style>

<section class="other_main" >
    <div class="container" style="/*margin-top: 150px;*/">


        <div class="form_valid_wrap" style="margin-left: 25%;margin-top: 20%;">
            <div class="form_container" style="text-align: center;">

                <p><?= $page_text['new_pass']; ?></p>

                <?php $form = ActiveForm::begin(['id' => 'reset-password-form']); ?>



                <?= $form->field($model, 'password')->passwordInput(['autofocus' => true]) ?>

                <div class="form-group">
                    <?= Html::submitButton($page_text['registration_button'], ['class' => 'btn-form']) ?>
                </div>

                <?php ActiveForm::end(); ?>

            </div>

        </div>

    </div>
</section>
