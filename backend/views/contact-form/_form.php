
<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use kartik\widgets\SwitchInput;

/* @var $this yii\web\View */
/* @var $model common\models\Feedbacs */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="feedbacs-form">
    <div class="admin_form_me_custom_medium" style="float: left; width: 40%;height: 550px;">
        <?php $form = ActiveForm::begin(); ?>

        <div style="width: 48%;float: left;margin-right: 2%">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>
        <div style="width: 48%;float: left">
            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
        </div>





        <div style="width: 48%;float: left;margin-right: 2%">
            <?= $form->field($model, 'telephone')->textInput(['maxlength' => true]) ?>
        </div>

        <div style="width: 50%;float: left">
            <?= $form->field($model, 'status')->widget(SwitchInput::classname(), ['pluginOptions' => [
                'onText' => 'Отмодерирован',
                'offText' => 'Ждет модерации',
            ]])->label('Активность'); ?>
        </div>

        <?= $form->field($model, 'subject')->textarea(['rows' => 6]) ?>


        <div class="form-group" style="padding-top: 10%;">
            <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
