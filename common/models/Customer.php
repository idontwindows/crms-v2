<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tbl_customer".
 *
 * @property int $customer_id
 * @property string|null $customer_name
 * @property string|null $customer_email
 * @property string|null $date_created
 *
 * @property TblRating[] $tblRatings
 */
class Customer extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_customer';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date_created'], 'safe'],
            [['customer_name', 'customer_email'], 'required'],
            [['customer_name', 'customer_email'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'customer_id' => 'Customer ID',
            'customer_name' => 'Customer Name',
            'customer_email' => 'Customer Email',
            'date_created' => 'Date Created',
        ];
    }

    /**
     * Gets query for [[TblRatings]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTblRatings()
    {
        return $this->hasMany(Rating::className(), ['customer_id' => 'customer_id']);
    }
}
