<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\RefMembers;

/**
 * ProfilesSearch represents the model behind the search form of `app\models\Profiles`.
 */
class RefMembersSearch extends RefMembers
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['doljnost_id', 'count'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = RefMembers::find();

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
            'doljnost_id' => $this->doljnost_id,
            'count' => $this->count,
        ]);

        $query->andFilterWhere(['like', 'doljnost_id', $this->doljnost_id])
            ->andFilterWhere(['like', 'count', $this->count]);
        return $dataProvider;
    }
}
