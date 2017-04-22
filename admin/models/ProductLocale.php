<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "product_locale".
 *
 * @property integer $id
 * @property integer $product_id
 * @property integer $locale_id
 * @property string $name
 * @property string $value
 */
class ProductLocale extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_locale';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['locale_id', 'name', 'value'], 'required'],
            [['product_id','locale_id'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['value'], 'string', 'max' => 1000],
        ];
    }

    public function getLocale() {
        return $this->hasOne(Locale::className(), ['id' => 'locale_id']);
    }

    public function getProduct() {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Product ID',
            'locale_id' => 'Locale ID',
            'name' => 'Name',
            'value' => 'Value',
        ];
    }
}
