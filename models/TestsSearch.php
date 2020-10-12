<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Tests;

/**
 * TestsSearch represents the model behind the search form of `app\models\Tests`.
 */
class TestsSearch extends Tests
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'number_of_attempts', 'olympic_id', 'class'], 'integer'],
            [['name', 'date_of_start', 'date_of_finish', 'timer'], 'safe'],
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
        $query = Tests::find();

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
            'date_of_start' => $this->date_of_start,
            'date_of_finish' => $this->date_of_finish,
            'number_of_attempts' => $this->number_of_attempts,
            'timer' => $this->timer,
            'olympic_id' => $this->olympic_id,
            'class' => $this->class,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
