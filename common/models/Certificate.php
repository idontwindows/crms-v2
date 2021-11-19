<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tbl_certificate".
 *
 * @property int $certificate_id
 * @property string|null $certificate_name
 */
class Certificate extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_certificate';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['certificate_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'certificate_id' => 'Certificate ID',
            'certificate_name' => 'Certificate Name',
        ];
    }
}
