<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tbl_pstc".
 *
 * @property int $pstc_id
 * @property string|null $pstc_name
 * @property int|null $region_id
 */
class Pstc extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_pstc';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['region_id'], 'integer'],
            [['pstc_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'pstc_id' => 'Pstc ID',
            'pstc_name' => 'Pstc Name',
            'region_id' => 'Region ID',
        ];
    }
}
