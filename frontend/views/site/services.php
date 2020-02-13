<section class="proxy_ipv6">
    <div class="container">
        <div class="row">
            <div class="proxy_ipv6_title">
                <h1 class="inner"><?= $pageInfo['h1']; ?></h1>


            </div>
            <div class="proxy_ipv6_items ani">
                <?php
                if (isset($category)){
                    foreach ($category as $val) {
                        ?>
                        <div class="margin_b col-lg-4 col-md-4 col-sm-4 col-xs-6">
                            <div class="proxy_ipv6_item">

                                <div class="proxy_ipv6_item_inner" >
                                    <a  href="<?= $val['url']; ?>">
                                    <?= \yii\helpers\Html::img('/img/'.$val['img']);?>
                                    </a>
                                    <a  class="proxy_pieces" href="<?= $val['url']; ?>"><?= $val['name']; ?></a>

                                </div>
                            </div>
                        </div>
                        <?php
                    }
                }
                ?>
            </div>
        </div>
        <div class="countries_and_prices_wrap center-block col-sm-12">
            <?= $pageInfo['description']; ?>
        </div>
    </div>
</section>

