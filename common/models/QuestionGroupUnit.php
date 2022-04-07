<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tbl_question_group_unit".
 *
 * @property int $question_group_unit_id
 * @property string|null $question_group_unit_name
 * @property int|null $unit_id
 * @property int|null $importance
 */
class QuestionGroupUnit extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public $question;
    public $question_id;
    public $no_dimension;
    public $attribute_group_id;
    public static function tableName()
    {
        return 'tbl_question_group_unit';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['unit_id', 'importance'], 'integer'],
            [['question_group_unit_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'question_group_unit_id' => 'Question Group Unit ID',
            'question_group_unit_name' => 'Question Group Unit Name',
            'unit_id' => 'Unit ID',
            'importance' => 'Importance',
        ];
    }
    public function getAttributequestions(){
        return $this->hasMany(QuestionUnit::class,['question_group_unit_id' => 'question_group_unit_id']);
    }
}
