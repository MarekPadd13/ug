<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\DictChairmans;

/**
 * DictChairmansSearch represents the model behind the search form of `app\models\DictChairmans`.
 */
class DictChairmansSearch extends DictChairmans
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'first_name', 'patronymic'], 'integer'],
            [['last_name', 'position'], 'safe'],
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
        $query = DictChairmans::find();

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
            'first_name' => $this->first_name,
            'patronymic' => $this->patronymic,
        ]);

        $query->andFilterWhere(['like', 'last_name', $this->last_name])
            ->andFilterWhere(['like', 'position', $this->position]);

        return $dataProvider;
    }
}
