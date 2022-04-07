<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tbl_services".
 *
 * @property int $services_id
 * @property string|null $services_name
 */
class Services extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_services';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['services_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'services_id' => 'Services ID',
            'services_name' => 'Services Name',
        ];
    }
}
