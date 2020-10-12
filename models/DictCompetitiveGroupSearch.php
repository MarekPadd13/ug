<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\DictCompetitiveGroup;

/**
 * DictCompetitiveGroupSearch represents the model behind the search form of `app\models\DictCompetitiveGroup`.
 */
class DictCompetitiveGroupSearch extends DictCompetitiveGroup
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'speciality_id', 'specialization_id', 'edu_level', 'education_form_id', 'financing_type_id', 'faculty_id', 'kcp', 'special_right_id', 'passing_score', 'is_new_program', 'only_pay_status'], 'integer'],
            [['competition_count'], 'number'],
            [['link'], 'safe'],
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
        $query = DictCompetitiveGroup::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $dataProvider->pagination = false;

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'speciality_id' => $this->speciality_id,
            'specialization_id' => $this->specialization_id,
            'edu_level' => $this->edu_level,
            'education_form_id' => $this->education_form_id,
            'financing_type_id' => $this->financing_type_id,
            'faculty_id' => $this->faculty_id,
            'kcp' => $this->kcp,
            'special_right_id' => $this->special_right_id,
            'competition_count' => $this->competition_count,
            'passing_score' => $this->passing_score,
            'is_new_program' => $this->is_new_program,
            'only_pay_status' => $this->only_pay_status,
        ]);

        $query->andFilterWhere(['like', 'link', $this->link]);

        return $dataProvider;
    }
}
