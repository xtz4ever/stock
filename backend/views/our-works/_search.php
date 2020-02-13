<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\OurWorksSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="our-works-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'car_before') ?>

    <?= $form->field($model, 'car_after') ?>

    <?= $form->field($model, 'text') ?>

    <?= $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'position') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
