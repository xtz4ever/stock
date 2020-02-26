<?php

namespace backend\models;

use frontend\models\Lang;
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
            [['message', 'lang'], 'string'],
            [['status'], 'integer'],
            [['name', 'email'], 'string', 'max' => 100],


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
            'lang' => 'Язык',
        ];
    }

    public static function getNewFeedbacs(){
        $new = Feedbacs::find()->where(['status' => 0])->asArray()->all();

        if ($new){
            return count($new);
        }else{
            return 0;
        }
    }


}
