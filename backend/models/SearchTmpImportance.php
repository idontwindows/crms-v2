<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\TmpImportance;

/**
 * SearchTmpRating represents the model behind the search form of `backend\models\TmpRating`.
 */
class SearchTmpImportance extends TmpImportance
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'vimportant', 'five', 'important', 'four', 'moderately', 'three', 'slightly', 'two', 'notall', 'one', 'total_score'], 'integer'],
            [['attribute'], 'safe'],
            [['ss','is','wf','ws'], 'number'],
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
        $query = TmpImportance::find();

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
            'vsatisfied' => $this->vimportant,
            'five' => $this->five,
            'satisfied' => $this->important,
            'four' => $this->four,
            'neither' => $this->moderately,
            'three' => $this->three,
            'dissatisfied' => $this->slightly,
            'two' => $this->two,
            'vdissatisfied' => $this->notall,
            'one' => $this->one,
            'total_score' => $this->total_score,
            'is' => $this->is,
            'wf' => $this->wf,
            'ss' => $this->ss,
            'ws' => $this->ws,
        ]);

        $query->andFilterWhere(['like', 'attribute', $this->attribute]);

        return $dataProvider;
    }
}