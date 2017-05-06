<?php

namespace app\controllers;

use Yii;
use app\models\Product;
use app\models\ProductLocale;
use app\models\ProductSearch;
use app\models\CategoryProduct;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends Controller
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

    /**
     * Lists all Product models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Product model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function addLocale($product_id,$locale_id,$name,$value) {
        $productLocale = new ProductLocale();
        $productLocale["product_id"] = $product_id;
        $productLocale["locale_id"] = $locale_id;
        $productLocale["name"] = $name;
        $productLocale["value"] = $value;
        $productLocale->save();              
    }
    /*
    public function addLocales($model) {
        $name = $model->name;
        $description = $model->description;
        $spec = $model->spec;
        $this->addLocale($model->id,$name);
        $this->addLocale($model->id,$description);
        $this->addLocale($model->id,$spec);
    }
    */

/*
            [['locale_id'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['value'], 'string', 'max' => 1000],
*/    
    /**
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Product();

        $postData = Yii::$app->request->post();
        if ($model->load($postData)&&$model->save()) {
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
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Product model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $postData = Yii::$app->request->post();
        if ($model->load($postData)) {

            $productData = $postData["Product"];
            $name_en = $model->name;
            $description_en = $model->description;
            $spec_en = $model->spec;

            $model->name = "product_".$model->id."_name";
            $model->description = "product_".$model->id."_description";
            $model->spec = "product_".$model->id."_spec";
            $model->save();

            $name_zh = $productData["name_zh"];
            $description_zh = $productData["description_zh"];
            $spec_zh = $productData["spec_zh"];
            $category_id = $productData["category_id"];


            $locale = ProductLocale::find()->where(["product_id" => $id,"locale_id" => 1,"name" => ("product_".$id."_name")])->one();
            if($locale) {
                $locale["value"] = $name_en;
                $locale->save(false);                
            }

            $locale = ProductLocale::find()->where(["product_id" => $id,"locale_id" => 1,"name" => ("product_".$id."_description")])->one();
            if($locale) {
                $locale["value"] = $description_en;
                $locale->save(false);                
            }

            $locale = ProductLocale::find()->where(["product_id" => $id,"locale_id" => 1,"name" => ("product_".$id."_spec")])->one();
            if($locale) {
                $locale["value"] = $spec_en;
                $locale->save(false);                
            }


            $locale = ProductLocale::find()->where(["product_id" => $id,"locale_id" => 2,"name" => ("product_".$id."_name")])->one();
            if($locale) {
                $locale["value"] = $name_zh;
                $locale->save(false);                
            }

            $locale = ProductLocale::find()->where(["product_id" => $id,"locale_id" => 2,"name" => ("product_".$id."_description")])->one();
            if($locale) {
                $locale["value"] = $description_zh;
                $locale->save(false);                
            }

            $locale = ProductLocale::find()->where(["product_id" => $id,"locale_id" => 2,"name" => ("product_".$id."_spec")])->one();
            if($locale) {
                $locale["value"] = $spec_zh;
                $locale->save(false);                
            }

            $categoryProduct = CategoryProduct::find()->where(["product_id" => $id])->one();
            if($categoryProduct) {
                $categoryProduct["category_id"] = $category_id;
                $categoryProduct->save(false);
            }
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            $model->name = $model->nameEn;
            $model->description = $model->descriptionEn;
            $model->spec = $model->specEn;
            $model->name_zh = $model->nameZh;
            $model->description_zh = $model->descriptionZh;
            $model->spec_zh = $model->specZh;  
            $model->category_id = $model->categoryId;            
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Product model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        ProductLocale::deleteAll(["product_id" => $id]);
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
