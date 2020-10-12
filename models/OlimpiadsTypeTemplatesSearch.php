<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\OlimpiadsTypeTemplates;

/**
 * OlimpiadsTypeTemplatesSearch represents the model behind the search form of `app\models\OlimpiadsTypeTemplates`.
 */
class OlimpiadsTypeTemplatesSearch extends OlimpiadsTypeTemplates
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['number_of_tours', 'form_of_passage', 'edu_level_olimp', 'template_id'], 'integer'],
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
        $query = OlimpiadsTypeTemplates::find();

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
            'number_of_tours' => $this->number_of_tours,
            'form_of_passage' => $this->form_of_passage,
            'edu_level_olimp' => $this->edu_level_olimp,
            'template_id' => $this->template_id,
        ]);

        return $dataProvider;
    }
}
