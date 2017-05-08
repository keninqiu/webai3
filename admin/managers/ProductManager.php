<?php

namespace app\managers;
use app\models\Product;
use app\models\ProductLocale;
use app\models\ProductSearch;
use app\models\CategoryProduct;
use app\managers\ProductManager;
class ProductManager {

   function __construct($model) {
       $this->model = $model;
   }

    public function addLocale($product_id,$locale_id,$name,$value) {
        $productLocale = new ProductLocale();
        $productLocale["product_id"] = $product_id;
        $productLocale["locale_id"] = $locale_id;
        $productLocale["name"] = $name;
        $productLocale["value"] = $value;
        $productLocale->save();              
    }

	public function saveProduct($postData) {
		echo json_encode($postData);
        $model = $this->model;
        if ($model->load($postData)&&$model->save(false)) {
        	echo "load success";
            $productData = $postData["Product"];
            $name_en = $model->name;
            $description_en = $model->description;
            $spec_en = $model->spec;

            $name_zh = $productData["name_zh"];
            $description_zh = $productData["description_zh"];
            $spec_zh = $productData["spec_zh"];
            $category_id = $productData["category_id"];

            $model->name = "product_".$model->id."_name";
            $model->description = "product_".$model->id."_description";
            $model->spec = "product_".$model->id."_spec";
            $this->addLocale($model->id,1,$model->name,$name_en);
            $this->addLocale($model->id,2,$model->name,$name_zh);
            $this->addLocale($model->id,1,$model->description,$description_en);
            $this->addLocale($model->id,2,$model->description,$description_zh);
            $this->addLocale($model->id,1,$model->spec,$spec_en);
            $this->addLocale($model->id,2,$model->spec,$spec_zh);                        
            $model->save();

            $categoryProduct = new CategoryProduct();
            $categoryProduct["category_id"] = $category_id;
            $categoryProduct["product_id"] = $model->id;
            $categoryProduct->save();
        }	
        return $model["id"];	
	}
}