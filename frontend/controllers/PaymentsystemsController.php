<?php

namespace frontend\controllers;

use app\components\Header;
use common\models\AccProduct;
use common\models\PartnerPercentForPaiment;
use common\models\PartnerUnpaidAmount;
use common\models\ProviderPersonalOrder;
use common\models\SeoPage;
use function GuzzleHttp\Psr7\str;
use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;

use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use yii\web\Response;
use kartik\form\ActiveForm;
use common\models\AccRightSideBarForCategory;
use common\models\ExchangeRates;
use common\models\AccCategory;
use yii\data\Pagination;
use frontend\models\BuyAccounts;
use common\models\AccountsNotAvailableIndex;
use frontend\widgets\ModalFormWidget;
use common\models\PromoCode;
use common\models\Feedbacs;
use common\models\PartnerReferalLinks;
use common\models\PartnerPersonalAreaStatistic;
use common\models\PartnerReferralBuyers;
use common\models\StockAllOrders;
use common\models\ListOfPurchasedAccounts; // Список аккаунтов каждой покупки
use common\models\CustomerEmails; // Список эл. адресов всех покупателей для рассылки писем при создании нового продукта

use common\models\Test;

/**
 * App controller
 */
class PaymentsystemsController extends AppController
{
    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionQiwiresponse()
    {

//        file_put_contents(__DIR__.'/QIWIWTF.txt' , serialize($_POST));

        $merchant_id = '50665';
        $merchant_secret = '33szbuo9';
        function getIP()
        {
            if (isset($_SERVER['HTTP_X_REAL_IP'])) return $_SERVER['HTTP_X_REAL_IP'];
            return $_SERVER['REMOTE_ADDR'];
        }

        if (!in_array(getIP(), array('136.243.38.147', '136.243.38.149', '136.243.38.150', '136.243.38.151', '136.243.38.189', '88.198.88.98'))) {
            die("hacking attempt!");
        }

        $order_id = $_POST['MERCHANT_ORDER_ID'];
        $order_info = new StockAllOrders();
        $order = $order_info->getOneOrder($order_id);
        if ($order === NULL){
            file_put_contents('logi/qiwi.txt', date('d.m.Y') . ' ордера с таким id ' . $order_id . ' нет в нашей Б.Д. ' . ' ID операции ' . $order_id . "\r\n", FILE_APPEND);

        }
        if ($order->status == 1){
            die("YES");
        }else {
            // меняем статус на оплачено и отправляем запрос на вторую БД за аккаунтами
            $order->status = 1;
            $order->save();

            // Меняем кол-во в наличии у продукта
            $product = new AccProduct();
            $product = $product->getOneProductById($order->product_id);
            $product->quantity -= $order->quantyti;
            $product->save();

            // Курсы всех валют
            $kyrsy_valut = new ExchangeRates();
            $kyrsy_valut = $kyrsy_valut->getKyrs();
            $order_amount = $order['order_amount'] * $kyrsy_valut->usd;
            $order_amount = round($order_amount, 0);


            // меняем статистику партнера если он есть
            if ((int)$order->operation_id != 0) {

                $user_id = (int)$order->operation_id;
                // Получаем процент партнера
                $partner_percent = new PartnerPercentForPaiment();
                $partner_percent = $partner_percent->getPartnerPercent($user_id);
                // процент от суммы покупки, для партнера
                $amount = ($order->order_amount / 100) * $partner_percent;

                // Добавляем сумму к общей сумме партнера
                $partner_unpaid_amount = new PartnerUnpaidAmount();
                $partner_unpaid_amount->UpdatePartnerUnpaidAmount($user_id, $amount);

                // Изменяем статистику
                $partner_statistic = new PartnerPersonalAreaStatistic();
                $partner_statistic->PartnerStatistic($order->operation_id, 'oplachenih', $amount);
            }


            $verification = \Yii::$app->security->generatePasswordHash(Yii::$app->params['passwordHash']);
            if ($curl = curl_init()) {
                curl_setopt($curl, CURLOPT_URL, Yii::$app->params['url_update_product']);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($curl, CURLOPT_HEADER, 1);
                curl_setopt($curl, CURLOPT_POST, 1);
                curl_setopt($curl, CURLOPT_POSTFIELDS, [
                    'product_id' => $order->product_id,
                    'quantyti' => $order->quantyti,
                    'verification' => $verification,
                    'file_name' => $order->file_for_download,
                    'buyers_email' => $order->buyers_email,
                    'subject' => 'order id ' . ' ' . $order->id,
                    'order_id' => $order->id,
                ]);
                curl_setopt($curl, CURLOPT_USERAGENT, 'MSIE 5');
                curl_setopt($curl, CURLOPT_REFERER, "http://ya.ru");
                $out = curl_exec($curl);
                $err = curl_error($curl);
//                file_put_contents(__DIR__ . '/out.txt', $out);
//                file_put_contents(__DIR__ . '/error.txt', $err);
                curl_close($curl);
            }
        }



    }

    public function actionYm()
    {

        $hash = ($_POST['notification_type']
            . '&' .
            $_POST['operation_id']
            . '&' .
            $_POST['amount']
            . '&' .
            $_POST['currency']
            . '&' .
            $_POST['datetime']
            . '&' .
            $_POST['sender']
            . '&' .
            $_POST['codepro']
            . '&' .
            '1Ir4jGMj8/cR0IbE8TicK7dc'
            . '&' .
            $_POST['label']);

        $hash = hash('sha1', $hash);


        // Получаем данные по ордеру
        $order_info = new StockAllOrders();
        $order = $order_info->getOneOrder($_POST['label']);

        if ($order === NULL) {
            file_put_contents('logi/yandex-money.txt', date('d.m.Y') . ' ордера с таким id ' . $_POST['label'] . ' нет в нашей Б.Д. ' . ' ID операции ' . $_POST['operation_id'] . "\r\n", FILE_APPEND);
            die ('ERROR');
            exit();
        }

        // Курсы всех валют
        $kyrsy_valut = new ExchangeRates();
        $kyrsy_valut = $kyrsy_valut->getKyrs();
        $order_amount = $order['order_amount'] * $kyrsy_valut->usd;
        $order_amount = round($order_amount, 0);


        if ($_POST['sha1_hash'] != $hash || $_POST['codepro'] === true || $_POST['unaccepted'] === true) {
            file_put_contents('logi/yandex-money.txt', date('d.m.Y') . ' Платеж не прошел !! ордер id ' . $_POST['label'] . ' ID операции ' . $_POST['operation_id'] . ' сумма ' . $_POST['amount'] . "\r\n", FILE_APPEND);
            die ('ERROR');
            exit();

        } elseif ($order_amount != round($_POST['withdraw_amount'],0)) {
            file_put_contents('logi/yandex-money.txt', date('d.m.Y') . ' Суммы не совпадают !! ордер id ' . $_POST['label'] . ' ID операции ' . $_POST['operation_id'] . ' сумма из Б.Д. ' . $order_amount . ' сумма от яндекса ' . $_POST['amount'] . "\r\n", FILE_APPEND);
            die ('ERROR');
            exit();
        } else {


            $order_id = $_POST['label'];

            // Все слова и предложения в зависимости от страницы
            $page_text = $this->getText();

            if ($order->status == 1) {
                die("OK");
            } else {

                // меняем статус на оплачено и отправляем запрос на вторую БД за аккаунтами
                $order->status = 1;
                $order->save();

                // Меняем кол-во в наличии у продукта
                $product = new AccProduct();
                $product = $product->getOneProductById($order->product_id);
                $product->quantity -= $order->quantyti;
                $product->save();

                // меняем статистику партнера если он есть
                if ((int)$order->operation_id != 0) {

                    $user_id = (int)$order->operation_id;
                    // Получаем процент партнера
                    $partner_percent = new PartnerPercentForPaiment();
                    $partner_percent = $partner_percent->getPartnerPercent($user_id);
                    // процент от суммы покупки, для партнера
                    $amount = ($order->order_amount / 100) * $partner_percent;

                    // Добавляем сумму к общей сумме партнера
                    $partner_unpaid_amount = new PartnerUnpaidAmount();
                    $partner_unpaid_amount->UpdatePartnerUnpaidAmount($user_id, $amount);

                    // Изменяем статистику
                    $partner_statistic = new PartnerPersonalAreaStatistic();
                    $partner_statistic->PartnerStatistic($order->operation_id, 'oplachenih', $amount);
                }


                $verification = \Yii::$app->security->generatePasswordHash(Yii::$app->params['passwordHash']);
                if ($curl = curl_init()) {
                    curl_setopt($curl, CURLOPT_URL, Yii::$app->params['url_update_product']);
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($curl, CURLOPT_HEADER, 1);
                    curl_setopt($curl, CURLOPT_POST, 1);
                    curl_setopt($curl, CURLOPT_POSTFIELDS, [
                        'product_id' => $order->product_id,
                        'quantyti' => $order->quantyti,
                        'verification' => $verification,
                        'file_name' => $order->file_for_download,
                        'buyers_email' => $order->buyers_email,
                        'subject' => 'order id' . ' ' . $order->id,
                        'order_id' => $order->id,
                    ]);
                    curl_setopt($curl, CURLOPT_USERAGENT, 'MSIE 5');
                    curl_setopt($curl, CURLOPT_REFERER, "http://ya.ru");
                    $out = curl_exec($curl);
                    $err = curl_error($curl);
//                    file_put_contents(__DIR__ . '/out.txt', $out);
//                    file_put_contents(__DIR__ . '/error.txt', $err);
                    curl_close($curl);
                }
            }

        }
    }

    public function actionPerfectmoney()
    {

        // Курсы всех валют
        $kyrsy_valut = new ExchangeRates();
        $kyrsy_valut = $kyrsy_valut->getKyrs();

        $kyrs_usd = $kyrsy_valut->usd;
        $kyrs_eur = $kyrsy_valut->eur;


        $secret = strtoupper(md5('Or5nf07M85XlZzefIoTlAqlnI'));
        $hash =
            $_POST['PAYMENT_ID'] . ':' .
            $_POST['PAYEE_ACCOUNT'] . ':' .
            $_POST['PAYMENT_AMOUNT'] . ':' .
            $_POST['PAYMENT_UNITS'] . ':' .
            $_POST['PAYMENT_BATCH_NUM'] . ':' .
            $_POST['PAYER_ACCOUNT'] . ':' .
            $secret . ':' .
            $_POST['TIMESTAMPGMT'];


        $hash = strtoupper(md5($hash));

        if ($hash == $_POST['V2_HASH']) {

            $order_info = new StockAllOrders();
            $order = $order_info->getOneOrder($_POST['PAYMENT_ID']);

            if ($order === NULL) {
                file_put_contents('logi/perfect-money.txt', date('d.m.Y') . ' ордера с таким id ' . $_POST['label'] . ' нет в нашей Б.Д. ' . ' ID операции ' . $_POST['operation_id'] . "\r\n", FILE_APPEND);
                die ('ERROR');
                exit();
            }
            if ($order->payment_system == 'Perfectmoney_USD') {
                $currency = 'USD';
                $amount = $order->order_amount;
            } else {
                $currency = 'EUR';

                $amount = $order->order_amount * ($kyrs_usd / $kyrs_eur);
            }

            if ($_POST['PAYMENT_UNITS'] == $currency && $_POST['PAYMENT_AMOUNT'] == $amount && $order->status != 1) {


                // меняем статус на оплачено и отправляем запрос на вторую БД за аккаунтами
                $order->status = 1;
                $order->save();

                // Меняем кол-во в наличии у продукта
                $product = new AccProduct();
                $product = $product->getOneProductById($order->product_id);
                $product->quantity -= $order->quantyti;
                $product->save();

                // меняем статистику партнера если он есть
                if ((int)$order->operation_id != 0) {

                    $user_id = (int)$order->operation_id;
                    // Получаем процент партнера
                    $partner_percent = new PartnerPercentForPaiment();
                    $partner_percent = $partner_percent->getPartnerPercent($user_id);
                    // процент от суммы покупки, для партнера
                    $amount = ($order->order_amount / 100) * $partner_percent;

                    // Добавляем сумму к общей сумме партнера
                    $partner_unpaid_amount = new PartnerUnpaidAmount();
                    $partner_unpaid_amount->UpdatePartnerUnpaidAmount($user_id, $amount);

                    // Изменяем статистику
                    $partner_statistic = new PartnerPersonalAreaStatistic();
                    $partner_statistic->PartnerStatistic($order->operation_id, 'oplachenih', $amount);
                }


                $verification = \Yii::$app->security->generatePasswordHash(Yii::$app->params['passwordHash']);
                if ($curl = curl_init()) {
                    curl_setopt($curl, CURLOPT_URL, Yii::$app->params['url_update_product']);
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($curl, CURLOPT_HEADER, 1);
                    curl_setopt($curl, CURLOPT_POST, 1);
                    curl_setopt($curl, CURLOPT_POSTFIELDS, [
                        'product_id' => $order->product_id,
                        'quantyti' => $order->quantyti,
                        'verification' => $verification,
                        'file_name' => $order->file_for_download,
                        'buyers_email' => $order->buyers_email,
                        'subject' => 'order id' . ' ' . $order->id,
                        'order_id' => $order->id,
                    ]);
                    curl_setopt($curl, CURLOPT_USERAGENT, 'MSIE 5');
                    curl_setopt($curl, CURLOPT_REFERER, "http://ya.ru");
                    $out = curl_exec($curl);
                    $err = curl_error($curl);
//                    file_put_contents(__DIR__ . '/out.txt', $out);
//                    file_put_contents(__DIR__ . '/error.txt', $err);
                    curl_close($curl);
                }
            }
        }
    }

    public function actionWebmoney(){

        file_put_contents(__DIR__.'/AAA.txt', serialize($_POST));

        // Получаем данные по ордеру
        $order_info = new StockAllOrders();
        $order = $order_info->getOneOrder($_POST['order_id']);

        // Курсы всех валют
        $kyrsy_valut = new ExchangeRates();
        $kyrsy_valut = $kyrsy_valut->getKyrs();
        $order_amount = $order['order_amount'] * $kyrsy_valut->usd;
        $order_amount = round($order_amount, 0);

        // меняем статус на оплачено и отправляем запрос на вторую БД за аккаунтами
        $order->status = 1;
        $order->save();

        // Меняем кол-во в наличии у продукта
        $product = new AccProduct();
        $product = $product->getOneProductById($order->product_id);
        $product->quantity -= $order->quantyti;
        $product->save();

        // меняем статистику партнера если он есть
        if ((int)$order->operation_id != 0) {

            $user_id = (int)$order->operation_id;
            // Получаем процент партнера
            $partner_percent = new PartnerPercentForPaiment();
            $partner_percent = $partner_percent->getPartnerPercent($user_id);
            // процент от суммы покупки, для партнера
            $amount = ($order->order_amount / 100) * $partner_percent;

            // Добавляем сумму к общей сумме партнера
            $partner_unpaid_amount = new PartnerUnpaidAmount();
            $partner_unpaid_amount->UpdatePartnerUnpaidAmount($user_id, $amount);

            // Изменяем статистику
            $partner_statistic = new PartnerPersonalAreaStatistic();
            $partner_statistic->PartnerStatistic($order->operation_id, 'oplachenih', $amount);
        }

    }

    public function actionAdvcashsuccess(){
      file_put_contents(__DIR__.'/ADVcash_success.txt', serialize($_POST));
    }
    public function actionAdvcasherror(){
        file_put_contents(__DIR__.'/ADVcash_error.txt', serialize($_POST));
    }

}