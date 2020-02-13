<header id="header" class="header">
    <?php
/*    $lang = substr(Yii::$app->language, 0, 2);

    */?>
    <?php if ($phone === true) { ?>
        <div class="container" style="text-align: center;padding-top: 13%;">
            <div class="row">
                <a href="/" class="logo">
                    <i>
                        <img src="img/logo.png" alt="">
                    </i>
                </a>
            </div>
        </div>
    <?php } ?>

    <div class="container">
        <div class="row">

            <div class="header_nav_wrap">
                <nav class="header_nav">
                    <a href="/" class="logo">
                        <img src="/img/logo.png" alt="">
                    </a>
                    <ul>

                        <!--                        <li>-->
                        <!--                            <a href="/our-works">Портфолио</a>-->
                        <!--                        </li>-->

                        <li>
                            <a href="/services">Услуги</a>
                            <i class="fa fa-angle-down"></i>
                            <div class="header_dropdown">

                                <ul style="display: table-cell;width: 800px">
                                    <?php if ($category) {
                                        foreach ($category as $val) {
                                            ?>
                                            <li style="width: 30%;float: left ">

                                                <a style="font-size: 13px;"
                                                   href="/<?= $val['url'] ?>"><?= $val['name'] ?></a>
                                            </li>
                                            <?php
                                        }
                                    } ?>
                                </ul>


                            </div>
                        </li>
                        <li>
                            <a href="/faq">FAQ</a>
                        </li>
                        <!--                        <li>-->
                        <!--                            <a href="/" class="logo">-->
                        <!--                                <i>-->
                        <!--                                    <img src="img/logo.png" alt="">-->
                        <!--                                </i>-->
                        <!--                            </a>-->
                        <!--                        </li>-->

                        <li>
                            <a href="/feedbacks">Отзывы</a>
                        </li>

                        <!--                        <li>-->
                        <!--                            <a data-modal="modal-2" class="modal_xtz" style="width: 100px;height: 25px" href="#">Контакты</a>-->
                        <!--                        </li>-->
                        <li>
                            <a href="/createcontacts">Контакты</a>
                        </li>

                        <?=\frontend\widgets\WLang::widget();?>
                    </ul>
                </nav>

            </div>
            <!--            <div class="header_title">-->
            <!--                <h1>--><?php //if (isset($text['h1'])) {
            //                        echo $text['h1'];
            //                    } ?>
            <!--                </h1>-->
            <!--            </div>-->


        </div>
    </div>

</header>