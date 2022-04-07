<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tbl_attribute_group".
 *
 * @property int $attribute_group_id
 * @property string|null $attribute_group_name
 * @property int|null $functional_unit_id
 * @property int|null $importance
 */
class AttributeGroup extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_attribute_group';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['functional_unit_id', 'importance'], 'integer'],
            [['attribute_group_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'attribute_group_id' => 'Attribute Group ID',
            'attribute_group_name' => 'Attribute Group Name',
            'functional_unit_id' => 'Functional Unit ID',
            'importance' => 'Importance',
        ];
    }
}
