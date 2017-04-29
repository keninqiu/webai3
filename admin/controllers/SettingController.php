<?php

namespace app\controllers;

use Yii;
use app\models\Setting;
use app\models\Category;
use app\models\Product;
use app\models\Brand;
use app\models\Slide;
use app\models\SettingSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SettingController implements the CRUD actions for Setting model.
 */
class SettingController extends Controller
{
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

    public function querySql($query) {
        $connection=Yii::$app->db; 
        $command=$connection->createCommand($query);
        $dataReader=$command->query(); // execute a query SQL   
        $rows = $dataReader->readAll();
        return $rows;
    }

    /**
     * Lists all Setting models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SettingSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionJson() {
        $data = [];

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

        $records = Category::find()->all();
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

        $sql = "select product.*,product_image.path from product,product_image where product_image.product_id=product.id";
        $records = self::querySql($sql);
        $product = [];
        foreach($records as $record) {
            $id = $record["id"];
            $name = $record["name"];
            $description = $record["description"];
            $price = $record["price"];
            $brand_id = $record["brand_id"];
            $spec = $record["spec"];
            $path = $record["path"];

            $sql = "select path from product_image where type_id=2 and product_id=$id";
            $side_path = self::querySql($sql);

            $product[$id] = [
                "id" => $id,
                "name" => $name,
                "description" => $description,
                "price" => $price,
                "brand_id" => $brand_id,
                "spec" => $spec,
                "path" => $path,
                "side_path" => $side_path
            ];

        }
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
        }

        return "export data successfully!";
    }


    /**
     * Displays a single Setting model.
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
     * Creates a new Setting model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Setting();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Setting model.
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
     * Deletes an existing Setting model.
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
     * Finds the Setting model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Setting the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Setting::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
