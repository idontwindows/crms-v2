<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tbl_question".
 *
 * @property int $question_id
 * @property string|null $question
 * @property int|null $question_group_id
 *
 * @property TblQuestionGroup $questionGroup
 * @property TblRating[] $tblRatings
 */
class Question extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_question';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['question_group_id'], 'integer'],
            [['question'], 'string', 'max' => 255],
            [['question_group_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuestionGroup::className(), 'targetAttribute' => ['question_group_id' => 'question_group_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'question_id' => 'Question ID',
            'question' => 'Question',
            'question_group_id' => 'Question Group ID',
        ];
    }

    /**
     * Gets query for [[QuestionGroup]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getQuestionGroup()
    {
        return $this->hasOne(QuestionGroup::className(), ['question_group_id' => 'question_group_id']);
    }

    /**
     * Gets query for [[TblRatings]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTblRatings()
    {
        return $this->hasMany(Rating::className(), ['question_id' => 'question_id']);
    }
}
