<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\SwitchInput;
use kartik\file\FileInput;
use vova07\imperavi\Widget;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\Event */
/* @var $form yii\widgets\ActiveForm */
?>
<style>
    .kv-file-content > img {
        width: 100%;
    }

</style>


    <?php $form = ActiveForm::begin(); ?>

<div class="admin_form_me_custom" style="width: 50%; float: left">

    <?= $form->field($model, 'parent_id')->dropDownList(\common\models\Services::getAllServices(), [
        'id' => 'name',
        'prompt' => 'Выберите Категорию',
        [
            'disabled' => true,
        ]])->label('Для какого мероприятия'); ?>

    <?= $form->field($model, 'position')->textInput() ?>

    <?php if ($model->isNewRecord === true) { ?>

        <?= $form->field($model, 'file[]')->widget(FileInput::classname(), [
            'options' => ['multiple' => 'true'],
        ]) ?>

    <?php } else { ?>
        <style>

            .kv-preview-thumb > img{
                width: 33.333%!important;
            }
        </style>
        <?php $images = explode('**', trim($model->imgs));

        $imgs = '';
        foreach ($images as $image) {
            if ($image == ''){
                continue;
            }

            $imgs .= "<b class='kv-file-content' style='float: left;padding-right: 1%;width: 33%;'>" . Html::img("/img/" . $image) . "</b>";
        }
        echo $imgs;
        ?>
        <?= $form->field($model, 'file[]')->widget(FileInput::classname(), [
            'options' => ['multiple' => 'true'],
        ]); ?>

    <?php } ?>


    <div style="height: 40px;margin-bottom: 40px;">
        <?= $form->field($model, 'status')->widget(SwitchInput::classname(), ['pluginOptions' => [
            'onText' => 'Да',
            'offText' => 'Нет',
        ]])->label('Отображать позицию на сайте или нет (вкл. / выкл.)'); ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
</div>
<div id="russion" style="max-width: 50%; padding-top: 30px;float: right;margin-right: 25px;" class="admin_form_me_custom">
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


