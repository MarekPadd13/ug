<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PrivateOlympic;

/**
 * PrivateOlympicSearch represents the model behind the search form of `app\models\PrivateOlympic`.
 */
class PrivateOlympicSearch extends PrivateOlympic
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'remote_olympic_id'], 'integer'],
            [['name', 'date', 'address'], 'safe'],
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
        $query = PrivateOlympic::find();

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
            'remote_olympic_id' => $this->remote_olympic_id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'date', $this->date])
            ->andFilterWhere(['like', 'address', $this->address]);

        return $dataProvider;
    }
}
