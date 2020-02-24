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

    $langs = \common\models\Lang::getAllLangs();


    $form = ActiveForm::begin(); ?>




    <div class="form-group seopage" style="padding-bottom: 20px">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-info']) ?>
    </div>
<div class="admin_form_me_custom" style="display: none">
    <?= $form->field($model0, 'page_name')->textInput(['maxlength' => true]) ?>
    <div style="color: red;font-size: 25px" >
        Название страницы должно ПОЛНОСТЬЮ СОВПАДАТЬ С ее URL ! <b style="color: #62c462">НЕЛЬЗЯ писать в URL КИРИЛИЧЕСКИЕ СИМВОЛЫ</b>
    </div>
</div>
<div style="color: #f7ff00;font-size: 25px;text-align: center;">
    Кликните по языку, который нужно заполнить или отредактировать
</div>
    <div class="button-tab-langs">
    <?php foreach ($langs as $lang => $name){ ?>
        <a href="#" class="btn btn-success seo-lang-button" data-lang="<?=$lang;?>"><?=$name;?></a>
    <?php } ?>
    </div>

<!--        --><?php
//    foreach ($langs as $lang => $name){
//    ?>



    <div id="<?=$lang?>" style="display: none;" class="admin_form_me_custom_medium seo-langs-form">



        <?= $form->field($model0, 'lang')->hiddenInput(['maxlength' => true,'readonly'=> true])->label('') ?>

        <?= $form->field($model0, 'seo_title')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model0, 'seo_description')->textarea(['rows' => 6]) ?>

        <?= $form->field($model0, 'seo_keywords')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model0, 'h1')->textarea(['rows' => 6]) ?>

        <?= $form->field($model0, 'description')->textarea(['rows' => 12]) ?>


        <?= $form->field($model1, 'lang')->hiddenInput(['maxlength' => true,'readonly'=> true])->label('') ?>

        <?= $form->field($model1, 'seo_title')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model1, 'seo_description')->textarea(['rows' => 6]) ?>

        <?= $form->field($model1, 'seo_keywords')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model1, 'h1')->textarea(['rows' => 6]) ?>

        <?= $form->field($model1, 'description')->textarea(['rows' => 12]) ?>



        <?= $form->field($model2, 'lang')->hiddenInput(['maxlength' => true,'readonly'=> true])->label('') ?>

        <?= $form->field($model2, 'seo_title')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model2, 'seo_description')->textarea(['rows' => 6]) ?>

        <?= $form->field($model2, 'seo_keywords')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model2, 'h1')->textarea(['rows' => 6]) ?>

        <?= $form->field($model2, 'description')->textarea(['rows' => 12]) ?>



<!--    </div>-->
<?php //} ?>


    <?php ActiveForm::end(); ?>

</div>



