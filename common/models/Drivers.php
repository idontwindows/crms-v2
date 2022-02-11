<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tbl_drivers".
 *
 * @property int $drivers_id
 * @property string|null $drivers_name
 * @property int|null $region_id
 */
class Drivers extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_drivers';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['region_id'], 'integer'],
            [['drivers_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'drivers_id' => 'Drivers ID',
            'drivers_name' => 'Drivers Name',
            'region_id' => 'Region ID',
        ];
    }
}
