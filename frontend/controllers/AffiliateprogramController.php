<?php

namespace frontend\controllers;

use common\models\PartnerPromotionalCategory;
use common\models\User;
use common\models\Wallets;
use frontend\models\Partner;
use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use common\models\PartnerReferalLinks;
use common\models\UserWallets;
use common\models\PartnerPersonalAreaStatistic;
use common\models\PartnerUnpaidAmount;
use common\models\PartnerPaymentsList;
use yii\data\Pagination;
use yii\helpers\Url;
use common\models\PartnerPercentForPaiment;

/**
 * App controller
 */
class AffiliateprogramController extends AppController
{

    public $layout = 'affiliateprogram';


// Проверка для особо ушлых. Что бы без авторизации не переходили на страницы Л.К.
    public function beforeAction($action)
    {
        /* H1, description, SEO */
        $this->PageInfo(Yii::$app->controller->action->id);
        if (Yii::$app->user->isGuest === true) {
            if (Yii::$app->controller->action->id == 'login-partner' ||
                Yii::$app->controller->action->id == 'password-reset-partner' ||
                Yii::$app->controller->action->id == 'signup-partner' ||
                Yii::$app->controller->action->id == 'affiliate-program-main'
            ) {

                return true;
//                return $this->redirect('/affiliate-program-main',302)->send();
            } else {
                return $this->redirect('affiliate-program-main', 302)->send();
            }

        } else {
            return true;
        }
    }


    public function actionAffiliateProgramMain()
    {


        /* H1, description */
        $pageInfo = $this->PageInfo(Yii::$app->controller->action->id);

        // Все слова и предложения в зависимости от страницы
        $page_text = $this->getText();

        // Язык
        $lang = substr(Yii::$app->language, 0, 2);


        return $this->render('affiliate-program-main', [
            'pageInfo' => $pageInfo,
            'page_text' => $page_text,
            'lang' => $lang,
        ]);
    }

    public function actionLoginPartner()
    {

//        if (!Yii::$app->user->isGuest) {
//            return $this->goHome();
//        }

        $model = new LoginForm();
        // Все слова и предложения в зависимости от страницы
        $page_text = $this->getText();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->isPartner() && $model->login()) {
                return $this->redirect('personal-area');
//                return $this->goBack();
            } else {
                Yii::$app->session->setFlash('error_login');
            }
        }

        return $this->render('login-partner', [
            'model' => $model,
            'page_text' => $page_text,
        ]);
    }
//    public function actionAjaxIsProvider()
//    {
//        $model = new LoginForm();
//        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
//            Yii::$app->response->format = Response::FORMAT_JSON;
//
//            if ($model->isProvider() !== 1){
//                Yii::$app->session->setFlash('error_login', 'У вас нет прав для доступа!');
//            }
//            return ActiveForm::validate($model);
//        }
//    }

    function actionSignupPartner()
    {
        $model = new SignupForm();
        // Все слова и предложения в зависимости от страницы
        $page_text = $this->getText();


        if ($model->load(Yii::$app->request->post())) {

            if ($user = $model->signup()) {

                $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                $name = '';
                for ($i = 0; $i <= 12; $i++) {
                    $name .= $characters[mt_rand(0, strlen($characters) - 1)];
                }

                $link = new PartnerReferalLinks();
                $link->partner_id = $user->id;
                $link->referal_link = 'https://stockaccs.com/?parther=' . $name;
                $link->save();

                $percent = new PartnerPercentForPaiment();
                $percent->CreatePercentagForPArtner($user->id);

                $amount = new PartnerUnpaidAmount();
                $amount->createPartnerUnpaidAmount($user->id);

                if (Yii::$app->getUser()->login($user)) {
                    return $this->redirect('personal-area');
                }
            }
        }

        return $this->render('signup-partner', [
            'model' => $model,
            'page_text' => $page_text,
        ]);
    }

    public
    function actionPasswordResetPartner()
    {
        $model = new PasswordResetRequestForm();

        // Все слова и предложения в зависимости от страницы
        $page_text = $this->getText();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {


                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        return $this->render('password-reset-partner', [
            'model' => $model,
            'page_text' => $page_text,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public
    function actionResetPassword($token)
    {

        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    public function actionPersonalArea()
    {
        $page_text = $this->getText();

        // Форма в хедере с ссылкой
        if (isset(Yii::$app->request->post()["PartnerReferalLinks"])) {
            $model = new PartnerReferalLinks();
            if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                if ($model->save()) {
                    Yii::$app->session->setFlash('success_link_save', $page_text['success_link_save']);
                }
            } else {
                if (isset($model->getErrors()["referal_link"][0]) && $model->getErrors()["referal_link"][0] == 'isset') {
                    Yii::$app->session->setFlash('error_link_isset', $page_text['error_link_isset']);

                }
            }
        }

        // основная форма
        $model = new Partner();
        if (isset(Yii::$app->request->post()["Partner"])) {
            if ($model->load(Yii::$app->request->post())) {
                $error = 0;
                // Сохраняем кошелек если добавили новый
                if ($model->wallets != '') {
                    $wallet = new Wallets();
                    $new_wallet = $wallet->saveUserWallet($model->wallets, $model->user_id, $model->add_wallet, 'partner');
                    if ($new_wallet === false) {
                        $error = 1;
                    }
                }
                // обновляем данные по пользователю
                $user = $this->findModel($model->user_id);

                if ($model->password != '') {
                    $user->password_hash = Yii::$app->security->generatePasswordHash($model->password);
                }
                $user->username = $model->username;
                $user->email = $model->email;
                if (!$user->save()) {
                    $error = 1;
                }
                if ($error == 0) {
                    Yii::$app->session->setFlash('success_update_form', $page_text['success_update_form']);
                } else {
                    Yii::$app->session->setFlash('error_update_form', $page_text['error_update_form']);
                }
            }
        }

        $partner_info = new User();
        $partner_info = $partner_info->findByPartner(\Yii::$app->user->identity->username);

        $wallets = new Wallets();
        $wallets = $wallets->getWalletsLang('for_partner');

        $model_2 = new UserWallets();
        $user_wallets = $model_2->getAllPartnerWallets(Yii::$app->user->identity->id);


        return $this->render('personal-area', ['model' => $model,
            'partner_info' => $partner_info,
            'wallets' => $wallets,
            'user_wallets' => $user_wallets,
            'page_text' => $page_text,
        ]);
    }

    public
    function actionDelleteWallet($id)
    {
        $model = new UserWallets();

        $model = $model->getOneWallet($id);

        if ($model->delete()) {
            return $this->redirect('/personal-area');
        }


    }

    public
    function actionPersonalAreaStatistic()
    {
        // текста для страницы
        $page_text = $this->getText();

        // Язык
        $lang = substr(Yii::$app->language, 0, 2);
        // Форма в хедере с ссылкой
        if (isset(Yii::$app->request->post()["PartnerReferalLinks"])) {
            $model = new PartnerReferalLinks();
            if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                if ($model->save()) {
                    Yii::$app->session->setFlash('success_link_save', $page_text['success_link_save']);
                }
            } else {
                if (isset($model->getErrors()["referal_link"][0]) && $model->getErrors()["referal_link"][0] == 'isset') {
                    Yii::$app->session->setFlash('error_link_isset', $page_text['error_link_isset']);

                }
            }
        }
        $model = new PartnerPersonalAreaStatistic();

        // Одобренные невыплаченные комиссии.
        $unpaid_amount_model = new PartnerUnpaidAmount();
        $unpaid_amount = $unpaid_amount_model->getPartnerUnpaidAmount(Yii::$app->user->identity->getId());
        $unpaid_amount = $unpaid_amount["amount"];

        // СТАТИСТИКА
        $amount = 0;
        $perekhodov_po_ssylke = 0;
        $oformlennykh_pokupok = 0;
        $oplachennykh_pokupok = 0;
        $ne_oplachennykh_pokupok = 0;
        $povtornykh_pokupok_referalov = 0;

        if ($model->load(Yii::$app->request->post())) {
            // что бы выборка работала правильно к конечной дате добавляю 1 день
            $date_end = date('Y-m-d', strtotime($model->date_end) + 1 * 24 * 3600);
            $statistic = $model->getStatisticForThePeriod($model->user_id, $model->date_start, $date_end);

            // привожу дату к нужному формату
            $date_start = date('d.m.Y', strtotime($model->date_start));
            $date_end = date('d.m.Y', strtotime($model->date_end));

        } else {

            // по умолчанию выборка идет за текущий день
            $date_start = date('Y-m-d');
            $date_end = date('Y-m-d');

            // что бы выборка работала правильно к конечной дате добавляю 1 день
            $date_end_plus_1 = date('Y-m-d', strtotime($date_end) + 1 * 24 * 3600);
            $statistic = $model->getStatisticForThePeriod(Yii::$app->user->identity->getId(), $date_start, $date_end_plus_1);

        }
        // суммирую все данные за выбранный период
        if ($statistic != null) {
            foreach ($statistic as $value) {
                $amount += $value['amount'];
                $perekhodov_po_ssylke += $value['perekhodov_po_ssylke'];
                $oformlennykh_pokupok += $value['oformlennykh_pokupok'];
                $oplachennykh_pokupok += $value['oplachennykh_pokupok'];
                $ne_oplachennykh_pokupok += $value['ne_oplachennykh_pokupok'];
                $povtornykh_pokupok_referalov += $value['povtornykh_pokupok_referalov'];
            }
        }

        return $this->render('personal-area-statistic', [
            'page_text' => $page_text,
            'model' => $model,
            'date_start' => date('d.m.Y', strtotime($date_start)),
            'date_end' => date('d.m.Y', strtotime($date_end)),
            'amount' => $amount,
            'perekhodov_po_ssylke' => $perekhodov_po_ssylke,
            'oformlennykh_pokupok' => $oformlennykh_pokupok,
            'oplachennykh_pokupok' => $oplachennykh_pokupok,
            'ne_oplachennykh_pokupok' => $ne_oplachennykh_pokupok,
            'povtornykh_pokupok_referalov' => $povtornykh_pokupok_referalov,
            'unpaid_amount' => $unpaid_amount,
            'lang' => $lang,
        ]);
    }

    public function actionPersonalAreaBalance()
    {
        // текста для страницы
        $page_text = $this->getText();


        // Форма в хедере с ссылкой
        if (isset(Yii::$app->request->post()["PartnerReferalLinks"])) {
            $model = new PartnerReferalLinks();
            if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                if ($model->save()) {
                    Yii::$app->session->setFlash('success_link_save', $page_text['success_link_save']);
                }
            } else {
                if (isset($model->getErrors()["referal_link"][0]) && $model->getErrors()["referal_link"][0] == 'isset') {
                    Yii::$app->session->setFlash('error_link_isset', $page_text['error_link_isset']);

                }
            }
        }

        // Одобренные невыплаченные комиссии.
        $unpaid_amount_model = new PartnerUnpaidAmount();
        $unpaid_amount = $unpaid_amount_model->getPartnerUnpaidAmount(Yii::$app->user->identity->getId());
        $unpaid_amount = $unpaid_amount["amount"];

        return $this->render('personal-area-balance', [
            'page_text' => $page_text,
            'unpaid_amount' => $unpaid_amount,
        ]);
    }

    public function actionPersonalAreaPayments()
    {
        // текста для страницы
        $page_text = $this->getText();


        // Форма в хедере с ссылкой
        if (isset(Yii::$app->request->post()["PartnerReferalLinks"])) {
            $model = new PartnerReferalLinks();
            if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                if ($model->save()) {
                    Yii::$app->session->setFlash('success_link_save', $page_text['success_link_save']);
                }
            } else {
                if (isset($model->getErrors()["referal_link"][0]) && $model->getErrors()["referal_link"][0] == 'isset') {
                    Yii::$app->session->setFlash('error_link_isset', $page_text['error_link_isset']);

                }
            }
        }
        // Одобренные невыплаченные комиссии.
        $user_id = Yii::$app->user->identity->getId();

        $unpaid_amount_model = new PartnerUnpaidAmount();
        $unpaid_amount_model = $unpaid_amount_model->getPartnerUnpaidAmount($user_id);
        if ($unpaid_amount_model) {
            $unpaid_amount = $unpaid_amount_model->amount;
        } else {
            $unpaid_amount = 0;
        }


        $model = new PartnerPaymentsList();

        $data = $model->getAllDataForOnePartner($user_id);

        $countQuery = clone $data;
        $pages = new Pagination([
            'totalCount' => $countQuery->count(),
            'pageSize' => 5,
            'defaultPageSize' => 5,
            'pageParam' => 'page',
            'forcePageParam' => false,
        ]);
        $data = $data->offset($pages->offset)->limit($pages->limit)->all();
        if ($model->load(Yii::$app->request->post())) {
            // Проверка суммы для вывода
            if ($unpaid_amount < $model->amoun) {
                Yii::$app->session->setFlash('error_amount', $page_text['amount_error']);
                return $this->render('personal-area-payments', [
                    'page_text' => $page_text,
                    'unpaid_amount' => $unpaid_amount,
                ]);
            }


            // $wallet_id , $amount , $user_id
            $save = $model->addRecord($model->wallet_id, $model->amoun, Yii::$app->user->identity->getId());

            if ($save === true) {
                Yii::$app->session->setFlash('success_amount', $page_text['modal_success']);
            } else {
                Yii::$app->session->setFlash('error_amount', $page_text['modal_error']);
            }

        }


        return $this->render('personal-area-payments', [
            'page_text' => $page_text,
            'unpaid_amount' => $unpaid_amount,
            'data' => $data,
            'pages' => $pages,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionPersonalAreaPromotionalMaterials()
    {
// текста для страницы
        $page_text = $this->getText();


        // Форма в хедере с ссылкой
        if (isset(Yii::$app->request->post()["PartnerReferalLinks"])) {
            $model = new PartnerReferalLinks();
            if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                if ($model->save()) {
                    Yii::$app->session->setFlash('success_link_save', $page_text['success_link_save']);
                }
            } else {
                if (isset($model->getErrors()["referal_link"][0]) && $model->getErrors()["referal_link"][0] == 'isset') {
                    Yii::$app->session->setFlash('error_link_isset', $page_text['error_link_isset']);

                }
            }
        }

        // Достаем все категории баннеров и разбиваем их по ключам (для табов) вместе со всеми включенными баннерами
        $all_cat_tab = PartnerPromotionalCategory::getAllCategory();
        $all_cat_with_banners = PartnerPromotionalCategory::getAllCategoryWithBanner();
        // Язык
        $lang = substr(Yii::$app->language, 0, 2);
        $model = new PartnerReferalLinks();
        $link = $model->getPartnerLastLink(Yii::$app->user->identity->getId());




        return $this->render('personal-area-promotional-materials', [
            'page_text' => $page_text,
            'all_cat_tab' => $all_cat_tab,
            'all_cat_with_banners' => $all_cat_with_banners,
            'lang' => $lang,
            'link' => $link,
        ]);
    }

    protected
    function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


}