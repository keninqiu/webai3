<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Product;
use app\models\Locale;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProductLocaleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Product Locales';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-locale-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Product Locale', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'attribute' => 'product_id',
                'value' => 'product.name',
                'filter' => Html::activeDropDownList($searchModel, 'product_id', [''=>'']+ArrayHelper::map(Product::find()->all(), 'id', 'name'), ['class' => 'form-control'])
            ],            
            [
                'attribute' => 'locale_id',
                'value' => 'locale.value',
                'filter' => Html::activeDropDownList($searchModel, 'locale_id', [''=>'']+ArrayHelper::map(Locale::find()->all(), 'id', 'value'), ['class' => 'form-control'])
            ],
            'name',
            'value',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
