<?php

namespace frontend\controllers;

use common\models\AccProduct;
use common\models\ListOfPurchasedAccounts;
use common\models\ProviderAccountType;
use common\models\ProviderPersonalOrder;
use common\models\UserWallets;
use Yii;
use common\models\Wallets;
use common\models\LoginForm;
use common\models\Newprovider;
use common\models\ProviderAccountsForActivationRequired;
use yii\web\UploadedFile;
use common\models\SaveFile;
use common\models\ProviderCheckoutGoods;
use yii\data\Pagination;
use frontend\models\PasswordResetRequestForm;
use common\models\User;
use common\models\ProviderListOfPayments;

/**
 * App controller
 */
class SellerController extends AppController
{

    public $layout = 'seller';

    public function beforeAction($action)
    {
        /* H1, description, SEO */
        $this->PageInfo(Yii::$app->controller->action->id);
        if (Yii::$app->user->isGuest === true) {
            if (Yii::$app->controller->action->id == 'login-provider' || Yii::$app->controller->action->id == 'new-provider' || Yii::$app->controller->action->id == 'reset-password-provider') {
                return true;
            } else {
                return $this->redirect('login-provider', 302)->send();
            }
        } else {
            return true;
        }
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLoginProvider()
    {
//        if (!Yii::$app->user->isGuest) {
//            return $this->actionProfileProvider();
//        }

        // Все слова и предложения в зависимости от страницы
        $page_text = $this->getText();

        $model = new LoginForm();
        if ($errors = $this->performAjaxValidation($model)) {
            return $errors;
        }


        if ($model->load(Yii::$app->request->post()) && $model->loginProvider()) {
//            return $this->goBackSeller();
            return $this->redirect('profile-provider');

        } else {

            return $this->render('login-provider', [
                'model' => $model,
                'page_text' => $page_text,
            ]);

        }

    }


    public function actionNewProvider()
    {
        $model = new Newprovider();
        $page_text = $this->getText();
        $model->scenario = Newprovider::SCENARIO_REGISTER;
//        $model->name = Yii::$app->request->post()["Newprovider"]['username'];
        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->save()) {

            $name = Yii::$app->request->post()["Newprovider"]['name'];
            $email = Yii::$app->request->post()["Newprovider"]['email'];
            $text = Yii::$app->request->post()["Newprovider"]['text'];
            $model->sendMailSeller('new_seller_for_admin', $name, $email, $text);


            return $this->goHome();

        } else {
            return $this->render('new-provider', [
                'model' => $model,
                'page_text' => $page_text,
            ]);
        }

    }

    public function actionProfileProvider()
    {

        // Все слова и предложения в зависимости от страницы
        $page_text = $this->getText();


        $model = new Newprovider();
        $model->scenario = Newprovider::SCENARIO_UPDATE_PROVIDER;


//        if ($model->load(Yii::$app->request->post())){
//            var_dump($_POST);
//            exit();
//        }

        if (isset(Yii::$app->request->post()["Newprovider"])) {
            if ($model->load(Yii::$app->request->post())) {
                $error = 0;


                // Сохраняем кошелек если добавили новый
                if ($model->wallets != '') {
                    $wallet = new Wallets();
                    $new_wallet = $wallet->saveUserWallet($model->wallets, $model->provider_id, $model->wallet_number, 'provider');
                    if ($new_wallet === false) {
                        $error = 1;
                    }
                }
                // обновляем данные по пользователю
                $user = $this->findModel($model->provider_id);


                if ($model->password != '') {
                    $user->password_hash = Yii::$app->security->generatePasswordHash($model->password);
                }
                $user->username = $model->username;
                $user->email = $model->email;
                $user->skype_icq = $model->skype_icq;


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

        $provider_info = new User();
        $provider_info = $provider_info->findByProvider(\Yii::$app->user->identity->username);


        $model_wallets = new Wallets();
        $model_wallets->scenario = Wallets::SCENARIO_USER_ADD_WALLET;
        $wallets = $model_wallets->getWalletsLang('for_seller');

        $model_2 = new UserWallets();
        $user_wallets = $model_2->getAllProviderWallets(Yii::$app->user->identity->id);

        if ($errors = $this->performAjaxValidation($model)) {
            return $errors;
        }
        if ($errors = $this->performAjaxValidation($model_wallets)) {
            return $errors;
        }


        return $this->render('profile-provider', [
            'model' => $model,
            'wallets' => $wallets,
            'user_wallets' => $user_wallets,
            'page_text' => $page_text,
            'provider_info' => $provider_info,
        ]);
    }

    public function actionPersonalProvider()
    {


        // Трубуются аккаунты для активации
        $model = new ProviderAccountsForActivationRequired();
        $allQuerys = $model->getAllRequestOrders();

        // Все слова и предложения в зависимости от страницы
        $page_text = $this->getText();

        $orders = new ProviderPersonalOrder();
        $ordera = $orders->getAllProviderOrders(Yii::$app->user->id);

        // Возвраты на замену
        $all_returns_orders = $orders->getAllReturnsOrders(Yii::$app->user->id);


        // Подсчитываю общую сумму не выплаченных денег за все аккаунты одного продавца
        $UnpaidOrdersTotal = $orders->getUnpaidOrdersTotal(Yii::$app->user->id);

        // Подсчитываю общую сумму выплаченных денег за все аккаунты одного продавца
        $PaidOrdersTotal = $orders->getPaidOrdersTotal(Yii::$app->user->id);

        $model = new ProviderPersonalOrder();


        // Достаю ордера в зависимости от запроса
        if ($model->load(Yii::$app->request->post())) {
            $ordera = $orders->getAllProviderOrders(Yii::$app->user->id, $model->status, $model->show_on_page);
            $show_on_page = $model->show_on_page;
        } elseif (Yii::$app->request->get('per-page')) {
            $ordera = $orders->getAllProviderOrders(Yii::$app->user->id, $model->status, Yii::$app->request->get('per-page'));
            $show_on_page = Yii::$app->request->get('per-page');
        } else {
            $show_on_page = 10;
        }

        // Пагинация
        $pages = new Pagination(['totalCount' => $ordera->count(), 'pageSize' => $show_on_page]);
        // приводим параметры в ссылке к ЧПУ
//        $pages->pageSizeParam = false;
        $ordera = $ordera->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        return $this->render('personal-provider', [
            'allQuerys' => $allQuerys,
            'all_returns_orders' => $all_returns_orders,
            'page_text' => $page_text,
            'ordera' => $ordera,
            'model' => $model,
            'show_on_page' => $show_on_page,
            'pages' => $pages,
            'UnpaidOrdersTotal' => $UnpaidOrdersTotal,
            'PaidOrdersTotal' => $PaidOrdersTotal,
        ]);
    }

    public function actionTakeorderProvider($id)
    {

        $model = new ProviderAccountsForActivationRequired();
        $model = $model->getOneTakeOrder($id);
        $lang = $this->lang;
        if ($lang == 'ru'){
            $product_name = $model["providerAccountType"]->account_name;
        }else{
            $product_name = $model["providerAccountType"]->account_name_en;
        }
        if ($model) {
            $model->scenario = ProviderAccountsForActivationRequired::SCENARIO_TAKE_ORDER;

            if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                $new_order = new ProviderPersonalOrder();
                $new_order->NewOrder(Yii::$app->controller->action->id, Yii::$app->request->post("ProviderAccountsForActivationRequired"));

                Yii::$app->session->setFlash('success', 'Заявка принята');
                return $this->redirect('personal-provider');
            } else {

                $page_text = $this->getText();
                $model_2 = new UserWallets();
                $user_wallets = $model_2->getAllProviderWallets(Yii::$app->user->identity->id);

                return $this->render('takeorder-provider', [
                    'model' => $model,
                    'user_wallets' => $user_wallets,
                    'page_text' => $page_text,
                    'product_name' => $product_name,

                ]);
            }
        } else {
            return $this->redirect('personal-provider');
        }
    }


    public function actionSuggestProvider()
    {
        $model = new ProviderAccountsForActivationRequired();


        $model->scenario = ProviderAccountsForActivationRequired::SCENARIO_SUGGEST_ORDER;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

//            $this->varD($_POST);exit();


            $new_order = new ProviderPersonalOrder();
            $case = Yii::$app->controller->action->id;
            $order = Yii::$app->request->post("ProviderAccountsForActivationRequired");
            $new_order->NewOrder($case, $order);

            Yii::$app->session->setFlash('success', 'Заявка принята');
            return $this->redirect('personal-provider');
        } else {

            $page_text = $this->getText();

            $model_2 = new UserWallets();
            $user_wallets = $model_2->getAllProviderWallets(Yii::$app->user->identity->id);
            return $this->render('suggest-provider', [
                'model' => $model,
                'user_wallets' => $user_wallets,
                'page_text' => $page_text,
            ]);
        }
    }

    public function actionUploadAccount($id)
    {


        $model = new ProviderPersonalOrder();
        $upload = $model->UploadAccount($id);
        $page_text = $this->getText();

        if ($model->load(Yii::$app->request->post())) {


            $modelFile = new SaveFile();

            $file = UploadedFile::getInstance($model, 'file');

            if ($file){
                /*Метод для проверки данных из загруженного файла. Возвращает массив проверенных аккаунтов*/
                $uploaded_file = $modelFile->getValidateAccounts($file, $model->verification_code, (int)$model->quntity);
            }




            if ($uploaded_file == 'error') {
                return $this->render('upload-account', [
                    'upload' => $upload,
                    'model' => $model,
                    'page_text' => $page_text,
                ]);
            } else {

                $model_checkout_goods = new ProviderCheckoutGoods();

                // goods , product_id , order_id
                $model_checkout_goods->SaveAll($uploaded_file, $model->product_id, $id);

                $model->sendMail('upload-account', $id);


                // Изменяю статусы в ордере
                $upload["status"] = 2; //Ждет активации;
                $upload["action"] = 1; //поменять кошелек для выплат и удалить оставшиеся
                $upload["it_was_accounts"] = count($uploaded_file);
                $upload["left_accounts"] = count($uploaded_file);
                $upload["paid_status"] = 0; // статус оплаты не оплачен.
                $upload["file"] = 'not'; // Используется в правилах requared , здесь не нужен.
                $upload->save();




                return $this->redirect('/personal-provider');
            }

        }

        return $this->render('upload-account', [
            'upload' => $upload,
            'model' => $model,
            'page_text' => $page_text,
        ]);
    }

    public function actionViewAccounts($id)
    {
//        $model = new ProviderPersonalOrder();
//        $order = $model->FindOneOrder($id);
        $model = new ListOfPurchasedAccounts();
        $order = $model->getAccountForReturn($id);
        $page_text = $this->getText();

        return $this->render('view-accounts', [
            'order' => $order,
            'page_text' => $page_text,
        ]);
    }
    public function actionViewOrder($id)
    {
//        $model = new ProviderPersonalOrder();
//        $order = $model->FindOneOrder($id);
        $model = new ProviderPersonalOrder();
        $order = $model->FindOneOrder($id);

        // достаем id заявки на возврат, что бы можно было увидеть забаненные акки
        $order_id_for_return = new ListOfPurchasedAccounts();
        $order_id_for_return = $order_id_for_return->getOrderIdForReturn($id);

        // текст
        $page_text = $this->getText();

        return $this->render('view-order', [
            'order' => $order,
            'page_text' => $page_text,
            'order_id_for_return' => $order_id_for_return,
        ]);
    }

    public function actionCheckFormat()
    {


        $model = new ProviderAccountType();
        return $model->getAccountType(Yii::$app->request->post('account_id'));
    }

    public function actionOrderDelete($id = null)
    {
        $model = new ProviderPersonalOrder();
        $order = $model->FindOneOrder($id);

        if ($order !== null) {
            $order->delete();
            return $this->redirect('/personal-provider');
        }

        return $this->redirect('/personal-provider');


    }


    public
    function actionResetPasswordProvider()
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

        return $this->render('reset-password-provider', [
            'model' => $model,
            'page_text' => $page_text,
        ]);
    }


    public
    function actionDelleteWalletProvider($id)
    {
        $model = new UserWallets();

        $model = $model->getOneWallet($id);

        if ($model->delete()) {
            return $this->redirect('/profile-provider');
        }


    }


    public function actionPersonalProviderPayments()
    {

        // Все слова и предложения в зависимости от страницы
        $page_text = $this->getText();

        // Язык
        $lang = $this->lang;

        $model = new ProviderListOfPayments();

        if ($model->load(Yii::$app->request->post())) {
//            $this->varD($model->product_id);exit();
            // что бы выборка работала правильно к конечной дате добавляю 1 день
            $date_end = date('Y-m-d', strtotime($model->date_end) + 1 * 24 * 3600);
            $statistic = $model->getPartnerStatisticForThePeriod($model->provider_id, $model->date_start, $date_end,$model->product_id);

            // привожу дату к нужному формату
            $date_start = date('d.m.Y', strtotime($model->date_start));
            $date_end = date('d.m.Y', strtotime($model->date_end));

        } else {

            // по умолчанию выборка идет за текущий день
//            $date_start = date('Y-m-d');
            $date_start = date('Y-m-d');
            $date_end = date('Y-m-d');

            // что бы выборка работала правильно к конечной дате добавляю 1 день
            $date_end_plus_1 = date('Y-m-d', strtotime($date_end) + 1 * 24 * 3600);
            $statistic = $model->getPartnerStatisticForThePeriod(Yii::$app->user->identity->getId(), $date_start, $date_end_plus_1);

        }

        $payment_statistic = new ProviderListOfPayments();
        $payment_statistic_pagination = $payment_statistic->getStatisticForPayment(Yii::$app->user->id);
        // Пагинация
        $pages = new Pagination(['totalCount' => $payment_statistic_pagination->count(), 'pageSize' => 10]);
        // приводим параметры в ссылке к ЧПУ
//        $pages->pageSizeParam = false;
        $statistic = $payment_statistic_pagination->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        return $this->render('personal-provider-payments', [
            'model' => $model,
            'page_text' => $page_text,
            'statistic' => $statistic,
            'lang' => $lang,
            'pages' => $pages,

        ]);
    }

    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}