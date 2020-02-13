<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\SwitchInput;
use kartik\file\FileInput;
use vova07\imperavi\Widget;

/* @var $this yii\web\View */
/* @var $model common\models\OurWorks */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="admin_form_me_custom">

    <?php $form = ActiveForm::begin(); ?>





    <?php if ($model->isNewRecord === true) { ?>

        <?= $form->field($model, 'car_before')->widget(FileInput::classname())->label('Картинка ДО проведенных работ'); ?>

        <?= $form->field($model, 'car_after')->widget(FileInput::classname())->label('Картинка ПОСЛЕ проведенных работ'); ?>

    <?php } else { ?>

        <?= $form->field($model, 'car_before')->widget(FileInput::classname(), ['pluginOptions' => [
            'previewFileType' => 'image',
            'value' => 'AAA',
            'initialPreview' => [
                Html::img("/img/" . $model->car_before)
            ],
            'overwriteInitial' => true
        ]])->label('Картинка для категории главная'); ?>

        <?= $form->field($model, 'car_after')->widget(FileInput::classname(), ['pluginOptions' => [
            'previewFileType' => 'image',
            'initialPreview' => [
                Html::img("/img/" . $model->car_after)
            ],
            'overwriteInitial' => true
        ]])->label('Картинка для категории в правом сайд баре'); ?>


    <?php } ?>




<!--    --><?//= $form->field($model, 'text')->textarea(['rows' => 6]) ?>

    <div style="height: 40px;margin-bottom: 40px;">
        <?= $form->field($model, 'status')->widget(SwitchInput::classname(), ['pluginOptions' => [
            'onText' => 'Да',
            'offText' => 'Нет',
        ]])->label('Отображать позицию на сайте или нет (вкл. / выкл.)'); ?>
    </div>

    <?= $form->field($model, 'position')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
