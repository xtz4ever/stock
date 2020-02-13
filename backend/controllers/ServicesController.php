<?php

namespace backend\controllers;

use common\models\Event;
use Yii;
use common\models\Services;
use common\models\ServicesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use common\models\SeoPage;
/**
 * ServicesController implements the CRUD actions for Services model.
 */
class ServicesController extends Controller
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
     * Lists all Services models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ServicesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Services model.
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
     * Creates a new Services model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Services();
        $model_seo = new SeoPage();
        $model_event = new Event();
        if ($model->load(Yii::$app->request->post())  && $model_seo->load(Yii::$app->request->post())&& $model_event->load(Yii::$app->request->post())) {

            $img = UploadedFile::getInstance($model, 'img');

            if ($img !== null){
                $model->img = $img->name;
                $img->saveAs(Yii::getAlias('@frontend/web') . '/img/services/' . $model->img);
            }else{
                $model->img = 'error.jpg';
            }
            $model->save();

            $model_event->parent_id = $model->id;

            mkdir(Yii::getAlias('@frontend/web/img/event/') . $model_event->parent_id,0755, true);
            $model_event->file = UploadedFile::getInstances($model_event, 'file');
            foreach ($model_event->file as $key => $file) {

                $file->saveAs(Yii::getAlias('@frontend/web/img/event/') . $model_event->parent_id.'/'. $file->baseName . '.' . $file->extension);//Upload files to server
                $model_event->imgs .= 'event/' . $model_event->parent_id.'/'. $file->baseName . '.' . $file->extension.'**';//Save file names in database- '**' is for separating images
            }

            $model_event->status = 1;
            $model_event->save();

            $model_seo->page_name = $model->url;
            $model_seo->save();
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'model_seo' => $model_seo,
                'model_event' => $model_event,
            ]);
        }
    }

    /**
     * Updates an existing Services model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model_event = $this->findEventModel($id);
        $saved_imgs = $model_event["imgs"];
        $model_seo = new SeoPage();
        $model_seo = $model_seo->findModel(mb_strtolower($model->url));
        $saved_img = $model["img"];
        if ($model->load(Yii::$app->request->post()) && $model_seo->load(Yii::$app->request->post()) && $model_event->load(Yii::$app->request->post())) {

            $img = UploadedFile::getInstance($model, 'img');

            if ($img === null) {
                $model->img = $saved_img;
            } else {
                $model->img = $img->name;
                $img->saveAs(Yii::getAlias('@frontend/web') . '/img/services/' . $model->img);

            }

            $model_event->file = UploadedFile::getInstances($model_event, 'file');

            if (count($model_event->file) != 0) {
                $model_event->imgs = '';
                foreach ($model_event->file as $key => $file) {
                    $file->saveAs(Yii::getAlias('@frontend/web/img/event/') . $model_event->parent_id . '/' . $file->baseName . '.' . $file->extension);//Upload files to server
                    $model_event->imgs .= 'event/' . $model_event->parent_id . '/' . $file->baseName . '.' . $file->extension . '**';//Save file names in database- '**' is for separating images
                }
            }else{
                $model_event->imgs = $saved_imgs;
            }
            $model_event->status = 1;

            $model_seo->page_name = $model->url;
            if ($model->validate() && $model->save() && $model_seo->save() && $model_event->save()) {

                return $this->redirect('/bureyko/services');
            }



            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'model_seo' => $model_seo,
                'model_event' => $model_event,
            ]);
        }
    }

    /**
     * Deletes an existing Services model.
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
     * Finds the Services model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Services the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Services::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findEventModel($id)
    {
        if (($model = Event::find()->where(['parent_id'=>$id])->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
