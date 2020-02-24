<?php

use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use yii\bootstrap\ActiveForm;
use vova07\imperavi\Widget;

/* @var $this yii\web\View */
/* @var $model common\models\SeoPage */
/* @var $form yii\bootstrap\ActiveForm */
?>
<style>
    input, textarea {
        width: 100%;
    }
    textarea {
        height: 300px;
    }
</style>

<div class="seo-page-form">

    <div class="admin_form_me_custom" style="text-align: center;">
        <div class="button-tab-langs">
            <?php foreach ($langs as $lang => $name) { ?>
                <a href="#" class="btn btn-success seo-lang-button" style="width: 25%;"
                   data-lang="<?= $lang; ?>"><?= $name; ?></a>
            <?php } ?>
        </div>
    </div>


        <?= Html::beginForm(['seopage/update', 'page_name' => $page_name], 'post', ['enctype' => 'multipart/form-data']) ?>

    <div class="form-group field-faq-question required" style="display: none;opacity: 0;z-index: 0;">
        <label class="control-label" for="faq-question">Название Страницы</label>
        <?= Html::input('text', "page_name", $model['ru']['page_name']) ?>

        <div class="help-block"></div>
    </div>

        <?php foreach ($langs as $key => $lang) { ?>

            <div id="<?= $key ?>" style="display: none;" class="admin_form_me_custom_medium seo-langs-form">


                <div class="form-group field-faq-question required">
                    <label class="control-label" for="faq-question">Title ( Не виден на странице для СЕО )</label>
                    <?= Html::input('text', "seo_title[$key]", $model[$key]['seo_title']) ?>

                    <div class="help-block"></div>
                </div>

                <div class="form-group field-faq-question required">
                    <label class="control-label" for="faq-question">Description ( Не виден на странице для СЕО )</label>
                    <?= Html::input('text', "seo_description[$key]", $model[$key]['seo_description']) ?>

                    <div class="help-block"></div>
                </div>

                <div class="form-group field-faq-question required">
                    <label class="control-label" for="faq-question">Keywords ( Не виден на странице для СЕО )</label>
                    <?= Html::textarea("seo_keywords[$key]", $model[$key]['seo_keywords']) ?>

                    <div class="help-block"></div>
                </div>
                <div class="form-group field-faq-question required">
                    <label class="control-label" for="faq-question">Заголовок H1 ( Виден на странице )</label>
                    <?= Html::input('text', "h1[$key]", $model[$key]['h1']) ?>

                    <div class="help-block"></div>
                </div>
                <div class="form-group field-faq-question required">
                    <label class="control-label" for="faq-question">Текст описание ( Виден на странице )</label>
                    <?= Html::textarea("description[$key]", $model[$key]['description']) ?>

                    <div class="help-block"></div>
                </div>


            </div>


        <?php } ?>


    <?= Html::submitButton('Сохранить', ['class' => 'submit']) ?>

        <?= Html::endForm() ?>
    </div>

