<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tbl_message".
 *
 * @property int $message_id
 * @property string|null $message
 * @property string|null $date
 */
class Message extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_message';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['message'], 'string'],
            [['date'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'message_id' => 'Message ID',
            'message' => 'Message',
            'date' => 'Date',
        ];
    }
}
