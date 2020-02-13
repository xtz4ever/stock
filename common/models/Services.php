<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;
/**
 * This is the model class for table "services".
 *
 * @property integer $id
 * @property integer $category_id
 * @property string $name
 * @property string $text
 * @property string $price
 * @property string $time_to_work
 * @property string $url
 * @property string $img
 * @property integer $status
 */
class Services extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'services';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'name',    'status'], 'required'],
            [['category_id', 'status'], 'integer'],
            [['text','img'], 'string'],
            [['name', 'price', 'time_to_work', 'url'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Категория услуг',
            'name' => 'Название услуги',
            'text' => 'Text',
            'price' => 'Цена ( примерная )',
            'time_to_work' => 'Время на выполнение ( примерное )',
            'url' => 'Url',
            'status' => 'Статус',
            'img' => 'img',
        ];
    }

    public static function getAllServices()
    {
        return ArrayHelper::map(self::find()->all(), 'id', 'name');
    }
    public static function getServicesInfo($id){
        return Services::find()->where(['id' => $id])->one();
    }
}
