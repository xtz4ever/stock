<?php

namespace common\models;

/**
 * This is the model class for table "event".
 *
 * @property integer $id
 * @property integer $parent_id
 * @property string $imgs
 * @property integer $status
 */
class Event extends \yii\db\ActiveRecord
{
    public $file;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'event';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['file'], 'file', 'maxFiles' => 6],
            [[/*'parent_id',*/ 'imgs'/*, 'status'*/], 'required'],
            [['parent_id', 'status'], 'integer'],
            [['imgs'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent_id' => 'Parent ID',
            'imgs' => 'Imgs',
            'status' => 'Status',
            'file' => 'Картинки',
        ];
    }

    public function getAllImage($url)
    {
        $parent_id = Services::find()->where(['url' => $url])->one();

        $images = $this::find()->where(['parent_id' => $parent_id->id])->one();

        $images = explode('**', trim($images->imgs));

        return $images;
    }

    public function ParrentId($url)
    {
        $parent_id = Services::find()->where(['url' => $url])->one();

        return $parent_id->id;
    }


}
