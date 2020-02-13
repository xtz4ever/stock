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
                            <a href="/services">Услуги</a>
                            <i class="fa fa-angle-down"  ></i>
                            <div class="footer_dropdown">
                                <i>
                                    <img src="img/decor_header_dropdown.png" alt="">
                                </i>
                                <ul>
                                    <?php if ($category) {
                                        foreach ($category as $val) {
                                            ?>
                                            <li style="width: 100%;">

                                                <a href="/<?= $val['url'] ?>"><?= $val['name'] ?></a>
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
            <div class="col-sm-6 col-lg-3"> <a href="/feedbacks">Отзывы</a></div>
            <div class="col-sm-6 col-lg-3"><a href="/createcontacts">Контакты</a></div>
            <div class="col-sm-6 col-lg-3"><a href="/faq">FAQ</a></div>
        </div>
    </div>
</footer>