<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\RefAnswer;

/**
 * RefAnswerSearch represents the model behind the search form of `app\models\RefAnswer`.
 */
class RefAnswerSearch extends RefAnswer
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'legasy_status', 'type', 'ref_problems_id', 'author_id'], 'integer'],
            [['name', 'content', 'date_start', 'date_finish'], 'safe'],
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
        $query = RefAnswer::find();

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
            'legasy_status' => $this->legasy_status,
            'type' => $this->type,
            'ref_problems_id' => $this->ref_problems_id,
            'date_start' => $this->date_start,
            'date_finish' => $this->date_finish,
            'author_id' => $this->author_id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'content', $this->content]);

        return $dataProvider;
    }
}
