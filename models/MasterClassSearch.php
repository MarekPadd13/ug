<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\MasterClass;

/**
 * MasterClassSearch represents the model behind the search form of `app\models\MasterClass`.
 */
class MasterClassSearch extends MasterClass
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'master_id', 'dod_id'], 'integer'],
            [['name', 'aud_number', 'time_start', 'time_finish'], 'safe'],
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
        $query = MasterClass::find();

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
            'master_id' => $this->master_id,
            'time_start' => $this->time_start,
            'time_finish' => $this->time_finish,
            'dod_id' => $this->dod_id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'aud_number', $this->aud_number]);

        return $dataProvider;
    }
}
