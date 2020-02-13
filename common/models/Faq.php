<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "faq".
 *
 * @property integer $id
 * @property string $question
 * @property string $answer
 * @property integer $status
 * @property integer $position
 */
class Faq extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'faq';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['question', 'answer', 'status', 'position'], 'required'],
            [['question', 'answer'], 'string'],
            [['status', 'position'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'question' => 'Вопрос',
            'answer' => 'Ответ',
            'status' => 'Статус',
            'position' => 'Позиция',
        ];
    }

    public static function getAllQuestions(){
        return Faq::find()->where(['status' => 1])->orderBy(['position' => SORT_ASC])->asArray()->all();
    }
}
