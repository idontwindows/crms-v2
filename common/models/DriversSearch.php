<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Drivers;

/**
 * DriversSearch represents the model behind the search form of `common\models\Drivers`.
 */
class DriversSearch extends Drivers
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['drivers_id', 'region_id'], 'integer'],
            [['drivers_name'], 'safe'],
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
        $query = Drivers::find()->where(['region_id' => Yii::$app->user->identity->region_id]);

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
            'drivers_id' => $this->drivers_id,
        ]);

        $query->andFilterWhere(['like', 'drivers_name', $this->drivers_name]);

        return $dataProvider;
    }
}
