<?php
namespace app\components;
use common\models\Category;
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


        return $this->render('header',[
            'text' => $text,
            'category' => $category,
            'phone' => $phone,
        ]);
    }
}