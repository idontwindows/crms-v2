<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tbl_unit".
 *
 * @property int $unit_id
 * @property int|null $region_id
 * @property string|null $unit_url
 * @property string|null $date_created
 */
class Unit extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_unit';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['region_id'], 'integer'],
            [['date_created'], 'safe'],
            [['unit_url'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'unit_id' => 'Unit ID',
            'region_id' => 'Region ID',
            'unit_url' => 'Unit Url',
            'date_created' => 'Date Created',
        ];
    }
}
