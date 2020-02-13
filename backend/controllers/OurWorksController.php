<?php

namespace backend\controllers;

use Yii;
use common\models\OurWorks;
use common\models\OurWorksSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
/**
 * OurWorksController implements the CRUD actions for OurWorks model.
 */
class OurWorksController extends Controller
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
     * Lists all OurWorks models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OurWorksSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single OurWorks model.
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
     * Creates a new OurWorks model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new OurWorks();

        if ($model->load(Yii::$app->request->post()) ) {
            $image_main = UploadedFile::getInstance($model, 'car_before');

            if ($image_main !== null){
                $model->car_before = $image_main->name;
                $image_main->saveAs(Yii::getAlias('@frontend/web') . '/img/our_works/' . $model->car_before);
            }else{
                $model->car_before = 'error.jpg';
            }



            $image_side_bar = UploadedFile::getInstance($model, 'car_after');

            if ($image_side_bar !== null){
                $model->car_after = $image_side_bar->name;
                $image_side_bar->saveAs(Yii::getAlias('@frontend/web') . '/img/our_works/' . $model->car_after);
            }else{
                $model->car_after = 'error.jpg';
            }

            $model->save();

            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing OurWorks model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $saved_car_before = $model["car_before"];
        $saved_car_after = $model["car_after"];


        if ($model->load(Yii::$app->request->post())) {

            $car_before = UploadedFile::getInstance($model, 'car_before');
            $car_after = UploadedFile::getInstance($model, 'car_after');

            if ($car_before === null) {
                $model->car_before = $saved_car_before;
            } else {
                $model->car_before = $car_before->name;
                $car_before->saveAs(Yii::getAlias('@frontend/web') . '/img/our_works/' . $model->car_before);

            }

            if ($car_after === null) {
                $model->car_after = $saved_car_after;
            } else {
                $model->car_after = $car_after->name;
                $car_after->saveAs(Yii::getAlias('@frontend/web') . '/img/our_works/' . $model->car_after);
            }
            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing OurWorks model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
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
     * Finds the OurWorks model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return OurWorks the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = OurWorks::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
