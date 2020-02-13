<?php

use frontend\assets\AppAsset;
use \yii\helpers\Url;
use kartik\form\ActiveForm;
use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\widgets\Pjax;
use himiklab\yii2\recaptcha\ReCaptcha;

?>
<style>
    .loader_more{
        text-align: center;
    }
</style>
<section class="proxy_ipv6">
    <div class="container">
        <div class="row">
            <div class="proxy_ipv6_items ani">
                <?php
                if (isset($category)) {

                    foreach ($category as $val) {
                        ?>
                        <div class="margin_b col-lg-4 col-md-4 col-sm-4 col-xs-6">
                            <div class="proxy_ipv6_item">

                                <div class="proxy_ipv6_item_inner">
                                    <a href="<?= $val['url']; ?>">
                                        <?= \yii\helpers\Html::img('/img/services/' . $val['img']); ?>
                                    </a>
                                    <a class="proxy_pieces"
                                       href="<?=  $val['url']; ?>"><?= $val['name']; ?></a>

                                    <?php if (strlen($val['price']) > 1) { ?>
                                        <p class="proxy_pieces" style="margin-top: 10%;">
                                            <i style="padding-right: 2%;" class="fa fa-dollar"></i><?= $val['price']; ?>
                                        </p>
                                    <?php } ?>
                                    <?php if (strlen($val['time_to_work']) > 1) { ?>
                                        <p class="proxy_pieces" style="margin-top: 20%;">
                                            <i style="padding-right: 2%;"
                                               class="fa fa-clock-o"></i><?= $val['time_to_work']; ?>
                                        </p>
                                    <?php } ?>
                                    <?php if (strlen($val['text']) > 1) { ?>
                                        <p class="proxy_pieces"
                                           style="font-size: 14px;margin-top: 30%;padding-left: 2%;padding-right: 2%;">
                                            <?= $val['text']; ?>
                                        </p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                }
                ?>
            </div>
            <?= \frontend\components\MyPaginationOurWorks::widget(['pagination' => $page]); ?>
        </div>
    </div>
</section>