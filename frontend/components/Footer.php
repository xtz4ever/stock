<?php
namespace app\components;

use common\models\Category;
use frontend\components\LangUrlManager;
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

        // Категории
        $category = Category::getCategories();

        return $this->render('footer',[
            'category'=>$category,
            'lang_url' => LangUrlManager::getUrlLink(),
        ]);
    }
}