<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "our_works".
 *
 * @property integer $id
 * @property string $car_before
 * @property string $car_after
 * @property string $text
 * @property integer $status
 * @property integer $position
 */
class OurWorks extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'our_works';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[  'status', 'position'], 'required'],
            [['text'], 'string'],
            [['status', 'position'], 'integer'],
            [['car_before', 'car_after'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'car_before' => 'Car Before',
            'car_after' => 'Car After',
            'text' => 'Текст ( например что было сделано в этой машине )',
            'status' => 'Статус',
            'position' => 'Позиция',
        ];
    }

    public static function getAllOUrWorks()
    {

        return  OurWorks::find()->where(['status' => 1])->orderBy(['id' => SORT_DESC])->asArray()->all();

    }
}
