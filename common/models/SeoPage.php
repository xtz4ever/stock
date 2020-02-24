<?php

namespace common\models;

use frontend\models\Lang;
use Yii;

/**
 * This is the model class for table "seo_page".
 *
 * @property integer $id
 * @property string $page_name
 * @property string $seo_title
 * @property string $seo_description
 * @property string $seo_keywords
 * @property string $description
 * @property string $h1
 */
class SeoPage extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'seo_page';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['page_name', 'seo_title'], 'required'],
            [['seo_description', 'description', 'h1', 'lang'], 'string'],
            [['page_name'], 'string', 'max' => 100],
            [['seo_title', 'seo_keywords'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'page_name' => 'Название Страницы',
            'seo_title' => 'Title ',
            'seo_description' => 'Description ',
            'seo_keywords' => 'Keywords',
            'description' => 'Текст на странице',
            'h1' => 'H1',
            'lang' => 'Язык',
        ];
    }

    /*Мета теги + H1 + Текст для страниц*/
    public function getSeo($page)
    {
        $page = SeoPage::find()->where(['page_name' => $page, 'lang' => Lang::getCurrent()->url])->one();

        if ($page) {

            $seo_title = $page->seo_title;
            $seo_description = $page->seo_description;
            $seo_keywords = $page->seo_keywords;
            $h1 = $page->h1;
            $description = $page->description;

        } else {

            $seo_title = Yii::$app->controller->action->id;
            $h1 = '';
            $seo_description = '';
            $seo_keywords = '';
            $description = '';

        }

        /* Регистрация метатегов для страницы*/
//        Yii::$app->view->registerMetaTag([
//            'name' => 'description',
//            'content' => $seo_description
//        ]);
//        Yii::$app->view->registerMetaTag([
//            'name' => 'keywords',
//            'content' => $seo_keywords
//        ]);
//        Yii::$app->view->registerMetaTag([
//            'name' => 'title',
//            'content' => $seo_title
//        ]);

        return ['seo_title' => $seo_title, 'h1' => $h1, 'description' => $description, 'keywords' => $seo_keywords, 'seo_description' => $seo_description];
    }

    public function findModel($url)
    {
        if (($model = SeoPage::findOne(['page_name' => $url])) !== null) {
            return $model;
        } else {
           return null;
        }
    }

    public static function updateRecord($page,$lang,$column, $value){

        \Yii::$app->db->createCommand("UPDATE `seo_page` SET $column='".$value."' WHERE page_name=:page_name AND lang=:lang ")
            ->bindValue(':page_name', $page)
            ->bindValue(':lang', $lang)
            ->execute();
    }
}
