<style>
    .kv-file-content > img {
        width: 16.666% !important;
        float: left;
    }

    .admin_form_me_custom {
        width: 100%
    }
</style>
<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\SeoPage */


$this->title = $model->parent_id;
$this->params['breadcrumbs'][] = ['label' => 'Событие', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>


<?php

$query = \common\models\Services::findOne($model->parent_id);



$images = explode('**', trim($model->imgs));
$imgs = '';
foreach ($images as $image) {
    if ($image == '') {
        continue;
    }
    $imgs .= "<b class='kv-file-content' style='padding-right: 1%;width: 16.666%!important;'>" . Html::img("/img/" . $image) . "</b>";
}


$attributes = [


    [
        'attribute' => 'id',
        'format' => 'ntext',
        'value' => $model->id,
        'displayOnly' => true
    ],


    [
        'label' => 'Событие ',
        'attribute' => 'parent_id',
        'format' => 'raw',
        'value' => '<span class="text-justify"><em>' . $query->name .
            '</em></span>',
        'displayOnly' => true
    ],


    [
        'label' => 'Картинки ',
        'attribute' => 'imgs',
        'format' => 'raw',
        'value' => '<span class="text-justify"><em>' . $imgs .
            '</em></span>',
        'type' => DetailView::INPUT_FILE,
        'options' => ['rows' => 2]
    ],

    [
        'attribute' => 'status',
        'label' => 'Статус',
        'format' => 'raw',
        'value' => $model->status ? '<span class="label label-success">Активный</span>' : '<span class="label label-danger">Деактивирован</span>',
        'type' => DetailView::INPUT_SWITCH,
        'widgetOptions' => [
            'pluginOptions' => [
                'onText' => 'Активный',
                'offText' => 'Деактивирован',
            ]
        ],
        'valueColOptions' => ['style' => 'width:30%']
    ],


];

?>


<div class="admin_form_me_custom">
    <?php
    echo DetailView::widget([
        'model' => $model,
        'condensed' => true,
        'hover' => true,
        'hAlign' => DetailView::ALIGN_CENTER,
        'mode' => DetailView::MODE_VIEW,
        'attributes' => $attributes,
        'deleteOptions' => [
            'params' => ['custom_param' => true, 'id' => $model->id],
            'url' => ['delete'],
        ],

        'panel' => [
            'heading' => $model->id,
            'type' => DetailView::TYPE_INFO,
        ],

        'responsive' => true,
    ]);
    ?>
</div>

