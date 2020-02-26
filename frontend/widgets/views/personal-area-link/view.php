<?php

use kartik\form\ActiveForm;
use yii\helpers\Html;
use yii\widgets\Pjax;

?>
<?php

if (Yii::$app->language == 'ru-RU') {


    $page_text['h2_text'] = 'Личный кабинет партнера';  /*Виджет*/
    $page_text['partner_link_text'] = 'Ваша партнерская ссылка:';  /*Виджет*/
    $page_text['update_link_button'] = 'Изменить';  /*Виджет*/
    $page_text['error_link_isset'] = 'Такая ссылка уже существует';  /*Виджет*/
    $page_text['success_link_save'] = 'Ссылка сохранена';  /*Виджет*/

    // основная форма
    $page_text['error_update_form'] = 'Ошибка. Данные не обновлены';
    $page_text['success_update_form'] = 'Данные успешно обновлены';

    $page_text['profile'] = 'Профиль';
    $page_text['button'] = 'Сохранить';


} else {

    $page_text['h2_text'] = "Partner's personal account";  /*Виджет*/
    $page_text['partner_link_text'] = 'Your affiliate link:';  /*Виджет*/
    $page_text['update_link_button'] = 'Update';  /*Виджет*/
    $page_text['error_link_isset'] = 'This link already exists';  /*Виджет*/
    $page_text['success_link_save'] = 'Link saved';  /*Виджет*/

    // основная форма
    $page_text['error_update_form'] = 'Error. Data not updated';
    $page_text['success_update_form'] = 'Data successfully updated';

    $page_text['profile'] = 'Profile';
    $page_text['button'] = 'Save';
}
?>

    <style>
        #partnerreferallinks-referal_link {
            margin-bottom: -7%;
        }

        #referal_link {
            width: 75%;
        }
        #partnerreferallinks-referal_link{
            margin-left: 6%;
        }

        #button_referal_link {
            margin-left: 83%;
        }

        .title_wrap_h2 > h2 {
            font-size: 45px;
            margin-top: 0;
            margin-bottom: .5rem;
        }
        #close_allert_success_index{
            z-index: 999999;
            /*position: absolute;*/
            /*margin-top: 7%;*/
            margin-left: 34%;
            background: #f34255;
            font-size: 17px;
            width: 38%;
            display: inline-block;
            padding-top: 10px;
            padding-bottom: 10px;
            padding-left: 5px;
            padding-right: 10px;
        }
        #partner-link-form{
            width: 76%;
        }
        .label-link{
            height: 2em;
            line-height: 1em;
            width: 20%;
        }
    </style>
<?php Pjax::begin(['enablePushState' => true]); ?>
    <section class="own_partner_cabinet">
        <div class="container">
            <div class="title_wrap_h2">

                <h2><?= $page_text['h2_text']; ?></h2>
                <?php if (Yii::$app->session->hasFlash('error_link_isset')): ?>
                    <div id="close_allert_success_index">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"
                                style="margin-top: -3%;color: white">×
                        </button>
                        <?= Yii::$app->session->getFlash('error_link_isset'); ?>
                    </div>
                <?php endif; ?>
                <?php if (Yii::$app->session->hasFlash('success_link_save')): ?>
                    <div id="close_allert_success_index">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"
                                style="margin-top: -3%;color: white">×
                        </button>
                        <?= Yii::$app->session->getFlash('success_link_save'); ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="input_button">
                <label class="label-link"><?= $page_text['partner_link_text']; ?></label>

                <?php $form = ActiveForm::begin(
                    ['options' => ['data-pjax' => true]/*,'action' => 'create-new-referal-link'*/, 'method' => 'post', 'id' => 'partner-link-form']
                    ); ?>

                <?= $form->field($model, 'referal_link', ['inputOptions' => ['autofocus' => 'autofocus']])->textInput(['value' => $link['referal_link'], 'readOnly' => false])->label(false); ?>

                <?= $form->field($model, 'partner_id')->textInput(['value' => Yii::$app->user->identity->getId(), 'style' => ['display' => 'none']])->label(false) ?>

                <?= Html::submitButton($page_text['update_link_button'], ['class' => 'btn-form', 'id' => 'button_referal_link']) ?>

                <?php $form = ActiveForm::end(); ?>

            </div>
        </div>
    </section>
    <div class="container">
        <hr style="border-top: 1px solid #020101">
    </div>
<?php Pjax::end(); ?>