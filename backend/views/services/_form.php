<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\SwitchInput;
use kartik\file\FileInput;
use vova07\imperavi\Widget;

/* @var $this yii\web\View */
/* @var $model common\models\Services */
/* @var $form yii\widgets\ActiveForm */
?>
<style>
    .kv-file-content > img{
        width: 100%;
    }
</style>
<div class="admin_form_me_custom_medium" id="hint_block" style=" font-size: 25px;color: red;width: 95%; margin-left: 3%">
    <p>Создание <a href="/bureyko/seopage" style="color: #82ff1a">СЕО</a>  для каждого мероприятия <strong>ОБЯЗАТЕЛЬНО</strong></p>
    <p>При создании СЕО для каждого мероприятия в поле  <strong>"Название Страницы"</strong>  вводить то, что вписывается в поле URL <strong style="color: white">вместе с event-</strong>. Эта запись должна иметь каждый раз
        <b>уникальное значение</b>, если не будет хватать фантазии,
        можно добавлять дату, или город, или что угодно, только через дефиз "-" или нижнее подчеркивание "_" <b style="color: #62c462">НЕЛЬЗЯ писать в URL КИРИЛИЧЕСКИЕ СИМВОЛЫ</b></p>

</div>


    <?php $form = ActiveForm::begin(); ?>
<div class="admin_form_me_custom_medium" style="width: 95%; margin-left: 3%">
    <?= $form->field($model, 'category_id')->dropDownList(\common\models\Category::getAllCategory(), [
        'id' => 'name',
        'prompt' => 'Выберите Категорию',
        [
            'disabled' => true,
        ]])->label('Для какой категории создается услуга'); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'text')->textarea(['rows' => 6 ]) ?>

    <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'time_to_work')->textInput(['maxlength' => true]) ?>




    <div style="height: 40px;margin-bottom: 40px;">
        <?= $form->field($model, 'status')->widget(SwitchInput::classname(), ['pluginOptions' => [
            'onText' => 'Да',
            'offText' => 'Нет',
        ]])->label('Отображать позицию на сайте или нет (вкл. / выкл.)'); ?>
    </div>

    <?php if ($model->isNewRecord === true) { ?>
        <?= $form->field($model, 'url')->textInput(['maxlength' => true , 'value' => 'event-']) ?>
        <?= $form->field($model, 'img')->widget(FileInput::classname())->label('Превью'); ?>



    <?php } else { ?>
        <?= $form->field($model, 'url')->textInput(['maxlength' => true ]) ?>

        <?= $form->field($model, 'img')->widget(FileInput::classname(), ['pluginOptions' => [
            'previewFileType' => 'image',
            'resizeImages' => true,
            'value' => 'AAA',
            'initialPreview' => [
                Html::img("/img/services/" . $model->img)
            ],
            'overwriteInitial' => true
        ]])->label('Картинка '); ?>
    <?php } ?>


</div>

<div id="russion" style="width: 95%; margin-left: 3%" class="admin_form_me_custom_medium">
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


<div class="admin_form_me_custom" style="width: 100%; float: left">

    <?/*= $form->field($model, 'parent_id')->dropDownList(\common\models\Services::getAllServices(), [
        'id' => 'name',
        'prompt' => 'Выберите Категорию',
        [
            'disabled' => true,
        ]])->label('Для какого мероприятия'); */?>




    <?php if ($model_event->isNewRecord === true) { ?>

        <?= $form->field($model_event, 'file[]')->widget(FileInput::classname(), [
            'options' => ['multiple' => 'true'],
        ]) ?>

    <?php } else { ?>
        <style>

            .kv-preview-thumb > img{
                width: 33.333%!important;
            }
        </style>
        <?php $images = explode('**', trim($model_event->imgs));

        $imgs = '';
        foreach ($images as $image) {
            if ($image == ''){
                continue;
            }

            $imgs .= "<b class='kv-file-content' style='float: left;padding-right: 1%;width: 20%;'>" . Html::img("/img/" . $image) . "</b>";
        }
        echo $imgs;
        ?>
    <div class="admin_form_me_custom" style="width: 100%; float: left">
        <?= $form->field($model_event, 'file[]')->widget(FileInput::classname(), [
            'options' => ['multiple' => 'true'],
        ]); ?>

    </div>

    <?php } ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-danger' : 'btn btn-danger']) ?>
    </div>
</div>
    <?php ActiveForm::end(); ?>


