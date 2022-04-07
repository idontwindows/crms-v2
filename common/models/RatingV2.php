<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tbl_rating_v2".
 *
 * @property int $rating_id
 * @property int|null $customer_id
 * @property int|null $unit_id
 * @property int|null $question_group_id
 * @property int|null $question_id
 * @property int|null $rating_point
 * @property int|null $drivers_id
 * @property string|null $rating_date
 */
class RatingV2 extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_rating_v2';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['customer_id', 'unit_id', 'question_group_id', 'question_id', 'rating_point', 'drivers_id'], 'integer'],
            [['rating_date'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'rating_id' => 'Rating ID',
            'customer_id' => 'Customer ID',
            'unit_id' => 'Unit ID',
            'question_group_id' => 'Question Group ID',
            'question_id' => 'Question ID',
            'rating_point' => 'Rating Point',
            'drivers_id' => 'Drivers ID',
            'rating_date' => 'Rating Date',
        ];
    }
}
