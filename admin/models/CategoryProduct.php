<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "category_product".
 *
 * @property integer $id
 * @property integer $category_id
 * @property integer $product_id
 */
class CategoryProduct extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'category_product';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'product_id'], 'required'],
            [['category_id', 'product_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Category ID',
            'product_id' => 'Product ID',
        ];
    }

    public function getCategory() {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }   
    public function getProduct() {
        return $this->hasOne(Category::className(), ['id' => 'product_id']);
    }       
}
