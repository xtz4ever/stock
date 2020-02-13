<?php
use yii\helpers\Html;
use yii\helpers\Url;

?>


<li>
    <a href="#"><?=$current_lang_name;?></a>
    <i class="fa fa-angle-down"></i>
    <div class="header_dropdown languages-header">

        <ul>
            <?php foreach ($langs as $lang):?>
                <li>


                    <?php if ($lang->url == 'ru'){?>
                        <?php if(Yii::$app->getRequest()->getLangUrl() == false){
                            $url = '/';
                        } else {
                            $url = Yii::$app->getRequest()->getLangUrl();
                        } ?>
                        <a href="<?= Url::to($url); ?>" data-pjax="0"><?=$lang->name;?></a>

                    <?php }else{ ?>

                        <a href="<?= Url::to('/' . $lang->url .''. Yii::$app->getRequest()->getLangUrl()); ?>" data-pjax="0"><?=$lang->name;?></a>
                    <?php } ?>

                </li>
            <?php endforeach;?>

        </ul>


    </div>
</li>

<!--<style>
    .menu_contacts_wrap .menu .menu_list .langruage{
        padding: 0px 25px;
        border-radius: 16px;
    }
</style>
<div id="lang">
    <span id="current-lang">
<?php /*//var_dump($langs)*/?>

        <?php /*$current->url == ' ' ? $img = 'ru' :  $img = $current->url; */?>

       <img src="/img/<?/*=$img*/?>.png"> <span class="show-more-lang"></span>
    </span>
    <ul id="langs" style="display: none; ">
        <?php /*foreach ($langs as $lang):*/?>
            <li class="item-lang">

                <?php /*if ($lang->url == 'en'){*/?>
                    <a href="<?/*= Url::to('/' . $lang->url .''. Yii::$app->getRequest()->getLangUrl()); */?>" data-pjax="0"><?/*='<img src="/img/'.$lang->url.'.png">'*/?></a>
                <?php /*}else{ */?>

                    <a href="<?/*= Url::to( Yii::$app->getRequest()->getLangUrl()); */?>" data-pjax="0"><?/*='<img src="/img/ru.png">'*/?></a>
                <?php /*} */?>

            </li>
        <?php /*endforeach;*/?>
    </ul>
</div>
                    <a style="display: none" href="<?/*= Url::to( '/' . $lang->url .''.Yii::$app->getRequest()->getLangUrl()); */?>" data-pjax="0"><?/*='<img src="/img/ru.png">'*/?></a>
-->