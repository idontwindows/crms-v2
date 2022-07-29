<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tbl_tmp_importance".
 *
 * @property int $id
 * @property int|null $attribute_id
 * @property string|null $attribute
 * @property int|null $vimportant
 * @property int|null $5
 * @property int|null $important
 * @property int|null $4
 * @property int|null $moderately
 * @property int|null $3
 * @property int|null $slightly
 * @property int|null $2
 * @property int|null $notall
 * @property int|null $1
 * @property int|null $total_score
 * @property float|null $is
 * @property float|null $wf
 * @property float|null $ss
 * @property float|null $ws
 */
class TmpImportance extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_tmp_importance';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['attribute_id', 'vimportant', 'five', 'important', 'four', 'moderately', 'three', 'slightly', 'two', 'notall', 'one', 'total_score'], 'integer'],
            [['is', 'wf', 'ss', 'ws'], 'number'],
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
            'attribute_id' => 'Attribute ID',
            'attribute' => 'Importance of Service Quality Attribute',
            'vimportant' => 'Very Important',
            'five' => '5',
            'important' => 'Important',
            'four' => '4',
            'moderately' => 'Moderately Important',
            'three' => '3',
            'slightly' => 'Slightly Important',
            'two' => '2',
            'notall' => 'Not All Importnant',
            'one' => '1',
            'total_score' => 'Total Score',
            'is' => 'SS',
            'wf' => 'WF',
            'ss' => 'SS',
            'ws' => 'WS',
        ];
    }
}
