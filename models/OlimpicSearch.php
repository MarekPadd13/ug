<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Olimpic;

/**
 * OlimpicSearch represents the model behind the search form of `app\models\Olimpic`.
 */
class OlimpicSearch extends Olimpic
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'chairman_id', 'number_of_tours', 'form_of_passage', 'edu_level_olymp', 'showing_works_and_appeal'], 'integer'],
            [['name', 'date_time_start_reg', 'date_time_finish_reg', 'time_of_distants_tour', 'date_time_start_tour', 'address', 'time_of_tour', 'requiment_to_work_of_distance_tour', 'requiment_to_work', 'criteria_for_evaluating_dt', 'criteria_for_evaluating'], 'safe'],
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
        $query = Olimpic::find();

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
            'chairman_id' => $this->chairman_id,
            'number_of_tours' => $this->number_of_tours,
            'form_of_passage' => $this->form_of_passage,
            'edu_level_olymp' => $this->edu_level_olymp,
            'date_time_start_reg' => $this->date_time_start_reg,
            'date_time_finish_reg' => $this->date_time_finish_reg,
            'time_of_distants_tour' => $this->time_of_distants_tour,
            'date_time_start_tour' => $this->date_time_start_tour,
            'time_of_tour' => $this->time_of_tour,
            'showing_works_and_appeal' => $this->showing_works_and_appeal,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'requiment_to_work_of_distance_tour', $this->requiment_to_work_of_distance_tour])
            ->andFilterWhere(['like', 'requiment_to_work', $this->requiment_to_work])
            ->andFilterWhere(['like', 'criteria_for_evaluating_dt', $this->criteria_for_evaluating_dt])
            ->andFilterWhere(['like', 'criteria_for_evaluating', $this->criteria_for_evaluating]);

        return $dataProvider;
    }
}
