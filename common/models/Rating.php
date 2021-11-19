<?php

namespace common\models;

use Yii;


/**
 * This is the model class for table "tbl_rating".
 *
 * @property int $rating_id
 * @property int|null $customer_id
 * @property int|null $event_id
 * @property int|null $question_group_id
 * @property int|null $question_id
 * @property int|null $rating_point
 * @property float|null $rating_date
 *
 * @property TblCustomer $customer
 * @property TblEvent $event
 * @property TblQuestion $question
 * @property TblQuestionGroup $questionGroup
 */
class Rating extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_rating';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['customer_id', 'event_id', 'question_group_id', 'question_id', 'rating_point'], 'integer'],
            [['rating_date'], 'number'],
            [['customer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Customer::className(), 'targetAttribute' => ['customer_id' => 'customer_id']],
            [['event_id'], 'exist', 'skipOnError' => true, 'targetClass' => Event::className(), 'targetAttribute' => ['event_id' => 'event_id']],
            [['question_id'], 'exist', 'skipOnError' => true, 'targetClass' => Question::className(), 'targetAttribute' => ['question_id' => 'question_id']],
            [['question_group_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuestionGroup::className(), 'targetAttribute' => ['question_group_id' => 'question_group_id']],
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
            'event_id' => 'Event ID',
            'question_group_id' => 'Question Group ID',
            'question_id' => 'Question ID',
            'rating_point' => 'Rating Point',
            'rating_date' => 'Rating Date',
        ];
    }

    /**
     * Gets query for [[Customer]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(Customer::className(), ['customer_id' => 'customer_id']);
    }

    /**
     * Gets query for [[Event]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEvent()
    {
        return $this->hasOne(Event::className(), ['event_id' => 'event_id']);
    }

    /**
     * Gets query for [[Question]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getQuestion()
    {
        return $this->hasOne(Question::className(), ['question_id' => 'question_id']);
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
}
