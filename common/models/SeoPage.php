<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "seo_page".
 *
 * @property integer $id
 * @property string $page_name
 * @property string $seo_title_ru
 * @property string $seo_description_ru
 * @property string $seo_keywords_ru
 * @property string $seo_image_alt_ru
 * @property string $seo_image_title_ru
 * @property string $description_ru
 * @property string $h1_ru
 * @property string $seo_title_en
 * @property string $seo_description_en
 * @property string $seo_keywords_en
 * @property string $seo_image_alt_en
 * @property string $seo_image_title_en
 * @property string $description_en
 * @property string $h1_en
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
            [['page_name', 'seo_title_ru'], 'required'],
            [['seo_description_ru', 'description_ru', 'h1_ru', 'seo_description_en', 'description_en', 'h1_en'], 'string'],
            [['page_name'], 'string', 'max' => 100],
            [['seo_title_ru', 'seo_keywords_ru', 'seo_image_alt_ru', 'seo_image_title_ru', 'seo_title_en', 'seo_keywords_en', 'seo_image_alt_en', 'seo_image_title_en'], 'string', 'max' => 255],
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
            'seo_title_ru' => 'Title ',
            'seo_description_ru' => 'Description ',
            'seo_keywords_ru' => 'Keywords',
            'seo_image_alt_ru' => 'Seo Image Alt',
            'seo_image_title_ru' => 'Seo Image Title',
            'description_ru' => 'Текст на странице',
            'h1_ru' => 'H1',
            'seo_title_en' => 'Seo Title En',
            'seo_description_en' => 'Seo Description En',
            'seo_keywords_en' => 'Seo Keywords En',
            'seo_image_alt_en' => 'Seo Image Alt En',
            'seo_image_title_en' => 'Seo Image Title En',
            'description_en' => 'Текст на странице En',
            'h1_en' => 'H1 En',
        ];
    }

    /*Мета теги + H1 + Текст для страниц*/
    public function getSeo($page)
    {

//        if (isset($_GET["url"]) && !empty($_GET["url"])) {
//            $page = $_GET["url"];
//        }


        $page = SeoPage::find()->where(['page_name' => $page])->one();



        if ($page) {

            $seo_title = $page->seo_title_ru;
            $seo_description = $page->seo_description_ru;
            $seo_keywords = $page->seo_keywords_ru;
            $h1 = $page->h1_ru;
            $description = $page->description_ru;

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
}
