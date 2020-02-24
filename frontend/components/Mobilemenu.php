<?php
namespace app\components;

use common\models\Category;
use common\models\Contacts;
use yii\base\Widget;
use frontend\models\Lang;



class Mobilemenu extends Widget
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
        $viber = Contacts::getContacts('viber');
        $telephone = Contacts::getContacts('telephone');
        $email = Contacts::getContacts('email');
        $skype = Contacts::getContacts('skype');
        $instagram = Contacts::getContacts('instagram');
        $facebook = Contacts::getContacts('facebook');
        return $this->render('footer',[
            'category'=>$category,
            'viber'=>$viber,
            'telephone'=>$telephone,
            'email'=>$email,
            'skype'=>$skype,
            'instagram'=>$instagram,
            'facebook'=>$facebook,
        ]);
    }
}