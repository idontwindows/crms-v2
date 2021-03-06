<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tbl_question_unit".
 *
 * @property int $question_unit_id
 * @property string|null $question
 * @property int|null $question_group_unit_id
 * @property int|null $pstc_id
 * @property int|null $dimension_id
 */
class QuestionUnit extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_question_unit';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['question_group_unit_id', 'pstc_id', 'dimension_id'], 'integer'],
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
            'question' => 'Question',
            'question_group_unit_id' => 'Question Group Unit ID',
            'pstc_id' => 'Pstc ID',
            'dimension_id' => 'Dimension ID',
        ];
    }
}
