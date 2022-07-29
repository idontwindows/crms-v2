<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\TmpRating;

/**
 * SearchTmpRating represents the model behind the search form of `backend\models\TmpRating`.
 */
class SearchTmpRating extends TmpRating
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'vsatisfied', 'five', 'satisfied', 'four', 'neither', 'three', 'dissatisfied', 'two', 'vdissatisfied', 'one', 'total_score'], 'integer'],
            [['attribute'], 'safe'],
            [['ss', 'gap'], 'number'],
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
        $query = TmpRating::find();

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
            'vsatisfied' => $this->vsatisfied,
            '5' => $this->five,
            'satisfied' => $this->satisfied,
            '4' => $this->four,
            'neither' => $this->neither,
            '3' => $this->three,
            'dissatisfied' => $this->dissatisfied,
            '2' => $this->two,
            'vdissatisfied' => $this->vdissatisfied,
            '1' => $this->one,
            'total_score' => $this->total_score,
            'ss' => $this->ss,
            'gap' => $this->gap,
        ]);

        $query->andFilterWhere(['like', 'attribute', $this->attribute]);

        return $dataProvider;
    }
}
