<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[Translates]].
 *
 * @see Translates
 */
class TranslatesQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Translates[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Translates|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
