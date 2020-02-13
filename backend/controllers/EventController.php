<?php

namespace backend\controllers;

use Yii;
use common\models\Event;
use common\models\EventSearch;
use common\models\SeoPage;
use common\models\Services;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
/**
 * EventController implements the CRUD actions for Event model.
 */
class EventController extends Controller
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
     * Lists all Event models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EventSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Event model.
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
     * Creates a new Event model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Event();
        $model_seo = new SeoPage();
        if ($model->load(Yii::$app->request->post()) ) {

            mkdir(Yii::getAlias('@frontend/web/img/event/') . $model->parent_id,0755, true);



            $model->file = UploadedFile::getInstances($model, 'file');
            foreach ($model->file as $key => $file) {

                $file->saveAs(Yii::getAlias('@frontend/web/img/event/') . $model->parent_id.'/'. $file->baseName . '.' . $file->extension);//Upload files to server
                $model->imgs .= 'event/' . $model->parent_id.'/'. $file->baseName . '.' . $file->extension.'**';//Save file names in database- '**' is for separating images
            }

            $model->save();

            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'model_seo' => $model_seo,
            ]);
        }
    }

    /**
     * Updates an existing Event model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model_seo = $this->findModelSeo($model['parent_id']);
        $saved_img = $model["imgs"];

        if ($model->load(Yii::$app->request->post()) && $model_seo->load(Yii::$app->request->post())) {
            $model->file = UploadedFile::getInstances($model, 'file');

            if (count($model->file) != 0) {
                $model->imgs = '';
                foreach ($model->file as $key => $file) {
                    $file->saveAs(Yii::getAlias('@frontend/web/img/event/') . $model->parent_id . '/' . $file->baseName . '.' . $file->extension);//Upload files to server
                    $model->imgs .= 'event/' . $model->parent_id . '/' . $file->baseName . '.' . $file->extension . '**';//Save file names in database- '**' is for separating images
                }
            }else{
                $model->imgs = $saved_img;
            }


            if ($model->validate() && $model->save() && $model_seo->save()) {
                return $this->redirect('/bureyko/event');
            }


        } else {
            return $this->render('update', [
                'model' => $model,
                'model_seo' => $model_seo,
            ]);
        }
    }

    /**
     * Deletes an existing Event model.
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


        return $this->redirect('/bureyko/services');

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
     * Finds the Event model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Event the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Event::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    protected function findModelSeo($id)
    {
        $data = Services::getServicesInfo($id);
        if ($data){
            $url = $data['url'];
        }


        if (($model = SeoPage::find()->where(['page_name'=>$url])->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

