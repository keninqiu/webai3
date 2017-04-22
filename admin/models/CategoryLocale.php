<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "category_locale".
 *
 * @property integer $id
 * @property integer $locale_id
 * @property string $name
 * @property string $value
 */
class CategoryLocale extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'category_locale';
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
            'id' => 'ID',
            'locale_id' => 'Locale ID',
            'name' => 'Name',
            'value' => 'Value',
        ];
    }

    public function getLocale() {
        return $this->hasOne(Locale::className(), ['id' => 'locale_id']);
    }    
}
