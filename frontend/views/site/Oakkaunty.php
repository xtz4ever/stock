<?php

use frontend\assets\AppAsset;
use \yii\helpers\Url;
use kartik\form\ActiveForm;
use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\widgets\Pjax;
use himiklab\yii2\recaptcha\ReCaptcha;

$this->registerJsFile('js/index.js',
    ['depends' => [AppAsset::className()],
        'position' => \yii\web\View::POS_END
    ]);
$this->registerCssFile('css/akkaunty-mail.css',
    ['depends' => [AppAsset::className()],
        'position' => \yii\web\View::POS_HEAD
    ]);

?>

<style>
    .help-block {
        display: none;
    }

    .map_index {
        background: none;
    }

    .tba_item_body_list > li > a > img {
        max-width: 74px !important;
        max-height: 70px !important;
    }
</style>

<section class="akkaunty-mail_first">
    <div class="title_wrap_h2">
        <!--H1-->
        <?php
        if (!empty($pageInfo['h1'])) {
            echo '<h2>' . $page_text['text_h1'] . '&#160<span>' . $pageInfo['h1'] . '</span></h2>';
        }
        ?>
    </div>


</section>
<?php if (Yii::$app->session->hasFlash('success_modal')): ?>
    <div id="close_allert_success_index" style="z-index: 999999; position: absolute;margin-top: 25%;margin-left: 36%;">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="margin-top: -3%;">×</button>
        <?= Yii::$app->session->getFlash('success_modal'); ?>
    </div>
<?php endif; ?>

<?php if (Yii::$app->session->hasFlash('success')): ?>
    <?php $info = Yii::$app->session->getFlash('success');
    $info = explode('&', $info);
    $name = $info[1];
    $quantyti = $info[0];

//    $this->registerJs(
//        "$('.modal_index').addClass('modal_open');",
//
//        yii\web\View::POS_READY
//    );
    ?>


<?php endif; ?>


<section class="index_main">
    <div class="container">
        <div class="table_tabs_wrap">

            <div class="table_body">
                <?php Pjax::begin(['enablePushState' => false]); ?>
                <?php count($categories_1000) == 0 ? $display = 'none' : $display = 'block'; ?>
                <div class="table_item main" style="display:<?= $display; ?>;">
                    <div class="ti_header">


                        <div class="serv"><?= $page_text['service']; ?></div>
                        <div class="amount"><?= $page_text['quantity']; ?></div>
                        <div class="price"><?= $page_text['price_for']; ?>
                            &#160<span>1К <?= $page_text['1k_accounts']; ?></span></div>


                        <div class="currency">
                            <div class="currency_currency <?= $currency == 'rub' ? ' active_curr' : '' ?> "><a
                                        href="<?= Url::to("/akkaunty-$title_en?currency=RUB"); ?>">RUB</a></div>
                            <div class="currency_currency <?= $currency == 'usd' ? ' active_curr' : '' ?> "><a
                                        href="<?= Url::to("/akkaunty-$title_en?currency=USD"); ?>">USD</a></div>
                            <div class="currency_currency <?= $currency == 'eur' ? ' active_curr' : '' ?> "><a
                                        href="<?= Url::to("/akkaunty-$title_en?currency=EUR"); ?>">EUR</a></div>
                        </div>

                    </div>

                    <div class="ti_body">

                        <?php


                        if (isset($categories_1000) && !empty($categories_1000)) {

                            foreach ($categories_1000 as $category_1000) { ?>
                                <div class="ti_body_title">
                                    <?php
                                    if ($lang == 'ru') {
                                        $url = '';
                                        $category_name = $category_1000["cateory_name_ru"];
                                    } else {
                                        $url = '/' . $lang;
                                        $category_name = $category_1000["cateory_name_en"];
                                    }
                                    ?>

                                    <div class="ti_body_a" style="pointer-events: none;cursor: default;">
                                        <a href="<?= Url::to('/' . $lang . '/akkaunty-' . strtolower($category_1000["cateory_name_en"])); ?>">
                                            <div class="img-wrap"><img src="/img/<?= $category_1000['image_main']; ?>">
                                            </div>
                                            <span><?= $category_name; ?></span></a></div>
                                    <?php
                                    foreach ($category_1000["products_1000"] as $product) {

                                        if ($lang == 'ru') {
                                            $product_name = $product["title_ru"];
                                            $product_description = $product["description_ru"];
                                        } else {
                                            $product_name = $product["title_en"];
                                            $product_description = $product["description_en"];
                                        }
                                        ?>

                                        <div class="ti_body_row" title="<?php if ($product_description) {
                                            echo $product_description;
                                        } ?>">
                                            <div class="ti_body_name"><?= $product_name; ?></div>
                                            <div class="ti_body_quanty"><?= $product["quantity"]; ?></div>
                                            <div class="ti_body_price">
                                                <?php
                                                $i = 1000;
                                                foreach ($product["prices"] as $price) {
                                                    $i++;
                                                    if ($price['quantity_min'] == 1000) {
                                                        $quantity_min = '1K';
                                                    } elseif ($price['quantity_min'] == 10000) {
                                                        $quantity_min = '10K';
                                                    } elseif ($price['quantity_min'] == 20000) {
                                                        $quantity_min = '20K';
                                                    } elseif ($price['quantity_min'] == 1) {
                                                        $quantity_min = '1';
                                                    } else {
                                                        $quantity_min = $price['quantity_min'];
                                                    }

                                                    if ($price['quantity_max'] == 1000) {
                                                        $quantity_max = '1K';
                                                    } elseif ($price['quantity_max'] == 10000) {
                                                        $quantity_max = '10K';
                                                    } elseif ($price['quantity_max'] == 20000) {
                                                        $quantity_max = '20K';
                                                    } elseif ($price['quantity_max'] == 50000) {
                                                        $quantity_max = '50K';
                                                    } else {
                                                        $quantity_max = $price['quantity_max'];
                                                    }
                                                    ?>
                                                    <!--Цена за 1000 шт.-->
                                                    <?= $quantity_min . '-' . $quantity_max . ': ' . round(($price['price'] * 1000 * $exchange_rates), 2) . $currency_sign . ' |' ?>

                                                <?php } ?>

                                            </div>
                                            <div class="ti_body_form">

                                                <?php $form = ActiveForm::begin([
                                                    'id' => 'form-buyakkounts-index_' . $i,
                                                    'action' => "$url/buyakkaynt",
                                                    'method' => 'post',
                                                    'enableAjaxValidation' => false,
                                                    'enableClientValidation' => true,
                                                    'options' => [
                                                        'class' => 'form-horizontal'
                                                    ]

                                                ]); ?>

                                                <?= $form->field($model, 'quantity')->textInput(['maxlength' => true, 'placeholder' => 0])->label(''); ?>
                                                <div class="DisplayNone" style="display: none;">
                                                    <?= $form->field($model, 'productId')->hiddenInput(['maxlength' => true, 'value' => (int)$product['id']])->label(''); ?>
                                                    <?= $form->field($model, 'productQuantity')->hiddenInput(['maxlength' => true, 'value' => (int)$product['quantity']])->label(''); ?>
                                                    <?= $form->field($model, 'productName')->hiddenInput(['maxlength' => true, 'value' => $product_name])->label(''); ?>
                                                    <?= $form->field($model, 'productExchangeRates')->hiddenInput(['maxlength' => true, 'value' => $exchange_rates])->label(''); ?>
                                                </div>
                                                <?= Html::submitButton($page_text['buy'], ['class' => 'buy_btn btn_' . $i, 'id' => 'index-buy-btn', 'data-name' => $product_name, 'data-quantyti' => $product["quantity"], 'data-product_id' => (int)$product['id']]) ?>

                                                <?php ActiveForm::end(); ?>
                                            </div>
                                        </div>

                                        <?php

                                    }
                                    ?>
                                </div>
                                <?php
                            }
                        }
                        ?>

                    </div>

                </div>
                <?php count($categories_1) == 0 ? $display = 'none' : $display = 'block'; ?>
                <div class="table_item" style="display: <?= $display ?>">
                    <div class="ti_header">


                        <div class="serv"><?= $page_text['service']; ?></div>
                        <div class="ammount"><?= $page_text['quantity']; ?></div>
                        <div class="price"><?= $page_text['price_for']; ?>
                            &#160<span>1 <?= $page_text['account']; ?></span></div>
                    </div>

                    <div class="ti_body">
                        <?php
                        if (isset($categories_1) && !empty($categories_1)) {
                            foreach ($categories_1 as $category_1) { ?>
                                <div class="ti_body_title">
                                    <?php
                                    if ($lang == 'ru') {
                                        $url = '';
                                        $category_name = $category_1["cateory_name_ru"];
                                    } else {
                                        $url = '/' . $lang;
                                        $category_name = $category_1["cateory_name_en"];
                                    }
                                    ?>

                                    <div class="ti_body_a" style="pointer-events: none;cursor: default;"><a
                                                href="<?= Url::to('/' . $lang . '/akkaunty-' . strtolower($category_name)); ?>">
                                            <div class="img-wrap"><img src="/img/<?= $category_1['image_main']; ?>">
                                            </div>
                                            <span><?= $category_name; ?></span></a></div>
                                    <?php
                                    foreach ($category_1["products_1"] as $product) {

                                        if ($lang == 'ru') {
                                            $product_name = $product["title_ru"];
                                            $product_description = $product["description_ru"];
                                        } else {
                                            $product_name = $product["title_en"];
                                            $product_description = $product["description_en"];
                                        }
                                        ?>


                                        <div class="ti_body_row" title="<?php if ($product_description) {
                                            echo $product_description;
                                        } ?>">
                                            <div class="ti_body_name"><?= $product_name; ?></div>
                                            <div class="ti_body_quanty"><?= $product["quantity"]; ?></div>
                                            <div class="ti_body_price">
                                                <?php
                                                $i = 1;
                                                foreach ($product["prices"] as $price) {
                                                    $i++;
                                                    if ($price['quantity_min'] == 1000) {
                                                        $quantity_min = '1K';
                                                    } elseif ($price['quantity_min'] == 10000) {
                                                        $quantity_min = '10K';
                                                    } elseif ($price['quantity_min'] == 20000) {
                                                        $quantity_min = '20K';
                                                    } elseif ($price['quantity_min'] == 1) {
                                                        $quantity_min = '1';
                                                    } else {
                                                        $quantity_min = $price['quantity_min'];
                                                    }

                                                    if ($price['quantity_max'] == 1000) {
                                                        $quantity_max = '1K';
                                                    } elseif ($price['quantity_max'] == 10000) {
                                                        $quantity_max = '10K';
                                                    } elseif ($price['quantity_max'] == 20000) {
                                                        $quantity_max = '20K';
                                                    } elseif ($price['quantity_max'] == 50000) {
                                                        $quantity_max = '50K';
                                                    } else {
                                                        $quantity_max = $price['quantity_max'];
                                                    }
                                                    ?>

                                                    <?= $quantity_min . '-' . $quantity_max . ': ' . round(($price['price'] * $exchange_rates), 2) . $currency_sign . ' |' ?>

                                                <?php } ?>

                                            </div>
                                            <div class="ti_body_form">

                                                <?php $form = ActiveForm::begin([
                                                    'id' => 'form-buyakkounts-index_' . $i,
                                                    'action' => "$url/buyakkaynt",
                                                    'method' => 'post',
                                                    'enableAjaxValidation' => false,
                                                    'enableClientValidation' => true,
                                                    'options' => [
                                                        'class' => 'form-horizontal'
                                                    ]

                                                ]); ?>

                                                <?= $form->field($model, 'quantity')->textInput(['maxlength' => true, 'class' => 'tooltipstered', 'placeholder' => 0])->label(''); ?>
                                                <div class="DisplayNone" style="display: none;">
                                                    <?= $form->field($model, 'productId')->hiddenInput(['maxlength' => true, 'value' => (int)$product['id']])->label(''); ?>
                                                    <?= $form->field($model, 'productQuantity')->hiddenInput(['maxlength' => true, 'value' => (int)$product['quantity']])->label(''); ?>
                                                    <?= $form->field($model, 'productName')->hiddenInput(['maxlength' => true, 'value' => $product_name])->label(''); ?>
                                                </div>
                                                <?= Html::submitButton($page_text['buy'], ['class' => 'buy_btn', 'id' => 'index-buy-btn', 'data-name' => $product_name, 'data-quantyti' => $product["quantity"], 'data-product_id' => (int)$product['id']]) ?>


                                                <?php ActiveForm::end(); ?>
                                            </div>
                                        </div>

                                        <?php

                                    }
                                    ?>
                                </div>
                                <hr>
                                <?php
                            }
                        }
                        ?>


                    </div>

                </div>
                <?php Pjax::end(); ?>
            </div>

            <div class="tabs_body">
                <div class="title_wrap">
                    <h5><?= $page_text['account_categories']; ?>:</h5>
                </div>
                <div class="tabs_body_accordion">
                    <?php
                    if (isset($sideBar) && !empty($sideBar)) {
                        foreach ($sideBar as $value) {
                            if (Yii::$app->language == 'ru-RU') {
                                $nameCategory = $value["name_ru"];
                            } else {
                                $nameCategory = $value["name_en"];
                            }
                            ?>

                            <div class="tba_item">
                                <div class="tba_item_button"><span><?= $nameCategory; ?></span><i
                                            class="fa fa-angle-down"></i></div>
                                <div class="tba_item_body">
                                    <ul class="tba_item_body_list">
                                        <?php
                                        foreach ($value["category"] as $item) {

                                            if (Yii::$app->language == 'ru-RU') {
                                                $nameCategoryChildren = $item["cateory_name_ru"];
                                            } else {
                                                $nameCategoryChildren = $item["cateory_name_en"];
                                            }
                                            ?>
                                            <li>
                                                <?php if ($lang == 'en') { ?>
                                                    <a href="<?= Url::to('/' . $lang . '/akkaunty-' . strtolower($item["cateory_name_en"])); ?>">
                                                        <img src="/img/<?= $item["image_side_bar"]; ?>"><span><?= $nameCategoryChildren; ?></span></a>
                                                <?php } else { ?>
                                                    <a href="<?= Url::to('/akkaunty-' . strtolower($item["cateory_name_en"])); ?>">
                                                        <img src="/img/<?= $item["image_side_bar"]; ?>"><span><?= $nameCategoryChildren; ?></span></a>
                                                <?php } ?>
                                            </li>
                                        <?php } ?>

                                    </ul>
                                </div>
                            </div>

                            <?php
                        }
                    }
                    ?>
                </div>

            </div>
        </div>
    </div>
</section>

<section class="other_main">
    <div class="container">
        <div class="share_link" style="display: none;">
            <p class="share_link_p"><?= $page_text['soc_seti_text']; ?>:</p>
            <div class="link_list">
                <ul>
                    <li>
                        <div class="g-plusone"></div>
                        <script type="text/javascript">
                            window.___gcfg = {lang: 'ru'};

                            (function () {
                                var po = document.createElement('script');
                                po.type = 'text/javascript';
                                po.async = true;
                                po.src = 'https://apis.google.com/js/plusone.js';
                                var s = document.getElementsByTagName('script')[0];
                                s.parentNode.insertBefore(po, s);
                            })();
                        </script>
                    </li>
                    <li>
                        <script>(function (d, s, id) {
                                var js, fjs = d.getElementsByTagName(s)[0];
                                if (d.getElementById(id)) return;
                                js = d.createElement(s);
                                js.id = id;
                                js.src = "//connect.facebook.net/ru_RU/sdk.js#xfbml=1&version=v2.8";
                                fjs.parentNode.insertBefore(js, fjs);
                            }(document, 'script', 'facebook-jssdk'));</script>
                        <div class="fb-like" data-href="https://stockaccs.com/<?= $_SERVER['REQUEST_URI']; ?>"
                             data-layout="button_count"
                             data-action="like" data-show-faces="true" data-share="false"></div>
                    </li>
                    <li><a href="https://twitter.com/share" class="twitter-share-button" data-size="large">Tweet</a>
                        <script>!function (d, s, id) {
                                var js, fjs = d.getElementsByTagName(s)[0],
                                    p = /^http:/.test(d.location) ? 'http' : 'https';
                                if (!d.getElementById(id)) {
                                    js = d.createElement(s);
                                    js.id = id;
                                    js.src = p + '://platform.twitter.com/widgets.js';
                                    fjs.parentNode.insertBefore(js, fjs);
                                }
                            }(document, 'script', 'twitter-wjs');</script>
                    </li>
                </ul>
            </div>
        </div>
        <?php
        if (Yii::$app->session->hasFlash('success')):?>
            <div id="close_allert_success_index">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="margin-top: -3%;">×
                </button>
                <?= Yii::$app->session->getFlash('success'); ?>
            </div>
        <?php endif; ?>
        <div class="form_valid_wrap">
            <div class="form_container">
                <p><?= $page_text['form_need_acc_header']; ?>:</p>

                <?php $form = ActiveForm::begin(); ?>


                <?= $form->field($model_form_footer, 'fom_name')->hiddenInput(['value' => 'форма с футера', 'style' => ['display' => 'none']])->label(false); ?>

                <?= $form->field($model_form_footer, 'status')->hiddenInput(['value' => '0', 'style' => ['display' => 'none']])->label(false); ?>

                <?= $form->field($model_form_footer, 'product_name')->textInput(['rows' => 6]) ?>

                <?= $form->field($model_form_footer, 'quantyti')->textInput() ?>

                <?= $form->field($model_form_footer, 'email')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model_form_footer, 'reCaptcha', ['enableAjaxValidation' => false])->widget(ReCaptcha::className(),
                    ['siteKey' => '6Le0nz0UAAAAAPA7i9NW_W7SIDiBCTwaRSJ9m32f', 'theme' => 'white']
                )->label('') ?>

                <div class="form-group">
                    <?= Html::submitButton($page_text['form_button'], ['class' => 'btn-form']) ?>
                </div>

                <?php ActiveForm::end(); ?>

            </div>
            <div class="valid_container">
                <p><?= $page_text['nevalid_acc']; ?>: <a href="#">xtz4ever@yandex.ua</a></p>
                <div class="img_wrap"><img src="/img/warning.png"></div>
                <p><?= $page_text['nevalid_acc_2']; ?>.</p>
            </div>
        </div>
        <div class="main_article">
            <article>
                <?php
                if (isset($pageInfo["description"]) && !empty($pageInfo["description"])) {
                    echo $pageInfo["description"];
                }
                ?>
            </article>
        </div>
    </div>
</section>















<div class="container">
    <div class="table_tabs_wrap">
        <div class="table_body">
            <div class="table_item main">
                <div class="ti_header">
                    <div class="serv">СЕРВИС</div>
                    <div class="amount">КОЛИЧЕСТВО</div>
                    <div class="price">ЦЕНА ЗА&#160<span>1К АККАУНТОВ</span></div>
                    <div class="currency">
                        <div class="currency_rub active_curr"><a href="#">RUB</a></div>
                        <div class="currency_usd"><a href="#">USD</a></div>
                        <div class="currency_eur"><a href="#">EUR</a></div>
                    </div>
                </div>
                <div class="ti_body">
                    <div class="ti_body_title">
                        <div class="ti_body_a"><a href="#">
                                <div class="img-wrap"><img src="img/logo-mail-ru.png"></div><span>MAIL.RU</span></a></div>
                        <div class="ti_body_row">
                            <div class="ti_body_name">МУЖ. ИМЕНА</div>
                            <div class="ti_body_quanty">0</div>
                            <div class="ti_body_price">1-1K: 2.1 $ | 1K-10K: 1.9 $ | 10K-50K: 232323.8 $ |</div>
                            <div class="ti_body_form">
                                <form>
                                    <input type="text" placeholder="0">
                                    <button class="buy_btn">Купить</button>
                                </form>
                            </div>
                        </div>
                        <div class="ti_body_row">
                            <div class="ti_body_name">NO SPAM</div>
                            <div class="ti_body_quanty">0</div>
                            <div class="ti_body_price">1-1K: 2.1 $ | 1K-10K: 1.9 $ | 10K-50K: 3232.8 $ |</div>
                            <div class="ti_body_form">
                                <form>
                                    <input type="text" placeholder="0">
                                    <button class="buy_btn">Купить</button>
                                </form>
                            </div>
                        </div>
                        <div class="ti_body_row">
                            <div class="ti_body_name">МОЙ МИР</div>
                            <div class="ti_body_quanty">0</div>
                            <div class="ti_body_price">1-1K: 2.1 $ | 1K-10K: 1.9 $ | 10K-50K: 1.8 $ |</div>
                            <div class="ti_body_form">
                                <form>
                                    <input type="text" placeholder="0">
                                    <button class="buy_btn">Купить</button>
                                </form>
                            </div>
                        </div>
                        <div class="ti_body_row">
                            <div class="ti_body_name">НА ДОМЕНЕ @ВК.RU</div>
                            <div class="ti_body_quanty">999999</div>
                            <div class="ti_body_price">1-1K: 2.1 $ | 1K-10K: 1.9 $ | 10K-50K: 1.2323 $ |</div>
                            <div class="ti_body_form">
                                <form>
                                    <input type="text" placeholder="0">
                                    <button class="buy_btn">Купить</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tabs_body">
            <div class="title_wrap">
                <h5>Категории аккаунтов:</h5>
            </div>
            <div class="tabs_body_accordion">
                <div class="tba_item">
                    <div class="tba_item_button akkaunty_tba"><span>СОЦИАЛЬНЫЕ СЕТИ</span><i class="fa fa-angle-down"></i></div>
                    <div class="tba_item_body">
                        <ul class="tba_item_body_list">
                            <li><a href="#"><img src="img/FB.png"><span>Facebook</span></a></li>
                            <li><a href="#"><img src="img/INSTA.png"><span>Instagram</span></a></li>
                            <li><a href="#"><img src="img/odn.png"><span>Odnoklassniki</span></a></li>
                            <li><a href="#"><img src="img/TWITTWR.png"><span>Twitter</span></a></li>
                            <li><a href="#"><img src="img/vk.png"><span>Vkontakte</span></a></li>
                        </ul>
                    </div>
                </div>
                <div class="tba_item">
                    <div class="tba_item_button akkaunty_tba"><span>СОЦИАЛЬНЫЕ СЕТИ</span><i class="fa fa-angle-down"></i></div>
                    <div class="tba_item_body">
                        <ul class="tba_item_body_list">
                            <li><a href="#"><img src="img/FB.png"><span>Facebook</span></a></li>
                            <li><a href="#"><img src="img/INSTA.png"><span>Instagram</span></a></li>
                            <li><a href="#"><img src="img/odn.png"><span>Odnoklassniki</span></a></li>
                            <li><a href="#"><img src="img/TWITTWR.png"><span>Twitter</span></a></li>
                            <li><a href="#"><img src="img/vk.png"><span>Vkontakte</span></a></li>
                        </ul>
                    </div>
                </div>
                <div class="tba_item">
                    <div class="tba_item_button akkaunty_tba"><span>СОЦИАЛЬНЫЕ СЕТИ</span><i class="fa fa-angle-down"></i></div>
                    <div class="tba_item_body">
                        <ul class="tba_item_body_list">
                            <li><a href="#"><img src="img/FB.png"><span>Facebook</span></a></li>
                            <li><a href="#"><img src="img/INSTA.png"><span>Instagram</span></a></li>
                            <li><a href="#"><img src="img/odn.png"><span>Odnoklassniki</span></a></li>
                            <li><a href="#"><img src="img/TWITTWR.png"><span>Twitter</span></a></li>
                            <li><a href="#"><img src="img/vk.png"><span>Vkontakte</span></a></li>
                        </ul>
                    </div>
                </div>
                <div class="tba_item">
                    <div class="tba_item_button akkaunty_tba"><span>СОЦИАЛЬНЫЕ СЕТИ</span><i class="fa fa-angle-down"></i></div>
                    <div class="tba_item_body">
                        <ul class="tba_item_body_list">
                            <li><a href="#"><img src="img/FB.png"><span>Facebook</span></a></li>
                            <li><a href="#"><img src="img/INSTA.png"><span>Instagram</span></a></li>
                            <li><a href="#"><img src="img/odn.png"><span>Odnoklassniki</span></a></li>
                            <li><a href="#"><img src="img/TWITTWR.png"><span>Twitter</span></a></li>
                            <li><a href="#"><img src="img/vk.png"><span>Vkontakte</span></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

























