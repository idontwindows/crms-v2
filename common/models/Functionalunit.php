<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tbl_functional_unit".
 *
 * @property int $functional_unit_id
 * @property int|null $services_id
 * @property string|null $functional_unit_name
 * @property int|null $region_id
 * @property string|null $url
 * @property string|null $date_created
 * @property int|null $is_disabled
 * @property int|null $pstc_id
 * @property int|null $hrdc_id
 */
class Functionalunit extends \yii\db\ActiveRecord
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
            [['services_id', 'region_id', 'is_disabled', 'pstc_id', 'hrdc_id'], 'integer'],
            [['date_created'], 'safe'],
            [['unit_name', 'unit_url'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'unit_id' => 'Functional Unit ID',
            'services_id' => 'Services ID',
            'unit_name' => 'Functional Unit Name',
            'region_id' => 'Region ID',
            'unit_url' => 'Url',
            'date_created' => 'Date Created',
            'is_disabled' => 'Is Disabled',
            'pstc_id' => 'Pstc ID',
            'hrdc_id' => 'Hrdc ID',
        ];
    }
    public function getServices(){
        return $this->hasOne(Services::class,['services_id' => 'services_id']);
    }
    public function getAttributegroup(){
        return $this->hasOne(QuestionGroupUnit::class,['unit_id' => 'unit_id',]);
    }
}
