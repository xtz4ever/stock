<?php

use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use yii\bootstrap\ActiveForm;
use vova07\imperavi\Widget;

/* @var $this yii\web\View */
/* @var $model common\models\SeoPage */
/* @var $form yii\bootstrap\ActiveForm */
?>


<div class="seo-page-form">

    <div class="admin_form_me_custom" style="text-align: center;">
        <div class="button-tab-langs">
            <?php foreach ($langs as $lang => $name){ ?>
                <a href="#" class="btn btn-success seo-lang-button" style="width: 25%;" data-lang="<?=$lang;?>"><?=$name;?></a>
            <?php } ?>
        </div>
    </div>
    <div class="admin_form_me_custom">


    <?= Html::beginForm(['seopage/update', 'page_name' => $page_name], 'post', ['enctype' => 'multipart/form-data']) ?>

    <?= Html::button('Сохранить', ['class' => 'btn btn-success']) ?>

    <?php foreach ($langs as $key => $lang) { ?>

        <div id="<?=$lang?>" style="display: none;" class="admin_form_me_custom_medium seo-langs-form">
        <div class="form-group field-faq-question required">
            <label class="control-label" for="faq-question">Вопрос</label>
            <?= Html::input('text', "page_name[$key]", $model[$key]['page_name']) ?>

            <div class="help-block"></div>
        </div>
        </div>


    <?php } ?>



    <?= Html::endForm() ?>
</div>
</div>
