<?php

namespace backend\controllers;

use Yii;
use common\models\Category;
use common\models\CategorySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use common\models\SeoPage;
/**
 * CategoryController implements the CRUD actions for Category model.
 */
class CategoryController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Category models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CategorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Category model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Category model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Category();
        $model_seo = new SeoPage();
        if ($model->load(Yii::$app->request->post()) && $model_seo->load(Yii::$app->request->post()) ) {

            $img = UploadedFile::getInstance($model, 'img');

            if ($img !== null){
                $model->img = $img->name;
                $img->saveAs(Yii::getAlias('@frontend/web') . '/img/' . $model->img);
            }else{
                $model->img = 'error.jpg';
            }

            $model->save();

            $model_seo->page_name = $model->url;
            $model_seo->save();
            
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'model_seo' => $model_seo,
            ]);
        }
    }

    /**
     * Updates an existing Category model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $model_seo = new SeoPage();
        $model_seo = $model_seo->findModel(mb_strtolower($model->url));



        $saved_img = $model["img"];
        if ($model->load(Yii::$app->request->post()) && $model_seo->load(Yii::$app->request->post()) ) {

            $img = UploadedFile::getInstance($model, 'img');

            if ($img === null) {
                $model->img = $saved_img;
            } else {
                $model->img = $img->name;
                $img->saveAs(Yii::getAlias('@frontend/web') . '/img/' . $model->img);

            }
            $model_seo->page_name = $model->url;
            if ($model->validate() && $model->save() && $model_seo->save() ) {
                return $this->redirect('/bureyko/category');
            }

            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'model_seo' => $model_seo
            ]);
        }
    }

    public function actionActivate($id)
    {
        $model = $this->findModel($id);

        $model['status'] = 1;
        $model->save();

        return $this->redirect(['index']);
    }

    public function actionDeactivate($id)
    {
        $model = $this->findModel($id);

        $model['status'] = 0;
        $model->save();

        return $this->redirect(['index']);
    }

    /**
     * Deletes an existing Category model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */


    public function actionDelete($id = null)
    {
        $post = Yii::$app->request->post();

        if (Yii::$app->request->isAjax && isset($post['custom_param'])) {

            $id = $post['id'];
            $model_seo = new SeoPage();
            $model_seo = $model_seo->findModel(mb_strtolower($this->findModel($id)->url));
            $this->findModel($id)->delete();
            $model_seo->delete();

        } else {

            $model_seo = new SeoPage();
            $model_seo = $model_seo->findModel(mb_strtolower($this->findModel($id)->url));
            $this->findModel($id)->delete();
            $model_seo->delete();
            return $this->redirect(['index']);
        }


        return $this->redirect('/bureyko/category');

    }

    /**
     * Finds the Category model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Category the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Category::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
