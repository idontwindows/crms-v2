<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tbl_dimension".
 *
 * @property int $dimension_id
 * @property string $name
 * @property string|null $description
 * @property int|null $active
 *
 * @property TblAttributesV2[] $tblAttributesV2s
 */
class Dimension extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_dimension';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['description'], 'string'],
            [['active'], 'integer'],
            [['name'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'dimension_id' => 'Dimension ID',
            'name' => 'Name',
            'description' => 'Description',
            'active' => 'Active',
        ];
    }

    /**
     * Gets query for [[TblAttributesV2s]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTblAttributesV2s()
    {
        return $this->hasMany(AttributesV2::className(), ['dimension_id' => 'dimension_id']);
    }
}
