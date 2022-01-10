<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tbl_nps_rating".
 *
 * @property int $nps_rating_id
 * @property int|null $score
 * @property int|null $customer_id
 * @property int|null $unit_id
 * @property string|null $rating_date
 */
class NpsRating extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_nps_rating';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['score', 'customer_id', 'unit_id'], 'integer'],
            [['rating_date'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'nps_rating_id' => 'Nps Rating ID',
            'score' => 'Score',
            'customer_id' => 'Customer ID',
            'unit_id' => 'Unit ID',
            'rating_date' => 'Rating Date',
        ];
    }
}
