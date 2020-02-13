<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\SwitchInput;
/* @var $this yii\web\View */
/* @var $model common\models\Faq */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="admin_form_me_custom">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'question')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'answer')->textarea(['rows' => 6]) ?>

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
