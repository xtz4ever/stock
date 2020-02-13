<?php
namespace app\components;

use common\models\Category;
use yii\base\Widget;
use frontend\models\Lang;



class Footer extends Widget
{
    public function init()
    {
        parent::init();

    }

    public function run()
    {


        $lang = Lang::getCurrent()->url;
        // Категории
        $category =Category::getCategories();

        return $this->render('footer',[
            'category'=>$category
        ]);
    }
}