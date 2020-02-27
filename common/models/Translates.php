<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "translates".
 *
 * @property int $id
 * @property string $page
 * @property string $text_key
 * @property string $text_value
 * @property string $lang
 */
class Translates extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'translates';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['page', 'text_key', 'text_value', 'lang'], 'required'],
            [['page', 'text_key', 'text_value'], 'string', 'max' => 50],
            [['lang'], 'string', 'max' => 3],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'page' => 'Page',
            'text_key' => 'Text Key',
            'text_value' => 'Text Value',
            'lang' => 'Lang',
        ];
    }

    /**
     * {@inheritdoc}
     * @return TranslatesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TranslatesQuery(get_called_class());
    }
}
