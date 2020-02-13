<?php

namespace common\models;

use Yii;
use himiklab\yii2\recaptcha\ReCaptchaValidator;

/**
 * This is the model class for table "feedbacs".
 *
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $date
 * @property string $message

 * @property integer $status
 */
class Feedbacs extends \yii\db\ActiveRecord
{

    public $verifyCode;



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'feedbacs';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'email', 'message', 'status'], 'required'],
            [['date'], 'safe'],
            [['message'], 'string'],
            [['status'], 'integer'],
            [['name', 'email'], 'string', 'max' => 100],
            [['verifyCode'], ReCaptchaValidator::className(), 'secret' => Yii::$app->params['reCaptcha_secret'], 'when' => function($model){ return !$model->getErrors() && !Yii::$app->request->isAjax /* !Yii::$app->request->post('ajax')*/; },]


        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Имя',
            'email' => 'Эл. адрес:',
            'date' => 'Date',
            'message' => 'Сообщение',
            'status' => 'Status',

            'verifyCode' => ''
        ];
    }


    public function getAllFedbacks()
    {

      return  $this::find()->where(['status' => 1])->orderBy(['id' => SORT_DESC]);

    }
    public function getAllFedbacksForEvent($parent_id)
    {

        return  $this::find()->where(['status' => 1,'work_id' => $parent_id])->orderBy(['id' => SORT_DESC]);

    }

    public static function getNewFeedbacs(){
        $new = Feedbacs::find()->where(['status' => 0])->asArray()->all();

        if ($new){
            return count($new);
        }else{
            return 0;
        }
    }

    public static function updateStatus($id,$status){
        $connection = Yii::$app->getDb();
        $command = $connection->createCommand("UPDATE `feedbacs` SET `status`= :status  WHERE id = :id", [':status' => (int)$status,':id' => (int)$id]);
        $command->query();
    }
}
