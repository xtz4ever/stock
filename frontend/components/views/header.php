<?php
use yii\helpers\Url;
?>

<header id="header" class="header">
    <?php
/*    $lang = substr(Yii::$app->language, 0, 2);

    */?>
    <?php if ($phone === true) { ?>
        <div class="container" style="text-align: center;padding-top: 13%;">
            <div class="row">
                <a href="<?= Url::to($lang_url.'/'); ?>" class="logo mobile">
                    <i>
                        <img src="/img/logo.png" alt="">
                    </i>
                </a>
            </div>
        </div>
    <?php } ?>

    <div class="container">
        <div class="row">

            <div class="header_nav_wrap">
                <nav class="header_nav">
                    <a href="<?= Url::to($lang_url.'/'); ?>" class="logo">
                        <img src="/img/logo.png" alt="">
                    </a>
                    <ul>
                        <li>
                            <a href="<?= Url::to($lang_url.'/services'); ?>"><?=$translates['services'];?></a>
                            <i class="fa fa-angle-down"></i>
                            <div class="header_dropdown menu_xtz">
                                <ul>
                                    <?php if ($category) {
                                        foreach ($category as $val) {
                                            ?>
                                            <li><a href="<?= Url::to($lang_url.'/'.$val['url']); ?> "><?= $val['name'] ?></a></li>
                                            <?php
                                        }
                                    } ?>
                                </ul>


                            </div>
                        </li>
                        <li>
                            <a href="<?= Url::to($lang_url.'/faq'); ?>"><?=$translates['faq'];?></a>
                        </li>
                        <li>
                            <a href="<?= Url::to($lang_url.'/feedbacks'); ?>"><?=$translates['feedbacks'];?></a>
                        </li>

                        <!--                        <li>-->
                        <!--                            <a data-modal="modal-2" class="modal_xtz" style="width: 100px;height: 25px" href="#">Контакты</a>-->
                        <!--                        </li>-->
                        <li>
                            <a href="<?= Url::to($lang_url.'/createcontacts'); ?>"><?=$translates['createcontacts'];?></a>
                        </li>

                        <?=\frontend\widgets\WLang::widget();?>
                    </ul>
                </nav>

            </div>


        </div>
    </div>

</header>