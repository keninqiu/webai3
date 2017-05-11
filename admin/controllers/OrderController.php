<?php

namespace app\controllers;

use Yii;
use app\models\Product;
use app\models\Order;
use app\models\OrderItem;
use app\models\OrderSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
/**
 * OrderController implements the CRUD actions for Order model.
 */
class OrderController extends Controller
{
    public function beforeAction($action) {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }    
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],            
        ];
    }

    public function actionDetail($id) {
        
        $order = $this->findModel($id);
        $orderDetail = OrderItem::find()->where(["order_id" => $id])->all();

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
                "name" => $product_name,
                "price" => $price,
                "quantity" => $quantity
            ];
        }

        if($order) {
            $orderData["id"] = $order["id"];
            $orderData["name"] = $order["name"];
            $orderData["price"] = $total_price;
            $orderData["quantity"] = $total_quantity;
        }

        $return = [
            "order" => $orderData,
            "orderItem" => $orderDetailData
        ];
        return json_encode($return);
    }

    public function actionConfirm() {
        $ret = "haha";
        $postData = Yii::$app->request->post();

        $productInfo = $postData["product"];
        $order = new Order();
        $order["name"] = "faesfa";
        $order["status"] = 0;
        $order->save();
        $order_id = $order["id"];
        $productInfoArray = explode(";", $productInfo);
        foreach($productInfoArray as $productInfoItem) {

            $idAndNumArray = explode(",", $productInfoItem);
            if(count($idAndNumArray) != 2) {
                continue;
            }
            $product_id = $idAndNumArray[0];
            $quantity = $idAndNumArray[1];
            $orderItem = new OrderItem();
            $orderItem["order_id"] = $order_id;
            $orderItem["product_id"] = $product_id;
            $orderItem["quantity"] = $quantity;
            $orderItem->save();
        }
        return "{\"order_id\":$order_id}";
    }

    /**
     * Lists all Order models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OrderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Order model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Order model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Order();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Order model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Order model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Order model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Order the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Order::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
