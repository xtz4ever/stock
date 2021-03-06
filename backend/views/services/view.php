<style>
    .kv-btn-update{
        display: none;
    }
</style>
<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\SeoPage */



$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Категории услуг', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>




<?php

$query = \common\models\Category::findOne($model->category_id);

$attributes=[




    [
        'attribute'=>'id',
        'format'=>'ntext',
        'value'=>$model->id,
        'displayOnly'=>true
    ],


    [
        'attribute'=>'category_id',
        'format'=>'raw',
        'value'=>'<span class="text-justify"><em>' . $query->name .
            '</em></span>',
        'displayOnly'=>true
    ],

    [
        'attribute'=>'text',
        'format'=>'raw',
        'value'=>'<span class="text-justify"><em>' . $model->text .
            '</em></span>',
        'type'=>DetailView::INPUT_TEXTAREA,
        'options'=>['rows'=>2]
    ],
    [
        'attribute'=>'name',
        'format'=>'raw',
        'value'=>'<span class="text-justify"><em>' . $model->name .
            '</em></span>',
        'type'=>DetailView::INPUT_TEXTAREA,
        'options'=>['rows'=>2]
    ],
    [
        'attribute'=>'price',
        'format'=>'raw',
        'value'=>'<span class="text-justify"><em>' . $model->price .
            '</em></span>',
        'type'=>DetailView::INPUT_TEXTAREA,
        'options'=>['rows'=>2]
    ],
 [
        'attribute'=>'time_to_work',
        'format'=>'raw',
        'value'=>'<span class="text-justify"><em>' . $model->time_to_work .
            '</em></span>',
        'type'=>DetailView::INPUT_TEXTAREA,
        'options'=>['rows'=>2]
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
        'label'=>'Картинка категории',
        'attribute'=>'img',
        'format'=>'raw',
        'value'=>'<span class="text-justify"><em>' . Html::img(Url::to('/frontend/web/img/services/'.$model->img),[
                'alt'=>'yii2',
                'style' => 'width:90px;background: #666'
            ]) .
            '</em></span>',
        'type'=>DetailView::INPUT_FILE,
        'options'=>['rows'=>2]
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

