<?php

$this->title = 'Seo Pages';
$this->params['breadcrumbs'][] = $this->title;
?>


<a  href="#" id="hint" style="color: white;font-size: 30px;display: none"> <span class="fa fa-exclamation-triangle" style="font-size: 60px;color: red;"></span> Кликни на меня!</a>
<div class="admin_form_me_custom_medium" id="hint_block" style=" font-size: 17px;color: white;max-width: 100%;display: none ">

    Здесь создаются СЕО для "статических страниц" , например главная (index), отзывы (feedbacs) и т.д. Если на сайте есть страница, но нет записи в этой таблице ,
    Вы сможете создать запись самостоятельно. Поле <b>Название Старницы </b>   <b style="color: red"> должно полностью соответсвовать url этой страницы</b>
    например вот URL страницы партнерского кабинета <b>stockaccs.com/affiliate-program-main</b>  следовательно в поле <b>Название Старницы</b>
    <p> вписывается ( affiliate-program-main ) </p>
    Также здесь можно отредактировать СЕО категорий товаров (google , yandex , vk и т.д.).
    <p>В этом очень помогает <b style="color: green">Поиск</b></p>



</div>

<style>
    .btn-success{
        display: none;
    }
</style>


<?php
use yii\bootstrap\ButtonDropdown;
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

$gridColumns = [

    [
        'label' => 'id',
        'format' => 'raw',
        'value' => 'id',
        'contentOptions'=>['style'=>'width: 30px;min-height:50px;']
    ],
    [
        'attribute' => Yii::t('app', 'page_name'),
    ],
    [
        'attribute' => Yii::t('app', 'h1'),
    ],
    [
        'attribute' => Yii::t('app', 'seo_title'),
    ],

    [
        'attribute' => Yii::t('app', 'lang'),
        'format'=>'raw',
        'filter' => Html::activeDropDownList($searchModel, 'lang', ArrayHelper::map(\common\models\Lang::find()->asArray()->all(), 'url', 'url'), ['class' => 'form-control', 'prompt' => 'Все'], ['multiple' => false]),
        'contentOptions' => ['style' => 'text-align: center; width: 10%'],
    ],





    [
        'label' => Yii::t('app', 'Actions'),
        'format' => 'raw',
        'contentOptions'=>['style'=>'width: 200px;    '],
        'value' => function($model, $key, $index, $widget)
        {

            $status = [
                'encode' => false,
                'label' => '<span class="glyphicon glyphicon-eye-open"></span> '.Yii::t('app', 'view'),
                'url' => ['view', 'id'=>$model->id],
            ];

            $update = [
                'encode' => false,
                'label' => '<span class="glyphicon glyphicon-pencil"></span> '.Yii::t('app', 'update'),
//                'url' => ['update', 'id'=>$model->id],
                'url' => ['update', 'page_name'=>$model->page_name],
            ];

            $delete = [
                'encode' => false,
                'label' => '<span class="glyphicon glyphicon-trash"></span> '.Yii::t('app', 'Delete'),
                'url' => ['delete', 'id'=>$model->id, ],
                'linkOptions'=>[
                    'aria-label' => 'Delete',
                    'data-method'=>'post',
                    'data-pjax'=>'0',
                ],
            ];

            $items [] = $status;
            $items [] = $update;
            $items [] = $delete;

            return ButtonDropdown::widget([
                'encodeLabel' => false,
                'label' => 'Actions',
                'options' => [
                    'class' => 'btn btn-default',
                    'role'=>"menu",
                ],
                'dropdown' => [
                    'items' => $items,
                ]
            ]);
        },
    ],

];
?>

<?php
echo GridView::widget([
    'id' => 'kv-grid-user',
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => $gridColumns,

    'panel'=>[
        'type'=>GridView::TYPE_PRIMARY,
        'heading'=>Yii::t('app', 'CEO'),
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
    'bordered' => false,
    'striped' => false,
    'condensed' => false,
    'responsive' => false,
    'hover' => true,
    'floatHeader' => false,

]);


?>
<script>
    $('#hint').on('click',function (e) {
        e.preventDefault();
        $('.admin_form_me_custom_medium').fadeIn('slow');
    });
    $('#close-hint').on('click',function (e) {
        e.preventDefault();
        $('.admin_form_me_custom_medium').fadeOut('slow');
    });
</script>