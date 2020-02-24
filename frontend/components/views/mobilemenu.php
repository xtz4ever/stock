<nav class="header_nav_mobile">
    <h3><a href="/services">УСЛУГИ</a></h3>

    <ul class="menu">
        <?php if ($category) {
            foreach ($category as $val) {
                ?>
                <li style="width: 100%;">

                    <a href="<?= $val['url'] ?>"><?= $val['name'] ?></a>
                </li>
                <?php
            }
        } ?>
    </ul>
    <h3>НАВИГАЦИЯ</h3>
    <ul class="menu">
        <li>
            <a href="/">Главная</a>
        </li>

        <li>
            <a href="/faq">FAQ</a>
        </li>

        <li>
            <a href="/feedbacks">Отзывы</a>
        </li>

        <li>
            <a href="/createcontacts">Контакты</a>
        </li>


    </ul>
    <h3>КОНТАКТЫ</h3>

    <ul class="menu contact">


        <?php if (!is_null($telephone)) { ?>
            <li><strong style="font-size: 15px;">Телефоны :</strong></li>
            <?php
            foreach ($telephone as $val) {
                ?>

                <li>
                    <i class="fa fa-phone"></i>
                    <a href="tel:<?= str_replace(' ', '', $val['text']); ?>"><?= $val['text']; ?></a>
                </li>

                <?php
            }
        } ?>


        <?php if (!is_null($viber)) { ?>
            <li><strong style="font-size: 15px;">VIBER</strong></li>
            <?php
            foreach ($viber as $val) {
                ?>
                <li>
                    <i class="fab fa-viber" style="width: 20px;height: 20px;font-size: 18px;"></i>
                    <a title="Viber"

                        <?php
                        $viber_number = str_replace(' ', '', $val['text']);
                        $viber_number = str_replace('+', '%2B', $viber_number);
                        ?>
                       href="viber://chat?number=<?=  $viber_number;?>"><?= $val['text']; ?>
                    </a>

                </li>

                <?php
            }
        } ?>

        <?php if (!is_null($email)) { ?>
            <li><strong style="font-size: 15px;">Email</strong></li>
            <?php
            foreach ($email as $val) {
                ?>
                <li>
                    <i class="fa fa-envelope"></i>
                    <a href="<?= $val['text']; ?>"><?= $val['text']; ?></a>
                </li>
                <?php
            }
        } ?>


        <?php if (!is_null($skype)) { ?>
            <li><strong style="font-size: 15px;">Skype</strong></li>
            <?php
            foreach ($skype as $val) {
                ?>
                <li>
                    <i class="fa fa-skype"></i>
                    <a href="skype:<?= $val['text']; ?>?call"><?= $val['text']; ?></a>
                </li>
                <?php
            }
        } ?>

        <?php if (!is_null($instagram)) { ?>
            <li><strong style="font-size: 15px;">Instagram</strong></li>
            <?php
            foreach ($instagram as $val) {
                ?>
                <li>
                    <i class="fa fa-instagram"></i>
                    <a href="https://www.instagram.com/<?= $val['text']; ?>"
                       target="_blank"><?= $val['text'] ?></a>
                </li>
                <?php
            }
        } ?>

        <?php if (!is_null($facebook)) { ?>
            <li><strong style="font-size: 15px;">Skype</strong></li>
            <?php
            foreach ($facebook as $val) {
                ?>
                <li>
                    <img style="width: 13px;margin-top: 0px;"
                         src="/img/facebook-square.svg"
                         alt="">

                    <a target="_blank"
                       href="https://www.facebook.com/<?= $val['text']; ?>"><?= $val['text']; ?></a>
                </li>
                <?php
            }
        } ?>

    </ul>

</nav>