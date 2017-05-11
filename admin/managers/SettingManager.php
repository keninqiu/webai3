<?php

namespace app\managers;
use Yii;
use app\models\Setting;
use app\models\Category;
use app\models\Product;
use app\models\ProductLocale;
use app\models\Brand;
use app\models\Slide;
use app\models\SettingSearch;
class SettingManager {

    public function querySql($query) {
        $connection=Yii::$app->db; 
        $command=$connection->createCommand($query);
        $dataReader=$command->query(); // execute a query SQL   
        $rows = $dataReader->readAll();
        return $rows;
    }

    public function getKeyWords($id) {
        $keywords = "";
        $records = ProductLocale::find()->where(["product_id" => $id])->all();
        foreach($records as $record) {
            $keywords .= ($record["value"]." ");
        }
        return $keywords;
    }

	public function generateJson() {
        $data = [];
        echo "111";
        $records = Setting::find()->all();
        $setting = [];
        foreach($records as $record) {
            $name = $record["name"];
            $value = $record["value"];
            $setting[] = [
                "name" => $name,
                "value" => $value,
            ];
        }
        $data["setting"] = $setting;

        $records = Category::find()->orderBy(['sequence' => SORT_ASC])->all();
        $category = [];
        foreach($records as $record) {
            $id = $record["id"];
            $name = $record["name"];
            $category[] = [
                "id" => $id,
                "name" => $name,
            ];
        }
        $data["category"] = $category;    

        $sql = "select product.*,origin.name as origin,brand.name as brand from product,origin,brand where  product.origin_id=origin.id and product.brand_id=brand.id";
        $records = self::querySql($sql);
        $product = [];
        foreach($records as $record) {
            $id = $record["id"];
            $name = $record["name"];
            $description = $record["description"];
            $price = $record["price"];
            $brand_id = $record["brand_id"];

            $spec = $record["spec"];
            $origin = $record["origin"];
            $brand = $record["brand"];
            $path = "";

            $sql = "select path,type_id from product_image where product_id=$id order by type_id asc";
            $side_path = self::querySql($sql);
            foreach($side_path as $image) {
                if($image["type_id"] == 1) {
                    $path = $image["path"];
                }
            }

            $sql = "select category_id from category_product where product_id=$id";
            $categories = self::querySql($sql);
            $product[] = [
                "id" => $id,
                "name" => $name,
                "description" => $description,
                "price" => $price,
                "price_rmb" => $price*Setting::getCurrency(),
                "brand_id" => $brand_id,
                "spec" => $spec,
                "path" => $path,
                "side_path" => $side_path,
                "origin" => $origin,
                "brand" => $brand,
                "categories" => $categories,
                "keywords" => self::getKeyWords($id),
            ];

        }
        //$product = (array) $product;
        $data["product"] = $product;  

        $records = Brand::find()->all();
        $brand = [];
        foreach($records as $record) {
            $id = $record["id"];
            $name = $record["name"];
            $brand[] = [
                "id" => $id,
                "name" => $name,
            ];
        }
        $data["brand"] = $brand;   

        $records = Slide::find()->all();
        $slide = [];
        foreach($records as $record) {
            $id = $record["id"];
            $name = $record["name"];
            $path = $record["path"];
            $text = $record["text"];
            $link = $record["link"];
            $position_id = $record["position_id"];

            $slide[] = [
                "id" => $id,
                "name" => $name,
                "path" => $path,
                "text" => $text,
                "link" => $link,
                "position_id" => $position_id
            ];
        }
        $data["slide"] = $slide;  

        $full = json_encode($data);
        $path = __DIR__ . "/../../json/data.json";
        file_put_contents($path, $full);

        $locale = [];
        $sql = "select setting_locale.name,setting_locale.value,locale.code from setting_locale,locale where setting_locale.locale_id=locale.id";
        $records = self::querySql($sql);

        foreach($records as $record) {
            $name = $record["name"];
            $value = $record["value"];
            $code = $record["code"];
            $locale[$code][] = [$name => $value];
        }

        $sql = "select category_locale.name,category_locale.value,locale.code from category_locale,locale where category_locale.locale_id=locale.id";
        $records = self::querySql($sql);

        foreach($records as $record) {
            $name = $record["name"];
            $value = $record["value"];
            $code = $record["code"];
            $locale[$code][] = [$name => $value];
        }

        $sql = "select product_locale.name,product_locale.value,locale.code from product_locale,locale where product_locale.locale_id=locale.id";
        $records = self::querySql($sql);

        foreach($records as $record) {
            $name = $record["name"];
            $value = $record["value"];
            $code = $record["code"];
            $locale[$code][] = [$name => $value];
        }

        $sql = "select origin_locale.name,origin_locale.value,locale.code from origin_locale,locale where origin_locale.locale_id=locale.id";
        $records = self::querySql($sql);

        foreach($records as $record) {
            $name = $record["name"];
            $value = $record["value"];
            $code = $record["code"];
            $locale[$code][] = [$name => $value];
        }


        foreach($locale as $index => $value) {
            $full = "";
            foreach($value as $codeName => $codeValue) {
                $codeValue = json_encode($codeValue);
                $codeValue = trim($codeValue,"{");
                $codeValue = trim($codeValue,"}");
                $full .= $codeValue.",";
            }
            $full = trim($full,",");
            $full = "{".$full."}";
            //$full = json_encode($value);
            $path = __DIR__ . "/../../i18n/locale-$index.json";
            file_put_contents($path, $full);
            $pos = stripos($index,"en");
            if($pos === 0) {
                $path = __DIR__ . "/../../i18n/locale-en.json";
                file_put_contents($path, $full);                
            }
            $pos = stripos($index,"zh");
            if($pos === 0) {
                $path = __DIR__ . "/../../i18n/locale-zh.json";
                file_put_contents($path, $full);                
            }            
        }
        echo "finished";
	}
}