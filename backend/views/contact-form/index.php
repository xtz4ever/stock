
<?php
use yii\bootstrap\ButtonDropdown;
use yii\helpers\Html;
use kartik\grid\GridView;


$this->title = 'Заказы с формы контактов';
$this->params['breadcrumbs'][] = $this->title;

$gridColumns = [


    [
        'label' => 'id',
        'format' => 'raw',
        'value' => 'id',
        'contentOptions'=>['style'=>'width: 30px;'] // <-- right heres
    ],



    [
        'attribute' => Yii::t('app', 'name'),
        'contentOptions' => ['style' => 'text-align: center;'],
    ],
    [
        'attribute' => Yii::t('app', 'email'),

        'contentOptions' => ['style' => 'text-align: center;'],
    ],

    [
        'attribute' => Yii::t('app', 'subject'),
        'contentOptions' => ['style' => 'width: 100px;text-align: center;'],
    ],
    [
        'attribute' => Yii::t('app', 'telephone'),
        'contentOptions' => ['style' => 'text-align: center;'],
    ],



    [
        'label' => 'Статус',
        'attribute' => 'status',
        'value' => function ($model) {
            if ($model->status == 1) {
                return '<div class="glyphicon glyphicon-ok text-success"></div>';
            }  else {
                return '<span class="glyphicon glyphicon-remove text-danger" ></span>';
            }
        },
        'filter' => Html::activeDropDownList($searchModel, 'status', [
            0 => "Ждет модерации",
            1 => "Отмодерирован",

        ],['class'=>'form-control','prompt' => 'Все']),
        'vAlign'=>'small',
        'format'=>'raw',
        'contentOptions' => ['style' => 'text-align: center;'],
    ],

    [
        'label' => Yii::t('app', 'Действия'),
        'contentOptions' => ['style' => 'width: 200px;'],
        'format' => 'raw',
        'value' => function ($model, $key, $index, $widget) {


//            $status = [
//                'encode' => false,
//                'label' => '<span class="glyphicon glyphicon-eye-open"></span> '.Yii::t('app', 'Посмотреть / изменить'),
//                'url' => ['view', 'id'=>$model->id],
//            ];

            $update = [
                'encode' => false,
                'label' => '<span class="glyphicon glyphicon-pencil"></span> '.Yii::t('app', 'Изменить'),
                'url' => ['update', 'id'=>$model->id],
            ];

            $delete = [
                'encode' => false,
                'label' => '<span class="glyphicon glyphicon-trash"></span> '.Yii::t('app', 'Удалить'),
                'url' => ['delete', 'id'=>$model->id, ],
                'linkOptions'=>[
                    'aria-label' => 'Delete',
                    'data-method'=>'post',
                    'data-pjax'=>'0',
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
    'id' => 'newprovider',
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => $gridColumns,

    'panel'=>[
        'type'=>GridView::TYPE_PRIMARY,
        'heading'=>Yii::t('app', 'Promo-code'),
    ],

    'toolbar' =>  [
        [
            'content'=>
                Html::a(    '<i class="glyphicon glyphicon-plus"></i>',
                    ['create'],
                    [
                        'class' => 'btn btn-success',
                        'title'=>Yii::t('app', 'Create').' '. Yii::t('app', 'User'),
                    ]
                )
                .' '.
                Html::a('<i class="glyphicon glyphicon-repeat"></i>',
                    ['index'],
                    ['data-pjax'=>0, 'class'=>'btn btn-default', 'title'=>Yii::t('kvgrid', 'Reset Grid')]
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
        'heading'=>$this->title,


    ],
]);


?>

