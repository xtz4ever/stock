<?php

namespace frontend\controllers;

use frontend\models\Lang;
use Yii;
use yii\web\Controller;
use common\models\SeoPage;
use yii\web\Response;
use yii\widgets\ActiveForm;
use frontend\models\LangTextForSite;
use common\models\Translates;
/**
 * App controller
 */
class AppController extends Controller
{

    public function NEWbehaviors()
    {
        return [
            [
                'class' => 'yii\filters\PageCache',
                'only' => ['index'],
                'duration' => 60,
                'variations' => [
                    \Yii::$app->language,
                ],
//                'dependency' => [
//                    'class' => 'yii\caching\DbDependency',
//                    'sql' => 'SELECT COUNT(*) FROM post',
//                ],
            ],
        ];
    }

    public $translates = [];
    public $lang = '';



    public function beforeAction($action)
    {

        if ($action->id == 'service'){
            $url = $action->id.'-'.$_GET["url"];
        }elseif ($action->id == 'event'){
            $url = $action->id.'-'.$_GET["url"];
        }else{
            $url = Yii::$app->controller->id;
        }

        $page_info = SeoPage::getSeo($url);
        $this->getView()->title = $page_info['seo_title'];


        /* Регистрация метатегов для страницы*/
        Yii::$app->view->registerMetaTag([
            'name' => 'title',
            'content' => $page_info['seo_title']
        ]);
        Yii::$app->view->registerMetaTag([
            'name' => 'description',
            'content' => $page_info['seo_description']
        ]);
        Yii::$app->view->registerMetaTag([
            'name' => 'keywords',
            'content' => $page_info['keywords']
        ]);

        $this->translates = Translates::getTranslate(Yii::$app->controller->id);
        $this->lang = Lang::getCurrent()->url;
        return parent::beforeAction($action, ['page_info' => $page_info]);
    }

    public function PageInfo()
    {

        $page_info = SeoPage::getSeo(Yii::$app->controller->action->id);
        if ($page_info) {

//            $this->getView()->title = $page_info['seo_title'];
            return $page_info;
        } else {
            $this->getView()->title = Yii::$app->controller->action->id;
        }
    }

    protected function performAjaxValidation($model)
    {
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = 'json'; /*Response::FORMAT_JSON*/
            return ActiveForm::validate($model);
        }
    }

    public function getCountry()
    {
        $geo = file_get_contents('http://api.sypexgeo.net/json/' . $_SERVER['REMOTE_ADDR']);
        $geo = json_decode($geo);
        return $geo->country->name_en;
    }

    public function createUniqueFileName()
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $name = '';
        for ($i = 0; $i <= 24; $i++) {
            $name .= $characters[mt_rand(0, strlen($characters) - 1)];
        }
        return $name . '.txt';
    }


    public function getText()
    {
        return LangTextForSite::actionTEXT(Yii::$app->controller->action->id);
    }


    public function isMobile()
    {

        return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
    }

}