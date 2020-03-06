<?php
namespace app\components;

use common\models\Category;
use common\models\Translates;
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
        $translates = Translates::find()->where(['page' => 'header', 'lang' => LangUrlManager::getLang()])->all();

        return $this->render('footer',[
            'category'=>$category,
            'translates' => $translates,
            'lang_url' => LangUrlManager::getUrlLink(),
        ]);
    }
}