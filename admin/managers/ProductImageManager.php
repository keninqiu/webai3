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
   public function saveImage($url,$crop_type) {
        $imageDir = '/uploads/' . $this->product_id;
        $imageAbsDir = Yii::getAlias('@app') . $imageDir;
        if(!file_exists($imageAbsDir)) {
            mkdir($imageAbsDir);
        }

        file_put_contents($imageAbsDir."/main.jpg", file_get_contents($url));

        $im = imagecreatefromjpeg($imageAbsDir."/main.jpg");
        $sizex = imagesx($im);
        $sizey = imagesy($im);
        if($sizex == $sizey) {

        }
        else {
          $size = min($sizex, $sizey);
          $sizeDiff = ($sizex == $size)?($sizey-$size):($sizex-$size);
          $im2 = FALSE;
          if($crop_type == "bottom") {
            if($sizex > $sizey) {
                $im2 = imagecrop($im, ['x' => $sizeDiff, 'y' => 0, 'width' => $size, 'height' => $size]);
            }
            else {
                $im2 = imagecrop($im, ['x' => 0, 'y' => $sizeDiff, 'width' => $size, 'height' => $size]);
            }
            
          }
          else if($crop_type == "middle") {
            if($sizex > $sizey) {
                $im2 = imagecrop($im, ['x' => $sizeDiff/2, 'y' => 0, 'width' => $size, 'height' => $size]);
            }
            else {
                $im2 = imagecrop($im, ['x' => 0, 'y' => $sizeDiff/2, 'width' => $size, 'height' => $size]);
            }            
          }
          else {
            $im2 = imagecrop($im, ['x' => 0, 'y' => 0, 'width' => $size, 'height' => $size]);
          }
          
          if ($im2 !== FALSE) {
              imagejpeg($im2, $imageAbsDir."/main.jpg");
          }          
        }


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