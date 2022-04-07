<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tbl_attributes".
 *
 * @property int $question_unit_id
 * @property string|null $question
 * @property int|null $question_group_unit_id
 * @property int|null $unit_id
 * @property int|null $pstc_id
 * @property int|null $dimension_id
 * @property int|null $no_dimension
 */
class Attributes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_attributes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['question_group_unit_id', 'unit_id', 'pstc_id', 'dimension_id', 'no_dimension'], 'integer'],
            [['question'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'question_unit_id' => 'Question Unit ID',
            'question' => 'Attributes',
            'question_group_unit_id' => 'Question Group Unit ID',
            'unit_id' => 'Unit ID',
            'pstc_id' => 'Pstc ID',
            'dimension_id' => 'Dimension ID',
            'no_dimension' => 'No Dimension',
        ];
    }
}
