<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tbl_hrdc".
 *
 * @property int $hrdc_id
 * @property string|null $hrdc_name
 * @property string|null $short_name
 * @property int|null $region_id
 */
class Hrdc extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_hrdc';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['region_id'], 'integer'],
            [['hrdc_name', 'short_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'hrdc_id' => 'Hrdc ID',
            'hrdc_name' => 'Hrdc Name',
            'short_name' => 'Short Name',
            'region_id' => 'Region ID',
        ];
    }
}
