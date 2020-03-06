<?php
namespace frontend\components;

use yii\web\UrlManager;
use frontend\models\Lang;
use Yii;

class LangUrlManager extends UrlManager
{
    public function createUrl($params)
    {
        if( isset($params['lang_id']) ){
            //Если указан идентификатор языка, то делаем попытку найти язык в БД,
            //иначе работаем с языком по умолчанию
            $lang = Lang::findOne($params['lang_id']);
            if( $lang === null ){
                $lang = Lang::getDefaultLang();
            }
            unset($params['lang_id']);
        } else {
            //Если не указан параметр языка, то работаем с текущим языком
            $lang = Lang::getCurrent();
        }

        //Получаем сформированный URL(без префикса идентификатора языка)
        $url = parent::createUrl($params);

        //Добавляем к URL префикс - буквенный идентификатор языка
        if( $url == '/' ){
            return '/'.$lang->url;
        }else{
            return '/'.$lang->url.$url;
        }
    }

    public static function getUrlLink(){
        $lang = substr(Yii::$app->language, 0, 2);
        if ($lang == 'ru') {
            $lang_url = '';
        } else {
            $lang_url = '/'.$lang;
        }
        return $lang_url;
    }
    public static function getLang(){
        return substr(Yii::$app->language, 0, 2);
    }
}