<?php

namespace backend\modules\admin\models;

use Yii;

/**
 * This is the model class for table "tbl_auth_access_region".
 *
 * @property int $auth_access_region_id
 * @property int $region_id
 * @property int $user_id
 */
class AuthAccessRegion extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_auth_access_region';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['region_id', 'user_id'], 'required'],
            [['region_id', 'user_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'auth_access_region_id' => 'Auth Access Region ID',
            'region_id' => 'Region ID',
            'user_id' => 'User ID',
        ];
    }
}
