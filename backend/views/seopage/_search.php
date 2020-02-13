<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\SeoPageSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="seo-page-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'page_name') ?>

    <?= $form->field($model, 'seo_title_ru') ?>

    <?= $form->field($model, 'seo_description_ru') ?>

    <?= $form->field($model, 'seo_keywords_ru') ?>

    <?php // echo $form->field($model, 'seo_image_alt_ru') ?>

    <?php // echo $form->field($model, 'seo_image_title_ru') ?>

    <?php // echo $form->field($model, 'description_ru') ?>

    <?php // echo $form->field($model, 'h1_ru') ?>

    <?php // echo $form->field($model, 'seo_title_en') ?>

    <?php // echo $form->field($model, 'seo_description_en') ?>

    <?php // echo $form->field($model, 'seo_keywords_en') ?>

    <?php // echo $form->field($model, 'seo_image_alt_en') ?>

    <?php // echo $form->field($model, 'seo_image_title_en') ?>

    <?php // echo $form->field($model, 'description_en') ?>

    <?php // echo $form->field($model, 'h1_en') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
