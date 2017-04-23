<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "setting_locale".
 *
 * @property integer $id
 * @property integer $locale_id
 * @property string $name
 * @property string $value
 */
class SettingLocale extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'setting_locale';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['locale_id', 'name', 'value'], 'required'],
            [['locale_id'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['value'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'locale_id' => Yii::t('app', 'Locale ID'),
            'name' => Yii::t('app', 'Name'),
            'value' => Yii::t('app', 'Value'),
        ];
    }

    public function getLocale() {
        return $this->hasOne(Locale::className(), ['id' => 'locale_id']);
    }  
        
}
