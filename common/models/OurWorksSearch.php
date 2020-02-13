<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\OurWorks;

/**
 * OurWorksSearch represents the model behind the search form about `common\models\OurWorks`.
 */
class OurWorksSearch extends OurWorks
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status', 'position'], 'integer'],
            [['car_before', 'car_after', 'text'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = OurWorks::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
            'position' => $this->position,
        ]);

        $query->andFilterWhere(['like', 'car_before', $this->car_before])
            ->andFilterWhere(['like', 'car_after', $this->car_after])
            ->andFilterWhere(['like', 'text', $this->text]);

        return $dataProvider;
    }
}
