<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\DictFaculty;

/**
 * HomeImageSearch represents the model behind the search form of `app\models\HomeImage`.
 */
class HomeImageSearch extends HomeImage
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'angle_id','home_id','status'], 'integer'],
            [['link','date'], 'safe'],
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
        $query = HomeImage::find();

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
            'angle_id' => $this->angle_id,
            'home_id' => $this->home_id,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'link', $this->link]);
        $query->andFilterWhere(['like', 'date', $this->date]);

        return $dataProvider;
    }
}
