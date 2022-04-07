<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tbl_customer_v2".
 *
 * @property int $customer_id
 * @property string|null $customer_name
 * @property string|null $customer_email
 * @property int|null $client_type
 * @property string|null $gender
 * @property string|null $age_group
 * @property int|null $other_info
 * @property int|null $digital_literacy
 * @property int|null $pwd
 * @property int|null $pregnant
 * @property int|null $senior_citizen
 * @property string|null $date_created
 * @property string|null $signature
 */
class CustomerV2 extends \yii\db\ActiveRecord
{
    // public $verifyCaptcha;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_customer_v2';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['customer_id'], 'required'],
            [['customer_id', 'client_type', 'other_info', 'digital_literacy', 'pwd', 'pregnant', 'senior_citizen'], 'integer'],
            [['date_created'], 'safe'],
            [['signature'], 'string'],
            [['customer_name', 'customer_email'], 'string', 'max' => 255],
            [['gender', 'age_group'], 'string', 'max' => 20],
            [['customer_id'], 'unique'],
            // ['verifyCaptcha', 'captcha'],
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
            'client_type' => 'Client Type',
            'gender' => 'Gender',
            'age_group' => 'Age Group',
            'other_info' => 'Other Info',
            'digital_literacy' => 'Digital Literacy',
            'pwd' => 'Pwd',
            'pregnant' => 'Pregnant',
            'senior_citizen' => 'Senior Citizen',
            'date_created' => 'Date Created',
            'signature' => 'Signature',
            'verifyCaptcha' => 'Verification Code',
        ];
    }
}
