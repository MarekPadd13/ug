<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\DictFaculty;

/**
 * DictHousesSearch represents the model behind the search form of `app\models\DictHouses`.
 */
class DictHousesSearch extends DictHouses
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'moderation', 'flat_count'], 'integer'],
            [['name','deadline'], 'safe'],
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
        $query = DictHouses::find();

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
            'flat_count'=> $this->flat_count,
            'moderation' =>  $this->moderation,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);
        $query->andFilterWhere(['like', 'deadline', $this->deadline]);

        return $dataProvider;
    }
}
