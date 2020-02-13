<!-- Секция countries_and_prices -->
<style>
    section{
        background-color: rgba(56, 63, 117, 0)!important;
    }
     p, h2{
        color: #575858;
    }
     #countries_and_prices_right{
         background-color: rgba(56, 63, 117, 0.5)!important;
     }

    header{
        min-height: 400px;
    }
</style>

<section class="countries_and_prices" style="display: none;opacity: 0;z-index: -100;position: absolute">
    <div class="container">
        <div class="row">
            <div class="countries_and_prices_left col-md-5">
                <h2>Почему мы?</h2>
                <p>Вот сюда нужно будет вписать текст и придумать 3 - 4 пункта почему именно ВЫ должны это делать. Очень полезно для СЕО
                </p>
                <div class="countries_and_prices_left_items">
                    <div class="countries_and_prices_left_item">
                        <div class="countries_and_prices_left_item_inner_wrap">
                            <div class="countries_and_prices_left_item_img">
                                <img src="img/countries_and_prices_left_item_img1.svg" alt="">
                            </div>
                            <div class="countries_and_prices_left_item_txt">
                                <p class="title">Скорость</p>
                                <p>Интернет канал 100 Мбит/c</p>
                            </div>
                        </div>
                    </div>
                    <div class="countries_and_prices_left_item">
                        <div class="countries_and_prices_left_item_inner_wrap">
                            <div class="countries_and_prices_left_item_img">
                                <img src="img/countries_and_prices_left_item_img2.svg" alt="">
                            </div>
                            <div class="countries_and_prices_left_item_txt">
                                <p class="title">Подсети</p>
                                <p>Прокси выдаются более чем из 150 разных подсетей
                                    и 70 сетей</p>
                            </div>
                        </div>
                    </div>
                    <div class="countries_and_prices_left_item">
                        <div class="countries_and_prices_left_item_inner_wrap">
                            <div class="countries_and_prices_left_item_img">
                                <img src="img/countries_and_prices_left_item_img3.svg" alt="">
                            </div>
                            <div class="countries_and_prices_left_item_txt">
                                <p class="title">Поддержка</p>
                                <p>Круглосуточная техническая поддержка</p>
                            </div>
                        </div>
                    </div>
                    <div class="countries_and_prices_left_item">
                        <div class="countries_and_prices_left_item_inner_wrap">
                            <div class="countries_and_prices_left_item_img">
                                <img src="img/countries_and_prices_left_item_img4.svg" alt="">
                            </div>
                            <div class="countries_and_prices_left_item_txt">
                                <p class="title">Возврат или замена</p>
                                <p>Замена прокси или возврат денег в течении суток после
                                    выдачи</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="countries_and_prices_right_wrap">
                <div id="countries_and_prices_right" class="countries_and_prices_right col-md-7">
                    <div class="countries_and_prices_right_decor">
                        <img src="img/countries_and_prices_right_elips.png" alt="">
                    </div>
                    <div class="countries_and_prices_right_inner">
                        <div class="title_table">
                            <p>Услуги</p>
                        </div>
                        <table class="table">
                            <tbody>
                            <!--не забываем прописать в нужном элементе (в данном случае tr)  data-href="..." как будто это ссылка-->

                            <?php if (isset($category)){
                                foreach ($category as $val){ ?>
                                    <tr onclick="document.location = <?= '/service-'.$val['url'];?>">
                                <td>

                                   <a href="<?= '/service-'.$val['url'];?>"><?=$val['name'];?></a>
                                    </td>
                                <td style="opacity: 0">80 руб. / мес.</td>
                            </tr>
                            <?php
                                }
                            }?>




                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Секция countries_and_prices -->
<section class="countries_and_prices">
    <div class="container">

        <div class="row">
            <div class="countries_and_prices_wrap center-block col-sm-8">
            <p><?= $pageInfo["description"];?></p>
            </div>
        </div>
    </div>
</section>