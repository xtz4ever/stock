<?php
namespace frontend\controllers;

use common\models\AccCategory;
use common\models\Category;
use common\models\SeoPage;
use common\models\AccProduct;
use yii\web\Controller;
use yii\db\Query;
use Yii;



class SitemapController extends AppController {

    public function actionIndex() {

        // проверяем есть ли закэшированная версия sitemap
        $urls = array(); // Выбираем категории сайта
//        $categories = Category::getCategories();
//
//
//
//        foreach ($categories as $category) {
//
//          $url = Yii::$app->urlManager->createUrl(['service-'.$category['url']]);
//          $url = explode('/', $url);
//
//
//            $urls[] = array( '/'.$url[2] // создаем ссылки на выбранные категории
//            , 'daily' ); }



        // Записи Блога
        /* $urls = array(); // Выбираем категории сайта
         $pages = StaticPages::find()->all();
         foreach ($pages as $page) {
             $urls[] = array( Yii::$app->urlManager->createUrl([ $page->page]) // создаем ссылки на выбранные категории
             , 'daily' ); }*/



        /*$products = (new Query()) ->select('title_en as title_en')
            ->from('product as b')
            ->all();

        foreach ($products as $post) {
            $post['title_en'] = str_replace(" ", "_",$post['title_en'] );
            $urls[] = array( Yii::$app->urlManager->createUrl([ 'buyakkaynt/' .$post['title_en'] ])  , 'weekly' );
        }*/ // строим ссылки на записи блога

        $pages = (new Query()) ->select('page_name as page')
            ->from('seo_page as b')
            ->all();

        foreach ($pages as $post) {
            $url = Yii::$app->urlManager->createUrl([$post['page']]);
            $url = explode('/', $url);


            $urls[] = array( '/'.$url[2] // создаем ссылки на выбранные категории
            , 'daily' );
//            $urls[] = array( Yii::$app->urlManager->createUrl([ $post['page'] ])  , 'weekly' );
        } // строим ссылки на записи блога

        $xml_sitemap = $this->renderPartial('index', array( // записываем view на переменную для последующего кэширования
            'host' => Yii::$app->request->hostInfo, // текущий домен сайта
            'urls' => $urls, // с генерированные ссылки для sitemap
        ));

        Yii::$app->cache->set('sitemap', $xml_sitemap, 3600*12); // кэшируем результат, чтобы не нагружать сервер и не выполнять код при каждом запросе карты сайта.


        Yii::$app->response->format = \yii\web\Response::FORMAT_XML; // устанавливаем формат отдачи контента
        header('Content-Type: application/xml');


        echo $xml_sitemap;
    }
}



