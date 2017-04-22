<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\ImageType;
use app\models\Product;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProductImageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Product Images';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-image-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Product Image', ['create'], ['class' => 'btn btn-success']) ?>
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
                'attribute' => 'type_id',
                'value' => 'type.name',
                'filter' => Html::activeDropDownList($searchModel, 'type_id', [''=>'']+ArrayHelper::map(ImageType::find()->all(), 'id', 'name'), ['class' => 'form-control'])
            ], 
            'path',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
