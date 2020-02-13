<?php
use frontend\assets\AppAsset;
?>



<style>
    .dedicated_server_top_decor{
        display: none!important;
    }
</style>


<section class="сonditions dedicated" >
    <div class="container">
        <div class="row">
            <div class="col-lg-12 dedicated_title">
                <h1 class="center inner"><?= $meta['h1'] ?></h1>
                <p class="center"><?= $meta['description'] ?> </p>
            </div>
            <div class="col-lg-12 scroll_wrap">
                <div class="dedicated_server_top">
                   
                    <div class="dedicated_server_top_inner">

                        <?php if($faq_list): ?>
                            <?php foreach ($faq_list as $item) { ?>
                                <div class="accordion frequently_asked_questions">
                                    <div class="accordion accordion_title accordion_xtz">
                                        <p><?= $item['question'] ?></p>
                                        <i class="fa fa-angle-down"></i>
                                    </div>
                                    <div class="accordion_content">
                                        <p><?= $item['answer'] ?></p>
                                    </div>
                                </div>
                            <?php } ?>
                        <?php endif; ?>
                    </div>
                </div>

            </div>



        </div>
    </div>
</section>

