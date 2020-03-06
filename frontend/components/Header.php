<?php
namespace app\components;
use common\models\Category;
use common\models\Translates;
use frontend\components\LangUrlManager;
use Yii;
use yii\base\Widget;
use frontend\controllers\AppController;


class Header extends Widget
{
    public $id;
    public function init()
    {
        parent::init();

    }

    public function run()
    {


      $text =  AppController::PageInfo(Yii::$app->controller->action->id);
        // Категории
        $category =Category::getCategories();
        function isMobile() {

            return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
        }

        if(isMobile()){
            $phone = true;
        }else{
            $phone = false;
        }

        $translates = Translates::find()->where(['page' => 'header', 'lang' => LangUrlManager::getLang()])->all();
        return $this->render('header',[
            'text' => $text,
            'translates' => $translates,
            'category' => $category,
            'phone' => $phone,
            'lang_url' => LangUrlManager::getUrlLink(),
        ]);
    }
}