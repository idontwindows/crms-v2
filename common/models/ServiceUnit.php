<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tbl_service_unit".
 *
 * @property int $service_unit_id
 * @property int|null $services_id
 * @property string|null $service_unit_name
 * @property int|null $is_child
 * @property int|null $parent_id
 * @property int|null $is_with_pstc
 *
 * @property TblServices $services
 */
class ServiceUnit extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_service_unit';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['services_id', 'is_child', 'parent_id', 'is_with_pstc'], 'integer'],
            [['service_unit_name'], 'string', 'max' => 255],
            [['services_id'], 'exist', 'skipOnError' => true, 'targetClass' => Services::className(), 'targetAttribute' => ['services_id' => 'services_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'service_unit_id' => 'Service Unit ID',
            'services_id' => 'Services ID',
            'service_unit_name' => 'Service Unit Name',
            'is_child' => 'Is Child',
            'parent_id' => 'Parent ID',
            'is_with_pstc' => 'Is With Pstc',
        ];
    }

    /**
     * Gets query for [[Services]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getServices()
    {
        return $this->hasOne(Services::className(), ['services_id' => 'services_id']);
    }
}
