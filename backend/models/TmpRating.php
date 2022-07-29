<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tbl_tmp_rating".
 *
 * @property int $id
 * @property string|null $attribute
 * @property int|null $vsatisfied
 * @property int|null $5
 * @property int|null $satisfied
 * @property int|null $4
 * @property int|null $neither
 * @property int|null $3
 * @property int|null $dissatisfied
 * @property int|null $2
 * @property int|null $vdissatisfied
 * @property int|null $1
 * @property int|null $total_score
 * @property float|null $ss
 * @property float|null $gap
 */
class TmpRating extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_tmp_rating';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['vsatisfied', 'five', 'satisfied', 'four', 'neither', 'three', 'dissatisfied', 'two', 'vdissatisfied', 'one', 'total_score'], 'integer'],
            [['ss', 'gap'], 'number'],
            [['attribute'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'attribute' => 'Service Quality Attributes',
            'vsatisfied' => 'Very Satisfied',
            'five' => '5',
            'satisfied' => 'Satisfied',
            'four' => '4',
            'neither' => 'Neither Satified nor Dissatisfied',
            'three' => '3',
            'dissatisfied' => 'Dissatisfied',
            'two' => '2',
            'vdissatisfied' => 'Very Dissatisfied',
            'one' => '1',
            'total_score' => 'Total Score',
            'ss' => 'SS',
            'gap' => 'GAP',
        ];
    }
}
