<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;
/**
 * This is the model class for table "category".
 *
 * @property integer $id
 * @property string $name
 * @property integer $status
 * @property integer $position
 * @property string $url
 * @property string $img
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'status', 'position', 'url'], 'required'],
            [['status', 'position'], 'integer'],
            [['name', 'url','img'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'status' => 'Status',
            'position' => 'Position',
            'url' => 'Url',
            'img' => 'img',
        ];
    }
    public static function getAllCategory()
    {
        return ArrayHelper::map(self::find()->all(), 'id', 'name');
    }

    public function getAll_services()
    {
        return $this->hasMany(Services::className(),['category_id' => 'id'])->where(['status' => 1]);
    }

    public function Categories_with_services($url)
    {
        return  $this::find()->where(['status' => 1, 'url' => $url])->with('all_services')->one();
    }

    public static function getCategories()
    {
        return Category::find()->where(['status' => 1])->orderBy(['position' => SORT_ASC])->asArray()->all();
    }

    public function getAllServicesForCategory($url)
    {
        $id = Category::gerCategoryId($url);
        return  Services::find()->where(['status' => 1, 'category_id' => $id])->orderBy(['id' => SORT_DESC]);

    }

    public static function gerCategoryId($url){
        $data =  Category::find()->where(['url' => $url])->one();
        if ($data){
            return $data['id'];
        }
    }
}
