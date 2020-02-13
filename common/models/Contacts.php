<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "contacts".
 *
 * @property integer $id
 * @property string $contact_type
 * @property string $text
 * @property integer $status
 */
class Contacts extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'contacts';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['contact_type', 'text', 'status'], 'required'],
            [['status'], 'integer'],
            [['contact_type', 'text'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'contact_type' => 'Contact Type',
            'text' => 'Text',
            'status' => 'Status',
        ];
    }

    public function getAllContactsType(){
        return  $contacts_systems = [
            'viber' => 'Viber',
            'telephone' => 'Телефон',
            'instagram' => 'Instagram',
            'facebook' => 'Facebook',
//            'twitter' => 'Twitter',

        ];
    }

    public static function getContacts($type){
      $request = Contacts::find()->where(['status' => 1])->andWhere(['contact_type' => $type])->asArray()->all();
      if ($request){
          return $request;
      }
    }


}
