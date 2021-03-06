<?php
use yii\helpers\Url;
use frontend\components\LangUrlManager;
$lang_url = LangUrlManager::getUrlLink();
?>

<style>


    #footer-dropdown > .footer_dropdown > ul > li > a{
        color: #000;
    }
    #footer-dropdown > .footer_dropdown > ul > li > a:hover{
        color: #f34255;
    }

    .footer > .container > .row > .col-lg-3{
        font-size: 15px;
        text-align: center;
    }

</style>

<footer class="footer">
    <div class="container">
        <div class="row footer_xtz">

            <div class="col-sm-6 col-lg-3">
                <nav>
                    <ul>
                        <li id="footer-dropdown">
                            <a href="<?= Url::to($lang_url.'/services'); ?>"><?=$translates['services'];?></a>
                            <i class="fa fa-angle-down"  ></i>
                            <div class="footer_dropdown">
                                <i>
                                    <img src="/img/decor_header_dropdown.png" alt="">
                                </i>
                                <ul>
                                    <?php if ($category) {
                                        foreach ($category as $val) {
                                            ?>
                                            <li style="width: 100%;">

                                                <a href="<?= Url::to($lang_url.'/'.$val['url']); ?>"><?= $val['name'] ?></a>
                                            </li>
                                            <?php
                                        }
                                    } ?>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </nav>
            </div>
            <div class="col-sm-6 col-lg-3"> <a href="<?= Url::to($lang_url.'/faq'); ?>"><?=$translates['faq'];?></a></div>
            <div class="col-sm-6 col-lg-3"><a href="<?= Url::to($lang_url.'/feedbacks'); ?>"><?=$translates['feedbacks'];?></a></div>
            <div class="col-sm-6 col-lg-3"><a href="<?= Url::to($lang_url.'/createcontacts'); ?>"><?=$translates['createcontacts'];?></a></div>
        </div>
    </div>
</footer>