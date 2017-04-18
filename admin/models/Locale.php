<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "locale".
 *
 * @property integer $id
 * @property string $code
 * @property string $value
 */
class Locale extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'locale';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code', 'value'], 'required'],
            [['code'], 'string', 'max' => 10],
            [['value'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Code',
            'value' => 'Value',
        ];
    }
}
