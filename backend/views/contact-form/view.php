<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\SeoPage */



$this->title = $model->email;
$this->params['breadcrumbs'][] = ['label' => 'Отзывы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>





<?php
$attributes=[



    [
        'attribute'=>'id',
        'format'=>'ntext',
        'value'=>$model->id,
        'displayOnly'=>true
    ],

    [
        'attribute'=>'name',
        'label'=>'Имя',
        'format'=>'raw',
        'value'=>'<span class="text-justify"><em>' . $model->name .
            '</em></span>',
        'type'=>DetailView::INPUT_TEXTAREA,
        'options'=>['rows'=>2]
    ],

    [
        'attribute'=>'email',
        'label'=>'email',
        'format'=>'raw',
        'value'=>'<span class="text-justify"><em>' . $model->email .
            '</em></span>',


    ],
 [
        'attribute'=>'telephone',
        'label'=>'telephone',
        'format'=>'raw',
        'value'=>'<span class="text-justify"><em>' . $model->telephone .
            '</em></span>',


    ],


    [
        'attribute'=>'subject',
        'label'=>'сообщение',
        'format'=>'raw',
        'value'=>'<span class="text-justify"><em>' . $model->subject .
            '</em></span>',
        'type'=>DetailView::INPUT_TEXTAREA,
        'options'=>['rows'=>12]
    ],



    [
        'attribute'=>'status',
        'label'=>'Выводить на сайте',
        'format'=>'raw',
        'value'=>$model->status ? '<span class="label label-success">Активный</span>' : '<span class="label label-danger">Деактивирован</span>',
        'type'=>DetailView::INPUT_SWITCH,
        'widgetOptions' => [
            'pluginOptions' => [
                'onText' => 'Отмодерирован',
                'offText' => 'Ждет модерации',
            ]
        ],
        'valueColOptions'=>['style'=>'width:30%']
    ],
];
?>

<div class="admin_form_me_custom_medium" style="width: 85%">
    <?php
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

    ]);
    ?>
</div>
