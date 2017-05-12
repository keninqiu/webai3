<?php

namespace app\models;

require_once(__DIR__ . '/../components/Logger.class.php');

use Yii;
use app\components\Logger;
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
    public $name_zh;
    public $description_zh;
    public $spec_zh;
    public $category_id;
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
            [['name'], 'string', 'max' => 500],
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

    public function getNameEn() {
        $locale = ProductLocale::find()->where(["product_id" => $this->id,"locale_id" => 1,"name" => ("product_".$this->id."_name")])->one();
        return $locale?$locale->value:"";
    }

    public function getDescriptionEn() {
        $locale = ProductLocale::find()->where(["product_id" => $this->id,"locale_id" => 1,"name" => "product_".$this->id."_description"])->one();
        return $locale?$locale->value:"";
    }

    public function getSpecEn() {
        $locale = ProductLocale::find()->where(["product_id" => $this->id,"locale_id" => 1,"name" => "product_".$this->id."_spec"])->one();
        return $locale?$locale->value:"";
    }

    public function getNameZh() {
        $locale = ProductLocale::find()->where(["product_id" => $this->id,"locale_id" => 2,"name" => "product_".$this->id."_name"])->one();
        return $locale?$locale->value:"";
    }

    public function getDescriptionZh() {
        $locale = ProductLocale::find()->where(["product_id" => $this->id,"locale_id" => 2,"name" => "product_".$this->id."_description"])->one();
        return $locale?$locale->value:"";
    }

    public function getSpecZh() {
        $locale = ProductLocale::find()->where(["product_id" => $this->id,"locale_id" => 2,"name" => "product_".$this->id."_spec"])->one();
        return $locale?$locale->value:"";
    }
    
    public function getCategoryId() {
        $categoryProduct = CategoryProduct::find()->where(["product_id" => $this->id])->one();
        return $categoryProduct?$categoryProduct->category_id:"";
    }
    
    public function getBrand() {
        return $this->hasOne(Brand::className(), ['id' => 'brand_id']);
    }
    public function getOrigin() {
        return $this->hasOne(Origin::className(), ['id' => 'origin_id']);
    }   
    public function getCategory() {
        Logger::log("id==".$this->id);
        $categoryProduct = CategoryProduct::find()->where(["product_id" => $this->id])->one();
        Logger::log("category_id==".$categoryProduct["category_id"]);

        if($categoryProduct ) {
            $category_id = $categoryProduct["category_id"];
            if($category_id) {
                Logger::log("111");
                $category = Category::find()->where(["id" => $category_id])->one();
                return $category;
            }
            
        }
        return null;
    }    

}
