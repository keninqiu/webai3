<?php

namespace app\controllers;
require_once(__DIR__ . '/../components/Logger.class.php');
require_once(__DIR__ . '/../components/StripeApi.class.php');
//require_once(__DIR__ . '/../managers/StripeApi.class.php');
use Yii;
use app\models\Product;
use app\models\Order;
use app\models\OrderItem;
use app\models\OrderSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\components\Logger;
use app\components\StripeApi;
use app\managers\OrderManager;
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
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        //'actions' => ['login', 'error'], // Define specific actions
                        'allow' => true, // Has access
                        'roles' => ['@'], // '@' All logged in users / or your access role e.g. 'admin', 'user'
                    ],
                    [
                        'allow' => false, // Do not have access
                        'roles'=>['?'], // Guests '?'
                    ],
                ],
            ],                     
        ];
    }

    public function actionDetail($id) {
        $orderManager = new OrderManager();
        $return = $orderManager->getOrderDetail($id);
        return json_encode($return);
    }

    public function actionPay() {
        $postData = Yii::$app->request->post();

        $number = $postData["number"];
        $exp_year = $postData["exp_year"];
        $exp_month = $postData["exp_month"];
        $cvc = $postData["cvc"];
        $order_id = $postData["order_id"];
        $currency = $postData["currency"];

        $state = -1;
        $orderManager = new OrderManager();
        $return = $orderManager->getOrderDetail($order_id);  
        Logger::curllog("return in actionPay for orderDetail=".json_encode($return)); 
        if(!isset($return["order"]) || !isset($return["order"]["price"]) || !isset($return["order"]["status"])) {
            $response = [
                "state" => $state,
                "msg" => "cannot get the total price or status of your order!"
            ];
            return json_encode($response);
        }   
        if($return["order"]["status"] == 1) {
            $response = [
                "state" => $state,
                "msg" => "your order have already been paid!"
            ];
            return json_encode($response);            
        } 
        $amount = $return["order"]["price"]*100;
        $stripeApi = new StripeApi();
        $createTokenResponse = $stripeApi->createToken($number,$exp_month,$exp_year,$cvc);

        $state = -1;
        $msg = "unknown error";

        $response = [
            "state" => $state,
            "msg" => $msg
        ];

        if($createTokenResponse) {
            
            $state = $createTokenResponse["state"];
            if($state == -1) {
                $response = $createTokenResponse;
            }
            else {
                $source = $createTokenResponse["token"];
                if($source) {
                    $description = "pay in webai";
                    $createChargeResponse = $stripeApi->createCharge($amount,$currency,$source,$description);
                    if($createChargeResponse) {
                        $response = $createChargeResponse;
                    }                  
                }                
            }

         
        }

        if($response && $response["state"] == 0) {
            $orderManager->setStatus($order_id,1);
        }
        else {
            $orderManager->setStatus($order_id,-1);
        }

        return json_encode($response);

    }

    public function actionConfirm() {
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
