<?php

use kartik\file\FileInput;
use kartik\widgets\SwitchInput;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

use vova07\imperavi\Widget;
/* @var $this yii\web\View */
/* @var $model common\models\Category */
/* @var $form yii\widgets\ActiveForm */
?>
<style>
    .kv-file-content > img {
        width: 100%;
    }
</style>
<div class="admin_form_me_custom_medium" id="hint_block" style=" font-size: 25px;color: red;max-width: 100%;">
    <p>Создание <a href="/bureyko/seopage" style="color: #82ff1a">СЕО</a> для каждой категории
        <strong>ОБЯЗАТЕЛЬНО</strong></p>
    <p>При создании СЕО для каждой категории в поле <strong>"Название Страницы"</strong> вводить только то, что задается
        в поле URL ВМЕСТЕ С "service-" <b style="color: #62c462">НЕЛЬЗЯ писать в URL КИРИЛИЧЕСКИЕ СИМВОЛЫ</b></p>

</div>


    <?php $form = ActiveForm::begin(); ?>
<div class="admin_form_me_custom" style="float: left">
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>


    <div style="height: 40px;margin-bottom: 40px;">
        <?= $form->field($model, 'status')->widget(SwitchInput::classname(), ['pluginOptions' => [
            'onText' => 'Да',
            'offText' => 'Нет',
        ]])->label('Отображать позицию на сайте или нет (вкл. / выкл.)'); ?>
    </div>

    <?= $form->field($model, 'position')->textInput() ?>

    <?php if ($model->isNewRecord === true) { ?>
        <?= $form->field($model, 'url')->textInput(['maxlength' => true, 'value' => 'service-']) ?>
        <?= $form->field($model, 'img')->widget(FileInput::classname())->label('Картинка для категории главная'); ?>


    <?php } else { ?>
        <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'img')->widget(FileInput::classname(), ['pluginOptions' => [
            'previewFileType' => 'image',
            'resizeImages' => true,
            'value' => 'AAA',
            'initialPreview' => [
                Html::img("/img/" . $model->img)
            ],
            'overwriteInitial' => true
        ]])->label('Картинка для категории главная'); ?>
    <?php } ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

</div>
    <div  style="max-width: 50%;float: right;" class="admin_form_me_custom">
        <h3 style="text-align: center">СЕО </h3>
        <?= $form->field($model_seo, 'h1_ru')->widget(Widget::className(), [

            'settings' => [

                'lang' => 'ru',
                'removeWithoutAttr' => [],
                'minHeight' => 300,
                'pastePlainText' => true,
                'buttonSource' => true,
                'paragraphize' => false,
                'replaceTags' => false,
                'paragraphize' => false,
                'replaceTags' => false,
                'replaceDivs' => false,
                'plugins' => [
                    'clips',
                    'fullscreen',
                    'fontfamily',
                    'fontsize',
                    'fontcolor',
                    'video',
                    'table'
                ],
            ]
        ]); ?>

        <?= $form->field($model_seo, 'description_ru')->widget(Widget::className(), [
            'settings' => [
                'lang' => 'ru',
                'removeWithoutAttr' => [],
                'minHeight' => 300,
                'pastePlainText' => true,
                'buttonSource' => true,
                'paragraphize' => false,
                'replaceTags' => false,
                'paragraphize' => false,
                'replaceTags' => false,
                'replaceDivs' => false,
                'plugins' => [
                    'clips',
                    'fullscreen',
                    'fontfamily',
                    'fontsize',
                    'fontcolor',
                    'video',
                    'table'
                ],
            ]
        ]); ?>

        <?= $form->field($model_seo, 'seo_title_ru')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model_seo, 'seo_description_ru')->widget(Widget::className(), [
            'settings' => [
                'lang' => 'ru',
                'removeWithoutAttr' => [],
                'minHeight' => 300,
                'pastePlainText' => true,
                'buttonSource' => true,
                'paragraphize' => false,
                'replaceTags' => false,
                'replaceDivs' => false,
                'plugins' => [
                    'clips',
                    'fullscreen',
                    'fontfamily',
                    'fontsize',
                    'fontcolor',
                    'video',
                    'table'
                ],
            ]
        ]); ?>


        <?= $form->field($model_seo, 'seo_keywords_ru')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model_seo, 'seo_image_alt_ru')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model_seo, 'seo_image_title_ru')->textInput(['maxlength' => true]) ?>


    </div>



    <?php ActiveForm::end(); ?>


