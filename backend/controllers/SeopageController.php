<?php

namespace backend\controllers;

use common\models\ProviderAccountType;
use phpDocumentor\Reflection\DocBlock\Tags\Var_;
use Yii;
use common\models\SeoPage;
use common\models\SeoPageSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use common\models\Lang;
/**
 * SeopageController implements the CRUD actions for SeoPage model .
 */
class SeopageController extends BackAppController
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
     * Lists all SeoPage models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SeoPageSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SeoPage model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        $model=$this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('kv-detail-success', 'Saved record successfully');

            return $this->redirect(['view', 'id'=>$model->id]);
        } else {
            return $this->render('view', ['model'=>$model]);
        }
    }

    /**
     * Creates a new SeoPage model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SeoPage();
        $langs = Lang::getAllLangs();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'langs' => $langs,
            ]);
        }
    }

    /**
     * Updates an existing SeoPage model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($page_name)
    {
        $model = $this->findModels($page_name);
        $langs = Lang::getAllLangs();

        if (Yii::$app->request->post()){

            $post = Yii::$app->request->post();
            $page_name = $post['page_name'];

            foreach (Yii::$app->request->post() as $key => $array){
                if (is_array($array)){
                    foreach ($array as $lang_key => $value){
                        SeoPage::updateRecord($page_name, $lang_key, $key, $value);
                    }
                }
            }
            return $this->redirect('/bureyko/seopage');
        }else {

            $result = [];
            foreach ($model as $k => $v) {
                $result[$v->lang] = $v;
            }


            return $this->render('update', [
                'model' => $result,
                'langs' => $langs,
                'page_name' => $page_name,
            ]);
        }
        /*if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }*/
    }

    /**
     * Deletes an existing SeoPage model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id = null)
    {

        $post = Yii::$app->request->post();


        if (Yii::$app->request->isAjax && isset($post['custom_param'])) {

            $id = $post['id'];
            $this->findModel($id)->delete();
        } else {
            $this->findModel($id)->delete();
            return $this->redirect(['index']);
        }


        return $this->redirect('/bureyko/seopage');

    }
    /**
     * Finds the SeoPage model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SeoPage the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SeoPage::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    protected function findModels($page_name)
    {
        if (($model = SeoPage::find()->where(['page_name' => $page_name])->all() ) !== null) {

            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}