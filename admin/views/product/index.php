<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Brand;
use app\models\Origin;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Products';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Product', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'nameZh',
            [
                'attribute' => 'brand_id',
                'value' => 'brand.name',
                'filter' => Html::activeDropDownList($searchModel, 'brand_id', [''=>'']+ArrayHelper::map(Brand::find()->all(), 'id', 'name'), ['class' => 'form-control'])
            ],
            [
                'attribute' => 'origin_id',
                'value' => 'origin.name',
                'filter' => Html::activeDropDownList($searchModel, 'brand_id', [''=>'']+ArrayHelper::map(Origin::find()->all(), 'id', 'name'), ['class' => 'form-control'])
            ],   
            'category.name',    
            'price',
            'specEn',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
