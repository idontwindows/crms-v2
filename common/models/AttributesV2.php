<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tbl_attributes_v2".
 *
 * @property int $attribute_id
 * @property string|null $question
 * @property int|null $dimension_id
 * @property int|null $service_unit_id
 * @property int|null $region_id
 *
 * @property TblDimension $dimension
 * @property TblRegion $region
 * @property TblServiceUnit $serviceUnit
 */
class AttributesV2 extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_attributes_v2';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['dimension_id', 'service_unit_id', 'region_id'], 'integer'],
            [['question'], 'string', 'max' => 255],
            [['dimension_id'], 'exist', 'skipOnError' => true, 'targetClass' => Dimension::className(), 'targetAttribute' => ['dimension_id' => 'dimension_id']],
            [['service_unit_id'], 'exist', 'skipOnError' => true, 'targetClass' => ServiceUnit::className(), 'targetAttribute' => ['service_unit_id' => 'service_unit_id']],
            [['region_id'], 'exist', 'skipOnError' => true, 'targetClass' => Region::className(), 'targetAttribute' => ['region_id' => 'region_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'attribute_id' => 'Attribute ID',
            'question' => 'Question',
            'dimension_id' => 'Dimension ID',
            'service_unit_id' => 'Service Unit ID',
            'region_id' => 'Region ID',
        ];
    }

    /**
     * Gets query for [[Dimension]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDimension()
    {
        return $this->hasOne(Dimension::className(), ['dimension_id' => 'dimension_id']);
    }

    /**
     * Gets query for [[Region]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRegion()
    {
        return $this->hasOne(Region::className(), ['region_id' => 'region_id']);
    }

    /**
     * Gets query for [[ServiceUnit]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getServiceUnit()
    {
        return $this->hasOne(ServiceUnit::className(), ['service_unit_id' => 'service_unit_id']);
    }
}
