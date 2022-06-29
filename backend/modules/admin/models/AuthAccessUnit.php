<?php

namespace backend\modules\admin\models;

use Yii;

/**
 * This is the model class for table "tbl_auth_access_unit".
 *
 * @property int $auth_access_unit_id
 * @property int $service_unit_id
 * @property int $user_id
 */
class AuthAccessUnit extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_auth_access_unit';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['service_unit_id', 'user_id'], 'required'],
            [['service_unit_id', 'user_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'auth_access_unit_id' => 'Auth Access Unit ID',
            'service_unit_id' => 'Service Unit ID',
            'user_id' => 'User ID',
        ];
    }
}
