<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tbl_event".
 *
 * @property int $event_id
 * @property string|null $event_name
 * @property string|null $event_date
 *
 * @property TblQuestionGroup[] $tblQuestionGroups
 * @property TblRating[] $tblRatings
 */
class Event extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_event';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['event_date'], 'safe'],
            [['event_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'event_id' => 'Event ID',
            'event_name' => 'Event Name',
            'event_date' => 'Event Date',
        ];
    }

    /**
     * Gets query for [[TblQuestionGroups]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTblQuestionGroups()
    {
        return $this->hasMany(QuestionGroup::className(), ['event_id' => 'event_id']);
    }

    /**
     * Gets query for [[TblRatings]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTblRatings()
    {
        return $this->hasMany(Rating::className(), ['event_id' => 'event_id']);
    }
}
