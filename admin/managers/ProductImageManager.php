<?php

namespace app\managers;
use app\models\Product;
use app\models\ProductImage;
use app\models\ProductLocale;
use app\models\ProductSearch;
use app\models\CategoryProduct;
use app\managers\ProductManager;
use Yii;
class ProductImageManager {

   function __construct($productId) {
       $this->product_id = $productId;
   }
   public function saveImage($url) {
        $imageDir = '/uploads/' . $this->product_id;
        $imageAbsDir = Yii::getAlias('@app') . $imageDir;
        if(!file_exists($imageAbsDir)) {
            mkdir($imageAbsDir);
        }

        file_put_contents($imageAbsDir."/main.jpg", file_get_contents($url));
        $path = "/admin".$imageDir."/main.jpg";
        $productImage = new ProductImage();
        $productImage["product_id"] = $this->product_id;
        $productImage["type_id"] = 1;
        $productImage["path"] = $path;
        $productImage->save(false);
        /*
        $image = $imageDir . '/' . $this->imageFile->baseName . '.' . $this->imageFile->extension;
        $this->path = '/admin'.$image; 
        */      
   }
}