<?php

use yii\bootstrap\ButtonDropdown;
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;


if (Yii::$app->session->hasFlash('success')):?>
    <div id="close_allert_success">
        <?= Yii::$app->session->getFlash('success'); ?>
    </div>
<?php
endif;
?>
<style>
    .kv-file-content > img {
        width: 16.666% !important;
        float: left;
    }
</style>
<div class="alert alert-success" id="success" style="display: none;max-width: 30%;
    text-align: center;z-index: 9999;left: 40%;
top: 10%;
    font-size: 20px;">Данные обновлены
</div>
<input type="hidden" id="case" value="<?= Yii::$app->controller->id ?>">
<?php

$this->title = 'События';
$this->params['breadcrumbs'][] = $this->title;

$gridColumns = [


    [
        'label' => 'id',
        'format' => 'raw',
        'value' => 'id',
        'contentOptions' => ['style' => 'width: 30px;'] // <-- right heres
    ],


    [
        'label' => 'Событие',
        'attribute' => 'parent_id',
        'value' => function ($model) {
            $query = \common\models\Services::findOne($model->parent_id);
            return $query['name'];
        },
        'filter' => Html::activeDropDownList($searchModel, 'parent_id', ArrayHelper::map(\common\models\Services::find()->asArray()->all(), 'id', 'name'), ['class' => 'form-control', 'prompt' => 'Все'], ['multiple' => false]),
        'vAlign' => 'small',
        'format' => 'raw',
        'contentOptions' => ['style' => 'width: 100px;']
    ],


    [
        'label' => 'Картинки',
        'format' => 'raw',
        'value' => function ($model) {
            $images = explode('**', trim($model->imgs));
            $imgs = '';
            foreach ($images as $image) {
                if ($image == '') {
                    continue;
                }
                $imgs .= "<b class='kv-file-content' style='padding-right: 1%;width: 16.666%!important;'>" . Html::img("/img/" . $image) . "</b>";
            }
            return $imgs;
        },
    ],

    [
        'label' => 'Статус',
        'attribute' => 'status',
        'value' => function ($model) {
            if ($model->status == 1) {
                return '<div class="glyphicon glyphicon-ok text-success"></div>';
            } else {
                return '<span class="glyphicon glyphicon-remove text-danger" ></span>';
            }
        },
        'filter' => Html::activeDropDownList($searchModel, 'status', [
            0 => "не активный",
            1 => "активный",
        ], ['class' => 'form-control', 'prompt' => 'Все']),
        'vAlign' => 'small',
        'format' => 'raw',
        'contentOptions' => ['style' => 'text-align: center;width: 50px;'],
    ],


    [
        'label' => Yii::t('app', 'Действия'),
        'contentOptions' => ['style' => 'width: 100px;'],
        'format' => 'raw',
        'value' => function ($model, $key, $index, $widget) {


//            $status = [
//                'encode' => false,
//                'label' => '<span class="glyphicon glyphicon-eye-open"></span> '.Yii::t('app', 'Посмотреть / изменить'),
//                'url' => ['view', 'id'=>$model->id],
//            ];
            $view = [
                'encode' => false,
                'label' => '<span class="glyphicon glyphicon-eye-open"></span> ' . Yii::t('app', 'Посмотреть'),
                'url' => ['view', 'id' => $model->id],
            ];
            $update = [
                'encode' => false,
                'label' => '<span class="glyphicon glyphicon-pencil"></span> ' . Yii::t('app', 'Изменить'),
                'url' => ['update', 'id' => $model->id],
            ];

            $delete = [
                'encode' => false,
                'label' => '<span class="glyphicon glyphicon-trash"></span> ' . Yii::t('app', 'Удалить'),
                'url' => ['delete', 'id' => $model->id,],
                'linkOptions' => [
                    'aria-label' => 'Delete',
                    'data-method' => 'post',
                    'data-pjax' => '0',
                ],
            ];
            $activate = [
                'encode' => false,
                'label' => '<span class="glyphicon glyphicon-ok"></span> ' . Yii::t('app', 'Активировать'),
                'url' => ['activate', 'id' => $model->id],
            ];
            $deactivate = [
                'encode' => false,
                'label' => '<span class="glyphicon glyphicon-remove"></span> ' . Yii::t('app', 'Деактивировать'),
                'url' => ['deactivate', 'id' => $model->id],
            ];

            $items [] = $activate;
            $items [] = $deactivate;
            $items [] = $view;
            $items [] = $update;

            $items [] = $delete;


            return ButtonDropdown::widget([
                'encodeLabel' => false,
                'label' => 'Действия',
                'options' => [
                    'class' => 'btn btn-default',
                    'role' => "menu",
                ],
                'dropdown' => [
                    'items' => $items,
                ]
            ]);
        },
    ],

];

echo GridView::widget([
    'id' => 'kv-grid-user',
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => $gridColumns,

    'panel' => [
        'type' => GridView::TYPE_PRIMARY,
        'heading' => Yii::t('app', 'Promo-code'),
    ],

    'toolbar' => [
        [
            'content' =>
                Html::a('<i class="glyphicon glyphicon-plus"></i>',
                    ['create'],
                    [
                        'class' => 'btn btn-success',
                        'title' => Yii::t('app', 'Create') . ' ' . Yii::t('app', 'User'),
                    ]
                )
                . ' ' .
                Html::a('<i class="glyphicon glyphicon-repeat"></i>',
                    ['index'],
                    ['data-pjax' => 0, 'class' => 'btn btn-default', 'title' => Yii::t('kvgrid', 'Reset Grid')]
                ),
        ],
        '{toggleData}'
    ],
    'pjax' => true,
    'pjaxSettings' => [
        'options' => [
            'enablePushState' => false,
        ],
    ],
    'bordered' => true,
    'striped' => false,
    'condensed' => false,
    'responsive' => true,
    'hover' => true,
    'floatHeader' => false,
    'panel' => [
        'type' => GridView::TYPE_PRIMARY,
        'heading' => $this->title,


    ],
]);


?>


