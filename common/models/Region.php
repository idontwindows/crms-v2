<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tbl_region".
 *
 * @property int $region_id
 * @property string|null $region_code
 * @property string|null $region_name
 * @property string|null $short_name
 * @property int|null $order
 */
class Region extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_region';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['order'], 'integer'],
            [['region_code', 'region_name', 'short_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'region_id' => 'Region ID',
            'region_code' => 'Region Code',
            'region_name' => 'Region Name',
            'short_name' => 'Short Name',
            'order' => 'Order',
        ];
    }
}
