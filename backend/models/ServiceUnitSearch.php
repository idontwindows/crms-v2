<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ServiceUnit;

/**
 * ServiceUnitSearch represents the model behind the search form of `common\models\ServiceUnit`.
 */
class ServiceUnitSearch extends ServiceUnit
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['service_unit_id', 'services_id', 'is_parent', 'is_child', 'parent_id', 'is_with_pstc'], 'integer'],
            [['service_unit_name'], 'safe'],
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
        $query = ServiceUnit::find()->where(['is_child' => 0]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'service_unit_id' => $this->service_unit_id,
            'services_id' => $this->services_id,
            'is_parent' => $this->is_parent,
            'is_child' => $this->is_child,
            'parent_id' => $this->parent_id,
            'is_with_pstc' => $this->is_with_pstc,
        ]);

        $query->andFilterWhere(['like', 'service_unit_name', $this->service_unit_name]);

        return $dataProvider;
    }
}
