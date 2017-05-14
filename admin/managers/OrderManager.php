<?php

namespace app\managers;
require_once(__DIR__ . '/../components/Logger.class.php');
use app\models\Product;
use app\models\ProductLocale;
use app\models\ProductSearch;
use app\models\CategoryProduct;
use app\models\OrderItem;
use app\models\Order;
use app\components\Logger;

class OrderManager {
	public function setStatus($id,$status) {
		$order = Order::findOne($id);
		$order["status"] = $status;
		$order->save();
	}
	public function getOrderDetail($id) {
        $order = Order::findOne($id);
        $orderDetail = OrderItem::find()->where(["order_id" => $id])->all();

        Logger::curllog("order count=".count($order));
        Logger::curllog("orderDetail count=".count($orderDetail));
        $orderData = [];


        $orderDetailData = [];
        $total_quantity = 0;
        $total_price = 0;
        foreach($orderDetail as $item) {
            
            $product_id = $item["product_id"];

            $product = Product::find()->where(["id" => $product_id])->one();
            $product_name = $product["name"];
            $price = $product["price"];
            
            $quantity = $item["quantity"];
            $total_quantity += $quantity ;
            $total_price += $quantity*$price;
            $orderDetailData[] = [
                "id" => $product_id,
                "name" => $product_name,
                "price" => $price,
                "quantity" => $quantity
            ];
        }

        if($order) {
            $orderData["id"] = $order["id"];
            $orderData["name"] = $order["name"];
            $orderData["status"] = $order["status"];
            $orderData["price"] = $total_price;
            $orderData["quantity"] = $total_quantity;
        }

        $return = [
            "order" => $orderData,
            "orderItem" => $orderDetailData
        ];	
        return $return;	
	}
}