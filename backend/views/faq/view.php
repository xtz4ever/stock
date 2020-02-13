
<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\SeoPage */



$this->title = $model->question;
$this->params['breadcrumbs'][] = ['label' => 'Вопросы', 'url' => ['index']];
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
        'attribute'=>'question',
        'format'=>'raw',
        'value'=>'<span class="text-justify"><em>' . $model->question .
            '</em></span>',
        'type'=>DetailView::INPUT_TEXTAREA,
        'options'=>['rows'=>2]
    ],
    [
        'attribute'=>'answer',
        'format'=>'raw',
        'value'=>'<span class="text-justify"><em>' . $model->answer .
            '</em></span>',
        'type'=>DetailView::INPUT_TEXTAREA,
        'options'=>['rows'=>16]
    ],


    [
        'attribute'=>'status',
        'label'=>'Статус',
        'format'=>'raw',
        'value'=>$model->status ? '<span class="label label-success">Активный</span>' : '<span class="label label-danger">Деактивирован</span>',
        'type'=>DetailView::INPUT_SWITCH,
        'widgetOptions' => [
            'pluginOptions' => [
                'onText' => 'Активный',
                'offText' => 'Деактивирован',
            ]
        ],
        'valueColOptions'=>['style'=>'width:30%']
    ],

    [
        'attribute'=>'position',
        'format'=>'ntext',
        'value'=>$model->position,
        'displayOnly'=>true
    ],



];

?>




<div class="admin_form_me_custom">
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
//        'bordered' => $bordered,
//        'striped' => $striped,
//        'condensed' => $condensed,
//        'responsive' => $responsive,
    ]);
    ?>
</div>
