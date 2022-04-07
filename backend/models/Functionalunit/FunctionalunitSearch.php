<?php

namespace backend\models\Functionalunit;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Functionalunit;
use yii;

/**
 * FunctionalunitSearch represents the model behind the search form of `common\models\Functionalunit`.
 */
class FunctionalunitSearch extends Functionalunit
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['unit_id', 'services_id', 'region_id', 'is_disabled', 'pstc_id', 'hrdc_id'], 'integer'],
            [['unit_name', 'url', 'date_created'], 'safe'],
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
        $query = Functionalunit::find()->where(['region_id' => Yii::$app->user->identity->region_id])->andWhere(['is_disabled' => 0]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'unit_id' => $this->unit_id,
            'services_id' => $this->services_id,
            'region_id' => $this->region_id,
            'date_created' => $this->date_created,
            'is_disabled' => $this->is_disabled,
            'pstc_id' => $this->pstc_id,
            'hrdc_id' => $this->hrdc_id,
        ]);

        $query->andFilterWhere(['like', 'unit_name', $this->unit_name])
            ->andFilterWhere(['like', 'unit_url', $this->unit_url]);

        return $dataProvider;
    }
}
