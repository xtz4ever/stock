<?php

use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\detail\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\SeoPage */

$this->title = $model->page_name;
$this->params['breadcrumbs'][] = ['label' => 'Seo Pages', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

    <h1><?= Html::encode($this->title) ?></h1>




<?php
$attributes=[
    [
        'attribute'=>'page_name',
        'format'=>'ntext',
        'value'=>$model->page_name,
        'displayOnly'=>true
    ],

    [
        'attribute'=>'seo_title_ru',
        'format'=>'raw',
        'value'=>'<span class="text-justify"><em>' . $model->seo_title_ru .
            '</em></span>',
        'type'=>DetailView::INPUT_TEXTAREA,
        'options'=>['rows'=>4]
    ],
    [
        'attribute'=>'seo_description_ru',
        'format'=>'raw',
        'value'=>'<span class="text-justify"><em>' . $model->seo_description_ru .
            '</em></span>',
        'type'=>DetailView::INPUT_TEXTAREA,
        'options'=>['rows'=>4]
    ],
    [
        'attribute'=>'seo_keywords_ru',
        'format'=>'raw',
        'value'=>'<span class="text-justify"><em>' . $model->seo_keywords_ru .
            '</em></span>',
        'type'=>DetailView::INPUT_TEXTAREA,
        'options'=>['rows'=>4]
    ],
    [
        'attribute'=>'seo_image_alt_ru',
        'format'=>'raw',
        'value'=>'<span class="text-justify"><em>' . $model->seo_image_alt_ru .
            '</em></span>',
        'type'=>DetailView::INPUT_TEXTAREA,
        'options'=>['rows'=>4]
    ],
    [
        'attribute'=>'seo_image_title_ru',
        'format'=>'raw',
        'value'=>'<span class="text-justify"><em>' . $model->seo_image_title_ru .
            '</em></span>',
        'type'=>DetailView::INPUT_TEXTAREA,
        'options'=>['rows'=>4]
    ],
    [
        'attribute'=>'description_ru',
        'format'=>'ntext',
        'value'=>'<span class="text-justify"><em>' . $model->description_ru .
            '</em></span>',
        'type'=>DetailView::INPUT_TEXTAREA,
        'options'=>['rows'=>10]
    ],
    [
        'attribute'=>'h1_ru',
        'format'=>'raw',
        'value'=>'<span class="text-justify"><em>' . $model->h1_ru .
            '</em></span>',
        'type'=>DetailView::INPUT_TEXTAREA,
        'options'=>['rows'=>4]
    ],
//    [
//        'attribute'=>'seo_title_en',
//        'format'=>'raw',
//        'value'=>'<span class="text-justify"><em>' . $model->seo_title_en .
//            '</em></span>',
//        'type'=>DetailView::INPUT_TEXTAREA,
//        'options'=>['rows'=>4]
//    ],
//    [
//        'attribute'=>'seo_description_en',
//        'format'=>'raw',
//        'value'=>'<span class="text-justify"><em>' . $model->seo_description_en .
//            '</em></span>',
//        'type'=>DetailView::INPUT_TEXTAREA,
//        'options'=>['rows'=>4]
//    ],
//    [
//        'attribute'=>'seo_keywords_en',
//        'format'=>'raw',
//        'value'=>'<span class="text-justify"><em>' . $model->seo_keywords_en .
//            '</em></span>',
//        'type'=>DetailView::INPUT_TEXTAREA,
//        'options'=>['rows'=>4]
//    ],
//    [
//        'attribute'=>'seo_image_alt_en',
//        'format'=>'raw',
//        'value'=>'<span class="text-justify"><em>' . $model->seo_image_alt_en .
//            '</em></span>',
//        'type'=>DetailView::INPUT_TEXTAREA,
//        'options'=>['rows'=>4]
//    ],
//    [
//        'attribute'=>'seo_image_title_en',
//        'format'=>'raw',
//        'value'=>'<span class="text-justify"><em>' . $model->seo_image_title_en .
//            '</em></span>',
//        'type'=>DetailView::INPUT_TEXTAREA,
//        'options'=>['rows'=>4]
//    ],
//    [
//        'attribute'=>'description_en',
//        'format'=>'ntext',
//        'value'=>'<span class="text-justify"><em>' . $model->description_en .
//            '</em></span>',
//        'type'=>DetailView::INPUT_TEXTAREA,
//        'options'=>['rows'=>10]
//    ],
//    [
//        'attribute'=>'h1_en',
//        'format'=>'raw',
//        'value'=>'<span class="text-justify"><em>' . $model->h1_en .
//            '</em></span>',
//        'type'=>DetailView::INPUT_TEXTAREA,
//        'options'=>['rows'=>4]
//    ],

];





Modal::begin([
    'header' => '<h4 class="modal-title">Detail View Demo</h4>',
    'toggleButton' => ['label' => '<i class="glyphicon glyphicon-th-list"></i> Посмотреть в модальном окне', 'class' => 'btn btn-primary'],
    'options' => ['tabindex' => false]
]);
echo DetailView::widget([
    'model'=>$model,
    'condensed'=>true,
    'hover'=>true,
    'hAlign'=> DetailView::ALIGN_CENTER,
    'mode'=>DetailView::MODE_VIEW,
    'attributes'=>$attributes,
    'deleteOptions'=>[
        'params' => ['custom_param'=>true],
        'url'=>['delete', 'id' => $model->id],
    ],
    'panel'=>[
        'heading'=>  $model->id,
        'type'=>DetailView::TYPE_INFO,
    ],
]);
Modal::end();


echo DetailView::widget([
    'model'=>$model,
    'condensed'=>true,
    'hover'=>true,
    'hAlign'=> DetailView::ALIGN_CENTER,
    'mode'=>DetailView::MODE_VIEW,
    'attributes'=>$attributes,
    'deleteOptions'=>[
        'params' => ['custom_param'=>true,'id' => $model->id],
        'url'=>['delete'],
    ],

    'panel'=>[
        'heading'=>  $model->id,
        'type'=>DetailView::TYPE_INFO,
    ],
//    'bordered' => $bordered,
//    'striped' => $striped,
//    'condensed' => $condensed,
//    'responsive' => $responsive,
]);
?>