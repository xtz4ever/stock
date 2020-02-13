<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\SwitchInput;

/* @var $this yii\web\View */
/* @var $model common\models\Contacts */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="admin_form_me_custom">

    <?php $form = ActiveForm::begin(); ?>

    <?php
    $items = [];

    foreach ($model::getAllContactsType() as $k => $v) {
    $items[$k] = "$v";
    }

    ?>

    <?= $form->field($model, 'contact_type')->dropDownList($items, [
        'id' => 'contact_type',
        'prompt' => 'Формат контакта',
        [
            'disabled' => true,
        ]])->label(''); ?>


    <?= $form->field($model, 'text')->textInput(['maxlength' => true]) ?>

    <div style="height: 40px;margin-bottom: 40px;">
        <?= $form->field($model, 'status')->widget(SwitchInput::classname(), ['pluginOptions' => [
            'onText' => 'Да',
            'offText' => 'Нет',
        ]])->label('Статус'); ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
