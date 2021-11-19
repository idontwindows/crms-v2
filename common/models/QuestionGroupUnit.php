<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tbl_question_group".
 *
 * @property int $question_group_id
 * @property string|null $question_group_name
 * @property int|null $event_id
 *
 * @property TblEvent $event
 * @property TblQuestion[] $tblQuestions
 * @property TblRating[] $tblRatings
 */
class QuestionGroupUnit extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_question_group_unit';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['unit_id'], 'integer'],
            [['question_group_unit_name'], 'string', 'max' => 255],
            [['unit_id'], 'exist', 'skipOnError' => true, 'targetClass' => Event::className(), 'targetAttribute' => ['unit_id' => 'unit_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'question_group_unit_id' => 'Question Group ID',
            'question_group_unit_name' => 'Question Group Name',
            'unit_id' => 'Unit ID',
        ];
    }

    /**
     * Gets query for [[Event]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEvent()
    {
        return $this->hasOne(Event::className(), ['unit_id' => 'unit_id']);
    }

    /**
     * Gets query for [[TblQuestions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTblQuestions()
    {
        return $this->hasMany(Question::className(), ['question_group_unit_id' => 'question_group_unit_id']);
    }

    /**
     * Gets query for [[TblRatings]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTblRatings()
    {
        return $this->hasMany(Rating::className(), ['question_group_unit_id' => 'question_group_unit_id']);
    }
}
