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
class SiteController extends AppController
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

        $category = Category::getCategories();
        /* H1, description */

        
        $page_info = SeoPage::getSeo(Yii::$app->controller->action->id);
       
        return $this->render('index',
            [
                'category' => $category,
                'pageInfo' => $page_info,

            ]);
    }

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->isPartner()) {
            if ($model->login()) {
                Yii::$app->session->removeFlash('error', 'У вас нет прав для доступа!');
                return $this->goBack();
            }
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }



    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            if ($model->sendEmail(Yii::$app->params['stockEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        } else {
            $page = $this->PageInfo(Yii::$app->controller->action->id);
            $this->getView()->title = $page["seo_title"];
            return $this->render('contact', [
                'model' => $model,
                'page' => $page
            ]);
        }
    }

    public function actionCreatecontacts()
    {

        $model = new ContactForm();
        $lang = $this->lang;

        // Все слова и предложения в зависимости от страницы
        $page_text = $this->getText();

        /* H1, description */
        
        $page_info = SeoPage::getSeo(Yii::$app->controller->action->id);
        $contacts_telephone = Contacts::getContacts('telephone');
        $contacts_viber = Contacts::getContacts('viber');
        $contacts_faceboock = Contacts::getContacts('facebook');
        $contacts_instagram = Contacts::getContacts('instagram');

        if ($model->load(\Yii::$app->request->post()) /*&& $model->validate()*/ && $model->save()) {


            ContactForm::sendEmailMy('Createcontacts', $model->name, $model->email, '', '', $model->subject, $model->telephone);
            Yii::$app->session->setFlash('success', '');

            $model = new ContactForm();
        }
        return $this->render('createcontacts',
            [
                'model' => $model,
                'pageInfo' => $page_info,
                'lang' => $lang,
                'page_text' => $page_text,
                'contacts_telephone' => $contacts_telephone,
                'contacts_viber' => $contacts_viber,
                'contacts_faceboock' => $contacts_faceboock,
                'contacts_instagram' => $contacts_instagram,
            ]);
    }


    public function actionAbout()
    {

        return $this->render('about');
    }

    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success-new-password', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    public function actionResetPassword($token)
    {

        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
// Все слова и предложения в зависимости от страницы
        $page_text = $this->getText();
        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
            'page_text' => $page_text,
        ]);
    }

    public function actionFeedbacks()
    {
        /* H1, description */
        
        $page_info = SeoPage::getSeo(Yii::$app->controller->action->id);

        $model = new Feedbacs();
        $lang = $this->lang;
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

    public function actionFaq()
    {

        /* H1, description */

        echo "<pre>";
        var_dump('AAA');
        echo "</pre>";
        die();
        $page_info = SeoPage::getSeo(Yii::$app->controller->action->id);

        $all_questions = Faq::getAllQuestions();
        return $this->render('faq', [
            'faq_list' => $all_questions,
            'pageInfo' => $page_info,

        ]);

    }

    public function actionOurWorks()
    {

        $our_works = OurWorks::getAllOUrWorks();


        // Все слова и предложения в зависимости от страницы
        $page_text = $this->getText();

        /* H1, description */
        
        $page_info = SeoPage::getSeo(Yii::$app->controller->action->id);


        return $this->render('our-works',
            [
                'our_works' => $our_works,
                'pageInfo' => $page_info,
//                'page' => $page,
                'page_text' => $page_text,
            ]);


    }

    public function actionService($url)
    {
        $url = 'service-'.$url;

        /* H1, description */
        
        $page_info = SeoPage::getSeo($url);

        // Категории с продуктами и ценами
        $category = new Category();


//        $category = $category->Categories_with_services($url);

        $category = $category->getAllServicesForCategory($url);


        $countQuery = clone $category;
        $page = new Pagination([
            'totalCount' => $countQuery->count(),
            'pageSize' => 6,
            'defaultPageSize' => 6,
            'pageParam' => 'page',
            'forcePageParam' => false,
        ]);
        $category = $category->offset($page->offset)->limit($page->limit)->all();

        // Все слова и предложения в зависимости от страницы
        $page_text = $this->getText();

        if ($category !== null) {
            return $this->render('service',
                [
                    'pageInfo' => $page_info,
                    'category' => $category,
                    'page' => $page,
                ]);
        } else {
            throw new \yii\web\HttpException(404, 'Страница не найдена');
        }
    }

    public function actionServices()
    {
        /* H1, description */
        
        $page_info = SeoPage::getSeo(Yii::$app->controller->action->id);

        // Категории с продуктами и ценами
        $category = new Category();


        $category = $category->getCategories();
        if ($category !== null) {
            return $this->render('services',
                [
                    'pageInfo' => $page_info,
                    'category' => $category,
                ]);
        } else {
            throw new \yii\web\HttpException(404, 'Страница не найдена');
        }
    }


    public function actionEvent($url){

        $url = 'event-'.$url;
//        $this->layout='site';
        /* H1, description */
        
        $page_info = SeoPage::getSeo($url);



        $model = new Event();
        $images = $model->getAllImage($url);

        $parent_id = $model->ParrentId($url);


        $model = new Feedbacs();
        $lang = $this->lang;
        $feedbacks = $model->getAllFedbacksForEvent($parent_id);
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

            ContactForm::sendEmailMy('Feedbacs', $model->name, $model->email);
            Yii::$app->session->setFlash('success', '');
            $model = new Feedbacs();
        }
        return $this->render('event',
            [
                'model' => $model,
                'fedbacks' => $feedbacks,
                'pageInfo' => $page_info,
                'lang' => $lang,
                'page' => $page,
                'page_text' => $page_text,
                'images' => $images,
                'parent_id' => $parent_id,
            ]);



    }
    public function actionTest(){
       return $this->render('test');

    }
}