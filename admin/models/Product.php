<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "product".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $price
 * @property integer $brand_id 
 * @property integer $origin_id 
 * @property string $spec 
 * @property string $source 
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'price'], 'required'],
            [['price'], 'number'],
            [['name'], 'string', 'max' => 50],
            [['description','spec','source'], 'string'],
            [['brand_id','origin_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'description' => 'Description',
            'price' => 'Price',
            'brand_id' => 'Brand ID',
            'origin_id' => 'Origin ID',
            'spec' => 'Spec',
            'source' => 'Source',
        ];
    }

    public function getBrand() {
        return $this->hasOne(Brand::className(), ['id' => 'brand_id']);
    }
    public function getOrigin() {
        return $this->hasOne(Origin::className(), ['id' => 'origin_id']);
    }    
}
