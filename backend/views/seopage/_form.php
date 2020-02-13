<?php

use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use yii\bootstrap\ActiveForm;
use vova07\imperavi\Widget;
/* @var $this yii\web\View */
/* @var $model common\models\SeoPage */
/* @var $form yii\bootstrap\ActiveForm */
?>
<!--s-->
<div class="seo-page-form">

    <?php
    $form = ActiveForm::begin(); ?>

    <div class="form-group seopage" >
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-info']) ?>
    </div>
<div class="admin_form_me_custom">
    <?= $form->field($model, 'page_name')->textInput(['maxlength' => true]) ?>
    <div style="color: red;font-size: 25px" >
        Название страницы должно ПОЛНОСТЬЮ СОВПАДАТЬ С ее URL ! <b style="color: #62c462">НЕЛЬЗЯ писать в URL КИРИЛИЧЕСКИЕ СИМВОЛЫ</b>
    </div>
</div>

    <div id="russion" style="display: block;float: left;
margin-right: 5%;width: 47%;" class="admin_form_me_custom">




        <?= $form->field($model, 'seo_title_ru')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'seo_description_ru')->textarea(['rows' => 6]) ?>

        <?= $form->field($model, 'seo_keywords_ru')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'seo_image_alt_ru')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'seo_image_title_ru')->textInput(['maxlength' => true]) ?>

<!--        --><?//= $form->field($model, 'description_ru')->textarea(['rows' => 6]) ?>

        <?= $form->field($model, 'description_ru')->widget(Widget::classname(), [
            'settings' => [
                'lang' => 'ru',
                'minHeight' => 300,
                'pastePlainText' => true,
                'buttonSource' => true,
                'paragraphize' => false,
                'replaceTags' => false,
                'replaceDivs' => false,
                'plugins' => [
                    'clips',
                    'fullscreen'
                ],

            ]
        ]);?>


        <?= $form->field($model, 'h1_ru')->textarea(['rows' => 6]) ?>
    </div>



    <div id="english" style="display: none;float: left;width: 47%;" class="admin_form_me_custom">
        <?= $form->field($model, 'seo_title_en')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'seo_description_en')->textarea(['rows' => 6]) ?>

        <?= $form->field($model, 'seo_keywords_en')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'seo_image_alt_en')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'seo_image_title_en')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'description_en')->widget(Widget::classname(), [
            'settings' => [
                'lang' => 'ru',
                'minHeight' => 300,
                'pastePlainText' => true,
                'buttonSource' => true,
                'paragraphize' => false,
                'replaceTags' => false,
                'replaceDivs' => false,
                'plugins' => [
                    'clips',
                    'fullscreen'
                ],

            ]
        ]);?>

        <?= $form->field($model, 'h1_en')->textarea(['rows' => 6]) ?>
    </div>


    <?php ActiveForm::end(); ?>

</div>



