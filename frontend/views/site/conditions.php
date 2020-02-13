<?php

use frontend\assets\AppAsset;
use \yii\helpers\Url;
use kartik\form\ActiveForm;
use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\widgets\Pjax;
use himiklab\yii2\recaptcha\ReCaptcha;


$this->registerJsFile('js/feedbacks.js',
    ['depends' => [AppAsset::className()],
        'position' => \yii\web\View::POS_END
    ]);
$this->registerCssFile('css/feedbacks.css',
    ['depends' => [AppAsset::className()],
        'position' => \yii\web\View::POS_HEAD
    ]);
?>
<style>
    .control-label {
        font-weight: 400;
        color: #474747;
    }

    .form_opinion {
        padding-top: 1px;
    }

    h4 {
        font-size: 20px;
        font-weight: 400;
        color: white;
        margin-bottom: 2%;
    }

    h1 {
        margin-left: 3%;
    }

    .help-block {
        display: none;
    }

    .loader_more {
        font-size: 28px;
    }

    ol > li {
        margin-bottom: 5px;
        font-size: 15px;
    }

    ol {
        margin-left: -3%;
        margin-right: 3%;
        margin-top: 3%;
    }

    .form_container {
        border: 1px solid #474747;
        border-radius: 15px;
    }

    .title_wrap {
        max-width: 48%;
        border: 1px solid grey;
        border-radius: 15px;
        padding: 1%;
        margin-bottom: 3%;
        text-align: center;

        background: #36394a;
    }
    ul.ul_xtz >  li > a{
        margin-left: 2%;
        color: #bb0b3a;
    }
    ul.ul_xtz > li {
        margin-bottom: 5%;
    }
   ul.contacts_list.xtz > li > span{
        margin-left: 2%;
        font-weight: 900;
    }
    ul.contacts_list.xtz > li{
        margin-bottom: 2%;
    }

</style>
<section class="feedbacks-section">

    <div class="container">

        <div class="title_wrap_h2">

        </div>

    </div>
</section>
<section class="form_opinion">

    <div class="container">

        <div class="title_wrap" style="margin-bottom: -5%;">
            <h4><?= $page_text['leave_a_review']; ?></h4>
        </div>
        <div class="title_wrap xtz" style="margin-left: 52%;">
            <h4><?= $page_text['leave_a_review_2']; ?></h4>
        </div>

        <div class="form_opinion_wrap">
            <div class="form_container">


                <?php

                if (!empty($pageInfo["h1"])) {
                    echo '<h1>' . $pageInfo["h1"] . '</h1>';
                }

                if (!empty($pageInfo["description"])) {
                    echo $pageInfo["description"];
                }


                ?>


            </div>
            <div class="form_container">

                <div class="zxc" style="margin-left: 3%;min-height: 400px;">

                    <p style="margin-bottom: 3%;margin-top: 6%;"><?= $page_text['p_1'] ?></p>

                    <div class="resourse-list" style="margin-bottom: 5%;">
                        <ul class="ul_xtz">
                            <li><?= Yii::$app->params['Antichat'] ?></li>
                            <li><?= Yii::$app->params['GoFuckBiz'] ?></li>
                            <li><?= Yii::$app->params['Umaxforum'] ?></li>
                            <li><?= Yii::$app->params['Zloy'] ?></li>
                        </ul>
                    </div>
                    <p style="margin-bottom: 5%;"><?= $page_text['p_2'] ?></p>
                    <ul class="contacts_list xtz">
                        <li><?= Yii::$app->params['contacts_icq'] ?></li>
                        <li><?= Yii::$app->params['contacts_email'] ?></li>
                        <li><?= Yii::$app->params['contacts_skype'] ?></li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
</section>




