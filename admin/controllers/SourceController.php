<?php

namespace app\controllers;

require_once(__DIR__ . '/../lib/simple_html_dom.php');
require_once(__DIR__ . '/../components/CurlUtil.class.php');
require_once(__DIR__ . '/../components/Logger.class.php');
use Yii;
use app\models\Source;
use app\models\SourceSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\components\CurlUtil;
use app\components\Logger;
/**
 * SourceController implements the CRUD actions for Source model.
 */
class SourceController extends Controller
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

    public function getProductFromCostco($source) {
        $url = "curl '".$source."' -H 'Accept-Encoding: gzip, deflate, sdch, br' -H 'Accept-Language: en-US,en;q=0.8,zh-CN;q=0.6,zh;q=0.4' -H 'Upgrade-Insecure-Requests: 1' -H 'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/57.0.2987.133 Safari/537.36' -H 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8' -H 'Cache-Control: max-age=0' -H 'Cookie: AMCVS_97B21CFE5329614E0A490D45%40AdobeOrg=1; AMCV_97B21CFE5329614E0A490D45%40AdobeOrg=-1330315163%7CMCIDTS%7C17293%7CMCMID%7C33418360481032625714012746240126029856%7CMCAAMLH-1494713041%7C7%7CMCAAMB-1494713041%7CcIBAx_aQzFEHcPoEv0GwcQ%7CMCOPTOUT-1494115441s%7CNONE%7CMCAID%7CNONE; mbox=session#0ced82daa4634e79a0cd3a7698659292#1494110103|PC#0ced82daa4634e79a0cd3a7698659292.17_59#1557353043; ak_bmsc=7EAC08C94E3EE4BC3070AA071E12AD55D194C042304F000053470E59177BAA23~plpDcXX3lUhh1mHp02TvurF/i9sFdG4UIIipBXGxz3qDR9GGFSwyjx/44jk+q0E0L/LRjeP6uUFA2gDRVUeaFXxsAQFQAsML4790XdWFDL2hSliPPi3FKMx10F9nAA66mhk37HreHawOoH6z1c43AfOcAxJmf1yeFbVBrmvOCJpCZYtnJftI8HMIGdUlCWh3lotb39lzUUotMWNcqAaCzzZg==; s_cc=true; __CT_Data=gpv=1&apv_81_www33=1&cpv_81_www33=1; WRIgnore=true; WRUID20170327=0; spid=9B2D7865-4020-4FFA-80B4-CF32322F6F17; sp_ssid=1494108249163; BVImplmain_site=20040; BVBRANDID=8f7cf078-e8aa-42de-9358-4d252d110226; BVBRANDSID=fe1eea93-4aeb-48ea-8f0b-2306bedd6738; s_sq=cwcostcocaprod%3D%2526c.%2526a.%2526activitymap.%2526page%253Dhttps%25253A%25252F%25252Fwww.costco.ca%25252FKirkland-Signature-Krill-Oil-500mg----120-Softgels-.product.100284782.html%2526link%253DSet%252520Language%252520and%252520Region%2526region%253DcostcoModalText%2526.activitymap%2526.a%2526.c; C_LOC=CAAB' -H 'Connection: keep-alive' --compressed";
        $response = CurlUtil::raw($url);

        $html = str_get_html($response);

        $name = "";
        $nameTag = $html->find('h1[itemprop="name"]',0);
        if($nameTag) {
            $name = $nameTag->text();
        }
        $price = 0;
        $yourPriceTag = $html->find('span[class="op-value"]',0);

        if($yourPriceTag) {

            $pricebase64 = $yourPriceTag->text();
            $price = base64_decode($pricebase64);
        }

        $description = "";
        $descriptionTag = $html->find('p[class="primary-clause"]',0);
        if($descriptionTag) {
            $description = $descriptionTag->text();
        }

        $image = "";
        $imageTag = $html->find('img[id="initialProductImage"]',0);
        if($imageTag) {
            $image = $imageTag->src;
        }

        return [
            "name" => $name,
            "description" => $description,
            "price" => $price,
            "image" => $image
        ];
    }

    public function handle($productInfo) {

    }
    public function actionGenerate() {
        $records = Source::find()->all();
        foreach($records as $record) {
            $source = $record["url"];
            $productInfo = self::getProductFromCostco($source);
            self::handle($productInfo);
        }
    }

    /**
     * Lists all Source models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SourceSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Source model.
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
     * Creates a new Source model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Source();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Source model.
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
     * Deletes an existing Source model.
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
     * Finds the Source model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Source the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Source::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
