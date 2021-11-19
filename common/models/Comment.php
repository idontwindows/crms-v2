<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tbl_comment".
 *
 * @property int $comment_id
 * @property int|null $customer_id
 * @property string|null $comment
 * @property string|null $other_important_attrib
 */
class Comment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_comment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['customer_id'], 'integer'],
            [['comment', 'other_important_attrib'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'comment_id' => 'Comment ID',
            'customer_id' => 'Customer ID',
            'comment' => 'Comment',
            'other_important_attrib' => 'Other Important Attrib',
        ];
    }
}
