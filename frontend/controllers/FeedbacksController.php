<?php

namespace frontend\controllers;

use app\components\Header;
use common\models\AccProduct;
use common\models\Category;
use common\models\Contacts;
use common\models\Event;
use common\models\Faq;
use common\models\FaqSuppliers;
use common\models\OurWorks;
use common\models\PartnerPercentForPaiment;
use common\models\PartnerUnpaidAmount;
use common\models\ProviderPersonalOrder;
use common\models\SeoPage;
use common\models\User;

use Yii;
use yii\base\InvalidParamException;
use yii\helpers\Url;
use yii\web\BadRequestHttpException;

use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use common\models\ContactForm;
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
use common\models\CustomerEmails; // Список эл. адресов всех покупателей для рассылки писем при создании нового продукта sd

use common\models\Test;

/**
 * Site controller
 */
class FeedbacksController extends AppController
{
    function SiteController()
    {
        parent::AppController();
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],

            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
            'httpCache' => [
                'class' => 'yii\filters\HttpCache',
                'sessionCacheLimiter' => 'public',
                'cacheControlHeader' => 'public, max-age=604800',
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function beforeAction($action)
    {
        if (in_array($action->id, ['response', 'about', 'promo'])) {
            $this->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
    }


    public function actionIndex()
    {
        /* H1, description */
        $page = new SeoPage();
        $page_info = $page->getSeo(Yii::$app->controller->id);

        $model = new Feedbacs();
        $lang = substr(Yii::$app->language, 0, 2);
        $feedbacks = $model->getAllFedbacks($lang);


        $countQuery = clone $feedbacks;
        $page = new Pagination([
            'totalCount' => $countQuery->count(),
            'pageSize' => 1,
            'defaultPageSize' => 1,
            'pageParam' => 'page',
            'forcePageParam' => false,
        ]);
        $feedbacks = $feedbacks->offset($page->offset)->limit($page->limit)->all();

        // Все слова и предложения в зависимости от страницы
        $page_text = $this->getText();



        if ($model->load(\Yii::$app->request->post()) && $model->save()) {

            ContactForm::sendEmailMy('Feedbacs', $model->name, $model->email,'', '', $model->message);

            Yii::$app->session->setFlash('success','');
            $model = new Feedbacs();
        }
        return $this->render('feedbacks',
            [
                'model' => $model,
                'fedbacks' => $feedbacks,
                'pageInfo' => $page_info,
                'lang' => $lang,
                'page' => $page,
                'page_text' => $page_text,
            ]);
    }

}